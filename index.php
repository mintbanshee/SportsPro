
<?php
require __DIR__ . '/views/header.php';
?>

<!-- PAGE HEADER -->
<div class="text-center mb-5">
    <h1 class="fw-bold">SportsPro Technical Support</h1>
    <p class="lead text-muted">
        Sports management software for the sports enthusiast <!-- changed to match assignment sheet --> 
    </p>
</div>

<!-- ADMINISTRATORS -->
<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Administrators</h4>
    </div>
    <div class="card-body">
    <div class="list-group list-group-flush">
        <a href="<?= $base_url ?>/views/admin/manage_products.php" 
            class="list-group-item list-group-item-action">
            Manage Products
        </a>

        <a href="<?= $base_url ?>/views/admin/manage_technicians.php" 
            class="list-group-item list-group-item-action">
            Manage Technicians
        </a>

        <a href="<?= $base_url ?>/views/admin/manage_customers.php" 
            class="list-group-item list-group-item-action">
            Manage Customers
        </a>

        

        <a href="incidents/create_incident.php" class="list-group-item list-group-item-action">
            Create Incident
        </a>

        <a href="incidents/assign_incident.php" class="list-group-item list-group-item-action">
            Assign Incident
        </a>

        <a href="incidents/index.php" class="list-group-item list-group-item-action">
            Display Incidents
        </a>

    </div>
</div>

</div>

<!-- TECHNICIANS -->
<div class="card shadow mb-4">
    <div class="card-header bg-warning">
        <h4 class="mb-0">Technicians</h4>
    </div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            <a href="technicians/update_incident.php"
               class="list-group-item list-group-item-action">
                Update Incident
            </a>
        </div>
    </div>
</div>

<!-- CUSTOMERS -->
<div class="card shadow mb-5">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0">Customers</h4>
    </div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            <a href="registrations/register_product.php"
               class="list-group-item list-group-item-action">
                Register Product
            </a>
        </div>
    </div>
</div>

<?php include 'views/footer.php'; ?>
