<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Art Stored-Shopping Cart</title>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/site_theme.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="page-header">
    <?php
    session_start();
    require_once 'includes\config.php';
    include 'art-header.inc.php';
    if (!isset($_SESSION['email']))
      exit("<h1>Please login first.</h1>");
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $connection->query("SET NAMES utf8");
    $error = mysqli_connect_error();
    if ($error != null) {
      $output = "<p>Unable to connect to database<p>" . $error;
      exit($output);
    }
    if (isset($_GET['delete']) && isset($_SESSION['email'])) {
      $email = $_SESSION['email'];
      $artworkID = $_GET['delete'];
      $sql = "DELETE FROM carts WHERE artworkID=$artworkID AND userEmail = '$email'";
      mysqli_query($connection, $sql);
    } ?>
    <h2>View Cart</h2>
    <?php
    if (!isset($_SESSION['email']))
      exit("<h1>Please login first.</h1>"); ?>
    <table class="table table-bordered
    table-striped table-hover table-condensed">
      <tbody>
      <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Price</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
      <?php
      $email = $_SESSION['email'];
      $sql =
          "SELECT imageFileName,title,description,artworkID,price FROM carts WHERE userEmail = '$email'";
      $result = mysqli_query($connection, $sql);
      $images = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $totalPrice = 0;
      for ($i = 0; $i < count($images); $i++) {
        $description = $images[$i]['description'];
        if (strlen($description) > 400)
          $description = substr($description, 0, 300);
        $artworkID = $images[$i]['artworkID'];
        echo "<tr>";
        echo "<td><img class=\"img-thumbnail\" src=\"img/" .
            $images[$i]['imageFileName'] . "\" /></td>";
        echo "<td><em><a href=\"details.php?artworkID=" .
            $images[$i]['artworkID'] . "\">" .
            $images[$i]['title'] . "</a></em></td>";
        echo "<td>" . $description . "</td>";
        echo "<td>$" . $images[$i]['price'] . "</td>";
        echo "<td><a type=\"button\" class=\"btn btn-danger\" href='shopping_cart.php?delete=$artworkID'>Remove</a></td>";
        echo "</tr>";
        $totalPrice += $images[$i]['price'];
      }
      ?>
      <tr class="success strong">
        <td colspan="3" class="moveRight">Subtotal</td>
        <td colspan="2">$<?php echo $totalPrice ?></td>
      </tr>
      <tr class="active strong">
        <td colspan="3" class="moveRight">Tax</td>
        <td colspan="2">$0</td>
      </tr>
      <tr class="strong">
        <td colspan="3" class="moveRight">Shipping</td>
        <td colspan="2">$0</td>
      </tr>
      <tr class="warning strong text-danger">
        <td colspan="3" class="moveRight">Grand Total</td>
        <td colspan="2">$<?php echo $totalPrice ?></td>
      </tr>
      <tr>
        <td colspan="3" class="moveRight">
          <button type="button" class="btn btn-primary"
                  href="index.php">Continue Shopping
          </button>
        </td>
        <td colspan="2">
          <button type="button" class="btn btn-success">Checkout</button>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</div>
<?php include 'art-footer.inc.php' ?>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>