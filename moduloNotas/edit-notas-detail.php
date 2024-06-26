<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $gradeIds = $_POST['gradeid'];
    $grades = $_POST['grade'];
    foreach ($gradeIds as $index => $gradeId) {
      $grade = $grades[$index];
      $sql = "UPDATE grades SET Grade = :grade WHERE GradeID = :gradeId";
      $query = $dbh->prepare($sql);
      $query->bindParam(':grade', $grade, PDO::PARAM_STR);
      $query->bindParam(':gradeId', $gradeId, PDO::PARAM_INT);
      $query->execute();
    }
    echo '<script>alert("Notas actualizadas exitosamente")</script>';
  }
  ?>
  <?php include_once ('../compartido/header.php'); ?>

  <div class="container-fluid page-body-wrapper">
    <?php include_once ('../compartido/sidebar.php'); ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">Editar Notas</h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="manage-notas.php">Gestionar Notas</a></li>
              <li class="breadcrumb-item active" aria-current="page">Editar Notas</li>
            </ol>
          </nav>
        </div>
        <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center;">Editar Notas</h4>

                <form class="forms-sample" method="post">
                  <?php
                  $studentID = $_GET['studentid'];
                  $sql = "SELECT evaluations.WeekNumber, grades.Grade, grades.GradeID
                          FROM evaluations
                          LEFT JOIN grades ON evaluations.EvaluationID = grades.EvaluationID AND grades.StudentID = :studentid
                          ORDER BY evaluations.WeekNumber ASC";
                  $query = $dbh->prepare($sql);
                  $query->bindParam(':studentid', $studentID, PDO::PARAM_INT);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($results as $row) {
                    ?>
                    <div class="form-group">
                      <label for="week<?php echo $row['WeekNumber']; ?>">Semana <?php echo $row['WeekNumber']; ?>: </label>
                      <input type="hidden" name="gradeid[]" value="<?php echo $row['GradeID']; ?>">
                      <input type="text" name="grade[]" class="form-control" value="<?php echo $row['Grade']; ?>">
                    </div>
                    <?php
                  }
                  ?>

                  <button type="submit" class="btn btn-primary mr-2" name="submit">Actualizar Notas</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include_once ('../compartido/footer.php'); ?>
    </div>
  </div>
<?php } ?>