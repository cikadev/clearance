<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    $user_id=$_GET['user_id'];
	

    $query = $connection->prepare("SELECT * from tbl_user WHERE user_id='$user_id'");
    $query->execute();
    $result = $query->fetch();
?>

<!DOCTYPE html>
<html>
<body>
	<h2>Edit</h2>
	<form method="POST" action="admin_manage_staff_update.php?user_id=<?php echo $result['user_id']; ?>">
		<label>Staff Name:</label><input type="text" value="<?php echo $result['user_name']; ?>" name="user_name"><br>
		<label>Staff Password:</label><input type="text" value="<?php echo $result['user_password']; ?>" name="user_password"><br>
		<input type="submit" name="submit"><br>
		<a href="admin_manage_staff_page.php">Back</a>
	</form>
</body>
</html>