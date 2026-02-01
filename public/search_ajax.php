<?php
require_once '../config/db.php';
$term = "%" . ($_GET['term'] ?? '') . "%";
$stmt = $conn->prepare("SELECT full_name FROM users WHERE role='student' AND full_name LIKE ? LIMIT 5");
$stmt->bind_param("s", $term);
$stmt->execute();
$result = $stmt->get_result();
$names = [];
while($row = $result->fetch_assoc()) $names[] = $row['full_name'];
echo json_encode($names);
?>