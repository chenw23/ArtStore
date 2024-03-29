<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Art Store-account</title>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="css/site_theme.css">
</head>
<body>
<?php
session_start();
if (isset($_COOKIE['footprint'])) {
  setcookie('footprint', $_COOKIE['footprint'] . ("account.php" . ","));
  setcookie('title', $_COOKIE['title'] . "Account Page,");
} else {
  setcookie('footprint', "account.php,");
  setcookie('title', "Account Page,");
}
require_once 'includes\config.php';
include 'art-header.inc.php';
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
$connection->query("SET NAMES utf8");
$error = mysqli_connect_error();
if ($error != null) {
  $output = "<p>Unable to connect to database<p>" . $error;
  exit($output);
}
?>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-heading">Account</div>
        <div class="panel-body">
          <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="account.php">My Account</a></li>
            <li><a href="my_artworks.php">My art works</a></li>
            <li><a href="sold.php">Sold art works</a></li>
            <li><a href="ordered.php">Order history</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="page-header">
        <h2>My Account</h2>
        <?php
        if (!isset($_SESSION['email']))
          exit("<h1>Please login first.</h1>");
        $email = $_SESSION['email'];
        if (isset($_GET['topUp'])) {
          $amount = $_GET['topUp'];
          $sql = "SELECT balance FROM users WHERE email='$email'";
          $result = mysqli_query($connection, $sql);
          $userInformation = mysqli_fetch_all($result, MYSQLI_ASSOC);
          $balance = $userInformation[0]['balance'];
          $balance = $balance + $amount;
          $sql = "UPDATE users SET balance = $balance WHERE email='$email'";
          mysqli_query($connection, $sql);
        }
        $sql = "SELECT name,balance FROM users WHERE email='$email'";
        $result = mysqli_query($connection, $sql);
        $userInformation = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $name = $userInformation[0]['name'];
        $balance = $userInformation[0]['balance'];
        ?>
        <p>Welcome .</p>
      </div>
      <div class="form-group">
        <label class="col-lg-2 control-label">Email</label>
        <div class="col-lg-10">
          <p class="form-control-static"><?php echo $email ?></p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-2 control-label">Name</label>
        <div class="col-lg-10">
          <p class="form-control-static"><?php echo $name ?></p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-2 control-label">Balance</label>
        <div class="col-lg-10">
          <p class="form-control-static"><?php echo $balance ?></p>
        </div>
      </div>
      <form action="account.php?topUp">
        <input title="Top up amount" required="required" name="topUp"
               type="number" placeholder="The amount of top up">
        <button type="submit" class="btn btn-primary"> Top Up
        </button>
      </form>
    </div>
  </div>
</div>  <!-- end container -->
<?php include 'art-footer.inc.php' ?>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
