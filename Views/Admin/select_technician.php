<?php
require_once __DIR__ . '/../header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Assign Incident</h2>
</div>
<p class="text-muted mb-3">
  Step 2 of 3: Select a technician to assign the incident to 
</p>

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Technician</th>
      <th>Open Incidents</th>
      <th style="width:120px;">Actions</th>
    </tr>
  </thead>
<tbody>
<?php foreach ($technicians as $t): ?>
  <tr>
    <td><?= htmlspecialchars($t['firstName'] . ' ' . $t['lastName']) ?></td>
    <td><?= (int)$t['openIncidents'] ?></td>
    <td>
      <a class="btn btn-sm btn-secondary"
         href="<?= BASE_URL ?>controllers/incident_controller.php?action=store_technician&id=<?= (int)$t['techID'] ?>">
        Select
      </a>
    </td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>

<a href="<?= BASE_URL ?>controllers/incident_controller.php?action=select_incident" class="btn btn-secondary">Back</a>
<!-- <a class="btn btn-primary"
    href="<?= BASE_URL ?>controllers/customer_controller.php?action=add_customer&lastName=<?= urlencode($lastName ?? '') ?>">
    Add New Customer
</a> -->

<?php require __DIR__ . '/../footer.php'; ?>

