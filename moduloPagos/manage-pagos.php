<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "DELETE FROM tblpayments WHERE PaymentID=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Pago eliminado');</script>";
        echo "<script>window.location.href = 'manage-pagos.php'</script>";
    }
    ?>

    <?php include_once ('../compartido/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once ('../compartido/sidebar.php'); ?>
        <div class="main-panel" style="width: calc(100% - 300px)">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title"> Administrar Pagos </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Administrar Pagos</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Seleccionar Estudiante</h4>
                                <form class="forms-sample" method="post" action="">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Estudiante</label>
                                        <select class="form-control" id="studentID" name="studentID" required="true">
                                            <option value="">Seleccionar Estudiante</option>
                                            <?php
                                            $sql = "SELECT * FROM tblstudent";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($results as $row) {
                                                ?>
                                                <option value="<?php echo htmlentities($row->StuID); ?>">
                                                    <?php echo htmlentities($row->StudentName); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Seleccionar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_POST['submit'])) {
                    $studentID = $_POST['studentID'];
                    ?>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Pagos Realizados</h4>
                                    <div class="table-responsive border rounded p-1">
                                        <table class="table">
                                            <thead>
                                                <tr style="text-align: center; color: white;">
                                                    <th class="font-weight-bold">ID del Estudiante</th>
                                                    <th class="font-weight-bold">Nombre del Estudiante</th>
                                                    <th class="font-weight-bold">Tipo de Pago</th>
                                                    <th class="font-weight-bold">Monto</th>
                                                    <th class="font-weight-bold">Fecha de Pago</th>
                                                    <th class="font-weight-bold">Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM tblpayments WHERE StudentID=:studentID";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':studentID', $studentID, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                        ?>
                                                        <tr style="text-align: center;">
                                                            <td style="text-align: center; color: white;">
                                                                <?php echo htmlentities($row->StudentID); ?>
                                                            </td>
                                                            <td style="text-align: center; color: white;"><?php
                                                            $student_name = "SELECT StudentName FROM tblstudent WHERE StuID=:studentID";
                                                            $query = $dbh->prepare($student_name);
                                                            $query->bindParam(':studentID', $row->StudentID, PDO::PARAM_STR);
                                                            $query->execute();
                                                            $result = $query->fetch(PDO::FETCH_ASSOC);
                                                            echo htmlentities($result['StudentName']); ?></td>
                                                            <td style="text-align: center; color: white;">
                                                                <?php echo htmlentities($row->PaymentType); ?>
                                                            </td>
                                                            <td style="text-align: center; color: white;">
                                                                <?php echo htmlentities($row->Amount); ?>
                                                            </td>
                                                            <td style="text-align: center; color: white;">
                                                                <?php echo htmlentities($row->PaymentDate); ?>
                                                            </td>
                                                            <td>
                                                                <a href="manage-pagos.php?delid=<?php echo htmlentities($row->PaymentID); ?>"
                                                                    onclick="return confirm('¿Estás seguro de que quieres eliminar este pago?');"
                                                                    class="btn btn-danger btn-sm"> <i class="fas fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6">
                                                            <div class="alert alert-danger" role="alert">No hay pagos registrados
                                                                para este estudiante.</div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php include_once ('../compartido/footer.php'); ?>
        </div>
    </div>
    </div>
<?php } ?>