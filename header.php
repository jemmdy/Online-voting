<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- ======= TOP NAVIGATION BAR ======= -->
<style>
  .topnav {
    background: #0078d4;
    color: white;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  .topnav .title {
    font-size: 20px;
    font-weight: bold;
  }
  .topnav .links a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
    font-weight: 500;
    transition: 0.3s;
    padding: 6px 12px;
    border-radius: 6px;
  }
  .topnav .links a:hover {
    background: #005fa3;
  }
  .topnav .right {
    display: flex;
    align-items: center;
  }
  .topnav .role {
    margin-right: 15px;
    font-style: italic;
  }
</style>

<div class="topnav">
  <div class="title">🎓 Online Voting System</div>

  <div class="links">
    <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
      <!-- Admin Navigation -->
      <a href="admin_dashboard.php">Dashboard</a>
      <a href="admin_add_position.php">Positions</a>
      <a href="admin_add_candidate.php">Candidates</a>
      <a href="results.php">Results</a>
    <?php else: ?>
      <!-- Student Navigation -->
      <a href="ballot.php">Vote</a>
      <a href="results.php">Results</a>
    <?php endif; ?>
  </div>

  <div class="right">
    <?php if (!empty($_SESSION['user_id'])): ?>
      <span class="role">
        Logged in as: <b><?= $_SESSION['is_admin'] ? 'Admin' : 'Student' ?></b>
      </span>
      <a href="logout.php" style="background:#ff4444;">Logout</a>
    <?php endif; ?>
  </div>
</div>
