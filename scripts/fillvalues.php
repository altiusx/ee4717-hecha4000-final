<?php
    @ $db = new mysqli('localhost', 'f37ee', 'f37ee', 'f37ee');
    
    if (mysqli_connect_errno()) {
        echo 'Error: Could not connect to database.  Please try again later.';
        exit;
    }
    
    $pricearray = array_fill(0,18,0); // create an array to store product prices; used for display
    $namearray = array_fill(0,18,0);  // create an array to store product names; used for display
    $stockarray = array_fill(0,3,0); // create an array to store stock quantities; used for display
    
    for ($i = 1; $i <= 18; $i++){
        $query = "SELECT * FROM pricelist WHERE itemid =" . $i;
        $result = $db->query($query);
        $row = $result->fetch_assoc();
        $pricearray[($i-1)] = $row["unitprice"];
        $namearray[($i-1)] = $row["item"];
    };

    for ($i = 1; $i <= 3; $i++) {
        $query = "SELECT stockqty FROM stocklist WHERE itemid =" . $i;
        $result = $db->query($query);
        $row = $result->fetch_assoc();
        $stockarray[($i-1)] = $row["stockqty"];
    }

    $result->free();

    $db->close();
?>