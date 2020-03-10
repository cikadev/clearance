<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    $user_id=$_GET['user_id'];
	

    $query = $connection->prepare("DELETE from tbl_user WHERE user_id='$user_id'");
    $query->execute();


function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";}
    header('location:admin_manage_staff_page.php');

?>