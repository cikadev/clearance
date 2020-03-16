<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: login_page.html");
    }
    
    $email = $_POST['email'];
    $password = $_POST['password'];
	
	$query = $connection->prepare("SELECT * FROM tbl_user WHERE user_type='student'");
    $query->execute();

    $user = $query->fetch();
    	
    $email = $user['email'];
    $passwordStored = $user['password'];
    	
	$passwordInput = $password;
	
	
	if ( $passwordStored == $passwordInput )  {
		
        //Login Successful
        session_regenerate_id();
		
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['user_type'] = $user['user_type'];
			
			
        session_write_close();
		echo "SUCCESS!";
                                
        if ($_SESSION['user_type'] == 'student'){ 
            echo "Login Successfull!";
            header("location: student_form_page.php");
        }else {
        //Login failed
        echo "Failed!";
        
        exit();

    }

 
    header("Location: manage_list_page.php");
?>
