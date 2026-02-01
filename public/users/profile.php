<?php 
require_once '../../config/db.php';
require_once '../../includes/functions.php';
protect_page('student');

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

include '../../includes/header.php'; 
?>

<div class="profile-card">
    <div class="status-badge" style="background:#e2e8f0; padding:10px; border-radius:5px; margin-bottom:15px;">
        <i class="fas fa-user-check"></i> 
        Logged in as: <strong>Student</strong>
    </div>

    <h1>Student Profile</h1>
    <p><strong>Name:</strong> <?= e($user['full_name']) ?></p>
    <p><strong>Course:</strong> <?= e($user['course']) ?></p>
    <p><strong>Attendance:</strong> <?= $user['present_days'] ?> Days</p>

    <div style="margin-top:20px;">
        <a href="../logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>