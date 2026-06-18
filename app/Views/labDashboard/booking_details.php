<?= view('templates/header', ['pageTitle' => 'Booking Details', 'activePage' => 'lablist']) ?>

<style>
.detail-wrap      { max-width: 760px; margin: 0 auto; padding: 24px 16px 60px; }
.back-bar         { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.back-btn         { display:inline-flex; align-items:center; gap:6px; color:#374151; text-decoration:none; font-size:14px; font-weight:500; }
.back-btn:hover   { color:#1d4ed8; }
.page-title       { font-size:1.4rem; font-weight:700; color:#111827; margin-top:4px; }
.booking-ref      { font-size:.75rem; color:#9ca3af; margin-top:2px; }

/* Status chip */
.status-chip { padding:6px 16px; border-radius:20px; font-size:.78rem; font-weight:600; }
.chip-phleb       { background:#dbeafe; color:#1d4ed8; }
.chip-in-process  { background:#fef9c3; color:#854d0e; }
.chip-arrived     { background:#e0f2fe; color:#0369a1; }
.chip-collected   { background:#fde8cc; color:#c76a15; }
.chip-report      { background:#dcfce7; color:#15803d; }

/* Card */
.d-card { background:#fff; border-radius:14px; border:1px solid #e5e7eb; padding:22px; margin-bottom:16px; }
.d-card-title { font-size:.9rem; font-weight:700; color:#111827; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
.d-card-title i { color:#6b7280; }

/* Progress */
.progress-bar-wrap { display:flex; align-items:center; margin:10px 0 8px; }
.step-dot { width:30px; height:30px; border-radius:50%; border:2px solid #d1d5db; background:#fff; display:flex; align-items:center; justify-content:center; flex-shrink:0; z-index:1; }
.step-dot.done { background:#1d4ed8; border-color:#1d4ed8; }
.step-dot.done svg { display:block; }
.step-dot svg { display:none; }
.step-connector { flex:1; height:3px; background:#d1d5db; }
.step-connector.done { background:#1d4ed8; }
.steps-labels { display:flex; justify-content:space-between; margin-top:6px; }
.step-lbl { font-size:.65rem; color:#9ca3af; text-align:center; flex:1; }
.step-lbl.active { color:#1d4ed8; font-weight:600; }
.step-lbl.done-lbl { color:#374151; }

/* ETA chip */
.eta-chip { display:inline-flex; align-items:center; gap:6px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:20px; padding:5px 14px; font-size:.78rem; color:#1d4ed8; font-weight:500; }

/* Action button */
.action-btn { display:inline-flex; align-items:center; gap:8px; margin-top:16px; padding:10px 22px; border-radius:10px; font-size:.85rem; font-weight:600; text-decoration:none; border:none; cursor:pointer; }
.action-btn.blue  { background:#1d4ed8; color:#fff; }
.action-btn.green { background:#16a34a; color:#fff; }
.action-btn:hover { opacity:.9; }

/* Info rows */
.info-row { display:flex; align-items:flex-start; gap:12px; margin-bottom:14px; }
.info-icon { color:#9ca3af; margin-top:1px; flex-shrink:0; }
.info-label { font-size:.7rem; color:#9ca3af; margin-bottom:2px; letter-spacing:.03em; }
.info-val   { font-size:.92rem; color:#111827; font-weight:500; }

/* Instructions card */
.inst-card { background:#fffbeb; border:1px solid #fde68a; border-radius:14px; padding:20px; margin-bottom:16px; }
.inst-title { font-size:.9rem; font-weight:700; color:#92400e; display:flex; align-items:center; gap:8px; margin-bottom:12px; }
.pin-label  { font-size:.7rem; font-weight:700; color:#92400e; letter-spacing:.05em; margin-bottom:4px; }
.pin-link   { display:inline-flex; align-items:center; gap:5px; font-size:.82rem; color:#d97706; font-weight:600; text-decoration:none; }
.notes-label{ font-size:.7rem; font-weight:700; color:#92400e; letter-spacing:.05em; margin-top:12px; margin-bottom:4px; }
.notes-val  { font-size:.88rem; color:#374151; }
.edit-link  { font-size:.78rem; color:#9ca3af; text-decoration:none; display:flex; align-items:center; gap:4px; }
.edit-link:hover { color:#1d4ed8; }

/* Phlebotomist card */
.phleb-card { background:#f0f7ff; border:1px solid #bfdbfe; border-radius:14px; padding:20px; margin-bottom:16px; }
.phleb-title{ font-size:.9rem; font-weight:700; color:#1e40af; display:flex; align-items:center; gap:8px; margin-bottom:14px; }
.phleb-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.phleb-label{ font-size:.7rem; color:#6b7280; margin-bottom:2px; }
.phleb-val  { font-size:.95rem; font-weight:700; color:#111827; }
.phleb-val.blue { color:#1d4ed8; }

/* Tests table */
.tests-table { width:100%; border-collapse:collapse; font-size:.83rem; }
.tests-table th { color:#9ca3af; font-weight:600; padding:8px 10px; border-bottom:1px solid #f3f4f6; font-size:.7rem; letter-spacing:.04em; text-transform:uppercase; }
.tests-table td { padding:12px 10px; border-bottom:1px solid #f9fafb; color:#111827; vertical-align:top; }
.tests-table tbody tr:last-child td { border-bottom:none; }
.save-txt { color:#16a34a; font-size:.75rem; margin-top:2px; }
.price-txt { font-weight:600; }

/* Financials */
.fin-row { display:flex; justify-content:space-between; align-items:center; font-size:.87rem; color:#374151; margin-bottom:10px; }
.fin-row.total-row { font-weight:700; font-size:1rem; color:#111827; border-top:1px solid #e5e7eb; padding-top:12px; margin-top:4px; }
.fin-row .disc { color:#dc2626; font-weight:500; }
.view-invoice { font-size:.78rem; color:#1d4ed8; text-decoration:none; display:inline-flex; align-items:center; gap:4px; }

/* History */
.history-list { list-style:none; padding:0; margin:0; }
.history-list li { display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f9fafb; font-size:.83rem; }
.history-list li:last-child { border-bottom:none; }
.h-dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; }
.h-dot.in-process           { background:#fbbf24; }
.h-dot.phlebotomist-assigned{ background:#93c5fd; }
.h-dot.phlebotomist-arrived { background:#a78bfa; }
.h-dot.sample-collected     { background:#f87171; }
.h-dot.report-ready         { background:#34d399; }
.h-badge { padding:3px 10px; border-radius:10px; font-size:.72rem; font-weight:600; }
.h-badge.in-process           { background:#fef9c3; color:#854d0e; }
.h-badge.phlebotomist-assigned{ background:#dbeafe; color:#1e40af; }
.h-badge.phlebotomist-arrived { background:#ede9fe; color:#5b21b6; }
.h-badge.sample-collected     { background:#fde8cc; color:#c76a15; }
.h-badge.report-ready         { background:#dcfce7; color:#15803d; }
.h-time { margin-left:auto; color:#9ca3af; font-size:.75rem; white-space:nowrap; }

.footer-meta { font-size:.75rem; color:#9ca3af; text-align:center; margin-top:12px; }

@media(max-width:600px){
  .phleb-grid { grid-template-columns:1fr; }
  .steps-labels .step-lbl { font-size:.55rem; }
}
</style>

<div class="detail-wrap">

  <!-- Back bar -->
  <div class="back-bar">
    <div>
      <a href="<?= base_url('labDashboard/dashboard') ?>" class="back-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Back
      </a>
      <div class="page-title">Booking Details</div>
      <div class="booking-ref">Patient #<?= esc($patient['id']) ?></div>
    </div>
    <?php
      $chipClass = match($currentStatus) {
        'In Process'            => 'chip-in-process',
        'Phlebotomist Assigned' => 'chip-phleb',
        'Phlebotomist Arrived'  => 'chip-arrived',
        'Sample Collected'      => 'chip-collected',
        'Report Ready'          => 'chip-report',
        default                 => 'chip-in-process',
      };
    ?>
    <span class="status-chip <?= $chipClass ?>"><?= esc($currentStatus) ?></span>
  </div>

  <!-- Status Progress -->
  <div class="d-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
      <span class="d-card-title" style="margin-bottom:0;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Status Progress
      </span>
      <?php if (!empty($latestBooking['eta'])): ?>
        <div class="eta-chip">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          ETA &nbsp;|&nbsp; <?= date('M d, Y, g:i A', strtotime($latestBooking['eta'])) ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="progress-bar-wrap">
      <?php foreach ($statusSteps as $i => $step): ?>
        <div class="step-dot <?= $i <= $currentStepIdx ? 'done' : '' ?>">
          <svg width="13" height="13" viewBox="0 0 12 12" fill="none">
            <path d="M2 6l3 3 5-5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <?php if ($i < count($statusSteps) - 1): ?>
          <div class="step-connector <?= $i < $currentStepIdx ? 'done' : '' ?>"></div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <div class="steps-labels">
      <?php foreach ($statusSteps as $i => $step): ?>
        <div class="step-lbl <?= $i === $currentStepIdx ? 'active' : ($i < $currentStepIdx ? 'done-lbl' : '') ?>">
          <?= esc($step) ?>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if ($currentStatus === 'Phlebotomist Assigned'): ?>
      <a href="<?= base_url('booking/markArrived/' . $latestBooking['id']) ?>" class="action-btn blue">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        Mark Phlebotomist Arrived
      </a>
    <?php elseif ($currentStatus === 'Phlebotomist Arrived'): ?>
      <a href="<?= base_url('booking/markCollected/' . $latestBooking['id']) ?>" class="action-btn green">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        Mark Sample Collected
      </a>
    <?php endif; ?>
  </div>

  <!-- Patient Info -->
  <div class="d-card">
    <div class="d-card-title">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Patient Information
    </div>

    <div class="info-row">
      <svg class="info-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      <div><div class="info-label">Name</div><div class="info-val"><?= esc($patient['patient_name']) ?></div></div>
    </div>

    <div class="info-row">
      <svg class="info-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.7A2 2 0 012 .18h3a2 2 0 012 1.72c.13 1 .36 1.97.71 2.91a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1-1.07a2 2 0 012.11-.45c.94.35 1.91.58 2.91.71A2 2 0 0122 14.92z"/></svg>
      <div><div class="info-label">Phone</div><div class="info-val"><?= esc($patient['phone_number']) ?></div></div>
    </div>

    <div class="info-row">
      <svg class="info-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
      <div><div class="info-label">Address</div><div class="info-val"><?= esc($patient['home_address']) ?></div></div>
    </div>

    <div class="info-row">
      <svg class="info-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <div>
        <div class="info-label">Age / Gender</div>
        <div class="info-val">
          <?php
            $parts = [];
            if (!empty($patient['age']))    $parts[] = $patient['age'] . ' yrs';
            if (!empty($patient['gender'])) $parts[] = $patient['gender'];
            echo esc(implode(' / ', $parts) ?: '—');
          ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Instructions & Location -->
  <?php if (!empty($patient['pin_location']) || !empty($patient['instructions'])): ?>
  <div class="inst-card">
    <div class="inst-title">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
      Instructions &amp; Location
    </div>
    <?php if (!empty($patient['pin_location'])): ?>
      <div class="pin-label">PIN LOCATION</div>
      <a href="<?= esc($patient['pin_location']) ?>" target="_blank" class="pin-link">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        View on Map
      </a>
    <?php endif; ?>
    <?php if (!empty($patient['instructions'])): ?>
      <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-top:10px;">
        <div>
          <div class="notes-label">NOTES / INSTRUCTIONS</div>
          <div class="notes-val"><?= esc($patient['instructions']) ?></div>
        </div>
        <a href="#" class="edit-link">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Edit
        </a>
      </div>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <!-- Phlebotomist (show only if assigned) -->
  <?php if (!empty($latestBooking['fk_phlebotomist_id']) || $currentStatus === 'Phlebotomist Assigned'): ?>
  <div class="phleb-card">
    <div class="phleb-title">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1e40af" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Phlebotomist
    </div>
    <div class="phleb-grid">
      <div>
        <div class="phleb-label">Name</div>
        <div class="phleb-val"><?= esc($latestBooking['phlebotomist_name'] ?? 'Assigned') ?></div>
      </div>
      <?php if (!empty($latestBooking['eta'])): ?>
      <div>
        <div class="phleb-label">ETA</div>
        <div class="phleb-val blue"><?= date('M d, Y, g:i A', strtotime($latestBooking['eta'])) ?></div>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- Tests Ordered -->
  <div class="d-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
      <span class="d-card-title" style="margin-bottom:0;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"/></svg>
        Tests Ordered
      </span>
      <a href="<?= base_url('booking/editTests/' . $patient['id']) ?>" class="view-invoice">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Edit Tests
      </a>
    </div>

    <table class="tests-table">
      <thead>
        <tr>
          <th>Code</th>
          <th>Test Name</th>
          <th>Reporting Time</th>
          <th>Patient Price</th>
          <th>Payment</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($testsOrdered as $item): ?>
        <tr>
          <td><?= esc($item['test']['test_code'] ?? '—') ?></td>
          <td><?= esc($item['test']['test_name']) ?></td>
          <td><?= esc($item['test']['reporting_time'] ?? '—') ?></td>
          <td>
            <div class="price-txt">PKR <?= number_format($item['patient_price']) ?></div>
            <?php if ($item['discount_amt'] > 0): ?>
              <div class="save-txt">
                save <?= $item['booking']['discount_percent'] ?>%
                (PKR <?= number_format($item['discount_amt']) ?>)
              </div>
            <?php endif; ?>
          </td>
          <td><?= ucfirst(esc($item['booking']['paid_status'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Financial Breakdown -->
  <div class="d-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
      <span class="d-card-title" style="margin-bottom:0;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
        Financial Breakdown
      </span>
     <!-- In the Financial Breakdown section -->
<a href="<?= base_url('booking/invoice/' . $latestBooking['id']) ?>" class="view-invoice" target="_blank">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
    </svg>
    View Invoice
</a>
    </div>

    <div class="fin-row">
      <span>Original Total (Rack Rate)</span>
      <span>PKR <?= number_format($originalTotal) ?></span>
    </div>
    <?php if ($discountTotal > 0): ?>
    <div class="fin-row">
      <span>Discount (<?= $testsOrdered[0]['booking']['discount_percent'] ?? 0 ?>%)</span>
      <span class="disc">− PKR <?= number_format($discountTotal) ?></span>
    </div>
    <?php endif; ?>
    <div class="fin-row total-row">
      <span>Patient Pays</span>
      <span>PKR <?= number_format($patientPays) ?></span>
    </div>
  </div>

  <!-- Status History -->
  <?php if (!empty($statusHistory)): ?>
  <div class="d-card">
    <div class="d-card-title">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      Status History
    </div>
    <ul class="history-list">
      <?php foreach (array_reverse($statusHistory) as $h):
        $slug = strtolower(str_replace(' ', '-', $h['status']));
      ?>
        <li>
          <div class="h-dot <?= esc($slug) ?>"></div>
          <span class="h-badge <?= esc($slug) ?>"><?= esc($h['status']) ?></span>
          <span class="h-time"><?= date('M d, Y — g:i A', strtotime($h['changed_at'])) ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>

  <div class="footer-meta">
    Created: <?= date('M d, Y g:i A', strtotime($latestBooking['date_created'])) ?>
    &nbsp;|&nbsp; Patient #<?= esc($patient['id']) ?>
  </div>

</div>

<?= view('templates/footer') ?>