<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
    
    $sqlprepare = $connection->prepare("SELECT * FROM puis_student WHERE std_status = 'graduate'");
    $sqlprepare->execute();

    while($result=$sqlprepare->fetch()){
        $sqlinsert = $connection->prepare("INSERT INTO tbl_student 
                                           SET student_id='$result[std_id]', 
                                               student_name='$result[std_name]',
                                               student_email='$result[std_email]',
                                               student_batch='$result[std_batch]',
                                               student_bod='$result[std_bod]',
                                               student_major='$result[std_prodi]',
                                               student_user_type='$result[std_user_type]',
                                               student_status='$result[std_status]'
                                           ON DUPLICATE KEY UPDATE
                                               student_id='$result[std_id]', 
                                               student_name='$result[std_name]',
                                               student_email='$result[std_email]',
                                               student_batch='$result[std_batch]',
                                               student_bod='$result[std_bod]',
                                               student_major='$result[std_prodi]',
                                               student_user_type='$result[std_user_type]',
                                               student_status='$result[std_status]'");
        
        
        $sqlinsert->execute();
    }

    header("Location: admin_manage_page1.php");
  
?>