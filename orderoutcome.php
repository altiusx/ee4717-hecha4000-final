<?php
session_start();
$customerID = $_SESSION['valid_user'];
$orderid = $_SESSION['orderid'];

if ($_SESSION['orderoutcomedisplay'] != 0 or !isset($_SESSION['orderoutcomedisplay'])){ // this page is only accessible after processorder.php script is run
    echo '<script language="javascript">';
    echo 'alert("Redirecting you back to Homepage")';
    echo '</script>';
    header("Refresh:0; url=index.php"); 
}
$_SESSION['orderoutcomedisplay'] = 1; // takes effect after user refreshes/moves away from this page
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Order Outcome | Hecha 4000</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="styles.css">
  <link rel="icon" href="assets/logos/logoedited.png">
</head>

<style>
  .status {
    background-color: #72a2a2;
    color: white;
    font-weight: bold;
    padding: 12px 50px;
    width: 100%;
    border: none;
    cursor: pointer;
    border-radius: 12px;
    font-size: 16px;
  }

  .status:hover {
    background-color: #55746f;
  }

  .return {
    background-color: #A9A9A9;
    color: white;
    font-weight: bold;
    padding: 12px 50px;
    width: 100%;
    border: none;
    cursor: pointer;
    border-radius: 12px;
    font-size: 16px;
  }

  .return:hover {
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
          <li><a href="status.php">Status</a></li>
          <li><a href="contactus.php">Contact Us</a></li>
          <li><a href="account.php">Account</a></li>
          <li class="right-nav"><a class="right-nav" href="cart.php">Cart</a></li>
        </b></ul>
    </nav>


    <div class="content">
      <p>Order completed. Your order number is: <?php echo $orderid; ?></p>
      <form action="status.php"><input type="submit" class="status" value="Check Status"></form><br>
      <form action="order.php"><input type="submit" class="return" value="Return To Menu"></form>
    </div>
    <footer>
      <small><i>Copyright &copy; 2020 Hecha 4000 Pte Ltd. All rights reserved.</i></small>
    </footer>
</body>

</html>