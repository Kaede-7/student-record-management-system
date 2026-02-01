<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['token']) || $_GET['token'] !== $_SESSION['csrf_token']) {
    die("Security Error: Invalid CSRF Token. Access Denied.");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'student'");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=deleted");
        exit();
    } else {
        die("Error deleting record: " . $conn->error);
    }
} else {
    header("Location: dashboard.php");
    exit();
}