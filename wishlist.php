<?php
session_start();
include 'connect.php';

// Kiểm tra đăng nhập
if(!isset($_SESSION['user_id'])) {
    header('Location:login.php');
    exit();
}

// Kiểm tra có product_id không
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location:index.php');
    exit();
}

$uid = $_SESSION['user_id'];
$pid = intval($_GET['id']);

// Kiểm tra sản phẩm có tồn tại không
$check_product = mysqli_query($conn, "SELECT * FROM product_info WHERE ID = $pid");
if(mysqli_num_rows($check_product) == 0) {
    $_SESSION['notification'] = array(
        'type' => 'error',
        'title' => 'Lỗi!',
        'message' => 'Sản phẩm không tồn tại!'
    );
    header('Location:index.php');
    exit();
}

// Kiểm tra đã có trong wishlist chưa
$sql = "SELECT * FROM wishlist WHERE product_id = $pid AND user_id = $uid";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) >= 1) {
    // ĐÃ CÓ TRONG WISHLIST → XÓA RA
    $deleteWishlist = "DELETE FROM wishlist WHERE product_id = $pid AND user_id = $uid";
    if(mysqli_query($conn, $deleteWishlist)) {
        $_SESSION['notification'] = array(
            'type' => 'success',
            'title' => 'Thành công!',
            'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích!'
        );
        header('Location:show-wishlist.php');
        exit();
    } else {
        $_SESSION['notification'] = array(
            'type' => 'error',
            'title' => 'Lỗi!',
            'message' => 'Có lỗi khi xóa: ' . mysqli_error($conn)
        );
        header('Location:show-wishlist.php');
        exit();
    }
} else {
    // CHƯA CÓ TRONG WISHLIST → THÊM VÀO
    $insertWishlist = "INSERT INTO wishlist (product_id, user_id) VALUES ($pid, $uid)";
    if(mysqli_query($conn, $insertWishlist)) {
        $_SESSION['notification'] = array(
            'type' => 'success',
            'title' => 'Thành công!',
            'message' => 'Đã thêm sản phẩm vào danh sách yêu thích!'
        );
        header('Location:show-wishlist.php');
        exit();
    } else {
        $_SESSION['notification'] = array(
            'type' => 'error',
            'title' => 'Lỗi!',
            'message' => 'Có lỗi xảy ra: ' . mysqli_error($conn)
        );
        header('Location:detail.php?id=' . $pid);
        exit();
    }
}
?>