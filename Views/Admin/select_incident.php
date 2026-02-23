<?php
require_once __DIR__ . '/../header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Assign Incident</h2>
</div>
<p class="text-muted mb-3">
  Step 1 of 3: Select an incident to assign to a technician
</p>

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Customer</th>
      <th>Product</th>
      <th>Date Opened</th>
      <th>Title</th>
      <th>Description</th>
      <th style="width:120px;">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($incidents as $i): ?>
      <tr>
        <td><?= htmlspecialchars($i['firstName'] . ' ' . $i['lastName']) ?></td>
        <td><?= htmlspecialchars($i['productName']) ?></td>
        <td><?= htmlspecialchars($i['dateOpened']) ?></td>
        <td><?= htmlspecialchars($i['title']) ?></td> 
        <td><?= htmlspecialchars($i['description']) ?></td>
        <td>
        <a class="btn btn-sm btn-secondary"
          href="<?= BASE_URL ?>controllers/incident_controller.php?action=store_incident&id=<?= (int)$i['incidentID'] ?>">
          Select
        </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?= BASE_URL ?>index.php" class="btn btn-secondary">Back to Home</a>

<?php if (isset($_SESSION['flash_success'])): ?>
    <script>alert("<?= $_SESSION['flash_success'] ?>");</script>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php require __DIR__ . '/../footer.php'; ?>

