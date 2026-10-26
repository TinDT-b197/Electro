<?php session_start(); ?>
<!DOCTYPE html>
<link rel="icon" href="./img/logo.png" type="image">

<?php

include 'connect.php';
include './language.php';
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$error = false;
$success = false;
if (isset($_GET['action'])) {

    function update_cart($add = false)
    {
        foreach ($_POST['quantity'] as $id => $quantity) {
            if ($quantity == 0) {
                unset($_SESSION['cart'][$id]);
            } else {
                if ($add) {

                    $_SESSION['cart'][$id] += $quantity;
                } else {
                    $_SESSION['cart'][$id] = $quantity;
                }
            }
        }
    }
    if (isset($_SESSION['user_id'])) {
        switch ($_GET['action']) {
            case "add":
                update_cart(true);
                header('Location:./cart.php');

                break;
            case "delete":
                if (isset($_GET['id'])) {
                    unset($_SESSION['cart'][$_GET['id']]);
                }
                header('Location:./cart.php');
                break;
            case "submit":
                if (isset($_POST['update_click'])) {
                    update_cart();
                    header('Location:./cart.php');
                } else if ($_POST['order_click']) {
                    if (empty($_POST['name'])) {
                        $error = "Bạn chưa nhập tên người nhận";
                    } else if (empty($_POST['phone'])) {
                        $error = "Bạn chưa nhập số điện thoại người nhận";
                    } else if (empty($_POST['address'])) {
                        $error = "Bạn chưa nhập địa chỉ người nhận";
                    } else if (empty($_POST['quantity'])) {
                        $error = "Giỏ hàng rỗng";
                    }
                    if ($error == false && !empty($_POST['quantity'])) {
                        $products = mysqli_query($conn, "SELECT * FROM product_info WHERE id IN (" . implode(",", array_keys($_POST['quantity'])) . ")");
                        $total = 0;
                        $orderProduct = array();
                        while ($row = mysqli_fetch_array($products)) {
                            $amount = $row['amount'];
                            $sold = $row['sold'];
                            $orderProduct[] = $row;
                            $total += $row['new_price'] * $_POST['quantity'][$row['ID']];
                        }
                        
                        // Thêm phí vận chuyển
                        $shippingFee = isset($_POST['shipping_fee']) ? (int)$_POST['shipping_fee'] : 0;
                        $grandTotal = $total + $shippingFee;
                        
                        $payment_method = $_POST['payment_method'];
                        $tienCoc = 0;

                        if ($payment_method === 'cod') {
                            $tienCoc = round($grandTotal * 0.1);
                        }
                        
                        $date = date("Y-m-d H:i:s");
                        $uid = $_SESSION['user_id'];
                        
                        // INSERT với phí vận chuyển
                        $insertOrder = mysqli_query($conn, "INSERT INTO `order_user` (`ID_order`, `ID_user`, `Hoten`, `SDT`, `DiaChi`, `GhiChu`, `NgayDat`, `Tongtien`, `PhiVanChuyen`) VALUES (NULL, '$uid', '{$_POST['name']}', '{$_POST['phone']}', '{$_POST['address']}', '{$_POST['note']}', '$date', '$grandTotal', '$shippingFee')");
                        
                        // KIỂM TRA LỖI KHI INSERT ORDER_USER
                        if (!$insertOrder) {
                            die("Lỗi khi tạo đơn hàng: " . mysqli_error($conn));
                        }
                        
                        // LẤY ID_ORDER VỪA TẠO
                        $orderID = mysqli_insert_id($conn);
                        
                        // KIỂM TRA XEM CÓ LẤY ĐƯỢC ID KHÔNG
                        if ($orderID == 0 || empty($orderID)) {
                            die("Lỗi: Không lấy được ID đơn hàng. ID_order = " . $orderID);
                        }
                        
                        // HIỂN thị để debug
                        // echo "Order ID vừa tạo: " . $orderID; exit;

                        // Tạo danh sách giá trị cần chèn vào order_info
                        $insertValues = [];
                        foreach ($orderProduct as $product) {
                            $productID = $product['ID'];
                            $quantity = $_POST['quantity'][$productID];
                            $price = $product['new_price'];
                            
                            $insertValues[] = "(NULL, '$orderID', '$productID', '$quantity', '$price', '$date')";
                        }

                        $insertString = implode(",", $insertValues);
                        
                        // INSERT VÀO order_info
                        $insertOrderInfo = mysqli_query($conn, "INSERT INTO `order_info` (`id`, `ID_order`, `ID_product`, `Soluong`, `Gia`, `NgayDat`) VALUES $insertString");

                        if (!$insertOrderInfo) {
                            die("Lỗi khi thêm chi tiết đơn hàng: " . mysqli_error($conn));
                        }

                        // Cập nhật số lượng tồn kho và đã bán
                        foreach ($orderProduct as $product) {
                            $productID = $product['ID'];
                            $quantity = $_POST['quantity'][$productID];
                            $newAmount = $product['amount'] - $quantity;
                            $newSold = $product['sold'] + $quantity;
                            
                            mysqli_query($conn, "UPDATE product_info SET amount = '$newAmount', sold = '$newSold' WHERE ID = '$productID'");
                        }

                        // Xác nhận thành công
                        $success = "Đặt hàng thành công";
                        unset($_SESSION['cart']);

                }
                }
                break;
        }
    } else {
        header("Location:login.php");
    }
}
if (!empty($_SESSION["cart"])) {
    $products = mysqli_query($conn, "SELECT * FROM product_info WHERE id IN (" . implode(",", array_keys($_SESSION['cart'])) . ")");
}



?>
<html lang="en">

<head>
    <?php include './partials/css.php'; ?>
    <style>
        body {
            font-family: arial;
        }

        * {
            box-sizing: border-box;
        }

        .container {
            width: 1200px;
            margin: 0 auto;
        }

        h1 {
            padding-top: 20px;
            text-align: center;
        }

        .product-items {
            border: 1px solid #b91212ff;
            padding: 30px;
        }

        .product-item {
            float: left;
            width: 23%;
            margin: 1%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #000;
            line-height: 26px;
        }

        .product-item label {
            font-weight: bold;
        }

        .product-item p {
            margin: 0;
            line-height: 26px;
            max-height: 52px;
            overflow: hidden;
        }

        .product-price {
            color: red;
            font-weight: bold;
        }

        .product-img {
            padding: 5px;
            border: 1px solid #000;
            margin-bottom: 5px;
        }

        .product-item img {
            max-width: 100%;
        }

        .product-item ul {
            margin: 0;
            padding: 0;
            border-right: 1px solid #000;
        }

        .product-item ul li {
            float: left;
            width: 33.3333%;
            list-style: none;
            text-align: center;
            border: 1px solid #000;
            border-right: 0;
            box-sizing: border-box;
        }

        .clear-both {
            clear: both;
        }

        a {
            text-decoration: none;
        }

        .buy-button {
            text-align: right;
            margin-top: 10px;
        }

        .buy-button a {
            background: #444;
            padding: 5px;
            color: #fff;
        }

        #pagination {
            text-align: right;
            margin-top: 15px;
        }

        .page-item {
            border: 1px solid #000;
            padding: 5px 9px;
            color: #000;
        }

        .current-page {
            background: #000;
            color: #FFF;
        }

        #product-detail {
            border-top: 1px solid #000;
            padding: 15px 0 0 0;
        }

        #product-img {
            width: 30%;
            float: left;
        }

        #product-info {
            float: right;
            width: 70%;
            text-align: left;
            padding-left: 30px;
        }

        #product-img img {
            max-width: 100%;
            padding: 5px;
            border: 1px solid #000;
            background: #eee;
        }

        h1 {
            text-align: left;
            margin-top: 0;
        }

        label.add-to-cart {
            background: #000;
            border: 1px solid #000;
            margin-top: 15px;
            padding: 15px;
            display: inline-block;
            color: #fff;
        }

        label a {
            color: #FFF;
        }

        #gallery {
            margin-top: 10px;
        }

        #gallery ul {
            margin: 0;
            padding: 0;
        }

        #gallery ul li {
            width: 150px;
            float: left;
            list-style: none;
            margin-right: 5px;
            margin-bottom: 5px;
            height: 100px;
            text-align: center;
            padding: 5px;
            border: 1px solid #000;
            background: #eee;
        }

        #gallery ul li img {
            max-width: 100%;
            max-height: 100%;
            vertical-align: middle;
        }

        table {
            border-collapse: collapse;
            width: 1170px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        table .product-img img {
            max-width: 100px;
        }

        table .product-name {
            width: 350px;
            padding-left: 20px;
        }

        table .product-img {
            width: 120px;
            text-align: center;
        }

        table .product-number {
            width: 50px;
            text-align: center;
        }

        table .product-price {
            width: 100px;
            text-align: center;
        }

        table .product-quantity input {
            width: 40px;
            text-align: center;
        }

        table .product-quantity {
            width: 60px;
            text-align: center;
        }

        table .total-money {
            width: 100px;
            text-align: center;
        }

        #form-button {
            text-align: right;
            margin-top: 15px;
        }

        .product-delete {
            width: 100px;
            text-align: center;
        }

        #cart-form label {
            width: 100px;
            display: inline-block;
            margin-top: 15px;
        }

        #cart-form textarea {
            margin-top: 15px;
        }

        #cart-form input {
            line-height: 30px;
            height: 30px;
        }

        input[name="order_click"] {
            margin-top: 15px;
        }

        .button {
            width: 126px;
            height: 52px;
            font-size: 16px;
            color: #fff;
            background-color: #D10024;
            border: 2px solid #D10024;
            padding-bottom: 34px;
            font-weight: 700;
        }

        #row-total {
            background: #eee;
            color: #000;
        }

        #add-to-cart-form input[type='text'] {
            margin-top: 10px;
            height: 30px;
            line-height: 30px;
        }

        #add-to-cart-form input[type='submit'] {
            background: #000;
            border: 1px solid #000;
            margin-top: 10px;
            padding: 15px;
            display: inline-block;
            color: #fff;
        }

        #qr-code-container {
            display: none;
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        #qr-code-container.show {
            display: block;
        }

        #qr-code-container h3 {
            color: #D10024;
            margin-bottom: 15px;
        }

        #qr-code-container img {
            max-width: 300px;
            margin: 15px auto;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            background: white;
        }

        .qr-info {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            text-align: left;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .qr-info p {
            margin: 8px 0;
            line-height: 1.6;
        }

        .qr-info strong {
            color: #333;
            display: inline-block;
            width: 140px;
        }

        .copy-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
            font-size: 12px;
        }

        .copy-btn:hover {
            background: #218838;
        }

        #deposit-info, #payment-info {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #D10024;
            margin-top: 15px;
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

    <div class="container">
        <?php if (!empty($error)) { ?>
            <div id="notify-msg">
                <?php echo $error ?>. <a href="javascript:history.back()">Quay lại</a>
            </div>
        <?php } else if (!empty($success)) { ?>
            <div id="notify-msg" style="text-align:center; font-size:28px; font-weight:bold; color:#28a745; margin-top:40px;">
    <?php if($sold < $amount) {?>     
        ✅ <?php echo $success ?>!<br>
        <a href="index.php" style="font-size:20px; color:#007bff; text-decoration:underline;">Tiếp tục mua hàng</a>
    <?php } else { ?>
        ❌ <span style="color:red;">Sản phẩm đã hết hàng.</span><br>
        <a href="index.php" style="font-size:18px; color:#007bff;">Quay lại trang chủ</a>
    <?php } ?>
</div>

        <?php  } else { ?>
            <h1><?php echo t('shopping_cart'); ?></h1>
            
            <?php if (empty($_SESSION['cart']) || empty($products)) { ?>
                <!-- Giỏ hàng trống -->
                <div style="text-align:center; padding:80px 20px; background:#f8f9fa; border-radius:10px; margin:40px 0;">
                    <div style="font-size:80px; color:#ccc; margin-bottom:20px;">🛒</div>
                    <h2 style="color:#666; font-size:28px; margin-bottom:15px;">Giỏ hàng của bạn đang trống</h2>
                    <p style="color:#999; font-size:16px; margin-bottom:30px;">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                    <a href="index.php" style="display:inline-block; background:#D10024; color:#fff; padding:15px 40px; text-decoration:none; border-radius:5px; font-size:18px; font-weight:bold;">
                        🏠 Quay về trang chủ
                    </a>
                </div>
            <?php } else { ?>
                <!-- Form giỏ hàng -->
            <form id="cart-form" action="cart.php?action=submit" method="POST">
                <table>
                    <tr>
    <th class="product-number"><?php echo t('stt'); ?></th>
    <th class="product-name"><?php echo t('product_name'); ?></th>
    <th class="product-img"><?php echo t('image'); ?></th>
    <th class="product-price"><?php echo t('price'); ?></th>
    <th class="product-quantity"><?php echo t('quantity'); ?></th>
    <th class="total-money"><?php echo t('subtotal'); ?></th>
    <th class="product-delete"><?php echo t('delete'); ?></th>
</tr>
                    <?php
                    if (!empty($products)) {
                        $total = 0;
                        $num = 1;
                        while ($row = mysqli_fetch_array($products)) {


                    ?>
                            <tr>
                                <td class="product-number"><?php echo $num++; ?></td>
                                <td class="product-name"><?php echo $row['title']; ?></td>
                                <td class="product-img"><img src="./img/<?php echo $row["image_name"]; ?>"></td>
                                <td class="product-price"><?php echo  format_currency($row["new_price"]); ?></td>
                                <td class="product-quantity"><input type="number" value="<?php echo $_SESSION['cart'][$row['ID']] ?>" name="quantity[<?php echo $row['ID'] ?>]"></td>
                                <td class="total-money"><?php echo format_currency($row["new_price"] * $_SESSION['cart'][$row['ID']]); ?></td>
                                <td class="product-delete"><a href="cart.php?action=delete&id=<?php echo $row['ID'] ?>"><?php echo t('delete'); ?></a></td>
                            </tr>
                        <?php
                            $total += $row["new_price"] * $_SESSION['cart'][$row['ID']];
                        }
                        ?>
                        <tr id="row-total">
                            <td class="product-number">&nbsp;</td>
                            <td class="product-name"><b><?php echo t('total'); ?></b></td>
                            <td class="product-img">&nbsp;</td>
                            <td class="product-price">&nbsp;</td>
                            <td class="product-quantity">&nbsp;</td>
                            <td class="total-money" data-raw-total="<?php echo $total; ?>"><b><?php echo format_currency($total); ?></b></td>
                            <td></td>
                        </tr>
                    <?php
                    }

                    ?>

                </table>
                <div id="form-button">
                    <input type="submit" class="button" name="update_click" value="<?php echo t('update'); ?>">
                </div>
                <hr>
                
                <!-- Thông tin giao hàng -->
                <h3 style="color:#D10024; margin-top:30px;">📦 Thông tin giao hàng</h3>
                <div><label><?php echo t('recipient'); ?>:</label><input type="text" value="" name="name" required></div>
                <div><label><?php echo t('phone'); ?>:</label><input type="text" value="" name="phone" required></div>
                <div><label><?php echo t('address'); ?>:</label><input type="text" value="" name="address" id="address-input" required></div>
                
                <!-- Chọn Tỉnh/Thành phố -->
                <div style="margin-top: 20px;">
                    <label style="display:block; font-weight:bold; margin-bottom:10px;">🌍 Chọn Tỉnh/Thành phố:</label>
                    <select name="city" id="city-select" style="width:300px; height:35px; margin-left:110px;" required onchange="updateShippingFee()">
                        <option value="">-- Chọn Tỉnh/Thành phố --</option>
                        <optgroup label="Nhận tại cửa hàng">
                            <option value="0" data-fee="0" data-city="danang">Nhận tại cửa hàng Đà Nẵng</option>
                        </optgroup>
                        <optgroup label="Nội thành Đà Nẵng (40.000đ - Miễn phí ≥5tr)">
                            <option value="40000" data-fee="40000" data-city="danang">Đà Nẵng</option>
                        </optgroup>
                        <optgroup label="Miền Trung (45.000đ)">
                            <option value="45000" data-fee="45000">Quảng Nam</option>
                            <option value="45000" data-fee="45000">Quảng Ngãi</option>
                            <option value="45000" data-fee="45000">Thừa Thiên Huế</option>
                            <option value="45000" data-fee="45000">Quảng Bình</option>
                            <option value="45000" data-fee="45000">Quảng Trị</option>
                        </optgroup>
                        <optgroup label="Hà Nội, TP.HCM (50.000đ)">
                            <option value="50000" data-fee="50000">Hà Nội</option>
                            <option value="50000" data-fee="50000">Hồ Chí Minh</option>
                        </optgroup>
                        <optgroup label="Các tỉnh khác (70.000đ)">
                            <option value="70000" data-fee="70000">An Giang</option>
                            <option value="70000" data-fee="70000">Bà Rịa - Vũng Tàu</option>
                            <option value="70000" data-fee="70000">Bạc Liêu</option>
                            <option value="70000" data-fee="70000">Bắc Giang</option>
                            <option value="70000" data-fee="70000">Bắc Kạn</option>
                            <option value="70000" data-fee="70000">Bắc Ninh</option>
                            <option value="70000" data-fee="70000">Bến Tre</option>
                            <option value="70000" data-fee="70000">Bình Dương</option>
                            <option value="70000" data-fee="70000">Bình Định</option>
                            <option value="70000" data-fee="70000">Bình Phước</option>
                            <option value="70000" data-fee="70000">Bình Thuận</option>
                            <option value="70000" data-fee="70000">Cà Mau</option>
                            <option value="70000" data-fee="70000">Cao Bằng</option>
                            <option value="70000" data-fee="70000">Cần Thơ</option>
                            <option value="70000" data-fee="70000">Đắk Lắk</option>
                            <option value="70000" data-fee="70000">Đắk Nông</option>
                            <option value="70000" data-fee="70000">Điện Biên</option>
                            <option value="70000" data-fee="70000">Đồng Nai</option>
                            <option value="70000" data-fee="70000">Đồng Tháp</option>
                            <option value="70000" data-fee="70000">Gia Lai</option>
                            <option value="70000" data-fee="70000">Hà Giang</option>
                            <option value="70000" data-fee="70000">Hà Nam</option>
                            <option value="70000" data-fee="70000">Hà Tĩnh</option>
                            <option value="70000" data-fee="70000">Hải Dương</option>
                            <option value="70000" data-fee="70000">Hải Phòng</option>
                            <option value="70000" data-fee="70000">Hậu Giang</option>
                            <option value="70000" data-fee="70000">Hòa Bình</option>
                            <option value="70000" data-fee="70000">Hưng Yên</option>
                            <option value="70000" data-fee="70000">Khánh Hòa</option>
                            <option value="70000" data-fee="70000">Kiên Giang</option>
                            <option value="70000" data-fee="70000">Kon Tum</option>
                            <option value="70000" data-fee="70000">Lai Châu</option>
                            <option value="70000" data-fee="70000">Lâm Đồng</option>
                            <option value="70000" data-fee="70000">Lạng Sơn</option>
                            <option value="70000" data-fee="70000">Lào Cai</option>
                            <option value="70000" data-fee="70000">Long An</option>
                            <option value="70000" data-fee="70000">Nam Định</option>
                            <option value="70000" data-fee="70000">Nghệ An</option>
                            <option value="70000" data-fee="70000">Ninh Bình</option>
                            <option value="70000" data-fee="70000">Ninh Thuận</option>
                            <option value="70000" data-fee="70000">Phú Thọ</option>
                            <option value="70000" data-fee="70000">Phú Yên</option>
                            <option value="70000" data-fee="70000">Quảng Ninh</option>
                            <option value="70000" data-fee="70000">Sóc Trăng</option>
                            <option value="70000" data-fee="70000">Sơn La</option>
                            <option value="70000" data-fee="70000">Tây Ninh</option>
                            <option value="70000" data-fee="70000">Thái Bình</option>
                            <option value="70000" data-fee="70000">Thái Nguyên</option>
                            <option value="70000" data-fee="70000">Thanh Hóa</option>
                            <option value="70000" data-fee="70000">Tiền Giang</option>
                            <option value="70000" data-fee="70000">Trà Vinh</option>
                            <option value="70000" data-fee="70000">Tuyên Quang</option>
                            <option value="70000" data-fee="70000">Vĩnh Long</option>
                            <option value="70000" data-fee="70000">Vĩnh Phúc</option>
                            <option value="70000" data-fee="70000">Yên Bái</option>
                        </optgroup>
                    </select>
                    <span id="shipping-fee-text" style="margin-left:10px; font-weight:bold;"></span>
                    <input type="hidden" name="shipping_fee" id="shipping-fee-input" value="0">
                    <div id="free-ship-status" style="margin-top:8px; margin-left:110px;"></div>
                </div>

                <!-- Hiển thị tổng cộng -->
                <div style="background:#f8f9fa; padding:20px; margin-top:20px; border-radius:8px; border:2px solid #D10024;">
                    <table style="width:100%; border:none;">
                        <tr style="border:none;">
                            <td style="border:none; padding:10px; font-size:16px;">Tổng tiền hàng:</td>
                            <td style="border:none; padding:10px; text-align:right; font-size:16px;" id="product-total">
                                <strong><?php echo format_currency($total); ?></strong>
                            </td>
                        </tr>
                        <tr style="border:none;">
                            <td style="border:none; padding:10px; font-size:16px;">Phí vận chuyển:</td>
                            <td style="border:none; padding:10px; text-align:right; font-size:16px;" id="shipping-total">
                                <strong></strong>
                            </td>
                        </tr>
                        <tr style="border:none; border-top:2px solid #D10024;">
                            <td style="border:none; padding:15px; font-size:20px; color:#D10024;"><strong>TỔNG CỘNG:</strong></td>
                            <td style="border:none; padding:15px; text-align:right; font-size:22px; color:#D10024;" id="grand-total" data-raw-total="<?php echo $total; ?>">
                                <strong><?php echo format_currency($total); ?></strong>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div><label><?php echo t('note'); ?>:</label><textarea name="note" id="" cols="50" rows="7"></textarea></div>
                
                <div>
                    <label><?php echo t('payment_method'); ?>:</label>
                    <select name="payment_method" id="payment-method">
                        <option value="cod"><?php echo t('pay_on_delivery'); ?></option>
                        <option value="bank"><?php echo t('bank_transfer'); ?></option>
                        <option value="qr"><?php echo t('qr_code'); ?></option>
                    </select>
                </div>

                <!-- Thông tin đặt cọc COD -->
                <div id="deposit-info" style="display:none;">
                    <p style="font-weight:bold; color:#D10024;">💰 <?php echo t('deposit_amount'); ?>: <span id="deposit-amount"></span> ₫</p>
                    <p><?php echo t('transfer_info'); ?></p>
                    <div class="qr-info">
                        <p><strong>🏦<?php echo t('bank'); ?>:</strong> MBBank</p>
                        <p><strong>💳<?php echo t('account_number'); ?>:</strong> 0364200565 
                            <button type="button" class="copy-btn" onclick="copyText('0364200565')">Copy</button>
                        </p>
                        <p><strong>👤 <?php echo t('account_holder'); ?>:</strong> Nguyen Tran Ngoc Anh</p>
                    </div>
                </div>

                <!-- Thông tin chuyển khoản -->
                <div id="payment-info" style="display:none;">
                    <p style="font-weight:bold; color:#D10024;">💰 <?php echo t('total_amount'); ?>: <span id="total-amount"></span></p>
                    <p><?php echo t('transfer_info'); ?></p>
                    <div class="qr-info">
                        <p><strong>🏦<?php echo t('bank'); ?>:</strong> MBBank</p>
                        <p><strong>💳<?php echo t('account_number'); ?>:</strong> 0364200565
                            <button type="button" class="copy-btn" onclick="copyText('0364200565')">Copy</button>
                        </p>
                        <p><strong>👤 <?php echo t('account_holder'); ?>:</strong> Nguyen Tran Ngoc Anh</p>
                        <p><strong>📝 <?php echo t('transfer_content'); ?>:</strong> <span id="transfer-content"></span>
                            <button type="button" class="copy-btn" onclick="copyText(document.getElementById('transfer-content').innerText)">Copy</button>
                        </p>
                    </div>
                </div>

                <!-- Mã QR thanh toán -->
                <div id="qr-code-container">
                    <h3>📱 <?php echo t('scan_qr'); ?></h3>
                    <img id="qr-code-image" src="" alt="QR Code">
                    <div class="qr-info">
                        <p><strong>💰 <?php echo t('total_amount'); ?>:</strong> <span id="qr-amount"></span></p>
                        <p><strong>🏦<?php echo t('bank'); ?>:</strong> MBBank</p>
                        <p><strong>💳<?php echo t('account_number'); ?>:</strong> 0364200565</p>
                        <p><strong>👤 <?php echo t('account_holder'); ?>:</strong> Nguyen Tran Ngoc Anh</p>
                        <p><strong>📝 <?php echo t('transfer_content'); ?>:</strong> <span id="qr-content"></span></p>
                    </div>
                    <p style="color:#666; font-size:14px; margin-top:15px;">
                        ⚠️ <?php echo t('qr_warning'); ?>
                    </p>
                </div>

                <input type="submit" class="button" name="order_click" value="<?php echo t('place_order'); ?>">
            </form>
        <?php } // Kết thúc kiểm tra giỏ hàng trống ?>
        <?php } ?>
        <br>
        <br>
    </div>
    <?php

    include './partials/footer.php';
    ?>
    <script>
        // Copy text function
        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Đã copy: ' + text);
            });
        }

        // Update shipping fee function
        function updateShippingFee() {
            const citySelect = document.getElementById('city-select');
            const selectedOption = citySelect.options[citySelect.selectedIndex];
            const shippingFee = selectedOption ? parseInt(selectedOption.getAttribute('data-fee') || 0) : 0;
            const cityType = selectedOption ? selectedOption.getAttribute('data-city') : '';
            
            const productTotalCell = document.querySelector(".total-money[data-raw-total]");
            const productTotal = productTotalCell ? parseInt(productTotalCell.getAttribute('data-raw-total')) : 0;
            
            // CHỈ miễn phí ship cho Đà Nẵng khi đơn >= 5000k
            let finalShippingFee = shippingFee;
            if (cityType === 'danang' && productTotal >= 5000000) {
                finalShippingFee = 0;
            }
            
            // Set hidden input value
            document.getElementById('shipping-fee-input').value = finalShippingFee;
            
            const grandTotal = productTotal + finalShippingFee;
            
            const currentCurrency = "<?php echo isset($_SESSION['currency']) ? $_SESSION['currency'] : 'VND'; ?>";
            
            function formatMoney(amountVND) {
                if (currentCurrency === 'USD') {
                    const usd = amountVND / 24000;
                    return '$' + usd.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                } else {
                    return new Intl.NumberFormat('vi-VN').format(amountVND) + 'đ';
                }
            }
            
            // Hiển thị phí ship
            if (selectedOption && selectedOption.value) {
                if (finalShippingFee === 0 && cityType === 'danang' && productTotal >= 5000000) {
                    document.getElementById('shipping-fee-text').innerHTML = '✅ Miễn phí vận chuyển!';
                    document.getElementById('shipping-fee-text').style.color = '#28a745';
                } else {
                    document.getElementById('shipping-fee-text').innerHTML = '(' + formatMoney(finalShippingFee) + ')';
                    document.getElementById('shipping-fee-text').style.color = '#D10024';
                    
                    // Chỉ hiển thị thông báo "mua thêm" nếu là Đà Nẵng
                    if (cityType === 'danang' && productTotal < 5000000) {
                        const remaining = 5000000 - productTotal;
                        document.getElementById('free-ship-status').innerHTML = '<span style="color:#666; font-size:13px;">⚡ Mua thêm ' + formatMoney(remaining) + ' để được miễn phí ship tại Đà Nẵng</span>';
                    } else {
                        document.getElementById('free-ship-status').innerHTML = '';
                    }
                }
            } else {
                document.getElementById('shipping-fee-text').innerHTML = '';
                document.getElementById('free-ship-status').innerHTML = '';
            }
            
            document.getElementById('shipping-total').innerHTML = '<strong>' + formatMoney(finalShippingFee) + '</strong>';
            document.getElementById('grand-total').innerHTML = '<strong>' + formatMoney(grandTotal) + '</strong>';
            document.getElementById('grand-total').setAttribute('data-raw-total', grandTotal);
        }

        document.addEventListener("DOMContentLoaded", function () {
            const paymentSelect = document.getElementById("payment-method");
            const paymentInfo = document.getElementById("payment-info");
            const depositInfo = document.getElementById("deposit-info");
            const qrContainer = document.getElementById("qr-code-container");
            const totalAmount = document.getElementById("total-amount");
            const depositAmount = document.getElementById("deposit-amount");
            const qrAmount = document.getElementById("qr-amount");
            const qrContent = document.getElementById("qr-content");
            const transferContent = document.getElementById("transfer-content");

            function generateOrderId() {
                return 'DH' + Date.now().toString().slice(-8);
            }

            const orderId = generateOrderId();
            const currentCurrency = "<?php echo isset($_SESSION['currency']) ? $_SESSION['currency'] : 'VND'; ?>";
            
            function formatMoney(amountVND) {
                if (currentCurrency === 'USD') {
                    const usd = amountVND / 24000;
                    return '$' + usd.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                } else {
                    return new Intl.NumberFormat('vi-VN').format(amountVND) + ' ₫';
                }
            }

            paymentSelect.addEventListener("change", function () {
                paymentInfo.style.display = "none";
                depositInfo.style.display = "none";
                qrContainer.classList.remove("show");

                const grandTotalCell = document.getElementById('grand-total');
                const totalValueVND = grandTotalCell ? parseInt(grandTotalCell.getAttribute('data-raw-total')) : 0;

                if (this.value === "bank") {
                    paymentInfo.style.display = "block";
                    totalAmount.innerText = formatMoney(totalValueVND);
                    transferContent.innerText = `Thanh toan ${orderId}`;
                    
                } else if (this.value === "cod") {
                    depositInfo.style.display = "block";
                    const depositVND = Math.round(totalValueVND * 0.1);
                    depositAmount.innerText = formatMoney(depositVND);
                    
                } else if (this.value === "qr") {
                    qrContainer.classList.add("show");
                    qrAmount.innerText = new Intl.NumberFormat('vi-VN').format(totalValueVND) + ' ₫';
                    
                    const content = `Thanh toan ${orderId}`;
                    qrContent.innerText = content;
                    
                    const accountNo = "0364200565";
                    const accountName = "NGUYEN TRAN NGOC ANH";
                    const bankCode = "MB";
                    const template = "compact2";
                    
                    const qrUrl = `https://img.vietqr.io/image/${bankCode}-${accountNo}-${template}.jpg?amount=${totalValueVND}&addInfo=${encodeURIComponent(content)}&accountName=${encodeURIComponent(accountName)}`;
                    
                    document.getElementById("qr-code-image").src = qrUrl;
                }
            });
        });
    </script>

    <?php include 'chatbot_widget.php'; ?>
    <?php include 'zalo_contact.php'; ?>
</body>
</html>