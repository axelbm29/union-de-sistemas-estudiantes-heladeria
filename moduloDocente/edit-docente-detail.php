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
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $contactnumber = $_POST['contactnumber'];
    $address = $_POST['address'];
    $eid = $_GET['editid'];

    $sql = "UPDATE tblteachers SET TeacherName=:teachername, TeacherEmail=:teacheremail, Gender=:gender, DOB=:dob, ContactNumber=:contactnumber, Address=:address WHERE ID=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':teachername', $teachername, PDO::PARAM_STR);
    $query->bindParam(':teacheremail', $teacheremail, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':contactnumber', $contactnumber, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();

    echo '<script>alert("Docente ha sido actualizado")</script>';
  }

  ?>

  <?php include_once ('../compartido/header.php'); ?>
  <div class="container-fluid page-body-wrapper">
    <?php include_once ('../compartido/sidebar.php'); ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">Actualizar Docente</h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Actualizar Docente</li>
            </ol>
          </nav>
        </div>
        <div class="row">
          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center;">Actualizar Docente</h4>

                <form class="forms-sample" method="post">
                  <?php
                  $eid = $_GET['editid'];
                  $sql = "SELECT * FROM tblteachers WHERE ID=:eid";
                  $query = $dbh->prepare($sql);
                  $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $cnt = 1;
                  if ($query->rowCount() > 0) {
                    foreach ($results as $row) {
                      ?>
                      <div class="form-group">
                        <label for="teachername">Nombre del Docente</label>
                        <input type="text" name="teachername" value="<?php echo htmlentities($row->TeacherName); ?>"
                          class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="teacheremail">Correo del Docente</label>
                        <input type="email" name="teacheremail" value="<?php echo htmlentities($row->TeacherEmail); ?>"
                          class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="gender">Genero</label>
                        <select name="gender" class="form-control" required='true'>
                          <option value="<?php echo htmlentities($row->Gender); ?>"><?php echo htmlentities($row->Gender); ?>
                          </option>
                          <option value="Male">Masculino</option>
                          <option value="Female">Femenino</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="dob">Fecha de Nacimiento</label>
                        <input type="date" name="dob" value="<?php echo htmlentities($row->DOB); ?>" class="form-control"
                          required='true'>
                      </div>
                      <div class="form-group">
                        <label for="contactnumber">Numero de Contacto</label>
                        <input type="text" name="contactnumber" value="<?php echo htmlentities($row->ContactNumber); ?>"
                          class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>
                      <div class="form-group">
                        <label for="address">Direccion</label>
                        <textarea name="address" class="form-control"
                          required='true'><?php echo htmlentities($row->Address); ?></textarea>
                      </div>
                      <h3>Informacion de Acceso</h3>
                      <div class="form-group">
                        <label for="uname">Nombre de Usuario</label>
                        <input type="text" name="uname" value="<?php echo htmlentities($row->UserName); ?>"
                          class="form-control" readonly='true'>
                      </div>
                      <div class="form-group">
                        <label for="password">Contrasena</label>
                        <input type="password" name="password" value="<?php echo htmlentities($row->Password); ?>"
                          class="form-control" readonly='true'>
                      </div>
                      <?php
                      $cnt++;
                    }
                  } ?>
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Actualizar</button>
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