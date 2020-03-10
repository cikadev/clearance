<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "staff"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    $std_id = $_POST['student_id'];
    $bod = $_POST['bod'];
    $card_id = $_POST['card_id'];
    if($_POST['card_id'] != NULL){
        $sqlpreparecard = $connection->prepare("SELECT * FROM tbl_student WHERE card_id = '$card_id'");
        $sqlpreparecard->execute();
        $resultcard = $sqlpreparecard->fetch();

        $cardStored = $resultcard['card_id'];

        if($card_id === $cardStored){
            $_SESSION['std_id'] = $resultcard['student_id'];
            $messageIn = "WELCOME ".$_SESSION['std_id'];
            echo "<script type='text/javascript'>alert('$messageIn');</script>";
            echo "<script type-'text/javascript>window.location.replace('staff_show_student_form.php');</script>'";
        }
        else{
             $messageIn = $card_id.' ID IS NOT REGISTERED! ';
            echo "<script type='text/javascript'>alert('$messageIn');</script>";
            echo "<script type-'text/javascript>window.location.replace('staff_for_student_form_page.php');</script>'";
        }
    }
    elseif(isset($_POST['bod']) && isset($_POST['student_id'])){
        $sqlprepare = $connection->prepare("SELECT * FROM tbl_student WHERE student_id = '$std_id'");
        $sqlprepare->execute();
        $result = $sqlprepare->fetch();

        $bodStored = $result['student_bod'];

        if($bod === $bodStored){
            $_SESSION['std_id'] = $result['student_id'];
            $messageIn = "WELCOME ".$_SESSION['std_id'];
            echo "<script type='text/javascript'>alert('$messageIn');</script>";
            echo "<script type-'text/javascript>window.location.replace('staff_show_student_form.php');</script>'";
        }
        else{
            $messageIn = "STUDENT ID or BOD INCORRECT";
            echo "<script type='text/javascript'>alert('$messageIn');</script>";
        }
    }
    
?>
