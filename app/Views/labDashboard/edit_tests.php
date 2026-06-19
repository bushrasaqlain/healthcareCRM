<?= view('templates/header', ['pageTitle' => 'Edit Tests', 'activePage' => 'lablist']) ?>

<style>
.edit-wrap        { max-width:960px;margin:0 auto;padding:24px 16px 60px; }
.back-btn         { display:inline-flex;align-items:center;gap:6px;color:#374151;text-decoration:none;font-size:14px;font-weight:500;margin-bottom:20px; }
.back-btn:hover   { color:#1d4ed8; }
.page-title       { font-size:1.4rem;font-weight:700;color:#111827;margin-bottom:2px; }
.sub-title        { font-size:.82rem;color:#9ca3af;margin-bottom:24px; }
.e-card           { background:#fff;border-radius:14px;border:1px solid #e5e7eb;padding:22px;margin-bottom:20px; }
.e-card-title     { font-size:.9rem;font-weight:700;color:#111827;margin-bottom:16px;display:flex;align-items:center;gap:8px; }

/* table */
.tests-tbl                 { width:100%;border-collapse:collapse; }
.tests-tbl thead th        { font-size:.7rem;font-weight:700;color:#9ca3af;letter-spacing:.05em;text-transform:uppercase;padding:8px 10px;border-bottom:2px solid #f3f4f6;text-align:left; }
.tests-tbl thead th.r      { text-align:right; }
.tests-tbl tbody td        { padding:10px;border-bottom:1px solid #f9fafb;vertical-align:middle; }
.tests-tbl tbody tr:last-child td { border-bottom:none; }
.tests-tbl tr.row-deleted  { background:#fff5f5;opacity:.55; }
.tests-tbl tr.row-deleted .tname::after { content:' — will be removed';color:#dc2626;font-size:.7rem;font-weight:400; }
.tests-tbl tr.row-new      { background:#f0fdf4; }
.tname   { font-size:.88rem;font-weight:600;color:#111827; }
.tmeta   { font-size:.7rem;color:#9ca3af;margin-top:1px; }
.rack    { font-size:.82rem;color:#6b7280;text-align:right; }
.tbl-in  { width:62px;padding:5px 8px;border:1px solid #d1d5db;border-radius:8px;font-size:.82rem;color:#111827;text-align:center; }
.tbl-sl  { padding:5px 8px;border:1px solid #d1d5db;border-radius:8px;font-size:.82rem;color:#111827;background:#fff; }
.tbl-in:focus,.tbl-sl:focus { outline:none;border-color:#1d4ed8;box-shadow:0 0 0 2px #dbeafe; }
.pprice  { font-size:.88rem;font-weight:600;color:#111827;text-align:right; }
.psave   { font-size:.68rem;color:#16a34a;text-align:right;margin-top:2px; }
.del-btn { width:30px;height:30px;border-radius:7px;border:none;background:#fee2e2;color:#dc2626;cursor:pointer;display:inline-flex;align-items:center;justify-content:center; }
.del-btn:hover { background:#fca5a5; }
.del-btn.undo  { background:#dcfce7;color:#16a34a; }
.empty-row td  { color:#9ca3af;font-size:.85rem;padding:14px 10px; }

/* picker */
.picker-wrap    { border:2px dashed #bfdbfe;border-radius:12px;padding:16px;margin-top:18px;background:#f8fbff; }
.picker-head    { display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;flex-wrap:wrap;gap:8px; }
.picker-label   { font-size:.82rem;font-weight:700;color:#1d4ed8;display:flex;align-items:center;gap:6px; }
.search-box     { flex:1;max-width:280px;padding:7px 12px;border:1px solid #bfdbfe;border-radius:8px;font-size:.82rem;color:#111827;background:#fff; }
.search-box:focus { outline:none;border-color:#1d4ed8;box-shadow:0 0 0 2px #dbeafe; }
.add-sel-btn    { display:inline-flex;align-items:center;gap:6px;padding:8px 18px;background:#1d4ed8;color:#fff;border:none;border-radius:9px;font-size:.82rem;font-weight:600;cursor:pointer; }
.add-sel-btn:hover { opacity:.9; }
.add-sel-btn:disabled { opacity:.4;cursor:not-allowed; }

.test-checklist  { max-height:240px;overflow-y:auto;border:1px solid #e5e7eb;border-radius:9px;background:#fff; }
.chk-item        { display:flex;align-items:center;gap:10px;padding:9px 12px;border-bottom:1px solid #f3f4f6;cursor:pointer; }
.chk-item:last-child { border-bottom:none; }
.chk-item:hover  { background:#eff6ff; }
.chk-item.sel    { background:#eff6ff; }
.chk-item.booked { opacity:.4;pointer-events:none; }
.chk-item input[type=checkbox] { width:16px;height:16px;accent-color:#1d4ed8;flex-shrink:0;cursor:pointer; }
.chk-name  { font-size:.85rem;font-weight:600;color:#111827;flex:1; }
.chk-code  { font-size:.72rem;color:#9ca3af;margin-right:6px; }
.chk-rate  { font-size:.78rem;font-weight:600;color:#1d4ed8;white-space:nowrap; }
.chk-empty { padding:16px;color:#9ca3af;font-size:.83rem;text-align:center; }
.sel-count { font-size:.75rem;color:#6b7280;margin-top:8px; }
.sel-count span { color:#1d4ed8;font-weight:700; }

/* summary */
.summary-box    { background:#f8fafc;border:1px solid #e5e7eb;border-radius:12px;padding:18px 20px;margin-bottom:20px; }
.sum-row        { display:flex;justify-content:space-between;align-items:center;font-size:.87rem;color:#374151;margin-bottom:8px; }
.sum-row:last-child { margin-bottom:0; }
.sum-row.total  { font-weight:700;font-size:1.05rem;color:#111827;border-top:1px solid #e5e7eb;padding-top:10px;margin-top:6px; }
.sum-row .disc  { color:#dc2626;font-weight:500; }

.save-btn       { display:inline-flex;align-items:center;gap:8px;padding:11px 28px;background:#1d4ed8;color:#fff;border:none;border-radius:10px;font-size:.9rem;font-weight:600;cursor:pointer; }
.save-btn:hover { opacity:.9; }
.cancel-link    { font-size:.85rem;color:#6b7280;text-decoration:none; }
.alert-error    { background:#fee2e2;color:#dc2626;padding:10px 14px;border-radius:10px;font-size:.85rem;margin-bottom:16px; }

@media(max-width:600px){ .hide-sm { display:none; } .search-box { max-width:100%; } }
</style>

<div class="edit-wrap">

  <a href="<?= base_url('booking/view/' . $patient['id']) ?>" class="back-btn">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Back to Booking
  </a>

  <div class="page-title">Edit Tests</div>
  <div class="sub-title">Patient: <?= esc($patient['patient_name']) ?> &nbsp;|&nbsp; #<?= esc($patient['id']) ?></div>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert-error"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <form action="<?= base_url('booking/updateTests/' . $patient['id']) ?>" method="post" id="editTestsForm">
    <?= csrf_field() ?>

    <div class="e-card">
      <div class="e-card-title">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"/></svg>
        Tests
      </div>

      <table class="tests-tbl">
        <thead>
          <tr>
            <th>Test</th>
            <th class="r hide-sm">Rack Rate</th>
            <th style="text-align:center">Discount %</th>
            <th style="text-align:center">Payment</th>
            <th class="r">Patient Pays</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="testsBody">
          <?php if (empty($currentBookings)): ?>
            <tr class="empty-row" id="emptyMsg"><td colspan="6">No tests currently booked.</td></tr>
          <?php else: ?>
            <?php foreach ($currentBookings as $b):
              $dAmt = round($b['rate'] * $b['discount_percent'] / 100);
              $pays = $b['rate'] - $dAmt;
            ?>
            <tr id="erow-<?= $b['id'] ?>">
              <td>
                <div class="tname"><?= esc($b['test_name']) ?></div>
                <div class="tmeta"><?= esc($b['test_code']) ?></div>
              </td>
              <td class="rack hide-sm">PKR <?= number_format($b['rate']) ?></td>
              <td style="text-align:center">
                <input class="tbl-in e-disc" type="number" min="0" max="100"
                  name="existing[<?= $b['id'] ?>][discount]"
                  value="<?= (int)$b['discount_percent'] ?>"
                  data-rate="<?= (float)$b['rate'] ?>"
                  data-id="<?= $b['id'] ?>"
                  oninput="refreshExisting(this)">
              </td>
              <td style="text-align:center">
                <select class="tbl-sl" name="existing[<?= $b['id'] ?>][payment]">
                  <option value="cash"    <?= $b['payment_method']==='cash'    ? 'selected':'' ?>>Cash</option>
                  <option value="prepaid" <?= $b['payment_method']==='prepaid' ? 'selected':'' ?>>Prepaid</option>
                </select>
              </td>
              <td>
                <div class="pprice" id="eprice-<?= $b['id'] ?>">PKR <?= number_format($pays) ?></div>
                <div class="psave"  id="esave-<?= $b['id'] ?>"><?= $dAmt>0 ? 'save PKR '.number_format($dAmt) : '' ?></div>
              </td>
              <td>
                <input type="hidden" name="delete_ids_map[<?= $b['id'] ?>]" value="0" id="dflag-<?= $b['id'] ?>">
                <button type="button" class="del-btn" id="dbtn-<?= $b['id'] ?>"
                  onclick="toggleDelete(<?= $b['id'] ?>, <?= (float)$b['rate'] ?>)" title="Remove">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                </button>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>

      <!-- ── Picker ── -->
      <div class="picker-wrap">
        <div class="picker-head">
          <div class="picker-label">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Tests
          </div>
          <input class="search-box" id="testSearch" type="text" placeholder="Search by name or code…" oninput="renderList()">
          <button type="button" class="add-sel-btn" id="addSelBtn" onclick="addSelected()" disabled>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Selected
          </button>
        </div>
        <div class="test-checklist" id="testChecklist"></div>
        <div class="sel-count">Selected: <span id="selCount">0</span></div>
      </div>
    </div>

    <!-- Summary -->
    <div class="summary-box">
      <div class="sum-row"><span>Rack Total</span><span id="sumRack">PKR 0</span></div>
      <div class="sum-row" id="sumDiscRow" style="display:none">
        <span>Total Discount</span><span class="disc" id="sumDisc">− PKR 0</span>
      </div>
      <div class="sum-row total"><span>Patient Pays</span><span id="sumPays">PKR 0</span></div>
    </div>

    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
      <button type="submit" class="save-btn" onclick="prepareDeleteIds()">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Save Changes
      </button>
      <a href="<?= base_url('booking/view/' . $patient['id']) ?>" class="cancel-link">Cancel</a>
    </div>
    <div id="deleteIdsContainer"></div>
  </form>
</div>

<script>
const ALL_TESTS  = <?= json_encode(array_values(array_map(fn($t) => [
  'id'   => (int)$t['id'],
  'name' => $t['test_name'],
  'code' => $t['test_code'],
  'rate' => (float)$t['rate'],
], $allTests))) ?>;

// IDs already booked for this patient
const bookedIds = new Set([<?= implode(',', array_map(fn($b) => (int)$b['fk_test_id'], $currentBookings)) ?>]);

const toDelete = new Set();   // existing booking row IDs marked for deletion
const checked  = new Set();   // test IDs ticked in picker
let   newIdx   = 0;

const fmt  = n  => 'PKR ' + Math.round(n).toLocaleString('en-PK');
const calc = (rate, pct) => { const d = Math.round(rate * pct / 100); return { disc: d, pays: rate - d }; };

/* ── Existing rows ── */
function refreshExisting(inp) {
  const id = inp.dataset.id, rate = +inp.dataset.rate;
  const {disc, pays} = calc(rate, +inp.value || 0);
  document.getElementById('eprice-'+id).textContent = fmt(pays);
  document.getElementById('esave-' +id).textContent = disc > 0 ? 'save '+fmt(disc) : '';
  recalc();
}

function toggleDelete(id, rate) {
  const row = document.getElementById('erow-'+id);
  const btn = document.getElementById('dbtn-'+id);
  const flag = document.getElementById('dflag-'+id);
  if (toDelete.has(id)) {
    toDelete.delete(id);
    row.classList.remove('row-deleted');
    btn.classList.remove('undo');
    btn.innerHTML = trashSvg();
    flag.value = '0';
    bookedIds.add(id); // keep greyed in picker
  } else {
    toDelete.add(id);
    row.classList.add('row-deleted');
    btn.classList.add('undo');
    btn.innerHTML = undoSvg();
    flag.value = '1';
  }
  recalc();
}

/* ── Checklist ── */
function renderList() {
  const q    = document.getElementById('testSearch').value.toLowerCase();
  const list = document.getElementById('testChecklist');
  const hits = ALL_TESTS.filter(t => !q || t.name.toLowerCase().includes(q) || t.code.toLowerCase().includes(q));
  if (!hits.length) { list.innerHTML = '<div class="chk-empty">No tests found.</div>'; return; }

  list.innerHTML = hits.map(t => {
    const isBooked  = bookedIds.has(t.id);
    const isTicked  = checked.has(t.id);
    return `<label class="chk-item${isTicked?' sel':''}${isBooked?' booked':''}" data-testid="${t.id}">
      <input type="checkbox" ${isTicked?'checked':''} ${isBooked?'disabled':''}
        onchange="tick(${t.id}, this.checked, this.closest('.chk-item'))">
      <span class="chk-name">${t.name}</span>
      <span class="chk-code">${t.code}</span>
      <span class="chk-rate">PKR ${t.rate.toLocaleString('en-PK')}</span>
      ${isBooked ? '<span style="font-size:.65rem;color:#9ca3af;">(booked)</span>' : ''}
    </label>`;
  }).join('');
}

function tick(id, on, label) {
  on ? checked.add(id) : checked.delete(id);
  label.classList.toggle('sel', on);
  document.getElementById('selCount').textContent = checked.size;
  document.getElementById('addSelBtn').disabled   = checked.size === 0;
}

/* ── Add all selected tests as table rows at once ── */
function addSelected() {
  if (!checked.size) return;
  document.getElementById('emptyMsg')?.remove();

  checked.forEach(testId => {
    const t = ALL_TESTS.find(x => x.id === testId);
    if (!t) return;
    const idx = newIdx++;
    const tr  = document.createElement('tr');
    tr.id = 'nrow-'+idx;
    tr.className = 'row-new';
    tr.innerHTML = `
      <td>
        <div class="tname">${t.name}
          <span style="font-size:.65rem;background:#dbeafe;color:#1d4ed8;padding:1px 7px;border-radius:10px;font-weight:600;margin-left:4px;">New</span>
        </div>
        <div class="tmeta">${t.code}</div>
        <input type="hidden" name="new_tests[${idx}][test_id]" value="${t.id}">
      </td>
      <td class="rack hide-sm">PKR ${t.rate.toLocaleString('en-PK')}</td>
      <td style="text-align:center">
        <input class="tbl-in n-disc" type="number" min="0" max="100" value="0"
          name="new_tests[${idx}][discount]"
          data-rate="${t.rate}" data-nidx="${idx}"
          oninput="refreshNew(this)">
      </td>
      <td style="text-align:center">
        <select class="tbl-sl" name="new_tests[${idx}][payment]">
          <option value="prepaid">Prepaid</option>
          <option value="cash">Cash</option>
        </select>
      </td>
      <td>
        <div class="pprice" id="nprice-${idx}">${fmt(t.rate)}</div>
        <div class="psave"  id="nsave-${idx}"></div>
      </td>
      <td>
        <button type="button" class="del-btn" onclick="removeNew(${idx},${testId})" title="Remove">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </td>`;
    document.getElementById('testsBody').appendChild(tr);
    bookedIds.add(testId);
  });

  checked.clear();
  document.getElementById('selCount').textContent = '0';
  document.getElementById('addSelBtn').disabled   = true;
  document.getElementById('testSearch').value     = '';
  renderList();
  recalc();
}

function refreshNew(inp) {
  const idx = inp.dataset.nidx, rate = +inp.dataset.rate;
  const {disc, pays} = calc(rate, +inp.value || 0);
  document.getElementById('nprice-'+idx).textContent = fmt(pays);
  document.getElementById('nsave-' +idx).textContent = disc > 0 ? 'save '+fmt(disc) : '';
  recalc();
}

function removeNew(idx, testId) {
  document.getElementById('nrow-'+idx)?.remove();
  bookedIds.delete(testId);
  renderList();
  recalc();
}

/* ── Summary ── */
function recalc() {
  let rack=0, disc=0, pays=0;
  document.querySelectorAll('.e-disc').forEach(inp => {
    if (toDelete.has(parseInt(inp.dataset.id))) return;
    const {disc:d, pays:p} = calc(+inp.dataset.rate, +inp.value||0);
    rack += +inp.dataset.rate; disc += d; pays += p;
  });
  document.querySelectorAll('.n-disc').forEach(inp => {
    const {disc:d, pays:p} = calc(+inp.dataset.rate, +inp.value||0);
    rack += +inp.dataset.rate; disc += d; pays += p;
  });
  document.getElementById('sumRack').textContent = fmt(rack);
  document.getElementById('sumPays').textContent = fmt(pays);
  const dr = document.getElementById('sumDiscRow');
  if (disc > 0) { dr.style.display='flex'; document.getElementById('sumDisc').textContent='− '+fmt(disc); }
  else          { dr.style.display='none'; }
}

function prepareDeleteIds() {
  const c = document.getElementById('deleteIdsContainer');
  c.innerHTML = '';
  toDelete.forEach(id => {
    const i = document.createElement('input');
    i.type='hidden'; i.name='delete_ids[]'; i.value=id;
    c.appendChild(i);
  });
}

function trashSvg() { return `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>`; }
function undoSvg()  { return `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>`; }

renderList();
recalc();
</script>

<?= view('templates/footer') ?>