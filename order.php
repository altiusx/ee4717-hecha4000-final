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
/*if (isset($_GET['buy'])) {
  $_SESSION['cart'][] = $_GET['buy'];
  header('location: ' . $_SERVER['PHP_SELF'] . '?' . SID);
  exit();
}*/
if (!isset($_SESSION['cartstockqty'])){
$_SESSION['cartstockqty'] = array_fill(0,3,0);  // to keep track of quantity of items in the cart
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Order | Hecha 4000</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="styles.css">
  <link rel="icon" href="assets/logos/logoedited.png">
  <?php 
    require "scripts/fillvalues.php"; 
    for ($i = 0; $i <= 2; $i++){
      $displaystockqty[$i] = $stockarray[$i] - $_SESSION['cartstockqty'][$i]; // to take into account the qty user has selected but has not checked out
    }
  
  ?>
  <script type="text/javascript" src="scripts/js.js"></script>
</head>

<body onload="inittotalDIY(<?php echo $pricearray[3] ?>,<?php echo $pricearray[12] ?>,<?php echo $pricearray[15] ?>)">
  <div id="wrapper">
    <header>
      <a href="index.php"><img src="assets/logos/logoedited.png" width="200px" height="200px" alt="hecha 4000 Logo"></a>
    </header>

    <nav>
      <ul><b>
          <li><a href="index.php">Home</a></li>
          <li><a href="aboutus.php">About Us</a></li>
          <li><a class="active" href="order.php">Order</a></li>
          <li><a href="status.php">Status</a></li>
          <li><a href="contactus.php">Contact Us</a></li>
          <li><a href="account.php">Account</a></li>
          <li class="right-nav"><a class="right-nav" href="cart.php">Cart</a></li>
        </b></ul>
    </nav>


    <div class="content">
      <div class="order-table">
        <h2>Hecha 4000 Signature Drinks</h2>
        <table border="0">
          <tr>
            <td>
              <div id="ClassicEarlGreyMT" class="rel-position"></div>
              <strong>Classic Earl Grey Milk Tea</strong>
            </td>
            <td><img src="assets/products/earlgrey.png" alt="Classic Earl Grey Milk Tea" width="150" height="225"></td>
            <td>
              <p class="order-table-description">
                With our unique "YiqiHe" brewing process, we are able to deliver up to
                60% richer flavour profiles
                compared to standard tea brewing techniques our competitors use. All this to deliver the best possible
                tea
                experience in a cup. The end result? A stunning, rich taste of earl grey complemented by the freshest
                milk
                from Hokkaido.</p><br>
              <form action="scripts/cartHandler.php" method="POST">
                <?php
                  if ($displaystockqty[0] <= 10 and $displaystockqty[0] != 0){
                    echo "<b style='color:red'>Selling Out!</b> $displaystockqty[0] cups left!<br>";
                  }
                  if ($displaystockqty[0] == 0){
                    echo "<b style='color:red'>Sold Out!</b><br>";
                  }
                  if ($displaystockqty[0] != 0){
                    echo "<label for='ClassicEarlGreyMTQty'><b>\$$pricearray[0]</b> Quantity </label>";
                    echo "<input type='number' name='SignatureQty' id='ClassicEarlGreyMTQty' style='width: 40px;' min='1' value='1' step='1' oninput='qtycheck(id, $displaystockqty[0])'>";
                    echo "<input type='hidden' name='productName' id='productName' value='ClassicEarlGreyMT'>";
                    echo " <input type='submit' value='Add' class='add-button-design'>";
                  }
                ?>
              </form>
            </td>
          </tr>

          <tr>
            <td>
              <div id="MarvelousMatcha" class="rel-position"></div>
              <strong>Marvelous Matcha</strong>
            </td>
            <td><img src="assets/products/matcha.png" alt="Matcha Milk Tea" width="150" height="225"></td>
            <td>
              <p class="order-table-description">
                Our most popular drink is back! Using state-of-the-art tea leaves, we
                were able to enhance our Matcha's
                flavour profile by over 80%.
                These new tea leaves are blended with 100% organic almond milk and agave to produce the best Matcha
                paste,
                ever.
                Marvelous Matcha now has the new brown sugar, for better taste.</p><br>
              <form action="scripts/cartHandler.php" method="POST">
              <?php
                  if ($displaystockqty[1] <= 10 and $displaystockqty[1] != 0){
                    echo "<b style='color:red'>Selling Out!</b> $displaystockqty[1] cups left!<br>";
                  }
                  if ($displaystockqty[1] == 0){
                    echo "<b style='color:red'>Sold Out!</b><br>";
                  }
                  if ($displaystockqty[1] != 0){
                    echo "<label for='MarvelousMatchaQty'><b>\$$pricearray[1]</b> Quantity </label>";
                    echo "<input type='number' name='SignatureQty' id='MarvelousMatchaQty' style='width: 40px;' min='1' value='1' step='1' oninput='qtycheck(id, $displaystockqty[1])'>";
                    echo "<input type='hidden' name='productName' id='productName' value='MarvelousMatcha'>";
                    echo " <input type='submit' value='Add' class='add-button-design'>";
                  }
                ?>
              </form>

            </td>
          </tr>
          <tr>
            <td>
              <div id="DingdongOolongFMT" class="rel-position"></div>
              <strong>Dingdong Oolong Fresh Milk Tea</strong>
            </td>
            <td><img src="assets/products/oolongpearls.png" alt="Oolong Milk Tea" width="150" height="225"></td>
            <td>
              <p class="order-table-description">
                Dingdong Oolong Fresh Milk Tea is the signature Bubble Tea from
                Hecha 4000.
                It has a sweet, aromatic and full-bodied flavour and stood up to the sweet taste of the fresh milk,
                creating
                a very fragrant and well-balanced bubble tea drink.
                Our tapioca pearls are made in Taiwan but freshly cooked in Singapore. Covered in a layer of caramel,
                they
                are soft, chewy, and sweet.
                The Dingdong is a great choice for everyone.</p><br>
              <form action="scripts/cartHandler.php" method="POST">
              <?php
                  if ($displaystockqty[2] <= 10 and $displaystockqty[2] != 0){
                    echo "<b style='color:red'>Selling Out!</b> $displaystockqty[2] cups left!<br>";
                  }
                  if ($displaystockqty[2] == 0){
                    echo "<b style='color:red'>Sold Out!</b><br>";
                  }
                  if ($displaystockqty[2] != 0){
                    echo "<label for='DingdongOolongFMTQty'><b>\$$pricearray[2]</b> Quantity </label>";
                    echo "<input type='number' name='SignatureQty' id='DingdongOolongFMTQty' style='width: 40px;' min='1' value='1' step='1' oninput='qtycheck(id, $displaystockqty[2])'>";
                    echo "<input type='hidden' name='productName' id='productName' value='DingdongOolongFMT'>";
                    echo " <input type='submit' value='Add' class='add-button-design'>";
                  }
                ?>
              </form>

            </td>
          </tr>
        </table><br><br>
        <div class="order-table">
          <h2>Hecha 4000 DIY Drink</h2>
          <div id="DIYdrink" class="rel-position"></div>
          <p>Customise your own drinks below! Select your desired type of tea, add-ons, sugar level and ice level. </p>
          <form action="scripts/cartHandler.php" method="POST">
            <table class="diy-table">
              <tr>
                <th>Type of Tea</th>
                <td>
                  <input type="radio" id="EarlGrey" name="teatype" value="3" checked onclick="calctotalDIY(<?php echo $pricearray[3] ?>, null, id)">
                  <label for="EarlGrey">Earl Grey ($<?php echo $pricearray[3] ?>)</label><br>
                  <input type="radio" id="Matcha" name="teatype" value="4" onclick="calctotalDIY(<?php echo $pricearray[4] ?>, null, id)">
                  <label for="Matcha">Matcha ($<?php echo $pricearray[4] ?>)</label><br>
                  <input type="radio" id="DingdongOolong" name="teatype" value="5" onclick="calctotalDIY(<?php echo $pricearray[5] ?>, null, id)">
                  <label for="DingdongOolong">Dingdong Oolong ($<?php echo $pricearray[5] ?>)</label>
                </td>
              </tr>
              <tr>
                <th>Add-ons</th>
                <td>
                  <input type="checkbox" id="Cream" name="addons[]" value="6" onclick="calctotalDIY(null, <?php echo $pricearray[6] ?>, id)">
                  <label for="Cream"> Cream (+$<?php echo $pricearray[6] ?>)</label><br>
                  <input type="checkbox" id="FreshMilk" name="addons[]" value="7" onclick="calctotalDIY(null, <?php echo $pricearray[7] ?>, id)">
                  <label for="FreshMilk"> Fresh Milk (+$<?php echo $pricearray[7] ?>)</label><br>

                  <input type="checkbox" id="MilkFoam" name="addons[]" value="8" onclick="calctotalDIY(null, <?php echo $pricearray[8] ?>, id)">
                  <label for="MilkFoam"> Milk Foam (+$<?php echo $pricearray[8] ?>)</label><br>
                  <input type="checkbox" id="Pearls" name="addons[]" value="9" onclick="calctotalDIY(null, <?php echo $pricearray[9] ?>, id)">
                  <label for="Pearls"> Pearls (+$<?php echo $pricearray[9] ?>)</label><br>

                  <input type="checkbox" id="CoconutJelly" name="addons[]" value="10" onclick="calctotalDIY(null, <?php echo $pricearray[10] ?>, id)">
                  <label for="CoconutJelly"> Coconut Jelly (+$<?php echo $pricearray[10] ?>)</label><br>
                  <input type="checkbox" id="GrassJelly" name="addons[]" value="11" onclick="calctotalDIY(null, <?php echo $pricearray[11] ?>, id)">
                  <label for="GrassJelly"> Grass Jelly (+$<?php echo $pricearray[11] ?>)</label><br>
                </td>
              </tr>
              <tr>
                <th>Sugar Level</th>
                <td>
                  <input type="radio" id="100percent" name="sugarlevel" value="12" checked onclick="calctotalDIY2(<?php echo $pricearray[12] ?>, name)">
                  <label for="100percent">100% (+$<?php echo $pricearray[12] ?>)</label><br>
                  <input type="radio" id="50percent" name="sugarlevel" value="13" onclick="calctotalDIY2(<?php echo $pricearray[13] ?>, name)">
                  <label for="50percent">50% (+$<?php echo $pricearray[13] ?>)</label><br>
                  <input type="radio" id="0percent" name="sugarlevel" value="14" onclick="calctotalDIY2(<?php echo $pricearray[14] ?>, name)">
                  <label for="0percent">0% (+$<?php echo $pricearray[14] ?>)</label>
                </td>
              </tr>
              <tr>
                <th>Ice Level</th>
                <td>
                  <input type="radio" id="regIce" name="icelevel" value="15" checked onclick="calctotalDIY2(<?php echo $pricearray[15] ?>, name)">
                  <label for="regIce">Regular Ice (+$<?php echo $pricearray[15] ?>)</label><br>
                  <input type="radio" id="lessIce" name="icelevel" value="16" onclick="calctotalDIY2(<?php echo $pricearray[16] ?>, name)">
                  <label for="lessIce">Less Ice (+$<?php echo $pricearray[16] ?>)</label><br>
                  <input type="radio" id="noIce" name="icelevel" value="17" onclick="calctotalDIY2(<?php echo $pricearray[17] ?>, name)">
                  <label for="noIce">No Ice (+$<?php echo $pricearray[17] ?>)</label>
                </td>
              </tr>
              <tr>
                <th colspan="2">
                  <div id="DIYdrinkPrice"></div>
                  <input type="hidden" name="productName" id="productName" value="DIYdrink">
                  <input type="submit" value="Add" class="add-button-design">
                </th>
              </tr>
            </table><br>
          </form>
        </div>
      </div>
      <button class="bar-design" onclick="window.location.href='cart.php'">View your cart<br>
        <?php
        if (count($_SESSION['cart']) == 1) {
          echo count($_SESSION['cart']) . ' item';
        } else {
          echo count($_SESSION['cart']) . ' items';
        }
        ?>
      </button>
    </div>
  </div>
  <footer>
    <small><i>Copyright &copy; 2020 Hecha 4000 Pte Ltd. All rights reserved.</i></small>
  </footer>
</body>

</html>