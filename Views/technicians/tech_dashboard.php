<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../header.php';

$pdo = Database::getDB();

?>

<div id="top"></div>

<div class="text-center mb-5">
    <h1 class="fw-bold">My Dashboard</h1>
    <p class="lead text-muted">
        Welcome back <?= htmlspecialchars($_SESSION['user']['name']) ?>! 
    </p>
</div>

<h3 class="mt-4">My Open Incidents</h3>

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Customer</th>
      <th>Product</th>
      <th>Incident</th>
      <th style="width:120px;">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php if (empty($assigned)): ?>
      <tr><td colspan="4" class="text-center text-muted">No assigned incidents.</td></tr>
    <?php else: ?>
      <?php foreach ($assigned as $i): ?>
        <tr>
          <td><?= htmlspecialchars($i['customerFirst'] . ' ' . $i['customerLast']) ?></td>
          <td><?= htmlspecialchars($i['productName']) ?></td>
          <td>
            <strong>ID:</strong> <?= (int)$i['incidentID'] ?><br>
            <strong>Opened:</strong> <?= htmlspecialchars($i['dateOpened']) ?><br>
            <strong>Title:</strong> <?= htmlspecialchars($i['title']) ?><br>
            <strong>Description:</strong> <?= htmlspecialchars($i['description']) ?>
          </td>
          <td>
            <a class="btn btn-sm btn-secondary"
              href="<?= BASE_URL ?>controllers/incident_controller.php?action=store_incident&id=<?= (int)$i['incidentID'] ?>">
              Select
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<div class="mb-4">
  <a class="btn btn-sm btn-outline-secondary" href="#top">Back to top</a>
</div>

<a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-danger">Logout</a>
<a href="../../index.php" class="btn btn-secondary">Back to Home</a> 


<?php require __DIR__ . '/../footer.php'; ?>

