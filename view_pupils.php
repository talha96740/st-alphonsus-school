<?php
require 'db.php';

// Get all pupils along with their class
$pupilsQuery = $conn->query("
    SELECT p.pupil_id, p.first_name, p.last_name, p.address, p.medical_info, c.class_name
    FROM pupil p
    LEFT JOIN class c ON p.class_id = c.class_id
");

$pupils = [];
while ($row = $pupilsQuery->fetch_assoc()) {
    $pupils[$row['pupil_id']] = $row;
    $pupils[$row['pupil_id']]['parents'] = [];
}

// Get all parent relationships
$parentLinks = $conn->query("
    SELECT pp.pupil_id, pr.first_name, pr.last_name
    FROM pupil_parent pp
    JOIN parent pr ON pp.parent_id = pr.parent_id
");

while ($link = $parentLinks->fetch_assoc()) {
    $pupils[$link['pupil_id']]['parents'][] = $link['first_name'] . " " . $link['last_name'];
}
?>

    <?php include 'includes/header.php'; ?>

    <h2>All Pupils</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Class</th>
            <th>Address</th>
            <th>Medical Info</th>
            <th>Parents / Guardians</th>
        </tr>
        <?php foreach ($pupils as $pupil): ?>
        <tr>
            <td><?= $pupil['pupil_id'] ?></td>
            <td><?= $pupil['first_name'] . " " . $pupil['last_name'] ?></td>
            <td><?= $pupil['class_name'] ?? 'N/A' ?></td>
            <td><?= $pupil['address'] ?></td>
            <td><?= $pupil['medical_info'] ?></td>
            <td>
                <?php
                    if (empty($pupil['parents'])) {
                        echo "No parent linked";
                    } else {
                        echo implode(", ", $pupil['parents']);
                    }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php include 'includes/footer.php'; ?>
