
<?= view('templates/header', ['pageTitle' => 'Lab List', 'activePage' => 'lablist']) ?>

<div class="page-wrap">

  <!-- Page Header -->
  <div class="page-header">
  
    <a href="/booking/new" class="btn-new-booking">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      New Booking
    </a>
  </div>

  <!-- Stat Cards -->
  <div class="stats-row">
    <div class="stat-card total">
      <div class="stat-val c-total">167</div>
      <div class="stat-label">Total</div>
    </div>
    <div class="stat-card process">
      <div class="stat-val c-orange">0</div>
      <div class="stat-label">In Process</div>
    </div>
    <div class="stat-card assigned">
      <div class="stat-val c-blue">3</div>
      <div class="stat-label">Assigned</div>
    </div>
    <div class="stat-card arrived">
      <div class="stat-val c-purple">0</div>
      <div class="stat-label">Arrived</div>
    </div>
    <div class="stat-card collected">
      <div class="stat-val c-amber">3</div>
      <div class="stat-label">Collected</div>
    </div>
    <div class="stat-card report">
      <div class="stat-val c-green">148</div>
      <div class="stat-label">Report Ready</div>
    </div>
  </div>

  <!-- Tabs -->
  <div class="tab-row">
    <a href="#" class="tab-btn active" onclick="switchTab(event,'individual')">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Individual Leads
      <span class="tab-badge" id="tab-count-individual">167</span>
    </a>
    <a href="#" class="tab-btn" onclick="switchTab(event,'b2b')">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
      B2B Activities
      <span class="tab-badge">2</span>
    </a>
  </div>

<!-- Filter Bar — inputs now submit via GET -->
<div class="filter-bar">
  <form method="GET" action="" id="filterForm">
    <div class="filter-inner">
      <div class="date-group">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        <input type="date" name="date_from" class="date-input" id="dateFrom"
               value="<?= esc($filters['date_from'] ?? '') ?>"
               onchange="this.form.submit()"/>
        <span class="date-sep">to</span>
        <input type="date" name="date_to" class="date-input" id="dateTo"
               value="<?= esc($filters['date_to'] ?? '') ?>"
               onchange="this.form.submit()"/>
      </div>

      <div class="search-wrap">
        <span class="search-icon">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
        </span>
        <input type="text" name="search" class="search-input" id="searchInput"
               placeholder="Search patient, phone…"
               value="<?= esc($filters['search'] ?? '') ?>"
               oninput="debounceSubmit()"/>
      </div>

      <div class="pills-group">
        <?php
        $statuses = ['All','In Process','Phlebotomist Assigned','Arrived','Sample Collected','Report Ready','Refused'];
        $labels   = ['All','In Process','Phleb. Assigned','Arrived','Collected','Report Ready','Refused'];
        $activeStatus = $filters['status'] ?? 'All';
        foreach ($statuses as $i => $s):
            $isActive = ($activeStatus === $s || ($s === 'All' && empty($activeStatus)));
        ?>
        <button type="submit" name="status" value="<?= esc($s) ?>"
                class="pill <?= $isActive ? 'active' : '' ?>">
            <?= esc($labels[$i]) ?>
        </button>
        <?php endforeach; ?>
      </div>
    </div>
  </form>
</div>

<!-- Table -->
<div class="table-wrap">
  <table id="bookingsTable">
    <thead>
      <tr>
        <th>Patient</th>
        <th>Phone</th>
        <th>Tests</th>
        <th>Financials</th>
        <th>Status</th>
        <th>ETA</th>
        <th>Date</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($bookings)): ?>
        <tr>
          <td colspan="8" class="empty-state"><p>No bookings match your filters.</p></td>
        </tr>
      <?php else: ?>
        <?php
        $statusClassMap = [
            'Phlebotomist Assigned' => 'phleb',
            'Sample Collected'      => 'collected',
            'Report Ready'          => 'report',
            'Arrived'               => 'arrived',
            'In Process'            => 'in-process',
            'Refused'               => 'refused',
        ];
        foreach ($bookings as $b):
            $sc        = $statusClassMap[$b['status']] ?? 'in-process';
            $total     = $b['total'] ?? 0;
            $payable   = $b['payable'] ?? 0;
            $testCount = $b['test_count'] ?? 0;
            $tests     = $b['tests'] ?? [];
            $testNames = implode(', ', array_column($tests, 'test_name'));
            $etaTs     = strtotime($b['eta'] ?? '');
            $etaRed    = $etaTs && $etaTs < time();
            $etaLabel  = $etaTs ? date('M d, Y g:i A', $etaTs) : '—';
            $dateLabel = date('M d, g:i A', strtotime($b['date_created']));
        ?>
        <tr>
          <td>
            <div class="patient-name"><?= esc($b['patient_name']) ?></div>
            <div class="patient-meta">
              <?= esc($b['gender']) ?><?= $b['age'] ? ' · ' . esc($b['age']) . ' yrs' : '' ?>
            </div>
            <div class="patient-meta"><?= esc($b['home_address']) ?></div>
          </td>
          <td style="padding-top:20px;">
            <span class="patient-meta"><?= esc($b['phone_number']) ?></span>
          </td>
          <td>
            <div class="test-count"><?= $testCount ?> test<?= $testCount !== 1 ? 's' : '' ?></div>
            <div class="test-desc" title="<?= esc($testNames) ?>"><?= esc($testNames ?: '—') ?></div>
          </td>
          <td>
            <div class="price-main">PKR <?= number_format($payable) ?></div>
            <?php if ($total > $payable): ?>
              <div class="price-strike">PKR <?= number_format($total) ?></div>
            <?php endif; ?>
          </td>
          <td>
            <span class="status-badge <?= $sc ?>"><?= esc($b['status']) ?></span>
          </td>
          <td>
            <div class="eta-val" style="color:<?= $etaRed ? '#dc2626' : '#6b7280' ?>">
              <?= esc($etaLabel) ?>
            </div>
          </td>
          <td>
            <div class="date-val"><?= esc($dateLabel) ?></div>
          </td>
          <td>
            <a href="/booking/view/<?= $b['id'] ?>" class="btn-view">
              View &amp; Update
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
              </svg>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
// Debounce search so it doesn't fire on every keystroke
let searchTimer;
function debounceSubmit() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 500);
}

// Set today's date in header
const now = new Date();
document.getElementById('todayDate').textContent = now.toLocaleDateString('en-US', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
});

function switchTab(e, tab) {
    e.preventDefault();
    document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));
    e.currentTarget.classList.add('active');
}
</script>

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Inter', sans-serif;
  background: #f0f4f8;
  color: #111827;
  min-height: 100vh;
}

/* ── Navbar ── */
.navbar {
  background: #fff;
  border-bottom: 1px solid #e5e7eb;
  padding: 0 32px;
  height: 58px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky; top: 0; z-index: 100;
}

.nav-brand {
  display: flex; align-items: center; gap: 10px;
}
.nav-brand .logo-box {
  width: 36px; height: 36px; border-radius: 10px;
  background: #0f3460;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 16px; font-weight: 700;
}
.nav-brand .brand-text {
  line-height: 1.1;
}
.nav-brand .brand-name { font-size: 15px; font-weight: 700; color: #0f172a; }
.nav-brand .brand-sub  { font-size: 11px; color: #6b7280; }

.nav-right {
  display: flex; align-items: center; gap: 24px;
}
.nav-link-item {
  font-size: 13px; color: #374151; text-decoration: none;
  display: flex; align-items: center; gap: 6px;
  cursor: pointer;
}
.nav-link-item:hover { color: #0f3460; }

.nav-user {
  display: flex; align-items: center; gap: 8px;
}
.nav-avatar {
  width: 32px; height: 32px; border-radius: 50%;
  background: #e5e7eb;
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; color: #6b7280;
}
.nav-user-info { line-height: 1.2; }
.nav-user-name  { font-size: 13px; font-weight: 600; color: #111827; }
.nav-user-role  {
  font-size: 11px; font-weight: 600;
  color: #0b5d8b; background: #e0f0fa;
  border-radius: 4px; padding: 1px 6px;
  display: inline-block;
}

.btn-signout {
  font-size: 13px; color: #6b7280;
  text-decoration: none; display: flex; align-items: center; gap: 5px;
  cursor: pointer; border: none; background: none;
}
.btn-signout:hover { color: #dc2626; }

/* ── Page Wrap ── */
.page-wrap { padding: 28px 32px; max-width: 1440px; margin: 0 auto; }

/* ── Page Header ── */
.page-header {
  display: flex; align-items: flex-start;
  justify-content: space-between; margin-bottom: 24px;
}
.page-header h1 {
  font-size: 26px; font-weight: 700; color: #111827; margin-bottom: 2px;
}
.page-header .page-date { font-size: 13px; color: #6b7280; }

.btn-new-booking {
  display: inline-flex; align-items: center; gap: 8px;
  background: #0f3460; color: #fff;
  font-size: 14px; font-weight: 600;
  padding: 10px 20px; border-radius: 12px;
  border: none; cursor: pointer; text-decoration: none;
  transition: background .15s;
}
.btn-new-booking:hover { background: #0b2a4f; color: #fff; }

/* ── Stat Cards ── */
.stats-row {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 12px;
  margin-bottom: 24px;
}

.stat-card {
  border-radius: 16px;
  padding: 18px 20px;
  border: 1px solid #e8ebef;
}
.stat-card.total    { background: #ffffff; }
.stat-card.process  { background: #fdf8ed; }
.stat-card.assigned { background: #edf5fb; }
.stat-card.arrived  { background: #eef0fb; }
.stat-card.collected{ background: #fdf2e9; }
.stat-card.report   { background: #eef8f0; }

.stat-val   { font-size: 38px; font-weight: 700; line-height: 1; margin-bottom: 6px; }
.stat-label { font-size: 13px; color: #6b7280; }

.c-total    { color: #0f172a; }
.c-orange   { color: #b96d00; }
.c-blue     { color: #0b5d8b; }
.c-purple   { color: #4f46e5; }
.c-amber    { color: #c76a15; }
.c-green    { color: #0c7a43; }

/* ── Tabs ── */
.tab-row {
  display: flex; gap: 8px; margin-bottom: 16px;
}
.tab-btn {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 13px; font-weight: 500; padding: 8px 14px;
  border-radius: 10px; border: 1px solid #e5e7eb;
  background: #f9fafb; color: #374151;
  cursor: pointer; transition: all .15s;
  text-decoration: none;
}
.tab-btn.active {
  background: #fff; border-color: #d1d5db; color: #111827;
  box-shadow: 0 1px 3px rgba(0,0,0,.07);
}
.tab-badge {
  background: #e5e7eb; color: #374151;
  font-size: 11px; padding: 1px 7px;
  border-radius: 999px;
}
.tab-btn.active .tab-badge { background: #dbeafe; color: #1e40af; }

/* ── Filter Bar ── */
.filter-bar {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  padding: 16px 20px;
  margin-bottom: 16px;
}
.filter-inner {
  display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
}

.date-group {
  display: flex; align-items: center; gap: 8px;
}
.date-input {
  height: 38px; min-width: 150px;
  border: 1px solid #d1d5db; border-radius: 10px;
  background: #fff; color: #374151;
  padding: 0 12px; font-size: 13px; font-family: inherit;
  outline: none;
}
.date-input:focus { border-color: #0b5d8b; }
.date-sep { font-size: 13px; color: #9ca3af; }

.search-wrap { position: relative; }
.search-input {
  height: 38px; width: 220px;
  border: 1px solid #d1d5db; border-radius: 10px;
  background: #fff; color: #374151;
  padding: 0 12px 0 36px; font-size: 13px; font-family: inherit;
  outline: none;
}
.search-input:focus { border-color: #0b5d8b; }
.search-icon {
  position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
  color: #9ca3af; font-size: 14px; pointer-events: none;
}

.pills-group {
  display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-left: auto;
}
.funnel-icon { color: #9ca3af; font-size: 14px; }

.pill {
  display: inline-flex; align-items: center;
  padding: 6px 14px; border-radius: 999px;
  border: 1px solid #d1d5db;
  background: #fff; color: #4b5563;
  font-size: 12px; font-weight: 500;
  cursor: pointer; transition: all .15s; user-select: none;
}
.pill:hover  { border-color: #0b5d8b; color: #0b5d8b; }
.pill.active { background: #0b5d8b; color: #fff; border-color: #0b5d8b; }

/* ── Table ── */
.table-wrap {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 18px;
  overflow: hidden;
}

table { width: 100%; border-collapse: collapse; }

thead th {
  background: #fafafa;
  color: #9ca3af;
  font-size: 11px; font-weight: 700;
  letter-spacing: .06em; text-transform: uppercase;
  padding: 14px 16px;
  border-bottom: 1px solid #f1f5f9;
  white-space: nowrap;
}

tbody tr {
  border-bottom: 1px solid #f1f5f9;
  transition: background .1s;
}
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: #fafafa; }

tbody td { padding: 16px; vertical-align: top; }

.patient-name { font-weight: 600; font-size: 14px; color: #111827; margin-bottom: 2px; }
.patient-meta { font-size: 12px; color: #6b7280; margin-bottom: 1px; }

.test-count  { font-weight: 600; font-size: 13px; color: #111827; margin-bottom: 2px; }
.test-desc   { font-size: 12px; color: #6b7280; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 220px; }

.badge-tag {
  display: inline-flex; align-items: center; gap: 4px;
  font-size: 11px; padding: 4px 10px; border-radius: 999px; margin-top: 2px;
}
.badge-tag.timings  { background: #e8f8ee; color: #15803d; }
.badge-tag.same-day { background: #e0f0fa; color: #0b5d8b; }
.badge-tag.reports  { background: #fff1dd; color: #d97706; }

.price-main   { font-weight: 700; font-size: 14px; color: #111827; }
.price-strike { font-size: 12px; color: #9ca3af; text-decoration: line-through; }

.status-badge {
  display: inline-block; font-size: 12px; font-weight: 500;
  padding: 6px 14px; border-radius: 999px; white-space: nowrap;
}
.status-badge.phleb    { background: #dbeafe; color: #1e40af; }
.status-badge.collected{ background: #fde8cc; color: #c76a15; }
.status-badge.report   { background: #dcfce7; color: #15803d; }
.status-badge.arrived  { background: #e0f2fe; color: #0369a1; }
.status-badge.in-process { background: #fef9c3; color: #854d0e; }
.status-badge.refused  { background: #fee2e2; color: #dc2626; }

.eta-val  { font-size: 12px; font-weight: 600; color: #dc2626; }
.date-val { font-size: 12px; color: #6b7280; }

.btn-view {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 13px; font-weight: 600; color: #0b5d8b;
  text-decoration: none; white-space: nowrap;
  border: none; background: none; cursor: pointer;
}
.btn-view:hover { color: #08496d; }
.btn-view svg { width: 14px; height: 14px; }

/* ── Empty State ── */
.empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }
.empty-state p { font-size: 14px; }

/* ── Responsive ── */
@media (max-width: 1100px) {
  .stats-row { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 700px) {
  .stats-row { grid-template-columns: repeat(2, 1fr); }
  .page-wrap { padding: 16px; }
  .pills-group { margin-left: 0; }
  thead { display: none; }
  tbody td { display: block; }
}
</style>

<?= view('templates/footer') ?>