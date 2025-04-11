<?php
require 'db.php';

// Get class info + number of pupils + teacher
$query = $conn->query("
    SELECT 
        c.class_id, 
        c.class_name, 
        c.capacity,
        t.first_name AS teacher_first, 
        t.last_name AS teacher_last,
        COUNT(p.pupil_id) AS pupil_count
    FROM class c
    LEFT JOIN teacher t ON c.teacher_id = t.teacher_id
    LEFT JOIN pupil p ON c.class_id = p.class_id
    GROUP BY c.class_id
");

?>


        <?php include 'includes/header.php'; ?>

    <h2>All Classes</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Class Name</th>
            <th>Capacity</th>
            <th>Enrolled Pupils</th>
            <th>Assigned Teacher</th>
        </tr>
        <?php while ($row = $query->fetch_assoc()): ?>
        <tr>
            <td><?= $row['class_id'] ?></td>
            <td><?= $row['class_name'] ?></td>
            <td><?= $row['capacity'] ?></td>
            <td><?= $row['pupil_count'] ?></td>
            <td>
                <?= $row['teacher_first'] ? $row['teacher_first'] . " " . $row['teacher_last'] : 'Unassigned' ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php include 'includes/footer.php'; ?>

