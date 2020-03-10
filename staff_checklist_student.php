<?php
    session_start();
    include('dbconn.php');

    if ($_SESSION['user_type'] != "staff"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    $cs_id = $_GET['cs_id'];
    $dep_id = $_GET['dep_id'];
    $std_id = $_GET['std_id'];
    $prev_step = $_GET['prev_step'];
    $prev_cs_id = $std_id."-".$prev_step;
    //$step = (int)$_GET['step'];

    $now = date("Y/m/d");

    /*CURRENT STATUS*/
    $sql = $connection->prepare("SELECT cs_status FROM tbl_cs WHERE cs_id = '$cs_id'");
    $sql->execute();
    $status = $sql->fetch();
    $curr_stts = $status['cs_status']; 

    /*PREV STATUS*/
    $prevStat = $connection->prepare("SELECT cs_status, activity FROM tbl_cs WHERE cs_id = '$prev_cs_id'");
    $prevStat->execute();
    $resultprevStat = $prevStat->fetch();
    $prev_stat = $resultprevStat['cs_status']; 

    if($prev_stat == "Checked" || $prev_stat == NULL){
        if($dep_id == $_SESSION['dep_id']){
            if($curr_stts == "Uncheck"){
                $sqlupdate = $connection->prepare("UPDATE tbl_cs 
                                                   SET cs_status = 'Checked',
                                                   signed = '$_SESSION[user_name]',
                                                   last_updated = '$now'
                                                   WHERE cs_id = '$cs_id'");
                if($sqlupdate->execute()){
                    $message2 = "Success checked !";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
                    
                }
                
            }elseif($curr_stts == "Checked"){
                $message3 = "Already checked !";
                echo "<script type='text/javascript'>alert('$message3');</script>";
            }else{
                $message4 = "DENIED";
                echo "<script type='text/javascript'>alert('$message4');</script>";
            }
        }
        else{
           $message5 = "YOU ARE NOT ALLOWED!";
                echo "<script type='text/javascript'>alert('$message5');</script>";
            //header("Location:staff_show_student_form.php"); 
        }
    }
    elseif($prev_stat == "Uncheck"){
        $message6 = "YOU HAVE NOT COMPLETED ".$resultprevStat['activity'];
        echo "<script type='text/javascript'>alert('$message6');</script>";
    }

?>
<script type="text/javascript">
    window.location.href = "staff_show_student_form.php";
</script>
