<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body style="background:#0f1923; color:#fff; font-family:sans-serif; padding:2rem;">
  <h1>Welcome, <?= session()->get('user_name') ?> 👋</h1>
  <p>Role: <?= session()->get('user_role') ?></p>
  <a href="<?= base_url('auth/logout') ?>" style="color:#1d9e75;">Logout</a>
</body>
</html>