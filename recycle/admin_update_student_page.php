<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
    
    $sqlshow = $connection->prepare("SELECT * FROM tbl_student WHERE student_status='graduate'");
    $sqlshow->execute();
    
    $sqlshow2 = $connection->prepare("SELECT * FROM tbl_cs");
    $sqlshow2->execute();
    
      
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
            <a class="float-left btn btn-outline-primary" href="admin_manage_account_page.php">Back</a>
            <div class="container bg-white">
                <h2 class="text-center">Update Student</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%">No.</th>
                            <th style="width: 20%">Name</th>
                            <th style="width: 20%">Email</th>
                            <th style="width: 20%">User Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $number = 1;
                        while($result = $sqlshow->fetch()){
                            echo "<tr>";
                            echo  "<td>"; echo $number; echo "</td>";
                            echo  "<td>"; echo $result['student_name']; echo "</td>";
                            echo  "<td>"; echo $result['student_email']; echo "</td>";
                            echo  "<td>"; echo $result['student_user_type']; echo "</td>";
                            echo "<td>";
                            echo "</td>";
                            echo"</tr>";
                            $number++;
                        }
                        ?>
                        
                    </tbody>
                </table>
                <button class="button" onclick="window.location.href = 'admin_update_student.php';">Update Student</button>
           
            </div>
        </div>
        
        <div class="container bg-white">
            <h2 class="text-center">Student Data of Clearance Checklist</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%">No.</th>
                        <th style="width: 20%">Checklist ID</th>
                        <th style="width: 20%">Checklist Status</th>
                        <th style="width: 20%">Student ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $number = 1;
                        while($result2 = $sqlshow2->fetch()){
                            echo "<tr>";
                            echo  "<td>"; echo $number; echo "</td>";
                            echo  "<td>"; echo $result2['cs_id']; echo "</td>";
                            echo  "<td>"; echo $result2['cs_status']; echo "</td>";
                            echo  "<td>"; echo $result2['fk_id']; echo "</td>";
                            echo "<td>";
                            echo "</td>";
                            echo"</tr>";
                            $number++;
                        }
                    ?>
                </tbody>
            </table>
            <button class="button" onclick="window.location.href = 'admin_cs_update.php';">Update Student Clearance Checklist</button>
            <div class="container">
                <a class="float-right btn btn-outline-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </body>
</html>