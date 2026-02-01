<?php 
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

include '../../includes/header.php'; 
?>

<div class="profile-card">
    <div class="status-badge">
        <i class="fas fa-user-check"></i> 
        Logged in as: <strong>Student</strong>
    </div>

    <h1>Student Profile</h1>
    
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['full_name'], ENT_QUOTES, 'UTF-8'); ?></p>
    <p><strong>Course:</strong> <?php echo htmlspecialchars($user['course'], ENT_QUOTES, 'UTF-8'); ?></p>
    <p><strong>Attendance:</strong> <?php echo (int)$user['present_days']; ?> Days</p>

    <div class="profile-actions">
        <a href="../logout.php" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>