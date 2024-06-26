<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sistema</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <link rel="stylesheet" href="../assets/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../assets/vendors/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../assets/vendors/chartist/chartist.min.css">
  <link rel="stylesheet" href="../assets/vendors/select2/select2.min.css">
  <link rel="stylesheet" href="../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <link rel="stylesheet" href="http://localhost:84/gestion-estudiantes/assets/css/style.css" />

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(nicEditors.allTextAreas);
  </script>
  <script type="text/javascript">
    function checkpass() {
      if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
        alert('New Password and Confirm Password field does not match');
        document.changepassword.confirmpassword.focus();
        return false;
      }
      return true;
    }
  </script>
</head>

<body>
  <div id="page"></div>
  <div id="loading" style="background-color: #282a36;"></div>
  <div class="container-scroller">
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex align-items-center">
        <a class="navbar-brand brand-logo ml-auto text-right" href="http://localhost:84/gestion-estudiantes/dashboard.php">
          <img src="http://localhost:84/gestion-estudiantes/assets/images/logo.png" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="http://localhost:84/gestion-estudiantes/dashboard.php"><img
            src="assets/images/logo.png" alt="logo" /></a>
      </div><?php
      $aid = $_SESSION['sturecmsaid'];
      $sql = "SELECT * from tbladmin where ID=:aid";

      $query = $dbh->prepare($sql);
      $query->bindParam(':aid', $aid, PDO::PARAM_STR);
      $query->execute();
      $results = $query->fetchAll(PDO::FETCH_OBJ);

      $cnt = 1;
      if ($query->rowCount() > 0) {
        foreach ($results as $row) { ?>
          <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
            <h5 class="mb-0 font-weight-medium d-none d-lg-flex"
              style="margin-left: 15px; margin-top:11px; color:white; font-size:1.25rem">BIENVENIDO(A)
              <?php echo htmlentities($row->AdminName); ?>
            </h5>
            <div id="google_translate_element" class="ml-auto"></div>

            <ul class="navbar-nav navbar-nav-right ml-auto">
              <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <img class="img-xs rounded-circle ml-2" src="assets/images/faces/face_perfil.png" alt="Profile image"
                    style="margin-left:60px;"> <i class="fas fa-caret-down" style="color: white; margin-left: 5px;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                  <div class="dropdown-header d-flex">
                    <img class="img-md rounded-circle" src="assets/images/faces/face_perfil.png" width="60px"
                      alt="Profile image">
                    <div>
                      <p class="mb-1 mt-3"><?php echo htmlentities($row->AdminName); ?></p>
                      <p class="font-weight-light text-muted mb-0"><?php echo htmlentities($row->Email); ?></p>
                    </div>

                  </div><?php $cnt = $cnt + 1;
        }
      } ?>
              <a class="dropdown-item" href="profile.php"><i class="fas fa-user text-primary"></i> Mi Perfil</a>
              <a class="dropdown-item" href="change-password.php"><i class="fas fa-key text-primary"></i> Cambiar
                Contrasena</a>
              <a class="dropdown-item" href="logout.php"><i class="fas fa-power-off text-primary"></i> Cerrar Sesion</a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>