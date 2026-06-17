<?= view('templates/header', ['pageTitle' => 'Lab List', 'activePage' => 'lablist']) ?>

<div class="container-fluid px-4 py-4">
  <!-- PAGE HEADER -->
  <div class="page-header">
    
   <a class="nav-link text-black d-flex align-items-center gap-1" href="<?= base_url('booking/new') ?>">
          New Booking
            </a>
  </div>
  <!-- Stat Cards -->
  <div class="d-flex gap-3 mb-4 flex-wrap">
    <div class="stat-card">
      <div class="stat-val c-white">165</div>
      <div class="stat-label">Total</div>
    </div>
    <div class="stat-card">
      <div class="stat-val c-orange">0</div>
      <div class="stat-label">In Process</div>
    </div>
    <div class="stat-card">
      <div class="stat-val c-blue">3</div>
      <div class="stat-label">Assigned</div>
    </div>
    <div class="stat-card">
      <div class="stat-val c-purple">0</div>
      <div class="stat-label">Arrived</div>
    </div>
    <div class="stat-card">
      <div class="stat-val c-red">2</div>
      <div class="stat-label">Collected</div>
    </div>
    <div class="stat-card">
      <div class="stat-val c-green">147</div>
      <div class="stat-label">Report Ready</div>
    </div>
  </div>

  <!-- Tabs -->
  <ul class="nav tab-nav mb-3">
    <li class="nav-item">
      <a href="#" class="nav-link active">
        <i class="bi bi-person"></i> Individual Leads
        <span class="badge-count">165</span>
      </a>
    </li>
    
  </ul>

  <!-- Filter Bar -->
  <div class="filter-bar mb-3">
    <div class="d-flex align-items-center gap-3 flex-wrap">
      <div class="d-flex align-items-center gap-2">
        <i class="bi bi-calendar3 text-muted-custom"></i>
        <input type="date"/>
        <span class="text-muted-custom small">to</span>
        <input type="date"/>
      </div>
      <div class="d-flex align-items-center gap-2 flex-wrap">
        <i class="bi bi-funnel text-muted-custom"></i>
        <span class="status-pill active" onclick="setPill(this)">All</span>
        <span class="status-pill" onclick="setPill(this)">In Process</span>
        <span class="status-pill" onclick="setPill(this)">Phleb. Assigned</span>
        <span class="status-pill" onclick="setPill(this)">Arrived</span>
        <span class="status-pill" onclick="setPill(this)">Collected</span>
        <span class="status-pill" onclick="setPill(this)">Report Ready</span>
        <span class="status-pill" onclick="setPill(this)">Refused</span>
      </div>
    </div>
  </div>
  <div class="table-responsive">
  <!-- Leads Table -->
  <div class="leads-table">
    <table class="table table-borderless mb-0">
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

        <!-- Row with Sample Collected status - this will navigate to sample collected page -->
        <tr>
          <td>
            <div class="patient-name">Nadia Tariq</div>
            <div class="patient-meta">Female</div>
            <div class="patient-meta">House 90 Dream Villas So...</div>
          </td>
          <td class="patient-meta pt-3">+923228117733</td>
          <td>
            <div class="test-name">1 test</div>
            <div class="test-desc">LFTs (T-Bill, ALT, AST, ALP, ALB, ...</div>
          </td>
          <td>
            <div class="price-main">PKR 1,365</div>
            <div class="price-strike">PKR 1,950</div>
          </td>
          <td><span class="status-badge phlebotomist">Phlebotomist Assigned</span></td>
          <td><div class="eta-val">Jun 16, 2026 3:00 PM</div></td>
          <td><div class="date-val">Jun 15, 7:13 PM</div></td>
          <td><a href="sample_collected/1" class="btn-view">View &amp; Update <i class="bi bi-arrow-right"></i></a></td>
        </tr>

        <tr>
          <td>
            <div class="patient-name">Asma</div>
            <div class="patient-meta">Female</div>
            <div class="patient-meta">4k plaza model town lah...</div>
          </td>
          <td class="patient-meta pt-3">+92 334 1006561</td>
          <td>
            <div class="test-name">1 test</div>
            <div class="test-desc">Complete Blood Examinatio...</div>
            <span class="badge-tag same-day">Reports: Same Day After 2 Hour</span>
          </td>
          <td>
            <div class="price-main">PKR 560</div>
            <div class="price-strike">PKR 800</div>
          </td>
          <td><span class="status-badge phlebotomist">Phlebotomist Assigned</span></td>
          <td><div class="eta-val">Jun 13, 2026 9:00 AM</div></td>
          <td><div class="date-val">Jun 12, 11:59 AM</div></td>
          <td><a href="#" class="btn-view">View &amp; Update <i class="bi bi-arrow-right"></i></a></td>
        </tr>

        <!-- Row with Sample Collected status - this will navigate to sample collected page -->
        <tr>
          <td>
            <div class="patient-name">muhammad ayub</div>
            <div class="patient-meta">58 golfers lane bedian ro...</div>
          </td>
          <td class="patient-meta pt-3">+923028457799</td>
          <td>
            <div class="test-name">9 tests</div>
            <div class="test-desc">Complete Blood Examinatio...</div>
            <span class="badge-tag timings">Reports: 5 timings</span>
            <span class="badge-tag reports d-block mt-1">8/9 reports</span>
          </td>
          <td>
            <div class="price-main">PKR 12,880</div>
            <div class="price-strike">PKR 18,400</div>
          </td>
          <td><span class="status-badge collected">Sample Collected</span></td>
          <td><div class="eta-val">Jun 12, 2026 3:00 PM</div></td>
          <td><div class="date-val">Jun 12, 1:37 PM</div></td>
          <td><a href="/sample-collected/2" class="btn-view">View &amp; Update <i class="bi bi-arrow-right"></i></a></td>
        </tr>

        <tr>
          <td>
            <div class="d-flex align-items-center">
              <div class="patient-name">Usman nabi</div>
              <span class="star-badge ms-2"><i class="bi bi-star-fill" style="font-size:10px;"></i> 0</span>
            </div>
            <div class="patient-meta">24 yrs · Male</div>
            <div class="patient-meta">Flat no 4b state bank col...</div>
          </td>
          <td class="patient-meta pt-3">+923054031039</td>
          <td>
            <div class="test-name">4 tests</div>
            <div class="test-desc">HbA1C, RFTs (Renal Function ...</div>
            <span class="badge-tag timings">Reports: 3 timings</span>
          </td>
          <td>
            <div class="price-main">PKR 4,680</div>
            <div class="price-strike">PKR 7,000</div>
          </td>
          <td><span class="status-badge phlebotomist">Phlebotomist Assigned</span></td>
          <td><div class="eta-val">May 8, 2026 1:30 PM</div></td>
          <td><div class="date-val">May 8, 12:41 PM</div></td>
          <td><a href="#" class="btn-view">View &amp; Update <i class="bi bi-arrow-right"></i></a></td>
        </tr>

      </tbody>
    </table>
  </div>
  </div>
</div>

<script>
  function setPill(el) {
    document.querySelectorAll('.status-pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
  }
</script>

<?= view('templates/footer') ?>