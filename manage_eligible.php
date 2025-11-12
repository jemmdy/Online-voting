<?php
require 'db.php';
session_start();

// ✅ Allow only Registrars to access this page
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'registrar') {
    header("Location: login.php");
    exit;
}

// Enable errors during dev (optional; remove in production)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Helper: insert a log row
function write_log($pdo, $actor_id, $action, $target_id = null, $description = null) {
    $lstmt = $pdo->prepare("INSERT INTO logs (user_id, action, target_id, description) VALUES (?, ?, ?, ?)");
    $lstmt->execute([$actor_id, $action, $target_id, $description]);
}

// ✅ Handle adding eligible student
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $student_name = trim($_POST['student_name'] ?? '');

    if ($student_id !== "" && $student_name !== "") {
        // ✅ Check if student already exists in eligible list
        $check = $pdo->prepare("SELECT * FROM eligible_students WHERE student_id = ?");
        $check->execute([$student_id]);

        if ($check->rowCount() > 0) {
            echo "<script>alert('This student is already marked as eligible.'); window.location='manage_eligible.php';</script>";
            exit;
        }

        try {
            // Insert student into eligible_students
            $stmt = $pdo->prepare("INSERT INTO eligible_students (student_id, name) VALUES (?, ?)");
            $stmt->execute([$student_id, $student_name]);

            // get the inserted eligible_students id (useful for logs)
            $eligible_id = $pdo->lastInsertId();

            // Log the action (registrar added eligible student)
            write_log(
                $pdo,
                $_SESSION['user_id'],
                'Added eligible student',
                $eligible_id,
                "student_id: {$student_id}, name: {$student_name}"
            );

            echo "<script>alert('Eligible student added successfully'); window.location='manage_eligible.php';</script>";
            exit;
        } catch (Exception $e) {
            // In production, you might want to log this error to a file instead of showing
            echo "<script>alert('Error adding eligible student: " . addslashes($e->getMessage()) . "'); window.location='manage_eligible.php';</script>";
            exit;
        }
    }
}

// ✅ Handle deleting eligible student
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Fetch the row for logging details (optional but helpful)
    $fetch = $pdo->prepare("SELECT * FROM eligible_students WHERE id = ?");
    $fetch->execute([$delete_id]);
    $row = $fetch->fetch();

    if ($row) {
        try {
            $stmt = $pdo->prepare("DELETE FROM eligible_students WHERE id = ?");
            $stmt->execute([$delete_id]);

            // Log deletion (who removed which eligible student)
            write_log(
                $pdo,
                $_SESSION['user_id'],
                'Deleted eligible student',
                $delete_id,
                "student_id: {$row['student_id']}, name: {$row['name']}"
            );

            header("Location: manage_eligible.php");
            exit;
        } catch (Exception $e) {
            echo "<script>alert('Error removing eligible student: " . addslashes($e->getMessage()) . "'); window.location='manage_eligible.php';</script>";
            exit;
        }
    } else {
        header("Location: manage_eligible.php");
        exit;
    }
}

// ✅ Fetch eligible students
$students = $pdo->query("SELECT * FROM eligible_students ORDER BY id ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Eligible Students | Registrar Panel</title>
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
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 40px;
      z-index: 2;
    }

    header h1 {
      color: #00b4ff;
    }

    nav a {
      margin-left: 20px;
      color: white;
      text-decoration: none;
      font-weight: 600;
    }

    .container {
      position: relative;
      z-index: 1;
      background: rgba(0, 0, 0, 0.7);
      width: 85%;
      max-width: 900px;
      margin: 120px auto;
      padding: 40px 50px;
      border-radius: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #444;
    }

    th {
      background: #00b4ff;
    }

    form input[type="text"] {
      padding: 10px;
      margin-right: 8px;
      border-radius: 6px;
      border: none;
      width: 220px;
    }

    .actions {
      display: flex;
      gap: 8px;
      justify-content: center;
      align-items: center;
    }

    button, .delete-btn {
      padding: 8px 12px;
      background: #00b4ff;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
    }

    .delete-btn {
      background: transparent;
      color: #ff7b7b;
      font-weight: 700;
    }

    .delete-btn:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<header>
  <h1>Registrar's Dashboard</h1>
  <nav>
    <a href="registrar_dashboard.php">Home</a>
    <a href="manage_eligible.php" class="active">Manage Eligible</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div class="container">
  <h2>Manage Eligible Students</h2>

  <form method="POST" style="text-align:center; margin-bottom:12px;">
    <input type="text" name="student_id" placeholder="Student ID" required>
    <input type="text" name="student_name" placeholder="Student Name" required>
    <button type="submit">Add Student</button>
  </form>

  <table>
    <tr>
      <th>ID</th>
      <th>Student ID</th>
      <th>Name</th>
      <th>Action</th>
    </tr>
    <?php foreach ($students as $stu): ?>
    <tr>
      <td><?= $stu['id'] ?></td>
      <td><?= htmlspecialchars($stu['student_id']) ?></td>
      <td><?= htmlspecialchars($stu['name']) ?></td>
      <td class="actions">
        <a href="manage_eligible.php?delete_id=<?= $stu['id'] ?>" class="delete-btn" onclick="return confirm('Remove this student?');">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

</body>
</html>
