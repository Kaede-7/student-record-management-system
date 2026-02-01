<?php
    session_start();
    include "../config/db.php";
    include "../includes/header.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    var_dump($res);

    if ($res && password_verify($_POST['password'], $res['password'])) {
        $_SESSION['user_id'] = $res['id'];
        $_SESSION['role'] = $res['role'];
        header("Location: " . ($res['role'] == 'admin' ? 'admin/dashboard.php' : 'users/profile.php'));
    } else {
        $error = "Invalid credentials";
        echo $error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Record Management System | Login Page</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <form method="POST">
    <h2>Login</h2>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
</body>
</html>

<?php
    include "../includes/footer.php";
?>