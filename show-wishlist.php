<?php
session_start();
include 'connect.php';
include './language.php';
// Kiểm tra đăng nhập
if(!isset($_SESSION['user_id'])) {
    header('Location:login.php');
    exit();
}

$uid = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Wishlist - Electro</title>
    <link rel="icon" href="./img/logo.png" type="image">
    
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    
    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
    
    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="css/slick.css" />
    <link type="text/css" rel="stylesheet" href="css/slick-theme.css" />
    
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    
    <!-- Custom stylesheet -->
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    
    <style>
        .wishlist-actions {
            margin-top: 15px;
        }
        .wishlist-actions .primary-btn {
            margin: 5px;
            padding: 10px 20px;
            display: inline-block;
            text-decoration: none;
        }
        .btn-remove {
            background: #D10024;
        }
        .btn-remove:hover {
            background: #b5001f;
        }
        .empty-wishlist {
            text-align: center;
            padding: 50px 0;
        }
        .empty-wishlist i {
            font-size: 80px;
            color: #ccc;
            margin-bottom: 20px;
        }
        .empty-wishlist h3 {
            color: #666;
            margin-bottom: 20px;
        }

        /* Custom Notification Styles */
        .custom-notification {
            position: fixed;
            top: -100px;
            right: 30px;
            min-width: 350px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            z-index: 99999;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .custom-notification.show {
            top: 90px;
            animation: slideInDown 0.5s ease;
        }
        

        /* Custom Confirm Dialog */
.custom-confirm-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 99998;
    display: none;
    animation: fadeIn 0.3s ease;
}

.custom-confirm-overlay.show {
    display: flex !important;
    align-items: center;
    justify-content: center;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.custom-confirm-dialog {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    max-width: 450px;
    width: 90%;
    overflow: hidden;
    animation: scaleIn 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    position: relative;
}

@keyframes scaleIn {
    from {
        transform: scale(0.7);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.confirm-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 25px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.confirm-icon {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.confirm-title {
    flex: 1;
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.confirm-body {
    padding: 30px 25px;
    color: #333;
    font-size: 15px;
    line-height: 1.6;
}

.confirm-footer {
    padding: 20px 25px;
    background: #f8f9fa;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.confirm-btn {
    padding: 12px 30px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.confirm-btn-cancel {
    background: #6c757d;
    color: white;
}

.confirm-btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(108,117,125,0.4);
}

.confirm-btn-ok {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.confirm-btn-ok:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102,126,234,0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .custom-confirm-dialog {
        max-width: 350px;
    }
    
    .confirm-body {
        padding: 20px;
    }
    
    .confirm-footer {
        flex-direction: column;
    }
    
    .confirm-btn {
        width: 100%;
    }
}
        .custom-notification.hide {
            animation: slideOutUp 0.5s ease;
            top: -100px;
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideOutUp {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(-100%);
                opacity: 0;
            }
        }

        .notification-header {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f0f0f0;
        }

        .notification-header.success {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .notification-header.error {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .notification-header.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .notification-header.warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 15px;
        }

        .notification-title {
            flex: 1;
            font-weight: 600;
            font-size: 16px;
            margin: 0;
        }

        .notification-close {
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
            border-radius: 50%;
            transition: all 0.3s;
        }

        .notification-close:hover {
            background: rgba(255,255,255,0.2);
            transform: rotate(90deg);
        }

        .notification-body {
            padding: 20px;
            color: #333;
            font-size: 14px;
            line-height: 1.6;
        }

        .notification-progress {
            height: 4px;
            background: linear-gradient(90deg, #D10024, #ff6b6b);
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            animation: progressBar 3s linear;
        }

        @keyframes progressBar {
            from { width: 100%; }
            to { width: 0%; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .custom-notification {
                right: 15px;
                left: 15px;
                min-width: auto;
            }
            .custom-notification.show {
                top: 70px;
            }
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <?php include './partials/header.php'; ?>

    <!-- NAVIGATION -->
    <?php include './partials/menu.php'; ?>

    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="./index.php">Home</a></li>
                        <li class="active">Wishlist</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Danh sách yêu thích của bạn</h3>
                    </div>
                </div>
                
                <?php
                $sql = "SELECT w.*, p.* FROM wishlist w 
                        JOIN product_info p ON w.product_id = p.ID 
                        WHERE w.user_id = $uid 
                        ORDER BY w.timestamp DESC";
                $result = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                ?>
                    <!-- Product -->
                    <div class="col-md-3 col-xs-6">
                        <div class="product">
                            <div class="product-img">
                                <img src="./img/<?php echo $row["image_name"]; ?>" alt="" style="width:100%">
                                <div class="product-label">
                                    <span class="new">YÊU THÍCH</span>
                                </div>
                            </div>
                            <div class="product-body">
                                <p class="product-category">Category</p>
                                <h3 class="product-name">
                                    <a href="detail.php?id=<?php echo $row["ID"]; ?>">
                                        <?php echo $row["title"]; ?>
                                    </a>
                                </h3>
                                <h4 class="product-price">
                                    <?php echo format_currency($row["new_price"]); ?> 
                                    <del class="product-old-price"><?php echo format_currency($row["old_price"]); ?></del>
                                </h4>
                                <div class="product-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="product-btns">
                                    <button onclick="removeFromWishlist(<?php echo $row['product_id']; ?>)" class="add-to-wishlist" style="color: #D10024;">
                                        <i class="fa fa-heart"></i>
                                        <span class="tooltipp">remove from wishlist</span>
                                    </button>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                <a href="detail.php?id=<?php echo $row["ID"]; ?>" class="add-to-cart-btn">
                                    <i class="fa fa-shopping-cart"></i> Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /Product -->
                    
                <?php 
                    }
                } else {
                ?>
                    <!-- Empty Wishlist -->
                    <div class="col-md-12">
                        <div class="empty-wishlist">
                            <i class="fa fa-heart-o"></i>
                            <h3>Danh sách yêu thích trống!</h3>
                            <p>Bạn chưa có sản phẩm nào trong danh sách yêu thích.</p>
                            <a href="index.php" class="primary-btn">
                                <i class="fa fa-shopping-bag"></i> Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                    <!-- /Empty Wishlist -->
                <?php
                }
                ?>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- NEWSLETTER -->
    <div id="newsletter" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p>Đăng kí để nhận <strong>THÔNG BÁO MỚI NHẤT</strong></p>
                        <form>
                            <input class="input" type="email" placeholder="Nhập Email của bạn">
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Đăng kí</button>
                        </form>
                        <ul class="newsletter-follow">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /NEWSLETTER -->

    <!-- FOOTER -->
    <?php include './partials/footer.php'; ?>
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/main.js"></script>
    
    <script>
        // Hàm hiển thị notification đẹp
        function showNotification(title, message, type = 'success') {
            // Xóa notification cũ nếu có
            $('.custom-notification').remove();
            
            // Icon theo loại
            let icon = '';
            switch(type) {
                case 'success':
                    icon = '<i class="fa fa-check-circle"></i>';
                    break;
                case 'error':
                    icon = '<i class="fa fa-times-circle"></i>';
                    break;
                case 'warning':
                    icon = '<i class="fa fa-exclamation-triangle"></i>';
                    break;
                case 'info':
                    icon = '<i class="fa fa-info-circle"></i>';
                    break;
            }
            
            // Tạo notification HTML
            const notification = `
                <div class="custom-notification">
                    <div class="notification-header ${type}">
                        <div class="notification-icon">${icon}</div>
                        <h4 class="notification-title">${title}</h4>
                        <button class="notification-close" onclick="closeNotification()">×</button>
                    </div>
                    <div class="notification-body">${message}</div>
                    <div class="notification-progress"></div>
                </div>
            `;
            
            // Thêm vào body
            $('body').append(notification);
            
            // Show với animation
            setTimeout(() => {
                $('.custom-notification').addClass('show');
            }, 100);
            
            // Auto hide sau 3 giây
            setTimeout(() => {
                closeNotification();
            }, 3000);
        }
        
        // Đóng notification
        function closeNotification() {
            $('.custom-notification').removeClass('show').addClass('hide');
            setTimeout(() => {
                $('.custom-notification').remove();
            }, 500);
        }
        
        // Custom Confirm Dialog
        function showConfirm(title, message, onConfirm) {
            // Xóa dialog cũ nếu có
            $('.custom-confirm-overlay').remove();
            
            // Tạo confirm dialog HTML
            const confirmDialog = `
                <div class="custom-confirm-overlay show">
                    <div class="custom-confirm-dialog">
                        <div class="confirm-header">
                            <div class="confirm-icon">
                                <i class="fa fa-question-circle"></i>
                            </div>
                            <h4 class="confirm-title">${title}</h4>
                        </div>
                        <div class="confirm-body">${message}</div>
                        <div class="confirm-footer">
                            <button class="confirm-btn confirm-btn-cancel" onclick="closeConfirm()">
                                <i class="fa fa-times"></i> Hủy
                            </button>
                            <button class="confirm-btn confirm-btn-ok" onclick="confirmAction()">
                                <i class="fa fa-check"></i> Đồng ý
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            // Thêm vào body
            $('body').append(confirmDialog);
            
            // Lưu callback
            window.confirmCallback = onConfirm;
        }
        
        // Đóng confirm dialog
        function closeConfirm() {
            $('.custom-confirm-overlay').removeClass('show');
            setTimeout(() => {
                $('.custom-confirm-overlay').remove();
            }, 300);
        }
        
        // Xác nhận action
        function confirmAction() {
            if (window.confirmCallback) {
                window.confirmCallback();
            }
            closeConfirm();
        }
        
        // Đóng khi click overlay
        $(document).on('click', '.custom-confirm-overlay', function(e) {
            if ($(e.target).hasClass('custom-confirm-overlay')) {
                closeConfirm();
            }
        });
        
        // Xóa khỏi wishlist với custom confirm
        function removeFromWishlist(productId) {
            showConfirm(
                'Xác nhận xóa',
                'Bạn có chắc muốn xóa sản phẩm này khỏi danh sách yêu thích?',
                function() {
                    showNotification(
                        'Đang xử lý...', 
                        'Đang xóa sản phẩm khỏi danh sách yêu thích', 
                        'info'
                    );
                    
                    // Redirect sau 1 giây
                    setTimeout(() => {
                        window.location.href = 'wishlist.php?id=' + productId;
                    }, 1000);
                }
            );
        }
        
        // Kiểm tra có notification trong session không
        $(document).ready(function() {
            <?php 
            if(isset($_SESSION['notification'])) {
                $notif = $_SESSION['notification'];
                echo "showNotification('{$notif['title']}', '{$notif['message']}', '{$notif['type']}');";
                unset($_SESSION['notification']);
            }
            ?>
        });
    </script>

    <?php include 'chatbot_widget.php'; ?>
    <?php include 'zalo_contact.php'; ?>
</body>
</html>