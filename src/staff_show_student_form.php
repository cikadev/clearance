<?php
    
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "staff"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
        
    $dep_name = $_SESSION['dep_id'];
    $query2 = $connection->prepare("SELECT * FROM tbl_dep WHERE dep_name = '$dep_name'");
    $query2->execute();

    $std_id = $_SESSION['std_id'];
    $user_id = $_SESSION['user_id'];

    $toga = $connection->prepare("SELECT toga_size FROM tbl_student WHERE student_id = '$std_id'");
    $toga->execute();
    $resultToga = $toga->fetch();
    
?>
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

    <body class="container vh-100" style="background-image: url(assets/img/backgroundhome.png); background-size: cover;">
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-2 shadow justify-content-between">
            <a class="btn btn-outline-secondary nav-item text-white" href="staff_for_student_form_page.php">Home</a>
            <a class="navbar-brand text-white">President University Graduation Automated Clearance System</a>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="btn btn-outline-danger text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
      

        <div class="container-fluid card col-sm-12 text-center justify-content-center align-items-center shadow text-white" style="margin-top: 100px; margin-bottom: 100px; background-image: url(assets/img/background.png); background-size: cover;">
            <h2 class="text-center mt-3">Checklist the Student Activity</h2>
                <div class="card-body table-responsive">
                    <form action="staff_submit_student_data.php" method="post">
                        <div class="row justify-content-center align-items-center">
                            <div class="text-center">
                                <img src="assets/img/pulogo.png" class="img-fluid" alt="Responsive image" style="width: 20%;">
                                <p class="text-center my-3">Passion . Responsibility . Entrepreneurial spirit . Sincerity . Inclusiveness . Dedication . Exellence . Nationalism . Trendsetter</p>
                            </div>
                        </div>
                        <div class="card-header rounded" style="background-image: url(assets/img/bg.png);">
                            <div>
                                <h1 class="text-center text-dark">Student Graduation Clearance Form</h1>
                            </div>
            
                        <div class="form-group">
                            <h5 class="text-dark float-left">Toga Size : <?php echo $resultToga['toga_size']?></h5>
                            <table class="table table-bordered table-striped bg-white table-responsive">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 5%">No.</th>
                                        <th style="width: 20%">Activity</th>
                                        <th style="width: 20%">Status</th>
                                        <th style="width: 20%">Action</th>
                                        <th style="width: 20%">Sign by</th>
                                        <th style="width: 20%">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql2 = $connection->prepare("SELECT COUNT(*) AS tot_list FROM tbl_list");
                                        $sql2->execute();
                                        $tot_list = $sql2->fetch();

                                        $counter  = 1;
                                        $flag=1;
                                        while ($counter <= $tot_list['tot_list']) {
                                            $cs_id = $std_id."-".$counter;
                                            $sql = $connection->prepare("SELECT * FROM tbl_cs WHERE cs_id = '$cs_id' AND dep_id = '$_SESSION[dep_id]'");
                                            $sql->execute();

                                            $prepPrev = $connection->prepare("SELECT step FROM tbl_list WHERE dep_id = '$_SESSION[dep_id]'");
                                            $prepPrev->execute();
                                            $resultprepPrev = $prepPrev->fetch();

                                            while($result = $sql->fetch()){
                                                
                                                echo "<tr>";
                                                echo "<td>".$counter."</td>";
                                                echo "<td>".$result['activity']."</td>";
                                                echo "<td>".$result['cs_status']."</td>";

                                                if($flag == 1){
                                                    echo "<td>
                                                            <a class='btn btn-outline-success fas fa-check-square' href='staff_checklist_student.php?cs_id=".$cs_id."&dep_id=".$result['dep_id']."&std_id=".$std_id."&prev_step=".$resultprepPrev['step']."'> CHECK</a>
                                                          </td>";
                                                }
                                                elseif ($flag == 0) {
                                                    echo "<td>
                                                            <a class='btn btn-outline-success fas fa-check-square disabled'  href='staff_checklist_student.php?cs_id=".$cs_id."dep_id=".$result['dep_id']."&std_id=".$std_id."'> CHECK</a>
                                                          </td>";
                                                }
                                                if($result['cs_status'] == 'Checked'){
                                                    $flag = 1;
                                                }
                                                elseif($result['cs_status'] == 'Uncheck'){
                                                    $flag =0;
                                                }


                                                echo "<td>".$result['signed']."</td>";
                                                echo "<td>".$result['last_updated']."</td>";
                                                echo "</tr>";
                                            }
                                            $counter++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
