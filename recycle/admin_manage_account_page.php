<?php
    session_start();
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>PUGACS - Admin</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </head>

    <body>
         <div class="container bg-white">
            <a class="float-left btn btn-outline-primary" href="admin_home.php">Back</a>
            
            <div class="container bg-white">
                <div>
                    <h2 class="text-center ">Manage Account Menu</h2>
                    <div class="imgcontainer">
                        <img src="pic/pulogo.png" alt="logo" class="logo">
                    </div>
                    <div class="container">
                        <button class="button" onclick="window.location.href = 'admin_update_student_page.php';">Update Student</button>
                        <button class="button" onclick="window.location.href = 'admin_update_student_page.php';">Manage Staff/Clearing Officer</button>
                    </div>
                </div>
            </div>
            <div class="container">
                <a class="float-right btn btn-outline-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </body>
</html>