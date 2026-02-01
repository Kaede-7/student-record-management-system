<?php
require_once '../../config/db.php';
require_once '../../includes/functions.php';
protect_page('admin');

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) die("CSRF validation failed");

    $stmt = $conn->prepare("UPDATE users SET full_name = ?, course = ?, present_days = ? WHERE id = ?");
    $stmt->bind_param("ssii", $_POST['full_name'], $_POST['course'], $_POST['present_days'], $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$s = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h2>Edit Student Record</h2>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        
        <label>Full Name:</label>
        <input type="text" name="full_name" value="<?= e($s['full_name']) ?>" required>
        
        <label>Course:</label>
        <input type="text" name="course" value="<?= e($s['course']) ?>">
        
        <label>Present Days(Manual Edit):</label>
        <input type="number" name="present_days" value="<?= $s['present_days'] ?>" min="0">
        
        <button type="submit">Update Record</button>
        <a href="dashboard.php">Cancel</a>
    </form>
</body>
</html>