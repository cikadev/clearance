<?php
    include("dbconn.php");
    session_start();
     if ($_SESSION['user_type'] != "admin"){
        $message = "You are not allowed!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: user_login_page.html");
    }

    $preptablestd = $connection->prepare("SELECT * FROM tbl_student");
    $preptablestd->execute();

    $preptablecs = $connection->prepare("SELECT * FROM tbl_cs");
    $preptablecs->execute();
    
?>


<!DOCTYPE html>
<html>
  <head>
    <title>PUGACS</title>
    <meta charset="utf-8">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

            <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <!-- Popper JS -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <!-- Latest compiled JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  </head>
  <body>
    <div class="container-fluid p-5">
      <div class="row">
        <div class="col-6">
          <h1>Graphs</h1>
          <h3>User</h3>
          <canvas id="test"></canvas>
          <h3>Activity</h3>
          <canvas id="bar"></canvas>
        </div>
        <div class="col-6">
          <h1>Tables</h1>
            <h3>Student Table</h3>
            <table id="myTable" class="table table-bordered table-striped bg-white" style="width: 100%">
              <thead class="thead-dark">
                <tr class="text-center">
                  <th>Student ID</th>
                  <th>Student Email</th>
                  <th>Student Name</th>
                  <th>Student Batch</th>
                  <th>Student Major</th>
                  <th>Student BoD</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  while($result = $preptablestd->fetch()){
                    echo "<tr>
                      <td>".$result['student_id']."</td>
                      <td>".$result['student_email']."</td>
                      <td>".$result['student_name']."</td>
                      <td>".$result['student_batch']."</td>
                      <td>".$result['student_major']."</td>
                      <td>".$result['student_bod']."</td>
                    </tr>";
                  }
                ?>
              </tbody>
            </table>
            <h3>CS Table</h3>
            <table id="myTable2" class="table table-bordered table-striped bg-white" style="width: 100%">
              <thead class="thead-dark">
                <tr class="text-center">
                  <th>CS ID</th>
                  <th>Activity</th>
                  <th>Signed by</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  while($result2 = $preptablecs->fetch()){
                    echo "<tr>
                      <td>".$result2['cs_id']."</td>
                      <td>".$result2['activity']."</td>
                      <td>".$result2['signed']."</td>
                      <td>".$result2['last_updated']."</td>
                    </tr>";
                  }
                ?>
              </tbody>
            </table>
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

  <!-- GRAPH GENERATE -->
  <script type="text/javascript">
    <?php
      $formdone = 0;

      $prep_lastlist = $connection->prepare("SELECT COUNT(*) AS row FROM tbl_list");
      $prep_lastlist->execute();
      $result = $prep_lastlist->fetch();
      $prep_stdid = $connection->prepare("SELECT student_id FROM tbl_student WHERE student_upd_status = 'SU'");
      if($prep_stdid->execute()){
        while($result2 = $prep_stdid->fetch()){
          $cs_id = $result2['student_id']."-".$result['row'];
          $prep_csid = $connection->prepare("SELECT cs_status FROM tbl_cs WHERE cs_id ='$cs_id'");
          if($prep_csid->execute()){
            while($result3 = $prep_csid->fetch()){
              if($result3['cs_status'] == "Checked"){
                $formdone++;
                $formnotdone = $result['row']-$formdone;
              }
            }
          }
        }
      }
    ?>

    var ctx = document.getElementById('test').getContext('2d');
    var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'pie',

      // The data for our dataset
      data: {
        labels: ["Done", "Undone"],
        datasets: [{
          label: "Users (Status)",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f"],
          data: [<?php echo $formdone.",".$formnotdone?>]
        }]
      },

      // Configuration options go here
      options: {}
    });

    <?php
      $prepdata = $connection->prepare("SELECT fk_step, COUNT(*) AS tot FROM tbl_cs WHERE cs_status = 'Checked' GROUP BY fk_step");
      $prepdata->execute();
      $preplabel = $connection->prepare("SELECT fk_step, COUNT(*) AS tot FROM tbl_cs WHERE cs_status = 'Checked' GROUP BY fk_step");
      $preplabel->execute();
    ?>   

    var ctx = document.getElementById('bar').getContext('2d');
    var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'bar',

      // The data for our dataset
      data: {
        labels: [<?php while($resultlabel = $preplabel->fetch()){
          echo '"'.$resultlabel['fk_step'].'",';
        }?>],
        datasets: [{
          label: "Activity (User)",
          barPercentage: 0.5,
          barThickness: 6,
          maxBarThickness: 8,
          minBarLength: 2,
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#3e95cd", "#8e5ea2","#3cba9f","#3e95cd", "#8e5ea2","#3cba9f"],
          data: [<?php while($resultdata = $prepdata->fetch()){
            echo $resultdata['tot'].',';
          }?>]
        }]
      },

      // Configuration options go here
      options: {}
    });
  </script>
  <!-- TABLES SCRIPT -->
  <script type="text/javascript">
    $(document).ready( function () {
            $('#myTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('#myTable2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

        } );
  </script>
</html>
