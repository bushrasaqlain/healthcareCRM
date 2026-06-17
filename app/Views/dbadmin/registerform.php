<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HealthCRM - Lab Registration</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"/>
<?= view('templates/header', ['pageTitle' => 'Lab Registration', 'activePage' => 'register']) ?>

<style>
  /* page-specific styles that aren't already in templates/header.php */
  .register-card-body {
    background-color: #fff;
  }
  .form-label {
    color: #1c4f63;
  }
</style>

<div class="flex-grow-1 d-flex align-items-center justify-content-center py-4">
  <div class="card register-card border-0 p-5" style="width:100%; max-width:900px; background-color:#134557;">

    <!-- Top header -->
    <div class="d-flex flex-column text-black align-items-center text-center px-4 pt-2 pb-3">
      <div class="rounded-circle d-flex align-items-center justify-content-center mb-3"
           style="width:56px; height:56px; background:#fff;">
        <i class="ti ti-flask text-primary fs-3"></i>
      </div>
      <span class="fs-4 fw-bold" style="color:#fff;">Health CRM</span>
      <small class="mt-1" style="color:#fff;">Lab Registration Form</small>
    </div>

    <!-- Form section -->
    <div class="register-card-body rounded-4 p-4 mt-2 p-md-5" style="margin-top:-1.5rem;">

      <h2 class="fw-bold fs-4 mb-4" style="color:#1c4f63;">Register a Lab</h2>

      <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger py-2 small">
          <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
              <li><?= esc($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success py-2 small">
          <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('labs/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="row">

          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">Lab Name</label>
            <div class="input-group">
              <span class="input-group-text input-group-text-light"><i class="ti ti-flask"></i></span>
              <input type="text" name="name" class="form-control input-light"
                     placeholder="City Diagnostics Lab" value="<?= old('name') ?>" required/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">Contact Person</label>
            <div class="input-group">
              <span class="input-group-text input-group-text-light"><i class="ti ti-user"></i></span>
              <input type="text" name="contact_person" class="form-control input-light"
                     placeholder="John Doe" value="<?= old('contact_person') ?>"/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">Email Address</label>
            <div class="input-group">
              <span class="input-group-text input-group-text-light"><i class="ti ti-mail"></i></span>
              <input type="email" name="email" class="form-control input-light"
                     placeholder="lab@healthcrm.com" value="<?= old('email') ?>" required/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">Phone Number</label>
            <div class="input-group">
              <span class="input-group-text input-group-text-light"><i class="ti ti-phone"></i></span>
              <input type="text" name="phone" class="form-control input-light"
                     placeholder="03XX-XXXXXXX" value="<?= old('phone') ?>"/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">License Number</label>
            <div class="input-group">
              <span class="input-group-text input-group-text-light"><i class="ti ti-id-badge-2"></i></span>
              <input type="text" name="license_number" class="form-control input-light"
                     placeholder="LAB-2026-0012" value="<?= old('license_number') ?>"/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">Address</label>
            <div class="input-group">
              <span class="input-group-text input-group-text-light"><i class="ti ti-map-pin"></i></span>
              <input type="text" name="address" class="form-control input-light"
                     placeholder="Street, City" value="<?= old('address') ?>"/>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">Password</label>
            <div class="input-group">
              <span class="input-group-text input-group-text-light"><i class="ti ti-lock"></i></span>
              <input type="password" name="password" id="password" class="form-control input-light"
                     placeholder="••••••••" required/>
              <button type="button" class="btn input-group-text-light" onclick="togglePw('password','eye-icon-1')">
                <i class="ti ti-eye" id="eye-icon-1"></i>
              </button>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-medium">Confirm Password</label>
            <div class="input-group">
              <span class="input-group-text input-group-text-light"><i class="ti ti-lock"></i></span>
              <input type="password" name="confirm_password" id="confirm_password" class="form-control input-light"
                     placeholder="••••••••" required/>
              <button type="button" class="btn input-group-text-light" onclick="togglePw('confirm_password','eye-icon-2')">
                <i class="ti ti-eye" id="eye-icon-2"></i>
              </button>
            </div>
          </div>

        </div>

        <input type="hidden" name="role" value="lab"/>

        <button type="submit" class="btn text-white w-100 fw-semibold py-2 mt-2" style="background:#134557">
          Register Lab
        </button>

      </form>

      <p class="text-center text-muted mt-4 mb-0" style="font-size:11px;">
        © 2026 HealthCRM · All rights reserved
      </p>

    </div>
  </div>
</div>

<script>
  function togglePw(inputId, iconId) {
    const inp  = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    inp.type   = inp.type === 'password' ? 'text' : 'password';
    icon.className = inp.type === 'password' ? 'ti ti-eye' : 'ti ti-eye-off';
  }
</script>

<?= view('templates/footer') ?>
</html>