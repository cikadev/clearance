<?php
    session_start();
    include('dbconn.php');
    if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    $sql = $connection->prepare("SELECT * FROM tbl_student");
    $sql->execute();

    $sql2 = $connection->prepare("SELECT * FROM tbl_cs");
    $sql2->execute();

      
?>
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
        <script type="text/javascript" language="javascript" src="TableFilter/tablefilter.js"></script>  
        <script src="js/jquery.tabledit.js"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
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
            <img src="pic/rprt.png" style="width: 200px;">          
        </div>

        <div class="container col-lg-10 shadow-lg rounded text-white pb-5" style="margin-top: 200px; position: relative; margin-bottom: 200px;">
            <div class="container-fluid" style="padding-top: 100px;">
                <h1 class="font-weight-bold text-center" style="padding-top: 20px;">Reporting the Student Data</h1>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="text-center col-12">
                    <img src="pic/pulogo.png" class="img-fluid" alt="Responsive image" style="width: 10%;">
                    <p class="text-center">Passion . Responsibility . Entrepreneurial spirit . Sincerity . Inclusiveness . Dedication . Exellence . Nationalism . Trendsetter</p>
                </div>
                <div class="text-center col-12">
                </div>
                <div class="container col-10 rounded my-3 align-content-center justify-content-center" style="background-image: url(pic/bg.png); background-size: cover;">
                    <ul class="nav nav-tabs nav-justified align-content-center justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="stdrprt-tab" data-toggle="tab" href="#stdrprt" role="tab" aria-controls="stdrprt" aria-selected="true">Student Data Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-white" id="lstrprt-tab" data-toggle="tab" href="#lstrprt" role="tab" aria-controls="lstrprt" aria-selected="true">Student CheckList Report</a>
                        </li>
                    </ul>
                    <div class="tab-content mb-5" id="myTabContent">
                        <div class="tab-pane fade show active text-dark" id="stdrprt" role="tabpanel" aria-labelledby="stdrprt">
                            <div class="text-center">
                                <h2 class="text-center">Student Data</h2>
                                <input type="text" id="myInput2" onkeyup="myFunction()" placeholder="Search for Batch.." title="Type in a Batch">
                                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Major.." title="Type in a Major">
                            </div>
                            <div class="container bg-white">
                                <form>
                                    <table id="myTable" class="table table-bordered table-striped bg-white">
                                        <thead class="thead-dark">
                                            <tr class="text-center">
                                                <th style="width: 5%">No</th>
                                                <th style="width: 20%">Student Name</th>
                                                <th style="width: 20%">Student ID</th>
                                                <th style="width: 20%">Student Batch</th>
                                                <th style="width: 20%">Student Major</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $num=1;
                                                while($result = $sql->fetch()){
                                                    echo "<tr>
                                                        <td>$num</td>
                                                        <td>".$result['student_name']."</td>
                                                        <td>".$result['student_id']."</td>
                                                        <td>".$result['student_batch']."</td>
                                                        <td>".$result['student_major']."</td>
                                                        </tr>";
                                                        $num++; 
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                                      


                        <div class="tab-pane fade" id="lstrprt" role="tabpanel" aria-labelledby="lstrprt">
                            <div class="text-center">
                                <h2 class="text-dark">Clearance List Data</h2>
                                <input type="text" id="myInput3" onkeyup="myFunction2()" placeholder="Search for Activity.." title="Type in a Activity">
                                <input type="text" id="myInput4" onkeyup="myFunction2()" placeholder="Search for Status.." title="Type in a Status Checklist">
                            </div>
                                <div class="container bg-white">
                                    <form>
                                        <table id="myTable2" class="table table-bordered table-striped bg-white">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>No</th>
                                                    <th>CS ID</th>
                                                    <th>Student ID</th>
                                                    <th>Activity</th>
                                                    <th>CS Status</th>
                                                    <th>Signed By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $number=1;
                                                    while($result2 = $sql2->fetch()){
                                                        echo "<tr>
                                                                <td>$number</td>
                                                                <td>".$result2['cs_id']."</td>
                                                                <td>".$result2['fk_id']."</td>
                                                                <td>".$result2['activity']."</td>
                                                                <td>".$result2['cs_status']."</td>
                                                                <td>".$result2['signed']."</td>
                                                              </tr>";
                                                              $number++;
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
      function myFunction() {

        var input, filter, table, tr, td, i, txtValue;
        var input2, filter2, tr2, td2, txtValue2;

        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        input2 = document.getElementById("myInput2");
        filter2 = input2.value.toUpperCase();
        tr2 = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[4];
          td2 = tr2[i].getElementsByTagName("td")[3];
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
            $('#myTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

        } );

      function myFunction2() {

        var input3, filter3, table3, tr3, td3, i3, txtValue3;
        var input4, filter4, tr4, td4, txtValue4;

        input3 = document.getElementById("myInput3");
        filter3 = input3.value.toUpperCase();
        table3 = document.getElementById("myTable2");
        tr3 = table3.getElementsByTagName("tr");

        input4 = document.getElementById("myInput4");
        filter4 = input4.value.toUpperCase();
        tr4 = table3.getElementsByTagName("tr");

        for (i3 = 0; i3 < tr3.length; i3++) {
          td3 = tr3[i3].getElementsByTagName("td")[3];
          td4 = tr4[i3].getElementsByTagName("td")[4];
          if (td3) {
            txtValue3 = td3.textContent || td3.innerText;
            txtValue4 = td4.textContent || td4.innerText;
            if (txtValue3.toUpperCase().indexOf(filter3) > -1 && txtValue4.toUpperCase().indexOf(filter4) > -1) {
              tr3[i3].style.display = "";
              tr4[i3].style.display = "";
            } else {
              tr3[i3].style.display = "none";
              tr4[i3].style.display = "none";
            }
          }       
        }
      }
      $(document).ready( function () {
            $('#myTable2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

        } );
      </script>

</html>