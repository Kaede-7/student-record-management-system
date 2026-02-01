<?php
require_once '../../config/db.php';
require_once '../../includes/functions.php';
protect_page('admin');

$today = date('Y-m-d');

// Logic to mark attendance once per day
if (isset($_GET['action']) && $_GET['action'] == 'mark' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Check current status
    $stmt = $conn->prepare("SELECT last_attendance_date FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user['last_attendance_date'] !== $today) {
        $update = $conn->prepare("UPDATE users SET present_days = present_days + 1, last_attendance_date = ? WHERE id = ?");
        $update->bind_param("si", $today, $id);
        $update->execute();
        header("Location: dashboard.php?status=success");
        exit;
    }
}

$students = $conn->query("SELECT * FROM users WHERE role = 'student'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h2>Student Record Management</h2>
    
    <div style="margin-bottom: 20px;">
        <a href="add.php" class="add-btn">Add New Student</a>
        <a href="../logout.php" style="margin-left:20px; color:red;">Logout</a>
    </div>

    <input type="text" id="studentSearch" placeholder="Search students..." autocomplete="off">
    <div id="results"></div>

    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Course</th>
                <th>Present Days</th>
                <th>Last Attendance Date</th> <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($s = $students->fetch_assoc()): ?>
            <tr>
                <td><?= e($s['full_name']) ?></td>
                <td><?= e($s['course']) ?></td>
                <td><strong><?= $s['present_days'] ?></strong></td>
                <td><?= $s['last_attendance_date'] ? $s['last_attendance_date'] : '<em style="color:gray;">No record</em>' ?></td>
                <td>
                    <?php if($s['last_attendance_date'] === $today): ?>
                        <button disabled style="background:#ccc; cursor:not-allowed;">Marked Today</button>
                    <?php else: ?>
                        <a href="?action=mark&id=<?= $s['id'] ?>" class="btn-p">Mark Present</a>
                    <?php endif; ?>
                    | <a href="edit.php?id=<?= $s['id'] ?>">Edit</a>
                    | <a href="delete.php?id=<?= $s['id'] ?>" style="color:red;" onclick="return confirm('Delete?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script src="../../assets/js/search.js"></script>
</body>
</html>