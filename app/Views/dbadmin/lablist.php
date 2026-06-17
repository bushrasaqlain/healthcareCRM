<?= view('templates/header', ['pageTitle' => 'Lab List', 'activePage' => 'lablist']) ?>

<div class="container py-4 flex-grow-1">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-semibold mb-0" style="color:#134557;">Lab List</h2>
    <a href="<?= base_url('registerform') ?>" class="btn text-white" style="background:#134557;">
      <i class="ti ti-plus me-1"></i> Register New Lab
    </a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success py-2 small"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead style="background:#134557; color:#fff;">
            <tr>
              <th class="py-3 px-4">#</th>
              <th class="py-3">Name</th>
              <th class="py-3">Person</th>
              <th class="py-3">Email</th>
              <th class="py-3">Phone</th>
              <th class="py-3">License</th>
              <th class="py-3">Address</th>
              <th class="py-3">Status</th>
              <th class="py-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($labs)): ?>
              <?php foreach ($labs as $i => $lab): ?>
                <tr>
                  <td class="px-4"><?= $i + 1 ?></td>
                  <td><?= esc($lab['name']) ?></td>
                  <td><?= esc($lab['contact_person']) ?></td>
                  <td><?= esc($lab['email']) ?></td>
                  <td><?= esc($lab['phone']) ?></td>
                  <td><?= esc($lab['license_number']) ?></td>
                  <td><?= esc($lab['address']) ?></td>
                  <td>
                    <?php if ($lab['status'] === 'active'): ?>
                      <span class="badge bg-success">Active</span>
                    <?php else: ?>
                      <span class="badge bg-secondary">Inactive</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="<?= base_url('labs/' . $lab['id'] . '/pricelist') ?>"
                       class="btn btn-sm text-white" style="background:#134557;">
                      <i class="ti ti-upload me-1"></i> Import
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center text-muted py-4">No labs registered yet.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<?= view('templates/footer') ?>