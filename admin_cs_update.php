<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: login_page.html");
    }

    $sql = $connection->prepare("SELECT * FROM tbl_student WHERE student_status='graduate' AND student_upd_status = ''");
    $sql->execute();
    
    

    while($result = $sql->fetch()){
        $sql2 = $connection->prepare("SELECT * FROM tbl_list ORDER BY id");
        $sql2->execute();
        
        $cs_status = "Uncheck";
        while($result2 = $sql2->fetch()){
//            
            $cs_id = $result['student_id']."-".$result2['id'];
            $fk_id = $result['student_id'];
            $fk_step = $result2['step'];

            $activity = $result2['activity'];
            

            $dep_id = $result2['dep_id'];
            
            $insert = $connection->prepare("INSERT INTO tbl_cs (cs_id, activity, cs_status, fk_id, fk_step, dep_id) VALUES (:cs_id, :activity, :cs_status, :fk_id, :fk_step, :dep_id)");
            $insert->bindParam(':cs_id', $cs_id, PDO::PARAM_STR);
            $insert->bindParam(':activity', $activity, PDO::PARAM_STR);
            $insert->bindParam(':cs_status', $cs_status, PDO::PARAM_STR);
            $insert->bindParam(':fk_id', $fk_id, PDO::PARAM_STR);
            $insert->bindParam(':fk_step', $fk_step, PDO::PARAM_STR);
            $insert->bindParam(':dep_id', $dep_id, PDO::PARAM_STR);

            if($insert->execute()){
                $message = "Data Has been updated";
                echo "<script type='text/javascript'>alert('$message');</script>";

                $sqlupdate = $connection->prepare("UPDATE tbl_student
                                                    SET student_upd_status = 'SU'
                                                    WHERE student_id = '$result[student_id]'");
                $sqlupdate->execute();
            }else{
                $message = "ERROR";
                echo "<script type='text/javascript'>alert('$message');</script>";
                exit();
            }
            
        }
        
    }
    header("location: admin_manage_page1.php");
?>