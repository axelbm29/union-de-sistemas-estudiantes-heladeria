<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "DELETE FROM tblteachers WHERE ID=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('Datos Eliminados');</script>";
    echo "<script>window.location.href = 'manage-docente.php'</script>";
  }
  ?>
  <?php include_once ('../compartido/header.php'); ?>
  <div class="container-fluid page-body-wrapper">
    <?php include_once ('../compartido/sidebar.php'); ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title"> Gestionar Docentes </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Gestionar Docentes</li>
            </ol>
          </nav>
        </div>
        <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-sm-flex align-items-center mb-4">
                  <h4 class="card-title mb-sm-0">Gestionar Docentes</h4>
                  <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> Ver todos los Docentes</a>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="searchInput"
                    placeholder="Buscar por ID de Docente o Nombre">
                </div>
                <div class="table-responsive border rounded p-1">
                  <table class="table" id="teacherTable">
                    <thead>
                      <tr>
                        <th class="font-weight-bold" style="color: white; text-align: center;">S.No</th>
                        <th class="font-weight-bold" style="color: white; text-align: center;">Nombre de Docente</th>
                        <th class="font-weight-bold" style="color: white; text-align: center;">Correo de Docente</th>
                        <th class="font-weight-bold" style="color: white; text-align: center;">Numero de Contacto</th>
                        <th class="font-weight-bold" style="color: white; text-align: center;">Fecha de Ingreso</th>
                        <th class="font-weight-bold" style="color: white; text-align: center;">Accion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                      } else {
                        $pageno = 1;
                      }
                      $no_of_records_per_page = 15;
                      $offset = ($pageno - 1) * $no_of_records_per_page;
                      $ret = "SELECT ID FROM tblteachers";
                      $query1 = $dbh->prepare($ret);
                      $query1->execute();
                      $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                      $total_rows = $query1->rowCount();
                      $total_pages = ceil($total_rows / $no_of_records_per_page);
                      $sql = "SELECT * FROM tblteachers LIMIT $offset, $no_of_records_per_page";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);

                      $cnt = 1;
                      if ($query->rowCount() > 0) {
                        foreach ($results as $row) { ?>
                          <tr>
                            <td style="color: white; text-align: center;"><?php echo htmlentities($cnt); ?></td>
                            <td style="color: white; text-align: center;"><?php echo htmlentities($row->TeacherName); ?></td>
                            <td style="color: white; text-align: center;"><?php echo htmlentities($row->TeacherEmail); ?></td>
                            <td style="color: white; text-align: center;"><?php echo htmlentities($row->ContactNumber); ?>
                            </td>
                            <td style="color: white; text-align: center;"><?php echo htmlentities($row->DateofJoining); ?>
                            </td>
                            <td style="text-align: center;">
                              <a href="edit-docente-detail.php?editid=<?php echo htmlentities($row->ID); ?>"
                                class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                              <a href="manage-docente.php?delid=<?php echo ($row->ID); ?>"
                                onclick="return confirm('Deseas eliminar este registro?');" class="btn btn-danger btn-sm"> <i
                                  class="fas fa-trash"></i></a>
                            </td>
                          </tr><?php $cnt = $cnt + 1;
                        }
                      } ?>
                    </tbody>
                  </table>
                </div>
                <div align="left" style="margin-top: 20px;">
                  <ul class="pagination">
                    <li><a href="?pageno=1"><strong>Primero</strong></a></li>
                    <li class="<?php if ($pageno <= 1) {
                      echo 'disabled';
                    } ?>">
                      <a href="<?php if ($pageno <= 1) {
                        echo '#';
                      } else {
                        echo "?pageno=" . ($pageno - 1);
                      } ?>"><strong style="padding-left: 10px">Anterior</strong></a>
                    </li>
                    <li class="<?php if ($pageno >= $total_pages) {
                      echo 'disabled';
                    } ?>">
                      <a href="<?php if ($pageno >= $total_pages) {
                        echo '#';
                      } else {
                        echo "?pageno=" . ($pageno + 1);
                      } ?>"><strong style="padding-left: 10px">Siguiente</strong></a>
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
      <?php include_once ('../compartido/footer.php'); ?>
    </div>
  </div>
  </div>

  <script>
    document.getElementById('searchInput').addEventListener('input', function () {
      var input = this.value.toLowerCase();
      var rows = document.querySelectorAll('#teacherTable tbody tr');

      rows.forEach(function (row) {
        var contactNumber = row.cells[1].innerText.toLowerCase();
        var teacherName = row.cells[2].innerText.toLowerCase();

        if (contactNumber.includes(input) || teacherName.includes(input)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  </script>
<?php } ?>