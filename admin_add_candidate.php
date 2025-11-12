<?php
require 'db.php';
session_start();

// ✅ Allow only admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ✅ Fetch all positions
$positions = $pdo->query("SELECT * FROM positions ORDER BY id")->fetchAll();

// ✅ Handle new candidate addition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = trim($_POST['name']);
  $manifesto = trim($_POST['manifesto']);
  $position_id = $_POST['position_id'];
  
  if ($name != "" && $position_id) {
    $stmt = $pdo->prepare("INSERT INTO candidates (position_id, name, manifesto) VALUES (?, ?, ?)");
    $stmt->execute([$position_id, $name, $manifesto]);
    echo "<script>alert('✅ Candidate added successfully!'); window.location='admin_add_candidate.php';</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Candidates | Admin Panel</title>
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

    /* Overlay for better contrast */
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

    /* ====== MAIN FORM CONTAINER ====== */
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

    label {
      font-weight: 600;
      display: block;
      text-align: left;
      width: 90%;
      margin: 10px auto 5px;
    }

    input[type="text"], textarea, select {
      width: 90%;
      padding: 12px;
      margin: 8px 0 15px;
      border: none;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.1);
      color: white;
      font-size: 16px;
      outline: none;
      transition: 0.3s;
    }

    input:focus, textarea:focus, select:focus {
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid #00b4ff;
      box-shadow: 0 0 8px #00b4ff;
    }

    select option {
      color: black;
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
      <a href="admin_add_position.php">Positions</a>
      <a href="admin_add_candidate.php" class="active">Candidates</a>
      <a href="view_logs.php">Logs</a>
      <a href="results.php">Results</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <!-- ====== FORM CONTAINER ====== -->
  <div class="container">
    <h2> Add New Candidate</h2>

    <form method="POST">
      <label>Candidate Name:</label>
      <input type="text" name="name" placeholder="Enter candidate's full name" required>

      <label>Manifesto:</label>
      <textarea name="manifesto" placeholder="Write the candidate's manifesto" rows="4"></textarea>

      <label>Position:</label>
      <select name="position_id" required>
        <option value="">-- Select Position --</option>
        <?php foreach ($positions as $p): ?>
          <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit">Add Candidate</button>
    </form>

    <a href="admin_dashboard.php" class="back">⬅ Back to Dashboard</a>
  </div>
</body>
</html>
