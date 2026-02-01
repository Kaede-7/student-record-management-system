<?php
require_once '../../config/db.php';
require_once '../../includes/functions.php';
protect_page('admin');

// Handle attendance increment
if (isset($_GET['mark']) && isset($_GET['id'])) {
    $col = ($_GET['mark'] == 'p') ? 'present_days' : 'absent_days';
    $stmt = $conn->prepare("UPDATE users SET $col = $col + 1 WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    header("Location: dashboard.php");
}

$students = $conn->query("SELECT * FROM users WHERE role = 'student'");
?>
<h2>Admin Dashboard</h2>
<input type="text" id="studentSearch" placeholder="Search students (AJAX)...">
<div id="results" style="border:1px solid #ccc; width:200px; display:none;"></div>

<table border="1" width="100%">
    <tr>
        <th>Name</th><th>Course</th><th>Present</th><th>Absent</th><th>Actions</th>
    </tr>
    <?php while($s = $students->fetch_assoc()): ?>
    <tr>
        <td><?= e($s['full_name']) ?></td>
        <td><?= e($s['course']) ?></td>
        <td><?= $s['present_days'] ?></td>
        <td><?= $s['absent_days'] ?></td>
        <td>
            <a href="?mark=p&id=<?= $s['id'] ?>">+Present</a> | 
            <a href="?mark=a&id=<?= $s['id'] ?>">+Absent</a> |
            <a href="edit.php?id=<?= $s['id'] ?>">Edit</a> | 
            <a href="delete.php?id=<?= $s['id'] ?>" onclick="return confirm('Confirm delete?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<script>
document.getElementById('studentSearch').addEventListener('input', function() {
    let term = this.value;
    let resDiv = document.getElementById('results');
    if(term.length > 1) {
        fetch(`../search_ajax.php?term=${term}`)
            .then(res => res.json())
            .then(data => {
                resDiv.style.display = 'block';
                resDiv.innerHTML = data.map(n => `<div style='padding:5px;'>${n}</div>`).join('');
            });
    } else { resDiv.style.display = 'none'; }
});
</script>