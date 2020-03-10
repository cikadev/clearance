<?php
	session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

	$user_id=$_GET['user_id'];
	$user_name=$_POST['user_name'];
	$user_password=$_POST['user_password'];
 
    $update = $connection->prepare("UPDATE tbl_user SET user_name='$user_name', user_password='$user_password' WHERE user_id='$user_id'");
    $update->execute();
	header('location:admin_manage_page1.php');
?>