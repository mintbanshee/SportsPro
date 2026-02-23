<?php
declare(strict_types=1);

require_once __DIR__ . '/../header.php';

?>

<h2 class="mb-3">Update Incident</h2>

<div class="card p-3 shadow-sm" style="max-width: 800px;">
  <p><strong>Incident ID:</strong> <?= (int)$incident['incidentID'] ?></p>
  <p><strong>Customer:</strong> <?= htmlspecialchars($incident['customerFirst'] . ' ' . $incident['customerLast']) ?></p>
  <p><strong>Product:</strong> <?= htmlspecialchars($incident['productName']) ?></p>
  <p><strong>Date Opened:</strong> <?= htmlspecialchars($incident['dateOpened']) ?></p>

  <form method="post" action="<?= BASE_URL ?>controllers/incident_controller.php">
    <input type="hidden" name="action" value="save_incident">
    <input type="hidden" name="incident_id" value="<?= (int)$incident['incidentID'] ?>">

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($incident['description'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Date Closed (optional)</label>
      <input type="date" name="dateClosed" class="form-control"
        value="<?= htmlspecialchars($incident['dateClosed'] ?? '') ?>">
    </div>

    <div class="d-flex gap-2">
      <a class="btn btn-secondary" href="<?= BASE_URL ?>controllers/incident_controller.php?action=tech_dashboard">Cancel</a>
      <button class="btn btn-primary" type="submit">Update Incident</button>
    </div>
  </form>
</div>

<?php require __DIR__ . '/../footer.php'; ?>