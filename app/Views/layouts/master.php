<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    
    <style>
        body {
            overflow-x: hidden;
            background-color: #f8f9fa;
        }
        #wrapper {
            display: flex;
            width: 100%;
        }
        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            background-color: #212529;
            transition: all 0.3s ease;
        }
        #sidebar-wrapper .sidebar-heading {
            padding: 1.5rem 1rem;
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            border-bottom: 1px solid #343a40;
        }
        #sidebar-wrapper .list-group-item {
            padding: 0.75rem 1.25rem;
            color: #ced4da;
            border: none;
        }
        #sidebar-wrapper .list-group-item:hover, 
        #sidebar-wrapper .list-group-item.active {
            background-color: #343a40;
            color: #fff;
        }
        #page-content-wrapper {
            width: 100%;
            flex-grow: 1;
        }
        .navbar {
            background-color: #fff !important;
            border-bottom: 1px solid #e3e6f0;
        }
        .pagination-wrapper ul {
        display: flex;
        padding-left: 0;
        list-style: none;
        gap: 10px;
    }
    .pagination-wrapper li a {
        padding: 6px 12px;
        border: 1px solid #dee2e6;
        color: #0d6efd;
        text-decoration: none;
        border-radius: 4px;
    }
    .pagination-wrapper li.active span {
        padding: 6px 12px;
        background-color: #0d6efd;
        color: white;
        border-radius: 4px;
    }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

<div id="wrapper">
    <?php if (session()->get('isLoggedIn')): ?>
        <div id="sidebar-wrapper">
            <div class="sidebar-heading"><i class="fa-solid fa-gauge me-2"></i>Dashboard App</div>
            <div class="list-group list-group-flush">
                <div class="small text-muted px-3 pt-3 pb-1 text-uppercase font-weight-bold" style="font-size: 0.75rem;">Core Modules</div>
                
                <?php if (in_array(session()->get('roleId'), [1, 4])): ?> 
                    <a href="<?= base_url('admin/dashboard') ?>" class="list-group-item list-group-item-action bg-dark text-white active">
                        <i class="fa-solid fa-users me-2"></i> User Management
                    </a>
                <?php endif; ?>

                <a href="<?= base_url('admin/healthcare-assistant') ?>" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fa-solid fa-heart-pulse me-2"></i> AI Assistant
                </a>
                
                <div class="small text-muted px-3 pt-3 pb-1 text-uppercase font-weight-bold" style="font-size: 0.75rem;">Account</div>
                <a href="<?= base_url('logout') ?>" class="list-group-item list-group-item-action bg-dark text-danger">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </a>
            </div>
        </div>
    <?php endif; ?>

    <div id="page-content-wrapper">
        <?php if (session()->get('isLoggedIn')): ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-light py-3 px-4 shadow-sm">
                <div class="container-fluid">
                    <span class="navbar-text text-dark">
                        Welcome back, <strong><?= esc(session()->get('firstName')) ?></strong> 
                        <span class="badge bg-secondary ms-1"><?= esc(session()->get('roleName')) ?></span>
                    </span>
                </div>
            </nav>
        <?php endif; ?>

        <div class="container-fluid p-4">
            <div class="<?= !session()->get('isLoggedIn') ? 'pt-5' : '' ?>">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>