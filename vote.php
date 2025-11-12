<?php
require 'db.php';
session_start();

// ✅ Ensure user is logged in and is a student (not admin or registrar)
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'student') { 
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Check if student has already voted
$checkVote = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE user_id = ?");
$checkVote->execute([$user_id]);
if ($checkVote->fetchColumn() > 0) {
    // If already voted, redirect immediately
    header("Location: thankyou.php");
    exit;
}

// ✅ Get submitted votes
$votes = $_POST['votes'] ?? [];
if (empty($votes)) {
  echo "<script>alert('You must select at least one candidate!'); window.location='ballot.php';</script>";
  exit;
}

try {
  $pdo->beginTransaction();

  // Prepare SQL statement to insert votes
  $insertVote = $pdo->prepare("INSERT INTO votes (user_id, position_id, candidate_id) VALUES (?, ?, ?)");

  // ✅ Prepare log entry insertion
  $insertLog = $pdo->prepare("INSERT INTO logs (user_id, action, target_id, description) VALUES (?, ?, ?, ?)");

  foreach ($votes as $position_id => $candidate_id) {
    // ✅ Insert the vote
    $insertVote->execute([$user_id, $position_id, $candidate_id]);

    // ✅ Fetch candidate & position details for logging
    $stmtCand = $pdo->prepare("
      SELECT c.name AS candidate_name, p.name AS position_name
      FROM candidates c
      JOIN positions p ON c.position_id = p.id
      WHERE c.id = ?
    ");
    $stmtCand->execute([$candidate_id]);
    $details = $stmtCand->fetch();

    $description = "Voted for: {$details['candidate_name']} ({$details['position_name']})";

    // ✅ Insert log entry
    $insertLog->execute([$user_id, 'Vote Cast', $candidate_id, $description]);
  }

  $pdo->commit();

  echo "<script>alert('Your vote(s) have been recorded successfully!'); window.location='thankyou.php';</script>";
} catch (Exception $e) {
  $pdo->rollBack();
  echo "Error: " . $e->getMessage();
}
?>
