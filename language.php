<?php

// Thiết lập ngôn ngữ mặc định
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'vi';
}

// Thiết lập tiền tệ mặc định
if (!isset($_SESSION['currency'])) {
    $_SESSION['currency'] = 'VND';
}

// Xử lý thay đổi ngôn ngữ
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Xử lý thay đổi tiền tệ
if (isset($_GET['currency'])) {
    $_SESSION['currency'] = $_GET['currency'];
}

// Tỷ giá USD/VND (cập nhật theo tỷ giá thực tế)
define('USD_TO_VND_RATE', 24000);

// Function chuyển đổi tiền tệ
function convert_currency($price_vnd, $to_currency = 'VND') {
    if ($to_currency == 'USD') {
        return $price_vnd / USD_TO_VND_RATE;
    }
    return $price_vnd;
}

// Function format tiền tệ
function format_currency($price_vnd) {
    $currency = $_SESSION['currency'];
    
    if ($currency == 'USD') {
        $price_usd = convert_currency($price_vnd, 'USD');
        return '$' . number_format($price_usd, 2, '.', ',');
    } else {
        return number_format($price_vnd, 0, ',', '.') . ' ₫';
    }
}

// Texts đa ngôn ngữ
$lang_text = [
    'vi' => [
        // Common
        'home' => 'Trang chủ',
        'shop' => 'Cửa hàng',
        'all_categories' => 'Tất cả danh mục',
        'collection' => 'Collection',
        'category' => 'Danh mục',
        'new_products' => 'Sản phẩm mới',
        'featured_products' => 'Sản phẩm nổi bật',
        'top_selling' => 'Bán chạy',
        'add_to_cart' => 'Thêm vào giỏ',
        'add_to_wishlist' => 'Yêu thích',
        'add_to_compare' => 'So sánh',
        'quick_view' => 'Xem nhanh',
        'shop_now' => 'Mua ngay',
        'subscribe' => 'Đăng ký',
        'newsletter_text' => 'Đăng kí để nhận THÔNG BÁO MỚI NHẤT',
        'enter_your_email' => 'Nhập email của bạn',
        'hot_deal_this_week' => 'Khuyến mãi trong tuần',
        'new_collection_sale' => 'Bộ sưu tập mới giảm đến 50%',
        'days' => 'Ngày',
        'hours' => 'Giờ',
        'mins' => 'Phút',
        'secs' => 'Giây',
        'showing' => 'Hiển thị',
        'products' => 'sản phẩm',
        'sort_by' => 'Sắp xếp theo',
        'default' => 'Mặc định',
        'price_low_high' => 'Giá: Thấp đến Cao',
        'price_high_low' => 'Giá: Cao đến Thấp',
        'name_asc' => 'Tên: A-Z',
        'name_desc' => 'Tên: Z-A',
        
        // Search & Filter
        'search' => 'Tìm kiếm',
        'search_result' => 'Kết quả tìm kiếm',
        'search_for' => 'Kết quả cho',
        'categories' => 'Danh mục',
        'brands' => 'Thương hiệu',
        'apply_filter' => 'Áp dụng lọc',
        'clear_filter' => 'Xóa bộ lọc',
        'no_products_found' => 'Không tìm thấy sản phẩm nào',
        
        // Cart page
        'shopping_cart' => 'Giỏ hàng',
        'stt' => 'STT',
        'product_name' => 'Tên sản phẩm',
        'image' => 'Ảnh',
        'price' => 'Giá tiền',
        'quantity' => 'Số lượng',
        'subtotal' => 'Thành tiền',
        'delete' => 'Xóa',
        'total' => 'Tổng tiền',
        'update' => 'Cập nhật',
        'recipient' => 'Người nhận',
        'phone' => 'Điện thoại',
        'address' => 'Địa chỉ',
        'note' => 'Ghi chú',
        'payment_method' => 'Phương thức thanh toán',
        'pay_on_delivery' => 'Thanh toán khi nhận hàng (COD)',
        'bank_transfer' => 'Chuyển khoản ngân hàng',
        'qr_code' => 'Quét mã QR',
        'place_order' => 'Đặt Hàng',
        'continue_shopping' => 'Tiếp tục mua hàng',
        'order_success' => 'Đặt hàng thành công',
        'out_of_stock' => 'Sản phẩm đã hết hàng',
        'back_to_home' => 'Quay lại trang chủ',
        
        // Payment info
        'deposit_required' => 'Số tiền cần đặt cọc',
        'total_amount' => 'Số tiền cần chuyển',
        'transfer_info' => 'Vui lòng chuyển khoản đến tài khoản sau',
        'bank' => 'Ngân hàng',
        'account_number' => 'Số tài khoản',
        'account_holder' => 'Chủ tài khoản',
        'transfer_content' => 'Nội dung CK',
        'scan_qr' => 'Quét mã QR để thanh toán',
        'amount' => 'Số tiền',
        'content' => 'Nội dung',
        'qr_warning' => 'Vui lòng không thay đổi nội dung chuyển khoản để đơn hàng được xử lý nhanh chóng!',
        'copy' => 'Copy',
        
        // Wishlist
        'wishlist' => 'Danh sách yêu thích',
        'my_wishlist' => 'Sản phẩm yêu thích của tôi',
        'remove' => 'Xóa',
        'empty_wishlist' => 'Danh sách yêu thích trống',
        'add_products_wishlist' => 'Hãy thêm sản phẩm vào danh sách yêu thích!',
        
        // Auth
        'login' => 'Đăng nhập',
        'register' => 'Đăng ký',
        'logout' => 'Đăng xuất',
        'login_account' => 'Đăng nhập tài khoản',
        'register_account' => 'Đăng ký tài khoản',
        'username' => 'Tên đăng nhập',
        'password' => 'Mật khẩu',
        'confirm_password' => 'Xác nhận mật khẩu',
        'full_name' => 'Họ và tên',
        'email' => 'Email',
        'forgot_password' => 'Quên mật khẩu?',
        'no_account' => 'Chưa có tài khoản?',
        'register_now' => 'Đăng ký ngay',
        'have_account' => 'Đã có tài khoản?',
        'login_now' => 'Đăng nhập ngay',
        'enter_username' => 'Nhập tên đăng nhập',
        'enter_password' => 'Nhập mật khẩu',
        'enter_full_name' => 'Nhập họ và tên đầy đủ',
        'enter_email' => 'Nhập địa chỉ email',
        'enter_phone' => 'Nhập số điện thoại',
        'register_success' => 'Đăng ký thành công! Chuyển hướng đến trang đăng nhập...',
        'email_exists' => 'Email đã được sử dụng!',
        'password_mismatch' => 'Mật khẩu không khớp!',
        'login_error' => 'Email hoặc mật khẩu không chính xác!',
        
        // Profile
        'profile' => 'Thông tin cá nhân',
        'account_info' => 'Thông tin tài khoản',
        'change_password' => 'Đổi mật khẩu',
        'old_password' => 'Mật khẩu cũ',
        'new_password' => 'Mật khẩu mới',
        'confirm_new_password' => 'Xác nhận mật khẩu mới',
        'update_profile' => 'Cập nhật thông tin',
        'update_password' => 'Cập nhật mật khẩu',
        'update_success' => 'Cập nhật thông tin thành công!',
        'update_error' => 'Có lỗi xảy ra, vui lòng thử lại!',
        'password_change_success' => 'Đổi mật khẩu thành công!',
        'old_password_incorrect' => 'Mật khẩu cũ không chính xác!',
        'password_mismatch' => 'Mật khẩu không khớp!',
        'enter_old_password' => 'Nhập mật khẩu cũ',
        'enter_new_password' => 'Nhập mật khẩu mới',
        'enter_confirm_password' => 'Xác nhận mật khẩu mới',
    ],
    'en' => [
        // Common
        'home' => 'Home',
        'shop' => 'Shop',
        'all_categories' => 'All Categories',
        'collection' => 'Collection',
        'category' => 'Category',
        'new_products' => 'New Products',
        'featured_products' => 'Featured Products',
        'top_selling' => 'Top Selling',
        'add_to_cart' => 'Add to Cart',
        'add_to_wishlist' => 'Add to Wishlist',
        'add_to_compare' => 'Add to Compare',
        'quick_view' => 'Quick View',
        'shop_now' => 'Shop Now',
        'subscribe' => 'Subscribe',
        'newsletter_text' => 'Sign up for the LATEST NEWS',
        'enter_your_email' => 'Enter Your Email',
        'hot_deal_this_week' => 'Hot Deal This Week',
        'new_collection_sale' => 'New Collection Up to 50% OFF',
        'days' => 'Days',
        'hours' => 'Hours',
        'mins' => 'Mins',
        'secs' => 'Secs',
        'showing' => 'Showing',
        'products' => 'products',
        'sort_by' => 'Sort By',
        'default' => 'Default',
        'price_low_high' => 'Price: Low to High',
        'price_high_low' => 'Price: High to Low',
        'name_asc' => 'Name: A-Z',
        'name_desc' => 'Name: Z-A',
        
        // Search & Filter
        'search' => 'Search',
        'search_result' => 'Search Results',
        'search_for' => 'Results for',
        'categories' => 'Categories',
        'brands' => 'Brands',
        'apply_filter' => 'Apply Filter',
        'clear_filter' => 'Clear Filter',
        'no_products_found' => 'No products found',
        
        // Cart page
        'shopping_cart' => 'Shopping Cart',
        'stt' => 'No.',
        'product_name' => 'Product Name',
        'image' => 'Image',
        'price' => 'Price',
        'quantity' => 'Quantity',
        'subtotal' => 'Subtotal',
        'delete' => 'Delete',
        'total' => 'Total',
        'update' => 'Update',
        'recipient' => 'Recipient',
        'phone' => 'Phone',
        'address' => 'Address',
        'note' => 'Note',
        'payment_method' => 'Payment Method',
        'pay_on_delivery' => 'Cash on Delivery (COD)',
        'bank_transfer' => 'Bank Transfer',
        'qr_code' => 'QR Code',
        'place_order' => 'Place Order',
        'continue_shopping' => 'Continue Shopping',
        'order_success' => 'Order placed successfully',
        'out_of_stock' => 'Product is out of stock',
        'back_to_home' => 'Back to Home',
        
        // Payment info
        'deposit_required' => 'Deposit Required',
        'total_amount' => 'Total Amount',
        'transfer_info' => 'Please transfer to the following account',
        'bank' => 'Bank',
        'account_number' => 'Account Number',
        'account_holder' => 'Account Holder',
        'transfer_content' => 'Transfer Content',
        'scan_qr' => 'Scan QR Code to Pay',
        'amount' => 'Amount',
        'content' => 'Content',
        'qr_warning' => 'Please do not change the transfer content for faster processing!',
        'copy' => 'Copy',
        
        // Wishlist
        'wishlist' => 'Wishlist',
        'my_wishlist' => 'My Wishlist',
        'remove' => 'Remove',
        'empty_wishlist' => 'Empty Wishlist',
        'add_products_wishlist' => 'Add products to your wishlist!',
        
        // Auth
        'login' => 'Login',
        'register' => 'Register',
        'logout' => 'Logout',
        'login_account' => 'Login Account',
        'register_account' => 'Register Account',
        'username' => 'Username',
        'password' => 'Password',
        'confirm_password' => 'Confirm Password',
        'full_name' => 'Full Name',
        'email' => 'Email',
        'forgot_password' => 'Forgot Password?',
        'no_account' => 'No account yet?',
        'register_now' => 'Register now',
        'have_account' => 'Already have an account?',
        'login_now' => 'Login now',
        'enter_username' => 'Enter username',
        'enter_password' => 'Enter password',
        'enter_full_name' => 'Enter full name',
        'enter_email' => 'Enter email address',
        'enter_phone' => 'Enter phone number',
        'register_success' => 'Registration successful! Redirecting to login...',
        'email_exists' => 'Email already in use!',
        'password_mismatch' => 'Passwords do not match!',
        'login_error' => 'Email or password is incorrect!',
        
        // Profile
        'profile' => 'Profile',
        'account_info' => 'Account Information',
        'change_password' => 'Change Password',
        'old_password' => 'Old Password',
        'new_password' => 'New Password',
        'confirm_new_password' => 'Confirm New Password',
        'update_profile' => 'Update Profile',
        'update_password' => 'Update Password',
        'update_success' => 'Profile updated successfully!',
        'update_error' => 'An error occurred, please try again!',
        'password_change_success' => 'Password changed successfully!',
        'old_password_incorrect' => 'Old password is incorrect!',
        'enter_old_password' => 'Enter old password',
        'enter_new_password' => 'Enter new password',
        'enter_confirm_password' => 'Confirm new password',
    ]
];

function t($key) {
    global $lang_text;
    $lang = $_SESSION['lang'];
    return isset($lang_text[$lang][$key]) ? $lang_text[$lang][$key] : $key;
}
?>