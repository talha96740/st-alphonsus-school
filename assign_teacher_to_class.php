<?php
require 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];

    // Assign teacher to class
    $stmt = $conn->prepare("UPDATE class SET teacher_id = ? WHERE class_id = ?");
    $stmt->bind_param("ii", $teacher_id, $class_id);

    if ($stmt->execute()) {
        $message = "Teacher assigned successfully!";
    } else {
        $message = "Error assigning teacher: " . $stmt->error;
    }
}

// Get all classes
$classes = $conn->query("SELECT class_id, class_name FROM class");

// Get all teachers
$teachers = $conn->query("SELECT * FROM teacher WHERE teacher_id NOT IN (SELECT teacher_id FROM class WHERE teacher_id IS NOT NULL)");
// $sql = "SELECT * FROM teacher WHERE id NOT IN (SELECT teacher_id FROM class WHERE teacher_id IS NOT NULL)";
?>

<?php include 'includes/header.php'; ?>

    <h2>Assign Teacher to Class</h2>

    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <form method="POST" action="">
        <label>Select Class:</label><br>
        <select name="class_id" required>
            <option value="">-- Select Class --</option>
            <?php while ($class = $classes->fetch_assoc()): ?>
                <option value="<?= $class['class_id'] ?>"><?= $class['class_name'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Select Teacher:</label><br>
        <select name="teacher_id" required>
            <option value="">-- Select Teacher --</option>
            <?php while ($teacher = $teachers->fetch_assoc()): ?>
                <option value="<?= $teacher['teacher_id'] ?>">
                    <?= $teacher['first_name'] . " " . $teacher['last_name'] ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Assign Teacher">
    </form>

    <?php include 'includes/footer.php'; ?>

