<?php
    session_start();
    if (isset($_SESSION['name'])) {
        header('Location: index.php');
        exit();
    }

    require_once("./loginAPI.php");

    $error = '';
    $user = '';
    $pass = '';

    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        $result = login($user,$pass,$conn);
        if ($result['code'] == 3) {
            $data = $result['data'];
            $_SESSION['user'] = $data;
            header("Location: register.php");
            exit();
        }

        if ($result['code'] == 0) {
            // success
            $data = $result['data'];
            $_SESSION['user'] = $data;
            $_SESSION['name'] = $data ['TENNV'];

            header("Location: index.php");
            exit;

        }

        
       else {
            $error = $result['message'];
       }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Employee Login</h3>
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input value="<?= $user ?>" name="user" id="user" type="text" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input name="pass" value="<?= $pass ?>" id="password" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input <?= isset($_POST['remember']) ? 'checked' : '' ?> name="remember" type="checkbox" class="custom-control-input" id="remember">
                    <label class="custom-control-label" for="remember">Remember login</label>
                </div>
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button class="btn btn-success px-5">Login</button>
                </div>
            </form>
            <!-- <p class="text-danger">Đăng nhập bằng tài khoản: <strong>admin</strong> - <strong>123456</strong></p>
            <p class="text-danger">Username và mật khẩu này đang viết trực tiếp trong code, cần bổ sung chức năng đọc database để lấy username và mật khẩu trong database</p> -->
        </div>
    </div>
</div>

</body>
</html>