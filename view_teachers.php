<?php
require 'db.php';

$sql = "SELECT t.teacher_id, t.first_name, t.last_name, t.address, t.phone, t.salary, t.background_check, c.class_name
        FROM teacher t
        LEFT JOIN class c ON t.class_id = c.class_id
        ORDER BY t.teacher_id DESC";

$result = $conn->query($sql);
?>

<?php include 'includes/header.php'; ?>

    <h2>All Teachers</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Class</th>
            <th>Phone</th>
            <th>Salary</th>
            <th>Background Check</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['teacher_id'] ?></td>
                    <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                    <td><?= $row['class_name'] ?? 'Unassigned' ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td>£<?= number_format($row['salary'], 2) ?></td>
                    <td><?= $row['background_check'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No teachers found.</td></tr>
        <?php endif; ?>
    </table>

    <?php include 'includes/footer.php'; ?>

