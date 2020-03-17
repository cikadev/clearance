<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
    
    $sqlshow = $connection->prepare("SELECT * FROM tbl_user where user_type='staff'");
    $sqlshow->execute();
    
    $sqlshow2 = $connection->prepare("SELECT * FROM tbl_list ORDER BY step");
    $sqlshow2->execute();
  
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
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
                <h2 class="text-center">MANAGE STAFF</h2>
                <form action="admin_manage_staff_add.php" method="post">
                    <div class="container">
                        <b>Add New Staff</b><br>
                        <label for="user_name"><p>Staff User Name: </p></label>
                        <input type="text" placeholder="Enter User Name" name="user_name" value=""><br>
                        <label for="user_email"><p>Staff Email: </p></label>
                        <input type="text" placeholder="Enter Staff Email" name="user_email" value=""><br>
                        <label for="user_id"><p>Staff Id: </p></label>
                        <input type="text" placeholder="Enter Staff ID" name="user_id" value=""><br>
                        <label for="user_password"><p>Staff Password: </p></label>
                        <input type="text" placeholder="Enter Staff Password" name="user_password" value=""><br>
                        <label for="user_type"><p>User Type: </p></label>
                        <input type="text" placeholder="Enter User Type" name="user_type" value="staff" readonly><br>
                        <button class="button" type="submit">Add</button><br>
                    </div>
                </form>
            
                    <table class="table table-striped">
                        <thead>
                            <br><b>Manage Staff Data </b>
                            <tr>
                                <th style="width: 20%">No.</th>
                                <th style="width: 20%">User Name</th>
                                <th style="width: 20%">Password</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counterselect = 1;
                            while($result = $sqlshow->fetch()){
                                $name = "step".$counterselect;
                                $row = "row".$counterselect;
                                $sqlshowstep=$connection->prepare("SELECT * FROM tbl_user");
                                $sqlshowstep->execute();
                                echo "<tr>";
                                    echo "<td>".$counterselect."</td>";
                                    echo  "<td>"; echo $result['user_name']; echo "</td>";
                                    echo  "<td>"; echo $result['user_password']; echo "</td>";
                        
                                    echo "<td>";
                                    echo "<a href='admin_manage_staff_edit_page.php?user_id="; echo $result['user_id']; echo"'>Edit</a>&nbsp";
                                    echo "<a href='admin_manage_staff_delete.php?user_id="; echo $result['user_id']; echo"'>Delete</a>";
                                    echo "</td>";
                                echo "</tr>";
                                $counterselect++;

                            }
                            ?>
                        </tbody>
                    </table>
               
            </div>
        </div>
        <div class="container bg-white">
                <div class="container">
                    <table class="table table-striped">
                        <thead>
                            <br><b>Manage Staff PIN </b>
                            <tr>
                                <th style="width: 20%">Number of Step</th>
                                <th style="width: 20%">Activity</th>
                                <th style="width: 20%">PIN</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counterselect = 1;
                            while($result = $sqlshow2->fetch()){
                                $name = "step".$counterselect;
                                $row = "row".$counterselect;
                               
                                echo "<tr>";
                                echo "<td>".$counterselect."</td>";
                                echo  "<td>"; echo $result['activity']; echo "</td>"; 
                                echo  "<td>"; echo $result['pin']; echo "</td>";

                            echo "<td>";
                            echo "<a href='admin_manage_pin_edit.php?pin=".$result['pin']."'>Edit PIN</a>&nbsp";
                                echo "</tr>";
                                $counterselect++;
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="container">
                    <a class="float-right btn btn-outline-primary" href="logout.php">Logout</a>
                </div>
            </div>
    </body>
</html>