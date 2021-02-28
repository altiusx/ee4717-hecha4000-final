<!DOCTYPE html>
<html lang="en">

<head>
  <title>Contact Us | Hecha 4000</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="styles.css" type="text/css" media="all">
  <link rel="icon" href="assets/logos/logoedited.png">
  <script type="text/javascript" src="scripts/js.js"></script>
</head>

<style>
  form {
    padding: 20px 40px;
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

  .email,
  .name {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    margin-top: 6px;
    margin-bottom: 16px;
  }

  .feedback {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    margin-top: 6px;
    margin-bottom: 16px;
    resize: none;
    font-family: Helvetica, Arial, sans-serif;
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
          <li><a class="active" href="contactus.php">Contact Us</a></li>
          <li><a href="account.php">Account</a></li>
          <li class="right-nav"><a class="right-nav" href="cart.php">Cart</a></li>
        </b></ul>
    </nav>

    <div class="content">
      <div class="col-container">
        <div class="col-left">
          <div style="text-align: center;">
            <h2>Contact Us</h2>
            <p>
              Got any feedback for us? Leave us your message below.
            </p>
          </div>
          <div class="row">
            <div class="column">
              <form action="scripts/feedback_submit.php" method="POST" onsubmit="feedbackSubmitted()">
                <label for="feedbackName">Name</label>
                <input type="text" class="name" name="feedbackName" id="feedbackName" placeholder="Edward Cullen" required onchange="nameCheck(id)">
                <label for="feedbackEmail">Email Address</label>
                <input type="email" class="email" name="feedbackEmail" id="feedbackEmail" placeholder="example@domain.com" required onchange="emailCheck(id)">
                <label for="feedbackMessage">Feedback</label>
                <textarea name="feedbackMessage" class="feedback" id="feedbackMessage" rows="7" cols="30" placeholder="Write something here" required></textarea>
                <input type="submit" value="Submit">
                <input type="reset" value="Clear">
              </form>
            </div>
          </div>
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
  </div>
  <footer>
    <small><i>Copyright &copy; 2020 Hecha 4000 Pte Ltd. All rights reserved.</i></small>
  </footer>
</body>

</html>
