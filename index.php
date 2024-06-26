<?php
session_start();

include ('compartido/dbconnection.php');

if (isset($_POST['login'])) {
  $username = htmlspecialchars($_POST['username']);
  $password = $_POST['password'];

  $sql = "SELECT ID, Password FROM tbladmin WHERE UserName=:username";
  $query = $dbh->prepare($sql);
  $query->bindParam(':username', $username, PDO::PARAM_STR);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_OBJ);

  if ($result && $password === $result->Password) {
    $_SESSION['sturecmsaid'] = $result->ID;

    if (!empty($_POST["remember"])) {
      setcookie("user_login", $username, time() + (10 * 365 * 24 * 60 * 60));
      setcookie("userpassword", $password, time() + (10 * 365 * 24 * 60 * 60));
    } else {
      if (isset($_COOKIE["user_login"])) {
        setcookie("user_login", "", time() - 3600);
      }
      if (isset($_COOKIE["userpassword"])) {
        setcookie("userpassword", "", time() - 3600);
      }
    }

    $_SESSION['login'] = $username;
    echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
  } else {
    echo "<script>alert('Detalles inválidos');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sistema</title>
  <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .content-wrapper {
      background-color: #282a36;
    }

    .footer {
      display: none;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-center p-5">
              <div class="brand-logo">
                <img src="assets/images/logo.png">
              </div>
              <h4>Login</h4>
              <h6 class="font-weight-light">Ingresa tus credenciales</h6>
              <form class="pt-3" id="login" method="post" name="login">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" placeholder="Ingresa tu usuario"
                    required="true" name="username" value="<?php if (isset($_COOKIE["user_login"])) {
                      echo $_COOKIE["user_login"];
                    } ?>">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" placeholder="Ingresa tu contraseña"
                    name="password" required="true" value="<?php if (isset($_COOKIE["userpassword"])) {
                      echo $_COOKIE["userpassword"];
                    } ?>">
                </div>
                <div class="mt-3">
                  <button class="btn btn-info btn-block loginbtn" name="login" type="submit">Acceder</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php include_once ('compartido/footer.php'); ?>
    </div>
  </div>
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>