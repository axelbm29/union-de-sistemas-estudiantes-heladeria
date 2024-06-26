<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $cname = $_POST['cname'];
    $section = $_POST['section'];
    $sql = "INSERT INTO tblclass(ClassName,Section) VALUES(:cname,:section)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':cname', $cname, PDO::PARAM_STR);
    $query->bindParam(':section', $section, PDO::PARAM_STR);
    $query->execute();
    $LastInsertId = $dbh->lastInsertId();
    if ($LastInsertId > 0) {
      echo '<script>alert("Periodo academico ha sido agregado correctamente")</script>';
      echo "<script>window.location.href ='add-periodo.php'</script>";
    } else {
      echo '<script>alert("Algo salió mal. Favor reintentar")</script>';
    }
  }
  ?>

  <?php include_once ('../compartido/header.php'); ?>
  <div class="container-fluid page-body-wrapper">
    <?php include_once ('../compartido/sidebar.php'); ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title" style="color: white;">Agregar Periodo Academico</h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Agregar Periodo Academico</li>
            </ol>
          </nav>
        </div>
        <div class="row">
          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <form class="forms-sample" method="post">
                  <div class="form-group">
                    <label for="exampleInputName1">Nombre de Periodo Academico</label>
                    <input type="text" name="cname" value="" class="form-control" required='true'>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail3">Seccion</label>
                    <select name="section" class="form-control" required='true'>
                      <option value="">Elige Seccion</option>
                      <option value="A">A</option>
                      <option value="B">B</option>
                      <option value="C">C</option>
                      <option value="D">D</option>
                    </select>
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