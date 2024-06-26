<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $stuname = $_POST['stuname'];
    $stuemail = $_POST['stuemail'];
    $stuclass = $_POST['stuclass'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $stuid = $_POST['stuid'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $connum = $_POST['connum'];
    $altconnum = $_POST['altconnum'];
    $address = $_POST['address'];
    $eid = $_GET['editid'];
    $sql = "update tblstudent set StudentName=:stuname,StudentEmail=:stuemail,StudentClass=:stuclass,Gender=:gender,DOB=:dob,StuID=:stuid,FatherName=:fname,MotherName=:mname,ContactNumber=:connum,AlternateNumber=:altconnum,Address=:address where ID=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':stuname', $stuname, PDO::PARAM_STR);
    $query->bindParam(':stuemail', $stuemail, PDO::PARAM_STR);
    $query->bindParam(':stuclass', $stuclass, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':mname', $mname, PDO::PARAM_STR);
    $query->bindParam(':connum', $connum, PDO::PARAM_STR);
    $query->bindParam(':altconnum', $altconnum, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
    echo '<script>alert("Estudiante ha sido actualizado")</script>';
  }

  ?>

  <?php include_once ('../compartido/header.php'); ?>
  <div class="container-fluid page-body-wrapper">
    <?php include_once ('../compartido/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title"> Actualizar Estudiante </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Actualizar Estudiante</li>
            </ol>
          </nav>
        </div>
        <div class="row">
          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="margin-bottom:35px;">Actualizar Estudiantes</h4>

                <form class="forms-sample" method="post">
                  <?php
                  $eid = $_GET['editid'];
                  $sql = "SELECT tblstudent.StudentName,tblstudent.StudentEmail,tblstudent.StudentClass,tblstudent.Gender,tblstudent.DOB,tblstudent.StuID,tblstudent.FatherName,tblstudent.MotherName,tblstudent.ContactNumber,tblstudent.AlternateNumber,tblstudent.Address,tblstudent.UserName,tblstudent.Password,tblstudent.DateofAdmission,tblclass.ClassName,tblclass.Section from tblstudent join tblclass on tblclass.ID=tblstudent.StudentClass where tblstudent.ID=:eid";
                  $query = $dbh->prepare($sql);
                  $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $cnt = 1;
                  if ($query->rowCount() > 0) {
                    foreach ($results as $row) { ?>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="exampleInputName1">Nombres del Estudiante</label>
                          <input type="text" name="stuname" value="<?php echo htmlentities($row->StudentName); ?>"
                            class="form-control" required='true'>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="exampleInputName1">Correo del Estudiante</label>
                          <input type="text" name="stuemail" value="<?php echo htmlentities($row->StudentEmail); ?>"
                            class="form-control" required='true'>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="exampleInputEmail3">Periodo Academico del Estudiante</label>
                          <select name="stuclass" class="form-control" required='true'>
                            <option value="<?php echo htmlentities($row->StudentClass); ?>">
                              <?php echo htmlentities($row->ClassName); ?>       <?php echo htmlentities($row->Section); ?>
                            </option>
                            <?php
                            $sql2 = "SELECT * from tblclass";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                            foreach ($result2 as $row1) { ?>
                              <option value="<?php echo htmlentities($row1->ID); ?>">
                                <?php echo htmlentities($row1->ClassName); ?>         <?php echo htmlentities($row1->Section); ?>
                              </option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="exampleInputName1">Genero</label>
                          <select name="gender" value="" class="form-control" required='true'>
                            <option value="<?php echo htmlentities($row->Gender); ?>">
                              <?php echo htmlentities($row->Gender); ?>
                            </option>
                            <option value="Male">Masculino</option>
                            <option value="Female">Femenino</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="exampleInputName1">Fecha de Nacimiento</label>
                          <input type="date" name="dob" value="<?php echo htmlentities($row->DOB); ?>" class="form-control"
                            required='true'>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="exampleInputName1">ID de Estudiante</label>
                          <input type="text" name="stuid" value="<?php echo htmlentities($row->StuID); ?>"
                            class="form-control" readonly='true'>
                        </div>
                      </div>
                      <h3 style="margin-top: 15px; margin-bottom:30px;">Padres / Acudientes</h3>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="exampleInputName1">Nombres del Padre</label>
                          <input type="text" name="fname" value="<?php echo htmlentities($row->FatherName); ?>"
                            class="form-control" required='true'>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="exampleInputName1">Nombres de la Madre</label>
                          <input type="text" name="mname" value="<?php echo htmlentities($row->MotherName); ?>"
                            class="form-control" required='true'>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="exampleInputName1">Numero de Contacto</label>
                          <input type="text" name="connum" value="<?php echo htmlentities($row->ContactNumber); ?>"
                            class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="exampleInputName1">Numero de Contacto Alternativo</label>
                          <input type="text" name="altconnum" value="<?php echo htmlentities($row->AlternateNumber); ?>"
                            class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Direccion</label>
                        <textarea name="address" class="form-control"
                          required='true'><?php echo htmlentities($row->Address); ?></textarea>
                      </div>
                      <h3 style="margin-bottom: 15px;">Informacion de Acceso</h3>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="exampleInputName1">Nombre de Usuario</label>
                          <input type="text" name="uname" value="<?php echo htmlentities($row->UserName); ?>"
                            class="form-control" readonly='true'>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="exampleInputName1">Contrasena</label>
                          <input type="Password" name="password" value="<?php echo htmlentities($row->Password); ?>"
                            class="form-control" readonly='true'>
                        </div>
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
      <?php include_once ('../compartido/footer.php'); ?>
    </div>
  </div>
  </div>
<?php } ?>