<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Air Project Login</title>
    <link href="management/themes/management_theme/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="management/themes/management_theme/vendors/bootstrap/dist/css/font-awesome.min.css" rel="stylesheet">
    <link href="management/themes/management_theme/vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="management/themes/management_theme/vendors/animate.css/animate.min.css" rel="stylesheet">
    <link href="management/themes/management_theme/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method='post'>
              <h1>Login Form</h1>
              <div>
                <input type="text" name='loginName' class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name='loginPass' class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button name='login' class="btn btn-default">Log in</button>
              <?php  if (isset($_POST['login'])) {
                  $login = $_POST['loginName'];
                  $pass = $_POST['loginPass'];
                  if ($login == "admin" && $pass == "admin") {
                      $_SESSION['login'] =  $login;
                      header("Location: index.php");
                  } else {
                       ?> <div><h2>Error, wrong username or password.</h2></div> <?php
                  }
              } ?>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
