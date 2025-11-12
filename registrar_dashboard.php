<?php
session_start();

// ✅ Check if user is logged in & is a registrar
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'registrar') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registrar Dashboard | Online Voting System</title>
  <style>
    body {
      position: relative;
      background: url('image/press.jpeg') no-repeat center center fixed;
      background-size: cover;
      font-family: "Segoe UI", Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: white;
      min-height: 100vh;
    }

    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.45);
      z-index: 0;
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
      font-size: 22px;
      margin: 0;
    }

    nav a {
      margin-left: 25px;
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    nav a:hover, nav a.active {
      color: #00b4ff;
      text-decoration: underline;
    }

    .container {
      position: relative;
      z-index: 1;
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(10px);
      width: 85%;
      max-width: 900px;
      margin: 120px auto 50px;
      padding: 40px 50px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.4);
      text-align: center;
    }

    h2 {
      color: #00b4ff;
      margin-bottom: 20px;
    }

    .btn {
      display: inline-block;
      background: #0078d4;
      padding: 15px 25px;
      border-radius: 10px;
      color: white;
      text-decoration: none;
      font-size: 16px;
      margin-top: 20px;
      transition: 0.3s;
    }

    .btn:hover {
      background: #005fa3;
      transform: translateY(-3px);
    }
  </style>
</head>
<body>

<header>
  <h1>Registrar Dashboard</h1>
  <nav>
    <a href="registrar_dashboard.php" class="active">Home</a>
    <a href="manage_eligible.php">Manage Eligible Students</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div class="container">
  <h2>Welcome, <?= htmlspecialchars($_SESSION['name']); ?> 👋</h2>
  <p>Your responsibility is to manage the list of eligible students.</p>
  <a href="manage_eligible.php" class="btn">Go to Eligible Students Manager</a>
</div>

</body>
</html>
