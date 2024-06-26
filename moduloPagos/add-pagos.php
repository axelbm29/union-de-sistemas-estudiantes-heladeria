<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $studentID = $_POST['studentID'];
        $paymentType = $_POST['paymentType'];
        $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
        if (!empty($amount)) {
            $sql = "INSERT INTO tblpayments(StudentID, PaymentType, Amount, PaymentDate) VALUES(:studentID, :paymentType, :amount, NOW())";
            $query = $dbh->prepare($sql);
            $query->bindParam(':studentID', $studentID, PDO::PARAM_STR);
            $query->bindParam(':paymentType', $paymentType, PDO::PARAM_STR);
            $query->bindParam(':amount', $amount, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                echo "<script>alert('Pago agregado correctamente');</script>";
                echo "<script>window.location.href='add-pagos.php'</script>";
            } else {
                echo "<script>alert('Hubo un error al agregar el pago');</script>";
            }
        } else {
            echo "<script>alert('El monto no puede estar vacío');</script>";
        }
    }
    ?>
    <?php include_once ('../compartido/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once ('../compartido/sidebar.php'); ?>
        <div class="main-panel" style="width: calc(100% - 300px)">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title"> Agregar Pagos </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Agregar Pagos</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Agregar Pago</h4>
                                <form class="forms-sample" method="post" action="">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Estudiante</label>
                                        <select class="form-control" id="stuID" name="studentID" required="true">
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
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Tipo de Pago</label>
                                        <select class="form-control" id="paymentType" name="paymentType" required="true">
                                            <option value="">Seleccionar Tipo de Pago</option>
                                            <option value="Matricula">Matricula</option>
                                            <option value="Pension">Pension</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Monto</label>
                                        <input type="hidden" class="form-control" id="amount" name="amount" value="">
                                        <input type="text" class="form-control" id="montoMostrado" value="" readonly>
                                    </div>


                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Agregar Pago</button>
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

<script>
    document.getElementById('paymentType').addEventListener('change', function () {
        var paymentType = this.value;
        var amountInput = document.getElementById('amount');
        var montoMostradoInput = document.getElementById('montoMostrado');

        if (paymentType === 'Matricula') {
            amountInput.value = '300';
            montoMostradoInput.value = 'S/. 300';
        } else if (paymentType === 'Pension') {
            amountInput.value = '200';
            montoMostradoInput.value = 'S/. 200';
        } else {
            amountInput.value = '';
            montoMostradoInput.value = '';
        }
    });
</script>