<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    $sqlshow3 = $connection->prepare("SELECT * FROM tbl_user where user_type='staff'");
    $sqlshow3->execute();
          
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
    <body>
        <table id="editable_table" class="table table-bordered table-striped bg-white table-responsive mt-4">
            <thead class="thead-dark">
                <div class="text-center my-3">
                    <b>Staff Data</b>
                </div>
                <tr>
                    <th style="width: 5%">No.</th>
                    <th style="width: 20%">User ID</th>
                    <th style="width: 20%">User Name</th>
                    <th style="width: 20%">Password</th>
                    <th style="width: 20%">Department ID</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $counterselect = 1;
                        while($result3 = $sqlshow3->fetch()){
                            $name = "step".$counterselect;
                            $row = "row".$counterselect;
                            $sqlshowstep=$connection->prepare("SELECT * FROM tbl_user");
                            $sqlshowstep->execute();
                            echo "<tr>";
                                echo "<td>".$counterselect."</td>";
                                echo  "<td>"; echo $result3['user_id']; echo "</td>";
                                echo  "<td>"; echo $result3['user_name']; echo "</td>";
                                echo  "<td>"; echo $result3['user_password']; echo "</td>";
                                echo  "<td>"; echo $result3['dep_id']; echo "</td>";
                            echo "</tr>";
                            $counterselect++;
                        }
                    ?>
                </tbody>
        </table>
    </body>
    <script type="text/javascript">
        $('#editable_table').Tabledit({
            url:'admin_manage_staff_editable_action.php',
            columns:{
                identifier:[1, "user_id"],
                editable:[[2, 'user_name'], [3, 'user_password']
            },
            restoreButton:false,
            onSuccess:function(data, textStatus, jqXHR){
                if(data.action == 'delete'){
                    $('#'+data.id).remove();
                }
            }
        });
     
    });  
    </script>
</html>
