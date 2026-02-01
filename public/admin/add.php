<?php
require_once '../../config/db.php';
require_once '../../includes/functions.php';
protect_page('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) die("CSRF Error");
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, full_name, course) VALUES (?, ?, 'student', ?, ?)");
    $stmt->bind_param("ssss", $_POST['username'], $pass, $_POST['full_name'], $_POST['course']);
    $stmt->execute();
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Page</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <form method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="text" name="full_name" placeholder="Full Name" required><br>
    <input type="text" name="course" placeholder="Course"><br>
    <button type="submit">Add Student</button>
</form>
</body>
</html>
