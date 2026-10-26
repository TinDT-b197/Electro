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
    <title>Về Chúng Tôi - Electro</title>
    <?php include './partials/css.php'; ?>
    <style>
        .about-content {
            padding: 50px 0;
            background: #f8f9fa;
        }
        .about-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .about-box h1 {
            color: #D10024;
            margin-bottom: 30px;
            font-size: 36px;
            font-weight: bold;
            text-align: center;
        }
        .about-box h2 {
            color: #D10024;
            margin-top: 40px;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: 600;
            border-bottom: 3px solid #D10024;
            padding-bottom: 10px;
        }
        .about-box p {
            color: #666;
            line-height: 1.9;
            margin-bottom: 20px;
            font-size: 16px;
            text-align: justify;
        }
        .intro-section {
            background: linear-gradient(135deg, #D10024 0%, #e91e63 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }
        .intro-section h1 {
            color: white;
            margin-bottom: 20px;
        }
        .intro-section p {
            color: white;
            font-size: 18px;
            line-height: 1.8;
        }
        .value-card {
            background: #fff;
            border-left: 4px solid #D10024;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        .value-card:hover {
            transform: translateX(10px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .value-card h3 {
            color: #D10024;
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .value-card p {
            color: #666;
            margin-bottom: 0;
            text-align: left;
        }
        .mission-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 10px;
            margin: 30px 0;
            text-align: center;
        }
        .mission-box h2 {
            color: white;
            border: none;
            margin-top: 0;
        }
        .mission-box p {
            color: white;
            font-size: 18px;
        }
        .team-section {
            background: #e3f2fd;
            padding: 30px;
            border-radius: 10px;
            margin: 30px 0;
            text-align: center;
        }
        .team-section h2 {
            color: #D10024;
            margin-top: 0;
        }
        .team-section p {
            color: #666;
            font-size: 17px;
        }
        .quote-box {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 25px;
            margin: 30px 0;
            font-style: italic;
            border-radius: 5px;
        }
        .quote-box p {
            color: #856404;
            font-size: 18px;
            margin-bottom: 0;
            text-align: center;
        }
        .stats-row {
            display: flex;
            justify-content: space-around;
            margin: 40px 0;
            flex-wrap: wrap;
        }
        .stat-item {
            text-align: center;
            padding: 20px;
            flex: 1;
            min-width: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .stat-item i {
            font-size: 48px;
            color: #D10024;
            margin-bottom: 15px;
        }
        .stat-item h3 {
            font-size: 36px;
            color: #D10024;
            font-weight: bold;
            margin: 10px 0;
        }
        .stat-item p {
            color: #666;
            font-size: 16px;
            margin: 0;
        }
        .contact-cta {
            background: #D10024;
            color: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            margin-top: 40px;
        }
        .contact-cta h2 {
            color: white;
            border: none;
            margin-top: 0;
        }
        .contact-cta p {
            color: white;
            font-size: 18px;
            margin-bottom: 25px;
        }
        .contact-cta .btn {
            background: white;
            color: #D10024;
            padding: 15px 40px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .contact-cta .btn:hover {
            background: #f8f9fa;
            transform: scale(1.05);
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

    <!-- ABOUT CONTENT -->
    <div class="about-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Intro Section -->
                    <div class="intro-section">
                        <h1><i class="fa fa-heart"></i> VỀ CHÚNG TÔI</h1>
                        <p><strong>"UY TÍN TẠO NIỀM TIN"</strong></p>
                    </div>

                    <!-- Main About Box -->
                    <div class="about-box">
                        <h2><i class="fa fa-users"></i> Câu Chuyện Của Chúng Tôi</h2>
                        <p>
                            Chúng tôi là một nhóm gồm hai người trẻ, bắt đầu hành trình với cùng một niềm đam mê: 
                            mang đến cho khách hàng những thiết bị điện tử chất lượng, đáng tin cậy và phù hợp nhất với nhu cầu hằng ngày.
                        </p>
                        <p>
                            Khởi đầu từ những trải nghiệm thực tế khi mua sắm thiết bị điện tử – đôi khi khó khăn vì quá nhiều lựa chọn, 
                            sản phẩm không đúng như mong đợi hoặc dịch vụ chăm sóc khách hàng chưa tốt – chúng tôi quyết định tạo ra một 
                            cửa hàng minh bạch, nhiệt tình và thật sự đặt khách hàng làm trọng tâm.
                        </p>

                        <!-- Mission Box -->
                        <div class="mission-box">
                            <h2><i class="fa fa-bullseye"></i> Sứ Mệnh Của Chúng Tôi</h2>
                            <p>
                                Mang đến cho mọi người những sản phẩm công nghệ chất lượng, với mức giá hợp lý và thông tin rõ ràng.
                            </p>
                            <p>
                                Chúng tôi tin rằng công nghệ tốt không chỉ để "khoe cấu hình", mà phải tạo ra giá trị thật trong cuộc sống, 
                                giúp công việc hiệu quả hơn và cuộc sống tiện lợi hơn.
                            </p>
                        </div>

                        <h2><i class="fa fa-star"></i> Giá Trị Cốt Lõi</h2>

                        <!-- Value Cards -->
                        <div class="value-card">
                            <h3>👍 Chất Lượng Trước Tiên</h3>
                            <p>
                                Mỗi sản phẩm đều được chúng tôi kiểm tra, chọn lọc, đảm bảo đúng mô tả và có nguồn gốc rõ ràng. 
                                Chúng tôi chỉ bán những gì chúng tôi tin tưởng và sẵn sàng sử dụng cho chính mình.
                            </p>
                        </div>

                        <div class="value-card">
                            <h3>❤️ Phục Vụ Bằng Sự Chân Thành</h3>
                            <p>
                                Là một cửa hàng nhỏ, chúng tôi không chạy theo số lượng mà chú trọng thái độ phục vụ, 
                                hỗ trợ tận tâm như cách chúng tôi muốn được phục vụ. Mỗi khách hàng đến với Electro đều được 
                                lắng nghe, tư vấn chi tiết và đồng hành lâu dài.
                            </p>
                        </div>

                        <div class="value-card">
                            <h3>⚡ Nhanh Chóng – Minh Bạch</h3>
                            <p>
                                Từ tư vấn, báo giá đến bảo hành, mọi quy trình đều được thực hiện rõ ràng, không phí ẩn, 
                                và phản hồi nhanh nhất có thể. Chúng tôi tôn trọng thời gian của bạn như thời gian của chính mình.
                            </p>
                        </div>

                        <!-- Quote Box -->
                        <div class="quote-box">
                            <p>
                                <i class="fa fa-quote-left"></i>
                                "Chúng tôi không chỉ bán hàng, chúng tôi xây dựng niềm tin và tạo ra trải nghiệm mua sắm đáng nhớ cho mỗi khách hàng."
                                <i class="fa fa-quote-right"></i>
                            </p>
                        </div>

                        <!-- Stats Row -->
                        <h2><i class="fa fa-chart-line"></i> Con Số Ấn Tượng</h2>
                        <div class="stats-row">
                            <div class="stat-item">
                                <i class="fa fa-users"></i>
                                <h3>2</h3>
                                <p>Người Sáng Lập Trẻ</p>
                            </div>
                            <div class="stat-item">
                                <i class="fa fa-box"></i>
                                <h3>500+</h3>
                                <p>Sản Phẩm Chất Lượng</p>
                            </div>
                            <div class="stat-item">
                                <i class="fa fa-smile"></i>
                                <h3>1000+</h3>
                                <p>Khách Hàng Hài Lòng</p>
                            </div>
                            <div class="stat-item">
                                <i class="fa fa-headset"></i>
                                <h3>24/7</h3>
                                <p>Hỗ Trợ Nhiệt Tình</p>
                            </div>
                        </div>

                        <!-- Team Section -->
                        <div class="team-section">
                            <h2><i class="fa fa-handshake"></i> Cam Kết Của Chúng Tôi</h2>
                            <p>
                                ✅ Sản phẩm chính hãng 100%, có tem chống hàng giả<br>
                                ✅ Bảo hành đầy đủ theo chính sách nhà sản xuất<br>
                                ✅ Đổi trả trong 30 ngày nếu có bất kỳ vấn đề gì<br>
                                ✅ Tư vấn miễn phí, không ép buộc mua hàng<br>
                                ✅ Giao hàng nhanh chóng, đóng gói cẩn thận<br>
                                ✅ Hỗ trợ sau bán hàng tận tâm, lâu dài
                            </p>
                        </div>

                        <h2><i class="fa fa-road"></i> Hành Trình Phía Trước</h2>
                        <p>
                            Chúng tôi biết mình còn rất nhiều điều cần học hỏi và cải thiện. Nhưng với tinh thần không ngừng phấn đấu, 
                            lắng nghe phản hồi từ khách hàng và luôn đặt chất lượng lên hàng đầu, chúng tôi tin rằng Electro sẽ 
                            trở thành địa chỉ tin cậy cho những ai đang tìm kiếm thiết bị công nghệ phù hợp.
                        </p>
                        <p>
                            Cảm ơn bạn đã dành thời gian tìm hiểu về chúng tôi. Nếu có bất kỳ câu hỏi nào, đừng ngại liên hệ – 
                            chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ! 😊
                        </p>
                    </div>

                    <!-- Contact CTA -->
                    <div class="contact-cta">
                        <h2><i class="fa fa-phone"></i> Liên Hệ Với Chúng Tôi</h2>
                        <p>Bạn có câu hỏi hoặc cần tư vấn? Chúng tôi luôn sẵn sàng hỗ trợ!</p>
                        <p>
                            <strong>📞 Hotline:</strong> 0364200565<br>
                            <strong>📧 Email:</strong> electro@gmail.com<br>
                            <strong>📍 Địa chỉ:</strong> Đà Nẵng<br>
                            <strong>💬 Zalo:</strong> 0364200565
                        </p>
                        <a href="tel:0364200565" class="btn">
                            <i class="fa fa-phone"></i> Gọi Ngay: 0364200565
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /ABOUT CONTENT -->

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
</body>
</html>