<?php
declare(strict_types=1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../db/database.php';

// Optional admin guard:
// require __DIR__ . '/../../config/app.php';
// require __DIR__ . '/../../auth/require_admin.php';

$techID = filter_input(INPUT_POST, 'techID', FILTER_VALIDATE_INT);

if (!$techID) {
    header('Location: error.php?msg=invalid');
    exit;
}

$stmt = $db->prepare("DELETE FROM technicians WHERE techID = :id");
$stmt->execute(['id' => $techID]);

header("Location: manage_technicians.php");
exit;
