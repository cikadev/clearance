<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
    $sqlshow=$connection->prepare("SELECT * FROM tbl_list");
    $sqlshow->execute();
    
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
    	<script src="assets/js/jquery.tabledit.js"></script>
	</head>
	<body class="vh-100" style="background-color: #d6cbd3">
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
            <img class="rounded-circle shadow" src="assets/img/mnglist.png" style="width: 200px;">
        </div>

		<div class="container col-lg-10 shadow-lg rounded" style="margin-top: 200px; position: relative; margin-bottom: 150px;">
			<div class="container-fluid" style="padding-top: 100px;">
				<h1 class="font-weight-bold text-center" style="padding-top: 20px;"><?php echo "Welcome Back, ".$_SESSION['user_name'];  echo "!";?></h1>
			</div>
			<div class="row justify-content-center align-items-center">
				<div class="text-center">
					<img src="assets/img/pulogo.png" class="img-fluid" alt="Responsive image" style="width: 10%;">
					<p class="text-center">Passion . Responsibility . Entrepreneurial spirit . Sincerity . Inclusiveness . Dedication . Exellence . Nationalism . Trendsetter</p>
			    </div>
				<div class="col-10 rounded my-3 align-content-center justify-content-center text-center mb-5">
    				<h1 class="nav-link active" id="mngcf-tab" data-toggle="tab" href="#mngcf" role="tab" aria-controls="mngcf" aria-selected="true">Clearance Form List</h1>
  						
					<div class="tab-content text-white" id="myTabContent">
  							<div class="row">
	  							<div class="container col-4 span6" style="padding-right:20px; border-right: 1px solid #ccc; background-color: #034f84;">
	  								<h5 class="text-center my-3">Input New Activity</h5>
					                <form class="text-center" action="admin_manage_list_add.php" method="post"><br>
					                        <input class="form-control" type="text" name="activity" placeholder="Enter the new activity" value="">
					                        <div class="text-center">
					                        	<button class="button btn btn-info my-3" type="submit">Add to List</button>
					                        </div>
					                        
					                </form>
					            </div>
					            <div class="container col-8 text-center" style="background-color: #034f84">
					            	<h5 class="text-center my-3">Graduation Clearance System Activity</h5>
					            	<form action="admin_manage_list_update.php" method="post">
					                    <table class="table table-bordered table-striped bg-white table-responsive">
					                        <thead class="thead-dark">
					                            <tr class="text-center">
					                                <th>Activity</th>
					                                <th>Number of Step</th>
					                                <th>Dependency</th>
					                                <th>Pervious Step</th>
					                                <th>Department</th>
					                                <th>Action</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                            <?php
						                            $counterselect = 1;
						                            while($result = $sqlshow->fetch()){
						                                $depen = "depen".$counterselect;
						                                $row = "row".$counterselect;
						                                $dep_row = "dep".$counterselect;
						                                $prev_step = "prevStep".$counterselect;

						                                $sqlshowstep=$connection->prepare("SELECT * FROM tbl_list");
						                                $sqlshowstep->execute();

						                                $sql=$connection->prepare("SELECT * FROM tbl_dep ORDER BY dep_id");
						                                $sql->execute();

						                                echo "<tr>";
						                                	echo "<td>"; echo "<input type='text' name='"; echo $row;  echo "'value='"; echo $result['activity']; echo"' readonly=true>"; 
						                                	echo "<td>".$counterselect."</td>";
						                                	echo "</td>";
						                                	echo  "<td>"; 
						                                    	echo "<select class='' name='"; echo $depen; echo"'>"; 
						                                        	echo "<option selected='true' disabled='true'> - select -</option>";
						                                            echo"<option>Dependent</option>";
						                                            echo"<option>Independent</option>";
						                                       	echo "</select>"; 
						                                    echo "</td>";
						                                	echo  "<td>"; 
						                                    	echo "<select class='' name='".$prev_step."'>"; 
						                                        	echo "<option selected='true' disabled='true'> - select -</option>";
						                                        		while($prevStep = $sqlshowstep->fetch()){ 
						                                            		echo"<option value='".$prevStep['id']."''>".$prevStep['activity']."</option>";
						                                        		} 
						                                       	echo "</select>"; 
						                                    echo "</td>";
						                                	echo  "<td>"; 
						                                    	echo "<select class='selectRound2' name='"; echo $dep_row; echo"'>"; 
						                                        	echo "<option selected='true' disabled='true'> - select -</option>";    
						                                        		while($result2 = $sql->fetch()){
						                                					echo"<option name='dep_name' value='".$result2['dep_id']."'>"; echo $result2['dep_name']; echo"</option>";
						                                        		}
						                                        echo "</select>"; 
						                                    echo "</td>";
						                                	echo "<td>";
						                                		echo "<a href='admin_manage_list_delete.php?activity="; echo $result['activity']; echo"'>Delete</a>";
						                                	echo "</td>";
						                                echo"</tr>";
						                                $counterselect++;
						                            }
					                            ?>
					                        </tbody>
					                    </table>
					                    <div class="text-center">
					                        	<button class="button btn btn-info my-3" type="submit">Update List</button>
					                        </div>
					                </form>
					            </div>
					        </div>
						</div>
				    </div>
				</div>
			</div>
		</div>  			
	</body>
</html>

<script>
    $(document).on('change', '.selectRound', function(e) {
        var tralse = true;
        var selectRound_arr = []; // for activity name
        $('.selectRound').each(function(k, v) {
            var getVal = $(v).val();
            //alert(getVal);
            if (getVal && $.trim(selectRound_arr.indexOf(getVal)) != -1) {
            tralse = false;
            //it should be if value 1 = value 1 then alert, and not those if -select- = -select-. how to    avoid those -select-
            alert ('Number of step cannot be same');
            $(v).val("");
            return false;
            } else {
            selectRound_arr.push($(v).val());
            }

        });
            if (!tralse) {
            return false;
        }
    });

    $(document).on('change', '.selectRound2', function(e) {
        var tralse = true;
        var selectRound2_arr = []; // for activity name
        $('.selectRound2').each(function(k, v) {
            var getVal = $(v).val();
            //alert(getVal);
            if (getVal && $.trim(selectRound2_arr.indexOf(getVal)) != -1) {
            tralse = false;
            
            $(v).val("");
            return false;
            } else {
            selectRound_arr.push($(v).val());
            }

        });
            if (!tralse) {
            return false;
        }
    });
</script>