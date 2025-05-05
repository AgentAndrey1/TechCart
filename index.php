<?php
session_start();

// If the user is already logged in, redirect to the dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="globals.css" />
    <link rel="stylesheet" href="styleguide.css" />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="strter">
      <div class="div">
        <!-- Sign Up text linked to the signup.php page -->
        <a href="signup.php" class="sign-up-link">
          <div class="text-wrapper">Sign Up</div>
        </a>
        
        <!-- Get Started button linked to the login.php page -->
        <div class="group">
          <a href="login.php" class="get-started-link">
            <div class="div-wrapper">
              <div class="text-wrapper-2">Get Started</div>
            </div>
          </a>
        </div>
        
        <!-- Brand Image -->
        <img class="techcart" src="img/TechCart.png" />
      </div>
    </div>
  </body>
</html>
