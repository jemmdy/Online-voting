<?php
require 'db.php';
session_start();

// ✅ Allow only admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ✅ Handle position creation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = trim($_POST['name']);
  $desc = trim($_POST['description']);
  if ($name != "") {
    $stmt = $pdo->prepare("INSERT INTO positions (name, description) VALUES (?, ?)");
    $stmt->execute([$name, $desc]);
    echo "<script>alert('✅ Position added successfully!'); window.location='admin_add_position.php';</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Positions | Admin Panel</title>
  <style>
    /* ====== GLOBAL STYLES ====== */
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

    /* Overlay for contrast */
    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.45);
      z-index: 0;
      pointer-events: none;
    }

    /* ====== HEADER / NAV BAR ====== */
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

    nav a:hover {
      color: #00b4ff;
    }

    nav a.active {
      color: #00b4ff;
      text-decoration: underline;
    }

    /* ====== FORM CONTAINER ====== */
    .container {
      position: relative;
      z-index: 1;
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(10px);
      width: 85%;
      max-width: 700px;
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
      margin-bottom: 25px;
    }

    input[type="text"], textarea {
      width: 90%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.1);
      color: white;
      font-size: 16px;
      outline: none;
      transition: 0.3s;
    }

    input:focus, textarea:focus {
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid #00b4ff;
      box-shadow: 0 0 8px #00b4ff;
    }

    button {
      background: #00b4ff;
      color: white;
      border: none;
      padding: 12px 25px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 10px;
    }

    button:hover {
      background: #008ecc;
    }

    a.back {
      display: inline-block;
      margin-top: 25px;
      color: #00b4ff;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    a.back:hover {
      color: #008ecc;
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 600px) {
      .container {
        width: 90%;
        padding: 25px;
      }
      header {
        flex-direction: column;
        align-items: flex-start;
        padding: 10px 20px;
      }
      nav {
        margin-top: 10px;
      }
    }
  </style>
</head>
<body>
  <!-- ====== HEADER BAR ====== -->
  <header>
    <h1> Admin's Dashboard</h1>
    <nav>
      <a href="admin_dashboard.php">Home</a>
      <a href="approve_students.php">Student Approval</a>
      <a href="admin_add_position.php" class="active">Positions</a>
      <a href="admin_add_candidate.php">Candidates</a>
      <a href="view_logs.php">Logs</a>
      <a href="results.php">Results</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <!-- ====== MAIN CONTENT ====== -->
  <div class="container">
    <h2> Add New Position</h2>

    <form method="POST">
      <input type="text" name="name" placeholder="Enter Position Name" required><br>
      <textarea name="description" placeholder="Enter description (optional)" rows="3"></textarea><br>
      <button type="submit">Add Position</button>
    </form>

    <a href="admin_dashboard.php" class="back">⬅ Back to Dashboard</a>
  </div>
</body>
</html>
