<?php
include('login/connect/connection.php');

session_start();

if (isset($_POST["register"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Username format validation
    $usernameRegex = '/^[a-zA-Z0-9_]+$/';
    if (!preg_match($usernameRegex, $name)) {
        ?>
        <script>
            alert("Username should only contain letters, numbers, and underscores.");
        </script>
        <?php
    } else {
        // Email format validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            ?>
            <script>
                alert("Invalid email address format.");
            </script>
            <?php
        } else {
            // Password format validation
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                ?>
                <script>
                    alert("Password should be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.");
                </script>
                <?php
            } else {
                $check_query = mysqli_query($connect, "SELECT * FROM users where email ='$email'");
                $rowCount = mysqli_num_rows($check_query);

                if (!empty($email) && !empty($password) && !empty($cpassword)) {
                    if ($rowCount > 0) {
                        ?>
                        <script>
                            alert("User with email already exists!");
                        </script>
                        <?php
                    } else {
                        if ($password != $cpassword) {
                            ?>
                            <script>
                                alert("Confirm password does not match");
                            </script>
                            <?php
                        } else {
                            $password_hash = password_hash($password, PASSWORD_BCRYPT);

                            $result = mysqli_query($connect, "INSERT INTO users (name, email, password, status) VALUES ('$name', '$email', '$password_hash', 0)");

                            if ($result) {
                                $otp = rand(100000, 999999);
                                $_SESSION['otp'] = $otp;
                                $_SESSION['mail'] = $email;
                                require "login/Mail/phpmailer/PHPMailerAutoload.php";
                                $mail = new PHPMailer;

                                $mail->isSMTP();
                                $mail->Host='smtp.gmail.com';
                                $mail->Port=587;
                                $mail->SMTPAuth=true;
                                $mail->SMTPSecure='tls';

                                $mail->Username='xskywalker989@gmail.com';
                                $mail->Password='ilzc vala hcww funf';

                                $mail->setFrom('xskywalker989@gmail.com', 'OTP Verification');
                                $mail->addAddress($_POST["email"]);

                                $mail->isHTML(true);
                                $mail->Subject="Your verify code";
                                $mail->Body="<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>
                                <br><br>
                                <p>With regards</p>
                                
                                ";

                                if (!$mail->send()) {
                                    ?>
                                    <script>
                                        alert("<?php echo "Register Failed, Invalid Email " ?>");
                                    </script>
                                    <?php
                                } else {
                                    ?>
                                    <script>
                                        alert("<?php echo "Register Successfully, OTP sent to " . $email ?>");
                                        window.location.replace('verification.php');
                                    </script>
                                    <?php
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
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

    <title>Register Form</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">Register Form</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php" >Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php" style="font-weight:bold; color:black; text-decoration:underline">Register</a>
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
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form action="#" method="POST" name="register">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Username</label>
                                <div class="col-md-6">
                                    <input type="text" id="name" class="form-control" name="name" required autofocus>
                                </div>
                            </div>
                            
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
                            
                            <div class="form-group row">
                                <label for="cpassword" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="cpassword" class="form-control" name="cpassword" required>
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Register" name="register">
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
        if(password.type == "password"){
            password.type = 'text';
        }else{
            password.type = 'password';
        }
        this.classList.toggle('bi-eye');
    });

    
</script>
