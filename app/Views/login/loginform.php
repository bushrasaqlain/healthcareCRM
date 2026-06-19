<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Infinity+ - Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"/>
  <style>
    body {
      background-color: #4e8aa0;
    }
    .login-card {
      background-color: #134557;
      overflow: hidden;
    }
    .login-card-body {
      background-color: #ffffff;
    }
    .input-light {
      background-color: #eef2f7 !important;
      border: none !important;
    }
    .input-light::placeholder {
      color: #8a99a8;
    }
    .input-group-text-light {
      background-color: #eef2f7 !important;
      border: none !important;
      color: #8a99a8 !important;
    }
    .btn-teal {
      background-color: #1c4f63;
      border: none;
      color: #fff;
    }
    .btn-teal:hover {
      background-color: #15404f;
      color: #fff;
    }
    .accent-cyan {
      color: #4fd1c5;
    }
    .subtitle-muted {
      color: #a9c2cc;
    }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">

  <div class="card login-card border-0 rounded-4 p-0" style="width:100%; max-width:420px;">

    <!-- Top dark teal header -->
    <div class="d-flex flex-column align-items-center text-center px-4 pt-4 pb-5">
      <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3"
           style="width:56px; height:56px;">
        <i class="ti ti-heart-plus text-white fs-3"></i>
      </div>
      <span class="fs-4 fw-bold text-white">Infinity +</span>
      <small class="subtitle-muted mt-1">Home Sample Collection Management</small>
    </div>

    <!-- White bottom section -->
    <div class="login-card-body rounded-4 p-4" style="margin-top:-1.5rem;">

      <h2 class="fw-bold fs-4 mb-4" style="color:#1c4f63;">Sign In</h2>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger py-2 small">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('auth/login') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="mb-3">
          <label class="form-label fw-medium" style="color:#1c4f63;">Email Address</label>
          <div class="input-group">
            <span class="input-group-text input-group-text-light">
              <i class="ti ti-mail"></i>
            </span>
            <input type="email" name="email"
                   class="form-control input-light"
                   placeholder="admin@infinitylus.com" required/>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-medium" style="color:#1c4f63;">Password</label>
          <div class="input-group">
            <span class="input-group-text input-group-text-light">
              <i class="ti ti-lock"></i>
            </span>
            <input type="password" name="password" id="password"
                   class="form-control input-light"
                   placeholder="••••••••" required/>
            <button type="button" class="btn input-group-text-light"
                    onclick="togglePw()">
              <i class="ti ti-eye" id="eye-icon"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn btn-teal w-100 fw-semibold py-2">
          Sign In
        </button>

      </form>

      <p class="text-center text-muted mt-4 mb-0" style="font-size:11px;">
        © 2026 Infinity+ · All rights reserved
      </p>

    </div>
  </div>

  <script>
      function togglePw() {
    const inp  = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    inp.type   = inp.type === 'password' ? 'text' : 'password';
    icon.className = inp.type === 'password' ? 'ti ti-eye' : 'ti ti-eye-off';
  }

  const emailField   = document.getElementById('email');
  const emailError   = document.getElementById('email-error');
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  emailField.addEventListener('input', function () {
    if (emailPattern.test(this.value)) emailError.classList.add('d-none');
  });

  emailField.addEventListener('blur', function () {
    const valid = this.value === '' || emailPattern.test(this.value);
    emailError.classList.toggle('d-none', valid);
  });

   
  </script>

</body>
</html>