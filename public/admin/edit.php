<?php
session_start();
require_once '../../config/db.php';

// 1. Manual Security Check (Replacing protect_page)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id'] ?? 0);
$token = $_SESSION['csrf_token'];

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manual CSRF Check
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $token) {
        die("CSRF validation failed");
    }

    $full_name = $_POST['full_name'];
    $course = $_POST['course'];
    $present_days = intval($_POST['present_days']);

    $stmt = $conn->prepare("UPDATE users SET full_name = ?, course = ?, present_days = ? WHERE id = ? AND role = 'student'");
    $stmt->bind_param("ssii", $full_name, $course, $present_days, $id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    }
}

// 3. Fetch Student Data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND role = 'student'");
$stmt->bind_param("i", $id);
$stmt->execute();
$s = $stmt->get_result()->fetch_assoc();

// If student doesn't exist, go back
if (!$s) {
    header("Location: dashboard.php");
    exit;
}

include '../../includes/header.php';
?>

<div class="form-container">
    <h2>Edit Student Record</h2>
    
    <form method="POST" class="edit-form">
        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
        
        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" id="full_name" 
                   value="<?php echo htmlspecialchars($s['full_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="course">Course:</label>
            <input type="text" name="course" id="course" 
                   value="<?php echo htmlspecialchars($s['course'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        
        <div class="form-group">
            <label for="present_days">Present Days (Manual Edit):</label>
            <input type="number" name="present_days" id="present_days" 
                   value="<?php echo (int)$s['present_days']; ?>" min="0">
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Record</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>