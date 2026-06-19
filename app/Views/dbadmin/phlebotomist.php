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

  <?php if ($count === 0): ?>

    <div class="mb-4">
      <button type="button" class="btn text-white" style="background:#134557;"
              data-bs-toggle="modal" data-bs-target="#importListModal">
        <i class="ti ti-upload me-1"></i> Import List
      </button>
    </div>

  <?php else: ?>

    <div class="d-flex gap-2 mb-4">
      <button type="button" class="btn text-white" style="background:#134557;"
              data-bs-toggle="modal" data-bs-target="#updateListModal">
        <i class="ti ti-refresh me-1"></i> Update List
      </button>
      <button type="button" class="btn btn-outline-secondary"
              data-bs-toggle="modal" data-bs-target="#addPhlebotomistModal">
        <i class="ti ti-user-plus me-1"></i> Add Phlebotomist
      </button>
    </div>

  <?php endif; ?>

  <!-- Import Modal -->
  <div class="modal fade" id="importListModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-header border-0" style="background:#134557;">
          <h5 class="modal-title text-white fw-semibold">
            <i class="ti ti-upload me-2"></i> Import Phlebotomist List
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form action="<?= base_url('labs/' . $lab['id'] . '/phlebotomist') ?>"
              method="POST" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="modal-body pt-4">
            <p class="text-muted small mb-3">Excel columns in order: <strong>Name, City</strong></p>
            <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required/>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn text-white" style="background:#134557;">
              <i class="ti ti-upload me-1"></i> Import
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Update List Modal -->
  <div class="modal fade" id="updateListModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-header border-0" style="background:#134557;">
          <h5 class="modal-title text-white fw-semibold">
            <i class="ti ti-refresh me-2"></i> Update Phlebotomist List
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form action="<?= base_url('labs/' . $lab['id'] . '/phlebotomist') ?>"
              method="POST" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="modal-body pt-4">
            <p class="text-muted small mb-3">Excel columns in order: <strong>Name, City</strong></p>
            <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required/>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn text-white" style="background:#134557;">
              <i class="ti ti-upload me-1"></i> Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Add Phlebotomist Modal -->
  <div class="modal fade" id="addPhlebotomistModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-header border-0" style="background:#134557;">
          <h5 class="modal-title text-white fw-semibold">
            <i class="ti ti-user-plus me-2"></i> Add Phlebotomist
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form action="<?= base_url('labs/' . $lab['id'] . '/phlebotomist/add') ?>" method="POST">
          <?= csrf_field() ?>
          <div class="modal-body pt-4">
            <div class="mb-3">
              <label class="form-label fw-medium" style="color:#134557;">Full Name</label>
              <div class="input-group">
                <span class="input-group-text"><i class="ti ti-user"></i></span>
                <input type="text" name="name" class="form-control" placeholder="e.g. Ali Khan" required/>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label fw-medium" style="color:#134557;">City</label>
              <div class="input-group">
                <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                <input type="text" name="city" class="form-control" placeholder="e.g. Rawalpindi"/>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn text-white" style="background:#134557;">
              <i class="ti ti-plus me-1"></i> Add
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Table -->
  <?php if ($count > 0): ?>
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
  <?php endif; ?>

</div>

<?= view('templates/footer') ?>