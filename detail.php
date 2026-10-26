<?php
session_start();
include 'connect.php';
include './language.php';
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
} else {
    die("Error: ID not found");
}

// Truy vấn sản phẩm
$sql = "SELECT * FROM product_info WHERE ID = $id";
$kq = mysqli_query($conn, $sql);

// Truy vấn ảnh mô tả
$img_pro = mysqli_query($conn, "SELECT * FROM image_desc WHERE id_product = $id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Electro - HTML Ecommerce Template</title>
    <link rel="icon" href="./img/logo.png" type="image">
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="css/slick.css" />
    <link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link type="text/css" rel="stylesheet" href="css/grid.css" />

    <style>
		
        .grid__column-6 {
            padding-left: 5px;
            padding-right: 5px;
            width: 50%;
        }

        .grid__row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -5px;
            margin-right: -5px;
        }

        p img {
            border: 2px solid white;
            cursor: pointer;
        }

        p img:hover {
            border: 2px solid red;
        }

        /* Share Links Styling */
        .product-links {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
            padding: 20px 0;
            border-top: 1px solid #E4E7ED;
        }

        .product-links li:first-child {
            font-weight: 600;
            color: #2B2D42;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-links li {
            list-style: none;
        }

        .product-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f8f9fa;
            color: #6c757d;
            transition: all 0.3s ease;
            text-decoration: none;
			font-size: 18px !important;
    display: inline-block !important;
    visibility: visible !important;
        }

        .product-links a:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .product-links a.facebook-share:hover {
            background: #1877F2;
            color: white;
        }

        .product-links a.twitter-share:hover {
            background: #1DA1F2;
            color: white;
        }

        .product-links a.pinterest-share:hover {
            background: #E60023;
            color: white;
        }

        .product-links a.email-share:hover {
            background: #EA4335;
            color: white;
        }

        .product-links a.copy-link:hover {
            background: #28a745;
            color: white;
        }

        .product-links a i {
            font-size: 18px;
        }

        /* Toast notification for copy link */
        .copy-toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 99999;
            animation: slideInUp 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .copy-toast i {
            font-size: 20px;
        }

        /* Force show social icons */
.product-links li a {
    display: inline-flex !important;
}

.product-links li a i {
    display: inline-block !important;
    font-size: 18px !important;
    line-height: 40px;
}

/* Specific hover colors */
.product-links li:nth-child(2) a:hover {
    background: #1877F2 !important;
    color: white !important;
}

.product-links li:nth-child(3) a:hover {
    background: #1DA1F2 !important;
    color: white !important;
}

.product-links li:nth-child(4) a:hover {
    background: #E60023 !important;
    color: white !important;
}

.product-links li:nth-child(5) a:hover {
    background: #EA4335 !important;
    color: white !important;
}

.product-links li:nth-child(6) a:hover {
    background: #28a745 !important;
    color: white !important;
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

    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="./index.php">Home</a></li>
                        <li><a href="#">All Categories</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <div class="container">
            <div class="grid wide">
                <div class="row">
                    <!-- Product main img -->
                    <?php
                    $row = mysqli_fetch_array($kq);
                    ?>
                    <div class="col c-6 text-center">
                        <div>
                            <img src="./img/<?php echo $row["image_name"]; ?>" style="width:300px" id="main-img">
                        </div>
                    </div>

                    <div class="col c-6">
                        <?php
                        $sql = "SELECT * FROM product_info WHERE ID = $id";
                        $result = mysqli_query($conn, $sql);
                        $row_pro = mysqli_fetch_array($result);
                        
                        // Query related product
                        $query = mysqli_query($conn, "SELECT * FROM product_info WHERE category_id = '" . $row_pro['category_id'] . "' AND ID != $id ORDER BY RAND() LIMIT 4");
                        ?>

                        <div class="product-details">
                            <h2 class="product-name"><?php echo $row_pro["title"]; ?></h2>
                            
                            <div>
                                <h3 class="product-price">
                                    <?php echo format_currency($row_pro["new_price"]); ?> 
                                    <del class="product-old-price"><?php echo format_currency($row_pro["old_price"]); ?></del>
                                </h3>
                                <span class="product-available">In Stock</span>
                            </div>
                            <p><?php echo $row_pro["description"]; ?></p>

                            <form action="cart.php?action=add" method="post">
                                <div class="add-to-cart">
                                    <div class="qty-label">
                                        <input type="number" min="1" name="quantity[<?php echo $row_pro['ID'] ?>]" value="1" style="height:30px; width:40px; border:2px solid #e0ebeb">
                                    </div>
                                    <input type="submit" name="add-to-cart" class="add-to-cart-btn" value="Mua hàng" style="padding:0 10px;text-align:center;cursor:pointer">
                                </div>
                            </form>
                        </div>

                        <ul class="product-btns">
                            <li><a href="wishlist.php?id=<?php echo $row_pro['ID'] ?>"><i class="fa fa-heart-o"></i> add to wishlist</a></li>
                        </ul>

                        <ul class="product-links">
    <li>Share:</li>
    <li>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
           target="_blank" 
           class="facebook-share" 
           title="Share on Facebook">
        <i class="fa-brands fa-facebook-f"></i>
        </a>
    </li>
    <li>
        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($row_pro['title']); ?>" 
           target="_blank" 
           class="twitter-share" 
           title="Share on Twitter">
            <i class="fa-solid fa-x"></i>
        </a>
    </li>
    <li>
        <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&media=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . '/electro/img/' . $row_pro['image_name']); ?>&description=<?php echo urlencode($row_pro['title']); ?>" 
           target="_blank" 
           class="pinterest-share" 
           title="Share on Pinterest">
           <i class="fa-brands fa-pinterest"></i>
        </a>
    </li>
    <li>
        <a href="mailto:?subject=<?php echo urlencode($row_pro['title']); ?>&body=<?php echo urlencode('Check out this product: ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
           class="email-share" 
           title="Share via Email">
            <i class="fa fa-envelope"></i>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);" 
           onclick="copyToClipboard('<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>')" 
           class="copy-link" 
           title="Copy Link">
            <i class="fa fa-link"></i>
        </a>
    </li>
</ul>

                        <input type="hidden" name="image" value="<?php echo $row_pro["image_name"]; ?>">
                        <input type="hidden" name="name" value="<?php echo $row_pro["title"]; ?>">
                        <input type="hidden" name="newprice" value="<?php echo format_currency($row_pro["new_price"]); ?>">
                        <input type="hidden" name="oldprice" value="<?php echo format_currency($row_pro["old_price"]); ?>">
                    </div>
                </div>
            </div>

            <!-- Product Images -->
            <p>
                <?php 
                mysqli_data_seek($img_pro, 0);
                while($img = mysqli_fetch_array($img_pro)) { 
                ?>
                    <img src="./img/<?php echo $img['image'] ?>" alt="" style="width:150px">
                <?php } ?>
            </p>

            <!-- Product tab -->
            <div class="col-md-12">
                <div id="product-tab">
                    <ul class="tab-nav">
                        <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
                        <li><a data-toggle="tab" href="#tab3">Reviews</a></li>
                    </ul>
                    
                    <div class="tab-content">
                        <!-- tab1 -->
                        <div id="tab1" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><?php echo $row_pro["description"]; ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- tab3 -->
                        <div id="tab3" class="tab-pane fade in">
                            <h2>Bình Luận</h2>
                            <div class="row">
                                <!-- Reviews -->
                                <div class="col-md-8">
                                    <div id="reviews">
                                        <?php
                                        $sql_comment = "SELECT * FROM comment_user WHERE ID_product = $id";
                                        $kq_comment = mysqli_query($conn, $sql_comment);
                                        
                                        if(isset($_SESSION['user_id'])) {
                                            while ($row_comment = mysqli_fetch_array($kq_comment)) {
                                        ?>
                                            <ul class="reviews">
                                                <li>
                                                    <div class="review-heading">
                                                        <h5 class="name"><?php echo $row_comment['username'] ?></h5>
                                                        <p class="date"><?php echo $row_comment['datetime'] ?></p>
                                                    </div>
                                                    <div class="review-body" style="min-height:10px">
                                                        <p style="text-align:center"><?php echo $row_comment['Comment'] ?></p>
                                                    </div>
                                                </li>
                                                <?php if(!empty($row_comment['Rep_comment'])) { ?>
                                                <li>
                                                    <div style="min-height: 70px;">
                                                        <h5 class="name">
                                                            <i class="fa fa-play" style="margin-right: 4px;"></i>
                                                            admin
                                                        </h5>
                                                        <p style="color: #8D99AE;font-size: 10px;margin: 0;"><?php echo $row_comment['datetime'] ?></p>
                                                    </div>
                                                    <div class="review-body">
                                                        <p style="text-align:center"><?php echo $row_comment['Rep_comment'] ?></p>
                                                    </div>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        <?php 
                                            }
                                        } 
                                        ?>
                                    </div>
                                </div>

                                <!-- Review Form -->
                                <div class="col-md-4">
                                    <div id="review-form">
                                        <form action="comment.php?id=<?php echo $id; ?>" method="POST" class="review-form">
                                            <textarea required name="comment" class="input" placeholder="Your Review"></textarea>
                                            <button type="submit" name="submit" class="primary-btn">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /SECTION -->

    <!-- Section - Related Products -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h3 class="title">Sản phẩm liên quan</h3>
                    </div>
                </div>

                <?php while ($row_related = mysqli_fetch_array($query)) { ?>
                    <div class="col-md-3 col-xs-6">
                        <div class="product">
                            <div class="product-img">
                                <img src="./img/<?php echo $row_related["image_name"]; ?>" alt="">
                                <div class="product-label">
                                    <span class="sale">-30%</span>
                                </div>
                            </div>
                            <div class="product-body">
                                <p class="product-category">Category</p>
                                <h3 class="product-name">
                                    <a href="detail.php?id=<?php echo $row_related["ID"]; ?>">
                                        <?php echo $row_related["title"]; ?>
                                    </a>
                                </h3>
                                <h4 class="product-price">
                                    <?php echo format_currency($row_related["new_price"]); ?> 
                                    <del class="product-old-price"><?php echo format_currency($row_related["old_price"]); ?></del>
                                </h4>
                                <div class="product-rating"></div>
                                <div class="product-btns">
                                    <a href="wishlist.php?id=<?php echo $row_related["ID"]; ?>" class="add-to-wishlist">
                                        <i class="fa fa-heart-o"></i>
                                        <span class="tooltipp"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- /Section -->

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
                            <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-pinterest"></i></a></li>
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
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script>

    <script>

        // Click để thay đổi ảnh chính
        $('p img').click(function() {
            let imgPath = $(this).attr('src');
            $('#main-img').attr('src', imgPath);
        });
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
        
		// Copy to clipboard function
function copyToClipboard(text) {
    // Tạo temporary input
    const tempInput = document.createElement('input');
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    
    // Show toast notification
    const toast = `
        <div class="copy-toast">
            <i class="fa fa-check-circle"></i>
            <span>Đã copy link vào clipboard!</span>
        </div>
    `;
    $('body').append(toast);
    
    setTimeout(() => {
        $('.copy-toast').fadeOut(300, function() {
            $(this).remove();
        });
    }, 2000);
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
    
    function closeNotification() {
        $('.custom-notification').removeClass('show').addClass('hide');
        setTimeout(() => {
            $('.custom-notification').remove();
        }, 500);
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