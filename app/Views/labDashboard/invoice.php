<?= view('templates/header', ['pageTitle' => 'Invoice #' . $invoiceNumber, 'activePage' => 'lablist']) ?>

<style>
.invoice-wrap {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px 16px 60px;
}

/* Invoice Container */
.invoice-container {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 40px;
    position: relative;
}

/* Header Section */
.invoice-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    border-bottom: 2px solid #f3f4f6;
    padding-bottom: 24px;
    margin-bottom: 24px;
}

.invoice-logo {
    display: flex;
    align-items: center;
    gap: 12px;
}

.invoice-logo .logo-icon {
    width: 48px;
    height: 48px;
    background: #1d4ed8;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 18px;
}

.invoice-logo h1 {
    font-size: 24px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.invoice-logo .subtitle {
    font-size: 13px;
    color: #6b7280;
    margin-top: 2px;
}

.invoice-status {
    text-align: right;
}

.invoice-status .status-badge {
    display: inline-block;
    padding: 6px 20px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.status-paid {
    background: #dcfce7;
    color: #15803d;
}

.status-unpaid {
    background: #fee2e2;
    color: #dc2626;
}

.status-pending {
    background: #fef9c3;
    color: #854d0e;
}

.invoice-number {
    font-size: 13px;
    color: #6b7280;
    margin-top: 8px;
}

/* Action Buttons */
.invoice-actions {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-pdf {
    background: #dc2626;
    color: #fff;
}

.btn-print {
    background: #1d4ed8;
    color: #fff;
}

.btn-share {
    background: #16a34a;
    color: #fff;
}

/* Billing Info Grid */
.billing-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 32px;
}

.billing-section h3 {
    font-size: 14px;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 12px;
}

.billing-section .info-item {
    margin-bottom: 6px;
    font-size: 14px;
    color: #111827;
}

.billing-section .info-item strong {
    color: #6b7280;
    font-weight: 500;
}

/* Test Items Table */
.test-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 32px;
}

.test-table th {
    background: #f9fafb;
    padding: 12px 16px;
    text-align: left;
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #e5e7eb;
}

.test-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #f3f4f6;
    font-size: 14px;
    color: #111827;
}

.test-table .test-code {
    font-weight: 600;
    color: #1d4ed8;
}

.test-table .test-name {
    font-weight: 500;
}

.test-table .test-price {
    font-weight: 600;
    text-align: right;
}

/* Financial Summary */
.financial-summary {
    border-top: 2px solid #f3f4f6;
    padding-top: 20px;
    margin-top: 8px;
}

.fin-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 14px;
    color: #374151;
}

.fin-row.total {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    border-top: 2px solid #e5e7eb;
    padding-top: 16px;
    margin-top: 8px;
}

.fin-row .discount-amount {
    color: #dc2626;
}

/* Footer */
.invoice-footer {
    border-top: 2px solid #f3f4f6;
    padding-top: 24px;
    margin-top: 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: #6b7280;
}

.invoice-footer .support {
    display: flex;
    align-items: center;
    gap: 8px;
}

.invoice-footer .notes {
    font-size: 12px;
    color: #9ca3af;
}

/* Share Modal */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.modal-overlay.active {
    display: flex;
}

.modal-content {
    background: #fff;
    border-radius: 16px;
    padding: 32px;
    max-width: 500px;
    width: 90%;
    position: relative;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        transform: translateY(30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-close {
    position: absolute;
    top: 16px;
    right: 16px;
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #6b7280;
}

.modal-title {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
}

.modal-subtitle {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 20px;
}

.share-link-container {
    display: flex;
    gap: 12px;
    margin: 16px 0 20px;
}

.share-link-container input {
    flex: 1;
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    background: #f9fafb;
    color: #111827;
}

.share-link-container input:focus {
    outline: none;
    border-color: #1d4ed8;
}

.btn-copy {
    padding: 10px 20px;
    background: #1d4ed8;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}

.btn-copy:hover {
    background: #1e40af;
}

.share-methods {
    display: flex;
    gap: 12px;
    margin-top: 16px;
}

.share-method {
    flex: 1;
    padding: 12px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
    color: #111827;
    transition: all 0.2s;
}

.share-method:hover {
    border-color: #1d4ed8;
    background: #f0f7ff;
}

.share-method .icon {
    font-size: 28px;
    display: block;
    margin-bottom: 4px;
}

.share-method .label {
    font-size: 12px;
    font-weight: 500;
}

.copied-message {
    display: none;
    color: #16a34a;
    font-size: 13px;
    font-weight: 600;
    margin-top: 12px;
    text-align: center;
}

.copied-message.show {
    display: block;
}

/* Responsive */
@media(max-width: 768px) {
    .invoice-container {
        padding: 20px;
    }
    
    .invoice-header {
        flex-direction: column;
        gap: 16px;
    }
    
    .invoice-status {
        text-align: left;
        width: 100%;
    }
    
    .billing-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .invoice-actions {
        flex-direction: column;
    }
    
    .btn-action {
        justify-content: center;
        width: 100%;
    }
    
    .test-table {
        font-size: 12px;
    }
    
    .test-table th,
    .test-table td {
        padding: 8px 10px;
    }
    
    .share-link-container {
        flex-direction: column;
    }
    
    .share-methods {
        flex-direction: column;
    }
}

@media print {
    .invoice-actions,
    .back-btn {
        display: none !important;
    }
    
    .invoice-container {
        border: none !important;
        padding: 20px !important;
    }
    
    .invoice-footer {
        page-break-inside: avoid;
    }
    
    .modal-overlay {
        display: none !important;
    }
}
</style>

<div class="invoice-wrap">


    <!-- Action Buttons -->
    <div class="invoice-actions">
      
        <button onclick="window.print()" class="btn-action btn-print">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 6 2 18 2 18 9"/>
                <path d="M18 9h3v6h-3"/>
                <path d="M6 9H3v6h3"/>
                <rect x="6" y="13" width="12" height="8"/>
                <line x1="9" y1="17" x2="15" y2="17"/>
            </svg>
            Print
        </button>
        
        <button onclick="openShareModal()" class="btn-action btn-share">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="18" cy="5" r="3"/>
                <circle cx="6" cy="12" r="3"/>
                <circle cx="18" cy="19" r="3"/>
                <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
            </svg>
            Share Link
        </button>
    </div>

    <!-- Invoice -->
    <div class="invoice-container" id="invoiceContainer">
        <!-- Header -->
        <div class="invoice-header">
            <div class="invoice-logo">
                <div class="logo-icon">M</div>
                <div>
                    <h1></h1>
                    <div class="subtitle"><?= esc($labName) ?></div>
                </div>
            </div>
            <div class="invoice-status">
                <span class="status-badge <?= $booking['paid_status'] === 'paid' ? 'status-paid' : 'status-unpaid' ?>">
                    <?= strtoupper($booking['paid_status'] ?? 'UNPAID') ?>
                </span>
                <div class="invoice-number">
                    Invoice #<?= $invoiceNumber ?>
                </div>
                <div class="invoice-number" style="font-weight:400;">
                    Issued <?= $issuedDate ?>
                </div>
            </div>
        </div>

        <!-- Billing Info -->
        <div class="billing-grid">
            <div class="billing-section">
                <h3>Billed To</h3>
                <div class="info-item"><strong><?= esc($patient['patient_name']) ?></strong></div>
                <div class="info-item"><?= esc($patient['phone_number']) ?></div>
                <div class="info-item"><?= esc($patient['home_address']) ?></div>
                <?php if (!empty($patient['gender'])): ?>
                    <div class="info-item"><?= esc($patient['gender']) ?></div>
                <?php endif; ?>
            </div>
            <div class="billing-section">
                <h3>Invoice Details</h3>
                <div class="info-item"><strong>Booking:</strong> <?= esc($booking['booking_no'] ?? '#USIT2KOU') ?></div>
                <div class="info-item"><strong>Date:</strong> <?= date('d M Y', strtotime($booking['date_created'])) ?></div>
                <div class="info-item"><strong>Status:</strong> <?= esc($booking['status'] ?? 'In Process') ?></div>
            </div>
        </div>

        <!-- Tests Table -->
        <table class="test-table">
            <thead>
                <tr>
                    
                    <th>Test</th>
                    <th>List Price</th>
                    <th>Discount</th>
                    <th style="text-align:right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tests as $test): ?>
                <tr>
                    
                    <td><div class="test-name"><?= esc($test['test_name']) ?></div>
                <div class="test-code"><?= esc($test['test_code'] ?? '—') ?></div>
                </td>
                    <td class="price-strike" >PKR <?= number_format($test['rack_rate']) ?></td>
                    <td><?= $test['discount_percent'] ?? 0 ?>%</td>
                    <td style="text-align:right;font-weight:600;">
                        PKR <?= number_format($test['patient_price']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Financial Summary -->
        <div class="financial-summary">
            <div class="fin-row">
                <span>Subtotal</span>
                <span>PKR <?= number_format($originalTotal) ?></span>
            </div>
            <?php if ($discountTotal > 0): ?>
            <div class="fin-row">
                <span>Discount</span>
                <span class="discount-amount">- PKR <?= number_format($discountTotal) ?></span>
            </div>
            <?php endif; ?>
            <div class="fin-row total">
                <span>Total Payable</span>
                <span>PKR <?= number_format($patientPays) ?></span>
            </div>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <div>
                <div class="support">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    Need help? Contact our support team
                </div>
                <div style="font-size:12px;color:#9ca3af;margin-top:4px;">
                    Quote your invoice number <?= $invoiceNumber ?>
                </div>
            </div>
            <div class="notes">
                <div>Prices are inclusive of all applicable charges.</div>
                <div>This is a system-generated invoice and does not require a signature.</div>
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal-overlay" id="shareModal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeShareModal()">&times;</button>
        
        <div class="modal-title">Share Invoice</div>
        <div class="modal-subtitle">Share this invoice link with anyone</div>
        
        <div class="share-link-container">
            <input type="text" id="shareLink" readonly value="<?= base_url('booking/sharedInvoice/' . $booking['id']) ?>">
            <button class="btn-copy" onclick="copyLink()">Copy</button>
        </div>
        
        <div class="share-methods">
            <a href="#" class="share-method" onclick="shareViaWhatsApp(event)">
                <span class="icon">💬</span>
                <span class="label">WhatsApp</span>
            </a>
            <a href="#" class="share-method" onclick="shareViaEmail(event)">
                <span class="icon">✉️</span>
                <span class="label">Email</span>
            </a>
            <a href="#" class="share-method" onclick="shareViaSMS(event)">
                <span class="icon">📱</span>
                <span class="label">SMS</span>
            </a>
        </div>
        
        <div class="copied-message" id="copiedMessage">
            ✓ Link copied to clipboard!
        </div>
    </div>
</div>

<script>
// Share Modal Functions
function openShareModal() {
    document.getElementById('shareModal').classList.add('active');
    document.getElementById('shareLink').value = '<?= base_url('booking/sharedInvoice/' . $booking['id']) ?>';
}

function closeShareModal() {
    document.getElementById('shareModal').classList.remove('active');
    document.getElementById('copiedMessage').classList.remove('show');
}

function copyLink() {
    const linkInput = document.getElementById('shareLink');
    linkInput.select();
    linkInput.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(linkInput.value);
    
    const msg = document.getElementById('copiedMessage');
    msg.classList.add('show');
    setTimeout(() => {
        msg.classList.remove('show');
    }, 3000);
}

function shareViaWhatsApp(e) {
    e.preventDefault();
    const url = encodeURIComponent(document.getElementById('shareLink').value);
    const text = encodeURIComponent('Here is the invoice for your lab test: ');
    window.open('https://wa.me/?text=' + text + url, '_blank');
}

function shareViaEmail(e) {
    e.preventDefault();
    const url = document.getElementById('shareLink').value;
    const subject = encodeURIComponent('Lab Test Invoice');
    const body = encodeURIComponent('Please find your invoice here: ' + url);
    window.location.href = 'mailto:?subject=' + subject + '&body=' + body;
}

function shareViaSMS(e) {
    e.preventDefault();
    const url = document.getElementById('shareLink').value;
    const body = encodeURIComponent('Your lab test invoice: ' + url);
    window.location.href = 'sms:?body=' + body;
}

// Close modal on outside click
document.getElementById('shareModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeShareModal();
    }
});

// PDF Download Function
function downloadPDF() {
    // Show loading state
    const btn = document.querySelector('.btn-pdf');
    const originalText = btn.innerHTML;
    btn.innerHTML = 'Generating...';
    btn.disabled = true;
    
    // Use html2pdf or window.print()
    // For simplicity, we'll use print with PDF option
    setTimeout(() => {
        window.print();
        btn.innerHTML = originalText;
        btn.disabled = false;
    }, 500);
}
</script>

<!-- Include html2pdf library for better PDF generation (optional) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<?= view('templates/footer') ?>