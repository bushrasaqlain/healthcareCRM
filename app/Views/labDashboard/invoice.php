<?= view('templates/header', [
    'pageTitle'  => 'Invoice #' . $invoiceNumber,
    'activePage' => 'lablist'
]) ?>

<style>
body{
    background:#f3f6fb;
}

.invoice-wrap{
    max-width:1100px;
    margin:30px auto;
    padding:0 15px;
}

/* ACTION BUTTONS */

.invoice-actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.btn-action{
    border:none;
    padding:12px 22px;
    border-radius:10px;
    color:#fff;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.btn-action:hover{
    transform:translateY(-2px);
}

.btn-print{
    background:#2563eb;
}

.btn-share{
    background:#16a34a;
}

/* MAIN CARD */

.invoice-container{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

/* BLUE HEADER */

.invoice-header{
    background:#005b8f;
    color:#fff;
    padding:40px;
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    flex-wrap:wrap;
}

.company-block{
    max-width:50%;
}

.company-logo{
    width:70px;
    height:70px;
    border-radius:14px;
    background:#fff;
    color:#005b8f;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    font-weight:700;
    margin-bottom:15px;
}

.company-name{
    font-size:28px;
    font-weight:700;
    margin-bottom:6px;
}

.company-subtitle{
    color:#dbeafe;
    font-size:14px;
}

.invoice-right{
    text-align:right;
}

.invoice-title{
    font-size:48px;
    font-weight:700;
    letter-spacing:2px;
    margin-bottom:10px;
}

.invoice-no{
    font-size:15px;
    color:#dbeafe;
    margin-bottom:4px;
}

.invoice-date{
    font-size:14px;
    color:#dbeafe;
    margin-bottom:15px;
}

.status-badge{
    display:inline-block;
    padding:8px 18px;
    border-radius:50px;
    font-size:13px;
    font-weight:700;
}

.status-paid{
    background:#dcfce7;
    color:#15803d;
}

.status-unpaid{
    background:#fee2e2;
    color:#dc2626;
}

/* CONTENT */

.invoice-body{
    padding:35px;
}

/* BILLING GRID */

.billing-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:40px;
    margin-bottom:35px;
}

.billing-card{
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:20px;
}

.billing-title{
    font-size:13px;
    font-weight:700;
    color:#6b7280;
    text-transform:uppercase;
    letter-spacing:1px;
    margin-bottom:15px;
}

.info-row{
    margin-bottom:8px;
    color:#111827;
    font-size:14px;
}

.info-row strong{
    color:#111827;
}

@media(max-width:768px){

    .invoice-header{
        padding:25px;
    }

    .invoice-right{
        text-align:left;
        margin-top:25px;
        width:100%;
    }

    .invoice-title{
        font-size:34px;
    }

    .billing-grid{
        grid-template-columns:1fr;
    }

    .invoice-body{
        padding:20px;
    }

    .company-block{
        max-width:100%;
    }
}
</style>

<div class="invoice-wrap">

    <!-- ACTIONS -->

    <div class="invoice-actions">

        <button onclick="window.print()" class="btn-action btn-print">
            Print Invoice
        </button>

        <button onclick="openShareModal()" class="btn-action btn-share">
            Share Invoice
        </button>

    </div>

    <!-- INVOICE CARD -->

    <div class="invoice-container">

        <!-- HEADER -->

        <div class="invoice-header">

            <div class="company-block">

                <div class="company-logo">
                    M
                </div>

                <div class="company-name">
                    <?= esc($labName) ?>
                </div>

                <div class="company-subtitle">
                    Laboratory & Diagnostic Services
                </div>

            </div>

            <div class="invoice-right">

                <div class="invoice-title">
                    INVOICE
                </div>

                <div class="invoice-no">
                    Invoice #<?= esc($invoiceNumber) ?>
                </div>

                <div class="invoice-date">
                    Issued <?= esc($issuedDate) ?>
                </div>

                <span class="status-badge <?= ($booking['paid_status'] == 'prepaid') ? 'status-paid' : 'status-unpaid' ?>">
                    <?= ($booking['paid_status'] == 'prepaid') ? 'PAID' : 'UNPAID' ?>
                </span>

            </div>

        </div>

        <!-- BODY -->

        <div class="invoice-body">

            <!-- BILLING INFO -->

            <div class="billing-grid">

                <div class="billing-card">

                    <div class="billing-title">
                        Billed To
                    </div>

                    <div class="info-row">
                        <strong><?= esc($patient['patient_name']) ?></strong>
                    </div>

                    <div class="info-row">
                        <?= esc($patient['phone_number']) ?>
                    </div>

                    <div class="info-row">
                        <?= esc($patient['home_address']) ?>
                    </div>

                    <?php if(!empty($patient['gender'])): ?>
                    <div class="info-row">
                        Gender: <?= esc($patient['gender']) ?>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($patient['age'])): ?>
                    <div class="info-row">
                        Age: <?= esc($patient['age']) ?>
                    </div>
                    <?php endif; ?>

                </div>

                <div class="billing-card">

                    <div class="billing-title">
                        Invoice Details
                    </div>

                    <div class="info-row">
                        <strong>Booking ID:</strong>
                        <?= esc($booking['id']) ?>
                    </div>

                    <div class="info-row">
                        <strong>Status:</strong>
                        <?= esc($booking['status']) ?>
                    </div>

                    <div class="info-row">
                        <strong>Date:</strong>
                        <?= date('d M Y', strtotime($booking['date_created'])) ?>
                    </div>

                    <div class="info-row">
                        <strong>Payment:</strong>
                        <?= ucfirst($booking['paid_status']) ?>
                    </div>

                </div>

            </div>

            <!-- TESTS TABLE -->

<table class="test-table">

    <thead>
        <tr>
            <th>Test Name</th>
            <th>Code</th>
            <th>List Price</th>
            <th>Discount</th>
            <th style="text-align:right;">Amount</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($tests as $test): ?>

        <tr>

            <td>
                <strong><?= esc($test['test_name']) ?></strong>
            </td>

            <td>
                <?= esc($test['test_code'] ?? '-') ?>
            </td>

            <td>
                <span style="
                    text-decoration:line-through;
                    color:#9ca3af;">
                    PKR <?= number_format($test['rack_rate']) ?>
                </span>
            </td>

            <td>
                <?= $test['discount_percent'] ?? 0 ?>%
            </td>

            <td style="
                text-align:right;
                font-weight:700;
                color:#111827;">
                PKR <?= number_format($test['patient_price']) ?>
            </td>

        </tr>

        <?php endforeach; ?>

    </tbody>

</table>

<style>
.test-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:35px;
}

.test-table th{
    background:#f8fafc;
    color:#6b7280;
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:1px;
    padding:15px;
    border-bottom:2px solid #e5e7eb;
}

.test-table td{
    padding:16px;
    border-bottom:1px solid #edf2f7;
    color:#111827;
    font-size:14px;
}
</style>

<!-- TOTAL SECTION -->

<div class="summary-box">

    <div class="summary-row">
        <span>Subtotal</span>
        <span>PKR <?= number_format($originalTotal) ?></span>
    </div>

    <?php if($discountTotal > 0): ?>

    <div class="summary-row">
        <span>Total Discount</span>

        <span style="color:#dc2626;">
            - PKR <?= number_format($discountTotal) ?>
        </span>
    </div>

    <?php endif; ?>

    <div class="summary-row grand-total">
        <span>Total Payable</span>
        <span>PKR <?= number_format($patientPays) ?></span>
    </div>

</div>

<style>
.summary-box{
    width:350px;
    margin-left:auto;
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:20px;
}

.summary-row{
    display:flex;
    justify-content:space-between;
    padding:10px 0;
    font-size:15px;
}

.grand-total{
    margin-top:10px;
    padding-top:15px;
    border-top:2px solid #dbe3ee;
    font-size:22px;
    font-weight:700;
    color:#111827;
}

@media(max-width:768px){

    .summary-box{
        width:100%;
    }
}
</style>

<!-- FOOTER -->

<div class="invoice-footer">

    <div class="footer-col">

        <h4>Need Help?</h4>

        <p>
            Contact our support team for any invoice related query.
        </p>

        <p>
            Reference Invoice:
            <?= esc($invoiceNumber) ?>
        </p>

    </div>

    <div class="footer-col">

        <h4>Notes</h4>

        <p>
            Prices are inclusive of all applicable charges.
        </p>

        <p>
            This is a system generated invoice and does not require a signature.
        </p>

    </div>

</div>

<style>
.invoice-footer{
    margin-top:40px;
    border-top:1px solid #e5e7eb;
    padding-top:25px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:40px;
}

.footer-col h4{
    margin-bottom:10px;
    color:#111827;
}

.footer-col p{
    color:#6b7280;
    margin:6px 0;
    font-size:14px;
}

@media(max-width:768px){

    .invoice-footer{
        grid-template-columns:1fr;
    }
}
</style>

        </div>
    </div>
</div>

<!-- SHARE MODAL -->

<div class="modal-overlay" id="shareModal">

    <div class="modal-content">

        <button class="modal-close"
                onclick="closeShareModal()">
            ×
        </button>

        <h2>Share Invoice</h2>

        <p>
            Generate and share a secure invoice link.
        </p>

        <div class="share-link-wrap">

            <input
                type="text"
                id="shareLink"
                readonly>

            <button onclick="copyLink()">
                Copy
            </button>

        </div>

        <div id="copiedMessage">
            Link copied successfully
        </div>

    </div>

</div>

<style>
.modal-overlay{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.55);
    z-index:9999;
    justify-content:center;
    align-items:center;
}

.modal-content{
    width:500px;
    max-width:90%;
    background:#fff;
    border-radius:16px;
    padding:30px;
    position:relative;
}

.modal-close{
    position:absolute;
    right:15px;
    top:10px;
    border:none;
    background:none;
    font-size:28px;
    cursor:pointer;
}

.share-link-wrap{
    display:flex;
    gap:10px;
    margin-top:20px;
}

.share-link-wrap input{
    flex:1;
    border:1px solid #d1d5db;
    padding:10px;
    border-radius:8px;
}

.share-link-wrap button{
    border:none;
    background:#2563eb;
    color:#fff;
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
}

#copiedMessage{
    display:none;
    margin-top:15px;
    color:#16a34a;
    font-weight:600;
}
</style>

<script>

function openShareModal(){

    document.getElementById('shareModal').style.display='flex';

    fetch(
        '<?= base_url("booking/generateShareLink/".$booking["id"]) ?>',
        {
            method:'POST'
        }
    )
    .then(res => res.json())
    .then(data => {

        if(data.success){

            document.getElementById('shareLink').value =
                data.share_url;
        }
    });
}

function closeShareModal(){

    document.getElementById('shareModal').style.display='none';
}

function copyLink(){

    const input =
        document.getElementById('shareLink');

    input.select();

    navigator.clipboard.writeText(input.value);

    document.getElementById('copiedMessage')
        .style.display='block';

    setTimeout(function(){

        document.getElementById('copiedMessage')
            .style.display='none';

    },3000);
}

window.onclick = function(event){

    const modal =
        document.getElementById('shareModal');

    if(event.target === modal){

        closeShareModal();
    }
}
</script>

<?= view('templates/footer') ?>