<?= view('templates/header', ['pageTitle' => 'Price List', 'activePage' => 'lablist']) ?>

<div class="container py-4 flex-grow-1">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-semibold mb-0" style="color:#134557;"><?= esc($lab['name']) ?></h2>
      <small class="text-muted">Import Price List via Excel</small>
    </div>
    <a href="<?= base_url('lablist') ?>" class="btn btn-outline-secondary btn-sm">
      <i class="ti ti-arrow-left me-1"></i> Back
    </a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success py-2 small"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger py-2 small"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <!-- Upload Card -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
      <h5 class="fw-semibold mb-3" style="color:#fff;">Upload Excel File</h5>

      <p class="text-white small mb-3">
        Excel file must have these columns in order:
        <strong>Test Name, Test Code, Price, Expected Time</strong>
      </p>

      <a href="<?= base_url('labs/download-template') ?>" class="btn btn-outline-light btn-sm mb-3">
        <i class="ti ti-download me-1"></i> Download Sample Template
      </a>

      <form action="<?= base_url('labs/' . $lab['id'] . '/pricelist') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="input-group" style="max-width:500px;">
          <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required/>
          <button type="submit" class="btn text-black" style="background:#fff;">
            <i class="ti ti-upload me-1"></i> Import
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Existing Tests Table -->
  <?php if (!empty($tests)): ?>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead style="background:#134557; color:#fff;">
  <tr>
    <th class="py-3 px-4">#</th>
    <th class="py-3">Code</th>
    <th class="py-3">Test Name</th>
    <th class="py-3">Rate (PKR)</th>
    <th class="py-3">Sample</th>
    <th class="py-3">Reporting Time</th>
  </tr>
</thead>
<tbody>
  <?php foreach ($tests as $i => $test): ?>
    <tr>
      <td class="px-4"><?= $i + 1 ?></td>
      <td><?= esc($test['test_code']) ?></td>
      <td><?= esc($test['test_name']) ?></td>
      <td><?= number_format($test['rate'], 2) ?></td>
      <td><?= esc($test['sample']) ?></td>
      <td><?= esc($test['reporting_time']) ?></td>
    </tr>
  <?php endforeach; ?>
</tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

</div>

<?= view('templates/footer') ?>