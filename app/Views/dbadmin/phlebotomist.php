<?= view('templates/header', ['pageTitle' => 'Phlebotomist List', 'activePage' => 'lablist']) ?>

<div class="container py-4 flex-grow-1">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-semibold mb-0" style="color:#134557;"><?= esc($lab['name']) ?></h2>
      <small class="text-muted">Phlebotomist List</small>
    </div>
    <a href="<?= base_url('lablist') ?>" class="btn btn-outline-secondary btn-sm">
      <i class="ti ti-arrow-left me-1"></i> Back
    </a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show py-2 small">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show py-2 small">
      <?= session()->getFlashdata('error') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Upload Card -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
      <h5 class="fw-semibold mb-2" style="color:#134557;">Import Phlebotomist List</h5>
      <p class="text-muted small mb-3">
  Excel columns in order: <strong>Name, City</strong>
</p>
      <form action="<?= base_url('labs/' . $lab['id'] . '/phlebotomist') ?>"
            method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="input-group" style="max-width:500px;">
          <input type="file" name="excel_file" class="form-control"
                 accept=".xlsx,.xls,.csv" required/>
          <button type="submit" class="btn text-white" style="background:#134557;">
            <i class="ti ti-upload me-1"></i> Import
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Phlebotomist Table -->
  <?php if (!empty($phlebotomists)): ?>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead style="background:#134557; color:#fff;">
  <tr>
    <th class="py-3 px-4">#</th>
    <th class="py-3">Name</th>
    <th class="py-3">City</th>
    <th class="py-3">Status</th>
  </tr>
</thead>
<tbody>
  <?php foreach ($phlebotomists as $i => $p): ?>
    <tr>
      <td class="px-4"><?= $i + 1 ?></td>
      <td><?= esc($p['name']) ?></td>
      <td><?= esc($p['city']) ?></td>
      <td>
        <?php if ($p['status'] === 'active'): ?>
          <span class="badge bg-success">Active</span>
        <?php else: ?>
          <span class="badge bg-secondary">Inactive</span>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
</tbody>
        </table>
      </div>
    </div>
  </div>
  <?php else: ?>
    <div class="text-center text-muted py-4">
      <i class="ti ti-users fs-1 d-block mb-2"></i>
      No phlebotomists imported yet.
    </div>
  <?php endif; ?>

</div>

<?= view('templates/footer') ?>