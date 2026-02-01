<?php 
require_once '../../config/db.php';
require_once '../../includes/functions.php';
require_once '../../includes/header.php';

protect_page('admin');

$today = date('Y-m-d');

if(isset($_GET['action']) && $_GET['action'] == 'mark' && isset($_GET['id'])){
    $id = intval($_GET['id']);
    
    $upd = $conn->prepare("UPDATE users SET present_days = present_days + 1, last_attendance_date = ? WHERE id = ? AND (last_attendance_date != ? OR last_attendance_date IS NULL)");
    $upd->bind_param("sis", $today, $id, $today);
    $upd->execute();
    
    header("Location: dashboard.php");
    exit;
}

$sql = "SELECT * FROM users WHERE role = 'student' ORDER BY full_name ASC";
$result = $conn->query($sql);
?>

<div class="card">
    <div style="display:flex; justify-content: space-between; align-items:center; margin-bottom: 20px;">
        <h2><i class="fas fa-clipboard-list"></i> Student Attendance Records</h2>
        <a href="add.php" class="btn btn-add"><i class="fas fa-plus"></i> Add New Student</a>
    </div>

    <div style="position: relative; margin-bottom: 20px;">
        <input type="text" id="studentSearch" placeholder="Type a name or course to filter the list below...">
    </div>

    <div class="table-container">
        <table id="studentTable">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Full Name</th>
                    <th><i class="fas fa-book"></i> Course</th>
                    <th><i class="fas fa-check-circle"></i> Attendance</th>
                    <th><i class="fas fa-calendar-alt"></i> Last Marked</th>
                    <th><i class="fas fa-hand-pointer"></i> Mark Status</th> <th><i class="fas fa-user-cog"></i> Management</th> </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $is_marked_today = ($row['last_attendance_date'] === $today);
                        
                        echo "<tr>";
                        echo "<td><strong>" . e($row['full_name']) . "</strong></td>";
                        echo "<td>" . e($row['course']) . "</td>";
                        echo "<td><span class='badge'>" . $row['present_days'] . " Days</span></td>";
                        echo "<td>" . ($row['last_attendance_date'] ?? '<span style="color:#999">No Record</span>') . "</td>";
                        
                        echo "<td>";
                        if (!$is_marked_today) {
                            echo "<a href='?action=mark&id={$row['id']}' class='btn btn-p' style='font-size:0.8rem;'><i class='fas fa-check'></i> Mark Present</a>";
                        } else {
                            echo "<span style='color:var(--success); font-weight:600; font-size:0.85rem;'><i class='fas fa-calendar-check'></i> Completed</span>";
                        }
                        echo "</td>";

                        echo "<td>";
                        echo "<a href='edit.php?id={$row['id']}' class='action-icon edit' title='Edit'><i class='fas fa-edit'></i> Edit</a>";
                        echo "<a href='delete.php?id={$row['id']}' class='action-icon delete' title='Delete' onclick='return confirm(\"Are you sure you want to delete this record?\")' style='margin-left:15px;'><i class='fas fa-trash'></i> Delete</a>";
                        echo "</td>";
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>No student records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>