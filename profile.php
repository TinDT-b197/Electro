<?php
include 'connect.php';
include 'language.php';
session_start();

// Kiểm tra đăng nhập
if(!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Xử lý cập nhật thông tin
if(isset($_POST['update_profile'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['HoTen']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $phone = mysqli_real_escape_string($conn, $_POST['Phone']);
    
    $update_query = "UPDATE user_info SET HoTen = '$fullname', Email = '$email', SDT = '$phone' WHERE ID = '$user_id'";
    
    if(mysqli_query($conn, $update_query)) {
        $success = 'Cập nhật thông tin thành công!';
    } else {
        $error[] = 'Có lỗi xảy ra, vui lòng thử lại!';
    }
}

// Xử lý đổi mật khẩu
if(isset($_POST['change_password'])) {
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    
    $check_pass = mysqli_query($conn, "SELECT * FROM user_info WHERE ID = '$user_id' AND password = '$old_pass'");
    
    if(mysqli_num_rows($check_pass) > 0) {
        if($new_pass == $confirm_pass) {
            mysqli_query($conn, "UPDATE user_info SET password = '$new_pass' WHERE ID = '$user_id'");
            $success_pass = t("password_changed_success");
        } else {
            $error_pass[] = t("password_mismatch");
        }
    } else {
        $error_pass[] = t("old_password_incorrect");
    }
}

// Lấy thông tin user
$query = mysqli_query($conn, "SELECT * FROM user_info WHERE ID = '$user_id'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./img/logo.png" type="image">
    <title>Thông tin cá nhân - Electro</title>

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

    <style>
        .profile-section {
            padding: 50px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 200px);
        }
        .profile-container {
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .profile-header {
            border-bottom: 2px solid #D10024;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .profile-header h3 {
            font-size: 24px;
            font-weight: 700;
            color: #D10024;
            margin: 0;
            text-transform: uppercase;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }
        .form-group input {
            width: 100%;
            height: 40px;
            padding: 0 15px;
            border: 1px solid #E4E7ED;
            background-color: #FFF;
            border-radius: 40px;
            font-size: 14px;
        }
        .form-group input:focus {
            border-color: #D10024;
            outline: none;
        }
        .form-group input:disabled {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }
        .success-msg {
            background: #28a745;
            color: #fff;
            padding: 12px 20px;
            border-radius: 40px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
        .error-msg {
            background: #D10024;
            color: #fff;
            padding: 12px 20px;
            border-radius: 40px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
        .update-btn {
            height: 45px;
            background: #D10024;
            color: #FFF;
            border: none;
            border-radius: 40px;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.2s all;
            padding: 0 30px;
        }
        .update-btn:hover {
            background: #b8001f;
        }
        .tab-buttons {
            margin-bottom: 30px;
        }
        .tab-btn {
            background: #f5f5f5;
            border: none;
            padding: 12px 25px;
            margin-right: 10px;
            border-radius: 40px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s all;
        }
        .tab-btn.active {
            background: #D10024;
            color: #fff;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
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
                        <li><a href="./index.php"><?php echo t('home'); ?></a></li>
                        <li class="active"><?php echo t('profile'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /BREADCRUMB -->

    <!-- PROFILE SECTION -->
    <div class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="profile-container">
                        <div class="profile-header">
                            <h3><?php echo t('profile'); ?></h3>
                        </div>

                        <!-- Tab Buttons -->
                        <div class="tab-buttons">
                            <button class="tab-btn active" onclick="openTab('info')"><?php echo t('account_info'); ?></button>
                            <button class="tab-btn" onclick="openTab('password')"><?php echo t('change_password'); ?></button>
                        </div>

                        <!-- Tab 1: Thông tin tài khoản -->
                        <div id="info" class="tab-content active">
                            <?php
                            if(isset($success)) {
                                echo '<div class="success-msg">'.$success.'</div>';
                            }
                            if(isset($error)) {
                                foreach($error as $err) {
                                    echo '<div class="error-msg">'.$err.'</div>';
                                }
                            }
                            ?>

                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username"><?php echo t('username'); ?></label>
                                            <input type="text" id="username" value="<?php echo $user['username']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="HoTen"><?php echo t('full_name'); ?></label>
                                            <input type="text" id="HoTen" name="HoTen" value="<?php echo $user['HoTen']; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Email"><?php echo t('email'); ?></label>
                                            <input type="email" id="Email" name="Email" value="<?php echo $user['Email']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Phone"><?php echo t('phone'); ?></label>
                                            <input type="text" id="Phone" name="Phone" value="<?php echo $user['SDT']; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" name="update_profile" class="update-btn"><?php echo t('update_profile'); ?></button>
                            </form>
                        </div>

                        <!-- Tab 2: Đổi mật khẩu -->
                        <div id="password" class="tab-content">
                            <?php
                            if(isset($success_pass)) {
                                echo '<div class="success-msg">'.$success_pass.'</div>';
                            }
                            if(isset($error_pass)) {
                                foreach($error_pass as $err) {
                                    echo '<div class="error-msg">'.$err.'</div>';
                                }
                            }
                            ?>

                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="old_password"><?php echo t('old_password'); ?></label>
                                            <input type="password" id="old_password" name="old_password" required placeholder="<?php echo t('enter_old_password'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_password"><?php echo t('new_password'); ?></label>
                                            <input type="password" id="new_password" name="new_password" required placeholder="<?php echo t('enter_new_password'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirm_password"><?php echo t('confirm_new_password'); ?></label>
                                            <input type="password" id="confirm_password" name="confirm_password" required placeholder="<?php echo t('enter_confirm_password'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" name="change_password" class="update-btn"><?php echo t('change_password'); ?></button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /PROFILE SECTION -->

    <!-- NEWSLETTER -->
    <div id="newsletter" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p>Đăng ký để nhận <strong>THÔNG BÁO MỚI</strong></p>
                        <form>
                            <input class="input" type="email" placeholder="Enter Your Email">
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
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
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        function openTab(tabName) {
            var i, tabContent, tabBtn;
            
            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].classList.remove("active");
            }
            
            tabBtn = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tabBtn.length; i++) {
                tabBtn[i].classList.remove("active");
            }
            
            document.getElementById(tabName).classList.add("active");
            event.target.classList.add("active");
        }
    </script>

</body>
</html>