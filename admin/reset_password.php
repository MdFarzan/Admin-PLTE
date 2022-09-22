<?php
/* 
        reset_password.php
        contains final step for reset password
    */

require_once '../app.php';
require_once 'config/db.php';


$OTPError = $PasswordError = '';

session_start();
if(!isset($_SESSION['PASS_REC_EXP'])){
    header("Location: index.php");
}

else{
    if($_SESSION['PASS_REC_EXP'] > time()){
        $otp_expired = false;

        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if ($db->connect_error)
                die("unable to connect to the database");

        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_SESSION ? : session_start();
            $OTP = trim($_POST['otp']);
            $new_password = password_hash($_POST['confirm-password'], PASSWORD_DEFAULT);
            $user_id = $_SESSION['PASS_REC_UID'];

            // checking is otp expired
            if($_SESSION['PASS_REC_EXP'] > time()){
                if($_SESSION['PASS_REC_OTP'] == $OTP){

                    if(strlen($_POST['confirm-password']) > 6){
                        
                        // updating when everything is ok
                        $sql = "UPDATE admin_auth SET password = '$new_password' WHERE id = '$user_id'";
                        if($db->query($sql)){
                            session_destroy();
                            echo "<script>
                                    alert('Password reset successfully!');
                                    window.location.href = 'index.php';
                                </script>";
                        }

                        else{
                            die("Unable to reset password!");
                        }
                    

                    }

                    else{
                        $PasswordError = 'Enter greater than 6 character password';
                    }

                }

                else{
                    $OTPError = 'Invalid OTP!';
                }
            }

            else{
                $otp_expired = true;

            }
         
        }
    }

    else{
        $otp_expired = true;
        
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | <?php echo APP_NAME ?></title>
    <link rel="stylesheet" href="dist/css/form.css" />
    <!-- BOOTSTRAP 4.6 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- FONT AWESOME 6.20  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div id="wrap" class="bg-light d-flex align-items-center justify-content-center">

        <div id="form-wrap" class="bg-white text-center">
            <h2 class="position-relative">Password Reset</h2>
            <?php if(!$otp_expired){ ?>
            <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                
                <div class="mb-4">
                <div class="input-group mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa-solid fa-key"></i></div>
                    </div>
                    <input type="text" name="otp" class="form-control" value="<?php echo isset($_POST['otp'])?$_POST['otp']:''; ?>" style="background:#fff;" placeholder="OTP" autofocus readonly
                        onclick="this.removeAttribute('readonly')" required>
                </div>
                <p class="text-danger"><?php echo $OTPError; ?></p>
                </div>

                <div class="mb-4">
                    <div class="input-group mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa-solid fa-key"></i></div>
                        </div>
                        <input type="password" name="confirm-password" value="<?php echo isset($_POST['confirm-password'])?$_POST['confirm-password']:''; ?>" class="form-control" placeholder="Confirm Password"
                            onfocus="this.type = 'text';" onblur="this.type = 'password'" required>
                    </div>
                    <p class="text-danger"><?php echo $PasswordError; ?></p>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary mb-2">Reset my Password</button>
                </div>
            </form>
            <?php }
                else{
                    echo '<div class="text-center text-danger"><h4>Your Password reset otp is expired!</h4></div>
                            <p class="lead">To generate new one <a href="forget_password.php" title="Forget password">visit here</a></p>';
                }
            ?>
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