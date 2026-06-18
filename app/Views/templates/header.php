<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Health+ - <?= $pageTitle ?? 'Dashboard' ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"/>
    <link rel="stylesheet" href="<?= base_url('/assets/css/base.css') ?>">
</head>
<body class="text-white min-vh-100 d-flex flex-column">

  <!-- Navbar -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark border-bottom border-secondary p-3">
  <div class="container-fluid px-4">

    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('dashboard') ?>">
      
      <span class="fw-semibold text-danger">Infinity<span class="text-primary">Healthcare</span></span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3 text-black">
        <?php 
        $userRole = session()->get('user_role'); 
        $activePage = $activePage ?? '';
        ?>
        
        <!-- Show Dashboard for both roles -->
     
        <!-- Show Lab List and Register only for Admin -->
        <?php if ($userRole === 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link text-black d-flex align-items-center gap-1 <?= $activePage === 'lablist' ? 'active-tab' : '' ?>" href="<?= base_url('lablist') ?>">
               Lab List
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary FE-BOLD d-flex align-items-center gap-1 <?= $activePage === 'register' ? 'active-tab' : '' ?>" href="<?= base_url('registerform') ?>">
               Register
            </a>
          </li>
        <?php endif; ?>

        <!-- You can add role-specific menu items here -->
        <?php if ($userRole === 'lab'): ?>
             <li class="nav-item">
          <a class="nav-link text-dark d-flex align-items-center gap-1 <?= $activePage === 'dashboard' ? 'active-tab' : '' ?>" href="<?= base_url('labDashboard/dashboard') ?>">
            <i class="ti ti-dashboard"></i> Dashboard
          </a>
        </li>

          <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center gap-1 <?= $activePage === 'tests' ? 'active-tab' : '' ?>" href="<?= base_url('tests') ?>">
              <i class="ti ti-flask"></i> Tests
            </a>
          </li>
        
        <?php endif; ?>
      </ul>

      <div class="d-flex align-items-center gap-3">
        <span class="text-black small">
          <i class="ti ti-user-circle me-1"></i>
          <?= session()->get('user_name') ?>
         
        </span>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-sm d-flex align-items-center gap-1">
          <i class="ti ti-logout"></i> Logout
        </a>
      </div>
    </div>

  </div>
</nav>

  <!-- Page content starts -->