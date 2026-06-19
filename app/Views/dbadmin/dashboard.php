<?= view('templates/header', ['pageTitle' => 'Dashboard', 'activePage' => 'dashboard']) ?>

<div class="flex-grow-1 py-5" style="background:#f0f4f8;">
  <div class="container">

    <!-- Welcome Section -->
    <div class="text-center mb-5">
      <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle"
           style="width:70px; height:70px; background:linear-gradient(135deg, #c9140e, #8B0000);">
        <i class="ti ti-home-2 text-white" style="font-size:32px;"></i>
      </div>
      <h1 class="fw-bold mb-1" style="color:#1a3a6b; font-family:'Poppins',sans-serif; font-size:28px;">
        Welcome back, <span style="color:#c9140e;"><?= session()->get('user_name') ?></span> 👋
      </h1>
      <p style="color:#6b7280; font-size:14px;">
        Logged in as <span class="fw-semibold" style="color:#1a3a6b;"><?= session()->get('user_role') ?></span>
      </p>
    </div>

    <!-- Stat card1s -->
    <?php
      $db        = \Config\Database::connect();
      $labCount  = $db->table('labs')->countAllResults();
      $testCount = $db->table('lab_tests')->countAllResults();
      $phleCount = $db->table('phlebotomists')->countAllResults();
    ?>

    <div class="row g-4 mb-5">

      <div class="col-md-4">
        <div class="card1 border-0 shadow-sm rounded-4 p-3">
          <div class="card1-body d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center"
                 style="width:56px; height:56px; background:#eef2f7; min-width:56px;">
              <i class="ti ti-flask" style="font-size:26px; color:#1a3a6b;"></i>
            </div>
            <div>
              <div class="fw-bold" style="font-size:28px; color:#1a3a6b;"><?= $labCount ?></div>
              <div style="color:#6b7280; font-size:14px;">Registered Labs</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card1 border-0 shadow-sm rounded-4 p-3">
          <div class="card1-body d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center"
                 style="width:56px; height:56px; background:#fdeaea; min-width:56px;">
              <i class="ti ti-test-pipe" style="font-size:26px; color:#c9140e;"></i>
            </div>
            <div>
              <div class="fw-bold" style="font-size:28px; color:#c9140e;"><?= $testCount ?></div>
              <div style="color:#6b7280; font-size:14px;">Total Tests</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card1 border-0 shadow-sm rounded-4 p-3">
          <div class="card1-body d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center"
                 style="width:56px; height:56px; background:#e8f0fb; min-width:56px;">
              <i class="ti ti-users" style="font-size:26px; color:#2463c2;"></i>
            </div>
            <div>
              <div class="fw-bold" style="font-size:28px; color:#2463c2;"><?= $phleCount ?></div>
              <div style="color:#6b7280; font-size:14px;">Phlebotomists</div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Quick Actions -->
    <?php if (session()->get('user_role') === 'admin'): ?>
    <div class="row g-4">

      <div class="col-md-6">
        <a href="<?= base_url('lablist') ?>" class="text-decoration-none">
          <div class="card11 border-0 shadow-sm rounded-4 p-4 h-100"
               style="border-left: 4px solid #1a3a6b !important;">
            <div class="d-flex align-items-center gap-3">
              <div class="rounded-3 d-flex align-items-center justify-content-center"
                   style="width:50px; height:50px; background:#eef2f7; min-width:50px;">
                <i class="ti ti-list" style="font-size:22px; color:#1a3a6b;"></i>
              </div>
              <div>
                <div class="fw-semibold" style="color:#1a3a6b; font-size:16px;">View Lab List</div>
                <div style="color:#6bfff7280; font-size:13px;">Manage registered labs, price lists & phlebotomists</div>
              </div>
              <i class="ti ti-chevron-right ms-auto" style="color:#1a3a6b;"></i>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-6">
        <a href="<?= base_url('registerform') ?>" class="text-decoration-none">
          <div class="card1 border-0 shadow-sm rounded-4 p-4 h-100"
               style="border-left: 4px solid #c9140e !important;">
            <div class="d-flex align-items-center gap-3">
              <div class="rounded-3 d-flex align-items-center justify-content-center"
                   style="width:50px; height:50px; background:#fdeaea; min-width:50px;">
                <i class="ti ti-plus" style="font-size:22px; color:#c9140e;"></i>
              </div>
              <div>
                <div class="fw-semibold" style="color:#c9140e; font-size:16px;">Register New Lab</div>
                <div style="color:#6b7280; font-size:13px;">Add a new lab partner to the system</div>
              </div>
              <i class="ti ti-chevron-right ms-auto" style="color:#c9140e;"></i>
            </div>
          </div>
        </a>
      </div>

    </div>
    <?php endif; ?>

  </div>
</div>

<?= view('templates/footer') ?>