<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $classid = $_POST['classid'];
        $weeknumber = $_POST['weeknumber'];
        $attendance = $_POST['attendance'];

        foreach ($attendance as $studentid => $status) {
            $sql = "INSERT INTO attendance (StudentID, ClassID, WeekNumber, AttendanceStatus) VALUES (:studentid, :classid, :weeknumber, :status)
                    ON DUPLICATE KEY UPDATE AttendanceStatus=:status";
            $query = $dbh->prepare($sql);
            $query->bindParam(':studentid', $studentid, PDO::PARAM_INT);
            $query->bindParam(':classid', $classid, PDO::PARAM_INT);
            $query->bindParam(':weeknumber', $weeknumber, PDO::PARAM_INT);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->execute();
        }

        echo '<script>alert("Asistencia registrada exitosamente")</script>';
    }
    ?>
    <?php include_once ('../compartido/header.php'); ?>

    <div class="container-fluid page-body-wrapper">
        <?php include_once ('../compartido/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">Registrar Asistencia</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Registrar Asistencia</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="margin-bottom: 20px;">Seleccionar Clase y Semana</h4>
                                <form class="forms-sample" method="post">
                                    <div class="form-group">
                                        <label for="classid">Clase</label>
                                        <select class="form-control" id="classid" name="classid" required>
                                            <option value="">Seleccionar Clase</option>
                                            <?php
                                            $sql_classes = "SELECT * FROM tblclass";
                                            $query_classes = $dbh->prepare($sql_classes);
                                            $query_classes->execute();
                                            $classes = $query_classes->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($classes as $class) {
                                                echo "<option value='" . $class['ID'] . "'>" . $class['ClassName'] . " " . $class['Section'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="weeknumber">Semana</label>
                                        <select class="form-control" id="weeknumber" name="weeknumber" required>
                                            <option value="">Seleccionar Semana</option>
                                            <?php
                                            for ($i = 1; $i <= 16; $i++) {
                                                echo "<option value='" . $i . "'>Semana " . $i . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2" name="fetch_students">Mostrar
                                        Estudiantes</button>
                                </form>

                                <?php
                                if (isset($_POST['fetch_students'])) {
                                    $classid = $_POST['classid'];
                                    $weeknumber = $_POST['weeknumber'];
                                    $sql_check = "SELECT COUNT(*) as count FROM attendance WHERE ClassID = :classid AND WeekNumber = :weeknumber";
                                    $query_check = $dbh->prepare($sql_check);
                                    $query_check->bindParam(':classid', $classid, PDO::PARAM_INT);
                                    $query_check->bindParam(':weeknumber', $weeknumber, PDO::PARAM_INT);
                                    $query_check->execute();
                                    $result_check = $query_check->fetch(PDO::FETCH_ASSOC);

                                    $attendance_registered = $result_check['count'] > 0;

                                    if ($attendance_registered) {
                                        echo '<p style="margin-top:20px;">La asistencia para esta clase y semana ya ha sido registrada.</p>';
                                    } else {
                                        $sql_students = "SELECT StuID, StudentName FROM tblstudent WHERE StudentClass = :classid";
                                        $query_students = $dbh->prepare($sql_students);
                                        $query_students->bindParam(':classid', $classid, PDO::PARAM_INT);
                                        $query_students->execute();
                                        $students = $query_students->fetchAll(PDO::FETCH_ASSOC);

                                        if (count($students) > 0) {
                                            echo '<form method="post">';
                                            echo '<input type="hidden" name="classid" value="' . $classid . '">';
                                            echo '<input type="hidden" name="weeknumber" value="' . $weeknumber . '">';
                                            echo '<table class="table table-bordered" style="margin-top:50px;">';
                                            echo '<thead>';
                                            echo '<tr>';
                                            echo '<th style="color: white; text-align: center; font-weight: bold;">Estudiante</th>';
                                            echo '<th style="color: white; text-align: center; font-weight: bold;">Asistencia</th>';
                                            echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                            foreach ($students as $student) {
                                                echo '<tr>';
                                                echo '<td style="color: white; text-align: center;">' . $student['StudentName'] . '</td>';
                                                echo '<td style="text-align: center;">';
                                                echo '<button type="button" class="btn btn-success" onclick="toggleAttendance(this)">Presente</button>';
                                                echo '<input type="hidden" name="attendance[' . $student['StuID'] . ']" value="presente" />';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                            echo '</tbody>';
                                            echo '</table>';
                                            echo '<button type="submit" class="btn btn-primary mr-2" name="submit" style="margin-top:30px;">Registrar Asistencia</button>';
                                            echo '</form>';
                                        } else {
                                            echo '<p>No hay estudiantes inscritos en esta clase.</p>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function toggleAttendance(button) {
                        var attendanceInput = button.nextElementSibling;
                        if (attendanceInput.value === 'presente') {
                            attendanceInput.value = 'ausente';
                            button.textContent = 'Ausente';
                            button.classList.remove('btn-success');
                            button.classList.add('btn-danger');
                        } else {
                            attendanceInput.value = 'presente';
                            button.textContent = 'Presente';
                            button.classList.remove('btn-danger');
                            button.classList.add('btn-success');
                        }
                    }
                </script>
            </div>
            <?php include_once ('../compartido/footer.php'); ?>
        </div>
    </div>
<?php } ?>