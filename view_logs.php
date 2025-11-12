<?php
require 'db.php';
session_start();

// ✅ Only allow admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ✅ Fetch logs with user details
$stmt = $pdo->prepare("
    SELECT l.id, l.user_id, u.name AS user_name, l.action, l.created_at
    FROM logs l
    LEFT JOIN users u ON l.user_id = u.id
    ORDER BY l.created_at DESC
");
$stmt->execute();
$logs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>System Logs | Admin Panel</title>
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
      max-width: 1000px;
      margin: 120px auto 50px;
      padding: 40px 50px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.4);
      animation: fadeIn 0.8s ease;
    }

    h2 {
      text-align: center;
      color: #00b4ff;
      font-size: 28px;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
      text-align: center;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #444;
    }

    th {
      background: #00b4ff;
      color: white;
    }

    a.back {
      display: inline-block;
      margin-top: 20px;
      color: #00b4ff;
      text-decoration: none;
      font-size: 14px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<header>
  <h1>Admin's Dashboard</h1>
  <nav>
    <a href="admin_dashboard.php">Home</a>
    <a href="approve_students.php" class="active">Student Approval</a>
    <a href="admin_add_position.php">Positions</a>
    <a href="admin_add_candidate.php">Candidates</a>
    <a href="view_logs.php" class="active">Logs</a>
     <a href="results.php">Results</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div class="container">
  <h2>System Activity Logs</h2>

  <?php if (count($logs) > 0): ?>
  <table>
    <tr>
      <th>ID</th>
      <th>User</th>
      <th>Action</th>
      <th>Timestamp</th>
    </tr>
    <?php foreach ($logs as $log): ?>
    <tr>
      <td><?= $log['id'] ?></td>
      <td><?= htmlspecialchars($log['user_name'] ?? 'Unknown User') ?></td>
      <td><?= htmlspecialchars($log['action']) ?></td>
      <td><?= $log['created_at'] ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <?php else: ?>
    <p style="text-align:center;">No logs available.</p>
  <?php endif; ?>

  <a href="admin_dashboard.php" class="back">⬅ Back to Dashboard</a>
</div>

</body>
</html>
