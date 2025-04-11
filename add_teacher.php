<?php
require 'db.php';

$success = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $salary = $_POST['salary'];
    $background_check = $_POST['background_check'];
    $class_id = $_POST['class_id'];

    // Insert the teacher
    $stmt = $conn->prepare("INSERT INTO teacher (first_name, last_name, address, phone, salary, background_check) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $first_name, $last_name, $address, $phone, $salary, $background_check);

    if ($stmt->execute()) {
        $teacher_id = $stmt->insert_id;

        // Assign teacher to the selected class
        $update = $conn->prepare("UPDATE class SET teacher_id = ? WHERE class_id = ?");
        $update->bind_param("ii", $teacher_id, $class_id);
        if ($update->execute()) {
            $success = "Teacher added and assigned to class.";
        } else {
            $error = "Failed to assign teacher to class: " . $conn->error;
        }

        $update->close();
    } else {
        $error = "Failed to insert teacher: " . $conn->error;
    }

    $stmt->close();
}

// Fetch only classes with no assigned teacher
$class_query = "
   SELECT c.class_id, c.class_name 
FROM class c 
WHERE c.teacher_id IS NULL
";
$class_result = $conn->query($class_query);
?>

<?php include 'includes/header.php'; ?>

    <h2>Add New Teacher</h2>

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

        <label>Phone:</label><br>
        <input type="text" name="phone"><br><br>

        <label>Salary (£):</label><br>
        <input type="number" name="salary" step="0.01"><br><br>

        <label>Background Check Info:</label><br>
        <textarea name="background_check"></textarea><br><br>

        <label>Assign to Class:</label><br>
        <select name="class_id" required>
            <option value="">-- Select Class --</option>
            <?php while ($row = $class_result->fetch_assoc()): ?>
                <option value="<?= $row['class_id'] ?>"><?= $row['class_name'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Add Teacher">
    </form>

    <?php include 'includes/footer.php'; ?>
