<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/chatbot_error.log');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// GEMINI API - MIỄN PHÍ!
// Lấy API key tại: https://makersuite.google.com/app/apikey
define('GEMINI_API_KEY', 'AIzaSyAyNxrZQLgfD9KoWxMbdnxEnKl18NQKVTw'); // Thay bằng key của bạn
define('USE_AI', !empty(GEMINI_API_KEY));

try {
    @include 'connect.php';
    
    if (!$conn) {
        throw new Exception('Database connection failed');
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $userMessage = $input['message'] ?? '';
    $history = $input['history'] ?? [];

    if (empty($userMessage)) {
        echo json_encode(['success' => false, 'error' => 'No message provided']);
        exit;
    }

    $productContext = getProductContext($conn);

    // Dùng Gemini AI
    if (USE_AI) {
        $aiResponse = getChatGeminiResponse($userMessage, $history, $productContext); // ← Đổi từ getChatOpenRouterResponse
    } else {
        $aiResponse = getSmartAIResponse($userMessage, $history, $productContext, $conn);
    }

    $products = [];
if (shouldShowProducts($userMessage) && $conn) { // Thêm check $conn
    $intent = analyzeIntent($userMessage);
    $products = getProductRecommendations($intent, $userMessage, $conn);
}

    echo json_encode([
        'success' => true,
        'response' => $aiResponse,
        'products' => $products
    ]);

} catch (Exception $e) {
    error_log("Chatbot Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

// Check if should show products
function shouldShowProducts($message) {
    $message = mb_strtolower($message, 'UTF-8');
    
    $keywords = [
        'gợi ý', 'tư vấn', 'recommend', 'nên mua', 'mua gì',
        'laptop', 'màn hình', 'monitor', 'screen', 'bàn phím', 'keyboard',
        'chuột', 'mouse', 'tai nghe', 'headphone', 'loa', 'speaker',
        'sản phẩm', 'product', 'có gì', 'bán gì', 'cho xem',
        'giá rẻ', 'gaming', 'game', 'cho tôi xem', 'show'
    ];
    
    foreach ($keywords as $keyword) {
        if (strpos($message, $keyword) !== false) {
            return true;
        }
    }
    
    return false;
}

// OpenRouter AI Integration
function getChatOpenRouterResponse($userMessage, $history, $productContext) {
    $messages = [];
    
    $messages[] = [
        'role' => 'system',
        'content' => "Bạn là trợ lý AI thông minh của Electro - cửa hàng điện tử Đà Nẵng.

THÔNG TIN:
- Hotline: 0364200565
- Email: electro@gmail.com
- Địa chỉ: Đà Nẵng
- Giờ mở cửa: 8:00-22:00 (Hàng ngày)
- Đổi trả: 30 ngày
- Ship: Toàn quốc 2-5 ngày, free từ 500k
- Thanh toán: COD, ATM, Visa/MasterCard

SẢN PHẨM:
$productContext

CÁCH TRẢ LỜI:
✅ Tự nhiên, thân thiện như người thật
✅ Hài hước khi phù hợp
✅ Ngắn gọn 2-3 câu (trừ khi cần giải thích chi tiết)
✅ Dùng emoji vừa phải (1-2/câu)
✅ Hỏi lại nếu cần thêm thông tin
✅ Tư vấn dựa trên nhu cầu: gaming, văn phòng, giá rẻ...

❌ Không cứng nhắc như robot
❌ Không liệt kê nhiều mục
❌ Không tự đề xuất sản phẩm nếu khách chưa hỏi
❌ Không dài dòng, lan man

Trả lời như một người bán hàng thật sự hiểu khách!"
    ];
    
    $recentHistory = array_slice($history, -5);
    foreach ($recentHistory as $msg) {
        $messages[] = [
            'role' => $msg['role'],
            'content' => $msg['content']
        ];
    }
    
    $messages[] = [
        'role' => 'user',
        'content' => $userMessage
    ];
    
    $data = [
        'model' => 'openai/gpt-3.5-turbo',
        'messages' => $messages,
        'temperature' => 0.8,
        'max_tokens' => 400,
        'top_p' => 0.95
    ];
    
    $url = 'https://openrouter.ai/api/v1/chat/completions';
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . OPENROUTER_API_KEY,
        'HTTP-Referer: http://localhost',
        'X-Title: Electro Chatbot'
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    error_log("OpenRouter API Response Code: $httpCode");
    if ($curlError) {
        error_log("CURL Error: $curlError");
    }
    
    if ($httpCode !== 200 || !empty($curlError)) {
        if (!empty($response)) {
            error_log("OpenRouter API Error: $response");
        }
        return getSmartAIResponse($userMessage, [], '', null);
    }
    
    $result = json_decode($response, true);
    
    if (isset($result['choices'][0]['message']['content'])) {
        return $result['choices'][0]['message']['content'];
    }
    
    error_log("No content in OpenRouter response, using fallback");
    return getSmartAIResponse($userMessage, [], '', null);
}

// SMART AI RESPONSE - Backup
function getSmartAIResponse($message, $history, $productContext, $conn) {
    $message = mb_strtolower($message, 'UTF-8');
    $intent = detectDetailedIntent($message);
    
    switch ($intent['type']) {
        case 'greeting': return getGreetingResponse($intent);
        case 'farewell': return getFarewellResponse();
        case 'time_store': return getStoreTimeResponse($intent);
        case 'location': return getLocationResponse($intent);
        case 'contact': return getContactResponse($intent);
        case 'return_policy': return getReturnPolicyResponse($intent);
        case 'shipping': return getShippingResponse($intent);
        case 'payment': return getPaymentResponse($intent);
        case 'product_advice': return getProductAdviceResponse($message, $intent, $conn);
        case 'product_specific': return getSpecificProductResponse($message, $intent, $conn);
        case 'price_inquiry': return getPriceInquiryResponse($message, $intent, $conn);
        case 'thanks': return getThanksResponse();
        case 'complaint': return getComplaintResponse($intent);
        case 'general_question': return getGeneralResponse($message, $intent);
        default: return getDefaultResponse($message);
    }
}

function detectDetailedIntent($message) {
    $intent = ['type' => 'general_question', 'details' => []];
    
    if (preg_match('/\b(xin chào|chào|hello|hi|hey)\b/iu', $message)) {
        $intent['type'] = 'greeting';
        $intent['time'] = date('H') < 12 ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening');
    }
    elseif (preg_match('/\b(tạm biệt|bye|goodbye)\b/iu', $message)) $intent['type'] = 'farewell';
    elseif (preg_match('/(giờ|mở cửa|thời gian|mấy giờ)/iu', $message)) $intent['type'] = 'time_store';
    elseif (preg_match('/(địa chỉ|ở đâu|chỗ nào)/iu', $message)) $intent['type'] = 'location';
    elseif (preg_match('/(hotline|liên hệ|số điện thoại|zalo|email)/iu', $message)) $intent['type'] = 'contact';
    elseif (preg_match('/(đổi trả|hoàn tiền|bảo hành|warranty)/iu', $message)) $intent['type'] = 'return_policy';
    elseif (preg_match('/(giao hàng|ship|vận chuyển|delivery)/iu', $message)) $intent['type'] = 'shipping';
    elseif (preg_match('/(thanh toán|payment|trả tiền|cod)/iu', $message)) $intent['type'] = 'payment';
    elseif (preg_match('/\b(cảm ơn|thank|thanks)\b/iu', $message)) $intent['type'] = 'thanks';
    elseif (preg_match('/(tư vấn|gợi ý|recommend|nên mua|mua gì)/iu', $message)) $intent['type'] = 'product_advice';
    elseif (preg_match('/(laptop|màn hình|chuột|bàn phím|tai nghe|loa)/iu', $message)) $intent['type'] = 'product_specific';
    elseif (preg_match('/(giá|bao nhiêu|price|cost)/iu', $message)) $intent['type'] = 'price_inquiry';
    
    return $intent;
}

function getGreetingResponse($intent) {
    $greetings = [
        'morning' => ["Chào buổi sáng! ☀️ Hôm nay bạn muốn tìm kiếm gì ở Electro?", "Chào bạn! Sáng tốt lành! Tôi có thể tư vấn gì cho bạn? 😊"],
        'afternoon' => ["Chào buổi chiều! 🌤️ Bạn cần tư vấn sản phẩm gì không?", "Xin chào! Có gì tôi có thể giúp bạn hôm nay? 😊"],
        'evening' => ["Chào buổi tối! 🌙 Bạn muốn xem sản phẩm gì ạ?", "Xin chào! Tối nay tôi có thể tư vấn gì không? 😊"]
    ];
    return $greetings[$intent['time']][array_rand($greetings[$intent['time']])];
}

function getFarewellResponse() {
    return "Tạm biệt! Hẹn gặp lại bạn sớm! 👋 Gọi 0364200565 nếu cần tư vấn!";
}

function getStoreTimeResponse($intent) {
    return "Electro mở cửa 8:00 - 22:00 hàng ngày! 🕐 Kể cả cuối tuần và lễ đều mở bình thường.";
}

function getLocationResponse($intent) {
    return "Electro tại Đà Nẵng! 📍 Gọi 0364200565 để mình chỉ đường chi tiết nhé!";
}

function getContactResponse($intent) {
    return "📞 Liên hệ Electro:\n\n• Hotline: 0364200565\n• Zalo: 0364200565\n• Email: electro@gmail.com\n\nNhắn tin hoặc gọi bất cứ lúc nào! 😊";
}

function getReturnPolicyResponse($intent) {
    return "Đổi trả trong 30 ngày nếu còn nguyên tem! 📦 Bảo hành theo hãng. Mua sắm yên tâm nhé!";
}

function getShippingResponse($intent) {
    return "Ship toàn quốc 2-5 ngày, free từ 500k! 🚚 COD được luôn nhé!";
}

function getPaymentResponse($intent) {
    return "💳 Thanh toán:\n• Tiền mặt\n• ATM/Internet Banking\n• Visa/MasterCard\n• COD\n\nBạn chọn cách nào tiện nhé! 😊";
}

function getThanksResponse() {
    return "Không có gì! Vui lòng được hỗ trợ bạn! 😊 Cần gì cứ hỏi nha!";
}

function getComplaintResponse($intent) {
    return "Mình xin lỗi! 😔 Vui lòng gọi 0364200565 để được hỗ trợ tốt hơn nhé!";
}

function getProductAdviceResponse($message, $intent, $conn) {
    return "Để tư vấn chính xác:\n\n🎯 Dùng để: Gaming/Văn phòng/Đồ họa?\n💰 Ngân sách: Khoảng bao nhiêu?\n\nGọi 0364200565 để tư vấn chi tiết! 📞";
}

function getSpecificProductResponse($message, $intent, $conn) {
    return "Bạn muốn xem sản phẩm dùng để làm gì? 🤔\n\n• Gaming? 🎮\n• Văn phòng? 💼\n• Thiết kế? 🎨\n\nVà ngân sách khoảng bao nhiêu? 💰";
}

function getPriceInquiryResponse($message, $intent, $conn) {
    return "Giá rất đa dạng tùy dòng! 💰 Từ phổ thông đến cao cấp. Bạn muốn xem sản phẩm gì? Gọi 0364200565 để báo giá chi tiết!";
}

function getGeneralResponse($message, $intent) {
    return "Hmm, câu này hơi ngoài chuyên môn! 😅 Mình chuyên tư vấn laptop, màn hình, phụ kiện gaming. Bạn cần tư vấn gì không?";
}

function getDefaultResponse($message) {
    return "Tôi có thể tư vấn:\n\n💻 Laptop\n🖥️ Màn hình\n⌨️ Bàn phím\n🖱️ Chuột\n🎧 Tai nghe\n\nBạn cần tìm gì? Gọi 0364200565 nhé! 📞";
}

function getProductContext($conn) {
    $context = "Sản phẩm:\n";
    $categories = [1 => 'Laptop', 2 => 'Màn hình', 3 => 'Bàn phím', 4 => 'Chuột', 5 => 'Tai nghe/Loa'];
    
    foreach ($categories as $id => $name) {
        $query = "SELECT title, new_price FROM product_info WHERE category_id = $id ORDER BY CAST(REPLACE(new_price, ',', '') AS UNSIGNED) DESC LIMIT 2";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $context .= "\n$name: ";
            $items = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $items[] = "{$row['title']} ({$row['new_price']}đ)";
            }
            $context .= implode(", ", $items);
        }
    }
    
    return $context;
}

function analyzeIntent($message) {
    $message = mb_strtolower($message, 'UTF-8');
    
    if (preg_match('/laptop/iu', $message)) return 'laptop';
    if (preg_match('/màn hình|monitor/iu', $message)) return 'monitor';
    if (preg_match('/bàn phím|keyboard/iu', $message)) return 'keyboard';
    if (preg_match('/chuột|mouse/iu', $message)) return 'mouse';
    if (preg_match('/tai nghe|headphone|loa/iu', $message)) return 'headphone';
    if (preg_match('/gaming|game/iu', $message)) return 'gaming';
    if (preg_match('/giá rẻ|rẻ/iu', $message)) return 'budget';
    if (preg_match('/cao cấp|premium/iu', $message)) return 'premium';
    
    return 'general';
}

function getProductRecommendations($intent, $message, $conn) {
    $products = [];
    $limit = 3;
    
    $query = "SELECT ID, title as name, image_name as image, new_price as price, old_price FROM product_info WHERE 1=1";
    
    switch ($intent) {
        case 'laptop': $query .= " AND category_id = 1"; break;
        case 'monitor': $query .= " AND category_id = 2"; break;
        case 'keyboard': $query .= " AND category_id = 3"; break;
        case 'mouse': $query .= " AND category_id = 4"; break;
        case 'headphone': $query .= " AND category_id = 5"; break;
        case 'gaming': $query .= " AND LOWER(title) LIKE '%gaming%'"; break;
        case 'budget': $query .= " AND CAST(REPLACE(new_price, ',', '') AS UNSIGNED) <= 10000000 ORDER BY CAST(REPLACE(new_price, ',', '') AS UNSIGNED) ASC"; break;
        case 'premium': $query .= " AND CAST(REPLACE(new_price, ',', '') AS UNSIGNED) >= 20000000 ORDER BY CAST(REPLACE(new_price, ',', '') AS UNSIGNED) DESC"; break;
        default: $query .= " AND featured = 'Có' ORDER BY RAND()";
    }
    
    $query .= " LIMIT $limit";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $imagePath = $row['image'];
            if (strpos($imagePath, 'img/') !== 0) {
                $imagePath = 'img/' . $imagePath;
            }
            
            $products[] = [
                'id' => $row['ID'],
                'name' => $row['name'],
                'image' => $imagePath,
                'price' => (int)str_replace(',', '', $row['price']),
                'old_price' => !empty($row['old_price']) ? (int)str_replace(',', '', $row['old_price']) : null
            ];
        }
    }
    
    return $products;
}

// Gemini AI Integration - MIỄN PHÍ!
function getChatGeminiResponse($userMessage, $history, $productContext) {
    // Tạo system prompt
    $systemPrompt = "Bạn là trợ lý AI thông minh của Electro - cửa hàng điện tử Đà Nẵng.

THÔNG TIN:
- Hotline: 0364200565
- Email: electro@gmail.com
- Địa chỉ: Đà Nẵng
- Giờ mở cửa: 8:00-22:00 (Hàng ngày)
- Đổi trả: 30 ngày
- Ship: Toàn quốc 2-5 ngày, free từ 500k
- Thanh toán: COD, ATM, Visa/MasterCard

SẢN PHẨM:
$productContext

CÁCH TRẢ LỜI:
✅ Tự nhiên, thân thiện như người thật
✅ Hài hước khi phù hợp
✅ Ngắn gọn 2-3 câu (trừ khi cần giải thích chi tiết)
✅ Dùng emoji vừa phải (1-2/câu)
✅ Hỏi lại nếu cần thêm thông tin
✅ Tư vấn dựa trên nhu cầu: gaming, văn phòng, giá rẻ...

❌ Không cứng nhắc như robot
❌ Không liệt kê nhiều mục
❌ Không tự đề xuất sản phẩm nếu khách chưa hỏi
❌ Không dài dòng, lan man

Trả lời như một người bán hàng thật sự hiểu khách!";
    // Build conversation history
    $conversationText = $systemPrompt . "\n\n";
    
    // Add recent history
    $recentHistory = array_slice($history, -5);
    foreach ($recentHistory as $msg) {
        $role = $msg['role'] === 'user' ? 'Khách hàng' : 'Bạn';
        $conversationText .= "$role: {$msg['content']}\n";
    }
    
    // Add current message
    $conversationText .= "Khách hàng: $userMessage\nBạn:";

    // Gemini API endpoint
$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . GEMINI_API_KEY;
    
    $data = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $conversationText]
                ]
            ]
        ],
        'generationConfig' => [
            'temperature' => 0.9,
            'topK' => 40,
            'topP' => 0.95,
            'maxOutputTokens' => 400,
        ],
        'safetySettings' => [
            ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_NONE'],
            ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_NONE'],
            ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_NONE'],
            ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_NONE'],
        ]
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    error_log("Gemini API Response Code: $httpCode");
    if ($curlError) {
        error_log("CURL Error: $curlError");
    }
    
    if ($httpCode !== 200 || !empty($curlError)) {
        if (!empty($response)) {
            error_log("Gemini API Error: $response");
        }
        return getSmartAIResponse($userMessage, [], '', null);
    }
    
    $result = json_decode($response, true);
    
    // Parse Gemini response
    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        return trim($result['candidates'][0]['content']['parts'][0]['text']);
    }
    
    error_log("No content in Gemini response, using fallback");
    return getSmartAIResponse($userMessage, [], '', null);
}
?>