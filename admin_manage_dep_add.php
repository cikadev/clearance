<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    
    $dep_name=$_POST['dep_name'];
    $place=$_POST['place'];
        
    $insert = $connection->prepare("INSERT INTO tbl_dep (dep_name, place) VALUES (:dep_name, :place)");
    $insert->bindParam(':dep_name', $dep_name, PDO::PARAM_STR);
    $insert->bindParam(':place', $place, PDO::PARAM_STR);


    if($insert->execute()){
      header("Location: admin_manage_page1.php");
       
    }
?>
