<?php
require 'db.php';

$parents = $conn->query("SELECT * FROM parent");
?>


   
<?php include 'includes/header.php'; ?>

    <h2>All Parents / Guardians</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
        <?php while ($row = $parents->fetch_assoc()): ?>
        <tr>
            <td><?= $row['parent_id'] ?></td>
            <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
            <td><?= $row['address'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phone'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php include 'includes/footer.php'; ?>
