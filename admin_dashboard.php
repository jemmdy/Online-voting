<?php
require 'db.php';
session_start();

// ✅ Allow only admins
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | Online Voting System</title>
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
      font-size: 20px;
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
      animation: fadeIn 0.8s ease;
      text-align: center;
    }

    h2 {
      color: #00b4ff;
      font-size: 28px;
      margin-bottom: 20px;
    }

    .nav-links {
      margin-top: 30px;
    }

    .nav-links a {
      display: inline-block;
      background: #00b4ff;
      color: white;
      padding: 12px 25px;
      margin: 10px;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      transition: 0.3s;
      box-shadow: 0 5px 15px rgba(0,180,255,0.3);
    }

    .nav-links a:hover {
      background: #008ecc;
      transform: translateY(-3px);
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
  <!-- ======== NAVIGATION BAR ======== -->
  <header>
    <h1> Admin's Dashboard</h1>
    <nav>
      <a href="admin_dashboard.php" class="active">Home</a>
      <a href="approve_students.php">Student Approval</a> <!-- ✅ NEW -->
      <a href="admin_add_position.php">Positions</a>
      <a href="admin_add_candidate.php">Candidates</a>
      <a href="view_logs.php">Logs</a>
      <a href="results.php">Results</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <!-- ======== DASHBOARD CONTENT ======== -->
  <div class="container">
    <h2>Welcome, Admin!</h2>
    <p>Manage your election system efficiently using the tools below.</p>

    <div class="nav-links">
      <a href="approve_students.php"> Pending Accounts</a>
      <a href="admin_add_position.php"> Add Positions</a>
      <a href="admin_add_candidate.php"> Add Candidates</a>
      <a href="view_logs.php">Logs</a>
      <a href="results.php"> View Results</a>
    </div>
  </div>

  <footer>
    © <?= date('Y') ?> Online Voting System | Admin Panel
  </footer>
</body>
</html>
