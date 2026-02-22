<?php
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';
require_once __DIR__ . '/../header.php';
?>


<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Incident Created</h2>
</div>

<p>The incident has been successfully created.</p>

 <div class="d-flex gap-2 mt-3">
  <a href="../../index.php" class="btn btn-secondary">Back to Home</a>
  <a href="create_incident.php" class="btn btn-primary">Create Another Incident</a>
</div>  

<?php require __DIR__ . '/../footer.php'; ?>
