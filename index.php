<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Art Store</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/site_theme.css">
</head>
<body>
<?php
session_start();
if (isset($_COOKIE['footprint'])) {
  setcookie('footprint', $_COOKIE['footprint'] . ("index.php" . ","));
  setcookie('title', $_COOKIE['title'] . "Home Page,");
} else {
  setcookie('footprint', "index.php,");
  setcookie('title', "Home Page,");
}
require_once 'includes\config.php';
if (isset($_GET['logOut']) && isset($_SESSION['email']))
  unset($_SESSION['email']);
setcookie("email", "", -1);
include 'art-header.inc.php';
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
$connection->query("SET NAMES utf8");
$error = mysqli_connect_error();
if ($error != null) {
  $output = "<p>Unable to connect to database<p>" . $error;
  exit($output);
}
$sqlView =
    "SELECT imageFileName,title,description,artworkID FROM artworks WHERE buyerEmail IS NULL ORDER BY view DESC LIMIT 3";
$result = mysqli_query($connection, $sqlView);
$imagesViewMost = mysqli_fetch_all($result, MYSQLI_ASSOC);
$sqlRecent = "SELECT * FROM artworks WHERE buyerEmail IS NULL ORDER BY timeReleased DESC LIMIT 3";
$result = mysqli_query($connection, $sqlRecent);
$imagesMostRecent = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item active">
            <img src="img/<?php echo $imagesViewMost[0]['imageFileName'] ?>">
            <div class="carousel-caption">
              <a href="details.php?artworkID=<?php echo $imagesViewMost[0]['artworkID'] ?>">
                <h3><?php echo $imagesViewMost[0]['title'] ?>
                </h3>
              </a>
              <?php echo substr($imagesViewMost[0]['description'], 0, 100) ?>
            </div>
          </div>
          <div class="item">
            <img src="img/<?php echo $imagesViewMost[1]['imageFileName'] ?>">
            <div class="carousel-caption">
              <a href="details.php?artworkID=<?php echo $imagesViewMost[1]['artworkID'] ?>">
                <h3>
                  <?php echo $imagesViewMost[1]['title'] ?>
                </h3>
              </a>
              <?php echo substr($imagesViewMost[1]['description'], 0, 100) ?>
            </div>
          </div>
          <div class="item">
            <img src="img/<?php echo $imagesViewMost[2]['imageFileName'] ?>">
            <div class="carousel-caption">
              <h3>
                <a href="details.php?artworkID=<?php echo $imagesViewMost[2]['artworkID'] ?>">
                  <?php echo $imagesViewMost[2]['title'] ?>
                </a>
              </h3>
              <?php echo substr($imagesViewMost[2]['description'], 0, 100) ?>
            </div>
          </div>
        </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        <img src="img/<?php echo $imagesMostRecent[0]['imageFileName'] ?>">
        <div class="caption">
          <h3><a href="details.php?artworkID=<?php echo $imagesMostRecent[0]['artworkID'] ?>">
              <?php echo $imagesMostRecent[0]['title'] ?>
            </a>
          </h3>
          <p>By
            <?php echo $imagesMostRecent[0]['artist'] ?>
          </p>
          <p>
            <?php echo $imagesMostRecent[0]['description'] ?>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        <img src="img/<?php echo $imagesMostRecent[1]['imageFileName'] ?>">
        <div class="caption">
          <h3><a href="details.php?artworkID=<?php echo $imagesMostRecent[1]['artworkID'] ?>">
              <?php echo $imagesMostRecent[1]['title'] ?>
            </a>
          </h3>
          <p>By
            <?php echo $imagesMostRecent[1]['artist'] ?>
          </p>
          <p>
            <?php echo $imagesMostRecent[1]['description'] ?>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        <img src="img/<?php echo $imagesMostRecent[2]['imageFileName'] ?>">
        <div class="caption">
          <h3><a href="details.php?artworkID=<?php echo $imagesMostRecent[2]['artworkID'] ?>">
              <?php echo $imagesMostRecent[2]['title'] ?>
            </a>
          </h3>
          <p>By
            <?php echo $imagesMostRecent[2]['artist'] ?>
          </p>
          <p>
            <?php echo $imagesMostRecent[2]['description'] ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'art-footer.inc.php' ?>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>