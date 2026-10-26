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
    <title>Chính Sách Vận Chuyển - Electro</title>
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
        .shipping-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .shipping-table th {
            background: #D10024;
            color: white;
            padding: 15px;
            text-align: left;
        }
        .shipping-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .shipping-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .note-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
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
                        <h1><i class="fa fa-truck"></i> Chính Sách Vận Chuyển</h1>
                        
                        <div class="highlight-box">
                            <p><strong>🚚 MIỄN PHÍ VẬN CHUYỂN</strong> cho đơn hàng từ <strong>5.000.000đ</strong> trở lên trong nội thành!</p>
                        </div>

                        <h2>1. Phạm Vi Vận Chuyển</h2>
                        <ul>
                            <li>✅ Giao hàng toàn quốc 63 tỉnh thành</li>
                            <li>✅ Ưu tiên khu vực nội thành Đà Nẵng (giao trong ngày)</li>
                            <li>✅ Hỗ trợ giao hàng đến tận tay khách hàng</li>
                            <li>✅ Đối tác vận chuyển uy tín: Giao Hàng Nhanh, Giao Hàng Tiết Kiệm, Viettel Post</li>
                        </ul>

                        <h2>2. Thời Gian Giao Hàng</h2>
                        <table class="shipping-table">
                            <tr>
                                <th>Khu vực</th>
                                <th>Thời gian giao hàng</th>
                                <th>Phí vận chuyển</th>
                            </tr>
                            <tr>
                                <td><strong>Nội thành Đà Nẵng</strong></td>
                                <td>2-4 giờ (giao trong ngày)</td>
                                <td>40.000đ<br><small>(Free từ 5.000.000đ)</small></td>
                            </tr>
                            <tr>
                                <td><strong>Các tỉnh miền Trung</strong></td>
                                <td>1-2 ngày</td>
                                <td>40.000đ - 50.000đ<br><small></small></td>
                            </tr>
                            <tr>
                                <td><strong>Hà Nội, TP.HCM</strong></td>
                                <td>2-3 ngày</td>
                                <td>50.000đ - 100.000đ<br><small></small></td>
                            </tr>
                            <tr>
                                <td><strong>Các tỉnh khác</strong></td>
                                <td>3-5 ngày</td>
                                <td>50.000đ - 120.000đ<br></td>
                            </tr>
                            <tr>
                                <td><strong>Vùng xa, hải đảo</strong></td>
                                <td>5-7 ngày</td>
                                <td>Liên hệ</td>
                            </tr>
                        </table>

                        <div class="note-box">
                            <p><strong>📌 Lưu ý:</strong> Thời gian giao hàng có thể chậm hơn 1-2 ngày trong các trường hợp:</p>
                            <ul style="margin-bottom: 0;">
                                <li>Thời tiết xấu (bão, lũ, mưa lớn)</li>
                                <li>Dịp Tết, Lễ lớn (Tết Nguyên Đán, 30/4, 2/9...)</li>
                                <li>Sản phẩm hết hàng cần đặt về từ nhà cung cấp</li>
                            </ul>
                        </div>

                        <h2>3. Hình Thức Thanh Toán</h2>
                        <ul>
                            <li>💵 <strong>COD (Ship COD):</strong> Thanh toán khi nhận hàng</li>
                            <li>💳 <strong>Chuyển khoản:</strong> Chuyển trước 100% hoặc đặt cọc 30-50%</li>
                            <li>🏦 <strong>Quẹt thẻ:</strong> Visa, MasterCard, ATM (tại cửa hàng)</li>
                        </ul>

                        <h2>4. Quy Trình Đặt Hàng & Nhận Hàng</h2>
                        <p><strong>Bước 1:</strong> Đặt hàng qua Website, Hotline 0364200565 hoặc Zalo</p>
                        <p><strong>Bước 2:</strong> Nhân viên xác nhận đơn hàng qua điện thoại (trong 1 giờ)</p>
                        <p><strong>Bước 3:</strong> Đóng gói và giao cho đơn vị vận chuyển</p>
                        <p><strong>Bước 4:</strong> Nhận mã vận đơn theo dõi</p>
                        <p><strong>Bước 5:</strong> Nhận hàng và kiểm tra kỹ trước khi thanh toán</p>

                        <div class="highlight-box">
                            <p><strong>✅ Cam kết:</strong> Hàng giao đến đúng như mô tả, đóng gói cẩn thận. Nếu sản phẩm bị lỗi do vận chuyển, Electro chịu 100% trách nhiệm đổi mới!</p>
                        </div>

                        <h2>5. Kiểm Tra Hàng Khi Nhận</h2>
                        <ul>
                            <li>✅ Kiểm tra tình trạng thùng hàng (có bị móp méo, ướt không)</li>
                            <li>✅ Mở kiểm tra sản phẩm trước khi thanh toán COD</li>
                            <li>✅ Kiểm tra số lượng, màu sắc, model đúng như đơn hàng</li>
                            <li>✅ Chụp video quá trình mở hàng (nếu muốn)</li>
                            <li>❌ Nếu sản phẩm không đúng/lỗi → <strong>TỪ CHỐI NHẬN HÀNG</strong> và liên hệ ngay 0364200565</li>
                        </ul>

                        <h2>6. Chính Sách Hoàn Trả Phí Ship</h2>
                        <ul>
                            <li>🔄 Lỗi do Electro (giao sai hàng, hàng lỗi) → <strong>Hoàn 100% phí ship</strong></li>
                            <li>🔄 Khách đổi ý (đã nhận hàng) → Khách chịu phí ship 2 chiều</li>
                            <li>🔄 Sản phẩm bị lỗi trong 30 ngày → Electro chịu phí ship đổi hàng</li>
                        </ul>

                        <div class="note-box">
                            <p><strong>⚠️ Lưu ý quan trọng:</strong></p>
                            <ul style="margin-bottom: 0;">
                                <li>Hãy cung cấp <strong>địa chỉ chính xác, số điện thoại luôn bật</strong></li>
                                <li>Shipper sẽ gọi điện trước khi giao (giữ máy)</li>
                                <li>Nếu không nhận được hàng sau 7 ngày, liên hệ ngay Hotline</li>
                            </ul>
                        </div>

                        <div class="contact-box">
                            <h3><i class="fa fa-headset"></i> Hỗ Trợ Vận Chuyển</h3>
                            <p><i class="fa fa-phone"></i> <strong>Hotline:</strong> 0364200565 (8:00 - 22:00 hàng ngày)</p>
                            <p><i class="fa fa-map-marker"></i> <strong>Địa chỉ:</strong> Đà Nẵng</p>
                            <p><i class="fa fa-envelope"></i> <strong>Email:</strong> electro@gmail.com</p>
                            <p><i class="fa fa-comment"></i> <strong>Zalo:</strong> 0364200565</p>
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