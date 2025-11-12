<?php 
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Check eligibility
    $check_eligible = $pdo->prepare("SELECT * FROM eligible_students WHERE student_id = ?");
    $check_eligible->execute([$student_id]);
    if ($check_eligible->rowCount() == 0) {
        echo "<script>
                alert('You are not in the eligible student list. Contact admin.');
                window.location.href='register.php';
              </script>";
        exit;
    }

    // ✅ Check if student_id or email already exists
    $check_user = $pdo->prepare("SELECT * FROM users WHERE student_id = ? OR email = ?");
    $check_user->execute([$student_id, $email]);
    if ($check_user->rowCount() > 0) {
        echo "<script>
                alert('Student ID or Email already exists. Please try again.');
                window.location.href='register.php';
              </script>";
        exit;
    }

    // ✅ Insert new user (is_admin = 0, status = 'Pending')
    $insert = $pdo->prepare("INSERT INTO users (student_id, name, email, password, is_admin, status) VALUES (?, ?, ?, ?, 0, 'Pending')");
    if ($insert->execute([$student_id, $name, $email, $hashed_password])) {
        echo "<script>
                alert('Registration submitted. Await admin approval before login.');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Error during registration. Please try again.');
                window.location.href='register.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Registration | Online Voting System</title>
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
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.3);
      z-index: 0;
    }

    .register-container {
      position: relative;
      z-index: 1;
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(8px);
      padding: 40px;
      border-radius: 20px;
      width: 420px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      text-align: center;
      animation: slideIn 0.8s ease;
    }

    .register-container h2 {
      color: #0078d4;
      margin-bottom: 10px;
    }

    .info {
      font-size: 14px;
      color: #555;
      margin-bottom: 15px;
    }

    .register-container input[type="text"],
    .register-container input[type="email"],
    .register-container input[type="password"] {
      width: 90%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      outline: none;
      transition: 0.3s;
    }

    .register-container input:focus {
      border-color: #0078d4;
      box-shadow: 0 0 5px #0078d4;
    }

    .register-container button {
      background: #0078d4;
      color: #fff;
      border: none;
      padding: 12px;
      width: 95%;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
      margin-top: 10px;
    }

    .register-container button:hover {
      background: #005fa3;
    }

    .register-container p {
      margin-top: 15px;
      font-size: 14px;
    }

    .register-container a {
      color: #0078d4;
      text-decoration: none;
    }

    .register-container a:hover {
      text-decoration: underline;
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2> Student Registration</h2>
    <p class="info"> Only eligible students can register.<br> Your account will be reviewed by the admin before login.</p>

    <form method="POST" action="">
      <input type="text" name="student_id" placeholder="Student ID" required><br>
      <input type="text" name="name" placeholder="Full Name" required><br>
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</body>
</html>
