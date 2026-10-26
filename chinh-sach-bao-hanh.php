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
    <title>Chính Sách Bảo Hành - Electro</title>
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
            background: #fff3cd;
            border-left: 4px solid #D10024;
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
        .contact-box p {
            margin-bottom: 8px;
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
                        <h1><i class="fa fa-shield"></i> Chính Sách Bảo Hành</h1>
                        
                        <div class="highlight-box">
                            <p><strong>⏰ Thời gian bảo hành:</strong> Từ 12-36 tháng tùy theo từng sản phẩm</p>
                        </div>

                        <h2>1. Điều Kiện Bảo Hành</h2>
                        <ul>
                            <li>✅ Sản phẩm còn trong thời hạn bảo hành</li>
                            <li>✅ Tem bảo hành còn nguyên vẹn, không bị rách, mờ hoặc tẩy xóa</li>
                            <li>✅ Số serial trên sản phẩm khớp với phiếu bảo hành</li>
                            <li>✅ Lỗi do nhà sản xuất (lỗi kỹ thuật, linh kiện)</li>
                        </ul>

                        <h2>2. Các Trường Hợp Không Được Bảo Hành</h2>
                        <ul>
                            <li>❌ Sản phẩm hết thời hạn bảo hành</li>
                            <li>❌ Tem bảo hành bị rách, bong tróc hoặc sửa đổi</li>
                            <li>❌ Sản phẩm bị va đập, rơi vỡ, cong vênh, trầy xước nặng</li>
                            <li>❌ Sản phẩm bị lỗi do người dùng (rơi, vào nước, cháy nổ, côn trùng...)</li>
                            <li>❌ Sản phẩm đã được sửa chữa bởi bên thứ ba không ủy quyền</li>
                            <li>❌ Sử dụng sai điện áp, nguồn không đúng quy cách</li>
                        </ul>

                        <h2>3. Quy Trình Bảo Hành</h2>
                        <p><strong>Bước 1:</strong> Liên hệ hotline <strong>0364200565</strong> hoặc đến trực tiếp cửa hàng</p>
                        <p><strong>Bước 2:</strong> Nhân viên kiểm tra tình trạng sản phẩm và điều kiện bảo hành</p>
                        <p><strong>Bước 3:</strong> Lập phiếu tiếp nhận bảo hành (khách giữ phiếu)</p>
                        <p><strong>Bước 4:</strong> Xử lý bảo hành trong 7-15 ngày làm việc</p>
                        <p><strong>Bước 5:</strong> Thông báo và giao sản phẩm cho khách hàng</p>

                        <div class="highlight-box">
                            <p><strong>⚡ Cam kết:</strong> Sản phẩm bảo hành quá 15 ngày sẽ được hỗ trợ <strong>ĐỔI MỚI</strong> hoặc <strong>HOÀN TIỀN 100%</strong></p>
                        </div>

                        <h2>4. Chính Sách Đổi Trả Trong 30 Ngày</h2>
                        <ul>
                            <li>🔄 Đổi trả miễn phí trong <strong>30 ngày đầu</strong> kể từ ngày mua</li>
                            <li>📦 Sản phẩm còn nguyên tem, hộp, phụ kiện đầy đủ</li>
                            <li>💯 Không phát sinh lỗi do người dùng</li>
                            <li>✨ Đổi sản phẩm tương đương hoặc hoàn tiền 100%</li>
                        </ul>

                        <h2>5. Thời Gian Bảo Hành Theo Sản Phẩm</h2>
                        <table style="width:100%; border-collapse: collapse; margin-top: 15px;">
                            <tr style="background: #f8f9fa;">
                                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Sản phẩm</th>
                                <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">Thời gian bảo hành</th>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Laptop</td>
                                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">12-24 tháng</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Màn hình</td>
                                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">24-36 tháng</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Bàn phím, Chuột</td>
                                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">12 tháng</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Tai nghe, Loa</td>
                                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">12-24 tháng</td>
                            </tr>
                        </table>

                        <div class="contact-box">
                            <h3><i class="fa fa-phone"></i> Liên Hệ Bảo Hành</h3>
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