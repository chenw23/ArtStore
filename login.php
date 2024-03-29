<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Art Store-login</title>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="css/site_theme.css">
</head>
<body>
<?php
session_start();
if (isset($_COOKIE['footprint'])) {
  setcookie('footprint', $_COOKIE['footprint'] . ("login.php" . ","));
  setcookie('title', $_COOKIE['title'] . "Login Page,");
} else {
  setcookie('footprint', "login.php,");
  setcookie('title', "Login Page,");
}
$status = '0';
if (isset($_POST['email']) && isset($_POST['passwordLogin'])) {
  require_once 'includes\config.php';
  $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
  $connection->query("SET NAMES utf8");
  $error = mysqli_connect_error();
  if ($error != null) {
    $output = "<p>Unable to connect to database<p>" . $error;
    exit($output);
  }
  $email = $_POST['email'];
  $longHashPassword = saltHash($_POST['passwordLogin']);
  $sql = "SELECT COUNT(*) FROM users WHERE email='$email' AND password='$longHashPassword'";
  $result = mysqli_query($connection, $sql);
  $row = $result->fetch_assoc();
  if ($row['COUNT(*)'] === '0')
    $status = 'loginFailed';
  else {
    $status = 'loginSuccess';
    $expiryTime = time() + 60 * 60 * 24;
    $_SESSION['email'] = $_POST['email'];
  }
}
include 'art-header.inc.php';
function saltHash($originalPassword)
{
  $salt = "RandomSALT_HJFKJDKL";  //the random string is set here
  $longPassword = $originalPassword . $salt;
  //connects the original password with the random string
  $longHashPassword = md5($longPassword);  //perform  MD5 calculation
  return $longHashPassword;  //returns the new password
}

?>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-heading">Account</div>
        <div class="panel-body">
          <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="login.php">Login</a></li>
            <li><a href="register_page.php">Register</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <?php
      if ($status === 'loginSuccess') {
        echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">";
        echo "<span aria-hidden=\"true\">&times;</span>";
        echo "</button>";
        echo "<strong>Success! </strong>";
        echo " You have successfully Logged in. </div>";
      } elseif ($status === 'loginFailed') {
        echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">";
        echo "<span aria-hidden=\"true\">&times;</span>";
        echo "</button>";
        echo "<strong>Failed! </strong>";
        echo "Sorry! Log in is failed.</div>";
      }
      ?>
      <form role="form" class="form-horizontal" action="login.php"
            method="post">
        <div class="page-header">
          <h2>Log in</h2>
          <p>If you don't have an account with us,
            please register at the register page.</p>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Email</label>
          <div class="col-md-9">
            <input type="email" title="email" class="form-control"
                   name="email" required="required">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Password</label>
          <div class="col-md-9">
            <input type="password" title="password" class="form-control"
                   name="passwordLogin" required="required">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn btn-primary">Log in
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>  <!-- end container -->
<?php include 'art-footer.inc.php' ?>
<?php
if (($status === 'loginSuccess') && isset($_COOKIE['footprint'])) {
  $path = explode(",", $_COOKIE['footprint']);
  if (count($path) > 2) {
    $url = $path[count($path) - 3];
    echo "<script>";
    echo "function jump(){  ";
    echo "location='$url';  ";
    echo "}  ";
    echo "setTimeout('jump()',3000);  ";
  }
  echo "</script>";
} ?>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/confirmation.js"></script>
</body>
</html>