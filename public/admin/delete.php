<?php
require_once '../../config/db.php';
require_once '../../includes/functions.php';
protect_page('admin');

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
header("Location: dashboard.php");
?>