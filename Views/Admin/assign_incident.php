<?php 
require_once __DIR__ . '/../header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Assign Incident</h2>
</div>
<p class="text-muted mb-3">
  Step 3 of 3: Finalize assigning the incident to the technician 
</p>

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Customer</th>
      <th>Product</th>
      <th>Title</th>
      <th>Technician</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?= htmlspecialchars($incident['firstName'] . ' ' . $incident['lastName']) ?></td>
      <td><?= htmlspecialchars($incident['productName']) ?></td>
      <td><?= htmlspecialchars($incident['title']) ?></td>
      <td><?= htmlspecialchars($technician['firstName'] . ' ' . $technician['lastName']) ?></td>
    </tr>
  </tbody>
</table>

<a href="<?= BASE_URL ?>controllers/incident_controller.php?action=select_incident" class="btn btn-secondary">
  Cancel
</a>
<a class="btn btn-primary"
  href="<?= BASE_URL ?>controllers/incident_controller.php?action=update_incident">
  Assign Incident
</a>

<?php require __DIR__ . '/../footer.php'; ?>