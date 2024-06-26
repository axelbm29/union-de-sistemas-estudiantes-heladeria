<?php
session_start();
error_reporting(0);
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
        <div class="page-header">
          <h3 class="page-title"> Intervalo para el Reporte </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Intervalo para el Reporte</li>
            </ol>
          </nav>
        </div>
        <div class="row">

          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center;">Intervalo para el Reporte</h4>

                <form class="forms-sample" method="post" action="reporteDetalles.php">

                  <div class="form-group">
                    <label for="exampleInputName1">Desde:</label>
                    <input type="date" class="form-control" id="fromdate" name="fromdate" value="" required='true'>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputName1">Hasta:</label>
                    <input type="date" class="form-control" id="todate" name="todate" value="" required='true'>
                  </div>
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Enviar</button>

                </form>
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