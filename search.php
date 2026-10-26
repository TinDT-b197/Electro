<?php 
include 'connect.php';
include './language.php';
// Lấy từ khóa tìm kiếm
$tukhoa = "";
if (isset($_POST['tim_kiem']) && isset($_POST['tu_khoa'])) {
    $tukhoa = trim($_POST['tu_khoa']);
}
// Nếu có từ khóa trong GET (từ form header)
if (isset($_GET['tu_khoa'])) {
    $tukhoa = trim($_GET['tu_khoa']);
}

// Lấy các tham số lọc và sắp xếp
$iddm = isset($_GET["category_id"]) ? $_GET["category_id"] : '';
$brand_id = isset($_GET["brand_id"]) ? $_GET["brand_id"] : '';
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'default';

// Phân trang
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$limit = 9;
$start = ($page - 1) * $limit;

// Xây dựng câu query với các điều kiện
$where_conditions = array();

// Điều kiện tìm kiếm
if (!empty($tukhoa)) {
    $where_conditions[] = "title LIKE '%" . mysqli_real_escape_string($conn, $tukhoa) . "%'";
}

// Điều kiện lọc theo danh mục
if (!empty($iddm)) {
    $where_conditions[] = "category_id = " . intval($iddm);
}

// Điều kiện lọc theo thương hiệu
if (!empty($brand_id)) {
    $where_conditions[] = "brand_id = " . intval($brand_id);
}

$where_clause = "";
if (count($where_conditions) > 0) {
    $where_clause = "WHERE " . implode(" AND ", $where_conditions);
}

// Xây dựng mệnh đề ORDER BY
$order_by_clause = "ORDER BY ID DESC";
switch ($sort_order) {
    case 'price_asc':
        $order_by_clause = "ORDER BY CAST(new_price AS UNSIGNED) ASC";
        break;
    case 'price_desc':
        $order_by_clause = "ORDER BY CAST(new_price AS UNSIGNED) DESC";
        break;
    case 'name_asc':
        $order_by_clause = "ORDER BY LOWER(title) ASC";
        break;
    case 'name_desc':
        $order_by_clause = "ORDER BY LOWER(title) DESC";
        break;
}

// Đếm tổng số sản phẩm
$total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM product_info $where_clause"));
$total_page = ceil($total / $limit);

// Truy vấn sản phẩm với phân trang
$query = "SELECT * FROM product_info $where_clause $order_by_clause LIMIT " . $start . ", " . $limit;
$query_pro = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./img/logo.png" type="image">
    <title><?php echo t('search'); ?> - Electro</title>

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
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
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
                        <li><a href="./index.php"><?php echo t('home'); ?></a></li>
                        <li><a href="#"><?php echo t('search'); ?></a></li>
                        <?php if (!empty($tukhoa)): ?>
                        <li class="active"><?php echo t('search_for'); ?>: "<?php echo htmlspecialchars($tukhoa); ?>"</li>
                        <?php endif; ?>
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
                <!-- ASIDE -->
                <div id="aside" class="col-md-3">
                    <!-- Form lọc -->
                    <form id="filterForm" method="GET" action="search.php">
                        <!-- Giữ lại từ khóa tìm kiếm -->
                        <input type="hidden" name="tu_khoa" value="<?php echo htmlspecialchars($tukhoa); ?>">

                        <!-- Categories Widget -->
                        <div class="aside">
                            <h3 class="aside-title"><?php echo t('categories'); ?></h3>
                            <div class="checkbox-filter">
                                <?php
                                $categories = mysqli_query($conn, "SELECT * FROM danhmuc_info");
                                while ($cat = mysqli_fetch_array($categories)) {
                                    $checked = ($iddm == $cat['id']) ? 'checked' : '';
                                    echo '<div class="input-radio">
                                            <input type="radio" name="category_id" id="category-'.$cat['id'].'" value="'.$cat['id'].'" '.$checked.'>
                                            <label for="category-'.$cat['id'].'">
                                                <span></span>
                                                '.$cat['tendanhmuc'].'
                                            </label>
                                          </div>';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /Categories Widget -->

                        <!-- Brand Widget -->
                        <div class="aside">
                            <h3 class="aside-title"><?php echo t('brands'); ?></h3>
                            <div class="checkbox-filter">
                                <?php
                                // Query lấy brand từ bảng brand_info
                                $brands_query = "
                                    SELECT DISTINCT b.id, b.tenbrand 
                                    FROM brand_info b
                                    INNER JOIN product_info p ON b.id = p.brand_id
                                    WHERE b.id IS NOT NULL
                                    ORDER BY b.tenbrand
                                ";
                                $brands_result = mysqli_query($conn, $brands_query);
                                
                                if ($brands_result && mysqli_num_rows($brands_result) > 0) {
                                    while ($brand = mysqli_fetch_array($brands_result)) {
                                        $checked = ($brand_id == $brand['id']) ? 'checked' : '';
                                        
                                        echo '<div class="input-radio">
                                                <input type="radio" name="brand_id" id="brand-'.$brand['id'].'" value="'.$brand['id'].'" '.$checked.'>
                                                <label for="brand-'.$brand['id'].'">
                                                    <span></span>
                                                    '.htmlspecialchars($brand['tenbrand']).'
                                                </label>
                                              </div>';
                                    }
                                } else {
                                    echo '<p style="color:#999; font-size:14px;">Chưa có thương hiệu nào</p>';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /Brand Widget -->

                        <!-- Filter Buttons -->
                        <button type="submit" class="primary-btn filter-btn" style="display: none;"><?php echo t('apply_filter'); ?></button>
                        <a href="search.php?tu_khoa=<?php echo htmlspecialchars($tukhoa); ?>" class="primary-btn clear-filter"><?php echo t('clear_filter'); ?></a>

                    </form>
                    <!-- /Form lọc -->

                    <!-- Top Selling Widget -->
                    <div class="aside">
                        <h3 class="aside-title"><?php echo t('top_selling'); ?></h3>
                        <?php
                        // Sử dụng cột 'sold' trong product_info thay vì JOIN với orders
                        $top_selling_query = "
                            SELECT * FROM product_info 
                            WHERE sold IS NOT NULL 
                            ORDER BY CAST(sold AS UNSIGNED) DESC 
                            LIMIT 3
                        ";
                        $top_selling_result = mysqli_query($conn, $top_selling_query);

                        if ($top_selling_result && mysqli_num_rows($top_selling_result) > 0) {
                            while ($product = mysqli_fetch_assoc($top_selling_result)) {
                        ?>
                        <div class="product-widget">
                            <div class="product-img">
                                <img src="./img/<?php echo $product['image_name']; ?>" alt="">
                            </div>
                            <div class="product-body">
                                <p class="product-category"><?php echo t('category'); ?></p>
                                <h3 class="product-name"><a href="detail.php?id=<?php echo $product['ID']; ?>"><?php echo $product['title']; ?></a></h3>
                                <h4 class="product-price"><?php echo format_currency($product['new_price']); ?></h4>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            echo '<p style="color:#999; font-size:14px;">'.t('no_products_found').'</p>';
                        }
                        ?>
                    </div>
                    <!-- /Top Selling Widget -->
                </div>
                <!-- /ASIDE -->

                <!-- STORE -->
                <div id="store" class="col-md-9">
                    <!-- Store top filter -->
                    <div class="store-filter clearfix">
                        <div class="store-sort">
                            <label>
                                <?php echo t('sort_by'); ?>:
                                <select class="input-select" name="sort" form="filterForm">
                                    <option value="default" <?php echo ($sort_order == 'default') ? 'selected' : ''; ?>><?php echo t('default'); ?></option>
                                    <option value="price_asc" <?php echo ($sort_order == 'price_asc') ? 'selected' : ''; ?>><?php echo t('price_low_high'); ?></option>
                                    <option value="price_desc" <?php echo ($sort_order == 'price_desc') ? 'selected' : ''; ?>><?php echo t('price_high_low'); ?></option>
                                    <option value="name_asc" <?php echo ($sort_order == 'name_asc') ? 'selected' : ''; ?>><?php echo t('name_asc'); ?></option>
                                    <option value="name_desc" <?php echo ($sort_order == 'name_desc') ? 'selected' : ''; ?>><?php echo t('name_desc'); ?></option>
                                </select>
                            </label>
                        </div>
                        <div class="store-qty">
                            <span><?php echo t('showing'); ?> <?php echo mysqli_num_rows($query_pro); ?> <?php echo t('products'); ?></span>
                        </div>
                    </div>
                    <!-- /Store top filter -->

                    <!-- Store products -->
                    <div class="row">
                        <?php
                        if (mysqli_num_rows($query_pro) == 0) {
                            echo '<div class="col-md-12"><p style="text-align:center; padding:50px;">'.t('no_products_found').'</p></div>';
                        }
                        
                        while ($row = mysqli_fetch_array($query_pro)) {
                        ?>
                        <div class="col-md-4 col-xs-6">
                            <div class="product">
                                <a href="detail.php?id=<?php echo $row['ID']; ?>">
                                <div class="product-img">
                                    <img src="./img/<?php echo $row["image_name"]; ?>" alt="">
                                    <div class="product-label">
                                        <span class="sale">-30%</span>
                                        <span class="new">NEW</span>
                                    </div>
                                </div>
                                </a>
                                <div class="product-body">
                                    <p class="product-category"><?php echo t('category'); ?></p>
                                    <h3 class="product-name"><a href="detail.php?id=<?php echo $row["ID"]; ?>"><?php echo $row["title"]; ?></a></h3>
                                    <h4 class="product-price">
                                        <?php echo format_currency($row["new_price"]); ?>
                                        <del class="product-old-price"><?php echo format_currency($row["old_price"]); ?></del>
                                    </h4>
                                    <div class="product-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="product-btns">
                                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp"><?php echo t('add_to_wishlist'); ?></span></button>
                                        <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp"><?php echo t('add_to_compare'); ?></span></button>
                                        <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp"><?php echo t('quick_view'); ?></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- /Store products -->

                    <!-- Store bottom filter -->
                    <div class="store-filter clearfix">
                        <ul class="store-pagination">
                            <?php
                            for ($i = 1; $i <= $total_page; $i++) {
                                $params = $_GET;
                                $params['page'] = $i;
                                $query_string = http_build_query($params);
                                $active = ($page == $i) ? 'active' : '';
                                echo '<li class="'.$active.'"><a href="search.php?'.$query_string.'">'.$i.'</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <!-- /Store bottom filter -->
                </div>
                <!-- /STORE -->
            </div>
        </div>
    </div>
    <!-- /SECTION -->

    <!-- NEWSLETTER -->
    <div id="newsletter" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p><?php echo t('newsletter_text'); ?></p>
                        <form>
                            <input class="input" type="email" placeholder="<?php echo t('enter_your_email'); ?>">
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> <?php echo t('subscribe'); ?></button>
                        </form>
                        <ul class="newsletter-follow">
                            <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
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
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const sortSelect = document.querySelector('select[name="sort"]');

            filterForm.addEventListener('change', function(event) {
                if (event.target.type === 'radio') {
                    filterForm.submit();
                }
            });

            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    filterForm.submit();
                });
            }
        });
    </script>
    <?php include 'chatbot_widget.php'; ?>
    <?php include 'zalo_contact.php'; ?>
</body>
</html>
