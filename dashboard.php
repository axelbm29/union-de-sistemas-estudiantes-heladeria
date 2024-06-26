<?php
session_start();
include ('compartido/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  ?>
  <?php include_once ('compartido/header.php'); ?>
  <div class="container-fluid page-body-wrapper">
    <?php include_once ('compartido/sidebar.php'); ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="d-sm-flex align-items-baseline report-summary-header">
                      <h5 class="font-weight-semibold" style="font-size: 1.75rem;">Resumen</h5>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class=" col-md-6 report-inner-cards-wrapper">
                    <div class="report-inner-card color-2">
                      <div class="inner-card-text text-white">
                        <?php
                        $sql1 = "SELECT * from  tblclass";
                        $query1 = $dbh->prepare($sql1);
                        $query1->execute();
                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                        $totclass = $query1->rowCount();
                        ?>
                        <span class="report-title">Total de Periodos Academicos</span>
                        <h4><?php echo htmlentities($totclass); ?></h4>
                        <a href="moduloCicloAcademico/manage-periodo.php"><span class="report-count"> Ver Periodos
                            Academicos</span></a>
                      </div>
                      <div class="inner-card-icon">
                        <i class="fas fa-calendar-alt"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 report-inner-cards-wrapper">
                    <div class="report-inner-card color-2">
                      <div class="inner-card-text text-white">
                        <?php
                        $sql2 = "SELECT * from  tblstudent";
                        $query2 = $dbh->prepare($sql2);
                        $query2->execute();
                        $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                        $totstu = $query2->rowCount();
                        ?>
                        <span class="report-title">Total de Estudiantes</span>
                        <h4><?php echo htmlentities($totstu); ?></h4>
                        <a href="moduloEstudiante/manage-students.php"><span class="report-count"> Ver
                            Estudiantes</span></a>
                      </div>
                      <div class="inner-card-icon ">
                        <i class="fas fa-user-graduate"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 report-inner-cards-wrapper">
                    <div class="report-inner-card color-1">
                      <div class="inner-card-text text-white">
                        <?php
                        $sql3 = "SELECT * from  tblteachers";
                        $query3 = $dbh->prepare($sql3);
                        $query3->execute();
                        $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                        $totnotice = $query3->rowCount();
                        ?>
                        <span class="report-title">Total de Docentes</span>
                        <h4><?php echo htmlentities($totnotice); ?></h4>
                        <a href="moduloDocente/manage-docente.php"><span class="report-count"> Ver Docentes</span></a>
                      </div>
                      <div class="inner-card-icon ">
                        <i class="fas fa-chalkboard-teacher"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 report-inner-cards-wrapper">
                    <div class="report-inner-card color-1">
                      <div class="inner-card-text text-white">
                        <span class="report-title">Semana Actual</span>
                        <h4>Semana 09</h4>
                        <a href="moduloAsistencia/show-asistencia.php"><span class="report-count">Ver
                            Asistencia</span></a>
                      </div>
                      <div class="inner-card-icon">
                        <i class="fas fa-calendar-week"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div id="piechart" style="width: 100%; height: 500px;"></div>
                  </div>
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