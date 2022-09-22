<?php
/* 
        forget_password.php
        Password recovery for admin
    */

require_once '../app.php';
require_once 'helpers/mailer.php';
require_once 'config/db.php';

$emailError = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($db->connect_error)
        die("unable to connect to the database");

    $email = trim($_POST['email']);
    

    $sql = "SELECT * FROM admin_auth WHERE email = '$email'";

    $res = $db->query($sql);

    if ($res->num_rows > 0) {
        $data = $res->fetch_assoc();    
        
        if($otp = send_forget_password_mail_to($data['email']) ){
            session_start();
            $_SESSION['PASS_REC_EXP'] = time() + (60 * 10);  // Password recovery expiry time 10 min
            $_SESSION['PASS_REC_OTP'] = $otp; // otp for password recovery
            $_SESSION['PASS_REC_UID'] = $data['id'];
            header('Location: reset_password.php');
        }
        

    }
    else{
        $emailError = 'Email not found!';
    }


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password | <?php echo APP_NAME ?></title>
    <link rel="stylesheet" href="dist/css/form.css" />
    <!-- BOOTSTRAP 4.6 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- FONT AWESOME 6.20  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div id="wrap" class="bg-light d-flex align-items-center justify-content-center">

        <div id="form-wrap" class="bg-white text-center ">
            <h2 class="position-relative">Forget Password</h2>
            <p class="lead">Enter your registered email</p>
            <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                <div class="mb-4">
                    <div class="input-group mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa-solid fa-user"></i></div>
                        </div>
                        <input type="text" name="email" class="form-control" placeholder="Email" required >
                    </div>
                    <p class="text-danger mb-0"><?php echo $emailError; ?></p>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary mb-2">Find my Account</button>
                </div>
            </form>

            <div class="text-center back">
                <a href="<?php echo BASE_URL; ?>" class="text-secondary"><i class="fa-solid fa-arrow-left-long"></i>Back to site</a>
            </div>
        </div>
    </div>

    <!-- JS FILES BOOTSTRAP 4.6 -->
    <script src=" https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>