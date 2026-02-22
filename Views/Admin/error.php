<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

require_once __DIR__ . '/../header.php';

$title = "Error";
$detail = "An unknown error occurred.";

if (isset($_SESSION['error_message'])) {
    $title = "Type Error";
    $detail = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
} else {
  $msg = $_GET['msg'] ?? 'unknown';

  if ($msg === 'required') {
    $title = "Required Field Missing";
    $detail = "A required field was not entered. Please go back and fill in all text boxes.";
  } elseif ($msg === 'exists') {
    $title = "Duplicate Product Code";
    $detail = "A product with that code already exists. Please choose a different code.";
  } elseif ($msg === 'invalid') {
    $title = "Invalid Request";
    $detail = "The request was invalid. Please try again.";
  }
}

?>

<h2 class="text-danger"><?= htmlspecialchars($title) ?></h2>
<p><?= htmlspecialchars($detail) ?></p>

<div class="mt-4">
  <button onclick="history.back()" class="btn btn-secondary">Go Back</button> 
  <!-- onclick takes the user back to their previous pafe -->  

  <a href="<?= BASE_URL ?>index.php" class="btn btn-primary">Return to Home</a>
</div>

<?php require __DIR__ . '/../footer.php'; ?>
