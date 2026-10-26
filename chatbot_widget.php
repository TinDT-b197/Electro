<style>
    /* Chatbot Widget Styles */
    .chatbot-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        font-family: Arial, sans-serif;
    }

    .chatbot-toggle-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        font-size: 24px;
        transition: transform 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chatbot-toggle-btn:hover {
        transform: scale(1.1);
    }

    .chatbot-window {
        display: none;
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 380px;
        height: 550px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        flex-direction: column;
        overflow: hidden;
        animation: slideUp 0.3s ease;
    }

    .chatbot-window.active {
        display: flex;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chatbot-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chatbot-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .chatbot-header .status {
        font-size: 12px;
        opacity: 0.9;
    }

    .chatbot-close {
        background: transparent;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chatbot-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f8f9fa;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .chatbot-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chatbot-messages::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }

    .chat-message {
        display: flex;
        margin-bottom: 10px;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chat-message.bot {
        justify-content: flex-start;
    }

    .chat-message.user {
        justify-content: flex-end;
    }

    .message-bubble {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 18px;
        word-wrap: break-word;
        line-height: 1.4;
    }

    .chat-message.bot .message-bubble {
        background: white;
        color: #333;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .chat-message.user .message-bubble {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .product-suggestion {
        background: white;
        border-radius: 12px;
        padding: 12px;
        margin-top: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .product-suggestion:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .product-suggestion img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 12px;
        float: left;
    }

    .product-info h4 {
        margin: 0 0 5px 0;
        font-size: 14px;
        color: #333;
    }

    .product-info .price {
        color: #e74c3c;
        font-weight: bold;
        font-size: 16px;
    }

    .product-info .old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 12px;
        margin-left: 5px;
    }

    .chatbot-input-area {
        border-top: 1px solid #e0e0e0;
        padding: 15px;
        background: white;
        display: flex;
        gap: 10px;
    }

    .chatbot-input {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 25px;
        outline: none;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .chatbot-input:focus {
        border-color: #667eea;
    }

    .chatbot-send-btn {
        padding: 12px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: transform 0.2s ease;
    }

    .chatbot-send-btn:hover {
        transform: scale(1.05);
    }

    .chatbot-send-btn:active {
        transform: scale(0.95);
    }

    .typing-indicator {
        display: none;
        padding: 10px 15px;
        background: white;
        border-radius: 18px;
        width: fit-content;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .typing-indicator.active {
        display: block;
    }

    .typing-indicator span {
        height: 8px;
        width: 8px;
        background: #999;
        border-radius: 50%;
        display: inline-block;
        margin: 0 2px;
        animation: typing 1.4s infinite;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {
        0%, 60%, 100% {
            transform: translateY(0);
        }
        30% {
            transform: translateY(-10px);
        }
    }

    .quick-replies {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .quick-reply-btn {
        padding: 8px 15px;
        background: white;
        border: 1px solid #667eea;
        color: #667eea;
        border-radius: 20px;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .quick-reply-btn:hover {
        background: #667eea;
        color: white;
    }

    .ai-badge {
        display: inline-block;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 10px;
        margin-left: 5px;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .chatbot-window {
            width: calc(100% - 40px);
            height: calc(100% - 110px);
            right: 20px;
            bottom: 90px;
        }
    }

    .discount-badge {
        position: absolute;
        top: 5px;
        left: 5px;
        background: #e74c3c;
        color: white;
        padding: 4px 8px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: bold;
        z-index: 1;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>

<div class="chatbot-widget">
    <button class="chatbot-toggle-btn" onclick="toggleChatbot()" id="chatbotToggle">
        <span id="toggleIcon">💬</span>
    </button>
    
    <div class="chatbot-window" id="chatbotWindow">
        <div class="chatbot-header">
            <div>
                <h3>ChatGPT Tư Vấn <span class="ai-badge">GPT-3.5</span></h3>
                <span class="status">● Trực tuyến</span>
            </div>
            <button class="chatbot-close" onclick="toggleChatbot()">×</button>
        </div>
        
        <div class="chatbot-messages" id="chatMessages">
            <div class="chat-message bot">
                <div class="message-bubble">
                    Xin chào! 👋 Tôi là ChatGPT - trợ lý AI tư vấn sản phẩm điện tử của Electro. Tôi có thể giúp bạn tìm kiếm và tư vấn sản phẩm phù hợp nhất!
                </div>
            </div>
            <div class="quick-replies">
                <button class="quick-reply-btn" onclick="sendQuickReply('Tư vấn laptop')">💻 Laptop</button>
                <button class="quick-reply-btn" onclick="sendQuickReply('Tư vấn màn hình')">🖥️ Màn hình</button>
                <button class="quick-reply-btn" onclick="sendQuickReply('Tư vấn tai nghe')">🎧 Tai nghe</button>
                <button class="quick-reply-btn" onclick="sendQuickReply('Giờ mở cửa')">🕒 Giờ mở cửa</button>
            </div>
            <div class="typing-indicator" id="typingIndicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        
        <div class="chatbot-input-area">
            <input 
                type="text" 
                class="chatbot-input" 
                id="chatInput" 
                placeholder="Hỏi AI về sản phẩm..."
                onkeypress="handleKeyPress(event)"
            >
            <button class="chatbot-send-btn" onclick="sendMessage()">
                <span id="sendBtnText">Gửi</span>
            </button>
        </div>
    </div>
</div>

<script>
    let conversationHistory = [];

    // Toggle chatbot window
    function toggleChatbot() {
        const window = document.getElementById('chatbotWindow');
        const icon = document.getElementById('toggleIcon');
        window.classList.toggle('active');
        icon.textContent = window.classList.contains('active') ? '×' : '💬';
    }

    // Handle Enter key press
    function handleKeyPress(event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    }

    // Send message
    async function sendMessage() {
        const input = document.getElementById('chatInput');
        const message = input.value.trim();
        
        if (message) {
            addMessage(message, 'user');
            conversationHistory.push({role: 'user', content: message});
            input.value = '';
            
            // Show typing indicator
            showTyping();
            
            // Call AI API
            try {
                const response = await fetch('chatbot_api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        message: message,
                        history: conversationHistory
                    })
                });
                
                const data = await response.json();
                hideTyping();
                
                if (data.success) {
                    addMessage(data.response, 'bot');
                    conversationHistory.push({role: 'assistant', content: data.response});
                    
                    // Display product suggestions if any
                    if (data.products && data.products.length > 0) {
                        displayProducts(data.products);
                    }
                } else {
                    addMessage('Xin lỗi, đã có lỗi xảy ra: ' + (data.error || 'Unknown error'), 'bot');
                }
            } catch (error) {
                hideTyping();
                addMessage('Không thể kết nối đến server. Vui lòng kiểm tra kết nối mạng.', 'bot');
                console.error('Error:', error);
            }
        }
    }

    // Send quick reply
    function sendQuickReply(message) {
        document.getElementById('chatInput').value = message;
        sendMessage();
    }

    // Add message to chat
    function addMessage(text, sender) {
        const messagesDiv = document.getElementById('chatMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${sender}`;
        
        const bubble = document.createElement('div');
        bubble.className = 'message-bubble';
        bubble.innerHTML = text.replace(/\n/g, '<br>');
        
        messageDiv.appendChild(bubble);
        messagesDiv.appendChild(messageDiv);
        
        // Scroll to bottom
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    // Display product suggestions
    function displayProducts(products) {
        const messagesDiv = document.getElementById('chatMessages');
        
        if (products.length === 0) {
            addMessage('Rất tiếc, hiện tại không tìm thấy sản phẩm phù hợp. Vui lòng liên hệ hotline 0364200565 để được tư vấn! 😊', 'bot');
            return;
        }
        
        products.forEach(product => {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'chat-message bot';
            
            const productDiv = document.createElement('div');
            productDiv.className = 'product-suggestion';
            productDiv.onclick = () => viewProduct(product.id);
            
            // Calculate discount if old_price exists
            let discountHTML = '';
            if (product.old_price && product.old_price > product.price) {
                const discount = Math.round(((product.old_price - product.price) / product.old_price) * 100);
                discountHTML = `<span class="discount-badge">-${discount}%</span>`;
            }
            
            console.log('Product:', product); // Debug log
            
            productDiv.innerHTML = `
                <div style="display: flex; gap: 12px; position: relative;">
                    <div style="flex-shrink: 0; width: 80px; height: 80px; background: #f5f5f5; border-radius: 8px; overflow: hidden; position: relative;">
                        ${discountHTML}
                        <img src="${product.image}" 
                             alt="${product.name}" 
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\\'width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 40px;\\'>📦</div>'">
                    </div>
                    <div class="product-info" style="flex: 1;">
                        <h4 style="margin: 0 0 8px 0; font-size: 14px; color: #333; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${product.name}</h4>
                        <div>
                            <span class="price" style="color: #e74c3c; font-weight: bold; font-size: 16px;">${formatPrice(product.price)}đ</span>
                            ${product.old_price ? `<span class="old-price" style="text-decoration: line-through; color: #999; font-size: 12px; margin-left: 8px;">${formatPrice(product.old_price)}đ</span>` : ''}
                        </div>
                        <button style="margin-top: 8px; padding: 6px 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px; font-size: 12px; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">Xem chi tiết →</button>
                    </div>
                </div>
            `;
            
            messageDiv.appendChild(productDiv);
            messagesDiv.appendChild(messageDiv);
        });
        
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    // Handle image error
    function handleImageError(img) {
        console.error('Image load error:', img.src);
        // Try alternative paths
        const originalSrc = img.src;
        const filename = originalSrc.split('/').pop();
        
        // Try different paths
        const possiblePaths = [
            `image/${filename}`,
            `images/${filename}`,
            `./image/${filename}`,
            `../image/${filename}`
        ];
        
        let pathIndex = 0;
        img.onerror = function() {
            pathIndex++;
            if (pathIndex < possiblePaths.length) {
                this.src = possiblePaths[pathIndex];
            } else {
                // All paths failed, show placeholder
                this.style.display = 'none';
                this.parentElement.innerHTML = '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 40px;">📦</div>';
            }
        };
        
        img.src = possiblePaths[0];
    }

    // Format price
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price);
    }

    // View product details
    function viewProduct(productId) {
        // Tùy vào cấu trúc URL của bạn, có thể là:
        window.location.href = `index.php?id=${productId}`;
        // Hoặc: window.location.href = `product_detail.php?id=${productId}`;
        // Hoặc: window.location.href = `product.php?id=${productId}`;
    }

    // Show typing indicator
    function showTyping() {
        document.getElementById('typingIndicator').classList.add('active');
        document.getElementById('sendBtnText').textContent = '...';
        const messagesDiv = document.getElementById('chatMessages');
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    // Hide typing indicator
    function hideTyping() {
        document.getElementById('typingIndicator').classList.remove('active');
        document.getElementById('sendBtnText').textContent = 'Gửi';
    }
</script>