<?= view('templates/header', ['pageTitle' => 'Lab List', 'activePage' => 'lablist']) ?>

<div class="container-fluid px-3 px-md-4 py-4 flex-grow-1" style="background:#f0f4f8; min-height:100vh;">

  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
      <h2 class="fw-bold mb-0" style="color:#c9140e; font-family:'Poppins',sans-serif;">Lab List</h2>
      <small class="text-muted">Manage registered lab partners</small>
    </div>
    <a href="<?= base_url('registerform') ?>" class="btn text-white fw-semibold px-4"
       style="background:#c9140e; border-radius:10px;">
      <i class="ti ti-plus me-1"></i> Register New Lab
    </a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show py-2 small">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Desktop Table -->
  <div class="d-none d-md-block card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0" style="border-collapse:separate; border-spacing:0;">
          <thead>
            <tr style="background:#1a3a6b; color:1a3a6b;">
              <th class="py-3 px-4 text-center" style="color:1a3a6b; width:5%; border-radius:16px 0 0 0;">#</th>
              <th class="py-3 text-center " style="width:20%;">Lab Name</th>
              <th class="py-3 text-center " style="width:25%;">Email</th>
              <th class="py-3 text-center " style="width:10%;">Status</th>
              <th class="py-3 text-center " style="width:40%; border-radius:0 16px 0 0;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($labs)): ?>
              <?php foreach ($labs as $i => $lab): ?>
                <tr style="border-bottom:1px solid #e5e7eb;">
                  <td class="px-4 text-center text-muted py-3"><?= $i + 1 ?></td>
                  <td class="text-center py-3">
                    <a href="javascript:void(0)"
                       class="fw-semibold text-decoration-none lab-name-link"
                       style="color:#1a3a6b;"
                       data-bs-toggle="modal"
                       data-bs-target="#labDetailsModal"
                       data-name="<?= esc($lab['name']) ?>"
                       data-person="<?= esc($lab['contact_person']) ?>"
                       data-license="<?= esc($lab['license_number']) ?>"
                       data-address="<?= esc($lab['address']) ?>"
                       data-email="<?= esc($lab['email']) ?>"
                       data-password="<?= esc($lab['password_hint'] ?? '') ?>">
                      <?= esc($lab['name']) ?>
                    </a>
                  </td>
                  <td class="text-center text-muted small py-3"><?= esc($lab['email']) ?></td>
                  <td class="text-center py-3">
                    <?php if ($lab['status'] === 'active'): ?>
                      <span class="badge rounded-pill px-3 py-2" style="background:#e8f8ee; color:#0c7a43;">Active</span>
                    <?php else: ?>
                      <span class="badge rounded-pill px-3 py-2 bg-secondary">Inactive</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center py-3">
                    <?php if ($lab['test_count'] > 0): ?>
                      <a href="<?= base_url('labs/' . $lab['id'] . '/pricelist?mode=view') ?>"
                         class="btn btn-sm me-1" style="background:#eef2f7; color:#1a3a6b; border-radius:8px;"
                         title="View List" data-bs-toggle="tooltip" data-bs-placement="top">
                        <i class="ti ti-list"></i>
                      </a>
                      <a href="<?= base_url('labs/' . $lab['id'] . '/pricelist?mode=update') ?>"
                         class="btn btn-sm text-white me-1" style="background:#1a3a6b; border-radius:8px;"
                         title="Update Price List" data-bs-toggle="tooltip" data-bs-placement="top">
                        <i class="ti ti-refresh"></i>
                      </a>
                    <?php else: ?>
                      <a href="<?= base_url('labs/' . $lab['id'] . '/pricelist') ?>"
                         class="btn btn-sm text-white me-1" style="background:#c9140e; border-radius:8px;"
                         title="Import Price List" data-bs-toggle="tooltip" data-bs-placement="top">
                        <i class="ti ti-upload"></i>
                      </a>
                    <?php endif; ?>
                    <a href="<?= base_url('labs/' . $lab['id'] . '/phlebotomist') ?>"
                       class="btn btn-sm text-white me-1" style="background:#2463c2; border-radius:8px;"
                       title="Phlebotomist List" data-bs-toggle="tooltip" data-bs-placement="top">
                      <i class="ti ti-user-plus"></i>
                    </a>
                    <a href="<?= base_url('labs/' . $lab['id'] . '/edit') ?>"
                       class="btn btn-sm" style="background:#eef2f7; color:#6b7280; border-radius:8px;"
                       title="Edit Lab" data-bs-toggle="tooltip" data-bs-placement="top">
                      <i class="ti ti-edit"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-5">
                  <i class="ti ti-flask d-block mb-2" style="font-size:32px;"></i>
                  No labs registered yet.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Mobile Cards -->
  <div class="d-md-none">
    <?php if (!empty($labs)): ?>
      <?php foreach ($labs as $i => $lab): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-3">
          <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <a href="javascript:void(0)"
                   class="fw-bold text-decoration-none lab-name-link d-block"
                   style="color:#1a3a6b; font-size:16px;"
                   data-bs-toggle="modal"
                   data-bs-target="#labDetailsModal"
                   data-name="<?= esc($lab['name']) ?>"
                   data-person="<?= esc($lab['contact_person']) ?>"
                   data-license="<?= esc($lab['license_number']) ?>"
                   data-address="<?= esc($lab['address']) ?>"
                   data-email="<?= esc($lab['email']) ?>"
                   data-password="<?= esc($lab['password_hint'] ?? '') ?>">
                  <?= esc($lab['name']) ?>
                </a>
                <small class="text-muted"><?= esc($lab['email']) ?></small>
              </div>
              <?php if ($lab['status'] === 'active'): ?>
                <span class="badge rounded-pill px-3 py-2" style="background:#e8f8ee; color:#0c7a43;">Active</span>
              <?php else: ?>
                <span class="badge rounded-pill px-3 py-2 bg-secondary">Inactive</span>
              <?php endif; ?>
            </div>
            <div class="d-flex gap-2 flex-wrap mt-2">
              <?php if ($lab['test_count'] > 0): ?>
                <a href="<?= base_url('labs/' . $lab['id'] . '/pricelist?mode=view') ?>"
                   class="btn btn-sm" style="background:#eef2f7; color:#1a3a6b; border-radius:8px;">
                  <i class="ti ti-list me-1"></i> View
                </a>
                <a href="<?= base_url('labs/' . $lab['id'] . '/pricelist?mode=update') ?>"
                   class="btn btn-sm text-white" style="background:#1a3a6b; border-radius:8px;">
                  <i class="ti ti-refresh me-1"></i> Update
                </a>
              <?php else: ?>
                <a href="<?= base_url('labs/' . $lab['id'] . '/pricelist') ?>"
                   class="btn btn-sm text-white" style="background:#c9140e; border-radius:8px;">
                  <i class="ti ti-upload me-1"></i> Import
                </a>
              <?php endif; ?>
              <a href="<?= base_url('labs/' . $lab['id'] . '/phlebotomist') ?>"
                 class="btn btn-sm text-white" style="background:#2463c2; border-radius:8px;">
                <i class="ti ti-user-plus me-1"></i> Phlebotomist
              </a>
              <a href="<?= base_url('labs/' . $lab['id'] . '/edit') ?>"
                 class="btn btn-sm" style="background:#eef2f7; color:#6b7280; border-radius:8px;">
                <i class="ti ti-edit me-1"></i> Edit
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="text-center text-muted py-5">
        <i class="ti ti-flask d-block mb-2" style="font-size:32px;"></i>
        No labs registered yet.
      </div>
    <?php endif; ?>
  </div>

</div>

<!-- Lab Details Modal -->
<div class="modal fade" id="labDetailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4">
      <div class="modal-header border-0" style="background:#1a3a6b;">
        <h5 class="modal-title text-white fw-semibold">
          <i class="ti ti-flask me-2"></i><span id="modalLabName">Lab Details</span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <table class="table table-borderless mb-0">
          <tbody>
            <tr><th class="text-muted small" style="width:40%;">Lab Name</th><td class="fw-medium" id="modalName"></td></tr>
            <tr><th class="text-muted small">Contact Person</th><td id="modalPerson"></td></tr>
            <tr><th class="text-muted small">License Number</th><td id="modalLicense"></td></tr>
            <tr><th class="text-muted small">Address</th><td id="modalAddress"></td></tr>
            <tr><th class="text-muted small">Email</th><td id="modalEmail"></td></tr>
            <tr><th class="text-muted small">Password</th><td id="modalPassword"></td></tr>
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('labDetailsModal').addEventListener('show.bs.modal', function (event) {
    const link = event.relatedTarget;
    document.getElementById('modalLabName').textContent  = link.dataset.name || '';
    document.getElementById('modalName').textContent     = link.dataset.name || '';
    document.getElementById('modalPerson').textContent   = link.dataset.person || '';
    document.getElementById('modalLicense').textContent  = link.dataset.license || '';
    document.getElementById('modalAddress').textContent  = link.dataset.address || '';
    document.getElementById('modalEmail').textContent    = link.dataset.email || '';
    document.getElementById('modalPassword').textContent = link.dataset.password || '';
  });

  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el);
  });
});
</script>

<?= view('templates/footer') ?>