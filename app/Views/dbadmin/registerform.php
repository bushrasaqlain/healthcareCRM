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

</style>

<div class="flex-grow-1 d-flex align-items-center justify-content-center py-4">
  <div class="card register-card border-0 p-5" style="width:100%; max-width:900px;  ">

    <!-- Top header -->
    <div class="d-flex flex-column text-black align-items-center text-center px-4 pt-2 pb-3">
      <div class="rounded-circle d-flex align-items-center justify-content-center mb-3"
           style="width:56px; height:56px; background:#fff;">
        <i class="ti ti-flask text-danger fs-3"></i>
      </div>
      <span class="fs-4 fw-bold" style="color:#fff;">Infinity +</span>
      <small class="mt-1" style="color:#fff;">Lab Registration Form</small>
    </div>

    <!-- Form section -->
    <div class="register-card-body rounded-4 p-4 mt-2 p-md-5" style="margin-top:-1.5rem;">

      <h2 class="fw-bold fs-4 mb-4" style="color:#961914;">Register a Lab</h2>

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
    <input type="email" name="email" id="email" class="form-control input-light"
           placeholder="lab@healthcrm.com" value="<?= old('email') ?>" required/>
  </div>
  <small class="text-danger d-none" id="email-error">Enter a valid email address.</small>
</div>

         <div class="col-md-6 mb-3">
  <label class="form-label fw-medium">Phone Number</label>
  <div class="input-group">
    <span class="input-group-text input-group-text-light"><i class="ti ti-phone"></i></span>
    <input type="text" name="phone" id="phone" class="form-control input-light"
           placeholder="03XX-XXXXXXX or 0XX-XXXXXXX" value="<?= old('phone') ?>" maxlength="12"/>
  </div>
  <small class="text-danger d-none" id="phone-error">Enter a valid Pakistani mobile (03XX-XXXXXXX) or landline (0XX-XXXXXXX) number.</small>
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

          <!-- <div class="col-md-6 mb-3">
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
          </div> -->
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
  <ul class="list-unstyled small mt-2 mb-0 d-none" id="pw-checklist">
    <li id="pw-length" class="text-muted"><i class="ti ti-x me-1"></i>At least 8 characters</li>
    <li id="pw-upper" class="text-muted"><i class="ti ti-x me-1"></i>One uppercase letter</li>
    <li id="pw-lower" class="text-muted"><i class="ti ti-x me-1"></i>One lowercase letter</li>
    <li id="pw-number" class="text-muted"><i class="ti ti-x me-1"></i>One number</li>
    <li id="pw-special" class="text-muted"><i class="ti ti-x me-1"></i>One special character</li>
  </ul>
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
  <small class="text-danger d-none" id="pw-mismatch">Passwords do not match</small>
</div>
        </div>

        <input type="hidden" name="role" value="lab"/>

        <button type="submit" class="btn text-white w-100 fw-semibold py-2 mt-2" style="background:#961914">
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

  const phoneField   = document.getElementById('phone');
  const phoneError   = document.getElementById('phone-error');
  const phonePattern = /^(03\d{2}-\d{7}|0(?!3)\d{2}-\d{7})$/;

  // Auto-format phone as mobile (4-7 split) or landline (3-7 split)
  phoneField.addEventListener('input', function () {
    let digits = this.value.replace(/\D/g, '');
    const isMobile = digits.length < 2 || digits[1] === '3';
    const maxLen = isMobile ? 11 : 10;
    digits = digits.slice(0, maxLen);

    const splitAt = isMobile ? 4 : 3;
    this.value = digits.length > splitAt
      ? digits.slice(0, splitAt) + '-' + digits.slice(splitAt)
      : digits;

    // Hide the error as soon as it becomes valid, even before blur
    if (phonePattern.test(this.value)) phoneError.classList.add('d-none');
  });

  // Final check when the user leaves the field
  phoneField.addEventListener('blur', function () {
    const valid = this.value === '' || phonePattern.test(this.value);
    phoneError.classList.toggle('d-none', valid);
  });

  const emailField = document.getElementById('email');
  const emailError = document.getElementById('email-error');
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  emailField.addEventListener('input', function () {
    if (emailPattern.test(this.value)) emailError.classList.add('d-none');
  });

  emailField.addEventListener('blur', function () {
    const valid = this.value === '' || emailPattern.test(this.value);
    emailError.classList.toggle('d-none', valid);
  });

  // Password checklist + match check
  const pwField       = document.getElementById('password');
  const confirmField  = document.getElementById('confirm_password');
  const pwChecklist   = document.getElementById('pw-checklist');

  function setCheck(id, ok) {
    const el = document.getElementById(id);
    el.classList.toggle('text-success', ok);
    el.classList.toggle('text-muted', !ok);
    el.querySelector('i').className = ok ? 'ti ti-check me-1' : 'ti ti-x me-1';
  }

  pwField.addEventListener('focus', function () {
    pwChecklist.classList.remove('d-none');
  });

  pwField.addEventListener('blur', function () {
    const allValid = document.querySelectorAll('#pw-checklist .text-success').length === 5;
    if (allValid) pwChecklist.classList.add('d-none');
  });

  pwField.addEventListener('input', function () {
    const pw = this.value;
    setCheck('pw-length', pw.length >= 8);
    setCheck('pw-upper', /[A-Z]/.test(pw));
    setCheck('pw-lower', /[a-z]/.test(pw));
    setCheck('pw-number', /\d/.test(pw));
    setCheck('pw-special', /[^A-Za-z0-9]/.test(pw));
    checkMatch();
  });

  function checkMatch() {
    const mismatch = confirmField.value.length > 0 && confirmField.value !== pwField.value;
    document.getElementById('pw-mismatch').classList.toggle('d-none', !mismatch);
  }
  confirmField.addEventListener('input', checkMatch);
</script>

<?= view('templates/footer') ?>
</html>

