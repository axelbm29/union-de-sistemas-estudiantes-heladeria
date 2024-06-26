<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $studentid = $_POST['studentid'];
    $weeknumber = $_POST['weeknumber'];
    $grade = $_POST['grade'];
    $sql = "SELECT grades.Grade FROM grades JOIN evaluations ON grades.EvaluationID = evaluations.EvaluationID WHERE grades.StudentID = :studentid AND evaluations.WeekNumber = :weeknumber";
    $query = $dbh->prepare($sql);
    $query->bindParam(':studentid', $studentid, PDO::PARAM_INT);
    $query->bindParam(':weeknumber', $weeknumber, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      echo '<script>alert("Ya existe una nota para este estudiante en la semana seleccionada")</script>';
    } else {
      $sql = "SELECT EvaluationID FROM evaluations WHERE WeekNumber = :weeknumber";
      $query = $dbh->prepare($sql);
      $query->bindParam(':weeknumber', $weeknumber, PDO::PARAM_INT);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      $evaluationid = $result['EvaluationID'];

      $sql = "INSERT INTO grades (StudentID, EvaluationID, Grade) VALUES (:studentid, :evaluationid, :grade)";
      $query = $dbh->prepare($sql);
      $query->bindParam(':studentid', $studentid, PDO::PARAM_INT);
      $query->bindParam(':evaluationid', $evaluationid, PDO::PARAM_INT);
      $query->bindParam(':grade', $grade, PDO::PARAM_STR);
      $query->execute();

      $lastInsertId = $dbh->lastInsertId();
      if ($lastInsertId > 0) {
        echo '<script>alert("Nota agregada exitosamente")</script>';
        echo "<script>window.location.href ='manage-notas.php'</script>";
      } else {
        echo '<script>alert("Algo salió mal. Por favor, inténtalo de nuevo")</script>';
      }
    }
  }
  ?>

  <?php include_once ('../compartido/header.php'); ?>

  <div class="container-fluid page-body-wrapper">
    <?php include_once ('../compartido/sidebar.php'); ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">Agregar Nota</h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="manage-notas.php">Gestionar Notas</a></li>
              <li class="breadcrumb-item active" aria-current="page">Agregar Nota</li>
            </ol>
          </nav>
        </div>
        <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <form class="forms-sample" method="post">
                  <div class="form-group">
                    <label for="studentid">Estudiante</label>
                    <select class="form-control" id="studentid" name="studentid" required>
                      <option value="">Seleccionar Estudiante</option>
                      <?php
                      $sql_students = "SELECT * FROM tblstudent";
                      $query_students = $dbh->prepare($sql_students);
                      $query_students->execute();
                      $students = $query_students->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($students as $student) {
                        echo "<option value='" . $student['StuID'] . "'>" . $student['StudentName'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="weeknumber">Semana</label>
                    <select class="form-control" id="weeknumber" name="weeknumber" required>
                      <option value="">Seleccionar Semana</option>
                      <?php
                      $sql_weeks = "SELECT * FROM evaluations";
                      $query_weeks = $dbh->prepare($sql_weeks);
                      $query_weeks->execute();
                      $weeks = $query_weeks->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($weeks as $week) {
                        echo "<option value='" . $week['WeekNumber'] . "'>Semana " . $week['WeekNumber'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="grade">Nota</label>
                    <input type="text" class="form-control" style="width: 50%;" id="grade" name="grade" required>
                  </div>
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Agregar</button>
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