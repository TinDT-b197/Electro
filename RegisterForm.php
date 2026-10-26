<?php
@include 'connect.php';
session_start();
if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];
    $fullname = mysqli_real_escape_string($conn, $_POST['HoTen']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $phone = $_POST['Phone'];
    $cpass = $_POST['cpassword'];
   
    $query = mysqli_query($conn, "SELECT * FROM `user_info` WHERE email = '$email'") or die('query failed');
    if(mysqli_num_rows($query) > 0) {
        $error[] = 'Email đã được sử dụng!';
    }else {
        if($pass != $cpass) {
            $error[] = 'Mật khẩu không khớp!';
        } else {
            mysqli_query($conn, "INSERT INTO `user_info`(username, password, HoTen, Email, SDT) VALUE ('$username', '$pass','$fullname','$email','$phone')") or die('query failed');
            $success = 'Đăng ký thành công! Chuyển hướng đến trang đăng nhập...';
            header('refresh:2;url=login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./img/logo.png" type="image">
    <title>Đăng ký - Electro</title>

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
        .register-section {
            padding: 50px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 200px);
        }
        .register-form {
            background: #fff;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .register-form h3 {
            font-size: 24px;
            font-weight: 700;
            color: #D10024;
            margin-bottom: 30px;
            text-align: center;
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
        .error-msg {
            background: #D10024;
            color: #fff;
            padding: 12px 20px;
            border-radius: 40px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
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
        .register-btn {
            width: 100%;
            height: 45px;
            background: #D10024;
            color: #FFF;
            border: none;
            border-radius: 40px;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.2s all;
            margin-top: 10px;
        }
        .register-btn:hover {
            background: #b8001f;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .login-link a {
            color: #D10024;
            font-weight: 500;
        }
        .login-link a:hover {
            text-decoration: underline;
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
                        <li class="active">Đăng ký</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /BREADCRUMB -->

    <!-- REGISTER SECTION -->
    <div class="register-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="register-form">
                        <h3>Đăng ký tài khoản</h3>
                        
                        <?php
                        if(isset($error)) {
                            foreach($error as $err) {
                                echo '<div class="error-msg">'.$err.'</div>';
                            }
                        }
                        if(isset($success)) {
                            echo '<div class="success-msg">'.$success.'</div>';
                        }
                        ?>

                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="username">Tên đăng nhập <span style="color:red;">*</span></label>
                                <input type="text" id="username" name="username" required placeholder="Nhập tên đăng nhập">
                            </div>

                            <div class="form-group">
                                <label for="HoTen">Họ và tên <span style="color:red;">*</span></label>
                                <input type="text" id="HoTen" name="HoTen" required placeholder="Nhập họ và tên đầy đủ">
                            </div>

                            <div class="form-group">
                                <label for="Email">Email <span style="color:red;">*</span></label>
                                <input type="email" id="Email" name="Email" required placeholder="Nhập địa chỉ email">
                            </div>

                            <div class="form-group">
                                <label for="Phone">Số điện thoại <span style="color:red;">*</span></label>
                                <input type="text" id="Phone" name="Phone" required placeholder="Nhập số điện thoại">
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu <span style="color:red;">*</span></label>
                                <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
                            </div>

                            <div class="form-group">
                                <label for="cpassword">Xác nhận mật khẩu <span style="color:red;">*</span></label>
                                <input type="password" id="cpassword" name="cpassword" required placeholder="Nhập lại mật khẩu">
                            </div>

                            <button type="submit" name="submit" class="register-btn">Đăng ký</button>
                            
                            <div class="login-link">
                                Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /REGISTER SECTION -->

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

</body>
</html>