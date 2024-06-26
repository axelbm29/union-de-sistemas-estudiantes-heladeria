<?php
session_start();
error_reporting(0);
include ('compartido/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $adminid = $_SESSION['sturecmsaid'];
    $AName = $_POST['adminname'];
    $mobno = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $sql = "update tbladmin set AdminName=:adminname,Email=:email where ID=:aid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':adminname', $AName, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
    $query->execute();

    echo '<script>alert("Tu perfil ha sido actualizado correctamente")</script>';
    echo "<script>window.location.href ='profile.php'</script>";
  }
  ?>

  <?php include_once ('compartido/header.php'); ?>
  <div class="container-fluid page-body-wrapper">
    <?php include_once ('compartido/sidebar.php'); ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title"> Perfil Administrativo </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Perfil Administrativo</li>
            </ol>
          </nav>
        </div>
        <div class="row">

          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center;">Perfil Administrativo</h4>

                <form class="forms-sample" method="post">
                  <?php

                  $sql = "SELECT * from  tbladmin";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $cnt = 1;
                  if ($query->rowCount() > 0) {
                    foreach ($results as $row) { ?>
                      <div class="form-group">
                        <label for="exampleInputName1">Nombre</label>
                        <input type="text" name="adminname" value="<?php echo $row->AdminName; ?>" class="form-control"
                          required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Usuario</label>
                        <input type="text" name="username" value="<?php echo $row->UserName; ?>" class="form-control"
                          readonly="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputCity1">Correo</label>
                        <input type="email" name="email" value="<?php echo $row->Email; ?>" class="form-control"
                          required='true'>
                      </div>
                      <?php $cnt = $cnt + 1;
                    }
                  } ?>
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Actualizar</button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include_once ('compartido/footer.php'); ?>
    </div>
  </div>

<?php } ?>