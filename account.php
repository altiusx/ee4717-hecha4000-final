<?php
@$dbcnx = new mysqli('localhost', 'f37ee', 'f37ee', 'f37ee');

if ($dbcnx->connect_error) {
    echo "Database is not online";
    exit;
}
if (!$dbcnx->select_db("f37ee")) {
    exit("<p>Unable to locate the f37ee database</p>");
}
session_start();

if (isset($_POST['loginEmail']) and isset($_POST['loginPassword'])) { // if the user has just tried to log in
    $loginEmail = $_POST['loginEmail'];
    $loginPassword = $_POST['loginPassword'];

    $loginPassword = md5($loginPassword);
    $query = 'SELECT * from customers ' . "where custemail='$loginEmail' " . " and custpw='$loginPassword'";
    $result = $dbcnx->query($query);
    $row = $result->fetch_assoc();
    if ($result->num_rows > 0) { // if they are in the database register their id and name
        $_SESSION['valid_user'] = $row["custid"];
        $_SESSION['valid_user_name'] = $row["custname"];
    }
    $dbcnx->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Account | Hecha 4000</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="assets/logos/logoedited.png">
    <script type="text/javascript" src="scripts/js.js"></script>
</head>

<style>
    form {
        padding: 0px 40px;
    }

    .status {
        text-align: center;
    }

    .signout {
        background-color: #A9A9A9;
        color: white;
        font-weight: bold;
        padding: 12px 50px;
        width: 100%;
        border: none;
        cursor: pointer;
        border-radius: 12px;
        font-size: 16px;
    }

    .signout:hover {
        background-color: #808080;
    }

    input[type=text],
    input[type=password] {
        width: 95%;
        padding: 12px;
        border: 1px solid #ccc;
        margin-top: 6px;
        margin-bottom: 16px;
    }

    .order,
    .login {
        background-color: #72a2a2;
        color: white;
        font-weight: bold;
        padding: 12px 50px;
        width: 100%;
        border: none;
        cursor: pointer;
        border-radius: 12px;
        font-size: 16px;
    }

    .order:hover,
    .login:hover {
        background-color: #55746f;
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
                    <li><a class="active" href="account.php">Account</a></li>
                    <li class="right-nav"><a class="right-nav" href="cart.php">Cart</a></li>
                </b></ul>
        </nav>

        <div class="content">
            <div class="col-container">
                <div class="col-left">
                    <div style="text-align: center;">
                        <h2>Welcome back to Hecha 4000</h2>
                    </div>

                    <?php // login page
                    if (isset($_SESSION['valid_user'])) { // if user is already logged in
                        echo '<p class="status">You are logged in as: ' . $_SESSION['valid_user_name'] . ' </p>';
                        if ($_SESSION['valid_user'] == 1){
                            echo '<p class="status"><a href="admin.php">Access Admin Page</a></p><br>';
                        }
                        echo '<form action="order.php"><input type="submit" class="order" value="Make An Order"></form><br>';
                        echo '<form action="scripts/signout.php"><input type="submit" class="signout" value="Sign Out"></form>'; // for user to sign out
                    } else {
                        if (isset($loginEmail)) { // if user tried to login but wrong email and/or password
                            echo '<p class="status">Could not log you in. Please try again!</p><br>';
                        } else { // displayed after user accesses the login page for the first time or logs out
                            echo '<p class="status">Please log in to your acccount.</p><br>';
                        }

                        // login form
                        echo '<form method="post" action="account.php">';
                        echo '<label for="email">Email Address</label>';
                        echo '<input type="text" id="email" name="loginEmail" placeholder="Enter your email address" required onchange="emailCheck(id)">';
                        echo '<label for="password">Password</label>';
                        echo '<input type="password" name="loginPassword" placeholder="Enter your password" required><br><br>';
                        echo '<input type="submit" class="login" value="Log in">';
                        echo '</form>';
                        echo '<p class="status">Don\'t have an account? <a href="accountsignup.php">Sign up here</a></p>';
                    }
                    ?>
                </div>
                <div class="col-right">
                    <h3>Try out our signature drinks!</h3>

                    <div class="signature-drinks-overlay">
                        <img src="assets/products/earlgrey.png" alt="Earl Grey Milk Tea" width="200" height="300">
                        <div class="overlay-text"><b><a href="order.php#ClassicEarlGreyMT">Classic Earl Grey Milk Tea</a></b></div>
                    </div>

                    <div class="signature-drinks-overlay">
                        <img src="assets/products/matcha.png" alt="Matcha Milk Tea" width="200" height="300">
                        <div class="overlay-text"><b><a href="order.php#MarvelousMatcha">Marvelous Matcha</a></b></div>
                    </div>

                    <div class="signature-drinks-overlay">
                        <img src="assets/products/oolongpearls.png" alt="Matcha Milk Tea" width="200" height="300">
                        <div class="overlay-text"><b><a href="order.php#DingdongOolongFMT">Dingdong Oolong Fresh Milk Tea</a></b></div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <small><i>Copyright &copy; 2020 Hecha 4000 Pte Ltd. All rights reserved.</i></small>
        </footer>
</body>

</html>
