<?php

$genders = $genders ?? ['Male', 'Female', 'Other'];


$tests = $tests ?? [
    ['id' => 1, 'test_code' => '1207', 'test_name' => 'Semen Analysis', 'rate' => 3000],
    ['id' => 2, 'test_code' => '2352', 'test_name' => '5 HIAA (24 Hrs Urine)', 'rate' => 4800],
    ['id' => 3, 'test_code' => '5050', 'test_name' => 'Complete Blood Count (CBC)', 'rate' => 1200],
    ['id' => 4, 'test_code' => '1090', 'test_name' => 'Fasting Blood Glucose', 'rate' => 600],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>New Lab Booking</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-light">
<?= view('templates/header', ['pageTitle' => 'Booking', 'activePage' => 'bookingform']) ?>

<div class="container py-4" style="max-width: 860px;">

  
  <div class="mb-4">
    <h2 class="fw-bold mb-1">New Lab Booking</h2>
    <p class="text-muted mb-0">Fill in patient details and test information</p>
  </div>

<form method="post" action="<?= site_url('booking/add') ?>" id="booking_form">
      <?= csrf_field() ?>


    <div class="card shadow-sm mb-4">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Patient Details</h5>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="patient_name" class="form-label fw-semibold">
              Patient Name <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="patient_name" name="patient_name"
                   placeholder="Full name" pattern="[A-Za-z\s]+" title="Letters and spaces only"
                   required>
          </div>
          <div class="col-md-6">
  <label for="phone_number" class="form-label fw-semibold">
    Phone Number <span class="text-danger">*</span>
  </label>
  <input type="text" class="form-control" id="phone_number" name="phone_number"
         inputmode="tel" placeholder="03XX-XXXXXXX or +92XXXXXXXXXX" maxlength="13" required>
  <small class="text-danger d-none" id="phone-error">Enter a valid Pakistani number — mobile (03XX-XXXXXXX), landline (0XX-XXXXXXX), or international (+92XXXXXXXXXX).</small>
</div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="age" class="form-label fw-semibold">
              Age <span class="text-muted fw-normal">(optional)</span>
            </label>
            <input type="number" class="form-control" id="age" name="age" placeholder="e.g. 35" min="0">
          </div>
          <div class="col-md-6">
            <label for="gender" class="form-label fw-semibold">
              Gender <span class="text-muted fw-normal">(optional)</span>
            </label>
            <select class="form-select" id="gender" name="gender">
              <option selected disabled>Select gender</option>
              <?php foreach ($genders as $g): ?>
                <option value="<?= esc($g) ?>"><?= esc($g) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label for="home_address" class="form-label fw-semibold">
            Home Address <span class="text-danger">*</span>
          </label>
          <textarea class="form-control" id="home_address" name="home_address" rows="2"
                    placeholder="Full home address for sample collection" required></textarea>
        </div>

        <!-- <div class="mb-3">
          <label for="pin_location" class="form-label fw-semibold">
            <i class="bi bi-geo-alt me-1"></i>Pin Location
            <span class="text-muted fw-normal">(optional — paste Google Maps link)</span>
          </label>
          <input type="url" class="form-control" id="pin_location" name="pin_location"
                 placeholder="https://maps.google.com/...">
        </div> -->

        <div class="mb-3 position-relative">
  <label for="pin_location_search" class="form-label fw-semibold">
    <i class="bi bi-geo-alt me-1"></i>Pin Location
    <span class="text-muted fw-normal">(optional — click the box to open the map)</span>
  </label>
  <input type="text" class="form-control mb-2" id="pin_location_search" autocomplete="off"
         placeholder="Search address, area, or landmark…">
  <div class="position-absolute w-100 bg-white border rounded-3 shadow-lg d-none"
       id="pin_search_dropdown" style="z-index: 1050; max-height: 250px; overflow-y: auto; top: 58px;"></div>

  <div class="position-relative d-none" id="pin_map_wrapper">
    <button type="button"
            class="btn btn-sm btn-light border rounded-circle position-absolute d-flex align-items-center justify-content-center"
            id="pin_map_close" title="Close map"
            style="top: 8px; right: 8px; z-index: 1000; width: 32px; height: 32px; padding: 0;">
      <i class="bi bi-x-lg"></i>
    </button>
    <div id="pin_map" style="height: 280px; border-radius: 0.5rem;"></div>
  </div>

  <input type="hidden" name="pin_lat" id="pin_lat">
  <input type="hidden" name="pin_lng" id="pin_lng">
  <input type="hidden" name="pin_address" id="pin_address">
</div>

        <div class="mb-0">
          <label for="instructions" class="form-label fw-semibold">
            <i class="bi bi-file-text me-1"></i>Instructions / Notes
            <span class="text-muted fw-normal">(optional — visible to lab team)</span>
          </label>
          <textarea class="form-control" id="instructions" name="instructions" rows="3"
                    placeholder="e.g. Patient is fasting, preferred morning slot, special handling instructions…"></textarea>
        </div>
      </div>
    </div>

    
    <div class="card shadow-sm mb-4">
      <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
          <h5 class="fw-bold mb-0">Tests Ordered</h5>
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-tag text-muted"></i>
            <span class="text-nowrap">Default discount:</span>
            <input type="number" class="form-control form-control-sm" id="default_discount"
                   style="width: 70px;" value="0" min="0" max="100">
            <span>%</span>
            <span id="apply_to_all_wrapper" class="d-none">
              <button type="button" id="apply_to_all" class="btn btn-sm btn-outline-primary text-nowrap">
                Apply to all
              </button>
            </span>
          </div>
        </div>

        <div class="mb-3 position-relative">
          <label for="test_search" class="form-label fw-semibold">
            Search &amp; Add Tests <span class="text-danger">*</span>
          </label>
          <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
            <input type="text" class="form-control" id="test_search" autocomplete="off"
                   placeholder="Type test name or code (e.g. CBC, Glucose, 5050)…">
          </div>
          <div class="position-absolute w-100 bg-white border rounded-3 shadow-lg mt-1 d-none"
               id="search_dropdown" style="z-index: 1050; max-height: 320px; overflow-y: auto; top: 100%;"></div>
        </div>

        <div class="rounded-3" id="tests_list" >
  <div class="p-5 text-center" id="no_tests_row">
    <i class="bi bi-flask fs-1 text-muted d-block mb-2"></i>
    <span class="text-muted">No tests added yet. Search above to add tests.</span>
  </div>
</div>
<small class="text-danger d-none mt-2 d-block" id="tests-error">Please add at least one test before submitting.</small>
      </div>
    </div>

   
    <div class="rounded-3 p-4 mb-4 d-none" id="financial_summary_panel" style="background-color:#0E2C40;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold text-white mb-0">
          <i class="bi bi-flask me-2"></i>Financial Summary
        </h6>
        <span class="small" style="color:#7FB3D5;">Live preview</span>
      </div>

      <div id="summary_line_items" class="border-bottom pb-2 mb-2" style="border-color: rgba(255,255,255,0.15) !important;"></div>

      <div class="d-flex justify-content-between mb-1">
        <span style="color:#9FC4DA;">Original Total (Rack Rate)</span>
        <span class="text-white" id="summary_original">PKR 0</span>
      </div>
      <div class="d-flex justify-content-between border-bottom pb-2 mb-2" style="border-color: rgba(255,255,255,0.15) !important;">
        <span style="color:#9FC4DA;">Total Discount</span>
        <span style="color:#FF8A80;" id="summary_discount">- PKR 0</span>
      </div>
      <div class="d-flex justify-content-between">
        <span class="text-white fw-bold fs-5">Patient Pays</span>
        <span class="text-white fw-bold fs-5" id="summary_patient_pays">PKR 0</span>
      </div>

      <div class="rounded-2 p-2 mt-3 text-center fw-semibold d-none" id="prepaid_banner"
           style="background-color: rgba(34,197,94,0.15); color:#86EFAC;"></div>
    </div>

   
    <div class="d-flex justify-content-start gap-2 mb-5">
      <a href="<?= site_url('labDashboard/dashboard') ?>" class="btn btn-outline-secondary px-4">
        <i class="bi bi-arrow-left me-1"></i>Cancel
      </a>
      <button type="submit" id="btn-new-booking" class="btn px-4 fw-semibold" >
        <i class="bi bi-plus-lg me-1"></i>Create Booking
      </button>
    </div>
  </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

document.getElementById('patient_name').addEventListener('input', function () {
    this.value = this.value.replace(/[^A-Za-z\s]/g, '');
  });

 
 const phoneField = document.getElementById('phone_number');
const phoneError = document.getElementById('phone-error');
const testsError = document.getElementById('tests-error');
const bookingForm = document.getElementById('booking_form');
  const testsList = document.getElementById('tests_list');
  const noTestsRow = document.getElementById('no_tests_row');
  const searchInput = document.getElementById('test_search');
  const searchDropdown = document.getElementById('search_dropdown');
  function updateEmptyState() {
  const hasTests = !!testsList.querySelector('[data-test-row]');
  noTestsRow.classList.toggle('d-none', hasTests);
  testsList.style.border = hasTests ? '1px solid #dee2e6' : '1px dashed #ced4da';
  applyToAllWrapper.classList.toggle('d-none', !hasTests);
  financialSummaryPanel.classList.toggle('d-none', !hasTests);
  if (hasTests) testsError.classList.add('d-none');
}
bookingForm.addEventListener('submit', function (e) {
  let valid = true;

  if (!phonePattern.test(phoneField.value)) {
    phoneError.classList.remove('d-none');
    valid = false;
  }

  if (!testsList.querySelector('[data-test-row]')) {
    testsError.classList.remove('d-none');
    valid = false;
  }

  if (!valid) e.preventDefault();
});
  const allTests = <?= json_encode(array_map(fn($t) => [
      'id'    => $t['id'],
      'test_code'  => $t['test_code'],
      'name'  => $t['test_name'],
      'price' => (float) $t['rate'],
  ], $tests), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
  const defaultDiscountInput = document.getElementById('default_discount');
  const applyToAllBtn = document.getElementById('apply_to_all');
  const applyToAllWrapper = document.getElementById('apply_to_all_wrapper');
  const financialSummaryPanel = document.getElementById('financial_summary_panel');
  const summaryOriginal = document.getElementById('summary_original');
  const summaryDiscount = document.getElementById('summary_discount');
  const summaryPatientPays = document.getElementById('summary_patient_pays');
  const summaryLineItems = document.getElementById('summary_line_items');
  const prepaidBanner = document.getElementById('prepaid_banner');

  let rowCounter = 0;

  function updateEmptyState() {
    const hasTests = !!testsList.querySelector('[data-test-row]');
    noTestsRow.classList.toggle('d-none', hasTests);
    testsList.style.border = hasTests ? '1px solid #dee2e6' : '1px dashed #ced4da';
    applyToAllWrapper.classList.toggle('d-none', !hasTests);
    financialSummaryPanel.classList.toggle('d-none', !hasTests);
  }

  function fmt(n) {
    return 'PKR ' + Number(n).toLocaleString(undefined, {maximumFractionDigits: 0});
  }

  function recalcTotals() {
    let original = 0, payable = 0, prepaidCount = 0;
    const rows = [...testsList.querySelectorAll('[data-test-row]')];

    summaryLineItems.innerHTML = rows.map(row => {
      const price = parseFloat(row.dataset.price || 0);
      const final = parseFloat(row.dataset.final || 0);
      const discount = parseFloat(row.dataset.discount || 0);
      const name = row.dataset.name || '';
      original += price;
      payable += final;
      if (row.dataset.payment === 'prepaid') prepaidCount++;

      return `
        <div class="d-flex justify-content-between small mb-1">
          <span style="color:#9FC4DA;">${name} (${discount}% off)</span>
          <span>
            <span class="text-decoration-line-through" style="color:#6B93AC;">${fmt(price)}</span>
            <span class="text-white fw-semibold">${fmt(final)}</span>
          </span>
        </div>`;
    }).join('');

    summaryOriginal.textContent = fmt(original);
    summaryDiscount.textContent = '- ' + fmt(original - payable);
    summaryPatientPays.textContent = fmt(payable);

    if (prepaidCount > 0) {
      const label = prepaidCount === 1 ? 'test' : 'tests';
      prepaidBanner.textContent = `✓ ${prepaidCount} ${label} pre-paid`;
      prepaidBanner.classList.remove('d-none');
    } else {
      prepaidBanner.classList.add('d-none');
    }
  }

  function recalcRow(row) {
    const price = parseFloat(row.dataset.price || 0);
    const discount = parseFloat(row.querySelector('.discount-input').value || 0);
    const final = price - (price * discount / 100);
    const savings = price - final;
    row.dataset.final = final;
    row.dataset.discount = discount;
    row.querySelector('.final-cell').textContent = fmt(final);

    const saveBadge = row.querySelector('.save-badge');
    if (savings > 0) {
      saveBadge.textContent = 'save ' + fmt(savings);
      saveBadge.classList.remove('d-none');
    } else {
      saveBadge.classList.add('d-none');
    }

    recalcTotals();
  }

  function setPaymentState(row, method) {
    row.dataset.payment = method;
    const cashBtn = row.querySelector('.payment-cash');
    const prepaidBtn = row.querySelector('.payment-prepaid');

    if (method === 'cash') {
      cashBtn.className = 'btn btn-sm rounded-pill payment-cash bg-warning-subtle text-warning-emphasis border-0 fw-semibold';
      prepaidBtn.className = 'btn btn-sm rounded-pill payment-prepaid btn-outline-secondary';
    } else {
      cashBtn.className = 'btn btn-sm rounded-pill payment-cash btn-outline-secondary';
      prepaidBtn.className = 'btn btn-sm rounded-pill payment-prepaid bg-success-subtle text-success-emphasis border-0 fw-semibold';
    }
    cashBtn.textContent = 'Cash';
    prepaidBtn.textContent = 'Pre-paid ✓';
    recalcTotals();
  }

  function addTestRow(name, test_code, price, testId) {
    if (!name) return;
    rowCounter++;

    const row = document.createElement('div');
    row.dataset.testRow = 'true';
    row.dataset.price = price;
    row.dataset.name = name;
    row.className = 'p-3 border-bottom';
    row.innerHTML = `
    
      <div class="d-flex justify-content-between align-items-start" >
        <div>
          <span class="text-muted small me-2">${test_code || ''}</span>
          <span class="fw-semibold">${name}</span>
        </div>
        <div class="d-flex align-items-center gap-2">
          <span class="text-muted text-decoration-line-through">${fmt(price)}</span>
          <button type="button" class="btn btn-sm btn-link text-secondary p-0 remove-row" title="Remove">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-tag text-muted"></i>
          <input type="number" class="form-control form-control-sm discount-input"
                 name="tests[${rowCounter}][discount]"
                 style="width: 70px;" value="${defaultDiscountInput.value || 0}" min="0" max="100">
          <span>%</span>
          <i class="bi bi-arrow-right text-muted"></i>
          <span class="fw-bold final-cell">${fmt(price)}</span>
          <span class="badge bg-success-subtle text-success-emphasis rounded-pill save-badge d-none"></span>
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-sm rounded-pill payment-cash btn-outline-secondary">Cash</button>
          <button type="button" class="btn btn-sm rounded-pill payment-prepaid bg-success-subtle text-success-emphasis border-0 fw-semibold">Pre-paid ✓</button>
        </div>
      </div>
      <input type="hidden" name="tests[${rowCounter}][test_id]" value="${testId || ''}">
      <input type="hidden" name="tests[${rowCounter}][test_code]" value="${test_code || ''}">
      <input type="hidden" name="tests[${rowCounter}][name]" value="${name}">
      <input type="hidden" name="tests[${rowCounter}][price]" value="${price}">
      <input type="hidden" class="payment-input" name="tests[${rowCounter}][payment]" value="prepaid">
    
    `;
    testsList.appendChild(row);
    updateEmptyState();

    row.querySelector('.discount-input').addEventListener('input', () => recalcRow(row));
    row.querySelector('.remove-row').addEventListener('click', () => {
      row.remove();
      updateEmptyState();
      recalcTotals();
    });
    row.querySelector('.payment-cash').addEventListener('click', () => {
      setPaymentState(row, 'cash');
      row.querySelector('.payment-input').value = 'cash';
    });
    row.querySelector('.payment-prepaid').addEventListener('click', () => {
      setPaymentState(row, 'prepaid');
      row.querySelector('.payment-input').value = 'prepaid';
    });

    setPaymentState(row, 'prepaid');
    recalcRow(row);
    searchInput.value = '';
  }

  function renderSearchDropdown(query) {
    const q = query.trim().toLowerCase();
    if (!q) {
      searchDropdown.classList.add('d-none');
      searchDropdown.innerHTML = '';
      return;
    }

    const discount = parseFloat(defaultDiscountInput.value || 0);
    const matches = allTests
      .filter(t => t.name.toLowerCase().includes(q) || String(t.test_code).toLowerCase().includes(q))
      .slice(0, 30);

    if (matches.length === 0) {
      searchDropdown.innerHTML = '<div class="p-3 text-muted text-center small">No matching tests found.</div>';
      searchDropdown.classList.remove('d-none');
      return;
    }

    searchDropdown.innerHTML = matches.map(t => {
      const final = t.price - (t.price * discount / 100);
      const savings = t.price - final;
      return `
        <div class="d-flex justify-content-between align-items-start p-3 border-bottom search-result-item"
             role="button" data-id="${t.id}" data-code="${t.test_code}" data-name="${t.name}" data-price="${t.price}">
          <div>
            <span class="fw-semibold">${t.name}</span>
            <span class="text-muted small ms-2">${t.test_code}</span>
          </div>
          <div class="text-end">
            ${savings > 0 ? `<div class="text-muted text-decoration-line-through small">${fmt(t.price)}</div>` : ''}
            <div class="fw-bold ${savings > 0 ? 'text-success' : 'text-dark'}">${fmt(final)}</div>
            ${savings > 0 ? `<div class="small text-success">save ${fmt(savings)}</div>` : ''}
          </div>
        </div>`;
    }).join('');

    searchDropdown.classList.remove('d-none');

    searchDropdown.querySelectorAll('.search-result-item').forEach(item => {
      item.addEventListener('mouseenter', () => item.classList.add('bg-light'));
      item.addEventListener('mouseleave', () => item.classList.remove('bg-light'));
      item.addEventListener('click', () => {
        addTestRow(item.dataset.name, item.dataset.code, item.dataset.price, item.dataset.id);
        searchDropdown.classList.add('d-none');
        searchDropdown.innerHTML = '';
      });
    });
  }

  searchInput.addEventListener('input', () => renderSearchDropdown(searchInput.value));
  searchInput.addEventListener('focus', () => {
    if (searchInput.value) renderSearchDropdown(searchInput.value);
  });
  searchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      const first = searchDropdown.querySelector('.search-result-item');
      if (first) first.click();
    }
  });
  document.addEventListener('click', (e) => {
    if (!e.target.closest('#test_search') && !e.target.closest('#search_dropdown')) {
      searchDropdown.classList.add('d-none');
    }
  });

  
  defaultDiscountInput.addEventListener('input', () => {
    if (!searchDropdown.classList.contains('d-none')) {
      renderSearchDropdown(searchInput.value);
    }
  });

  applyToAllBtn.addEventListener('click', () => {
    testsList.querySelectorAll('[data-test-row]').forEach(row => {
      row.querySelector('.discount-input').value = defaultDiscountInput.value;
      recalcRow(row);
    });
  });

  const phonePattern = /^(03\d{2}-\d{7}|0(?!3)\d{2}-\d{7}|\+92\d{9,10})$/;

phoneField.addEventListener('input', function () {
  let value = this.value;

  if (value.startsWith('+')) {
    // International — keep the + and digits only, no dash formatting
    value = '+' + value.slice(1).replace(/\D/g, '');
    this.value = value.slice(0, 13); // +92 plus up to 10 digits
  } else {
    // Local — existing mobile/landline auto-dash logic
    let digits = value.replace(/\D/g, '');
    const isMobile = digits.length < 2 || digits[1] === '3';
    const maxLen = isMobile ? 11 : 10;
    digits = digits.slice(0, maxLen);

    const splitAt = isMobile ? 4 : 3;
    this.value = digits.length > splitAt
      ? digits.slice(0, splitAt) + '-' + digits.slice(splitAt)
      : digits;
  }

  if (phonePattern.test(this.value)) phoneError.classList.add('d-none');
});

phoneField.addEventListener('blur', function () {
  phoneError.classList.toggle('d-none', phonePattern.test(this.value));
});


  // ---- Pin location: map only opens when the search box is focused, closes via the × button ----

  const defaultCenter = [33.6844, 73.0479]; // Rawalpindi/Islamabad fallback

  const pinSearchInput = document.getElementById('pin_location_search');
  const pinDropdown     = document.getElementById('pin_search_dropdown');
  const pinMapWrapper   = document.getElementById('pin_map_wrapper');
  const pinMapCloseBtn  = document.getElementById('pin_map_close');
  let searchDebounce;
  let pinMap, pinMarker;
  let pinMapInitialized = false;

  function updatePinFields(lat, lng, address) {
    document.getElementById('pin_lat').value = lat;
    document.getElementById('pin_lng').value = lng;
    document.getElementById('pin_address').value = address || '';
  }

  function movePin(lat, lng, address, recenter = true) {
    const latLng = [lat, lng];
    pinMarker.setLatLng(latLng);
    if (recenter) { pinMap.setView(latLng, 16); }
    updatePinFields(lat, lng, address);
  }

  function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
      .then(res => res.json())
      .then(data => {
        const address = data.display_name || '';
        pinSearchInput.value = address;
        updatePinFields(lat, lng, address);
      })
      .catch(() => updatePinFields(lat, lng, ''));
  }

  // Map is created lazily (only the first time it's needed), since initializing
  // Leaflet inside a hidden container produces a blank/grey map.
  function initPinMap() {
    if (pinMapInitialized) return;

    pinMap = L.map('pin_map').setView(defaultCenter, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
      maxZoom: 19,
    }).addTo(pinMap);

    pinMarker = L.marker(defaultCenter, { draggable: true }).addTo(pinMap);

    pinMarker.on('dragend', () => {
      const { lat, lng } = pinMarker.getLatLng();
      reverseGeocode(lat, lng);
    });

    pinMap.on('click', (e) => {
      pinMarker.setLatLng(e.latlng);
      reverseGeocode(e.latlng.lat, e.latlng.lng);
    });

    pinMapInitialized = true;
  }

  function showPinMap() {
    pinMapWrapper.classList.remove('d-none');
    initPinMap();
    // Nudge Leaflet to recalculate tile size now that the container is visible.
    setTimeout(() => pinMap.invalidateSize(), 80);
  }

  function hidePinMap() {
    pinMapWrapper.classList.add('d-none');
  }

  pinSearchInput.addEventListener('focus', () => {
    showPinMap();
  });

  pinMapCloseBtn.addEventListener('click', () => {
    hidePinMap();
  });

  pinSearchInput.addEventListener('input', function () {
    clearTimeout(searchDebounce);
    const q = this.value.trim();

    if (!q) {
      pinDropdown.classList.add('d-none');
      pinDropdown.innerHTML = '';
      return;
    }

    // Nominatim's usage policy caps free requests at ~1/sec — debounce keeps us well under that.
    searchDebounce = setTimeout(() => {
      fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q)}&countrycodes=pk&limit=5`)
        .then(res => res.json())
        .then(results => {
          if (!results.length) {
            pinDropdown.innerHTML = '<div class="p-3 text-muted text-center small">No matches found.</div>';
            pinDropdown.classList.remove('d-none');
            return;
          }

          pinDropdown.innerHTML = results.map(r => `
            <div class="p-2 border-bottom pin-result-item" role="button"
                 data-lat="${r.lat}" data-lon="${r.lon}" data-address="${r.display_name.replace(/"/g, '&quot;')}">
              <small>${r.display_name}</small>
            </div>`).join('');
          pinDropdown.classList.remove('d-none');

          pinDropdown.querySelectorAll('.pin-result-item').forEach(item => {
            item.addEventListener('mouseenter', () => item.classList.add('bg-light'));
            item.addEventListener('mouseleave', () => item.classList.remove('bg-light'));
            item.addEventListener('click', () => {
              showPinMap();
              movePin(parseFloat(item.dataset.lat), parseFloat(item.dataset.lon), item.dataset.address);
              pinSearchInput.value = item.dataset.address;
              pinDropdown.classList.add('d-none');
              pinDropdown.innerHTML = '';
            });
          });
        });
    }, 400);
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('#pin_location_search') && !e.target.closest('#pin_search_dropdown')) {
      pinDropdown.classList.add('d-none');
    }
  });
</script>

</body>
</html>

<?= view('templates/footer') ?>