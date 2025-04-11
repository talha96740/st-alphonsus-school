<?php
require 'db.php';

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Clean input
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $address = htmlspecialchars(trim($_POST['address']));
    $medical_info = htmlspecialchars(trim($_POST['medical_info']));
    $class_id = $_POST['class_id'];

    // Basic validation
    if (empty($first_name) || empty($last_name) || empty($address) || empty($class_id)) {
        $errors[] = "Please fill in all required fields.";
    } else {
        // Insert into DB
        $stmt = $conn->prepare("INSERT INTO pupil (first_name, last_name, address, medical_info, class_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $first_name, $last_name, $address, $medical_info, $class_id);

        if ($stmt->execute()) {
            $success = "Pupil added successfully.";
        } else {
            $errors[] = "Error: " . $conn->error;
        }
        $stmt->close();
    }
}

// Fetch classes
$class_result = $conn->query("SELECT class_id, class_name FROM class");
?>
<?php include 'includes/header.php'; ?>
<h2>Add New Pupil</h2>

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

        <label>Medical Info:</label><br>
        <textarea name="medical_info"></textarea><br><br>

        <label>Class:</label><br>
        <select name="class_id" required>
            <option value="">-- Select Class --</option>
            <?php while ($row = $class_result->fetch_assoc()): ?>
                <option value="<?= $row['class_id'] ?>"><?= $row['class_name'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Add Pupil">
    </form>

    <?php include 'includes/footer.php'; ?>
