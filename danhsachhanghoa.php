<?php
include 'connect.php';
include './language.php';
// Lấy các tham số từ URL
// Đảm bảo $iddm luôn là một giá trị đơn (string), không phải mảng
$iddm_param = isset($_GET["category_id"]) ? $_GET["category_id"] : '';
$iddm = is_array($iddm_param) ? end($iddm_param) : $iddm_param;

$brand_id = isset($_GET["brand_id"]) ? $_GET["brand_id"] : '';
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'default';

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$limit = 9;
$start = ($page - 1) * $limit;

// Xây dựng câu query với các điều kiện lọc
$where_conditions = array();

if (!empty($iddm)) {
    $where_conditions[] = "category_id = " . intval($iddm); // Lọc theo một ID
}

if (!empty($brand_id)) {
    $where_conditions[] = "brand_id = " . intval($brand_id);
}

$where_clause = "";
if (count($where_conditions) > 0) {
    $where_clause = "WHERE " . implode(" AND ", $where_conditions);
}

// Xây dựng mệnh đề ORDER BY
$order_by_clause = "ORDER BY ID DESC"; // Sắp xếp mặc định
switch ($sort_order) {
    case 'price_asc':
        // Sửa lỗi sắp xếp giá bằng cách chuyển về kiểu số
        $order_by_clause = "ORDER BY CAST(new_price AS UNSIGNED) ASC";
        break;
    case 'price_desc':
        // Sửa lỗi sắp xếp giá bằng cách chuyển về kiểu số
        $order_by_clause = "ORDER BY CAST(new_price AS UNSIGNED) DESC";
        break;
    case 'name_asc':
        // Sắp xếp tên từ A-Z (đơn giản hóa, bỏ COLLATE)
        $order_by_clause = "ORDER BY LOWER(title) ASC";
        break;
    case 'name_desc':
        // Sắp xếp tên từ Z-A (đơn giản hóa, bỏ COLLATE)
        $order_by_clause = "ORDER BY LOWER(title) DESC";
        break;
}

$total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM product_info $where_clause"));
$total_page = ceil($total / $limit);

$query = "SELECT * FROM product_info $where_clause $order_by_clause LIMIT " . $start . ", " . $limit;
$kq = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<link rel="icon" href="./img/logo.png" type="image">

<html lang="en">
<?php
session_start();
if (!function_exists('currency_format')) {
    function currency_format($number)
    {
        $currency = isset($_SESSION['currency']) ? $_SESSION['currency'] : 'VND';
        if (!empty($number)) {
            if ($currency == 'USD') {
                $number = $number / 24000;
                return '$' . number_format($number, 2, '.', ',');
            }
            return number_format($number, 0, ',', '.');
        }
    }
}
if (isset($_GET['currency'])) {
    $_SESSION['currency'] = $_GET['currency'];
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Electro</title>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .filter-btn {
            margin-top: 10px;
            width: 100%;
        }
        .clear-filter {
            margin-top: 10px;
            width: 100%;
            background-color: #dc3545;
        }
        .clear-filter:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <?php
    include './partials/header.php';
    ?>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <?php
    include './partials/menu.php';
    ?>
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
            <div class="row">
                <!-- ASIDE -->
                <div id="aside" class="col-md-3">
                    <!-- Form lọc -->
                    <form method="GET" action="danhsachhanghoa.php" id="filterForm">
                        
                        <!-- Categories Widget -->
                        <div class="aside">
                            <h3 class="aside-title">Categories</h3>
                            <div class="checkbox-filter">
                                <?php
                                $sql = "SELECT * FROM danhmuc_info";
                                $result = mysqli_query($conn, $sql);
                                $total_products_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM product_info");
                                $total_products = mysqli_fetch_assoc($total_products_query)['total'];
                                ?>

                                <div class="input-radio">
                                    <input type="radio" id="category-all" name="category_id" value=""
                                        <?php echo empty($iddm) ? 'checked' : ''; ?>>
                                    <label for="category-all">
                                        <span></span>
                                        Tất cả sản phẩm
                                        <small>(<?php echo $total_products; ?>)</small>
                                    </label>
                                </div>

                                <?php
                                $count = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    // Đếm số sản phẩm trong danh mục
                                    $count_sql = "SELECT COUNT(*) as total FROM product_info WHERE category_id = " . $row['id'];
                                    $count_result = mysqli_query($conn, $count_sql);
                                    $count_data = mysqli_fetch_assoc($count_result);
                                ?>
                                <div class="input-radio">
                                    <input type="radio" id="category-<?php echo $count; ?>" 
                                           name="category_id" value="<?php echo $row['id']; ?>"
                                           <?php echo ($iddm == $row['id']) ? 'checked' : ''; ?>>
                                    <label for="category-<?php echo $count; ?>">
                                        <span></span>
                                        <?php echo $row["tendanhmuc"]; ?>
                                        <small>(<?php echo $count_data['total']; ?>)</small>
                                    </label>
                                </div>
                                <?php
                                    $count++;
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /Categories Widget -->

                        <!-- Brand Widget -->
                        <div class="aside">
                            <h3 class="aside-title">Brand</h3>
                            <div class="checkbox-filter">
                                <?php
                                $brand_sql = "SELECT * FROM brand_info ORDER BY tenbrand";
                                $brand_result = mysqli_query($conn, $brand_sql);
                                ?>
                                
                                <div class="input-radio">
                                    <input type="radio" id="brand-all" name="brand_id" value=""
                                        <?php echo empty($brand_id) ? 'checked' : ''; ?>>
                                    <label for="brand-all">
                                        <span></span>
                                        Tất cả thương hiệu
                                    </label>
                                </div>
                                
                                <?php
                                $brand_count = 1;
                                while ($brand_row = mysqli_fetch_array($brand_result)) {
                                    // Đếm số sản phẩm của brand
                                    $count_sql = "SELECT COUNT(*) as total FROM product_info WHERE brand_id = " . $brand_row['id'];
                                    $count_result = mysqli_query($conn, $count_sql);
                                    $count_data = mysqli_fetch_assoc($count_result);
                                ?>
                                <div class="input-radio">
                                    <input type="radio" id="brand-<?php echo $brand_count; ?>" 
                                           name="brand_id" value="<?php echo $brand_row['id']; ?>"
                                           <?php echo ($brand_id == $brand_row['id']) ? 'checked' : ''; ?>>
                                    <label for="brand-<?php echo $brand_count; ?>">
                                        <span></span>
                                        <?php echo $brand_row['tenbrand']; ?>
                                        <small>(<?php echo $count_data['total']; ?>)</small>
                                    </label>
                                </div>
                                <?php
                                    $brand_count++;
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /Brand Widget -->

                        <!-- Filter Buttons -->
                        <button type="submit" class="primary-btn filter-btn" style="display: none;">Áp dụng lọc</button>
                        <a href="danhsachhanghoa.php" class="primary-btn clear-filter">Xóa bộ lọc</a>

                    </form>
                    <!-- /Form lọc -->

                    <!-- aside Widget -->
                    <div class="aside">
                        <h3 class="aside-title">Top selling</h3>
                        <?php
                        $top_selling_query = "
                            SELECT 
                                p.ID, 
                                p.title, 
                                p.image_name, 
                                p.new_price, 
                                p.old_price,
                                SUM(ou.Soluong) as total_sold
                            FROM product_info p
                            JOIN order_info ou ON p.ID = ou.ID_product
                            GROUP BY p.ID
                            ORDER BY total_sold DESC
                            LIMIT 3
                        ";
                        $top_selling_result = mysqli_query($conn, $top_selling_query);

                        if ($top_selling_result && mysqli_num_rows($top_selling_result) > 0) {
                            while ($product = mysqli_fetch_assoc($top_selling_result)) {
                        ?>
                        <!-- Bọc mỗi sản phẩm trong một div riêng -->
                        <div>
                            <div class="product-widget">
                                <div class="product-img">
                                    <img src="./img/<?php echo $product['image_name']; ?>" alt="">
                                </div>
                                <div class="product-body">
                                    <p class="product-category">Bán chạy</p>
                                    <h3 class="product-name"><a href="detail.php?id=<?php echo $product['ID']; ?>"><?php echo $product['title']; ?></a></h3>
                                    <h4 class="product-price"><?php echo currency_format($product['new_price']); ?> <del class="product-old-price"><?php echo currency_format($product['old_price']); ?></del></h4>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            echo "<p>Chưa có sản phẩm bán chạy.</p>";
                        }
                        ?>
                    </div>
                    <!-- /aside Widget -->
                </div>
                <!-- /ASIDE -->

                <!-- STORE -->
                <div id="store" class="col-md-9">
                    <!-- store top filter -->
                    <div class="store-filter clearfix">
                        <div class="store-sort">
                            <label>
                                Sắp xếp theo:
                                <select class="input-select" name="sort" form="filterForm">
                                    <option value="default" <?php echo ($sort_order == 'default') ? 'selected' : ''; ?>>Mặc định</option>
                                    <option value="price_asc" <?php echo ($sort_order == 'price_asc') ? 'selected' : ''; ?>>Giá: Thấp đến Cao</option>
                                    <option value="price_desc" <?php echo ($sort_order == 'price_desc') ? 'selected' : ''; ?>>Giá: Cao đến Thấp</option>
                                    <option value="name_asc" <?php echo ($sort_order == 'name_asc') ? 'selected' : ''; ?>>Tên: A-Z</option>
                                    <option value="name_desc" <?php echo ($sort_order == 'name_desc') ? 'selected' : ''; ?>>Tên: Z-A</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <!-- /store top filter -->

                    <!-- Hiển thị bộ lọc đang áp dụng -->
                    <?php if (!empty($iddm) || !empty($brand_id)) : ?>
                    <div class="store-filter clearfix" style="margin-bottom: 20px;">
                        <div style="padding: 10px; background: #f8f9fa; border-radius: 5px;">
                            <strong>Bộ lọc đang áp dụng: </strong>
                            <?php
                            if (!empty($iddm)) {
                                $cat_query = mysqli_query($conn, "SELECT tendanhmuc FROM danhmuc_info WHERE id = " . intval($iddm));
                                if ($cat_query && mysqli_num_rows($cat_query) > 0) {
                                    $cat_data = mysqli_fetch_assoc($cat_query);
                                    echo "<span class='label label-info'>Danh mục: " . $cat_data['tendanhmuc'] . "</span> ";
                                }
                            }
                            if (!empty($brand_id)) {
                                $brand_query = mysqli_query($conn, "SELECT tenbrand FROM brand_info WHERE id = " . intval($brand_id));
                                if ($brand_query && mysqli_num_rows($brand_query) > 0) {
                                    $brand_data = mysqli_fetch_assoc($brand_query);
                                    echo "<span class='label label-info'>Thương hiệu: " . $brand_data['tenbrand'] . "</span> ";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <!-- product -->
                        <?php
                        if (mysqli_num_rows($kq) == 0) {
                            echo "<div class='col-md-12'><p style='padding:20px; font-size:18px; color:red; text-align:center;'>Không tìm thấy sản phẩm nào phù hợp với bộ lọc.</p></div>";
                        }

                        while ($row = mysqli_fetch_array($kq)) {
                            // Lấy tên brand
                            $brand_name = "Category";
                            if (!empty($row['brand_id'])) {
                                $brand_query = mysqli_query($conn, "SELECT tenbrand FROM brand_info WHERE id = " . $row['brand_id']);
                                if ($brand_data = mysqli_fetch_assoc($brand_query)) {
                                    $brand_name = $brand_data['tenbrand'];
                                }
                            }
                        ?>
                        <div class="col-md-4 col-xs-6">
                            <div class="product">
                                <a href="detail.php?id=<?php echo $row['ID']; ?>">
                                    <div class="product-img">
                                        <img src="./img/<?php echo $row["image_name"]; ?>">
                                        <div class="product-label">
                                            <span class="sale">-30%</span>
                                            <span class="new">NEW</span>
                                        </div>
                                    </div>
                                </a>
                                <div class="product-body">
                                    <p class="product-category"><?php echo $brand_name; ?></p>
                                    <h3 class="product-name"><a
                                            href="detail.php?id=<?php echo $row["ID"]; ?>"><?php echo $row["title"]; ?></a>
                                    </h3>
                                    <h4 class="product-price"><?php echo currency_format($row["new_price"]); ?> <del
                                            class="product-old-price"><?php echo currency_format($row["old_price"]); ?></del>
                                    </h4>
                                    <div class="product-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="product-btns">
                                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span
                                                class="tooltipp">add to wishlist</span></button>
                                        <button class="add-to-compare"><i class="fa fa-exchange"></i><span
                                                class="tooltipp">add to compare</span></button>
                                        <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick
                                                view</span></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /product -->
                        <div class="clearfix visible-sm visible-xs"></div>
                        <?php
                        }
                        ?>
                    </div>

                    <!-- /store products -->

                    <!-- store bottom filter -->
                    <div class="store-filter clearfix">
                        <ul class="store-pagination">
                            <?php
                            // Xây dựng URL params cho pagination một cách chính xác
                            $params = [];
                            if (!empty($iddm)) $params['category_id'] = $iddm;
                            if (!empty($brand_id)) $params['brand_id'] = $brand_id;
                            if ($sort_order != 'default') $params['sort'] = $sort_order;
                            
                            $param_string = !empty($params) ? "&" . http_build_query($params) : "";

                            for ($i = 1; $i <= $total_page; $i++) {
                                echo '<li' . ($page == $i ? ' class="active"' : '') . '><a href="danhsachhanghoa.php?page=' . $i . $param_string . '" >' . $i . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <!-- /store bottom filter -->
                </div>
                <!-- /STORE -->
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
                        <p>Đăng kí để nhận <strong>THÔNG BÁO MỚI</strong></p>
                        <form>
                            <input class="input" type="email" placeholder="Enter Your Email">
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
                        </form>
                        <ul class="newsletter-follow">
                            <li>
                                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-brands fa-pinterest"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /NEWSLETTER -->

    <!-- FOOTER -->
    <?php
    include './partials/footer.php';
    ?>
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

            // Lắng nghe sự kiện thay đổi trên tất cả các radio button trong form
            filterForm.addEventListener('change', function(event) {
                if (event.target.type === 'radio') {
                    filterForm.submit();
                }
            });

            // Lắng nghe sự kiện thay đổi trên dropdown sắp xếp
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