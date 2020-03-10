<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
    $sqlshow=$connection->prepare("SELECT * FROM tbl_list ORDER BY step");
    $sqlshow->execute();
    
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
            <div class="container">
                <h2 class="text-center">Input New Activity</h2>
                <form action="admin_manage_list_add.php" method="post">
                        Input Activity: <input type="text" name="activity" value="">
                        <button type="submit">Add</button>
                </form>
            </div>
            <div class="container">
                <form action="admin_manage_list_update.php" method="post">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 20%">Number of Step</th>
                                <th style="width: 20%">Activity</th>
                                <th style="width: 20%">PIN</th>
                                <th style="width: 20%">Change the Step Number</th>
                                <th style="width: 20%">Delete Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //$counter=0;
                            $counterselect = 1;
                            while($result = $sqlshow->fetch()){
                                //$counter++;
                                
                                $name = "step".$counterselect;
                                $row = "row".$counterselect;
                                $sqlshowstep=$connection->prepare("SELECT * FROM tbl_list ORDER BY step");
                                $sqlshowstep->execute();
                                echo "<tr>";
                                echo "<td>".$counterselect."</td>";
                                echo  "<td>"; echo "<input type='text' name='"; echo $row;  echo "'value='"; echo $result['activity']; echo"' readonly=true>"; echo "</td>";
                                echo  "<td>"; echo $result['pin']; echo "</td>";
                                echo  "<td>"; 
                                    echo "<select class='selectRound' name='"; echo $name; echo"'>"; 
                                        echo "<option selected='true' disabled='true'> - select -</option>";
                                        while($step = $sqlshowstep->fetch()){ 
                                            echo"<option name='step'>"; echo $step['step']; echo"</option>";
                                        } 
                                        echo "</select>"; echo "</td>";
                                echo "<td>";
                                echo "<a href='admin_manage_list_delete.php?pin="; echo $result['pin']; echo"'>Delete</a>";
                                echo "</td>";
                                echo"</tr>";
                                $counterselect++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <button type="submit">Update</button>
                </form>
                <div class="container">
                <a class="float-right btn btn-outline-primary" href="logout.php">Logout</a>
            </div>
            </div>
        </div>
    </body>
</html>


<script>
    $(document).on('change', '.selectRound', function(e) {
        var tralse = true;
        var selectRound_arr = []; // for contestant name
        $('.selectRound').each(function(k, v) {
            var getVal = $(v).val();
            //alert(getVal);
            if (getVal && $.trim(selectRound_arr.indexOf(getVal)) != -1) {
            tralse = false;
            //it should be if value 1 = value 1 then alert, and not those if -select- = -select-. how to    avoid those -select-
            alert('Number of step cannot be same');
            $(v).val("");
            return false;
            } else {
            selectRound_arr.push($(v).val());
            }

        });
            if (!tralse) {
            return false;
        }
    });
</script>
