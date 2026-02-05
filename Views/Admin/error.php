<?php
require __DIR__ . '/../header.php';

$msg = $_GET['msg'] ?? 'unknown';

$title = "Error";
$detail = "An unknown error occurred.";

if ($msg === 'required') {
  $title = "Required Field Missing";
  $detail = "A required field was not entered. Please go back and fill in all text boxes.";
} elseif ($msg === 'invalid') {
  $title = "Invalid Request";
  $detail = "The request was invalid. Please try again.";
}
?>

<h2 class="text-danger"><?= htmlspecialchars($title) ?></h2>
<p><?= htmlspecialchars($detail) ?></p>

<a href="manage_technicians.php" class="btn btn-secondary">Back to Technicians</a>

<?php require __DIR__ . '/../footer.php'; ?>
