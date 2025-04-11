<?php
require 'db.php';

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $address = htmlspecialchars(trim($_POST['address']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));

    if (empty($first_name) || empty($last_name) || empty($address)) {
        $errors[] = "Please fill in all required fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO parent (first_name, last_name, address, email, phone)
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $address, $email, $phone);

        if ($stmt->execute()) {
            $success = "Parent/Guardian added successfully.";
        } else {
            $errors[] = "Error: " . $conn->error;
        }

        $stmt->close();
    }
}
?>

<?php include 'includes/header.php'; ?>

    <h2>Add New Parent / Guardian</h2>

    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $e): ?>
                <li><?= $e ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color: green;"><?= $success ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>First Name:</label><br>
        <input type="text" name="first_name" required><br><br>

        <label>Last Name:</label><br>
        <input type="text" name="last_name" required><br><br>

        <label>Address:</label><br>
        <textarea name="address" required></textarea><br><br>

        <label>Email:</label><br>
        <input type="email" name="email"><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone"><br><br>

        <input type="submit" value="Add Parent / Guardian">
    </form>

    <?php include 'includes/footer.php'; ?>
