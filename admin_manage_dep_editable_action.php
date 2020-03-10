<?php  

	$connect = mysqli_connect('localhost', 'root', '', 'puacs');

	$input = filter_input_array(INPUT_POST);

	$dep_name = mysqli_real_escape_string($connect, $input["dep_name"]);
	$place = mysqli_real_escape_string($connect, $input["place"]);

	if($input["action"] === 'edit'){
		$query = "UPDATE tbl_dep 
					SET dep_name = '".$dep_name."', 
	 					place = '".$place."' 
	 				WHERE dep_id = '".$input["dep_id"]."'";
		mysqli_query($connect, $query);
	}
	if($input["action"] === 'delete'){
		$query = "DELETE FROM tbl_dep 
					WHERE dep_id = '".$input["dep_id"]."'";
	 	mysqli_query($connect, $query);
	}

	echo json_encode($input);

?>