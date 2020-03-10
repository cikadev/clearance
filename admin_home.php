<?php
    include("dbconn.php");
    session_start();
    if ($_SESSION['user_type'] != "admin"){
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

        <style type="text/css">
            body, html {
                height: 100%;
                margin: 0;
            }
            .bg {
                /* The image used */
                background-image: url("pic/backgroundd.jpg");

                /* Full height */
                height: 100%; 

                /* Center and scale the image nicely */
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;

                padding-top: 70px;
            }
        </style>

    </head>
    <body class="bg">
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-2 shadow justify-content-between">
            <a class="btn btn-outline-secondary nav-item text-white" href="admin_home.php">Home</a>
            <a class="navbar-brand text-white">President University Graduation Automated Clearance System</a>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="btn btn-outline-danger text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>

        <div class="container text-center">
            <div>
            <img src="pic/pulogo.png" class="img-fluid" alt="Responsive image" style="width: 10%;">
            <h5 class="text-center text-white">Passion . Responsibility . Entrepreneurial spirit . Sincerity . Inclusiveness . Dedication . Exellence . Nationalism . Trendsetter</h5>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                
                <div class="col-6">
                    <div class="container-fluid text-center" style="margin-top: 5px; z-index: 1;">
                        <img class="rounded-circle shadow" src="pic/dashboard.png" style="width: 200px;">          
                    </div>
                    <div class="container col-lg-12 shadow-lg rounded pb-1" style="margin-top: -100px; position: relative;">
                        <div class="text-center text-white" style="padding-top: 120px;">
                            <h1>Dashboard</h1>
                        </div>
                         <div class="card m-lg-5 text-center shadow" style="background-color: #d6cbd3;">        
                            <div class="row card-body" >
                                <div class="col-sm-3">
                                    <div class="row">
                                       
                                        <div class="col-12">
                                            <a type="button-rounded" class="btn btn-lg btn-info shadow" href="admin_manage_page1.php"><i class="fas fa-address-card fa-4x"></i><br>Manage the Account</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3" >
                                    <div class="row">
                                        
                                        <div class="col-12">
                                            <a type="button-rounded" class="btn btn-lg btn-info shadow" href="admin_manage_page2.php"><i class="fas fa-list-alt fa-4x"></i><br>Manage Clearance</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3" >
                                    <div class="row">
                                        
                                        <div class="col-12">
                                            <a type="button-rounded" class="btn btn-lg btn-info shadow" href="admin_report_page.php"><i class="fas fa-chart-line fa-4x"></i><br>Generate the Report</a>   
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-sm-3" >
                                    <div class="row">
                                        
                                        <div class="col-12">
                                            <a type="button-rounded" class="btn btn-lg btn-info shadow" href="admin_activate_id_page.php"><i class="fas fa-user-check fa-4x"></i><br>Activate Student ID</a>      
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="container-fluid text-center" style="margin-top: 5px; z-index: 1;">
                        <img src="pic/report.png" style="width: 200px;">          
                    </div>
                    <div class="container col-lg-12 shadow-lg rounded pb-1" style="margin-top: -100px; position: relative;">
                        <div class="text-center text-white" style="padding-top: 120px;">
                            <h1>Summary Reports</h1>
                        </div>
                         <div class="card m-lg-5 text-center my-5 shadow" style="background-color: #d6cbd3;">        
                            <div class="row card-body justify-content-center align-items-center" style="margin-bottom: 10px;">
                                <h2 class="mt-3">Total Student Based on Clearance Activity</h2>
                                <div class="row card-body justify-content-center align-items-center">
                                    <canvas id="myPie" style="max-width: 500px;"></canvas>
                                </div><hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <!-- Graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    
    <script type="text/javascript">
        <?php
          $done = 0;
          $counterC = 0;
          $undone = 0;
          $counterU = 0;
          $error = 0;

          $prep = $connection->prepare("SELECT COUNT(*) AS row FROM tbl_list");
          $prep->execute();
          $res = $prep->fetch();

          $prepdata = $connection->prepare("SELECT fk_id, COUNT(*) AS flag FROM tbl_cs WHERE cs_status ='Checked' GROUP BY cs_status, fk_id");
          $prepdata->execute();
          while($result = $prepdata->fetch()){
            if($result['flag'] == $res['row']){
              $done++;
            }
          }
          $prepdata2 = $connection->prepare("SELECT fk_id, COUNT(*) AS flag FROM tbl_cs WHERE cs_status ='Uncheck' GROUP BY cs_status, fk_id");
          $prepdata2->execute();
          while($result2 = $prepdata2->fetch()){
            $undone++;
          }
        ?>   

        var ctx = document.getElementById('myPie').getContext('2d');
        var chart = new Chart(ctx, {
          // The type of chart we want to create
          type: 'pie',

          // The data for our dataset
          data: {
            labels: ["Done", "Undone"],
            datasets: [{
              label: "Users (Status)",
              backgroundColor: ["#0000FF", "#FF0083"],
              data: [<?php echo $done.",".$undone?>]
            }]
          },

          // Configuration options go here
          options: {}
        });
    </script>
</html>
