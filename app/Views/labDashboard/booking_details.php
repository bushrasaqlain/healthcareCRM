<?= view('templates/header', ['pageTitle' => 'Booking Details', 'activePage' => 'lablist']) ?>

<style>
.detail-wrap { max-width: 760px; margin: 0 auto; padding: 24px 16px 60px; }
.back-bar { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.back-btn { display:inline-flex; align-items:center; gap:6px; color:#374151; text-decoration:none; font-size:14px; font-weight:500; }
.back-btn:hover { color:#1d4ed8; }
.page-title { font-size:1.4rem; font-weight:700; color:#111827; margin-top:4px; }
.booking-ref { font-size:.75rem; color:#9ca3af; margin-top:2px; }

/* Status chip */
.status-chip { padding:6px 16px; border-radius:20px; font-size:.78rem; font-weight:600; }
.chip-phleb { background:#dbeafe; color:#1d4ed8; }
.chip-in-process { background:#fef9c3; color:#854d0e; }
.chip-arrived { background:#e0f2fe; color:#0369a1; }
.chip-collected { background:#fde8cc; color:#c76a15; }
.chip-report { background:#dcfce7; color:#15803d; }

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
.action-btn.blue { background:#1d4ed8; color:#fff; }
.action-btn.green { background:#16a34a; color:#fff; }
.action-btn.orange { background:#f59e0b; color:#fff; }
.action-btn:hover { opacity:.9; }

/* Info rows */
.info-row { display:flex; align-items:flex-start; gap:12px; margin-bottom:14px; }
.info-icon { color:#9ca3af; margin-top:1px; flex-shrink:0; }
.info-label { font-size:.7rem; color:#9ca3af; margin-bottom:2px; letter-spacing:.03em; }
.info-val { font-size:.92rem; color:#111827; font-weight:500; }

/* Instructions card */
.inst-card { background:#fffbeb; border:1px solid #fde68a; border-radius:14px; padding:20px; margin-bottom:16px; }
.inst-title { font-size:.9rem; font-weight:700; color:#92400e; display:flex; align-items:center; gap:8px; margin-bottom:12px; }
.pin-label { font-size:.7rem; font-weight:700; color:#92400e; letter-spacing:.05em; margin-bottom:4px; }
.pin-link { display:inline-flex; align-items:center; gap:5px; font-size:.82rem; color:#d97706; font-weight:600; text-decoration:none; }
.notes-label{ font-size:.7rem; font-weight:700; color:#92400e; letter-spacing:.05em; margin-top:12px; margin-bottom:4px; }
.notes-val { font-size:.88rem; color:#374151; }
.edit-link { font-size:.78rem; color:#9ca3af; text-decoration:none; display:flex; align-items:center; gap:4px; }
.edit-link:hover { color:#1d4ed8; }

/* Phlebotomist card */
.phleb-card { background:#f0f7ff; border:1px solid #bfdbfe; border-radius:14px; padding:20px; margin-bottom:16px; }
.phleb-title{ font-size:.9rem; font-weight:700; color:#1e40af; display:flex; align-items:center; gap:8px; margin-bottom:14px; }
.phleb-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.phleb-label{ font-size:.7rem; color:#6b7280; margin-bottom:2px; }
.phleb-val { font-size:.95rem; font-weight:700; color:#111827; }
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
.h-dot.in-process { background:#fbbf24; }
.h-dot.phlebotomist-assigned{ background:#93c5fd; }
.h-dot.phlebotomist-arrived { background:#a78bfa; }
.h-dot.sample-collected { background:#f87171; }
.h-dot.report-ready { background:#34d399; }
.h-badge { padding:3px 10px; border-radius:10px; font-size:.72rem; font-weight:600; }
.h-badge.in-process { background:#fef9c3; color:#854d0e; }
.h-badge.phlebotomist-assigned{ background:#dbeafe; color:#1e40af; }
.h-badge.phlebotomist-arrived { background:#ede9fe; color:#5b21b6; }
.h-badge.sample-collected { background:#fde8cc; color:#c76a15; }
.h-badge.report-ready { background:#dcfce7; color:#15803d; }
.h-time { margin-left:auto; color:#9ca3af; font-size:.75rem; white-space:nowrap; }

.footer-meta { font-size:.75rem; color:#9ca3af; text-align:center; margin-top:12px; }

/* Upload Reports Section */
.upload-card { border: 2px dashed #3b82f6; background: #f0f9ff; }
.upload-card .d-card-title { color: #1e40af; }
.upload-progress { margin-top:12px; padding-top:12px; border-top:1px solid #e5e7eb; }
.upload-progress-bar { width:100%; height:6px; background:#e5e7eb; border-radius:3px; overflow:hidden; }
.upload-progress-fill { height:100%; background:#3b82f6; transition:width 0.3s; }
.test-checkbox-grid { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
.test-checkbox-item { display:flex; align-items:center; gap:8px; padding:8px 12px; background:#fff; border:1px solid #e5e7eb; border-radius:6px; font-size:.82rem; cursor:pointer; }
.test-checkbox-item.uploaded { opacity:0.6; background:#f3f4f6; }
.test-checkbox-item input[type="checkbox"] { width:16px; height:16px; cursor:pointer; }
.test-checkbox-item .check-label { flex:1;color: black;}
.test-checkbox-item .uploaded-badge { color:#16a34a; font-size:.7rem; }
.file-upload-input { width:100%; padding:8px; border:1px solid #d1d5db; border-radius:6px; font-size:.85rem;color: black; }
.file-upload-hint { font-size:.7rem; color:#9ca3af; margin-top:4px; }

@media(max-width:600px){
  .phleb-grid { grid-template-columns:1fr; }
  .steps-labels .step-lbl { font-size:.55rem; }
  .test-checkbox-grid { grid-template-columns:1fr; }
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
        'Arrived'               => 'chip-arrived',
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

    <!-- Action Buttons -->
    <?php if ($currentStatus === 'Phlebotomist Assigned'): ?>
      <a href="<?= base_url('booking/status/' . $latestBooking['id'] . '/arrived') ?>" class="action-btn blue">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
          <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        Mark Phlebotomist Arrived
      </a>
    <?php elseif ($currentStatus === 'Arrived'): ?>
      <a href="<?= base_url('booking/status/' . $latestBooking['id'] . '/collected') ?>" class="action-btn green">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
          <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        Mark Sample Collected
      </a>
    <?php elseif ($currentStatus === 'Sample Collected'): ?>
      <div style="margin-top:16px; font-size:.85rem; color:#0369a1; background:#e0f2fe; padding:12px 16px; border-radius:8px; display:flex; align-items:center; gap:8px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="16" x2="12" y2="12"/>
          <line x1="12" y1="8" x2="12.01" y2="8"/>
        </svg>
        Upload lab reports to complete the booking
      </div>
    <?php endif; ?>
  </div>

  <!-- Upload Lab Reports - Only show when status is Sample Collected -->
 <!-- Upload Lab Reports - Only show when status is Sample Collected -->
<?php 
if ($currentStatus === 'Sample Collected'):
    // Ensure bookingId is set
    $bookingId = $bookingId ?? $latestBooking['id'] ?? 0;
?>
<div class="d-card upload-card">
    <div class="d-card-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="12" y1="18" x2="12" y2="12"/>
            <line x1="9" y1="15" x2="15" y2="15"/>
        </svg>
        Upload Lab Reports
    </div>
    
    <p style="color:#4b5563; font-size:.85rem; margin-bottom:16px;">
        Check the tests covered by your report, then upload one PDF. One PDF can cover multiple tests.
    </p>
    
    <form action="<?= base_url('booking/uploadReport/' . $bookingId) ?>" method="post" enctype="multipart/form-data" id="uploadReportForm">
        <?= csrf_field() ?>
        
        <div style="margin-bottom:16px;">
            <div style="font-size:.78rem; font-weight:600; color:#374151; margin-bottom:8px;">Select Tests for this Report:</div>
            <div class="test-checkbox-grid">
                <?php 
                $uploadedCount = 0;
                $totalTests = count($testsOrdered);
                foreach ($testsOrdered as $test): 
                    $hasReport = isset($test['has_report']) && $test['has_report'];
                    if ($hasReport) $uploadedCount++;
                ?>
                    <label class="test-checkbox-item <?= $hasReport ? 'uploaded' : '' ?>">
                        <input type="checkbox" name="test_ids[]" value="<?= $test['booking']['fk_test_id'] ?>" 
                               <?= $hasReport ? 'disabled checked' : '' ?>>
                        <span class="check-label">
                             <?= esc($test['test']['test_name']) ?> - <?= esc($test['test']['test_code']) ?> 
                        </span>
                        <?php if ($hasReport): ?>
                            <span class="uploaded-badge">✓ Uploaded</span>
                        <?php endif; ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div style="margin-bottom:16px;">
            <label style="display:block; font-size:.78rem; font-weight:600; color:#374151; margin-bottom:4px;">Upload PDF Report</label>
            <input type="file" name="report_file" accept=".pdf" required class="file-upload-input" id="reportFile">
            <div class="file-upload-hint">PDF only, max 10MB. Booking auto-completes when all tests are reported.</div>
            <div id="fileError" style="color:#dc2626; font-size:.75rem; margin-top:4px; display:none;"></div>
        </div>
        
        <button type="submit" class="action-btn blue" id="uploadBtn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                <polyline points="17 8 12 3 7 8"/>
                <line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
            Upload Report
        </button>
    </form>
    
    <!-- Upload Progress -->
    
</div>
<?php endif; ?>

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
          <?php if ($currentStatus === 'Sample Collected'): ?>
          <th>Report</th>
          <?php endif; ?>
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
          <td><?= ucfirst(esc($item['booking']['payment_method'])) ?></td>
          <?php if ($currentStatus === 'Sample Collected'): ?>
          <td>
            <?php if (isset($item['has_report']) && $item['has_report']): ?>
              <span style="color:#16a34a; font-size:.75rem; display:flex; align-items:center; gap:4px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                  <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                Uploaded
              </span>
            <?php else: ?>
              <span style="color:#9ca3af; font-size:.75rem;">Pending</span>
            <?php endif; ?>
          </td>
          <?php endif; ?>
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
<!-- Payment Status -->

<div class="d-card">
    <div class="d-card-title">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="1" x2="12" y2="23"/>
            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
        </svg>
        Payment
    </div>

    <?php 
    // Get payment status from the first test
    $paymentStatus = $testsOrdered[0]['booking']['payment_status'] ?? 'unpaid';
    $isPaid = $paymentStatus === 'paid';
    $totalTests = count($testsOrdered);
    $paidTests = 0;
    foreach ($testsOrdered as $item) {
        if (isset($item['booking']['payment_status']) && $item['booking']['payment_status'] === 'paid') {
            $paidTests++;
        }
    }
    ?>

    <!-- Test Payment List -->
    <div style="margin-bottom:16px;">
        <?php foreach ($testsOrdered as $index => $item): 
            $testPaymentStatus = $item['booking']['payment_status'] ?? 'unpaid';
            $isTestPaid = $testPaymentStatus === 'paid';
        ?>
        <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f3f4f6; <?= $index === count($testsOrdered) - 1 ? 'border-bottom:none;' : '' ?>">
            <span style="font-size:.88rem; color:#111827; font-weight:500;">
                <?= esc($item['test']['test_name']) ?>
            </span>
            <span style="font-size:.82rem; color:#6b7280;">
                <?php if ($isTestPaid): ?>
                    <span style="color:#16a34a; font-weight:600;">✓ Paid</span>
                <?php else: ?>
                    <span style="color:#dc2626; font-weight:500;">Pending</span>
                <?php endif; ?>
            </span>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Action Buttons -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; padding-top:12px; border-top:1px solid #e5e7eb;">
       
        
        <?php if (!$isPaid): ?>
            <form action="<?= base_url('booking/markPaymentPaid/' . $bookingId) ?>" method="post" onsubmit="return confirm('Mark all tests as PAID?');">
                <?= csrf_field() ?>
                <button type="submit" class="action-btn green" style="background:#16a34a; color:#fff; border:none; padding:10px 24px; border-radius:10px; font-size:.85rem; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    Mark Cash Collected (<?= $totalTests ?> tests)
                </button>
            </form>
        <?php else: ?>
            <div style="display:flex; align-items:center; gap:8px; color:#15803d; font-size:.85rem; font-weight:500;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                Payment Completed
            </div>
        <?php endif; ?>
    </div>

    <?php if ($isPaid && !empty($latestBooking['payment_date'])): ?>
        <div style="margin-top:12px; padding-top:12px; border-top:1px solid #e5e7eb; font-size:.78rem; color:#6b7280;">
            Paid on: <?= date('M d, Y g:i A', strtotime($latestBooking['payment_date'])) ?>
        </div>
    <?php endif; ?>
</div>
  <!-- Status History -->
  <div class="d-card">
    <div class="d-card-title">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/>
        <polyline points="12 6 12 12 16 14"/>
      </svg>
      Status History
    </div>
    <!-- Status History card in booking_details.php -->
<ul class="history-list">
  <?php foreach (array_reverse($statusHistory) as $h):
    $slug = strtolower(str_replace(' ', '-', $h['status']));
  ?>
    <li>
      <div class="h-dot <?= esc($slug) ?>"></div>
      <span class="h-badge <?= esc($slug) ?>"><?= esc($h['status']) ?></span>
      <?php if (!empty($h['changed_by'])): ?>
        <span style="font-size:.72rem; color:#6b7280; background:#f3f4f6; padding:2px 8px; border-radius:8px;">
          <?= esc($h['changed_by']) ?>
        </span>
      <?php endif; ?>
      <?php if (!empty($h['notes'])): ?>
        <span style="color:#6b7280;font-size:.75rem;">— <?= esc($h['notes']) ?></span>
      <?php endif; ?>
      <span class="h-time"><?= date('M d, Y — g:i A', strtotime($h['changed_at'])) ?></span>
    </li>
  <?php endforeach; ?>
</ul>
  </div>

  
<!-- Lab Reports Section - Only show when status is Report Ready -->
<?php if ($currentStatus === 'Report Ready'): 
    // Get all uploaded reports for this booking
    $reports = [];
    foreach ($testsOrdered as $item) {
        if (isset($item['has_report']) && $item['has_report']) {
            $reports[] = $item;
        }
    }
?>
<div class="d-card" style="border: 1px solid #e5e7eb; padding: 22px; margin-bottom: 16px; background: #fff; border-radius: 14px;">
    <!-- Header with status -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
            <span style="font-size: .9rem; font-weight: 700; color: #111827;">Lab Reports</span>
        </div>
        <span style="font-size: .75rem; color: #15803d; background: #dcfce7; padding: 4px 12px; border-radius: 12px; font-weight: 600;">
            ✓ All reports uploaded
        </span>
    </div>

    <!-- Notification -->
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 10px 14px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        <span style="font-size: .85rem; color: #166534; font-weight: 500;">
            All reports uploaded. The Marham team has been notified.
        </span>
    </div>

    <!-- Report Items -->
    <?php foreach ($reports as $report): ?>
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
        <div>
            <div style="font-size: .9rem; font-weight: 600; color: #111827;">
                <?= esc($report['test']['test_name']) ?>
            </div>
            <?php if (!empty($report['test']['test_code'])): ?>
                <div style="font-size: .75rem; color: #9ca3af; margin-top: 2px;">
                    <?= esc($report['test']['test_code']) ?>
                </div>
            <?php endif; ?>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: .85rem; color: #059669; font-weight: 500; background: #d1fae5; padding: 2px 10px; border-radius: 12px;">
                Report
            </span>
            <a href="<?= base_url('booking/downloadReport/' . $report['booking']['fk_test_id'] ?? '') ?>" 
               style="display: inline-flex; align-items: center; gap: 4px; color: #1d4ed8; text-decoration: none; font-size: .82rem; font-weight: 500;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Download
            </a>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Footer meta - matches the image exactly -->
    
</div>
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; padding-top: 14px; border-top: 1px solid #f3f4f6;">
        <div>
            <div style="font-size: .75rem; color: #9ca3af;">
                Created: <?= date('M d, Y g:i A', strtotime($latestBooking['date_created'])) ?>
            </div>
            <div style="font-size: .75rem; color: #9ca3af; margin-top: 2px;">
                By: <?= esc($latestBooking['lab_name'] ?? 'INFINITY Lab') ?>
            </div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: .75rem; color: #9ca3af;">
                Assigned to: <?= esc($latestBooking['lab_name'] ?? 'INFINITY Lab') ?>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>

<!-- JavaScript for file upload validation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadReportForm');
    const fileInput = document.getElementById('reportFile');
    const fileError = document.getElementById('fileError');
    const uploadBtn = document.getElementById('uploadBtn');

    if (form) {
        form.addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="test_ids[]"]:checked');
            const file = fileInput.files[0];
            let isValid = true;
            let errorMsg = '';

            // Validate at least one test is selected
            if (checkboxes.length === 0) {
                errorMsg = 'Please select at least one test for this report.';
                isValid = false;
            }

            // Validate file is selected
            if (!file) {
                errorMsg = 'Please select a PDF file to upload.';
                isValid = false;
            } else if (file.type !== 'application/pdf') {
                errorMsg = 'Only PDF files are allowed.';
                isValid = false;
            } else if (file.size > 10 * 1024 * 1024) { // 10MB
                errorMsg = 'File size exceeds 10MB limit.';
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                fileError.textContent = errorMsg;
                fileError.style.display = 'block';
                return false;
            }

            // Show loading state
            uploadBtn.innerHTML = `
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 2a10 10 0 0110 10"/>
                </svg>
                Uploading...
            `;
            uploadBtn.disabled = true;
        });
    }

    // Hide error when user makes a selection
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            fileError.style.display = 'none';
        });
    }

    // Checkbox change - update progress
    const checkboxes = document.querySelectorAll('input[name="test_ids[]"]');
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const checked = document.querySelectorAll('input[name="test_ids[]"]:checked').length;
            const total = <?= count($testsOrdered) ?>;
            // Update progress if needed
        });
    });
});

// Add spin animation
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>

<?= view('templates/footer') ?>