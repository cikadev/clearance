<?php  

	$connect = mysqli_connect('localhost', 'root', '', 'puacs');

	$input = filter_input_array(INPUT_POST);

	$user_name = mysqli_real_escape_string($connect, $input["user_name"]);
	$user_pass = mysqli_real_escape_string($connect, $input["user_password"]);
	$dep_id = mysqli_real_escape_string($connect, $input["dep_id"]);

	if($input["action"] === 'edit'){
		$query = "UPDATE tbl_user SET user_name = '".$user_name."', 
									user_password = '".$user_pass."',
									dep_id = '".$dep_id."' 
	 					WHERE user_id = '".$input["user_id"]."'";

	 	mysqli_query($connect, $query);
	}
	
	if($input["action"] === 'delete'){
	 	$query = "DELETE FROM tbl_user 
	 				WHERE user_id = '".$input["user_id"]."'";
	 	mysqli_query($connect, $query);
	}

	echo json_encode($input);

?>