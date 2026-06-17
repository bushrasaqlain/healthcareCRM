<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HealthCRM - <?= $pageTitle ?? 'Dashboard' ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"/>
  <style>
    body { background-color: #fff; }
    .navbar { background-color: #134557; overflow: hidden; }
    .card-body { background-color: #134557; }
    .input-light { background-color: #eef2f7 !important; border: none !important; }
    .input-light::placeholder { color: #8a99a8; }
    .input-group-text-light { background-color: #eef2f7 !important; border: none !important; color: #8a99a8 !important; }
    .btn-teal { background-color: #1c4f63; border: none; color: #fff; }
    .btn-teal:hover { background-color: #15404f; color: #fff; }
    .accent-cyan { color: #4fd1c5; }
    .subtitle-muted { color: #a9c2cc; }
    .nav-link.active-tab { color: #4fd1c5 !important; font-weight: 600; }
  </style>
</head>
<body class="text-white min-vh-100 d-flex flex-column">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark border-bottom border-secondary p-3">
    <div class="container-fluid px-4">

      <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('dashboard') ?>">
        <div class="bg-success rounded-3 d-flex align-items-center justify-content-center" style="width:34px; height:34px;">
          <i class="ti ti-heart-plus text-white"></i>
        </div>
        <span class="fw-semibold">Health<span class="text-success">CRM</span></span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3 text-white">
          <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center gap-1 <?= ($activePage ?? '') === 'lablist' ? 'active-tab' : '' ?>" href="<?= base_url('lablist') ?>">
              Lab List
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center gap-1 <?= ($activePage ?? '') === 'register' ? 'active-tab' : '' ?>" href="<?= base_url('registerform') ?>">
              Register
            </a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-3">
          <span class="text-white small">
            <i class="ti ti-user-circle me-1"></i>
            <?= session()->get('user_name') ?>
          </span>
          <a href="<?= base_url('auth/logout') ?>" class="btn btn-info btn-sm d-flex align-items-center gap-1">
            <i class="ti ti-logout"></i> Logout
          </a>
        </div>
      </div>

    </div>
  </nav>

  <!-- Page content starts -->