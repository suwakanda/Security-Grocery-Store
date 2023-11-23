<?php
    include('login/connect/connection.php');

    session_start();

    $error = ""; // Initialize an error variable

    if(isset($_POST["login"])){
        $email = mysqli_real_escape_string($connect, trim($_POST['email']));
        $password = trim($_POST['password']);
        $captcha = $_POST['captcha'];
        $captcharandom = $_POST['captcha-rand'];

        $sql = mysqli_query($connect, "SELECT * FROM users WHERE email = '$email'");
        $count = mysqli_num_rows($sql);

        if($count > 0){
            $fetch = mysqli_fetch_assoc($sql);
            $hashpassword = $fetch["password"];

            if($captcha != $captcharandom){
                $error = "Invalid captcha value";
            } elseif($fetch["status"] == 0){
                $error = "Please verify email account before login.";
            } elseif(password_verify($password, $hashpassword)){
                if($fetch['user_type'] == 'admin'){
                    $_SESSION['admin_id'] = $fetch['id'];
                    header('location:admin_page.php');
                } elseif($fetch['user_type'] == 'seller'){
                    $_SESSION['seller_id'] = $fetch['id'];
                    header('location:seller_sales.php');
                } elseif($fetch['user_type'] == 'user'){
                    $_SESSION['user_id'] = $fetch['id'];
                    header('location:home.php');
                }
            } else {
                $error = "Incorrect password. Please try again.";
            }
        } else {
            $error = "Email not found. Please check your email address.";
        }
    }
?>

<style>
 
 .captcha
{
  width: 50%;
  background: yellow;
  text-align: center;
  font-size: 24px;
  font-weight: 700;
} 
</style>
<?php
$rand = rand(9999,1000);
?>



<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="login/style.css">

    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>Login Form</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">Login Form</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php" style="font-weight:bold; color:black; text-decoration:underline">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form method="POST" name="login">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required>
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                </div>
                            </div>

                                <div class="form-group row" style="margin-left: 25%;">
                                <div class="col-md-6">
                                <label for="captcha">Captcha</label>
                                <input type="text" name="captcha" id="captcha" placeholder="Enter Captcha" required class="form-control"/>
                                <input type="hidden" name="captcha-rand" value="<?php echo $rand; ?>">
                                </div>
                                <div class="col-md-6 ">
                                <label for="captcha-code">Captcha Code</label>
                                <div class="captcha"><?php echo $rand; ?></div>
                                </div>
                                </div>
                                
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Login" name="login">
                                <a href="recover_psw.php" class="btn btn-link">
                                    Forgot Your Password?
                                </a>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>
</body>
</html>
<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function(){
        if(password.type === "password"){
            password.type = 'text';
        }else{
            password.type = 'password';
        }
        this.classList.toggle('bi-eye');
    });
</script>

<div class="col-md-6 offset-md-4">

    <p style="color: red;"><?php echo $error; ?></p> <!-- Display error messages here -->
</div>