<?php
// connect to db
@$db = new mysqli('localhost', 'f37ee', 'f37ee', 'f37ee');

if (mysqli_connect_errno()) {
  echo 'Error: Could not connect to database.  Please try again later.';
  exit;
}
$status = '';
  $order = $_POST['order'];
  $email = $_POST['email'];

  $query = "SELECT * FROM customers WHERE custemail='$email'";
  $result = $db->query($query);
  $num_results = $result -> num_rows;

  if ($num_results > 0) {
    $query = "SELECT currentstatus FROM orders WHERE orderid='$order'";
    $result1 = $db->query($query);
    $num_results1 = $result1 -> num_rows;
    if ($num_results1 > 0) {
      $row = $result1->fetch_assoc();
      $status = "For order " . $order . ": " . $row['currentstatus'];
    } else {
      $status = "Order not found. Please try again!";
    }
  } else {
    $status = "Error. Check your fields again";
  }
  echo '<script language="javascript">';
  echo "alert(\"$status\")";
  echo '</script>';

  $db->close();
  header("Refresh:0; url=../status.php");
?>