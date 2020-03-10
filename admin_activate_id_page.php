<?php
    include("dbconn.php");
    session_start();
     if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    if(isset($_POST['student_id']) && isset($_POST['card_id']) && isset($_POST['toga_size'])){
        $student_id = $_POST['student_id'];
        $card_id = $_POST['card_id'];
        $toga_size = $_POST['toga_size'];

        $sqlprep = $connection->prepare("SELECT student_id, card_id FROM tbl_student WHERE student_id = '$student_id'");
        $sqlprep->execute();
        $resultprep = $sqlprep->fetch();

        if($student_id == $resultprep['student_id']){
            if($resultprep['card_id'] != NULL){
                $messageIn = "Student ID Card Already Activated";
                echo "<script type='text/javascript'>alert('$messageIn');</script>";
            }
            elseif($resultprep['card_id'] == NULL){
                $sqlupdate = $connection->prepare("UPDATE tbl_student SET card_id ='$card_id', toga_size = '$toga_size' WHERE student_id = '$student_id'");
                if($sqlupdate->execute()){
                    $messageIn = "Card Activated ".$student_id;
                    echo "<script type='text/javascript'>alert('$messageIn');</script>";
                }
            }
        }
        else{
            $messageIn = $student_id."ID Card Has not been registered";
            echo "<script type='text/javascript'>alert('$messageIn');</script>";
        }
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
        <style type="text/css">
            body, html {
                height: 100%;
                margin: 0;
            }
            .bg {
                /* The image used */
                background-image: url("pic/backgroundhome.png");

                /* Full height */
                height: 100%; 

                /* Center and scale the image nicely */
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;

                padding-top: 100px;
            }
        </style>
    </head>
    <body class="container bg">
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-2 shadow justify-content-between">
            <a class="btn btn-outline-secondary nav-item text-white" href="admin_home.php">Home</a>
            <a class="navbar-brand text-white">President University Graduation Automated Clearance System</a>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="btn btn-outline-danger text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>

        <div class="container text-center" style="margin-top: 120px; position: absolute; z-index: 1;">
            <img class="rounded" src="pic/acc.png" style="width: 100px;">          
        </div>

        <div class="container-fluid h-100 card col-sm-10 text-center justify-content-center align-items-center bg-transparent" style="border: 0px;">
            <div class="card-header shadow text-center text-white" style="background-image: url(pic/test.jpg); background-position: center;">
                <div class="container-fluid mt-3">
                    <h1 class="font-weight-bold text-center" style="padding-top: 20px;"><?php echo "Welcome Back, ".$_SESSION['user_name'];  echo "!";?></h1>
                </div>
            
                <img src="pic/pulogo.png" class="img-fluid" alt="Responsive image" style="width: 20%;">
                <p>Passion . Responsibility . Entrepreneurial spirit . Sincerity . Inclusiveness . Dedication . Exellence . Nationalism . Trendsetter</p>
                <h1>Activate Student ID Card</h1>
                <div class="bg-danger">
                  
    
        
   

                </div>

                <div class="container text-center rounded p-3 text-white">
                    <form action="" method="post" id="test">
                        <div class="container">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <select class="rounded bg-white" name="student_id" id="student" style="width: 200px; padding: 7px;">
                                            <option value="">Student ID</option>  
                                            <?php
                                                $sql = $connection->prepare("SELECT * FROM tbl_student ORDER BY student_name");
                                                $sql->execute();
                                              
                                                while($data = $sql->fetch()){
                                                    echo "<option value='".$data['student_id']."'>".$data['student_id']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <select class="rounded bg-white" name="toga_size" id="toga" style="width: 200px; padding: 7px;">
                                            <option value="">Toga Size</option>  
                                            <option value="XS">XS</option>  
                                            <option value="S">S</option>  
                                            <option value="M">M</option>  
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>  
                                            <option value="XXL">XXL</option>  
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="card_id"><b>Tap Student Card </b></label>
                                <input class="form-control bg-white" type="password" placeholder="Tap Card" name="card_id" onchange="submit()" required>
                            </div>
                        </div>
                    </form>
                </div>               
            </div>
        </div>
    </body>
    <script type="text/javascript">
        $(".input1").on('keyup', function (e) {
            if (e.keyCode === 13) {
                document.getElementById("test").submit();
            }
        });
    </script>
</html>
