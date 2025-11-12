<?php 
require 'db.php';
session_start();

// ✅ Allow only admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ✅ Fetch positions
$positions = $pdo->query("SELECT * FROM positions ORDER BY id")->fetchAll();

// ✅ Count voted students
$totalApproved = $pdo->query("SELECT COUNT(*) FROM users WHERE role='student' AND status='Approved'")->fetchColumn();
$totalVoted = $pdo->query("SELECT COUNT(DISTINCT user_id) FROM votes")->fetchColumn();
$totalNotVoted = $totalApproved - $totalVoted;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin | Election Results</title>

  <!-- ✅ Chart.js & datalabels -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

  <style>
    body {
      position: relative;
      background: url('image/press.jpeg') no-repeat center center fixed;
      background-size: cover;
      font-family: "Segoe UI", Arial, sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      color: white;
    }

    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.45);
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
      color: white;
      margin: 0;
    }

    nav a {
      margin-left: 25px;
      color: white;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    nav a:hover, .active {
      text-decoration: underline;
    }

    .container {
      position: relative;
      z-index: 1;
      background: rgba(0,0,0,0.75);
      backdrop-filter: blur(10px);
      width: 85%;
      max-width: 1000px;
      margin: 120px auto 50px;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    }

    h2 {
      text-align: center;
      color: #00b4ff;
      margin-bottom: 30px;
      font-size: 28px;
    }

    h3 {
      color: #00b4ff;
      border-left: 5px solid #00b4ff;
      padding-left: 10px;
      margin-bottom: 15px;
    }

    .chart-block {
      width: 100%;
      display: flex;
      justify-content: center;
      margin-bottom: 25px;
    }

    /* ✅ Smaller Pie Chart */
    .chart-block canvas {
      max-width: 350px;
      max-height: 350px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th {
      background: #00b4ff;
      padding: 10px;
    }

    td {
      background: rgba(20,20,20,0.9);
      padding: 10px;
      border-bottom: 1px solid #333;
    }

    .winner {
      background: #008ecc !important;
      font-weight: bold;
      color: #fff;
    }

    .back {
      display: block;
      text-align: center;
      margin-top: 25px;
      color: #00b4ff;
      text-decoration: none;
    }
  </style>
</head>
<body>

<!-- ✅ NAV BAR -->
<header id="navbar">
  <h1>Admin's Dashboard</h1>
  <nav>
    <a href="admin_dashboard.php">Home</a>
    <a href="approve_students.php">Approve</a>
    <a href="admin_add_position.php">Positions</a>
    <a href="admin_add_candidate.php">Candidates</a>
    <a href="view_logs.php">Logs</a>
    <a href="result.php" class="active">Results</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<script>
/* ✅ Auto-Hide Navbar */
let lastScrollTop = 0;
const nav = document.getElementById("navbar");

window.addEventListener("scroll", function () {
  let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  if (scrollTop > lastScrollTop) {
    nav.style.top = "-80px";   // hide
  } else {
    nav.style.top = "0";       // show
  }
  lastScrollTop = scrollTop;
});
</script>

<div class="container">
  <h2>Election Results</h2>

  <!-- ✅ Global Voted vs Not Voted -->
  <h3>Voting Status Overview</h3>
  <div class="chart-block">
    <canvas id="overallVoteChart"></canvas>
  </div>

  <script>
    new Chart(document.getElementById("overallVoteChart"), {
      type: "pie",
      data: {
        labels: ["Voted", "Not Voted"],
        datasets: [{
          data: [<?= $totalVoted ?>, <?= $totalNotVoted ?>],
          backgroundColor: ["#00ff88", "#ff5555"]
        }]
      },
      plugins: [ChartDataLabels],
      options: {
        plugins: {
          datalabels: {
            formatter: (value, ctx) => {
              let sum = ctx.chart._metasets[0].total;
              let percentage = (value * 100 / sum).toFixed(1) + "%";
              return percentage;
            },
            color: "white",
            font: { weight: "bold" }
          }
        }
      }
    });
  </script>

  <!-- ✅ One chart per position -->
  <?php foreach ($positions as $p): ?>
    <?php
      $stmt = $pdo->prepare("
        SELECT c.id, c.name, COUNT(v.id) AS total_votes
        FROM candidates c
        LEFT JOIN votes v ON v.candidate_id = c.id
        WHERE c.position_id = ?
        GROUP BY c.id
        ORDER BY total_votes DESC
      ");
      $stmt->execute([$p['id']]);
      $cands = $stmt->fetchAll();

      $winnerId = $cands[0]['id'] ?? null;
      $labels = [];
      $data = [];

      foreach ($cands as $c) {
        $labels[] = $c['name'];
        $data[]   = $c['total_votes'];
      }

      $chartId = "chart_" . $p['id'];
    ?>

    <h3><?= htmlspecialchars($p['name']) ?></h3>

    <div class="chart-block">
      <canvas id="<?= $chartId ?>"></canvas>
    </div>

    <table>
      <tr><th>Candidate</th><th>Votes</th></tr>
      <?php foreach ($cands as $c): ?>
      <tr class="<?= ($c['id']==$winnerId?'winner':'') ?>">
        <td><?= htmlspecialchars($c['name']) ?> <?= ($c['id']==$winnerId?'⭐':'') ?></td>
        <td><?= $c['total_votes'] ?></td>
      </tr>
      <?php endforeach; ?>
    </table>

    <script>
      new Chart(document.getElementById("<?= $chartId ?>"), {
        type: "pie",
        data: {
          labels: <?= json_encode($labels) ?>,
          datasets: [{
            data: <?= json_encode($data) ?>,
            backgroundColor: ["#00aaff","#ffaa00","#ff0055","#33ff99","#aa33ff"]
          }]
        },
        plugins: [ChartDataLabels],
        options: {
          plugins: {
            datalabels: {
              formatter: (val, ctx) => {
                let sum = ctx.chart._metasets[0].total;
                let percentage = (val * 100 / sum).toFixed(1)+"%";
                return percentage;
              },
              color: "#fff",
              font: { weight: "bold", size: 13 }
            }
          }
        }
      });
    </script>

  <?php endforeach; ?>

  <a class="back" href="admin_dashboard.php">⬅ Back</a>
</div>

</body>
</html>
