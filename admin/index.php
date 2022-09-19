<?php
/* 
        sign_in.php
        sign_in form / entrypoint for admin
    */

require_once '../app.php';
require_once 'config/db.php';
require_once 'helpers/auth.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($db->connect_error)
    die("unable to connect to the database");

$passwordError = '';
$emailError = '';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];


    $remember_me = isset($_POST['remember-me']) ? true : false;

    $sql = "SELECT * FROM admin_auth WHERE email = '$email'";

    $res = $db->query($sql);

    if ($res->num_rows > 0) {
        $data = $res->fetch_assoc();

        if (password_verify($password, $data['password'])) {
               
            $user_id = $data['id'];

            if($remember_me){

                // setting auth token for 1 month
                $token = sha1(rand(1, 20));
                setcookie('AUTH_TOKEN', $token, time() + (86400*30), '/');
                $sql = "UPDATE admin_auth set auth_token = '$token' WHERE id = '$user_id'";
                $db->query($sql);
            }

            $session_data = [
                    "ADMIN_LOGGED_IN" => true,
                    "USER_ID" => $user_id,
                    "USER_EMAIL" => $data['email']
            ];

            set_session_auth($session_data);
            header("Location: dashboard.php");

        } 
        else
            $passwordError = "Password not matched!";

    }
    
    else {
        $emailError = "Email not found!";
    }
}

else{
    verify_auth($db);
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

        <div id="form-wrap" class="bg-white">
            <h2 class="position-relative">Sign in</h2>

            <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" autocomplete="off">

                <div class="mb-4">
                    <div class="input-group mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa-solid fa-user"></i></div>
                        </div>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <p class="text-danger mb-0"><?php echo $emailError; ?></p>
                </div>

                <div class="mb-4">
                    <div class="input-group mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa-solid fa-key"></i></div>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <p class="text-danger mb-0"><?php echo $passwordError; ?></p>
                </div>

                <div class="form-check mb-4 mr-sm-2">
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember-me">
                    <label class="form-check-label" for="remember-me">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn btn-primary mb-2">Sign In</button>
                <a href="#" class="float-right">Forget Password?</a>
            </form>

            <div class="text-center back">
                <a href="#" class="text-secondary"><i class="fa-solid fa-arrow-left-long"></i>Back to site</a>
            </div>
        </div>
    </div>

    <!-- JS FILES BOOTSTRAP 4.6 -->
    <script src=" https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>