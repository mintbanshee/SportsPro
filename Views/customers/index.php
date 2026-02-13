<?php
declare(strict_types=1);

require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../../config/app.php';
require __DIR__ . '/../../auth/require_login.php'; 

?>

<!doctype html> 
<html> 
<head><meta charset="utf-8"><title>My Account</title></head> 
<body> 
<h1>My Account</h1> 

<p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user']['email']) ?></p> 
<p><strong>Role:</strong> <?= htmlspecialchars($_SESSION['user']['role']) ?></p> 
<p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['user']['name'] ?: '—') ?></p> 

<?php if ($_SESSION['user']['role'] === 'admin'): ?> 
<p><a href="<?= BASE_URL ?>/views/admin/dashboard.php">Go to Admin Dashboard</a></p> 
<?php endif; ?> 

<p><a href="<?= BASE_URL ?>/auth/logout.php">Logout</a></p> 
</body> 
</html> 