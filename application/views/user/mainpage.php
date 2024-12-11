<!DOCTYPE html>
<html lang="en">
<head>
    <title>Expired Support System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/artemis-assets/images/shuffle-for-bootstrap.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS and JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

</head>
<body>
<div class="container py-4">
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 5px;">
        <div style="text-align: center; flex-grow: 2;">
            <h3 style="margin: 0;">NADICOM DIGITAL SDN BHD</h3>
            <h4 style="margin: 0;">EXPIRED SUPPORT SYSTEM</h4>
        </div>
        <div>
            <a href="<?= site_url('login/logout') ?>" class="btn btn-outline-danger" style="font-size: medium;" title="Logout">
                <i class="fas fa-sign-out-alt me-3"></i> Logout
            </a>
        </div>
    </div>
    <!-- Table -->
    <table id="companiesTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Bill Date</th>
                <th>Company Name</th>
                <th>Service</th>
                <th>Start Date</th>
                <th>Expired Date</th>
                <th>Day Left</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<!-- DataTables Initialization -->
<script>
    $(document).ready(function () {
        var table = $('#companiesTable').DataTable({
            pageLength: 10,          // Default rows per page
            lengthMenu: [5, 10, 25], // Options for rows per page
            order: [[0, 'asc']],     // Default sorting by 'Day Left' column
            columnDefs: [
                { targets: [8], orderable: false } // Disable sorting for 'Action' column
            ],
            language: {
                emptyTable: "No data available",
                search: "Search:", // Custom text for the search box
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            },
            dom: 'Bfrtip', // Add buttons below the search bar
            buttons: [
                {
                    text: 'All',
                    className: 'btn btn-light me-2',
                    action: function () {
                        table.columns(7).search('').draw(); // Tampilkan semua data
                        table.order([[0, 'asc']]).draw();

                        resetButtonStyles();
                        $('.dt-button:contains("Active")').addClass('btn-primary text-white');
                    }
                },
                {
                    text: 'Active',
                    className: 'btn btn-success me-2',
                    action: function () {
                        table.columns(7).search('Active').draw(); // Filter untuk 'Active'

                        resetButtonStyles();
                        $('.dt-button:contains("Active")').addClass('btn-primary text-white');
                    }
                },
                {
                    text: 'Expired',
                    className: 'btn btn-danger me-2',
                    action: function () {
                        table.columns(7).search('Expired').draw(); // Filter untuk 'Expired'

                        resetButtonStyles();
                        $('.dt-button:contains("Expired")').addClass('btn-primary text-white');
                    }
                },
                {
                    text: 'No Subscription',
                    className: 'btn btn-secondary me-2',
                    action: function () {
                        table.columns(7).search('No Subscription').draw(); // Filter untuk 'No Subscription'

                        resetButtonStyles();
                        $('.dt-button:contains("No Subscription")').addClass('btn-primary text-white');
                    }
                }
            ],
            data: <?= json_encode($combined); ?>, // Backend data passed to DataTables
            columns: [
                { data: null, render: (data, type, row, meta) => meta.row + 1 }, // Auto-number
                { data: 'DOCDATE' },        // Bill Date
                { data: 'COMPANYNAME' },    // Company Name
                { data: 'DESCRIPTION' },    // Service
                { data: 'DOCREF1' },        // Start Date
                { 
                    data: 'DOCNOEX',        // Expired Date
                    render: function (data, type, row) {
                        // Format to dd/mm/yyyy if valid
                        if (data && !isNaN(Date.parse(data))) {
                            var date = new Date(data);
                            var day = String(date.getDate()).padStart(2, '0');
                            var month = String(date.getMonth() + 1).padStart(2, '0');
                            var year = date.getFullYear();
                            return `${day}/${month}/${year}`;
                        } else {
                            return 'N/A'; // Handle invalid date
                        }
                    }
                },
                { data: 'day_left' },       // Day Left
                { data: 'status' },         // Status
                { 
                    data: null,
                    render: function (data, type, row) {

                        var phoneNumber = row.MOBILE;
                        var amount = row.DOCAMT;
                        var companyName = row.COMPANYNAME; // Nama perusahaan
                        var expiredDate = row.DOCNOEX; // Tanggal expired
                        var servis = row.DESCRIPTION;

                        // Encode pesan untuk URL WhatsApp
                        var message = `REMINDER ${companyName} SEBANYAK RM${amount} SERVIS ${servis}, UTK BAYAR SILA HUBUNGI 097191081/HUBUNGI AGEN NADICOM. BYR SBLM ${expiredDate}. PERTANYAAN: 097191081. ABAIKAN JIKA ANDA TELAH BAYAR`;
                        var encodedMessage = encodeURIComponent(message);

                        return `<a href="https://wa.me/${phoneNumber}?text=${encodedMessage}" target="_blank">
                                    <i class="fab fa-whatsapp text-success" style="font-size: 35px;"></i>
                                </a>`;
                    }
                }
            ]
        });
    });
</script>

</body>
</html>