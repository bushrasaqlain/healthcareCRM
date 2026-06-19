<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Infinity+ - <?= $pageTitle ?? 'Dashboard' ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"/>
  <link rel="stylesheet" href="<?= base_url('/assets/css/base.css') ?>">
</head>
<body class="text-white min-vh-100 d-flex flex-column">

  <!-- Navbar -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid px-4">

<a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('dbadmin/dashboard') ?>">
  <div class="d-flex flex-column" style="line-height:1;">
    <img src="<?= base_url('assets/images/12.png') ?>" alt="Infinity Healthcare" height="60" width="140"/>
    <small style="font-size:11px; color:#000; letter-spacing:0.5px; margin:2px;">by infinityhealthpk.com</small>
  </div>
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <ul class="navbar-nav align-items-center gap-1">
        <?php 
        $userRole  = session()->get('user_role'); 
        $activePage = $activePage ?? '';
        ?>

        <?php if ($userRole === 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link text-dark <?= $activePage === 'lablist' ? 'active-tab' : '' ?>"
               href="<?= base_url('lablist') ?>">Lab List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark <?= $activePage === 'register' ? 'active-tab' : '' ?>"
               href="<?= base_url('registerform') ?>">Register</a>
          </li>
        <?php endif; ?>

        <?php if ($userRole === 'lab'): ?>
             <li class="nav-item">
          <a class="nav-link text-dark d-flex align-items-center gap-1 <?= $activePage === 'dashboard' ? 'active-tab' : '' ?>" href="<?= base_url('labDashboard/dashboard') ?>">
            <i class="ti ti-dashboard"></i> Dashboard
          </a>
        </li>

         <li class="nav-item">
            <a class="nav-link text-dark d-flex align-items-center gap-1 <?= $activePage === 'pricelist' ? 'active-tab' : '' ?>" 
              href="<?= base_url('labDashboard/pricelist') ?>">
                <i class="ti ti-list"></i> Price List
            </a>
        </li>

          <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center gap-1 <?= $activePage === 'tests' ? 'active-tab' : '' ?>" href="<?= base_url('tests') ?>">
              <i class="ti ti-flask"></i> Tests
            </a>
          </li>
        <?php endif; ?>

        <!-- Divider -->
        <li class="nav-item ms-2 text-secondary">|</li>

        <li class="nav-item">
          <span class="nav-link text-dark small">
            <i class="ti ti-user-circle me-1"></i><?= session()->get('user_name') ?>
          </span>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('auth/logout') ?>"
             class="btn-new-booking text-white d-flex align-items-center gap-1">
            <i class="ti ti-logout"></i> Logout
          </a>
        </li>

      </ul>
    </div>

  </div>
</nav>

