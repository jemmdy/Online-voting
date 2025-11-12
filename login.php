<?php 
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        
        // ✅ Check status only for students (admin and registrar bypass this)
        if ($user['role'] === 'student') {
            if ($user['status'] === 'Pending') {
                echo "<script>alert('Your account is awaiting approval.'); window.location.href = 'login.php';</script>";
                exit;
            } elseif ($user['status'] === 'Rejected') {
                echo "<script>alert('Your registration was rejected. Contact admin.'); window.location.href = 'login.php';</script>";
                exit;
            }
        }

        // ✅ Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['student_id'] = $user['student_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // ✅ Redirect based on role
        if ($user['role'] === 'admin') {
    header("Location: admin_dashboard.php");
} elseif ($user['role'] === 'registrar') {
    header("Location: registrar_dashboard.php");
} else {
    header("Location: student_dashboard.php");
}
        exit;

    } else {
        echo "<script>alert('Invalid Student ID or Password'); window.location.href = 'login.php';</script>";
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Online Voting System</title>
  <style>
    body {
      position: relative;
      background: url('image/press.jpeg') no-repeat center center fixed;
      background-size: cover;
      font-family: "Segoe UI", Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.3);
      z-index: 0;
    }
    .login-container {
      position: relative;
      z-index: 1;
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(8px);
      padding: 40px;
      border-radius: 20px;
      width: 400px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      text-align: center;
      animation: slideIn 0.8s ease;
    }
    .login-container h2 {
      color: #0078d4;
      margin-bottom: 25px;
    }
    .login-container input[type="text"],
    .login-container input[type="password"] {
      width: 90%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      outline: none;
      transition: 0.3s;
    }
    .login-container input:focus {
      border-color: #0078d4;
      box-shadow: 0 0 5px #0078d4;
    }
    .login-container button {
      background: #0078d4;
      color: #fff;
      border: none;
      padding: 12px 25px;
      width: 95%;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
      margin-top: 10px;
    }
    .login-container button:hover {
      background: #005fa3;
    }
    .login-container p {
      margin-top: 15px;
      font-size: 14px;
    }
    .login-container a {
      color: #0078d4;
      text-decoration: none;
    }
    .login-container a:hover {
      text-decoration: underline;
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2> Online Voting Login</h2>

    <form method="POST" action="">
      <input type="text" name="student_id" placeholder="Enter Student ID" required>
      <input type="password" name="password" placeholder="Enter Password" required>
      <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </div>
</body>
</html>
