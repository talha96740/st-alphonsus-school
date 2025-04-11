<?php
require 'db.php';

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $class_name = htmlspecialchars(trim($_POST['class_name']));
    $capacity = (int) $_POST['capacity'];

    if (empty($class_name) || empty($capacity)) {
        $errors[] = "All fields are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO class (class_name, capacity) VALUES (?, ?)");
        $stmt->bind_param("si", $class_name, $capacity);

        if ($stmt->execute()) {
            $success = "Class added successfully.";
        } else {
            $errors[] = "Error: " . $conn->error;
        }

        $stmt->close();
    }
}
?>
        <?php include 'includes/header.php'; ?>

    <h2>Add New Class</h2>

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
        <label>Class Name:</label><br>
        <input type="text" name="class_name" required><br><br>

        <label>Capacity:</label><br>
        <input type="number" name="capacity" min="1" required><br><br>

        <input type="submit" value="Add Class">
    </form>

    <?php include 'includes/footer.php'; ?>
