<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $teachername = $_POST['teachername'];
    $teacheremail = $_POST['teacheremail'];
    $teacherid = $_POST['teacherid'];
    $connum = $_POST['connum'];
    $address = $_POST['address'];
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    $ret = "SELECT UserName, TeacherID FROM tblteachers WHERE UserName=:uname OR TeacherID=:teacherid";
    $query = $dbh->prepare($ret);
    $query->bindParam(':uname', $uname, PDO::PARAM_STR);
    $query->bindParam(':teacherid', $teacherid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() == 0) {
      $sql = "INSERT INTO tblteachers (TeacherName, TeacherEmail, Gender, DOB, ContactNumber, Address, UserName, Password, DateofJoining) VALUES (:teachername, :teacheremail, :gender, :dob, :connum, :address, :uname, :password, CURDATE())";
      $query = $dbh->prepare($sql);
      $query->bindParam(':teachername', $teachername, PDO::PARAM_STR);
      $query->bindParam(':teacheremail', $teacheremail, PDO::PARAM_STR);
      $query->bindParam(':gender', $gender, PDO::PARAM_STR);
      $query->bindParam(':dob', $dob, PDO::PARAM_STR);
      $query->bindParam(':connum', $connum, PDO::PARAM_STR);
      $query->bindParam(':address', $address, PDO::PARAM_STR);
      $query->bindParam(':uname', $uname, PDO::PARAM_STR);
      $query->bindParam(':password', $password, PDO::PARAM_STR);
      $query->execute();
      $LastInsertId = $dbh->lastInsertId();
      if ($LastInsertId > 0) {
        echo '<script>alert("Docente ha sido agregado correctamente")</script>';
        echo "<script>window.location.href ='add-docente.php'</script>";
      } else {
        echo "<pre>";
        print_r($query->errorInfo());
        echo "</pre>";
        echo '<script>alert("Algo salió mal, favor reintentar")</script>';
      }
    } else {
      echo "<script>alert('Usuario o ID existente, favor reintentar');</script>";
    }
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Agregar Docente</title>
    <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>

  <body>
    <?php include_once ('../compartido/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
      <?php include_once ('../compartido/sidebar.php'); ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title"> Agregar Docente </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Agregar Docente</li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample row" method="post">
                    <div class="form-group col-md-6">
                      <label for="exampleInputName1">Nombre del Docente</label>
                      <input type="text" name="teachername" value="" class="form-control" required='true'>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputName1">Correo del Docente</label>
                      <input type="text" name="teacheremail" value="" class="form-control" required='true'>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputName1">ID del Docente</label>
                      <input type="text" name="teacherid" value="" class="form-control" required='true'>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputGender1">Genero</label>
                      <select name="gender" class="form-control" required='true'>
                        <option value="">Seleccionar Genero</option>
                        <option value="Male">Masculino</option>
                        <option value="Female">Femenino</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputDob1">Fecha de Nacimiento</label>
                      <input type="date" name="dob" value="" class="form-control" required='true'>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputContact1">Numero de Contacto</label>
                      <input type="text" name="connum" value="" class="form-control" required='true' maxlength="10"
                        pattern="[0-9]+">
                    </div>
                    <div class="form-group col-md-12">
                      <label for="exampleInputAddress1">Direccion</label>
                      <textarea name="address" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-6" style="margin-top: 20px;">
                      <label for="exampleInputUname1">Nombre de Usuario</label>
                      <input type="text" name="uname" value="" class="form-control" required='true'>
                    </div>
                    <div class="form-group col-md-6" style="margin-top: 20px;">
                      <label for="exampleInputPassword1">Contraseña</label>
                      <input type="Password" name="password" value="" class="form-control" required='true'>
                    </div>
                    <button type="submit" style="margin-left: 10px;" class="btn btn-primary mr-2"
                      name="submit">Agregar</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include_once ('../compartido/footer.php'); ?>
      </div>
    </div>
    </div>
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>

  </html>
<?php } ?>