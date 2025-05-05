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
	  background: linear-gradient(to bottom, #2ca3a3, #146c6c);
	  display: flex;
	  justify-content: center;
	  align-items: center;
	  width: 100%;
	  height: 100vh;
	  font-family: Arial, sans-serif;
	}

	.login .overlap {
	  position: relative;
	  width: 400px;
	  padding: 40px;
	  background: linear-gradient(to bottom, #166666, #0f4c4c);
	  border: 4px solid black;
	  border-radius: 10px;
	  box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.7);
	}

	.login .text-wrapper {
	  text-align: center;
	  color: white;
	  font-weight: bold;
	  font-size: 40px;
	  margin-bottom: 30px;
	}

	.login input[type="text"],
	.login input[type="password"] {
	  background-color: #288282;
	  border: 2px solid black;
	  color: white;
	  border-radius: 8px;
	  font-size: 16px;
	  padding: 10px;
	  width: 100%;
	  margin-bottom: 20px;
	}

	.login input::placeholder {
	  color: rgba(255, 255, 255, 0.7);
	}

	.login label {
	  color: white;
	  font-weight: bold;
	  font-size: 16px;
	  display: block;
	  margin-bottom: 8px;
	}

	.login .remember-container {
	  display: flex;
	  align-items: center;
	  margin-bottom: 20px;
	}

	.login input[type="checkbox"] {
	  width: 16px;
	  height: 16px;
	  margin-right: 8px;
	}

	.login .remember-label {
	  color: white;
	  font-size: 14px;
	  font-weight: bold;
	}

	.login .login-button {
	  background-color: #e0e0e0;
	  color: black;
	  font-weight: bold;
	  border: none;
	  padding: 15px;
	  font-size: 22px;
	  border-radius: 30px;
	  width: 100%;
	  margin-top: 10px;
	  transition: background-color 0.3s;
	}

	.login .login-button:hover {
	  background-color: #c7c7c7;
	}

	.login .guest-button {
	  background-color: #b0b0b0;
	  color: black;
	  font-weight: 600;
	  border: none;
	  padding: 10px;
	  font-size: 18px;
	  border-radius: 30px;
	  width: 100%;
	  margin-top: 10px;
	}

	.login .signup-text {
	  text-align: center;
	  color: white;
	  margin-top: 20px;
	  font-size: 14px;
	}

	.login .signup-text a,
	.signup-text a:visited {
	  color: skyblue;
	  text-decoration: none;
	}

	}

	.error-message {
	  color: red;
	  font-size: 15px;
	  font-weight: bold;
	  margin-top: 10px;
	  text-align: center;
	}
  </style>
</head>
<body>
  <div class="login">
    <div class="overlap-wrapper">
      <form class="overlap" action="login.php" method="POST">
        <div class="text-wrapper">TechCart</div>

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
			Don't have an account? <a href="signup.php">Sign up</a>
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
