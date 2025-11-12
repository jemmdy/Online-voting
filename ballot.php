<?php
require 'db.php';
session_start();

// ✅ Ensure only logged-in students can vote
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Check if the student has already voted
$checkVote = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE user_id = ?");
$checkVote->execute([$user_id]);
if ($checkVote->fetchColumn() > 0) {
    header("Location: thankyou.php");
    exit;
}

// ✅ Fetch all positions
$positions = $pdo->query("SELECT * FROM positions ORDER BY id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cast Your Vote | Online Voting System</title>
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
      margin-left: 20px;
      color: white;
      text-decoration: none;
      font-weight: 600;
    }

    nav a:hover, nav a.active {
      color: #00b4ff;
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
    }

    h2 {
      text-align: center;
      color: #00b4ff;
      margin-bottom: 30px;
    }

    .position {
      margin-bottom: 40px;
      border-bottom: 1px solid #333;
      padding-bottom: 20px;
    }

    .position h3 {
      color: #00b4ff;
      margin-bottom: 15px;
      border-left: 5px solid #00b4ff;
      padding-left: 10px;
    }

    .candidates {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .candidate {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 15px;
      padding: 15px;
      transition: 0.3s;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .candidate:hover {
      background: rgba(0, 180, 255, 0.15);
      transform: translateY(-3px);
    }

    .candidate label {
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
    }

    .candidate input[type="radio"] {
      accent-color: #00b4ff;
      transform: scale(1.3);
    }

    .submit-container {
      text-align: center;
      margin-top: 40px;
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
    }

    button:hover {
      background: #008ecc;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<header>
  <h1>Student's Dashboard</h1>
  <nav>
    <a href="student_dashboard.php">Home</a>
    <a href="ballot.php" class="active">Vote</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div class="container">
  <h2>Cast Your Vote</h2>

  <form action="vote.php" method="POST">
    <?php foreach ($positions as $p): ?>
      <div class="position">
        <h3><?= htmlspecialchars($p['name']) ?></h3>
        <div class="candidates">
          <?php
          $stmt = $pdo->prepare("SELECT * FROM candidates WHERE position_id = ?");
          $stmt->execute([$p['id']]);
          $cands = $stmt->fetchAll();
          foreach ($cands as $c): ?>
            <div class="candidate">
              <label>
                <input type="radio" name="votes[<?= $p['id'] ?>]" value="<?= $c['id'] ?>" required>
                <div>
                  <strong><?= htmlspecialchars($c['name']) ?></strong><br>
                  <small><?= htmlspecialchars($c['manifesto']) ?></small>
                </div>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="submit-container">
      <button type="submit">Submit Votes</button>
    </div>
  </form>
</div>

</body>
</html>
