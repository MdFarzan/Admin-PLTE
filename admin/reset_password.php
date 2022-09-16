<?php
/* 
        sign_in.php
        sign_in form / entrypoint for admin
    */

require_once '../app.php';

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

            <form class="form" action="">

                <div class="input-group mb-4 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa-solid fa-key"></i></div>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>

                <div class="input-group mb-4 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa-solid fa-key"></i></div>
                    </div>
                    <input type="password" name="confirm-password" class="form-control" placeholder="Confirm Password">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary mb-2">Reset my Password</button>
                </div>
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