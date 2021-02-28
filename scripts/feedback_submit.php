<?php
  // create short variable names for feedback input
  $feedbackName = $_POST['feedbackName'];
  $feedbackEmail = $_POST['feedbackEmail'];
  $feedbackMessage = $_POST['feedbackMessage'];

  // connect to db
  @$db = new mysqli('localhost', 'f37ee', 'f37ee', 'f37ee');

  if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.  Please try again later.';
    exit;
  }
  $query = "INSERT INTO feedback (feedbackName, feedbackEmail, feedbackMessage) VALUES ('$feedbackName', '$feedbackEmail', '$feedbackMessage')";
  $db->query($query);
  $db->close();
  
  header("Location: ../contactus.php");
?>