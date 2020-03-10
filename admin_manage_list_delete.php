<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    $activity=$_GET['activity'];
	

    $query = $connection->prepare("DELETE from tbl_list WHERE activity='$activity'");
    $query->execute();

    header('location:admin_manage_page2.php');

?>