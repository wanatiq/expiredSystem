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
        var companyname = "<?= $this->session->userdata('COMPANYNAME'); ?>";
        var filteredData = <?= json_encode($combined); ?>.filter(function (row) {
            return row.COMPANYNAME === companyname; // Match the company name
        });

        $('#companiesTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25],
            order: [[0, 'asc']],
            columnDefs: [{ targets: [8], orderable: false }],
            language: {
                emptyTable: "No data available",
                search: "Search:",
                paginate: { previous: "Previous", next: "Next" }
            },
            dom: 'Bfrtip',
            data: filteredData,
            columns: [
                { data: null, render: (data, type, row, meta) => meta.row + 1 },
                { data: 'DOCDATE' },
                { data: 'COMPANYNAME' },
                { data: 'DESCRIPTION' },
                { data: 'DOCREF1' },
                {
                    data: 'DOCNOEX',
                    render: function (data) {
                        if (data && !isNaN(Date.parse(data))) {
                            var date = new Date(data);
                            var day = String(date.getDate()).padStart(2, '0');
                            var month = String(date.getMonth() + 1).padStart(2, '0');
                            var year = date.getFullYear();
                            return `${day}/${month}/${year}`;
                        } else {
                            return 'N/A';
                        }
                    }
                },
                { data: 'day_left' },
                { data: 'status' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var phoneNumber = row.MOBILE;
                        var amount = row.DOCAMT;
                        var companyName = row.COMPANYNAME;
                        var expiredDate = row.DOCNOEX;
                        var service = row.DESCRIPTION;
                        var message = `REMINDER ${companyName} SEBANYAK RM${amount} SERVIS ${service}, UTK BAYAR SILA HUBUNGI 097191081/HUBUNGI AGEN NADICOM. BYR SBLM ${expiredDate}. PERTANYAAN: 097191081. ABAIKAN JIKA ANDA TELAH BAYAR`;
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