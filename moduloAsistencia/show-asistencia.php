<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    ?>
    <?php include_once ('../compartido/header.php'); ?>

    <div class="container-fluid page-body-wrapper">
        <?php include_once ('../compartido/sidebar.php'); ?>
        <div class="panel-asistencia main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">Mostrar Asistencia</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mostrar Asistencia</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card" style="margin: 20px;">
                            <div class="card-body">
                                <h4 class="card-title" style="margin-bottom: 30px;">Seleccionar Clase</h4>
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
                                    <button type="submit" style="margin-bottom: 40px;" class="btn btn-primary mr-2"
                                        name="fetch_attendance">Mostrar
                                        Asistencia</button>
                                </form>

                                <?php
                                if (isset($_POST['fetch_attendance'])) {
                                    $classid = $_POST['classid'];

                                    $sql_attendance = "SELECT tblstudent.StuID, tblstudent.StudentName, attendance.WeekNumber, attendance.AttendanceStatus 
                                                   FROM tblstudent 
                                                   LEFT JOIN attendance ON tblstudent.StuID = attendance.StudentID 
                                                   WHERE tblstudent.StudentClass = :classid
                                                   ORDER BY tblstudent.StuID, attendance.WeekNumber";
                                    $query_attendance = $dbh->prepare($sql_attendance);
                                    $query_attendance->bindParam(':classid', $classid, PDO::PARAM_INT);
                                    $query_attendance->execute();
                                    $attendance_records = $query_attendance->fetchAll(PDO::FETCH_ASSOC);

                                    if (count($attendance_records) > 0) {
                                        echo '<h4 class="card-title">Asistencia de la Clase</h4>';
                                        echo '<div style="overflow-x: auto;">';
                                        echo '<table class="table table-bordered">';
                                        echo '<thead>';
                                        echo '<tr>';
                                        echo '<th style="color: white; text-align: center; font-weight: bold;">Estudiante</th>';
                                        for ($i = 1; $i <= 16; $i++) {
                                            echo '<th style="color: white; text-align: center; font-weight: bold;">Semana ' . $i . '</th>';
                                        }
                                        echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';

                                        $attendance_data = array();
                                        foreach ($attendance_records as $record) {
                                            if (!isset($attendance_data[$record['StuID']])) {
                                                $attendance_data[$record['StuID']] = array(
                                                    'name' => $record['StudentName'],
                                                    'weeks' => array()
                                                );
                                            }
                                            $attendance_data[$record['StuID']]['weeks'][$record['WeekNumber']] = $record['AttendanceStatus'];
                                        }

                                        foreach ($attendance_data as $student_id => $data) {
                                            echo '<tr>';
                                            echo '<td style="color: white; text-align: center;">' . $data['name'] . '</td>';
                                            for ($i = 1; $i <= 16; $i++) {
                                                $status = isset($data['weeks'][$i]) ? $data['weeks'][$i] : 'N/A';
                                                $class = '';
                                                switch ($status) {
                                                    case 'presente':
                                                        $class = 'asistencia-presente';
                                                        break;
                                                    case 'ausente':
                                                        $class = 'asistencia-ausente';
                                                        break;
                                                    default:
                                                        break;
                                                }
                                                echo '<td style="color: white; text-align: center;" class="' . $class . '">' . $status . '</td>';
                                            }
                                            echo '</tr>';
                                        }

                                        echo '</tbody>';
                                        echo '</table>';
                                        echo '</div>';
                                    } else {
                                        echo '<p>No hay registros de asistencia para esta clase.</p>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once ('../compartido/footer.php'); ?>
        </div>
    </div>
<?php } ?>