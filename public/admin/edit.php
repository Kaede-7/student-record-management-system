<?php
require_once '../../config/db.php';
require_once '../../includes/functions.php';
protect_page('admin');

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE users SET full_name=?, course=? WHERE id=?");
    $stmt->bind_param("ssi", $_POST['full_name'], $_POST['course'], $id);
    $stmt->execute();
    header("Location: dashboard.php");
}
$s = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
?>
<form method="POST">
    <input type="text" name="full_name" value="<?= e($s['full_name']) ?>"><br>
    <input type="text" name="course" value="<?= e($s['course']) ?>"><br>
    <button type="submit">Update</button>
</form>