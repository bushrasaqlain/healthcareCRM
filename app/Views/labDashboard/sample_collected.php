 <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: #eef2f7;
      font-family: 'Inter', -apple-system, system-ui, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      display: flex;
      justify-content: center;
      padding: 2rem 1rem;
    }

    .card {
      max-width: 840px;
      width: 100%;
      background: #ffffff;
      border-radius: 28px;
      box-shadow: 0 20px 40px -12px rgba(0, 20, 30, 0.15);
      padding: 1.8rem 2rem 2.5rem;
      transition: all 0.2s;
    }

    /* header */
    .brand {
      display: flex;
      align-items: baseline;
      gap: 12px;
      border-bottom: 1px solid #e9edf4;
      padding-bottom: 1rem;
      margin-bottom: 1.6rem;
      flex-wrap: wrap;
    }

    .brand h1 {
      font-size: 1.9rem;
      font-weight: 600;
      letter-spacing: -0.5px;
      color: #0b1e33;
    }

    .brand h1 small {
      font-size: 0.95rem;
      font-weight: 400;
      color: #5f7d9c;
      margin-left: 10px;
      letter-spacing: 0.2px;
    }

    .brand .by {
      font-size: 0.9rem;
      color: #5f7d9c;
      background: #f0f4fa;
      padding: 4px 14px;
      border-radius: 30px;
      margin-left: auto;
      font-weight: 450;
    }

    .booking-ref {
      background: #f5f8fe;
      padding: 0.5rem 1.2rem;
      border-radius: 40px;
      font-family: 'SF Mono', 'Menlo', monospace;
      font-size: 0.9rem;
      color: #1b3a5c;
      display: inline-block;
      margin-bottom: 1.8rem;
      letter-spacing: 0.3px;
      border: 1px solid #dce3ed;
    }

    /* grid layout */
    .grid-2col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.8rem 2rem;
      margin-top: 0.2rem;
    }

    @media (max-width: 640px) {
      .grid-2col {
        grid-template-columns: 1fr;
        gap: 1.8rem;
      }
      .card { padding: 1.5rem; }
    }

    /* sections */
    .section-title {
      font-size: 0.85rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #4b6a8b;
      margin-bottom: 1.2rem;
      border-bottom: 1px solid #eef2f8;
      padding-bottom: 0.5rem;
    }

    .status-progress {
      display: flex;
      flex-wrap: wrap;
      gap: 6px 14px;
      margin-bottom: 1.6rem;
    }

    .status-step {
      font-size: 0.85rem;
      color: #2f4b6e;
      background: #f1f5fc;
      padding: 4px 12px;
      border-radius: 30px;
      font-weight: 450;
    }
    .status-step.active {
      background: #d3e3ff;
      color: #0047b3;
      font-weight: 500;
    }
    .status-step.done {
      background: #d4edda;
      color: #0b6e3b;
    }

    .upload-area {
      background: #f8faff;
      border: 1px dashed #b8cbdf;
      border-radius: 18px;
      padding: 1rem 1.2rem 1.4rem;
      margin: 1rem 0 1.4rem;
    }

    .upload-area .test-chips {
      display: flex;
      flex-wrap: wrap;
      gap: 8px 12px;
      margin: 10px 0 8px;
    }

    .test-chip {
      background: white;
      border: 1px solid #d3ddee;
      border-radius: 40px;
      padding: 4px 14px;
      font-size: 0.8rem;
      font-weight: 500;
      color: #1d3c5e;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .test-chip i {
      color: #3f7bc0;
      font-size: 0.7rem;
    }
    .test-chip .code {
      background: #e9eff8;
      border-radius: 30px;
      padding: 0px 8px;
      font-weight: 600;
      font-size: 0.7rem;
      color: #1a3d66;
    }

    .upload-hint {
      font-size: 0.8rem;
      color: #4e6f93;
      margin: 6px 0 10px;
    }

    .btn-upload {
      background: white;
      border: 1px solid #b6cae3;
      border-radius: 40px;
      padding: 8px 22px;
      font-weight: 500;
      font-size: 0.85rem;
      color: #1e3f66;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      cursor: default;
      transition: 0.1s;
    }
    .btn-upload i {
      color: #3d70af;
    }

    .patient-info {
      background: #f7fafd;
      border-radius: 18px;
      padding: 0.8rem 1.2rem 0.2rem;
      margin-top: 0.2rem;
    }
    .patient-info p {
      display: flex;
      align-items: baseline;
      gap: 6px 12px;
      flex-wrap: wrap;
      font-size: 0.94rem;
      padding: 4px 0;
      color: #12304e;
    }
    .patient-info strong {
      font-weight: 500;
      color: #2b4f75;
      min-width: 70px;
    }

    .instruction-box {
      background: #f3f8ff;
      border-radius: 18px;
      padding: 0.6rem 1.2rem 0.2rem;
      margin: 1rem 0 0.8rem;
      border-left: 3px solid #3f82d6;
    }

    .phlebo-card {
      background: #f4f9ff;
      border-radius: 20px;
      padding: 0.8rem 1.2rem 0.4rem;
      margin: 1rem 0 0.5rem;
    }
    .phlebo-card .name {
      font-weight: 600;
      font-size: 1rem;
      color: #103456;
    }
    .phlebo-card .eta {
      font-size: 0.85rem;
      color: #2d5a85;
    }

    /* table */
    .table-wrap {
      overflow-x: auto;
      margin: 0.5rem 0 1rem;
      border-radius: 16px;
      border: 1px solid #e4ebf5;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.8rem;
      min-width: 460px;
    }
    th {
      background: #f0f5fd;
      color: #1f4269;
      font-weight: 500;
      padding: 10px 10px;
      text-align: left;
      border-bottom: 1px solid #dbe2ed;
    }
    td {
      padding: 9px 10px;
      border-bottom: 1px solid #eaeff7;
      color: #163252;
    }
    tr:last-child td {
      border-bottom: none;
    }
    .price {
      font-weight: 500;
      white-space: nowrap;
    }
    .pending-badge {
      background: #fff1d6;
      color: #a76100;
      padding: 2px 12px;
      border-radius: 30px;
      font-size: 0.7rem;
      font-weight: 500;
      display: inline-block;
    }

    .financial-breakdown {
      background: #f7faff;
      border-radius: 18px;
      padding: 1rem 1.2rem 0.6rem;
      margin: 1rem 0 0.8rem;
    }
    .fin-row {
      display: flex;
      justify-content: space-between;
      padding: 4px 0;
      font-size: 0.9rem;
      color: #1b3a5a;
    }
    .fin-row.total {
      font-weight: 600;
      border-top: 1px solid #d7e0ec;
      margin-top: 8px;
      padding-top: 10px;
    }
    .fin-row .label {
      color: #3f6083;
    }
    .fin-row .value {
      font-weight: 500;
    }
    .fin-row .discount {
      color: #1f7b4b;
    }
    .view-invoice {
      color: #2b6bb0;
      font-weight: 500;
      font-size: 0.85rem;
      margin-top: 6px;
      display: inline-block;
    }

    .activity-log {
      background: #f9fcff;
      border-radius: 18px;
      padding: 0.5rem 1.2rem 0.2rem;
      margin: 1rem 0 0.2rem;
      font-size: 0.85rem;
    }
    .log-item {
      padding: 6px 0;
      border-bottom: 1px solid #ebf0f8;
      color: #1d3a5b;
      display: flex;
      flex-wrap: wrap;
      gap: 4px 10px;
    }
    .log-item .lab {
      font-weight: 500;
      color: #0d2948;
    }
    .log-item .status-badge {
      background: #e4edf9;
      border-radius: 40px;
      padding: 0px 10px;
      font-size: 0.75rem;
    }

    .status-history {
      display: flex;
      flex-wrap: wrap;
      gap: 4px 10px;
      margin-top: 8px;
    }
    .status-history span {
      background: #eef3fb;
      border-radius: 30px;
      padding: 2px 12px;
      font-size: 0.75rem;
      color: #1d3f65;
    }

    .price-list-scroll {
      background: #fafdff;
      border: 1px solid #dfe8f2;
      border-radius: 18px;
      padding: 0.3rem 0.8rem 0.1rem;
      max-height: 140px;
      overflow-y: auto;
      margin: 6px 0 0px;
      font-size: 0.7rem;
      color: #2c5280;
    }
    .price-list-scroll span {
      display: inline-block;
      margin-right: 4px;
    }
    .price-list-scroll .pricetag {
      background: #edf4fd;
      padding: 0 6px;
      border-radius: 12px;
      margin: 1px 2px;
    }
    .mt-1 { margin-top: 0.5rem; }
    .mb-1 { margin-bottom: 0.3rem; }
    .flex { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

    /* tiny extras */
    .text-muted { color: #4f7193; }
    .fa-regular, .fas, .far { margin-right: 4px; }
    hr { border: none; border-top: 1px solid #dce4ef; margin: 0.8rem 0; }

    i.fa-circle-check { color: #1d8b4f; }
    .pin-loc { background: #e6effa; padding: 4px 14px; border-radius: 30px; font-size: 0.8rem; }
  </style>
</head>
<body>
<div class="card">

  <!-- header -->
  <div class="brand">
    <h1>Health+ <small>by marham.pk</small></h1>
    <span class="by"><i class="fas fa-flask" style="margin-right:6px;"></i>Lab</span>
  </div>

  <div class="booking-ref">
    <i class="fas fa-hashtag" style="color:#3f7bc0;"></i> cmqfan2e2000zt5083orfxtd1j
  </div>

  <!-- STATUS PROGRESS -->
  <div class="status-progress">
    <span class="status-step done"><i class="fas fa-check-circle" style="color:#0f7b3a;"></i> In Process</span>
    <span class="status-step done"><i class="fas fa-check-circle" style="color:#0f7b3a;"></i> Phlebotomist Assigned</span>
    <span class="status-step done"><i class="fas fa-check-circle" style="color:#0f7b3a;"></i> Phlebotomist Arrived</span>
    <span class="status-step active"><i class="fas fa-spinner fa-pulse" style="color:#1f5f9e;"></i> Sample Collected</span>
    <span class="status-step">Report Ready</span>
  </div>

  <!-- UPLOAD LAB REPORTS -->
  <div class="upload-area">
    <div style="font-weight:600; color:#113456; font-size:0.95rem; margin-bottom:6px;">
      <i class="fas fa-cloud-upload-alt" style="color:#2f6eb0;"></i> Upload Lab Reports
    </div>
    <div class="test-chips">
      <span class="test-chip"><i class="fas fa-vial"></i> LFTs <span class="code">6668</span></span>
      <span class="test-chip"><i class="fas fa-vial"></i> Beta HCG <span class="code">4303</span></span>
    </div>
    <div class="upload-hint">
      <i class="fas fa-info-circle" style="color:#3f7bc0;"></i> Check the tests covered by your report, then upload one PDF. One PDF can cover multiple tests.
    </div>
    <div class="flex" style="justify-content:space-between; flex-wrap:wrap;">
      <span style="font-size:0.8rem; background:#e9f0fa; padding:2px 14px; border-radius:30px; color:#1c4670;">Select tests above first</span>
      <span class="btn-upload"><i class="fas fa-file-pdf"></i> PDF only, max 10MB</span>
    </div>
    <div style="font-size:0.75rem; color:#3b6289; margin-top:8px;">
      <i class="fas fa-arrow-right" style="color:#2b6bb0;"></i> Booking auto-completes when all tests are reported.
    </div>
  </div>

  <!-- GRID -->
  <div class="grid-2col">
    <!-- LEFT COL -->
    <div>

      <!-- Patient Information -->
      <div class="section-title"><i class="fas fa-user-circle"></i> Patient Information</div>
      <div class="patient-info">
        <p><strong>Name:</strong> Nadia Tariq</p>
        <p><strong>Phone:</strong> +923228117733</p>
        <p><strong>Address:</strong> House 90 Dream Villas Society</p>
        <p><strong>Age / Gender:</strong> Female</p>
      </div>

      <!-- Instructions & Location -->
      <div class="section-title" style="margin-top:1.4rem;"><i class="fas fa-map-pin"></i> Instructions & Location</div>
      <div class="flex" style="gap:10px;">
        <span class="pin-loc"><i class="fas fa-map-marker-alt" style="color:#d4533b;"></i> PIN LOCATION</span>
        <span style="color:#2b6bb0; font-weight:500;"><i class="fas fa-eye"></i> View on Map</span>
      </div>
      <div class="instruction-box">
        <i class="fas fa-sticky-note" style="color:#3f7bc0;"></i> <strong>NOTES / INSTRUCTIONS</strong><br>
        <span style="font-size:0.9rem;">16 june 3 pm</span>
      </div>

      <!-- Phlebotomist -->
      <div class="phlebo-card">
        <div><i class="fas fa-user-md" style="color:#1f5f9e;"></i> <span class="name">Khawar</span></div>
        <div class="eta"><i class="far fa-clock"></i> ETA: 16 Jun 2026, 3:00 PM</div>
      </div>

      <!-- Tests Ordered (table) -->
      <div class="section-title" style="margin-top:1.2rem;"><i class="fas fa-flask"></i> Tests Ordered</div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>CODE</th><th>TEST NAME</th><th>REPORTING TIME</th><th>PATIENT PRICE</th><th>PAYMENT</th></tr></thead>
          <tbody>
            <tr><td>6668</td><td>LFTs (T-Bili, ALT, AST, ALP, ALB, GGT, T-Prot, Globulins, A/G)</td><td>—</td><td class="price">PKR 1,365</td><td>Cash</td></tr>
            <tr><td>4303</td><td>Beta HCG</td><td>Same Day After 3 Hour</td><td class="price">PKR 1,575</td><td><span class="pending-badge">Pending</span></td></tr>
          </tbody>
        </table>
      </div>

    </div><!-- left col -->

    <!-- RIGHT COL -->
    <div>

      <!-- Financial Breakdown -->
      <div class="section-title"><i class="fas fa-file-invoice-dollar"></i> Financial Breakdown</div>
      <div class="financial-breakdown">
        <div class="fin-row"><span class="label">Original Total (Rack Rate)</span><span class="value">PKR 3,000</span></div>
        <div class="fin-row"><span class="label">Discount (30%)</span><span class="value discount">- PKR 900</span></div>
        <div class="fin-row total"><span class="label">Patient Pays</span><span class="value">PKR 2,100</span></div>
        <div class="fin-row"><span class="label">Payment</span><span class="value">PKR 1,365 Cash / 1,575 Pending</span></div>
        <div class="view-invoice"><i class="fas fa-receipt"></i> View Invoice</div>
      </div>

      <!-- mini list: LFTs + Beta HCG line -->
      <div style="font-size:0.82rem; background:#f3f8fe; border-radius:14px; padding:0.4rem 1rem; margin:0.4rem 0;">
        <div><i class="fas fa-circle" style="color:#3672b5; font-size:0.5rem;"></i> LFTs (T-Bili, ALT, AST, ALP, ALB, GGT, T-Prot, Globulins, A/G) <span style="float:right;">Pending</span></div>
        <div><i class="fas fa-circle" style="color:#3672b5; font-size:0.5rem;"></i> Beta HCG <span style="float:right;">Pending</span></div>
      </div>

      <!-- Activity Log -->
      <div class="section-title" style="margin-top:1.2rem;"><i class="fas fa-history"></i> Activity Log</div>
      <div class="activity-log">
        <div class="log-item"><span class="lab">INFINITY Lab</span> Status: Phlebotomist Arrived → Sample Collected</div>
        <div class="log-item"><span class="lab">INFINITY Lab</span> Added: Beta HCG</div>
        <div class="log-item"><span class="lab">INFINITY Lab</span> Status: Phlebotomist Assigned → Phlebotomist Arrived</div>
        <div class="log-item"><span class="lab">INFINITY Lab</span> Status: In Process → Phlebotomist Assigned (Khawar)</div>
        <div class="log-item"><span class="lab">Marham Agent</span> Booking created → 1 test: LFTs (T-Bili, ALT, AST, ALP, ALB, GGT, T-Prot, Globulins, A/G)</div>
      </div>

      <!-- Status History (two rows) -->
      <div style="margin-top:0.8rem;">
        <div class="status-history">
          <span><i class="fas fa-check-circle" style="color:#0f7b3a;"></i> In Process</span>
          <span><i class="fas fa-check-circle" style="color:#0f7b3a;"></i> Phlebotomist Assigned</span>
          <span><i class="fas fa-check-circle" style="color:#0f7b3a;"></i> Phlebotomist Arrived</span>
          <span><i class="fas fa-check-circle" style="color:#0f7b3a;"></i> Sample Collected</span>
        </div>
        <div class="status-history" style="margin-top:2px;">
          <span>In Process</span>
          <span>Phlebotomist Assigned</span>
        </div>
      </div>

      <!-- Price list scroll (exactly as in image: many PKR amounts) -->
      <div class="price-list-scroll">
        <span class="pricetag">PKR 1,365</span> <span class="pricetag">PKR 1,575</span> <span class="pricetag">PKR 2,940</span>
        <span class="pricetag">PKR 3,000</span> <span class="pricetag">PKR 3,500</span> <span class="pricetag">PKR 4,000</span>
        <span class="pricetag">PKR 4,500</span> <span class="pricetag">PKR 5,000</span> <span class="pricetag">PKR 5,500</span>
        <span class="pricetag">PKR 6,000</span> <span class="pricetag">PKR 6,500</span> <span class="pricetag">PKR 7,000</span>
        <span class="pricetag">PKR 7,500</span> <span class="pricetag">PKR 8,000</span> <span class="pricetag">PKR 8,500</span>
        <span class="pricetag">PKR 9,000</span> <span class="pricetag">PKR 9,500</span> <span class="pricetag">PKR 10,000</span>
        <span class="pricetag">PKR 10,500</span> <span class="pricetag">PKR 11,000</span> <span class="pricetag">PKR 11,500</span>
        <span class="pricetag">PKR 12,000</span> <span class="pricetag">PKR 12,500</span> <span class="pricetag">PKR 13,000</span>
        <span class="pricetag">PKR 13,500</span> <span class="pricetag">PKR 14,000</span> <span class="pricetag">PKR 14,500</span>
        <span class="pricetag">PKR 15,000</span> <span class="pricetag">PKR 15,500</span> <span class="pricetag">PKR 16,000</span>
        <span class="pricetag">PKR 16,500</span> <span class="pricetag">PKR 17,000</span> <span class="pricetag">PKR 17,500</span>
        <span class="pricetag">PKR 18,000</span> <span class="pricetag">PKR 18,500</span> <span class="pricetag">PKR 19,000</span>
        <span class="pricetag">PKR 19,500</span> <span class="pricetag">PKR 20,000</span> <span class="pricetag">PKR 20,500</span>
        <span class="pricetag">PKR 21,000</span> <span class="pricetag">PKR 21,500</span> <span class="pricetag">PKR 22,000</span>
        <span class="pricetag">PKR 22,500</span> <span class="pricetag">PKR 23,000</span> <span class="pricetag">PKR 23,500</span>
        <span class="pricetag">PKR 24,000</span> <span class="pricetag">PKR 24,500</span> <span class="pricetag">PKR 25,000</span>
        <span class="pricetag">PKR 25,500</span> <span class="pricetag">PKR 26,000</span> <span class="pricetag">PKR 26,500</span>
        <span class="pricetag">PKR 27,000</span> <span class="pricetag">PKR 27,500</span> <span class="pricetag">PKR 28,000</span>
        <span class="pricetag">PKR 28,500</span> <span class="pricetag">PKR 29,000</span> <span class="pricetag">PKR 29,500</span>
        <span class="pricetag">PKR 30,000</span> <span class="pricetag">PKR 30,500</span> <span class="pricetag">PKR 31,000</span>
        <span class="pricetag">PKR 31,500</span> <span class="pricetag">PKR 32,000</span> <span class="pricetag">PKR 32,500</span>
        <span class="pricetag">PKR 33,000</span> <span class="pricetag">PKR 33,500</span> <span class="pricetag">PKR 34,000</span>
        <span class="pricetag">PKR 34,500</span> <span class="pricetag">PKR 35,000</span> <span class="pricetag">PKR 35,500</span>
        <span class="pricetag">PKR 36,000</span> <span class="pricetag">PKR 36,500</span> <span class="pricetag">PKR 37,000</span>
        <span class="pricetag">PKR 37,500</span> <span class="pricetag">PKR 38,000</span> <span class="pricetag">PKR 38,500</span>
        <span class="pricetag">PKR 39,000</span> <span class="pricetag">PKR 39,500</span> <span class="pricetag">PKR 40,000</span>
        <span class="pricetag">PKR 40,500</span> <span class="pricetag">PKR 41,000</span> <span class="pricetag">PKR 41,500</span>
        <span class="pricetag">PKR 42,000</span> <span class="pricetag">PKR 42,500</span> <span class="pricetag">PKR 43,000</span>
        <span class="pricetag">PKR 43,500</span> <span class="pricetag">PKR 44,000</span> <span class="pricetag">PKR 44,500</span>
        <span class="pricetag">PKR 45,000</span> <span class="pricetag">PKR 45,500</span> <span class="pricetag">PKR 46,000</span>
        <span class="pricetag">PKR 46,500</span> <span class="pricetag">PKR 47,000</span> <span class="pricetag">PKR 47,500</span>
        <span class="pricetag">PKR 48,000</span> <span class="pricetag">PKR 48,500</span> <span class="pricetag">PKR 49,000</span>
        <span class="pricetag">PKR 49,500</span> <span class="pricetag">PKR 50,000</span> <span class="pricetag">PKR 50,500</span>
        <span class="pricetag">PKR 51,000</span> <span class="pricetag">PKR 51,500</span> <span class="pricetag">PKR 52,000</span>
        <span class="pricetag">PKR 52,500</span> <span class="pricetag">PKR 53,000</span> <span class="pricetag">PKR 53,500</span>
        <span class="pricetag">PKR 54,000</span> <span class="pricetag">PKR 54,500</span> <span class="pricetag">PKR 55,000</span>
        <span class="pricetag">PKR 55,500</span> <span class="pricetag">PKR 56,000</span> <span class="pricetag">PKR 56,500</span>
        <span class="pricetag">PKR 57,000</span> <span class="pricetag">PKR 57,500</span> <span class="pricetag">PKR 58,000</span>
        <span class="pricetag">PKR 58,500</span> <span class="pricetag">PKR 59,000</span> <span class="pricetag">PKR 59,500</span>
        <span class="pricetag">PKR 60,000</span> <span class="pricetag">PKR 60,500</span> <span class="pricetag">PKR 61,000</span>
        <span class="pricetag">PKR 61,500</span> <span class="pricetag">PKR 62,000</span> <span class="pricetag">PKR 62,500</span>
        <span class="pricetag">PKR 63,000</span> <span class="pricetag">PKR 63,500</span> <span class="pricetag">PKR 64,000</span>
        <span class="pricetag">PKR 64,500</span> <span class="pricetag">PKR 65,000</span> <span class="pricetag">PKR 65,500</span>
        <span class="pricetag">PKR 66,000</span> <span class="pricetag">PKR 66,500</span> <span class="pricetag">PKR 67,000</span>
        <span class="pricetag">PKR 67,500</span> <span class="pricetag">PKR 68,000</span> <span class="pricetag">PKR 68,500</span>
        <span class="pricetag">PKR 69,000</span> <span class="pricetag">PKR 69,500</span> <span class="pricetag">PKR 70,000</span>
        <span class="pricetag">PKR 70,500</span> <span class="pricetag">PKR 71,000</span> <span class="pricetag">PKR 71,500</span>
        <span class="pricetag">PKR 72,000</span> <span class="pricetag">PKR 72,500</span> <span class="pricetag">PKR 73,000</span>
        <span class="pricetag">PKR 73,500</span> <span class="pricetag">PKR 74,000</span> <span class="pricetag">PKR 74,500</span>
        <span class="pricetag">PKR 75,000</span> <span class="pricetag">PKR 75,500</span> <span class="pricetag">PKR 76,000</span>
        <span class="pricetag">PKR 76,500</span> <span class="pricetag">PKR 77,000</span> <span class="pricetag">PKR 77,500</span>
        <span class="pricetag">PKR 78,000</span> <span class="pricetag">PKR 78,500</span> <span class="pricetag">PKR 79,000</span>
        <span class="pricetag">PKR 79,500</span> <span class="pricetag">PKR 80,000</span> <span class="pricetag">PKR 80,500</span>
        <span class="pricetag">PKR 81,000</span> <span class="pricetag">PKR 81,500</span> <span class="pricetag">PKR 82,000</span>
        <span class="pricetag">PKR 82,500</span> <span class="pricetag">PKR 83,000</span> <span class="pricetag">PKR 83,500</span>
        <span class="pricetag">PKR 84,000</span> <span class="pricetag">PKR 84,500</span> <span class="pricetag">PKR 85,000</span>
        <span class="pricetag">PKR 85,500</span> <span class="pricetag">PKR 86,000</span> <span class="pricetag">PKR 86,500</span>
        <span class="pricetag">PKR 87,000</span> <span class="pricetag">PKR 87,500</span> <span class="pricetag">PKR 88,000</span>
        <span class="pricetag">PKR 88,500</span> <span class="pricetag">PKR 89,000</span> <span class="pricetag">PKR 89,500</span>
        <span class="pricetag">PKR 90,000</span> <span class="pricetag">PKR 90,500</span> <span class="pricetag">PKR 91,000</span>
        <span class="pricetag">PKR 91,500</span> <span class="pricetag">PKR 92,000</span> <span class="pricetag">PKR 92,500</span>
        <span class="pricetag">PKR 93,000</span> <span class="pricetag">PKR 93,500</span> <span class="pricetag">PKR 94,000</span>
        <span class="pricetag">PKR 94,500</span> <span class="pricetag">PKR 95,000</span> <span class="pricetag">PKR 95,500</span>
        <span class="pricetag">PKR 96,000</span> <span class="pricetag">PKR 96,500</span> <span class="pricetag">PKR 97,000</span>
        <span class="pricetag">PKR 97,500</span> <span class="pricetag">PKR 98,000</span> <span class="pricetag">PKR 98,500</span>
        <span class="pricetag">PKR 99,000</span> <span class="pricetag">PKR 99,500</span> <span class="pricetag">PKR 100,000</span>
        <span class="pricetag">PKR 100,500</span> <span class="pricetag">PKR 101,000</span> <span class="pricetag">PKR 101,500</span>
        <span class="pricetag">PKR 102,000</span> <span class="pricetag">PKR 102,500</span> <span class="pricetag">PKR 103,000</span>
        <span class="pricetag">PKR 103,500</span> <span class="pricetag">PKR 104,000</span> <span class="pricetag">PKR 104,500</span>
        <span class="pricetag">PKR 105,000</span> <span class="pricetag">PKR 105,500</span> <span class="pricetag">PKR 106,000</span>
        <span class="pricetag">PKR 106,500</span> <span class="pricetag">PKR 107,000</span> <span class="pricetag">PKR 107,500</span>
        <span class="pricetag">PKR 108,000</span> <span class="pricetag">PKR 108,500</span> <span class="pricetag">PKR 109,000</span>
        <span class="pricetag">PKR 109,500</span> <span class="pricetag">PKR 110,000</span> <span class="pricetag">PKR 110,500</span>
        <span class="pricetag">PKR 111,000</span> <span class="pricetag">PKR 111,500</span> <span class="pricetag">PKR 112,000</span>
        <span class="pricetag">PKR 112,500</span> <span class="pricetag">PKR 113,000</span> <span class="pricetag">PKR 113,500</span>
        <span class="pricetag">PKR 114,000</span> <span class="pricetag">PKR 114,500</span> <span class="pricetag">PKR 115,000</span>
        <span class="pricetag">PKR 115,500</span> <span class="pricetag">PKR 116,000</span> <span class="pricetag">PKR 116,500</span>
        <span class="pricetag">PKR 117,000</span> <span class="pricetag">PKR 117,500</span> <span class="pricetag">PKR 118,000</span>
        <span class="pricetag">PKR 118,500</span> <span class="pricetag">PKR 119,000</span> <span class="pricetag">PKR 119,500</span>
        <span class="pricetag">PKR 120,000</span> <span class="pricetag">PKR 120,500</span> <span class="pricetag">PKR 121,000</span>
        <span class="pricetag">PKR 121,500</span> <span class="pricetag">PKR 122,000</span> <span class="pricetag">PKR 122,500</span>
        <span class="pricetag">PKR 123,000</span> <span class="pricetag">PKR 123,500</span> <span class="pricetag">PKR 124,000</span>
        <span class="pricetag">PKR 124,500</span> <span class="pricetag">PKR 125,000</span> <span class="pricetag">PKR 125,500</span>
        <span class="pricetag">PKR 126,000</span> <span class="pricetag">PKR 126,500</span> <span class="pricetag">PKR 127,000</span>
        <span class="pricetag">PKR 127,500</span> <span class="pricetag">PKR 128,000</span> <span class="pricetag">PKR 128,500</span>
        <span class="pricetag">PKR 129,000</span> <span class="pricetag">PKR 129,500</span> <span class="pricetag">PKR 130,000</span>
        <span class="pricetag">PKR 130,500</span>
      </div>

    </div><!-- right col -->
  </div><!-- grid -->

  <!-- tiny footnote -->
  <div style="margin-top:1.2rem; font-size:0.7rem; color:#6d8bb0; border-top:1px solid #e1e9f2; padding-top:0.8rem; text-align:right;">
    <i class="fas fa-circle" style="color:#3973c0; font-size:0.4rem;"></i> Health+ · marham.pk
  </div>
