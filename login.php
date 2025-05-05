<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$loginError = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "techcart");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $loginError = 'invalid_password';
        }
    } else {
        $loginError = 'no_user_found';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <style>
    .login {
      background-color: #1a675e;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      height: 100vh;
      background-attachment: fixed;
      background-position: center center;
      background-repeat: no-repeat;
    }

    .login .overlap {
      position: relative;
      width: 600px;
      height: 500px;
      top: -10px;
      left: 15px;
      border: 3px solid #252424;
    }

    .login .text-wrapper {
      width: 260px;
      top: 35px;
      left: 250px;
      color: #ffffff;
      font-size: 40px;
      white-space: nowrap;
      position: absolute;
      font-family: "Inter-Bold", Helvetica;
      font-weight: 700;
    }

    .login input[type="text"],
    .login input[type="password"] {
      position: absolute;
      width: 450px;
      height: 15px;
      left: 60px;
      background-color: #c4c4c4;
      border-radius: 10px;
      border: 3px solid #000000;
      padding: 12px;
      font-size: 18px;
      font-family: "Inter", sans-serif;
    }

    .login input[type="text"] {
      top: 148px;
    }

    .login input[type="password"] {
      top: 242px;
    }

    .login label.username-label,
    .login label.password-label {
      position: absolute;
      font-family: "Inter-Bold", Helvetica;
      font-weight: 700;
      color: #ffffff;
      font-size: 16px;
      left: 96px;
      white-space: nowrap;
    }

    .login label.username-label {
      top: 120px;
    }

    .login label.password-label {
      top: 210px;
    }

    .login .remember-container {
      position: absolute;
      top: 300px;
      left: 80px;
      display: flex;
      align-items: center;
    }

    .login input[type="checkbox"] {
      width: 13px;
      height: 13px;
      margin-right: 5px;
    }

    .login .remember-label {
      font-family: "Inter-Bold", Helvetica;
      font-weight: 700;
      color: #ffffff;
      font-size: 13px;
    }

    .login .login-button {
      position: absolute;
      width: 300px;
      height: 40px;
      top: 340px;
      left: 150px;
      background-color: #d9d9d9;
      border: none;
      border-radius: 120px;
      font-size: 25px;
      font-family: "Inter-Bold", Helvetica;
      font-weight: 700;
      cursor: pointer;
    }

    .login .guest-button {
      position: absolute;
      width: 300px;
      height: 40px;
      top: 390px;
      left: 150px;
      background-color: #b0b0b0;
      border: none;
      border-radius: 120px;
      font-size: 20px;
      font-family: "Inter-Bold", Helvetica;
      font-weight: 600;
      cursor: pointer;
    }

    .login .signup-text {
      position: absolute;
      width: 284px;
      height: 22px;
      top: 440px;
      left: 177px;
      display: flex;
      gap: 7px;
      font-family: "Inter-Bold", Helvetica;
      font-weight: 650;
      font-size: 16px;
      color: #ffffff;
    }

    .login .signup-link {
      background: linear-gradient(
        180deg,
        rgba(63, 127, 211, 1) 0%,
        rgb(13, 51, 102) 54%
      );
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      text-fill-color: transparent;
      cursor: pointer;
      text-decoration: none;
    }

    .error-message {
      position: absolute;
      top: 470px;
      left: 170px;
      color: red;
      font-size: 15px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="login">
    <div class="overlap-wrapper">
      <form class="overlap" action="login.php" method="POST">
        <div class="text-wrapper">Login</div>

        <label class="username-label" for="username">Username</label>
        <input type="text" id="username" name="username" required />

        <label class="password-label" for="password">Password</label>
        <input type="password" id="password" name="password" required />

        <div class="remember-container">
          <input type="checkbox" id="remember" name="remember" />
          <label for="remember" class="remember-label">Remember Me</label>
        </div>

        <button type="submit" class="login-button">Login</button>
        <button type="button" class="guest-button" onclick="window.location.href='guest.php'">Continue as Guest</button>

        <div class="signup-text">
          <div>Don't have an Account?</div>
          <a href="signup.php" class="signup-link">Sign Up</a>
        </div>

        <?php if ($loginError == 'invalid_password'): ?>
          <div class="error-message">Incorrect password. Please try again.</div>
        <?php elseif ($loginError == 'no_user_found'): ?>
          <div class="error-message">No user found with that username.</div>
        <?php endif; ?>
      </form>
    </div>
  </div>
</body>
</html>
