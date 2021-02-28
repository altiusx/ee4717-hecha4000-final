<?php
session_start();

if (!isset($_SESSION['valid_user'])) {  // if not logged in, redirect to login page
  echo '<script language="javascript">';
  echo 'alert("Please login first. Redirecting you to login page.")';
  echo '</script>';
  header("Refresh:0; url=account.php");
}

if (!isset($_SESSION['cart'])) { 
  $_SESSION['cart'] = array();
}
if (!isset($_SESSION['cartstockqty'])) {
  $_SESSION['cartstockqty'] = array_fill(0, 3, 0); // to keep track of quantity of items in the cart
}
if (isset($_GET['empty'])) {  // upon clicking on remove button
  $strVal = str_replace("plus", "+", $_GET['empty']); // replace back "plus" with "+" (if the value is of DIYdrink's); else no change to $_GET['empty'] value
  $del = array_keys($_SESSION['cart'], $strVal);  // $del is an array containing the keys/index of $_GET['empty']/$strVal (product to be deleted)
  foreach ($del as $val) { // remove the cart items based on the values given in $del
    unset($_SESSION['cart'][$val]);
  }
  $_SESSION['cart'] = array_values($_SESSION['cart']);  // tidy up the remaining products in the cart by making them start from index 0

  // to handle Signature Drinks stock (after removing some Signature Drinks)
  $cartArr = array_count_values($_SESSION['cart']);
  if (empty($cartArr)) { // check if $cartArr is empty
    $_SESSION['cartstockqty'][0] = 0;
    $_SESSION['cartstockqty'][1] = 0;
    $_SESSION['cartstockqty'][2] = 0;
  } else {
    foreach ($cartArr as $key => $qtyvalue) {
      if (!array_key_exists("ClassicEarlGreyMT", $cartArr)) { // set qty to 0 for ClassicEarlGreyMT if array key doesn't exist
        $_SESSION['cartstockqty'][0] = 0;
      }
      if (!array_key_exists("MarvelousMatcha", $cartArr)) { // set qty to 0 for MarvelousMatcha if array key doesn't exist
        $_SESSION['cartstockqty'][1] = 0;
      }
      if (!array_key_exists("DingdongOolongFMT", $cartArr)) { // set qty to 0 for DingdongOolongFMT if array key doesn't exist
        $_SESSION['cartstockqty'][2] = 0;
      }
    }
  }
  header('location: ' . $_SERVER['PHP_SELF']);
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Cart | Hecha 4000</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="styles.css">
  <link rel="icon" href="assets/logos/logoedited.png">
  <?php require "scripts/fillvalues.php"; ?>
</head>

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
          <li class="right-nav"><a class="right-nav active" href="cart.php">Cart</a></li>
        </b></ul>
    </nav>


    <div class="content">
      <div class="cart-table">
        <h2>Cart</h2>
        <table border="0">
          <?php
          $orderItemsArr = array_count_values($_SESSION['cart']);
          $total = 0.00; // to keep track of total price for cart
          $totalqty = 0; // to keep track of total qty for cart
          if (empty($orderItemsArr)) {  // check if cart is empty
            echo "<p>Cart is empty!</p>";
          } else {
            echo "<tr><th>Item</th><th>Quantity</th><th>Subtotal</th><th>Remove?</th></tr>";
          }
          // $namearray and $pricearray are generated from the fillvalues.php script
          foreach ($orderItemsArr as $key => $qtyvalue) {  // iterate through each product and qty in cart
            if ($key == "ClassicEarlGreyMT") {
              $subtotal = number_format(($qtyvalue * $pricearray[0]), 2, '.', '');
              $total += $subtotal;
              $totalqty += $qtyvalue;
              echo "<tr>";
              echo "<td>$namearray[0]</td><td>$qtyvalue</td>";
              echo "<td>\$$subtotal</td>";
              echo "<td><a href=" . $_SERVER['PHP_SELF'] . "?empty=" . $key . "><img src=\"assets/logos/removecart.png\" width=\"31px\" height=\"24px\" alt=\"Remove\"></a></td>";
              echo "</tr>";
            } else if ($key == "MarvelousMatcha") {
              $subtotal = number_format(($qtyvalue * $pricearray[1]), 2, '.', '');
              $total += $subtotal;
              $totalqty += $qtyvalue;
              echo "<tr>";
              echo "<td>$namearray[1]</td><td>$qtyvalue</td>";
              echo "<td>\$$subtotal</td>";
              echo "<td><a href=" . $_SERVER['PHP_SELF'] . "?empty=" . $key . "><img src=\"assets/logos/removecart.png\" width=\"31px\" height=\"24px\" alt=\"Remove\"></a></td>";
              echo "</tr>";
            } else if ($key == "DingdongOolongFMT") {
              $subtotal = number_format(($qtyvalue * $pricearray[2]), 2, '.', '');
              $total += $subtotal;
              $totalqty += $qtyvalue;
              echo "<tr>";
              echo "<td>$namearray[2]</td><td>$qtyvalue</td>";
              echo "<td>\$$subtotal</td>";
              echo "<td><a href=" . $_SERVER['PHP_SELF'] . "?empty=" . $key . "><img src=\"assets/logos/removecart.png\" width=\"31px\" height=\"24px\" alt=\"Remove\"></a></td>";
              echo "</tr>";
            } else {  // if it's not the signature drinks (ie DIY drinks)
              $DIYarr = explode("+", $key); // the individual components (teatype, addons, sugar level, ice level) for the DIY drink are put into an array (split via "+")
              array_shift($DIYarr); // array_shift removes index 0 (ie "DIYdrink")
              $DIYstr = ''; // DIY order string
              $subtotal = 0.00;
              $DIYqty = $qtyvalue;

              foreach ($DIYarr as $componentvalue) { // iterate through each component value of the DIY order 
                $DIYstr .= " $namearray[$componentvalue]<br>";
                $subtotal += $pricearray[$componentvalue];
              }
              $total += ($subtotal * $DIYqty);
              $totalqty += $DIYqty;
              echo "<tr>";
              echo "<td>$DIYstr</td><td>$DIYqty</td>";
              echo "<td>$" . number_format($subtotal * $DIYqty, 2, '.', '') . "</td>";
              echo "<td><a href=" . $_SERVER['PHP_SELF'] . "?empty=" . str_replace("+", "plus", $key) . "><img src=\"assets/logos/removecart.png\" width=\"31px\" height=\"24px\" alt=\"Remove\"></a></td>"; // str_replace needed as "+" is reserved
              echo "</tr>";
            }
          }
          if (!empty($orderItemsArr)) {  // check if cart is empty
            $total = number_format($total, 2, '.', '');
            $_SESSION['total'] = $total;  // to hold total price
            echo "<tr><th>Total:</th><th>$totalqty</th><th>\$$total</th><th></th></tr>";
          }
          ?>
        </table>
        <?php
        if (!empty($orderItemsArr)) {  // if cart is not empty，display checkout button
          //echo "<br><a class=\"bar-design-link\" href=\"scripts/processorder.php\">";
          //echo "<div class=\"bar-design\">";
          //echo "<p><b>Check Out</b></p></div></a>";
          echo '<br><form action="scripts/processorder.php"><input type="submit" class="bar-design" value="Check Out"></form><br>';
        }
        //echo "<br><a class=\"bar-design-link\" href=\"order.php\">";
        //echo "<div class=\"bar-design\">";
        //echo "<p><b>Back to Order Menu</b></p></div></a>";
        echo '<form action="order.php"><input type="submit" class="bar-design-2" value="Back to Order Menu"></form>';
        ?>

      </div>
    </div>
    <footer>
      <small><i>Copyright &copy; 2020 Hecha 4000 Pte Ltd. All rights reserved.</i></small>
    </footer>
</body>

</html>