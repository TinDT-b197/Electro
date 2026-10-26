<?php
include './connect.php';

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
echo "✓ Kết nối database thành công!<br><br>";

// Kiểm tra bảng danhmuc_info có tồn tại không
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'danhmuc_info'");
if (mysqli_num_rows($check_table) == 0) {
    echo "✗ Bảng 'danhmuc_info' KHÔNG tồn tại!<br>";
    echo "Tạo bảng bằng SQL sau:<br>";
    echo "<pre>";
    echo "CREATE TABLE `danhmuc_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tendanhmuc` varchar(255) NOT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    echo "</pre>";
} else {
    echo "✓ Bảng 'danhmuc_info' tồn tại!<br><br>";
    
    // Kiểm tra dữ liệu
    $sql = "SELECT * FROM danhmuc_info";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $count = mysqli_num_rows($result);
        echo "✓ Số lượng danh mục: " . $count . "<br><br>";
        
        if ($count > 0) {
            echo "Danh sách danh mục:<br>";
            while($row = mysqli_fetch_array($result)) {
                echo "- ID: {$row['id']}, Tên: {$row['tendanhmuc']}<br>";
            }
        } else {
            echo "✗ Bảng không có dữ liệu! Thêm dữ liệu mẫu:<br>";
            echo "<pre>";
            echo "INSERT INTO `danhmuc_info` (`tendanhmuc`, `image_name`) VALUES
('Laptops', 'shop01.png'),
('Smartphones', 'shop02.png'),
('Cameras', 'shop03.png');";
            echo "</pre>";
        }
    } else {
        echo "✗ Lỗi truy vấn: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>