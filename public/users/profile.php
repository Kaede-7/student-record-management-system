<?php
require_once '../../config/db.php';
require_once '../../includes/functions.php';
protect_page('student');

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
?>
<h2>My Profile</h2>
<p>Name: <?= e($u['full_name']) ?></p>
<p>Course: <?= e($u['course']) ?></p>
<p>Present: <?= $u['present_days'] ?> | Absent: <?= $u['absent_days'] ?></p>
<a href="../logout.php">Logout</a>