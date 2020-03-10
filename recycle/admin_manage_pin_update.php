<?php
	session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

	$pin=$_POST['pin'];
 
	$activity=$_POST['activity'];
 
    $update = $connection->prepare("UPDATE tbl_list SET pin='$pin' WHERE activity='$activity'");
    $update->execute();
	//header('location:admin_manage_staff_page.php');
?>