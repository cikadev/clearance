<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
    
    $prep = $connection->prepare("SELECT COUNT(*) as row FROM tbl_list");
    $prep->execute();

    $result = $prep->fetch();
    $step = $result['row']+1;

    $activity=$_POST['activity'];
    
        
    $insert = $connection->prepare("INSERT INTO tbl_list (step, activity) VALUES (:step, :activity)");
    $insert->bindParam(':step', $step, PDO::PARAM_STR);
    $insert->bindParam(':activity', $activity, PDO::PARAM_STR);
    
    if($insert->execute()){    
        header("Location: admin_manage_page2.php");
    }
 
?>
