<?php
require_once __DIR__ . '/../header.php'; 

?>

<div id="top"></div>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">View Incidents</h2>
  <a class="btn btn-secondary" href="<?= BASE_URL ?>views/admin/dashboard.php">
    Back to Dashboard
  </a>
</div>

<div class="d-flex gap-2 mb-4">
  <a class="btn btn-outline-primary" href="#unassigned">Unassigned</a>
  <a class="btn btn-outline-primary" href="#assigned">Assigned</a>
</div>

<h3 id="unassigned" class="mt-4">Unassigned Incidents</h3>

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Customer</th>
      <th>Product</th>
      <th>Incident</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($unassigned)): ?>
      <tr><td colspan="3" class="text-center text-muted">No unassigned incidents.</td></tr>
    <?php else: ?>
      <?php foreach ($unassigned as $i): ?>
        <tr>
          <td><?= htmlspecialchars($i['firstName'] . ' ' . $i['lastName']) ?></td>
          <td><?= htmlspecialchars($i['productName']) ?></td>
          <td>
            <strong>ID:</strong> <?= (int)$i['incidentID'] ?><br>
            <strong>Opened:</strong> <?= htmlspecialchars($i['dateOpened']) ?><br>
            <strong>Title:</strong> <?= htmlspecialchars($i['title']) ?><br>
            <strong>Description:</strong> <?= htmlspecialchars($i['description']) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<div class="mb-4">
  <a class="btn btn-sm btn-outline-secondary" href="#top">Back to top</a>
</div>

<h3 id="assigned" class="mt-4">Assigned Incidents</h3>

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Customer</th>
      <th>Product</th>
      <th>Technician</th>
      <th>Incident</th>
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
          <td><?= htmlspecialchars($i['techFirst'] . ' ' . $i['techLast']) ?></td>
          <td>
            <strong>ID:</strong> <?= (int)$i['incidentID'] ?><br>
            <strong>Opened:</strong> <?= htmlspecialchars($i['dateOpened']) ?><br>
            <strong>Closed:</strong> <?= $i['dateClosed'] ? htmlspecialchars($i['dateClosed']) : 'OPEN' ?><br>
            <strong>Title:</strong> <?= htmlspecialchars($i['title']) ?><br>
            <strong>Description:</strong> <?= htmlspecialchars($i['description']) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<div class="mb-4">
  <a class="btn btn-sm btn-outline-secondary" href="#top">Back to top</a>
</div>




<?php if (isset($_SESSION['flash_success'])): ?>
    <script>alert("<?= $_SESSION['flash_success'] ?>");</script>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php require __DIR__ . '/../footer.php'; ?>

