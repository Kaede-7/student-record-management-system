<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$token = $_SESSION['csrf_token'];
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $token) {
        die("Security Error: CSRF Mismatch");
    }

    $full_name = trim($_POST['full_name']);
    $username  = trim($_POST['username']);
    $course    = trim($_POST['course']);
    $password  = $_POST['password'];

    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $error = "Username already taken. Please choose another.";
    } else {
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
        $role = 'student';
        
        $stmt = $conn->prepare("INSERT INTO users (username, password, full_name, course, role, present_days) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("sssss", $username, $hashed_pw, $full_name, $course, $role);
        
        if ($stmt->execute()) {
            header("Location: dashboard.php?msg=added");
            exit();
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}

include '../../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Students</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    
    <div class="form-container">
        <h2>Add New Student</h2>
    
        <?php if ($error): ?>
            <p class="error-msg" style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
    
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
    
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="full_name" required>
            </div>
    
            <div class="form-group">
                <label>Username (for login):</label>
                <input type="text" name="username" required>
            </div>
    
            <div class="form-group">
                <label>Course:</label>
                <input type="text" name="course" required>
            </div>
    
            <div class="form-group">
                <label>Default Password:</label>
                <input type="password" name="password" required>
            </div>
    
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Student</button>
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php include '../../includes/footer.php'; ?>