<?php
  session_start();
  
  $old_user = $_SESSION['valid_user'];   // test if user is logged in
  unset($_SESSION['valid_user']);
  unset($_SESSION['valid_user_name']);
  session_destroy();

  if (!empty($old_user))
  {
    echo '<script language="javascript">';
    echo 'alert("Signed out. Redirecting you back to login page")';
    echo '</script>';
    header("Refresh:0; url=../account.php"); 
  }
  else
  {
    echo '<script language="javascript">';
    echo 'alert("You were not signed in. Redirecting you back to login page")';
    echo '</script>';
    header("Refresh:0; url=../account.php"); 
  }
?>