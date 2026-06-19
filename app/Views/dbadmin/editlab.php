<?= view('templates/header', ['pageTitle' => 'Edit Lab', 'activePage' => 'lablist']) ?>

<div class="container py-4 flex-grow-1">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-semibold mb-0" style="color:#961914;">Edit Lab</h2>
      <small class="text-muted">Update lab information</small>
    </div>
    <a href="<?= base_url('lablist') ?>" class="btn btn-outline-secondary btn-sm">
      <i class="ti ti-arrow-left me-1"></i> Back
    </a>
  </div>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger py-2 small"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-4" style="background:#fff;">

      <form action="<?= base_url('labs/' . $lab['id'] . '/edit') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="row">

          <div class="col-md-6 mb-3">
            <label class="hform-label1 fw-medium" style="color:#961914;">Lab Name</label>
            <div class="input-group">
              <span class="input-group-text"><i class="ti ti-flask"></i></span>
              <input type="text" name="name" class="form-control"
                     value="<?= esc($lab['name']) ?>" required/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="hform-label1 fw-medium" style="color:#961914;">Contact Person</label>
            <div class="input-group">
              <span class="input-group-text"><i class="ti ti-user"></i></span>
              <input type="text" name="contact_person" class="form-control"
                     value="<?= esc($lab['contact_person']) ?>"/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="hform-label1 fw-medium" style="color:#961914;">Email Address</label>
            <div class="input-group">
              <span class="input-group-text"><i class="ti ti-mail"></i></span>
              <input type="email" name="email" class="form-control"
                     value="<?= esc($lab['email']) ?>" required/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="hform-label1 fw-medium" style="color:#961914;">Phone Number</label>
            <div class="input-group">
              <span class="input-group-text"><i class="ti ti-phone"></i></span>
              <input type="text" name="phone" class="form-control"
                     value="<?= esc($lab['phone']) ?>"/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="hform-label1 fw-medium" style="color:#961914;">License Number</label>
            <div class="input-group">
              <span class="input-group-text"><i class="ti ti-id-badge-2"></i></span>
              <input type="text" name="license_number" class="form-control"
                     value="<?= esc($lab['license_number']) ?>"/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="hform-label1 fw-medium" style="color:#961914;">Address</label>
            <div class="input-group">
              <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
              <input type="text" name="address" class="form-control"
                     value="<?= esc($lab['address']) ?>"/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="hform-label1 fw-medium" style="color:#961914;">Status</label>
            <div class="input-group">
              <span class="input-group-text"><i class="ti ti-toggle-right"></i></span>
              <select name="status" class="form-select">
                <option value="active"   <?= $lab['status'] === 'active'   ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $lab['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
              </select>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="hform-label1 fw-medium" style="color:#961914;">
              New Password <small class="text-muted fw-normal">(leave blank to keep current)</small>
            </label>
            <div class="input-group">
              <span class="input-group-text"><i class="ti ti-lock"></i></span>
              <input type="password" name="password" id="password" class="form-control"
                     placeholder="••••••••"/>
              <button type="button" class="btn btn-outline-secondary" onclick="togglePw()">
                <i class="ti ti-eye" id="eye-icon"></i>
              </button>
            </div>
          </div>

        </div>

        <button type="submit" class="btn text-white px-4 mt-2" style="background:#961914;">
          <i class="ti ti-device-floppy me-1"></i> Save Changes
        </button>

      </form>
    </div>
  </div>

</div>

<script>
  function togglePw() {
    const inp  = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    inp.type   = inp.type === 'password' ? 'text' : 'password';
    icon.className = inp.type === 'password' ? 'ti ti-eye' : 'ti ti-eye-off';
  }
</script>

<?= view('templates/footer') ?>