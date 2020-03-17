<?php

//Start session
	session_start();

	//Connect to mysqli server
	require "dbconn.php";
    $user_id = $_POST['user_id'];
    $user_password = $_POST['user_password'];
	
	$query = $connection->prepare("SELECT * FROM tbl_user WHERE user_id='$user_id'");
    $query->execute();

    $user = $query->fetch();
    	
    $user_id = $user['user_id'];
    $passwordStored = $user['user_password'];
    	
	$passwordInput = $user_password;
	
	
	if ( $passwordStored == $passwordInput )  {
		
        //Login Successful
        session_regenerate_id();
		
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_email'] = $user['user_email'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['dep_id'] = $user['dep_id'];
			
			
        session_write_close();
		echo "SUCCESS!";
                                
        if ($_SESSION['user_type'] == 'admin'){ 
            echo "Login Successfull!";
            header("location: admin_home.php");
        }
        elseif($_SESSION['user_type'] == 'staff'){
            //header("location: staff_home.php");
            $prepDep = $connection->prepare("SELECT * FROM tbl_dep WHERE dep_id = $_SESSION[dep_id]");
            $prepDep->execute();
            $resultPrepDep = $prepDep->fetch();

            echo "<script type='text/javascript'>window.location.replace('staff_for_student_form_page.php')</script>";
            //header("location: staff_for_student_form_page.php?dep_name=".$dep_name."&dep_id=".$dep_id);
        }
        
        exit();
    }else {
        //Login failed
        echo "Failed!";
        
        exit();

    }

?>