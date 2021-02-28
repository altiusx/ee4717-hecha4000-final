<?php 
    session_start();
   
    // create short variable names
    $productName = $_POST['productName'];

    $teatype = $_POST['teatype'];
    $addons = $_POST['addons'];
    $sugarlevel = $_POST['sugarlevel'];
    $icelevel = $_POST['icelevel'];
    
    $SignatureQty = $_POST['SignatureQty'];

     
    if ($productName == 'DIYdrink') { 
        $addonsString = '';
        foreach ($addons as $values){
            $addonsString .= "$values+";
        }
        array_push($_SESSION['cart'], $productName .'+'.  $teatype .'+'. $addonsString . $sugarlevel .'+'. $icelevel);
    }

    else if ($productName == 'ClassicEarlGreyMT' or $productName == 'MarvelousMatcha' or $productName ==  'DingdongOolongFMT') {
        for ($i=1;$i<=$SignatureQty;$i++){
        array_push($_SESSION['cart'], $productName);
        }
    } 

    // to handle Signature Drinks stock (after adding some Signature Drinks)
    $cartArr = array_count_values($_SESSION['cart']);
    foreach ($cartArr as $key => $qtyvalue){
        if ($key == "ClassicEarlGreyMT"){
            $_SESSION['cartstockqty'][0] = $qtyvalue;
        }
        if ($key == "MarvelousMatcha"){
            $_SESSION['cartstockqty'][1] = $qtyvalue;
        }
        if ($key == "DingdongOolongFMT"){
            $_SESSION['cartstockqty'][2] = $qtyvalue;
        }
    }
    
    header("Location: ../order.php#" . $productName);

?>
