<?php
ob_start();
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "techcart");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $store_name = trim($_POST['store_name'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, username, email, store_name, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            echo "<script>alert('Prepare failed: " . $conn->error . "');</script>";
        } else {
            $stmt->bind_param("sssss", $name, $username, $email, $store_name, $hashed_password);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful! Redirecting to login.'); window.location.href = 'login.php';</script>";
                exit();
            } else {
                if ($conn->errno === 1062) {
                    echo "<script>alert('Username or email already exists.');</script>";
                } else {
                    echo "<script>alert('Error: " . $stmt->error . "');</script>";
                }
            }

            $stmt->close();
        }
    }
}

$conn->close();
ob_end_flush();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <style>
      .sign-up {
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

      .sign-up .overlap-group {
        position: relative;
        width: 700px;
        height: 400px;
        top: -30px;
        left: 15px;
        border: 3px solid;
        border-color: #000000;
      }

      .sign-up input[type="text"],
      .sign-up input[type="email"],
      .sign-up input[type="password"] {
        position: absolute;
        height: 15px;
        border-radius: 10px;
        border: 3px solid #000;
        background-color: #c4c4c4;
        width: 250px;
        padding: 8px;
        font-size: 14px;
        font-family: "Inter", sans-serif;
        background-blend-mode: overlay;
      }

      .sign-up .name { top: 120px; left: 60px; }
      .sign-up .username { top: 120px; left: 380px; }
      .sign-up .email { top: 190px; left: 60px; background-color: #d9d9d9; }
      .sign-up .store_name { top: 190px; left: 380px; }
      .sign-up .password { top: 260px; left: 60px; background-color: #d9d9d9; }
      .sign-up .confirm_password { top: 260px; left: 380px; }

      .sign-up .overlap {
        position: absolute;
        width: 160px;
        height: 35px;
        top: 310px;
        left: 273px;
        background-color: #d9d9d9;
        border-radius: 120px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        font-size: 20px;
        font-family: "Inter-Bold", Helvetica;
        font-weight: 700;
      }

      .sign-up .text-wrapper-2 {
        position: absolute;
        width: 226px;
        top: 30px;
        left: 290px;
        color: #ffffff;
        font-size: 35px;
        font-family: "Inter-Bold", Helvetica;
        font-weight: 700;
        white-space: nowrap;
      }

      .sign-up .text-wrapper-3,
      .sign-up .text-wrapper-4,
      .sign-up .text-wrapper-5,
      .sign-up .text-wrapper-6,
      .sign-up .text-wrapper-7,
      .sign-up .text-wrapper-8 {
        position: absolute;
        font-family: "Inter-Bold", Helvetica;
        font-weight: 700;
        color: #ffffff;
        font-size: 15px;
        white-space: nowrap;
      }

      .sign-up .text-wrapper-3 { top: 97px; left: 80px; }
      .sign-up .text-wrapper-4 { top: 97px; left: 400px; }
      .sign-up .text-wrapper-5 { top: 168px; left: 75px; }
      .sign-up .text-wrapper-6 { top: 168px; left: 398px; }
      .sign-up .text-wrapper-7 { top: 237px; left: 73px; }
      .sign-up .text-wrapper-8 { top: 237px; left: 395px; }

      .sign-up .overlap-2 {
        position: absolute;
        width: 350px;
        height: 15px;
        top: 355px;
        left: 230px;
      }

      .sign-up .text-wrapper-9 {
        position: absolute;
        width: 287px;
        top: 0;
        left: 0;
        font-family: "Inter-Bold", Helvetica;
        font-weight: 700;
        color: #ffffff;
        font-size: 15px;
      }

      .sign-up .text-wrapper-10 {
        position: absolute;
        width: 171px;
        top: 0;
        left: 200px;
        font-family: "Inter-Bold", Helvetica;
        font-weight: 700;
        font-size: 15px;
        background: linear-gradient(180deg, rgba(63, 127, 211, 1) 0%, rgba(33, 66, 109, 1) 54%);
        -webkit-background-clip: text !important;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        text-fill-color: transparent;
        color: transparent;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <div class="sign-up">
      <div class="overlap-group-wrapper">
        <div class="overlap-group">
          <form action="signup.php" method="POST">
            <label class="text-wrapper-3">Name</label>
            <input class="name" type="text" name="name" required />

            <label class="text-wrapper-4">Username</label>
            <input class="username" type="text" name="username" required />

            <label class="text-wrapper-5">Email Address</label>
            <input class="email" type="email" name="email" required />

            <label class="text-wrapper-6">Store Name</label>
            <input class="store_name" type="text" name="store_name" required />

            <label class="text-wrapper-7">Password</label>
            <input class="password" type="password" name="password" required />

            <label class="text-wrapper-8">Confirm Password</label>
            <input class="confirm_password" type="password" name="confirm_password" required />

            <button type="submit" class="overlap">Sign Up</button>

            <div class="text-wrapper-2">Sign Up</div>

            <div class="overlap-2">
              <div class="text-wrapper-9">Already have an account?</div>
              <a href="login.php" class="get-started-link">
                <div class="text-wrapper-10">Sign in</div>
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
