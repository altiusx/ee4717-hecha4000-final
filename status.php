<?php
// connect to db
@$db = new mysqli('localhost', 'f37ee', 'f37ee', 'f37ee');

if (mysqli_connect_errno()) {
  echo 'Error: Could not connect to database.  Please try again later.';
  exit;
}
  $status = '';
  if (isset($_POST['order']) and isset($_POST['email'])){ // when order status form is submitted
  $order = $_POST['order'];
  $email = $_POST['email'];

  $query = "SELECT * FROM customers WHERE custemail='$email'";
  $result = $db->query($query);
  $num_results = $result -> num_rows;

  if ($num_results > 0) { // if email exists
    $query = "SELECT currentstatus FROM orders WHERE orderid='$order'";
    $result1 = $db->query($query);
    $num_results1 = $result1 -> num_rows;
    if ($num_results1 > 0) { // if order exists
      $row = $result1->fetch_assoc();
      $status = "For order " . $order . ": " . $row['currentstatus'];
    } else {  // if email exists but order number is wrong
      $status = "Order not found. Please try again!";
    }
  } else {  // if email is wrong
    $status = "Error. Check your fields again";
  }
  echo '<script language="javascript">';
  echo "alert(\"$status\")";
  echo '</script>';

  $db->close();
  header("Refresh:0; url=status.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Status | Hecha 4000</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="styles.css" type="text/css" media="all">
  <link rel="icon" href="assets/logos/logoedited.png">
  <script type="text/javascript" src="scripts/js.js"></script>
</head>

<style>
  form {
    padding: 20px 40px;
  }

  .order,
  .email {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    margin-top: 6px;
    margin-bottom: 16px;
  }

  input[type=submit] {
    background-color: #72a2a2;
    color: white;
    font-weight: bold;
    padding: 12px 50px;
    border: none;
    cursor: pointer;
    border-radius: 8px;
    font-size: 16px;
  }

  input[type=submit]:hover {
    background-color: #55746f;
  }

  input[type=reset] {
    background-color: #A9A9A9;
    color: white;
    font-weight: bold;
    padding: 12px 20px;
    border: none;
    cursor: pointer;
    border-radius: 8px;
    font-size: 16px;
  }

  input[type=reset]:hover {
    background-color: #808080;
  }
</style>

<body>
  <div id="wrapper">
    <header>
      <a href="index.php"><img src="assets/logos/logoedited.png" width="200px" height="200px" alt="hecha 4000 Logo"></a>
    </header>

    <nav>
      <ul><b>
          <li><a href="index.php">Home</a></li>
          <li><a href="aboutus.php">About Us</a></li>
          <li><a href="order.php">Order</a></li>
          <li><a class="active" href="status.php">Status</a></li>
          <li><a href="contactus.php">Contact Us</a></li>
          <li><a href="account.php">Account</a></li>
          <li class="right-nav"><a class="right-nav" href="cart.php">Cart</a></li>
        </b></ul>
    </nav>

    <div class="content">
      <div class="col-container">
        <div class="col-left">
          <div style="text-align: center;">
            <h2>Order Status</h2>
            <p>Check the status of your order below:</p>
          </div>
          <form action="status.php" method="POST">
            <label for="ordernumber">Order Number</label>
            <input type="number" name="order" class="order" id="ordernumber" placeholder="Enter your order number" min=1 step=1 required>
            <label for="email">Email Address</label>
            <input type="email" class="email" name="email" id="email" placeholder="example@domain.com" required onchange="emailCheck(id)">
            <input type="submit" value="Submit">
            <input type="reset" value="Clear">
          </form>
        </div>

        <div class="col-right">
          <h3>Try out our signature drinks!</h3>

          <div class="signature-drinks-overlay">
            <img src="assets/products/earlgrey.png" alt="Earl Grey Milk Tea" width="200" height="300">
            <div class="overlay-text"><b><a href="order.php#ClassicEarlGreyMT">Classic Earl Grey Milk Tea</a></b></div>
          </div>

          <div class="signature-drinks-overlay">
            <img src="assets/products/matcha.png" alt="Matcha Milk Tea" width="200" height="300">
            <div class="overlay-text"><b><a href="order.php#MarvelousMatcha">Marvelous Matcha</a></b></div>
          </div>

          <div class="signature-drinks-overlay">
            <img src="assets/products/oolongpearls.png" alt="Matcha Milk Tea" width="200" height="300">
            <div class="overlay-text"><b><a href="order.php#DingdongOolongFMT">Dingdong Oolong Fresh Milk Tea</a></b></div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <small><i>Copyright &copy; 2020 Hecha 4000 Pte Ltd. All rights reserved.</i></small>
    </footer>
</body>

</html>
