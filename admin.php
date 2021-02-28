<?php
session_start();
if ($_SESSION['valid_user'] != 1) {   // checks if admin is the one accessing the admin page
    echo '<script language="javascript">';
    echo 'alert("Admin Only! Redirecting you back to Homepage.")';
    echo '</script>';
    header("Refresh:0; url=index.php");
}

@$db = new mysqli('localhost', 'f37ee', 'f37ee', 'f37ee');

if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.  Please try again later.';
    exit;
}

// for order status update
if (isset($_POST['order']) and isset($_POST['status'])) {
    $order = $_POST['order'];
    $status = $_POST['status'];

    $query = "SELECT * FROM orders WHERE orderid='$order'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        $query = "UPDATE orders SET currentstatus = '$status' WHERE orderid='$order'";
        $result = $db->query($query);

        // email stuff
        $to      = 'f37ee@localhost';
        $subject = "Update on your Hecha 4000 Order (Order Number: $order)";
        $message = "Current status of your order (order number: $order) has changed to \"$status\".";

        $headers = 'From: f37ee@localhost' . "\r\n" .
            'Reply-To: f37ee@localhost' . "\r\n" .
            'X-Mailer: PHP/' . phpversion() . "\r\n";

        mail($to, $subject, $message, $headers, '-ff37ee@localhost');

        echo '<script language="javascript">';
        echo 'alert("Order Status updated!")';
        echo '</script>';
        header("Refresh:0; url=admin.php");
    } else {
        echo '<script language="javascript">';
        echo 'alert("No such order. Try again!")';
        echo '</script>';
        header("Refresh:0; url=admin.php");
    }
}

// for product price update
if (isset($_POST['item']) and isset($_POST['price'])) {
    $item = $_POST['item'];
    $price = $_POST['price'];

    $query = "UPDATE pricelist SET unitprice = '$price' WHERE itemid='$item'";
    $result = $db->query($query);

    echo '<script language="javascript">';
    echo 'alert("Price updated!")';
    echo '</script>';
    header("Refresh:0; url=admin.php");
}

// for stock qty update
if (isset($_POST['stockitem']) and isset($_POST['stockqty'])) {
    $stockitem = $_POST['stockitem'];
    $stockqty = $_POST['stockqty'];

    $query = "UPDATE stocklist SET stockqty = '$stockqty' WHERE itemid='$stockitem'";
    $result = $db->query($query);

    echo '<script language="javascript">';
    echo 'alert("Stock Quantity updated!")';
    echo '</script>';
    header("Refresh:0; url=admin.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Page | Hecha 4000</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="assets/logos/logoedited.png">
    <script type="text/javascript" src="scripts/js.js"></script>
</head>

<style>
    .order,
    .status,
    .price,
    .stockqty,
    .detailsnumber {
        width: 20%;
        border: 1px solid #ccc;
        margin-top: 6px;
        margin-bottom: 16px;
    }

    .reportdate{
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
        border-radius: 12px;
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
        border-radius: 12px;
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
                    <li><a href="status.php">Status</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                    <li><a href="account.php">Account</a></li>
                    <li class="right-nav"><a class="right-nav" href="cart.php">Cart</a></li>
                </b></ul>
        </nav>

        <div class="content">
            <h2 style="text-align: center;">Admin Page</h2>
            <div class="col-container-admin">
                <div class="col-left-admin">
                    <h2>Update Database</h2>
                    <h3>Update Order Status</h3>
                    <form action="admin.php" method="POST">
                        <label for="ordernumber">Order Number:</label>
                        <input type="number" name="order" class="order" id="ordernumber" required>
                        <br>
                        <label for="status">Update Order Status:</label>
                        <input type="text" name="status" class="status" id="status" required>
                        <br>
                        <input type="submit" value="Submit">
                        <input type="reset" value="Clear">
                    </form>
                    <br>
                    <h3>Update Product Price</h3>
                    <form action="admin.php" method="POST">
                        <label for="item">Product:</label>
                        <select name='item' id='item'>
                            <option value='' selected disabled>Option</option>
                            <option value='1'>Classic Earl Grey Milk Tea</option>
                            <option value='2'>Marvelous Matcha</option>
                            <option value='3'>Dingdong Oolong Fresh Milk Tea</option>
                            <option value='4'>Earl Grey</option>
                            <option value='5'>Matcha</option>
                            <option value='6'>Dingdong Oolong</option>
                            <option value='7'>Add Cream</option>
                            <option value='8'>Add Fresh Milk</option>
                            <option value='9'>Add Milk Foam</option>
                            <option value='10'>Add Pearls</option>
                            <option value='11'>Add Coconut Jelly</option>
                            <option value='12'>Add Grass Jelly</option>
                            <option value='13'>100% Sugar</option>
                            <option value='14'>50% Sugar</option>
                            <option value='15'>0% Sugar</option>
                            <option value='16'>Regular Ice</option>
                            <option value='17'>Less Ice</option>
                            <option value='18'>No Ice</option>
                        </select>
                        <br><br>
                        <label for="price">Update Price ($):</label>
                        <input type="number" name="price" class="price" id="price" step="0.01" min="0.00" required>
                        <br><br>
                        <input type="submit" value="Submit">
                        <input type="reset" value="Clear">
                    </form>
                    <br>
                    <h3>Update Stock Quantity</h3>
                    <form action="admin.php" method="POST">
                        <label for="stockitem">Product:</label>
                        <select name='stockitem' id='stockitem'>
                            <option value='' selected disabled>Option</option>
                            <option value='1'>Classic Earl Grey Milk Tea</option>
                            <option value='2'>Marvelous Matcha</option>
                            <option value='3'>Dingdong Oolong Fresh Milk Tea</option>
                        </select>
                        <br><br>
                        <label for="stockqty">Update Stock Quantity:</label>
                        <input type="number" name="stockqty" class="stockqty" id="stockqty" step="1" min="0" required>
                        <br><br>
                        <input type="submit" value="Submit">
                        <input type="reset" value="Clear">
                    </form>
                </div>

                <div class="col-right-admin">
                    <h2>Retrieve from Database</h2>
                    <h3>Retrieve Lists</h3>
                    <form action="admin.php" method="POST">
                        <select name='retrieve' id='retrieve'>
                            <option value='' selected disabled>Option</option>
                            <option value='productpricelist'>Product Price List</option>
                            <option value='stockqtylist'>Stock Quantity List</option>
                        </select>
                        <br><br>
                        <input type="submit" value="Submit">
                        <input type="reset" value="Clear">
                    </form>
                    <br>
                    <h3>Retrieve Order Details</h3>
                    <form action="admin.php" method="POST">
                        <label for="detailsnumber">Order Number:</label>
                        <input type="number" name="detailsnumber" class="detailsnumber" id="detailsnumber" step="1" min="1" required>
                        <br><br>
                        <input type="submit" value="Submit">
                        <input type="reset" value="Clear">
                    </form>
                    <br>
                    <h3>Retrieve Daily Sales Report</h3>
                    <form action="admin.php" method="POST">
                        <label for="reportdate">Date:</label>
                        <input type="date" name="reportdate" class="reportdate" id="reportdate" required>
                        <br><br>
                        <input type="submit" value="Submit">
                        <input type="reset" value="Clear">
                    </form>
                    <br>
                    <?php   // to handle form submits
                    if (isset($_POST['retrieve'])) {
                        $retrieve = $_POST['retrieve'];

                        if ($retrieve == 'productpricelist') {  // If Product Price List is selected

                            $query = "SELECT * FROM pricelist";
                            $result = $db->query($query);

                            echo "<table border='0'><tr><th>Item</th><th>Unit Price</th></tr>";

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['item'] . "</td>";
                                echo "<td style='text-align: center'>$" . $row['unitprice'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else if ($retrieve == 'stockqtylist') {   // If Stock Qty List is selected
                            $query = "SELECT pricelist.item, stocklist.stockqty FROM pricelist INNER JOIN stocklist ON pricelist.itemid = stocklist.itemid";
                            $result = $db->query($query);

                            echo "<table border='0'><tr><th>Item</th><th>Stock Quantity</th></tr>";

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['item'] . "</td>";
                                echo "<td style='text-align: center'>" . $row['stockqty'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                    }

                    if (isset($_POST['detailsnumber'])) {   // If want to retrieve order details 
                        $ordernum = $_POST['detailsnumber'];

                        $query = "SELECT * FROM orders WHERE orderid = '$ordernum'";
                        $result = $db->query($query);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $date = date_create($row['date']);

                            echo "Order number: $ordernum <br>";
                            echo "Date: " . date_format($date, "d/m/Y") . "<br>";
                            echo "Total amount: $" . $row['totalamount'] . "<br>";
                            echo "Current status: " . $row['currentstatus'] . "<br>";
                            echo "<table border='0'><tr><th>Item</th><th>Quantity</th></tr>";

                            $query = "SELECT CQty, MQty, DQty FROM signaturedrinks WHERE orderid = '$ordernum'";
                            $result = $db->query($query);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                if ($row['CQty'] > 0) {
                                    echo "<tr>";
                                    echo "<td>Classic Earl Grey Milk Tea</td>";
                                    echo "<td style='text-align: center'>" . $row['CQty'] . "</td>";
                                    echo "</tr>";
                                }
                                if ($row['MQty'] > 0) {
                                    echo "<tr>";
                                    echo "<td>Marvelous Matcha</td>";
                                    echo "<td style='text-align: center'>" . $row['MQty'] . "</td>";
                                    echo "</tr>";
                                }
                                if ($row['DQty'] > 0) {
                                    echo "<tr>";
                                    echo "<td>Dingdong Oolong Fresh Milk Tea</td>";
                                    echo "<td style='text-align: center'>" . $row['DQty'] . "</td>";
                                    echo "</tr>";
                                }
                            }

                            $query = "SELECT teatype, addCream, addFreshmilk, addMilkfoam, addPearls, addCoconutjelly, addGrassjelly, sugarlevel, icelevel FROM DIYdrinks WHERE orderid = '$ordernum'";
                            $result = $db->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $tempaddons = '';
                                    foreach ($row as $key => $value) {
                                        if ($value == 1) {
                                            $tempaddons .= "$key<br>";
                                        }
                                    }
                                    $tempDIY = "<br>" . $row['teatype'] . "<br>" . $tempaddons . $row['sugarlevel'] . "<br>" . $row['icelevel'] . "<br>";
                                    echo "<tr>";
                                    echo "<td>" . $tempDIY . "</td>";
                                    echo "<td style='text-align: center'>1</td>";
                                    echo "</tr>";
                                }
                            }
                            echo "</table>";
                        } else {
                            echo 'No records found.';
                        }
                    }

                    if (isset($_POST['reportdate'])){    // if want to get daily sales report
                        $reportdate = $_POST['reportdate']; // date queried
                        $reporttotalsales = 0;
                        $reporttotalqty = 0;
                        $reportsalesSgn = array(0,0,0,0);
                        $reportqtySgn = array(0,0,0,0);
                        $reportsalesDIY = 0;
                        $reportqtyDIY = array_fill(0,16,0);
                        

                        $query = "SELECT date,sum(totalamount) FROM orders WHERE date = '$reportdate'";
                        $result = $db->query($query);
                        $row = $result->fetch_assoc();
                        if ($row['date'] == NULL){
                            echo 'No records found.';
                        }
                        else {
                            $reporttotalsales = $row['sum(totalamount)'];
                            $query = "SELECT sum(signaturedrinks.CQty),sum(signaturedrinks.MQty),sum(signaturedrinks.DQty),sum(signaturedrinks.CSubtotal),sum(signaturedrinks.MSubtotal),sum(signaturedrinks.DSubtotal) FROM orders INNER JOIN signaturedrinks ON orders.orderid = signaturedrinks.orderid WHERE orders.date = '$reportdate'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();

                            $reportsalesSgn[0] = $row['sum(signaturedrinks.CSubtotal)'] + $row['sum(signaturedrinks.MSubtotal)'] + $row['sum(signaturedrinks.DSubtotal)'];
                            $reportsalesSgn[0] = number_format($reportsalesSgn[0],2,'.','');
                            $reportsalesSgn[1] = $row['sum(signaturedrinks.CSubtotal)'];
                            $reportsalesSgn[2] = $row['sum(signaturedrinks.MSubtotal)'];
                            $reportsalesSgn[3] = $row['sum(signaturedrinks.DSubtotal)'];

                            $reportqtySgn[0] = $row['sum(signaturedrinks.CQty)'] + $row['sum(signaturedrinks.MQty)'] + $row['sum(signaturedrinks.DQty)'];
                            $reportqtySgn[1] = $row['sum(signaturedrinks.CQty)'];
                            $reportqtySgn[2] = $row['sum(signaturedrinks.MQty)'];
                            $reportqtySgn[3] = $row['sum(signaturedrinks.DQty)'];

                            $query = "SELECT sum(DIYdrinks.DIYprice),sum(DIYdrinks.addCream),sum(DIYdrinks.addFreshmilk),sum(DIYdrinks.addMilkfoam),sum(DIYdrinks.addPearls),sum(DIYdrinks.addCoconutjelly),sum(DIYdrinks.addGrassjelly) FROM orders INNER JOIN DIYdrinks ON orders.orderid = DIYdrinks.orderid WHERE orders.date = '$reportdate'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();

                            $reportsalesDIY = $row['sum(DIYdrinks.DIYprice)'];
                            $reportsalesDIY = number_format($reportsalesDIY,2,'.','');
                            $reportqtyDIY[3] = $row['sum(DIYdrinks.addCream)'];
                            $reportqtyDIY[4] = $row['sum(DIYdrinks.addFreshmilk)'];
                            $reportqtyDIY[5] = $row['sum(DIYdrinks.addMilkfoam)'];
                            $reportqtyDIY[6] = $row['sum(DIYdrinks.addPearls)'];
                            $reportqtyDIY[7] = $row['sum(DIYdrinks.addCoconutjelly)'];
                            $reportqtyDIY[8] = $row['sum(DIYdrinks.addGrassjelly)'];

                            $query = "SELECT count(DIYdrinks.teatype) FROM orders INNER JOIN DIYdrinks ON orders.orderid = DIYdrinks.orderid WHERE orders.date = '$reportdate' AND DIYdrinks.teatype = 'Earl Grey'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();
                            $reportqtyDIY[0] = $row['count(DIYdrinks.teatype)'];

                            $query = "SELECT count(DIYdrinks.teatype) FROM orders INNER JOIN DIYdrinks ON orders.orderid = DIYdrinks.orderid WHERE orders.date = '$reportdate' AND DIYdrinks.teatype = 'Matcha'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();
                            $reportqtyDIY[1] = $row['count(DIYdrinks.teatype)'];

                            $query = "SELECT count(DIYdrinks.teatype) FROM orders INNER JOIN DIYdrinks ON orders.orderid = DIYdrinks.orderid WHERE orders.date = '$reportdate' AND DIYdrinks.teatype = 'Dingdong Oolong'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();
                            $reportqtyDIY[2] = $row['count(DIYdrinks.teatype)'];

                            $query = "SELECT count(DIYdrinks.sugarlevel) FROM orders INNER JOIN DIYdrinks ON orders.orderid = DIYdrinks.orderid WHERE orders.date = '$reportdate' AND DIYdrinks.sugarlevel = '100% Sugar'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();
                            $reportqtyDIY[9] = $row['count(DIYdrinks.sugarlevel)'];

                            $query = "SELECT count(DIYdrinks.sugarlevel) FROM orders INNER JOIN DIYdrinks ON orders.orderid = DIYdrinks.orderid WHERE orders.date = '$reportdate' AND DIYdrinks.sugarlevel = '50% Sugar'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();
                            $reportqtyDIY[10] = $row['count(DIYdrinks.sugarlevel)'];

                            $query = "SELECT count(DIYdrinks.sugarlevel) FROM orders INNER JOIN DIYdrinks ON orders.orderid = DIYdrinks.orderid WHERE orders.date = '$reportdate' AND DIYdrinks.sugarlevel = '0% Sugar'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();
                            $reportqtyDIY[11] = $row['count(DIYdrinks.sugarlevel)'];

                            $query = "SELECT count(DIYdrinks.icelevel) FROM orders INNER JOIN DIYdrinks ON orders.orderid = DIYdrinks.orderid WHERE orders.date = '$reportdate' AND DIYdrinks.icelevel = 'Regular Ice'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();
                            $reportqtyDIY[12] = $row['count(DIYdrinks.icelevel)'];

                            $query = "SELECT count(DIYdrinks.icelevel) FROM orders INNER JOIN DIYdrinks ON orders.orderid = DIYdrinks.orderid WHERE orders.date = '$reportdate' AND DIYdrinks.icelevel = 'Less Ice'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();
                            $reportqtyDIY[13] = $row['count(DIYdrinks.icelevel)'];

                            $query = "SELECT count(DIYdrinks.icelevel) FROM orders INNER JOIN DIYdrinks ON orders.orderid = DIYdrinks.orderid WHERE orders.date = '$reportdate' AND DIYdrinks.icelevel = 'No Ice'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();
                            $reportqtyDIY[14] = $row['count(DIYdrinks.icelevel)'];
                            
                            $query = "SELECT count(*) FROM orders INNER JOIN DIYdrinks ON orders.orderid = DIYdrinks.orderid WHERE orders.date = '$reportdate'";
                            $result = $db->query($query);
                            $row = $result->fetch_assoc();
                            $reportqtyDIY[15] = $row['count(*)'];
                            $reporttotalqty = $reportqtySgn[0] + $reportqtyDIY[15];

                            echo "Date: $reportdate <br>";
                            echo "Total Sales: \$$reporttotalsales<br>";
                            echo "Total Quantity: $reporttotalqty <br><br>";
                            echo "<b>Signature Drinks Breakdown</b><br>";
                            echo "Total Signature Drinks Sales:  \$$reportsalesSgn[0]<br>";
                            echo "Classic Earl Grey Milk Tea Sales: \$$reportsalesSgn[1]<br>";
                            echo "Marvelous Matcha Sales: \$$reportsalesSgn[2]<br>";
                            echo "Dingdong Oolong Fresh Milk Tea Sales: \$$reportsalesSgn[3]<br>";
                            echo "<br>Total Signature Drinks Qty: $reportqtySgn[0]<br>";
                            echo "Classic Earl Grey Milk Tea Qty: $reportqtySgn[1]<br>";
                            echo "Marvelous Matcha Qty: $reportqtySgn[2]<br>";
                            echo "Dingdong Oolong Fresh Milk Tea Qty: $reportqtySgn[3]<br>";

                            echo "<br><b>DIY Drinks Breakdown</b><br>";
                            echo "Total DIY Drinks Sales: \$$reportsalesDIY<br>";
                            echo "Total DIY Drinks Qty: $reportqtyDIY[15]<br>";

                            echo "<br>DIY Item Selection Frequency<br>";
                            echo "Earl Grey: $reportqtyDIY[0]<br>";
                            echo "Matcha: $reportqtyDIY[1]<br>";
                            echo "Dingdong Oolong: $reportqtyDIY[2]<br>";

                            echo "<br>addCream: $reportqtyDIY[3]<br>";
                            echo "addFreshmilk: $reportqtyDIY[4]<br>";
                            echo "addMilkfoam: $reportqtyDIY[5]<br>";
                            echo "addPearls: $reportqtyDIY[6]<br>";
                            echo "addCoconutjelly: $reportqtyDIY[7]<br>";
                            echo "addGrassjelly: $reportqtyDIY[8]<br>";
                            
                            echo "<br>100% sugar: $reportqtyDIY[9]<br>";
                            echo "50% sugar: $reportqtyDIY[10]<br>";
                            echo "0% sugar: $reportqtyDIY[11]<br>";

                            echo "<br>Regular Ice: $reportqtyDIY[12]<br>";
                            echo "Less Ice: $reportqtyDIY[13]<br>";
                            echo "No Ice: $reportqtyDIY[14]<br>";
                        }
                        
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <small><i>Copyright &copy; 2020 Hecha 4000 Pte Ltd. All rights reserved.</i></small>
    </footer>
</body>

</html>