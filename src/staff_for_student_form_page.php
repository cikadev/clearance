<?php
    
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "staff"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }
        
    $dep_id = $_SESSION['dep_id'];
    $query2 = $connection->prepare("SELECT * FROM tbl_dep WHERE dep_id = '$dep_id'");
    $query2->execute();

    $sqlshow = $connection->prepare("SELECT cs.activity, cs.cs_status, st.student_major, st.student_name FROM tbl_cs cs, tbl_student st WHERE cs.fk_id = st.student_id AND cs.dep_id = $_SESSION[dep_id]");
    $sqlshow->execute();

    $countchecked = $connection->prepare("SELECT COUNT(cs_status) AS amount from tbl_cs WHERE cs_status = 'Checked' AND dep_id = $_SESSION[dep_id]");
    $countchecked->execute();
    $countcheckedresult = $countchecked->fetch();

    $countuncheck = $connection->prepare("SELECT COUNT(cs_status) AS amount from tbl_cs WHERE cs_status = 'Uncheck' AND dep_id = $_SESSION[dep_id]");
    $countuncheck->execute();
    $countuncheckresult = $countuncheck->fetch();
?>
<html>
    <head>
        <title id="pageTitle"><?php echo 'PUAGCS Checked = '.$countcheckedresult['amount'].' Uncheck = '.$countuncheckresult['amount'];?></title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

            <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

            <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

            <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

            <!-- TableFilter -->       
        <script type="text/javascript" language="javascript" src="TableFilter/tablefilter.js"></script>  
        <script src="assets/js/jquery.tabledit.js"></script>

        <style type="text/css">
            body, html {
                height: 100%;
                margin: 0;
            }
            .bg {
                /* The image used */
                background-image: url("src/assets/img/backgroundd.jpg");

                /* Full height */
                height: 100%; 

                /* Center and scale the image nicely */
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;

                padding-top: 70px;
            }
        </style>
    </head>

    <body class="container vh-100 bg">
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-2 shadow justify-content-between">
            <a class="btn btn-outline-secondary nav-item text-white" href="staff_for_student_form_page.php">Home</a>
            <a class="navbar-brand text-white">President University Graduation Automated Clearance System</a>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="btn btn-outline-danger text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
        
        
        <div class="row h-100 text-center justify-content-center align-items-center">
            <div class="col-12 rounded" style="padding: 0px; background-image: url(assets/img/bg.png); background-position: center; background-size: cover;">
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="input-tab" data-toggle="tab" href="#inputTab" role="tab" aria-controls="home" aria-selected="true">Input Student Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#reportingTab" role="tab" aria-controls="profile" aria-selected="false"> Show Reporting</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent" style="height: 80%">
                    <div class="tab-pane fade show active" id="inputTab" role="tabpanel" aria-labelledby="home-tab">
                        <h2 class="text-center mt-3">Input the Student Data</h2><br>
                        <?php
                            $result = $query2->fetch();
                            echo "Department "; echo $result['dep_name'];
                            //echo " - ";
                            //echo $result['activity'];
                        ?>
                        
                        <form action="staff_submit_student_data.php" method="post" id="test"><br>
                            <div class="row justify-content-center align-items-center">
                                <div class="text-center">
                                    <img src="assets/img/pulogo.png" class="img-fluid" alt="Responsive image" style="width: 20%;">
                                    <p class="text-center my-3">Passion . Responsibility . Entrepreneurial spirit . Sincerity . Inclusiveness . Dedication . Exellence . Nationalism . Trendsetter</p><br>
                                </div>
                            </div>
                            <div class="container text-center col-6 rounded mt-4" style="background-image: url(assets/img/background.png); background-size: cover;">
                                <div class="form-group">
                                    <label for="card_id"></label>
                                    <input type="text" placeholder="Tap Student ID Card" name="card_id" class="form-control mt-3" id="input1">
                                </div>
                                <p class="text-white text-center"><strong>OR</strong></p>
                                <div class="form-group">
                                    <label for="student_id"></label>
                                    <input type="text" placeholder="Enter Student ID" name="student_id" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="student_bod"></label>
                                    <input type="password" placeholder="Enter Student DoB" name="bod"class="form-control">
                                </div>  
                                <div class="text-center">
                                    <button type="submit" class="btn btn-warning mb-3">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="reportingTab" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="container text-center">
                            <h2 class="mt-3">Reporting</h2>
                            <div class="row justify-content-center align-items-center">
                                <canvas id="myPie" style="max-width: 400px;"></canvas>
                            </div><hr>
                            <div class="container-fluid">
                                <h2>Student Data</h2>
                                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Status.." title="Type in a Status">
                                <input type="text" id="myInput2" onkeyup="myFunction()" placeholder="Search for Major.." title="Type in a Major">
                                <table id="staffTable" class="table table-bordered table-striped bg-white" style="width: 100%">
                                    <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>Activity Name</th>
                                        <th>Status</th>
                                        <th>Student Major</th>
                                        <th>Student Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        while($checked = $sqlshow->fetch()){
                                        echo "<tr>
                                                <td>".$checked['activity']."</td>
                                                <td>".$checked['cs_status']."</td>
                                                <td>".$checked['student_major']."</td>
                                                <td>".$checked['student_name']."</td>
                                            </tr>";
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
    </body>
    <!-- Graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        $(".input1").on('keyup', function (e) {
            if (e.keyCode === 13) {
                document.getElementById("test").submit();
            }
        });
    </script>

    <script type="text/javascript">
        <?php
          $prepdata = $connection->prepare("SELECT COUNT(*) AS done FROM tbl_cs WHERE cs_status = 'Checked' AND dep_id = $_SESSION[dep_id] GROUP BY dep_id");
          $prepdata->execute();
          $result = $prepdata->fetch();
          $prepdata2 = $connection->prepare("SELECT COUNT(*) AS undone FROM tbl_cs WHERE cs_status = 'Uncheck' AND dep_id = $_SESSION[dep_id] GROUP BY dep_id");
          $prepdata2->execute();
          $result2 = $prepdata2->fetch();
        ?>   

        var ctx = document.getElementById('myPie').getContext('2d');
        var chart = new Chart(ctx, {
          // The type of chart we want to create
          type: 'pie',

          // The data for our dataset
          data: {
            labels: ["Done", "Undone"],
            datasets: [{
              label: "Users (Status)",
              backgroundColor: ["#622569", "#e06377"],
              data: [<?php echo $result['done'].",".$result2['undone']?>]
            }]
          },

          // Configuration options go here
          options: {}
        });
    </script>

    <script type="text/javascript">
        function recount(tableInput)
        {
            var checkedAmount = 0;
            var uncheckAmount = 0;
            tableInput = tableInput
            .data()
            .filter(function(value, index){
                if(value[1] == "Checked")
                {
                    console.log("YES" + index);
                    checkedAmount++;
                }
                else
                {
                    uncheckAmount++;
                }
            })
            ;
            console.log(checkedAmount + " " + uncheckAmount);
            document.getElementById("pageTitle").innerHTML = "PUAGCS Checked = " + checkedAmount + " Uncheck = " + uncheckAmount;
        }
        function myFunction() {

        var input, filter, table, tr, td, i, txtValue;
        var input2, filter2, tr2, td2, txtValue2;

        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("staffTable");
        tr = table.getElementsByTagName("tr");

        input2 = document.getElementById("myInput2");
        filter2 = input2.value.toUpperCase();
        tr2 = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[1];
          td2 = tr2[i].getElementsByTagName("td")[2];
          if (td) {
            txtValue = td.textContent || td.innerText;
            txtValue2 = td2.textContent || td2.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1 && txtValue2.toUpperCase().indexOf(filter2) > -1) {
              tr[i].style.display = "";
              tr2[i].style.display = "";
            } else {
              tr[i].style.display = "none";
              tr2[i].style.display = "none";
            }
          }       
        }
      }
    $(document).ready( function () {
            $('#staffTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            }).on('draw', function() {
                recount($(this).DataTable().rows({search:'applied'}));
            } );

            $('#myTable2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

        } );;

  </script>
</html>
