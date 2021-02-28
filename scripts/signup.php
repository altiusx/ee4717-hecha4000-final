<?php
@$dbcnx = new mysqli('localhost','f37ee','f37ee','f37ee');

if ($dbcnx->connect_error){
	echo "Database is not online"; 
	exit;
}
if (!$dbcnx->select_db ("f37ee")){
    exit("<p>Unable to locate the f37ee database</p>");
}
    
// short variable names
$signupName = $_POST['signupName'];
$signupEmail = $_POST['signupEmail'];
$signupPassword = $_POST['signupPassword'];
$signupAddress = $_POST['signupAddress'];
$signupCardNo = $_POST['signupCardNo'];
$signupCardExpiryMM = $_POST['signupCardExpiryMM'];
$signupCardExpiryYY = $_POST['signupCardExpiryYY'];
$signupCVV = $_POST['signupCVV'];

$signupPassword = md5($signupPassword);

$sql = "SELECT * FROM customers WHERE custemail = '$signupEmail'";  // check if email already exists
$result = $dbcnx->query($sql);
$num_results = $result -> num_rows;

if ($num_results > 0){
    echo '<script language="javascript">';
    echo "alert('User already exists. Try again!')";
    echo '</script>';

    $dbcnx->close();
    header("Refresh:0; url=../accountsignup.php");
}

$sql = "INSERT INTO customers (custname, custemail, custpw, custaddress, custcardno, custcardexpiryMM, custcardexpiryYY, custCVV) VALUES ('$signupName', '$signupEmail', '$signupPassword', '$signupAddress', '$signupCardNo', '$signupCardExpiryMM','$signupCardExpiryYY', '$signupCVV')";
$result = $dbcnx->query($sql);

if (!$result) {
    echo "Your query failed.";
}
else {
    $str = "Welcome ". $signupName . ". You are now registered.\\nDirecting to login page.";
    echo '<script language="javascript">';
    echo "alert(\"$str\")";
    echo '</script>';
    $dbcnx->close();
    header("Refresh:0; url=../account.php");
}
    
?>