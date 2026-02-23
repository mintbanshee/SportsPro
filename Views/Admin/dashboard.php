<?php 
declare(strict_types=1); 

require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../auth/require_admin.php'; 
require_once __DIR__ . '/../header.php';

?>

<div class="text-center mb-5">
    <h1 class="fw-bold">Admin Dashboard</h1>
    <p class="lead text-muted">
        Welcome <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin') ?>! 
    </p>
</div>

<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">System Administration</h4>
    </div>
    <div class="card-body">
    <div class="list-group list-group-flush">
        <a href="<?= BASE_URL ?>controllers/product_controller.php?action=manage_products" 
            class="list-group-item list-group-item-action">
            Manage Products
        </a>

        <a href="<?= BASE_URL ?>controllers/technician_controller.php?action=manage_technicians" 
            class="list-group-item list-group-item-action">
            Manage Technicians
        </a>

        <a href="<?= BASE_URL ?>controllers/customer_controller.php?action=manage_customers"
            class="list-group-item list-group-item-action">
            Manage Customers
        </a>

        <a href="<?= BASE_URL ?>/views/admin/create_incident.php" 
            class="list-group-item list-group-item-action">
            Create Incident
        </a>

        <a href="<?= BASE_URL ?>controllers/incident_controller.php?action=select_incident" 
            class="list-group-item list-group-item-action">
            Assign Incident
        </a>

        <a href="<?= BASE_URL ?>controllers/incident_controller.php?action=display_incidents"
            class="list-group-item list-group-item-action">
            Display Incidents
        </a>

    </div>
</div>

</div>


<div class="d-flex gap-2">
  <a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-danger">Logout</a>
  <a href="../../index.php" class="btn btn-secondary">Back to Home</a> 
  <a href="<?= BASE_URL ?>/views/customers/index.php" class="btn btn-primary">My Account</a> 
</div>

<?php require __DIR__ . '/../footer.php'; ?>

