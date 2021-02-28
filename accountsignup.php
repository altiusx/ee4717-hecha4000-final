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
        clear: left;
    }

    .name,
    .email,
    .password,
    .address,
    .cardnumber {
        width: 95%;
        padding: 12px;
        border: 1px solid #ccc;
        margin-top: 6px;
        margin-bottom: 16px;
    }

    .signupCardExpiry {
        float: left;
        padding-right: 50px;
    }
    .signupCardExpiryMM, .signupCardExpiryYY, .signupCVV {
        border: 1px solid #ccc;
        padding: 12px;
    }

    input[type=submit] {
        background-color: #72a2a2;
        color: white;
        font-weight: bold;
        padding: 12px 50px;
        width: 100%;
        border: none;
        cursor: pointer;
        border-radius: 12px;
        clear: left;
        font-size: 16px;
    }

    input[type=submit]:hover {
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

        <?php
        ?>
        <div class="content">
            <div class="col-container">
                <div class="col-left">
                    <div style="text-align:center;">
                        <h2>Sign Up for Hecha 4000</h2>
                        <p>All fields are required.</p>
                    </div>
                    <form action="scripts/signup.php" method="POST">
                        <label for="signupName">Name</label>
                        <input type="text" class="name" name="signupName" id="name" placeholder="Edward Cullen" required onchange="nameCheck(id)"><br>
                        <label for="signupEmail">Email Address</label>
                        <input type="email" class="email" name="signupEmail" id="email" placeholder="example@domain.com" required onchange="emailCheck(id)"><br>
                        <label for="signupPassword">Password</label>
                        <input type="password" class="password" name="signupPassword" id="signupPassword" placeholder="Enter a password (at least 8 characters)" pattern=".{8,}" title="Please ensure your password has at least 8 characters" required><br>
                        <label for="signupAddress">Address</label>
                        <input type="text" class="address" name="signupAddress" id="signupAddress" placeholder="50 Nanyang Ave, 639798" required><br>
                        <label for="signupCardNo">Card Number</label>
                        <input type="tel" class="cardnumber" name="signupCardNo" id="signupCardNo" pattern="[0-9]{4}\s[0-9]{4}\s[0-9]{4}\s[0-9]{4}" maxlength="19" placeholder="XXXX XXXX XXXX XXXX" title="Please enter your 16-digit card number in the following format: groups of 4 digits with a space between them (e.g. 1111 2222 3333 4444)" required onchange="cardnumCheck(id)"><br>
                        <div class="signupCardExpiry">
                            <label for="signupCardExpiry">Expiry</label><br>
                            <select name='signupCardExpiryMM' id='signupCardExpiryMM' class='signupCardExpiryMM'>
                                <option value='' selected disabled>Month</option>
                                <option value='01'>01</option>
                                <option value='02'>02</option>
                                <option value='03'>03</option>
                                <option value='04'>04</option>
                                <option value='05'>05</option>
                                <option value='06'>06</option>
                                <option value='07'>07</option>
                                <option value='08'>08</option>
                                <option value='09'>09</option>
                                <option value='10'>10</option>
                                <option value='11'>11</option>
                                <option value='12'>12</option>
                            </select>
                            <select name='signupCardExpiryYY' id='signupCardExpiryYY' class='signupCardExpiryYY'>
                                <option value='' selected disabled>Year</option>
                                <option value='20'>20</option>
                                <option value='21'>21</option>
                                <option value='22'>22</option>
                                <option value='23'>23</option>
                                <option value='24'>24</option>
                                <option value='25'>25</option>
                            </select>
                        </div>
                        <label for="signupCVV">CVV/CVC</label><br>
                        <input type="text" class="signupCVV" name="signupCVV" id="signupCVV" placeholder="123" required onchange="CVVCheck(id)" maxlength="3" size="4"><br><br>
                        <input type="submit" value="Submit">
                        <!--<input type="reset" value="Clear">-->
                    </form>
                    <p class="status">Already have an account? <a href="account.php">Log in here</a></p>
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
