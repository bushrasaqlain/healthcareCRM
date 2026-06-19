<?= view('templates/header', ['pageTitle' => 'Price List', 'activePage' => 'pricelist']) ?>

<style>
body { background: #f8fafc; }
.pl-wrap        { max-width: 900px; margin: 0 auto; padding: 32px 16px; }
.pl-header      { margin-bottom: 28px; }
.pl-title       { font-size: 1.4rem; font-weight: 700; color: #111827; display:flex; align-items:center; gap:10px; }
.pl-subtitle    { font-size: .83rem; color: #6b7280; margin-top: 4px; }
.search-wrap    { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; display:flex; align-items:center; gap:16px; flex-wrap:wrap; box-shadow: 0 1px 4px rgba(0,0,0,.04); }
.search-box     { position:relative; flex:1; min-width:220px; }
.search-icon    { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:1rem; pointer-events:none; }
.search-input   { width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:9px 14px 9px 38px; font-size:.85rem; outline:none; background:#fff; color:#111827; }
.search-input:focus { border-color:#134557; box-shadow: 0 0 0 3px rgba(19,69,87,.08); }
.discount-wrap  { display:flex; align-items:center; gap:8px; font-size:.85rem; color:#374151; white-space:nowrap; }
.discount-input { width:70px; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:.85rem; text-align:center; outline:none; }
.discount-input:focus { border-color:#134557; }
.result-count   { font-size:.8rem; color:#6b7280; margin-bottom:10px; }

/* Table */
.pl-card        { background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,.05); min-width:100%; }
.pl-table       { width:100%; border-collapse:collapse; min-width:600px; table-layout:fixed; }
.pl-table thead { background:#fff; }
.pl-table thead th { 
    font-size:.72rem; font-weight:700; letter-spacing:.05em; 
    color:#6b7280; padding:10px 16px; 
    border-bottom:2px solid #f3f4f6; 
    background:#fff;
}
.pl-table tbody tr { border-bottom:1px solid #f3f4f6; background:#fff; }
.pl-table tbody tr:hover { background:#f8fafc; }
.pl-table td    { padding:14px 16px; vertical-align:middle; background:transparent; }
.td-code        { font-size:.78rem; color:#9ca3af; }
.td-name        { font-size:.88rem; font-weight:600; color:#111827; }
.td-rack        { font-size:.88rem; font-weight:600; color:#111827; }
.td-patient     { font-size:.82rem; color:#134557; font-weight:500; margin-top:3px; }
.no-results     { text-align:center; color:#9ca3af; padding:40px; font-size:.88rem; }
</style>

<div class="pl-wrap">

  <!-- Header -->
  <div class="pl-header">
    <div class="pl-title">
      <i class="ti ti-flask" style="color:#134557;"></i>
      Test Price List
    </div>
    <div class="pl-subtitle">
      <?= count($tests) ?> tests available &middot; Use this page to answer patient pricing queries
    </div>
  </div>

  <!-- Search + Discount Bar -->
 <div class="search-wrap">
    <div class="search-box">
        <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" id="searchInput" class="search-input" 
               placeholder="Search by test name or code (e.g. CBC, Vitamin D, 5050)...">
    </div>
    <div class="discount-wrap">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#134557" stroke-width="2">
            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
            <line x1="7" y1="7" x2="7.01" y2="7"/>
        </svg>
        Discount:
        <input type="number" id="discountInput" class="discount-input" value="0" min="0" max="100">
        %
    </div>
</div>

  <!-- Result count -->
  <div class="result-count" id="resultCount">All <?= count($tests) ?> tests</div>

  <!-- Table -->
  <div style="overflow-x:auto;">
    <div class="pl-card">
        <table class="pl-table" id="priceTable">
            <thead>
                <tr>
                    <th style="width:15%;">CODE</th>
                    <th>TEST NAME</th>
                    <th style="width:22%; text-align:right; padding-right:20px;">
                        RACK RATE<br>
                        <span style="color:#134557;">PATIENT PAYS</span>
                    </th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php foreach ($tests as $test): ?>
                <tr data-name="<?= strtolower(esc($test['test_name'])) ?>" 
                    data-code="<?= strtolower(esc($test['test_code'] ?? '')) ?>"
                    data-rate="<?= $test['rate'] ?>">
                    <td><div class="td-code"><?= esc($test['test_code'] ?? '—') ?></div></td>
                    <td><div class="td-name"><?= esc($test['test_name']) ?></div></td>
                    <td style="text-align:right; padding-right:20px;">
                        <div class="td-rack">PKR <span class="rack-val"><?= number_format($test['rate'], 0) ?></span></div>
                        <div class="td-patient">PKR <span class="patient-val"><?= number_format($test['rate'], 0) ?></span></div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="no-results" id="noResults" style="display:none;">No tests found</div>

        <div style="text-align:center; font-size:.78rem; color:#9ca3af; margin-top:20px; padding-bottom:10px;">
            Prices shown are rack rates (INFINITY price list). Actual patient price depends on applied discount.
        </div>
     </div>
    </div>
  </div>

</div>

<script>
const searchInput   = document.getElementById('searchInput');
const discountInput = document.getElementById('discountInput');
const rows          = document.querySelectorAll('#tableBody tr');
const resultCount   = document.getElementById('resultCount');
const noResults     = document.getElementById('noResults');
const total         = rows.length;

function update() {
  const q        = searchInput.value.toLowerCase().trim();
  const discount = Math.min(100, Math.max(0, parseFloat(discountInput.value) || 0));
  let   visible  = 0;

  rows.forEach(row => {
    const name = row.dataset.name;
    const code = row.dataset.code;
    const rate = parseFloat(row.dataset.rate) || 0;

    const match = !q || name.includes(q) || code.includes(q);
    row.style.display = match ? '' : 'none';

    if (match) {
      visible++;
      const patientPrice = rate - (rate * discount / 100);
      row.querySelector('.patient-val').textContent = 
        Math.round(patientPrice).toLocaleString();
    }
  });

  resultCount.textContent = q 
    ? `${visible} result${visible !== 1 ? 's' : ''} for "${searchInput.value}"`
    : `All ${total} tests`;

  noResults.style.display = visible === 0 ? '' : 'none';
}

searchInput.addEventListener('input', update);
discountInput.addEventListener('input', update);
</script>

<?= view('templates/footer') ?>