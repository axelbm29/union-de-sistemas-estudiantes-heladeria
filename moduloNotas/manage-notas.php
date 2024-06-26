<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
  header('location:logout.php');
} else {
  if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "DELETE FROM tblstudent WHERE ID=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('Datos Eliminados');</script>";
    echo "<script>window.location.href = 'manage-students.php'</script>";
  }
  ?>
  <?php include_once ('../compartido/header.php'); ?>
  <div class="container-fluid page-body-wrapper">
    <?php include_once ('../compartido/sidebar.php'); ?>
    <div class="main-panel" style="width: calc(100% - 300px)">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title"> Gestionar Notas </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Gestionar Notas</li>
            </ol>
          </nav>
        </div>
        <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-sm-flex align-items-center mb-4">
                  <h4 class="card-title mb-sm-0">Gestionar Notas</h4>
                  <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> Ver todas las Notas</a>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="searchInput"
                    placeholder="Buscar por ID de Estudiante o Nombre">
                </div>
                <div class="table-responsive border rounded p-1">
                  <table class="table" id="studentTable">
                    <thead>
                      <tr>
                        <th class="font-weight-bold" style="color: white; text-align: center;">S.No</th>
                        <th class="font-weight-bold" style="color: white; text-align: center;">ID de Estudiante</th>
                        <th class="font-weight-bold" style="color: white; text-align: center;">Nombres de Estudiante</th>
                        <?php
                        $evaluationsSql = "SELECT * FROM evaluations ORDER BY WeekNumber ASC";
                        $evaluationsQuery = $dbh->prepare($evaluationsSql);
                        $evaluationsQuery->execute();
                        $evaluations = $evaluationsQuery->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($evaluations as $evaluation) {
                          echo "<th class='font-weight-bold' style='color: white; text-align: center;'>Semana " . $evaluation['WeekNumber'] . "</th>";
                        }
                        ?>
                        <th class="font-weight-bold" style="color: white; text-align: center;">Promedio</th>
                        <th class="font-weight-bold" style="color: white; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT tblstudent.StuID, tblstudent.StudentName, grades.Grade, evaluations.WeekNumber, evaluations.Weight 
                            FROM tblstudent 
                            LEFT JOIN grades ON tblstudent.StuID = grades.StudentID 
                            LEFT JOIN evaluations ON grades.EvaluationID = evaluations.EvaluationID 
                            ORDER BY tblstudent.StuID ASC, evaluations.WeekNumber ASC";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_ASSOC);
                      $studentGrades = array();

                      foreach ($results as $row) {
                        $studentID = $row['StuID'];
                        $studentName = $row['StudentName'];
                        $weekNumber = $row['WeekNumber'];
                        $grade = $row['Grade'];
                        $weight = $row['Weight'];

                        if (!isset($studentGrades[$studentID])) {
                          $studentGrades[$studentID] = array(
                            'name' => $studentName,
                            'grades' => array(),
                            'totalWeight' => 0,
                            'weightedTotal' => 0
                          );
                        }

                        $studentGrades[$studentID]['grades'][$weekNumber] = $grade;
                        $studentGrades[$studentID]['weightedTotal'] += ($grade * $weight) / 100;
                        $studentGrades[$studentID]['totalWeight'] += $weight;
                      }

                      $cnt = 1;
                      foreach ($studentGrades as $studentID => $studentData) {
                        echo "<tr>";
                        echo "<td style='color: white; text-align: center;'>" . $cnt . "</td>";
                        echo "<td style='color: white; text-align: center;'>" . $studentID . "</td>";
                        echo "<td style='color: white; text-align: center;'>" . $studentData['name'] . "</td>";

                        foreach ($evaluations as $evaluation) {
                          $weekNumber = $evaluation['WeekNumber'];
                          if (isset($studentData['grades'][$weekNumber])) {
                            echo "<td style='color: white; text-align: center;'>" . $studentData['grades'][$weekNumber] . "</td>";
                          } else {
                            echo "<td></td>";
                          }
                        }

                        $average = ($studentData['totalWeight'] > 0) ? ($studentData['weightedTotal']) : 0;
                        echo "<td style='color: white; text-align: center;'>" . round($average, 0) . "</td>";

                        $updateSql = "UPDATE tblstudent SET AverageGrade = :average WHERE StuID = :studentID";
                        $updateQuery = $dbh->prepare($updateSql);
                        $updateQuery->bindParam(':average', $average, PDO::PARAM_STR);
                        $updateQuery->bindParam(':studentID', $studentID, PDO::PARAM_STR);
                        $updateQuery->execute();

                        echo "<td style='text-align:center;'><a href='edit-notas-detail.php?studentid=" . $studentID . "'
                              class='btn btn-primary btn-sm' ><i class='fa fa-eye'></i></a></td>";

                        echo "</tr>";
                        $cnt++;
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                <div align="left" style="margin-top:15px;">
                  <ul class="pagination">
                    <li><a href="?pageno=1"><strong>First></strong></a></li>
                    <li class="<?php if ($pageno <= 1) {
                      echo 'disabled';
                    } ?>">
                      <a href="<?php if ($pageno <= 1) {
                        echo '#';
                      } else {
                        echo "?pageno=" . ($pageno - 1);
                      } ?>"><strong style="padding-left: 10px">Prev></strong></a>
                    </li>
                    <li class="<?php if ($pageno >= $total_pages) {
                      echo 'disabled';
                    } ?>">
                      <a href="<?php if ($pageno >= $total_pages) {
                        echo '#';
                      } else {
                        echo "?pageno=" . ($pageno + 1);
                      } ?>"><strong style="padding-left: 10px">Next></strong></a>
                    </li>
                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include_once ('../compartido/footer.php'); ?>
    </div>
  </div>
  </div>

  <script>
    document.getElementById('searchInput').addEventListener('input', function () {
      var input = this.value.toLowerCase();
      var rows = document.querySelectorAll('#studentTable tbody tr');

      rows.forEach(function (row) {
        var studentId = row.cells[1].innerText.toLowerCase();
        var studentName = row.cells[2].innerText.toLowerCase();

        if (studentId.includes(input) || studentName.includes(input)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  </script>
<?php } ?>