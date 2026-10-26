<!DOCTYPE html>
<html lang="vi">
<link rel="icon" href="./img/logo.png" type="image">

<?php
session_start();
include './connect.php';
include './language.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chính Sách Bảo Mật - Electro</title>
    <?php include './partials/css.php'; ?>
    <style>
        .policy-content {
            padding: 50px 0;
            background: #f8f9fa;
        }
        .policy-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .policy-box h1 {
            color: #D10024;
            margin-bottom: 30px;
            font-size: 32px;
            font-weight: bold;
        }
        .policy-box h2 {
            color: #333;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: 600;
        }
        .policy-box p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 15px;
        }
        .policy-box ul {
            margin-left: 20px;
            margin-bottom: 20px;
        }
        .policy-box ul li {
            color: #666;
            line-height: 1.8;
            margin-bottom: 10px;
        }
        .highlight-box {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px 20px;
            margin: 20px 0;
        }
        .warning-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px 20px;
            margin: 20px 0;
        }
        .info-box {
            background: #d1ecf1;
            border-left: 4px solid #17a2b8;
            padding: 15px 20px;
            margin: 20px 0;
        }
        .contact-box {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }
        .contact-box h3 {
            color: #D10024;
            margin-bottom: 15px;
        }
        .contact-box i {
            margin-right: 10px;
            color: #D10024;
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <?php include './partials/header.php'; ?>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <?php include './partials/menu.php'; ?>
    <!-- /NAVIGATION -->

    <!-- POLICY CONTENT -->
    <div class="policy-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="policy-box">
                        <h1><i class="fa fa-shield"></i> Chính Sách Bảo Mật Thông Tin</h1>
                        
                        <div class="highlight-box">
                            <p><strong>🔒 CAM KẾT:</strong> Electro cam kết bảo vệ thông tin cá nhân của khách hàng và không chia sẻ cho bên thứ ba khi chưa có sự đồng ý.</p>
                        </div>

                        <h2>1. Mục Đích Thu Thập Thông Tin</h2>
                        <p>Chúng tôi thu thập thông tin cá nhân của bạn với các mục đích sau:</p>
                        <ul>
                            <li>✅ Xử lý đơn hàng và giao hàng đến đúng địa chỉ</li>
                            <li>✅ Liên hệ xác nhận đơn hàng, thông báo tình trạng vận chuyển</li>
                            <li>✅ Cung cấp thông tin khuyến mãi, sản phẩm mới (nếu bạn đăng ký nhận)</li>
                            <li>✅ Hỗ trợ khách hàng khi có yêu cầu bảo hành, đổi trả</li>
                            <li>✅ Cải thiện chất lượng dịch vụ dựa trên phản hồi của khách hàng</li>
                            <li>✅ Ngăn chặn các hành vi gian lận, vi phạm pháp luật</li>
                        </ul>

                        <h2>2. Thông Tin Chúng Tôi Thu Thập</h2>
                        <p>Khi bạn mua hàng hoặc đăng ký tài khoản tại Electro, chúng tôi có thể thu thập:</p>
                        
                        <div class="info-box">
                            <p><strong>📋 Thông tin cá nhân:</strong></p>
                            <ul style="margin-bottom: 0;">
                                <li>Họ tên đầy đủ</li>
                                <li>Số điện thoại</li>
                                <li>Địa chỉ email</li>
                                <li>Địa chỉ giao hàng</li>
                                <li>Thông tin thanh toán (nếu thanh toán trực tuyến)</li>
                            </ul>
                        </div>

                        <div class="info-box">
                            <p><strong>💻 Thông tin kỹ thuật:</strong></p>
                            <ul style="margin-bottom: 0;">
                                <li>Địa chỉ IP</li>
                                <li>Loại trình duyệt</li>
                                <li>Thời gian truy cập website</li>
                                <li>Cookie (để cải thiện trải nghiệm người dùng)</li>
                            </ul>
                        </div>

                        <h2>3. Phạm Vi Sử Dụng Thông Tin</h2>
                        <p>Thông tin cá nhân của bạn <strong>CHỈ</strong> được sử dụng trong phạm vi:</p>
                        <ul>
                            <li>🔹 Nội bộ công ty Electro để xử lý đơn hàng</li>
                            <li>🔹 Đối tác vận chuyển (chỉ cung cấp tên, SĐT, địa chỉ nhận hàng)</li>
                            <li>🔹 Cơ quan pháp luật khi có yêu cầu hợp lệ</li>
                        </ul>

                        <div class="warning-box">
                            <p><strong>⚠️ Chúng tôi KHÔNG BAO GIỜ:</strong></p>
                            <ul style="margin-bottom: 0;">
                                <li>❌ Bán thông tin cá nhân của bạn cho bên thứ ba</li>
                                <li>❌ Chia sẻ email để gửi spam, quảng cáo rác</li>
                                <li>❌ Tiết lộ thông tin tài chính, ngân hàng của bạn</li>
                                <li>❌ Sử dụng thông tin cho mục đích khác ngoài kinh doanh hợp pháp</li>
                            </ul>
                        </div>

                        <h2>4. Thời Gian Lưu Trữ Thông Tin</h2>
                        <p>Thông tin cá nhân của bạn được lưu trữ:</p>
                        <ul>
                            <li>📅 <strong>Tài khoản đăng ký:</strong> Lưu trữ vĩnh viễn cho đến khi bạn yêu cầu xóa</li>
                            <li>📅 <strong>Thông tin đơn hàng:</strong> Lưu trữ tối thiểu 3 năm (theo quy định pháp luật)</li>
                            <li>📅 <strong>Log truy cập website:</strong> Lưu trữ 12 tháng</li>
                            <li>📅 <strong>Dữ liệu thanh toán:</strong> Không lưu trữ thông tin thẻ/tài khoản ngân hàng</li>
                        </ul>

                        <h2>5. Biện Pháp Bảo Mật Thông Tin</h2>
                        <p>Chúng tôi áp dụng các biện pháp kỹ thuật và tổ chức để bảo vệ thông tin của bạn:</p>
                        <ul>
                            <li>🔐 Mã hóa SSL/TLS cho mọi giao dịch trên website</li>
                            <li>🔐 Hệ thống tường lửa (Firewall) bảo vệ máy chủ</li>
                            <li>🔐 Sao lưu dữ liệu định kỳ, an toàn</li>
                            <li>🔐 Giới hạn quyền truy cập: Chỉ nhân viên được ủy quyền mới xem được thông tin khách hàng</li>
                            <li>🔐 Cam kết bảo mật: Nhân viên ký cam kết không tiết lộ thông tin khách hàng</li>
                            <li>🔐 Cập nhật bảo mật thường xuyên, vá lỗi kịp thời</li>
                        </ul>

                        <h2>6. Quyền Của Khách Hàng</h2>
                        <p>Bạn có các quyền sau đối với thông tin cá nhân của mình:</p>

                        <div class="info-box">
                            <p><strong>✅ Quyền truy cập:</strong> Yêu cầu xem thông tin cá nhân mà chúng tôi đang lưu trữ</p>
                        </div>

                        <div class="info-box">
                            <p><strong>✅ Quyền chỉnh sửa:</strong> Cập nhật, sửa đổi thông tin cá nhân không chính xác</p>
                        </div>

                        <div class="info-box">
                            <p><strong>✅ Quyền xóa:</strong> Yêu cầu xóa tài khoản và thông tin cá nhân (trừ dữ liệu phải lưu theo pháp luật)</p>
                        </div>

                        <div class="info-box">
                            <p><strong>✅ Quyền rút lại đồng ý:</strong> Hủy đăng ký nhận email marketing bất cứ lúc nào</p>
                        </div>

                        <div class="info-box">
                            <p><strong>✅ Quyền khiếu nại:</strong> Liên hệ chúng tôi nếu phát hiện thông tin bị sử dụng sai mục đích</p>
                        </div>

                        <h2>7. Sử Dụng Cookie</h2>
                        <p>Website của chúng tôi sử dụng cookie để:</p>
                        <ul>
                            <li>🍪 Ghi nhớ giỏ hàng của bạn</li>
                            <li>🍪 Ghi nhớ thông tin đăng nhập (nếu bạn chọn "Ghi nhớ tôi")</li>
                            <li>🍪 Phân tích hành vi người dùng để cải thiện website (Google Analytics)</li>
                            <li>🍪 Hiển thị quảng cáo phù hợp (nếu có)</li>
                        </ul>
                        <p>Bạn có thể tắt cookie trong cài đặt trình duyệt, nhưng một số tính năng của website có thể không hoạt động.</p>

                        <h2>8. Liên Kết Đến Website Bên Thứ Ba</h2>
                        <p>
                            Website của chúng tôi có thể chứa liên kết đến các trang web khác (ví dụ: trang thanh toán, mạng xã hội). 
                            Chúng tôi <strong>KHÔNG chịu trách nhiệm</strong> về chính sách bảo mật của các trang web này. 
                            Vui lòng đọc kỹ chính sách bảo mật của họ trước khi cung cấp thông tin.
                        </p>

                        <h2>9. Bảo Mật Thông Tin Thanh Toán</h2>
                        <ul>
                            <li>💳 <strong>Thanh toán COD:</strong> Chúng tôi không lưu trữ bất kỳ thông tin tài chính nào</li>
                            <li>💳 <strong>Chuyển khoản:</strong> Bạn chuyển trực tiếp vào tài khoản công ty, chúng tôi không lưu thông tin tài khoản của bạn</li>
                            <li>💳 <strong>Thanh toán thẻ/ví điện tử:</strong> Được xử lý qua cổng thanh toán bảo mật của đối tác (VNPay, Momo...), chúng tôi không lưu trữ thông tin thẻ</li>
                        </ul>

                        <h2>10. Chính Sách Đối Với Trẻ Em</h2>
                        <p>
                            Chúng tôi không cố ý thu thập thông tin cá nhân của trẻ em dưới 16 tuổi. 
                            Nếu bạn là phụ huynh và phát hiện con bạn đã cung cấp thông tin cá nhân cho chúng tôi mà không có sự đồng ý, 
                            vui lòng liên hệ để chúng tôi xóa thông tin đó.
                        </p>

                        <h2>11. Thay Đổi Chính Sách Bảo Mật</h2>
                        <p>
                            Chúng tôi có thể cập nhật Chính sách bảo mật này theo thời gian. Mọi thay đổi sẽ được đăng tải trên trang này 
                            với ngày hiệu lực mới. Chúng tôi khuyến khích bạn thường xuyên kiểm tra để nắm rõ cách thông tin của bạn được bảo vệ.
                        </p>
                        <p><strong>Ngày cập nhật cuối:</strong> 19/11/2025</p>

                        <div class="highlight-box">
                            <p><strong>📢 LƯU Ý QUAN TRỌNG:</strong></p>
                            <p>
                                Nếu bạn không đồng ý với Chính sách bảo mật này, vui lòng không sử dụng dịch vụ của chúng tôi. 
                                Việc tiếp tục sử dụng website và dịch vụ của Electro đồng nghĩa với việc bạn chấp nhận 
                                Chính sách bảo mật này.
                            </p>
                        </div>

                        <h2>12. Liên Hệ Về Bảo Mật</h2>
                        <p>Nếu bạn có bất kỳ câu hỏi nào về Chính sách bảo mật hoặc muốn thực hiện quyền của mình, vui lòng liên hệ:</p>

                        <div class="contact-box">
                            <h3><i class="fa fa-shield-alt"></i> Bộ Phận Bảo Mật Thông Tin</h3>
                            <p><i class="fa fa-phone"></i> <strong>Hotline:</strong> 0364200565 (8:00 - 22:00 hàng ngày)</p>
                            <p><i class="fa fa-map-marker"></i> <strong>Địa chỉ:</strong> Đà Nẵng</p>
                            <p><i class="fa fa-envelope"></i> <strong>Email:</strong> electro@gmail.com</p>
                            <p><i class="fa fa-comment"></i> <strong>Zalo:</strong> 0364200565</p>
                        </div>

                        <div class="warning-box">
                            <p><strong>⚠️ Phát hiện lỗ hổng bảo mật?</strong></p>
                            <p>
                                Nếu bạn phát hiện bất kỳ lỗ hổng bảo mật nào trên website của chúng tôi, 
                                vui lòng báo ngay qua email <strong>electro@gmail.com</strong>. 
                                Chúng tôi sẽ xử lý khẩn cấp và có phần thưởng tri ân cho những báo cáo giá trị.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /POLICY CONTENT -->

    <!-- FOOTER -->
    <?php include './partials/footer.php'; ?>
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script>

    <?php include 'chatbot_widget.php'; ?>
    <?php include 'zalo_contact.php'; ?>
</body>
</html>