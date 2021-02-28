<?php
    require "fillvalues.php";

    @ $db = new mysqli('localhost', 'f37ee', 'f37ee', 'f37ee');
    
    if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.  Please try again later.';
    exit;
    }
    
    session_start();
    $checkoutItemsArr = array_count_values($_SESSION['cart']); // put checkout items into an array (of item => qty)
    //print_r($checkoutItemsArr);
    $customerID = $_SESSION['valid_user'];
    $total = $_SESSION['total'];
    $date = date("Y-m-d"); // current date

    // create order in db
    $query = "INSERT INTO orders (custid, totalamount, date, currentstatus) VALUES ('$customerID', '$total', '$date', 'Order in progress')"; 
    $db->query($query);

    // retrieve orderid 
    $query = "SELECT orderid FROM orders WHERE custid='$customerID' AND currentstatus='Order in progress'";
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    $orderid = $row['orderid']; 
    $_SESSION['orderid'] = $orderid;

    // fill the other tables in db
    // $namearray and $pricearray are generated from the fillvalues.php script
    $DIYmsgstring = array();
    $SignatureQty = array(0,0,0); // qty for ClassicEarlGreyMT, MarvelousMatcha and DingdongOolongFMT respectively
    $SignatureSubtotal = array(number_format(0,2,'.',''),number_format(0,2,'.',''),number_format(0,2,'.','')); // subtotal for ClassicEarlGreyMT, MarvelousMatcha and DingdongOolongFMT respectively
    foreach ($checkoutItemsArr as $key => $qtyvalue) {  // iterate through each product and qty in checkout cart
        if ($key == "ClassicEarlGreyMT") {
            $SignatureQty[0] = $qtyvalue;
            $SignatureSubtotal[0] = number_format(($qtyvalue * $pricearray[0]), 2, '.', '');
        } else if ($key == "MarvelousMatcha") {
            $SignatureQty[1] = $qtyvalue;
            $SignatureSubtotal[1] = number_format(($qtyvalue * $pricearray[1]), 2, '.', '');
        } else if ($key == "DingdongOolongFMT") {
            $SignatureQty[2] = $qtyvalue;
            $SignatureSubtotal[2] = number_format(($qtyvalue * $pricearray[2]), 2, '.', '');
        } else {  // if it's not the signature drinks (ie DIY drinks)
          $DIYarr = explode("+", $key); // the individual components (teatype, addons, sugar level, ice level) for the DIY drink are put into an array (split via "+")
          array_shift($DIYarr); // array_shift removes index 0 (ie "DIYdrink")
          $subtotal = 0.00;
          $teatype = NULL;      
          $addonsArr = array_fill(0,6,0);
          $sugarlevel = NULL;
          $icelevel = NULL;

          foreach ($DIYarr as $componentvalue) { // iterate through each component value of the DIY order
            $subtotal += $pricearray[$componentvalue]; 
            if (($componentvalue>=3) && ($componentvalue<=5)){
                $teatype = $namearray[$componentvalue];
            } else if (($componentvalue>=6) && ($componentvalue<=11)){
                $addonsArr[($componentvalue-6)] = 1; 
            } else if (($componentvalue>=12) && ($componentvalue<=14)){
                $sugarlevel = $namearray[$componentvalue];
            } else if (($componentvalue>=15) && ($componentvalue<=17)){
                $icelevel = $namearray[$componentvalue];
            }
          }

          $DIYsubtotal = number_format($subtotal, 2, '.', '');
          for ($i=1;$i<=$qtyvalue;$i++){  // insert into DIYdrinks table
              $query = "INSERT INTO DIYdrinks (orderid, teatype, addCream, addFreshmilk, addMilkfoam, addPearls, addCoconutjelly, addGrassjelly, sugarlevel, icelevel, DIYprice) VALUES ('$orderid', '$teatype', '$addonsArr[0]', '$addonsArr[1]', '$addonsArr[2]', '$addonsArr[3]', '$addonsArr[4]', '$addonsArr[5]', '$sugarlevel', '$icelevel', '$DIYsubtotal')";
              $db->query($query);
              // email message for DIY drink orders
              $tempstr = "$teatype\n";
              if ($addonsArr[0] == 1){
                $tempstr .= "$namearray[6]\n";
              }
              if ($addonsArr[1] == 1){
                $tempstr .= "$namearray[7]\n";
              }
              if ($addonsArr[2] == 1){
                $tempstr .= "$namearray[8]\n";
              }
              if ($addonsArr[3] == 1){
                $tempstr .= "$namearray[9]\n";
              }
              if ($addonsArr[4] == 1){
                $tempstr .= "$namearray[10]\n";
              }
              if ($addonsArr[5] == 1){
                $tempstr .= "$namearray[11]\n";
              }
              $tempstr .= "$sugarlevel\n";
              $tempstr .= "$icelevel\n";
              $tempstr .= "Subtotal: \$$DIYsubtotal\n\n";
              array_push($DIYmsgstring, $tempstr);
            }
        }
    }

    if (!($SignatureQty[0] == 0 and $SignatureQty[1] == 0 and $SignatureQty[2] == 0)){ // insert into signaturedrinks table (except when all 3 qtys are 0)
    $query = "INSERT INTO signaturedrinks (orderid, CQty, MQty, DQty, CSubtotal, MSubtotal, DSubtotal) VALUES ('$orderid', '$SignatureQty[0]', '$SignatureQty[1]', '$SignatureQty[2]', '$SignatureSubtotal[0]', '$SignatureSubtotal[1]', '$SignatureSubtotal[2]')";
    $db->query($query);
    }

    for ($i = 0; $i <= 2; $i++){ // update stock list for signature drinks
    $query = "UPDATE stocklist SET stockqty = stockqty - '$SignatureQty[$i]' WHERE stockid = $i+1";
    $db->query($query);
    }

    $query = "UPDATE orders SET currentstatus='Order placed' WHERE orderid=$orderid";
    $db->query($query);

    //generate email message
    $temp = "Your order (order number: $orderid) is as follows: \n";

    // handle Signature drinks
    foreach ($SignatureQty as $index => $value){
        if ($value > 0){
            $temp .= "$namearray[$index] "; 
            $temp .= "Qty: $SignatureQty[$index] ";
            $temp .= "Subtotal: \$$SignatureSubtotal[$index]\n\n";
        }
    }

    foreach ($DIYmsgstring as $value){
        $temp .= $value;
    }

    $temp .= "Grand total: \$$total";

    // email stuff
    $to      = 'f37ee@localhost';
    $subject = "Your Hecha 4000 Order Details for Order Number: $orderid";
    $message = $temp;

    $headers = 'From: f37ee@localhost' . "\r\n" .
    'Reply-To: f37ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion() . "\r\n";

    mail($to, $subject, $message, $headers,'-ff37ee@localhost');
    //echo ("mail sent to : ".$to);

    $db->close();
    unset($_SESSION['cart']);
    unset($_SESSION['total']);
    unset($_SESSION['cartstockqty']);
    $_SESSION['orderoutcomedisplay'] = 0;   // users can only access orderoutcome page if this variable is 0 
    header("Location: ../orderoutcome.php");
?>