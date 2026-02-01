<?php 
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$today = date('Y-m-d');
$token = $_SESSION['csrf_token']; 

if (isset($_GET['action']) && $_GET['action'] == 'mark' && isset($_GET['id'])) {
    if (!isset($_GET['token']) || $_GET['token'] !== $token) {
        die("Security Error: Invalid CSRF Token.");
    }

    $id = intval($_GET['id']);
    
    $stmt = $conn->prepare("UPDATE users SET present_days = present_days + 1, last_attendance_date = ? WHERE id = ? AND (last_attendance_date != ? OR last_attendance_date IS NULL)");
    $stmt->bind_param("sis", $today, $id, $today);
    $stmt->execute();
    
    header("Location: dashboard.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'unmark' && isset($_GET['id'])) {
    if (!isset($_GET['token']) || $_GET['token'] !== $token) {
        die("Security Error: Invalid CSRF Token.");
    }

    $id = intval($_GET['id']);
    
    $stmt = $conn->prepare("UPDATE users SET present_days = present_days - 1, last_attendance_date = NULL WHERE id = ? AND last_attendance_date = ?");
    $stmt->bind_param("is", $id, $today);
    $stmt->execute();
    
    header("Location: dashboard.php");
    exit;
}

$sql = "SELECT * FROM users WHERE role = 'student' ORDER BY full_name ASC";
$result = $conn->query($sql);

include '../../includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    
    <div class="dashboard-controls" style="display:flex; justify-content: space-between; align-items:center; margin-bottom: 20px;">
        <div class="status-badge" style="background:#e2e8f0; padding:10px; border-radius:5px;">
            <i class="fas fa-user-check"></i> 
            Logged in as: <strong>Admin</strong>
        </div>
        <h2>Admin Dashboard</h2>
        <div class="actions">
            <a href="add.php" class="btn btn-add"><i class="fas fa-plus"></i> Add Student</a>
            <a href="../logout.php" class="btn btn-danger" style="margin-left:10px;"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div class="search-area" style="margin-bottom: 20px;">
        <input type="text" id="studentSearch" placeholder="Search students by name or course..." style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
    </div>
    
    <table id="studentTable">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Course</th>
                <th>Attendance</th>
                <th>Last Marked</th>
                <th>Mark Status</th>
                <th>Management</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $is_marked_today = ($row['last_attendance_date'] === $today);
                    
                    $safe_name = htmlspecialchars($row['full_name'], ENT_QUOTES, 'UTF-8');
                    $safe_course = htmlspecialchars($row['course'], ENT_QUOTES, 'UTF-8');
    
                    echo "<tr>";
                    echo "<td>" . $safe_name . "</td>";
                    echo "<td>" . $safe_course . "</td>";
                    echo "<td>" . $row['present_days'] . " Days</td>";
                    echo "<td>" . ($row['last_attendance_date'] ?? 'Never') . "</td>";
                    
                    echo "<td>";
                    if (!$is_marked_today) {
                        echo "<a href='?action=mark&id={$row['id']}&token={$token}' class='btn btn-p'>Mark Present</a>";
                    } else {
                        echo "<a href='?action=unmark&id={$row['id']}&token={$token}' class='btn btn-unmark'>Unmark</a>";
                    }
                    echo "</td>";
    
                    echo "<td>";
                    echo "<a href='edit.php?id={$row['id']}' style='color: #2563eb;'>Edit</a> | ";
                    echo "<a href='delete.php?id={$row['id']}&token=" . $_SESSION['csrf_token'] . "' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>No students found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <script src="../../assets/js/search.js"></script>
</body>
</html>

<?php include '../../includes/footer.php'; ?>