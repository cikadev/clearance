<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
    

    $stmt = $connection->prepare("SELECT * FROM tbl_list");
    $stmt->execute();

    $counter = 0;

    while($result = $stmt->fetch()){
        $counter++;
        $row = "row".$counter;
        $depen = "depen".$counter;
        $dep_row = "dep".$counter;
        $prev_step = "prevStep".$counter;
        
        $activity = $_POST[$row];
        $dependency = $_POST[$depen];
        $dep = $_POST[$dep_row];
        
        
        if($dependency == 'Dependent'){
            $prevStep = $_POST[$prev_step];
            if(isset($prevStep) && !empty($prevStep)){
                $sqlupdate = $connection->prepare("UPDATE tbl_list
                                                   SET step = '$prevStep', dep_id = '$dep', dependency = '$dependency'
                                                   WHERE activity = '$activity'");
            }
            else{
                $message = $activity."is dependent ! Must have pervious step";
                echo "<script type='text/javascript'>alert('$message');</script>";
                echo "<script type='text/javascript'>window.location.replace('ssss.php');</script>";
                exit();
            }
        }
        elseif($dependency == 'Independent'){
            $sqlupdate = $connection->prepare("UPDATE tbl_list
                                               SET dep_id = '$dep', dependency = '$dependency', step = 0
                                               WHERE activity = '$activity'");
        }
        if($sqlupdate->execute()){
            header("Location: admin_manage_page2.php");          
        }
    }

  
?>