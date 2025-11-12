<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Thank You for Voting | Online Voting System</title>
  <style>
    /* ===== GLOBAL STYLES ===== */
    body {
      position: relative;
      font-family: "Segoe UI", Arial, sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: url('image/press.jpeg') no-repeat center center fixed;
      background-size: cover;
      color: white;
      overflow: hidden;
    }

    /* Overlay for better readability */
    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 0;
    }

    /* ===== CONTAINER ===== */
    .container {
      position: relative;
      z-index: 1;
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(10px);
      text-align: center;
      padding: 60px 50px;
      border-radius: 25px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.4);
      width: 420px;
      max-width: 90%;
      animation: fadeIn 1s ease;
    }

    .emoji {
      font-size: 60px;
      margin-bottom: 15px;
      animation: pop 1s ease;
    }

    h2 {
      color: #00b4ff;
      margin-bottom: 15px;
      font-size: 28px;
    }

    p {
      color: #ddd;
      font-size: 16px;
      line-height: 1.6;
      margin-bottom: 30px;
    }

    .btn {
      display: inline-block;
      background: #00b4ff;
      color: white;
      text-decoration: none;
      padding: 12px 30px;
      border-radius: 8px;
      font-weight: 600;
      margin: 10px;
      transition: 0.3s;
    }

    .btn:hover {
      background: #008ecc;
      transform: translateY(-3px);
    }

    footer {
      margin-top: 25px;
      font-size: 14px;
      color: #aaa;
      opacity: 0.8;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pop {
      0% { transform: scale(0.5); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }

    @media (max-width: 600px) {
      .container {
        width: 90%;
        padding: 40px 25px;
      }
      h2 { font-size: 24px; }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="emoji">🎉</div>
    <h2>Thank You for Voting!</h2>
    <p>Your participation makes a difference.  
       Every vote brings us one step closer to a fair and transparent election.</p>

    <a href="student_dashboard.php" class="btn"> Back to Dashboard</a>
    <a href="logout.php" class="btn"> Logout</a>

    <footer>© <?= date('Y') ?> Online Voting System — Empowering Student Democracy</footer>
  </div>
</body>
</html>
