<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
    
    $sqlshow = $connection->prepare("SELECT * FROM tbl_student WHERE student_status='graduate'");
    $sqlshow->execute();
    
    $sqlshow2 = $connection->prepare("SELECT * FROM tbl_cs");
    $sqlshow2->execute();
    

    $sqlshow3 = $connection->prepare("SELECT * FROM tbl_user where user_type='staff'");
    $sqlshow3->execute();
    
    $sqlshow4 = $connection->prepare("SELECT * FROM tbl_dep ORDER BY dep_id");
    $sqlshow4->execute();
      
?>
<!DOCTYPE html>
<html>
	<head>
		<title>PUGACS</title>
		<meta charset="utf-8">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>            
    	
	</head>
	<body class="vh-100" style="background-color: #18318b">
		<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-2 shadow justify-content-between">
            <a class="btn btn-outline-secondary nav-item text-white" href="admin_home.php">Home</a>
            <a class="navbar-brand text-white">President University Graduation Automated Clearance System</a>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="btn btn-outline-danger text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
        <div class="container-fluid text-center" style="margin-top: -100px; position: absolute; z-index: 1;">
            <img class="rounded-circle shadow" src="assets/img/mnguser.png" style="width: 200px;">
        </div>

		<div class="container col-lg-10 shadow-lg rounded" style="margin-top: 200px; position: relative; margin-bottom: 150px; background-image: url(assets/img/background.png); background-position: center; background-repeat: no-repeat; background-size: cover;">
			<div class="container-fluid" style="padding-top: 100px;" >
				<h1 class="font-weight-bold text-center text-white" style="padding-top: 20px;"><?php echo "Welcome Back, ".$_SESSION['user_name'];  echo "!";?></h1>
			</div>
			<div class="row justify-content-center align-items-center">
				<div class="text-center">
					<img src="assets/img/pulogo.png" class="img-fluid my-3" alt="Responsive image" style="width: 10%;">
					<p class="text-center text-white">Passion . Responsibility . Entrepreneurial spirit . Sincerity . Inclusiveness . Dedication . Exellence . Nationalism . Trendsetter</p>
			    </div>
				<div class="col-10 rounded my-3 align-content-center justify-content-center">
					<div class="bg-white rounded">
					<ul class="nav nav-tabs nav-justified align-content-center justify-content-center" id="myTab" role="tablist">
						<li class="nav-item">
    						<a class="nav-link active" id="upstd-tab" data-toggle="tab" href="#upstd" role="tab" aria-controls="upstd" aria-selected="true">Update Student</a>
  						</li>
						<li class="nav-item">
							<a class="nav-link" id="mngstf-tab" data-toggle="tab" href="#staff" role="tab" aria-controls="mngstf" aria-selected="false">Manage Staff/ Clearing Officer</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="mngdep-tab" data-toggle="tab" href="#dep" role="tab" aria-controls="mngdep" aria-selected="false">Manage Department</a>
						</li>
					</ul>
					<div class="tab-content my-3" id="myTabContent">
  						<div class="container-fluid tab-pane fade show active" id="upstd" role="tabpanel" aria-labelledby="upstd-tab">
  							<div class="row" style="margin-bottom: 100px;">
	  							<div class="container col-6 span6 bg-white rounded" style="padding-right:15px; border-right: 1px solid #ccc;">
					                <h2 class="text-center my-3">Update Student</h2>
					                <table class="table table-bordered table-striped bg-white table-responsive">
					                    <thead class="thead-dark">
					                        <tr class="text-center">
					                            <th style="width: 5%">No.</th>
					                            <th style="width: 20%">Name</th>
					                            <th style="width: 20%">Email</th>
					                            <th style="width: 20%">Batch</th>
					                            <th style="width: 20%">Major</th>
					                        </tr>
					                    </thead>
					                    <tbody>
					                        <?php
						                        $number = 1;
						                        while($result = $sqlshow->fetch()){
						                            echo "<tr>";
						                            echo  "<td>"; echo $number; echo "</td>";
						                            echo  "<td>"; echo $result['student_name']; echo "</td>";
						                            echo  "<td>"; echo $result['student_email']; echo "</td>";
						                            echo  "<td>"; echo $result['student_batch']; echo "</td>";
						                            echo  "<td>"; echo $result['student_major']; echo "</td>";
						                            
						                            echo"</tr>";
						                            $number++;
						                        }
					                        ?>
					                    </tbody>
					                </table>
					                <div class="text-center">
					                	<button class="button btn btn-info my-3" onclick="window.location.href = 'admin_update_student.php';">Update Student</button>
					                </div>
					            </div>
						        <div class="container col-6 bg-white rounded">
						            <h2 class="text-center my-3">Student Data of Clearance Checklist</h2>
						            <table class="table table-bordered table-striped bg-white table-responsive">
						                <thead class="thead-dark">
						                    <tr class="text-center">
						                        <th style="width: 5%">No.</th>
						                        <th style="width: 20%">Checklist ID</th>
						                        <th style="width: 20%">Activity</th>
						                        <th style="width: 20%">Checklist Status</th>
						                        <th style="width: 20%">Student ID</th>
						                        <th style="width: 20%">Dept ID</th>
						                    </tr>
						                </thead>
						                <tbody>
						                    <?php
						                        $number = 1;
						                        while($result2 = $sqlshow2->fetch()){
						                            echo "<tr>";
						                            echo  "<td>"; echo $number; echo "</td>";
						                            echo  "<td>"; echo $result2['cs_id']; echo "</td>";
						                            echo  "<td>"; echo $result2['activity']; echo "</td>";
						                            echo  "<td>"; echo $result2['cs_status']; echo "</td>";
						                            echo  "<td>"; echo $result2['fk_id']; echo "</td>";
						                            echo  "<td>"; echo $result2['dep_id']; echo "</td>";
						                            echo"</tr>";
						                            $number++;
						                        }
						                    ?>
						                </tbody>
						            </table>
						            <div class="text-center">
						            	<button class="button btn btn-info my-3" onclick="window.location.href = 'admin_cs_update.php';">Update Student Clearance Checklist</button>
						            	
						            </div>
		  						</div>
	  						</div>
				        </div>
				        




  						<div class="container-fluid tab-pane fade" id="staff" role="tabpanel" aria-labelledby="mngstf-tab">
  							<div>
					        	<h2 class="text-center">Manage Staff</h2>	
  							</div>
  							<div class="row" style="margin-bottom: 100px;">
	  							<div class="container col-4 span6 bg-white rounded" style="padding-right:15px; border-right: 1px solid #ccc;">
					                <form action="admin_manage_staff_add.php" method="post">
					                    <div class="form-group table-responsive">
					                    	<div class="text-center my-3">
				                            	<b>Add New Staff</b>
				                            </div>
					                        <label class="my-0" for="user_id"></label>
					                        <input class="form-control" type="text" placeholder="Enter Staff ID" name="user_id" value="">
					                        
					                        <label class="my-0" for="user_name"></label>
					                        <input class="form-control" type="text" placeholder="Enter User Name" name="user_name" value="">
					                        
					                        <label class="my-0" for="user_email"></label>
					                        <input class="form-control" type="text" placeholder="Enter Staff Email" name="user_email" value="">
					                        
					                        
					                        <label class="my-0" for="user_password"></label>
					                        <input class="form-control" type="text" placeholder="Enter Staff Password" name="user_password" value="">
					                        
					                        <label class="my-0" for="dep_id"></label>
					                        <input class="form-control" type="text" placeholder="Enter Department ID" name="dep_id" value="">
					                        
					                        <div class="text-center">
					                        	<button class="button btn btn-info my-3" type="submit">Add to Staff</button>
					                        </div>
					                    </div>
					                </form>
				            	</div>
				            	<div class="container col-8 bg-white">
				                    <table id="editable_table" class="table table-bordered table-striped bg-white table-responsive mt-4">
				                        <thead class="thead-dark">
				                            <div class="text-center my-3">
				                            	<b>Staff Data</b>
				                            </div>
				                            <tr>
				                                <th style="width: 5%">No.</th>
				                                <th style="width: 20%">User ID</th>
				                                <th style="width: 20%">User Name</th>
				                                <th style="width: 20%">Password</th>
				                                <th style="width: 20%">Department ID</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <?php
					                            $counterselect = 1;
					                            while($result3 = $sqlshow3->fetch()){
					                                $name = "step".$counterselect;
					                                $row = "row".$counterselect;
					                                $sqlshowstep=$connection->prepare("SELECT * FROM tbl_user");
					                                $sqlshowstep->execute();
					                                echo "<tr>";
					                                    echo "<td>".$counterselect."</td>";
					                                    echo  "<td>"; echo $result3['user_id']; echo "</td>";
					                                    echo  "<td>"; echo $result3['user_name']; echo "</td>";
					                                    echo  "<td>"; echo $result3['user_password']; echo "</td>";
					                                    echo  "<td>"; echo $result3['dep_id']; echo "</td>";
					                                    
					                                echo "</tr>";
					                                $counterselect++;
					                            }
				                            ?>
				                        </tbody>
				                    </table>
				                </div>
				            </div>
				        </div>



				        <div class="container-fluid tab-pane fade" id="dep" role="tabpanel" aria-labelledby="mngdep-tab">
				        	<div>
					        	<h2 class="text-center">Manage Department</h2>	
  							</div>
  							<div class="row" style="margin-bottom: 100px;">
	  							<div class="container col-4 span6 bg-white" style="padding-right:15px; border-right: 1px solid #ccc;">
					                <form action="admin_manage_dep_add.php" method="post">
					                    <div class="form-group table-responsive">
					                    	<div class="text-center mt-4">
					                        	<b>Add New Department</b>
				                        	</div>
					                        <label class="my-0" for="dep_name"></label>
					                        <input class="form-control" type="text" placeholder="Enter Department Name" name="dep_name" value="">
					                        <label class="my-0" for="place"></label>
					                        <input class="form-control" type="text" placeholder="Enter Place" name="place" value="">
					                        <div class="text-center">
					                        	<button class="button btn btn-info my-3" type="submit">Add to Department</button><br>
					                        </div>
					                    </div>
					                </form>
					            </div>
					            <div class="container col-8">
				                    <table id="editable_table2" class="table table-bordered table-striped bg-white table-responsive mt-4">
				                        <thead class="thead-dark">
				                        	<div class="text-center my-4">
				                            	<b>Department Data</b>
				                        	</div>
				                            <tr>
				                                <th style="width: 5%">No.</th>
				                                <th style="width: 20%">Department ID</th>
				                                <th style="width: 20%">Department Name</th>
				                                <th style="width: 20%">Place</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <?php
					                            $num = 1;
					                            while($result4 = $sqlshow4->fetch()){
					                                $sql=$connection->prepare("SELECT * FROM tbl_dep");
					                                $sql->execute();
					                                echo "<tr>";
					                                    echo "<td>".$num."</td>";
					                                    echo  "<td>"; echo $result4['dep_id']; echo "</td>";
					                                    echo  "<td>"; echo $result4['dep_name']; echo "</td>";
					                                    echo  "<td>"; echo $result4['place']; echo "</td>";
					                                echo "</tr>";
					                                $num++;
					                            }
				                            ?>
				                        </tbody>
				                    </table>
				               	</div>     
				            </div>
				        </div>
				    </div>
				</div>
			</div>
			</div>
		</div>  			
	</body>
	<script type="text/javascript" src="assets/js/jquery.tabledit.min.js"></script>
	<script type="text/javascript">  
	$(document).ready(function(){  
		$('#editable_table').Tabledit({
	    	url:'admin_manage_staff_editable_action.php',
	      	columns:{
	       		identifier:[1, "user_id"],
	       		editable:[[2, 'user_name'], [3, 'user_password'], [4, 'dep_id']]
	      	},
	      	restoreButton:false,
	      	onSuccess:function(data, textStatus, jqXHR){
	       		if(data.action == 'delete'){
	        		$('#'+data.id).remove();
	       		}
	      	}

	    });

	    $('#editable_table2').Tabledit({
	    	url:'admin_manage_dep_editable_action.php',
	      	columns:{
	       		identifier:[1, "dep_id"],
	       		editable:[[2, 'dep_name'], [3, 'place']]
	      	},
	      	restoreButton:false,
	      	onSuccess:function(data, textStatus, jqXHR){
	       		if(data.action == 'delete'){
	        		$('#'+data.id).remove();
	       		}
	      	}
	    });
	 
	});  
	</script>
</html>
