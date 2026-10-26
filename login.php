<?php
include 'connect.php';
session_start();
if(isset($_POST['submit'])) {
 
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = ($_POST['password']);

    $sql = "SELECT * FROM user_info WHERE email = '$email' && password = '$pass'";
    $query = mysqli_query($conn, $sql) ;
    if(mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
    
        $_SESSION['user_id'] = $row['ID'];
        $_SESSION['name_user'] = $row['username'];

        header('location:index.php');
    
    } else {
        $error[] = 'Email hoặc mật khẩu không chính xác!';
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
    <title>Đăng nhập - Electro</title>

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
        .login-section {
            padding: 50px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 200px);
        }
        .login-form {
            background: #fff;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        .login-form h3 {
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
        .login-btn {
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
        .login-btn:hover {
            background: #b8001f;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .register-link a {
            color: #D10024;
            font-weight: 500;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }
        .forgot-password a {
            color: #666;
            font-size: 13px;
        }
        .forgot-password a:hover {
            color: #D10024;
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
                        <li class="active">Đăng nhập</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /BREADCRUMB -->

    <!-- LOGIN SECTION -->
    <div class="login-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="login-form">
                        <h3>Đăng nhập tài khoản</h3>
                        
                        <?php
                        if(isset($error)) {
                            foreach($error as $err) {
                                echo '<div class="error-msg">'.$err.'</div>';
                            }
                        }
                        ?>

                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="email">Email <span style="color:red;">*</span></label>
                                <input type="email" id="email" name="email" required placeholder="Nhập địa chỉ email">
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu <span style="color:red;">*</span></label>
                                <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
                            </div>

                            <div class="forgot-password">
                                <a href="#">Quên mật khẩu?</a>
                            </div>

                            <button type="submit" name="submit" class="login-btn">Đăng nhập</button>
                            
                            <div class="register-link">
                                Chưa có tài khoản? <a href="RegisterForm.php">Đăng ký ngay</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /LOGIN SECTION -->

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