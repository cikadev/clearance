<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    
    $prep = $connection->prepare("SELECT * FROM tbl_user WHERE user_type='staff'");
    $prep->execute();

    $num = 1;
    while($result = $prep->fetch()){
        $num++;
    }

    $user_name=$_POST['user_name'];
    $user_email=$_POST['user_email'];
    $user_id=$_POST['user_id'];
    $user_password=$_POST['user_password'];
    $dep_id=$_POST['dep_id'];
    $user_type="staff";
        
    $insert = $connection->prepare("INSERT INTO tbl_user (user_name, user_email, user_id, user_password, dep_id, user_type) VALUES (:user_name, :user_email, :user_id, :user_password, :dep_id, :user_type)");
    $insert->bindParam(':user_name', $user_name, PDO::PARAM_STR);
    $insert->bindParam(':user_email', $user_email, PDO::PARAM_STR);
    $insert->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $insert->bindParam(':user_password', $user_password, PDO::PARAM_STR);
    $insert->bindParam(':dep_id', $dep_id, PDO::PARAM_STR);
    $insert->bindParam(':user_type', $user_type, PDO::PARAM_STR);

    $insert->execute();
 
    header("Location: admin_manage_page1.php");
?>
