<?php
require 'db.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pupil_id = $_POST['pupil_id'];
    $parent_id = $_POST['parent_id'];

    // Check if already assigned
    $check = $conn->prepare("SELECT * FROM pupil_parent WHERE pupil_id = ? AND parent_id = ?");
    $check->bind_param("ii", $pupil_id, $parent_id);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        $error = "This parent is already linked to the selected pupil.";
    } else {
        $stmt = $conn->prepare("INSERT INTO pupil_parent (pupil_id, parent_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $pupil_id, $parent_id);

        if ($stmt->execute()) {
            $success = "Parent linked to pupil successfully.";
        } else {
            $error = "Error: " . $conn->error;
        }
        $stmt->close();
    }
    $check->close();
}

// Get pupils without parents assigned
$pupils = $conn->query("
    SELECT p.pupil_id, p.first_name, p.last_name 
    FROM pupil p 
    LEFT JOIN pupil_parent pp ON p.pupil_id = pp.pupil_id 
    WHERE pp.pupil_id IS NULL
");

// Get all parents
$parents = $conn->query("SELECT parent_id, first_name, last_name FROM parent");
?>

<?php include 'includes/header.php'; ?>

    <h2>Link Parent to Pupil</h2>

    <?php if ($success): ?>
        <p style="color: green;"><?= $success ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Select Pupil:</label><br>
        <select name="pupil_id" required>
            <option value="">-- Select Pupil --</option>
            <?php while ($p = $pupils->fetch_assoc()): ?>
                <option value="<?= $p['pupil_id'] ?>">
                    <?= htmlspecialchars($p['first_name'] . " " . $p['last_name']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Select Parent:</label><br>
        <select name="parent_id" required>
            <option value="">-- Select Parent --</option>
            <?php while ($r = $parents->fetch_assoc()): ?>
                <option value="<?= $r['parent_id'] ?>">
                    <?= htmlspecialchars($r['first_name'] . " " . $r['last_name']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Assign Parent">
    </form>

    <?php include 'includes/footer.php'; ?>
