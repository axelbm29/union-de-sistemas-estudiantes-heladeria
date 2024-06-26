<?php
session_start();
error_reporting(0);
include ('compartido/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "delete from tblstudent where ID=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('Datos eliminados correctamente');</script>";
    echo "<script>window.location.href = 'manage-students.php'</script>";
  }
  ?>
  <?php include_once ('compartido/header.php'); ?>
  <div class="container-fluid page-body-wrapper">
    <?php include_once ('compartido/sidebar.php'); ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title"> Busqueda de Estudiantes </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Busqueda de Estudiante</li>
            </ol>
          </nav>
        </div>
        <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <form method="post">
                  <div class="form-group">
                    <strong>Busqueda de Estudiante:</strong>

                    <input id="searchdata" type="text" name="searchdata" required="true" class="form-control"
                      placeholder="Buscar por ID de Estufdiante">
                  </div>

                  <button type="submit" class="btn btn-primary" name="search" id="submit">Busqueda</button>
                </form>
                <div class="d-sm-flex align-items-center mb-4">


                  <?php
                  if (isset($_POST['search'])) {

                    $sdata = $_POST['searchdata'];
                    ?>
                    <h4 align="center" style="margin-top: 25px;">Resultados por "<?php echo $sdata; ?>" palabra clave </h4>
                  </div>
                  <div class="table-responsive border rounded p-1">

                    <table class="table">
                      <thead>
                        <tr>
                          <th class="font-weight-bold" style="text-align: center; color:white;">S.No</th>
                          <th class="font-weight-bold" style="text-align: center; color:white;">ID de Estudiante</th>
                          <th class="font-weight-bold" style="text-align: center; color:white;">Periodo Academico</th>
                          <th class="font-weight-bold" style="text-align: center; color:white;">Nombre de Estudiante</th>
                          <th class="font-weight-bold" style="text-align: center; color:white;">Correo de Estudiante</th>
                          <th class="font-weight-bold" style="text-align: center; color:white;">Fecha de Admision</th>
                          <th class="font-weight-bold" style="text-align: center; color:white;">Accion</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (isset($_GET['pageno'])) {
                          $pageno = $_GET['pageno'];
                        } else {
                          $pageno = 1;
                        }
                        $no_of_records_per_page = 5;
                        $offset = ($pageno - 1) * $no_of_records_per_page;
                        $ret = "SELECT ID FROM tblstudent";
                        $query1 = $dbh->prepare($ret);
                        $query1->execute();
                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                        $total_rows = $query1->rowCount();
                        $total_pages = ceil($total_rows / $no_of_records_per_page);
                        $sql = "SELECT tblstudent.StuID,tblstudent.ID as sid,tblstudent.StudentName,tblstudent.StudentEmail,tblstudent.DateofAdmission,tblclass.ClassName,tblclass.Section from tblstudent join tblclass on tblclass.ID=tblstudent.StudentClass where tblstudent.StuID like '$sdata%' LIMIT $offset, $no_of_records_per_page";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                          foreach ($results as $row) { ?>
                            <tr>

                              <td style="text-align: center; color:white;"><?php echo htmlentities($cnt); ?></td>
                              <td style="text-align: center; color:white;"><?php echo htmlentities($row->StuID); ?></td>
                              <td style="text-align: center; color:white;"><?php echo htmlentities($row->ClassName); ?>
                                <?php echo htmlentities($row->Sección); ?>
                              </td>
                              <td style="text-align: center; color:white;"><?php echo htmlentities($row->StudentName); ?></td>
                              <td style="text-align: center; color:white;"><?php echo htmlentities($row->StudentEmail); ?></td>
                              <td style="text-align: center; color:white;"><?php echo htmlentities($row->DateofAdmission); ?>
                              </td>
                              <td style="text-align: center;">
                                <div>
                                  <a href="edit-student-detail.php?editid=<?php echo htmlentities($row->sid); ?>"
                                    class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i>
                                  </a>
                                  <a href="manage-students.php?delid=<?php echo ($row->sid); ?>"
                                    onclick="return confirm('Deseas eliminar este registro?');" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                  </a>
                                </div>
                              </td>
                            </tr><?php
                            $cnt = $cnt + 1;
                          }
                        } else { ?>
                          <tr>
                            <td colspan="8"> Sin registros coincidentes según el criterio de búsqueda ingresado</td>

                          </tr>
                        <?php }
                  } ?>
                    </tbody>
                  </table>
                </div>
                <div align="left" style="margin-top:15px;">
                  <ul class="pagination">
                    <li><a href="?pageno=1"><strong>Primero></strong></a></li>
                    <li class="<?php if ($pageno <= 1) {
                      echo 'disabled';
                    } ?>">
                      <a href="<?php if ($pageno <= 1) {
                        echo '#';
                      } else {
                        echo "?pageno=" . ($pageno - 1);
                      } ?>"><strong style="padding-left: 10px">Anterior></strong></a>
                    </li>
                    <li class="<?php if ($pageno >= $total_pages) {
                      echo 'disabled';
                    } ?>">
                      <a href="<?php if ($pageno >= $total_pages) {
                        echo '#';
                      } else {
                        echo "?pageno=" . ($pageno + 1);
                      } ?>"><strong style="padding-left: 10px">Siguiente></strong></a>
                    </li>
                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong
                          style="padding-left: 10px">Ultimo</strong></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include_once ('compartido/footer.php'); ?>
    </div>
  </div>
  </div>
<?php } ?>