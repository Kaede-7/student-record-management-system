<?php 
require_once '../../config/db.php';
require_once '../../includes/functions.php';
protect_page('admin');

$today = date('Y-m-d');
$sql = "SELECT * FROM users WHERE role = 'student' ORDER BY full_name ASC";
$result = $conn->query($sql);

include '../../includes/header.php'; 
?>

<div class="dashboard-controls" style="display:flex; justify-content: space-between; align-items:center; margin-bottom: 20px;">
    <div class="status-badge" style="background:#e2e8f0; padding:10px; border-radius:5px; margin-bottom:15px;">
        <i class="fas fa-user-check"></i> 
        Logged in as: <strong>Admin</strong>
    </div>
    <h2>Admin Dashboard</h2>
    <div class="actions">
        <a href="add.php" class="btn btn-add"><i class="fas fa-plus"></i> Add Student</a>
        <a href="../logout.php" class="btn btn-danger" style="margin-left:10px;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="search-area">
    <input type="text" id="studentSearch" placeholder="Search students...">
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
                echo "<tr>";
                echo "<td>" . e($row['full_name']) . "</td>";
                echo "<td>" . e($row['course']) . "</td>";
                echo "<td>" . $row['present_days'] . "</td>";
                echo "<td>" . ($row['last_attendance_date'] ?? 'N/A') . "</td>";
                
                echo "<td>";
                if (!$is_marked_today) {
                    echo "<a href='?action=mark&id={$row['id']}' class='btn btn-p'>Mark Present</a>";
                } else {
                    echo "<span>Completed</span>";
                }
                echo "</td>";

                echo "<td>";
                echo "<a href='edit.php?id={$row['id']}'>Edit</a> | ";
                echo "<a href='delete.php?id={$row['id']}' onclick='return confirm(\"Delete?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>

<script src="../../assets/js/search.js"></script>
<?php include '../../includes/footer.php'; ?>