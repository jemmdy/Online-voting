<?php 
require 'db.php';
session_start();

// ✅ Only allow admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ✅ Logging function
function write_log($pdo, $actor_id, $action, $target_id = null, $description = null) {
    $lstmt = $pdo->prepare("INSERT INTO logs (user_id, action, target_id, description) VALUES (?, ?, ?, ?)");
    $lstmt->execute([$actor_id, $action, $target_id, $description]);
}

// ✅ Approve or Reject student
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $actionStatus = $_GET['action'] === 'approve' ? 'Approved' : 'Rejected';

    // ✅ Get student info for logging
    $fetch = $pdo->prepare("SELECT student_id, name FROM users WHERE id = ?");
    $fetch->execute([$id]);
    $student = $fetch->fetch();

    // ✅ Update status
    $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->execute([$actionStatus, $id]);

    // ✅ Write log (Admin approved/rejected student)
    write_log(
        $pdo,
        $_SESSION['user_id'], // Admin ID
        $actionStatus . " student",
        $id, // Target user ID
        "student_id: {$student['student_id']}, name: {$student['name']}"
    );

    echo "<script>alert('Student has been {$actionStatus}.'); window.location='approve_students.php';</script>";
    exit;
}

// ✅ Fetch all pending students
$stmt = $pdo->prepare("SELECT * FROM users WHERE status = 'Pending' AND is_admin = 0 ORDER BY id");
$stmt->execute();
$pendingStudents = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Approve Students | Admin Panel</title>
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

    .btn {
      padding: 8px 15px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    .approve {
      background: #28a745;
      color: white;
    }

    .approve:hover {
      background: #218838;
    }

    .reject {
      background: #dc3545;
      color: white;
    }

    .reject:hover {
      background: #c82333;
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
  <h1>Admin Dashboard</h1>
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
  <h2>Pending Student Approvals</h2>

  <?php if (count($pendingStudents) > 0): ?>
  <table>
    <tr>
      <th>ID</th>
      <th>Student ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
    <?php foreach ($pendingStudents as $stu): ?>
    <tr>
      <td><?= $stu['id'] ?></td>
      <td><?= htmlspecialchars($stu['student_id']) ?></td>
      <td><?= htmlspecialchars($stu['name']) ?></td>
      <td><?= htmlspecialchars($stu['email']) ?></td>
      <td>
        <a href="approve_students.php?action=approve&id=<?= $stu['id'] ?>" class="btn approve">Approve</a>
        <a href="approve_students.php?action=reject&id=<?= $stu['id'] ?>" class="btn reject" onclick="return confirm('Are you sure you want to reject this student?');">Reject</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
  <?php else: ?>
    <p style="text-align:center;">✅ All students have been reviewed.</p>
  <?php endif; ?>

  <a href="admin_dashboard.php" class="back">⬅ Back to Dashboard</a>
</div>

</body>
</html>
