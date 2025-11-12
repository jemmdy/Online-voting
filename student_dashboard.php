<?php
require 'db.php';
session_start();

// Ensure user is logged in and not admin
if (empty($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
  header("Location: login.php");
  exit;
}

// Fetch student name + voting status
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, has_voted FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$student = $stmt->fetch();
$name = $student ? htmlspecialchars($student['name']) : "Student";
$has_voted = $student['has_voted'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Dashboard | Online Voting System</title>
  <style>
    body {
      position: relative;
      background: url('image/press.jpeg') no-repeat center center fixed;
      background-size: cover;
      font-family: "Segoe UI", Arial, sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
    }

    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      z-index: 0;
      pointer-events: none;
    }

    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 95%;
      background: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      z-index: 2;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 40px;
    }

    header h1 {
      color: #00b4ff;
      font-size: 20px;
      margin: 0;
    }

    nav a {
      margin-left: 20px;
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    nav a:hover {
      color: #00b4ff;
    }

    .container {
      position: relative;
      z-index: 1;
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(10px);
      color: white;
      width: 85%;
      max-width: 900px;
      margin: 120px auto 50px;
      padding: 40px 50px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.4);
      text-align: center;
      animation: fadeIn 0.8s ease;
    }

    h2 {
      color: #00b4ff;
      font-size: 28px;
      margin-bottom: 25px;
    }

    p {
      font-size: 18px;
      margin-bottom: 30px;
    }

    .buttons a, .voted-msg {
      display: inline-block;
      background: #00b4ff;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 8px;
      margin: 10px;
      font-weight: bold;
      transition: 0.3s;
    }

    .buttons a:hover {
      background: #008ecc;
    }

    .voted-msg {
      background: gray;
      cursor: default;
    }

    footer {
      text-align: center;
      color: white;
      font-size: 14px;
      margin-bottom: 15px;
      opacity: 0.7;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <header>
    <h1> Student's Dashboard</h1>
    <nav>
      <a href="student_dashboard.php">Home</a>
      <?php if ($has_voted == 0): ?>
        <a href="ballot.php">Vote</a>
      <?php endif; ?>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="container">
    <h2>Welcome, <?= $name ?> </h2>
    <p>Welcome to the student's voting portal.</p>

    <div class="buttons">
      <?php if ($has_voted == 0): ?>
        <a href="ballot.php"> Cast Your Vote</a>
      <?php else: ?>
        <span class="voted-msg">✅ You have already voted</span>
      <?php endif; ?>
      
      <a href="logout.php"> Logout</a>
    </div>
  </div>

  <footer>
    © <?= date('Y') ?> Online Voting System | All Rights Reserved
  </footer>
</body>
</html>
