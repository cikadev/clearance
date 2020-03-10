<?php
    include("dbconn.php");
    session_start();
     if ($_SESSION['user_type'] != "staff"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PUGACS</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

            <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

            <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

            <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </head>
    <body class="container vh-100" style="background-color: #d6cbd3">
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-2 shadow justify-content-between">
            <a class="btn btn-outline-secondary nav-item text-white" href="staff_home.php">Home</a>
            <a class="navbar-brand text-white">President University Graduation Automated Clearance System</a>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="btn btn-outline-danger text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>

        <div class="container text-center" style="margin-top: 140px; position: absolute; z-index: 1;">
            <img class="rounded-circle shadow" src="pic/pin.png" style="width: 100px;">          
        </div>

        <div class="container-fluid h-100 card col-sm-8 text-center justify-content-center align-items-center" style="border: 0px; background-color: #d6cbd3;">
            <div class="card-header text-center text-white" style="background-color: #034f84">
                <h1 class="my-lg-5"><?php echo "Welcome Back, ".$_SESSION['user_name']; echo " in Department ".$_SESSION['dep_id'];  echo "!";?></h1>

            
                <img src="pic/pulogo.png" class="img-fluid" alt="Responsive image" style="width: 20%;">
                <p>Passion . Responsibility . Entrepreneurial spirit . Sincerity . Inclusiveness . Dedication . Exellence . Nationalism . Trendsetter</p>
                <h1>PIN</h1>

                <div class="container text-center rounded">
                    <form action="staff_input_pin.php" method="post">
                        <div class="container">
                            <label class="my-3" for="user_name" for="pin"><b>Input PIN: </b></label>
                            <input class="form-control" type="password" placeholder="Enter PIN" name="pin" required>
                            <div class="text-center">
                                <button class="button btn btn-info my-3" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>               
            </div>
        </div>
    </body>
</html>
