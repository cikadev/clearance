<?php

//Start session

	session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "staff"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    $pin_input = $_POST['pin'];
	
	$query = $connection->prepare("SELECT * FROM tbl_dep WHERE dep_id='$_SESSION[dep_id]'");
    $query->execute();

    $list = $query->fetch();
    $pin_stored = $list['pin'];
    $dep_id = $list['dep_id'];
    $dep_name = $list['dep_name'];
    
    
	if ($pin_input == $pin_stored){
        
        header("location: staff_for_student_form_page.php?dep_name=".$dep_name."&dep_id=".$dep_id);
        
        exit();
    }else {
        //failed
        echo "Failed!";
        
        exit();

    }

?>