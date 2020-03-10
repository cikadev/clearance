<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    $pin=$_GET['pin'];
	

    $query = $connection->prepare("SELECT * from tbl_list WHERE pin='$pin'");
    $query->execute();
    $result = $query->fetch();
?>

<!DOCTYPE html>
<html>
<body>
    <a href="admin_manage_page1.php">Back</a>
	<h2>Edit PIN</h2>
	<form method="POST" action="admin_manage_pin_update.php?id=<?php echo $result['pin']; ?>">
		<label>Activity:</label><input type="text" value="<?php echo $result['activity']; ?>" name="activity" readonly><br>
        <label>PIN:</label><input type="text" value="<?php echo $result['pin']; ?>" name="pin"><br>
		<input type="submit" name="submit"><br>
	</form>
</body>
</html>