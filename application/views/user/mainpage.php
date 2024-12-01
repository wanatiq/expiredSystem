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
    <div class="mb-4 text-center">
        <h3>NADICOM DIGITAL SDN </h3>
        <h4>EXPIRED SUPPORT SYSTEM</h4>
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
            <!-- <?php if (!empty($combined)): ?>
                <?php foreach ($combined as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= $row->DOCDATE; ?></td>
                        <td><?= $row->COMPANYNAME; ?></td>
                        <td><?= $row->DESCRIPTION; ?></td>
                        <td><?= $row->DOCREF1; ?></td>
                        <td><?= $row->DOCNOEX; ?></td>
                        <td><?= $row->day_left; ?></td>
                        <td><?= $row->status; ?></td>
                        <td>
                            <a href="https://wa.me/60142159284?text=Sila Bayar Lesen SQL">
                                <i class="fab fa-whatsapp text-success" style="font-size: 20px;"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">No data available</td>
                </tr>
            <?php endif; ?> -->
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
                    className: 'btn btn-light',
                    action: function () {
                        table.columns(7).search('').draw(); // Tampilkan semua data
                        table.order([[0, 'asc']]).draw();
                    }
                },
                {
                    text: 'Active',
                    className: 'btn btn-success',
                    action: function () {
                        table.columns(7).search('Active').draw(); // Filter untuk 'Active'
                    }
                },
                {
                    text: 'Expired',
                    className: 'btn btn-danger',
                    action: function () {
                        table.columns(7).search('Expired').draw(); // Filter untuk 'Expired'
                    }
                },
                {
                    text: 'No Subscription',
                    className: 'btn btn-secondary',
                    action: function () {
                        table.columns(7).search('No subscription').draw(); // Filter untuk 'No Subscription'
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









<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <title>Expired Support System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/artemis-assets/images/shuffle-for-bootstrap.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->


    <!-- jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- DataTables CSS and JS -->
    <!-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> -->
    
<!-- </head>
<body>
<div class="container py-4">
  
    <div class="mb-4 text-center">
        <h3>NADICOM DIGITAL SDN BHD</h3>
        <h4>EXPIRED SUPPORT SYSTEM</h4>
        
    </div>

    
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
        <?php $row_number = 1; ?>
        <?php foreach ($combined as $company): ?>
            <tr>
                <td><?= $row_number++; ?></td>
                <td><?= ($date = DateTime::createFromFormat('Y-m-d', $company->DOCDATE)) ? $date->format('d-m-Y') : 'N/A'; ?></td>
                <td><?= $company->COMPANYNAME; ?></td>
                <td><?= $company->DESCRIPTION; ?></td>
                <td><?= ($date = DateTime::createFromFormat('Y-m-d', $company->DOCREF1)) ? $date->format('d-m-Y') : 'N/A'; ?></td>
                <td><?= ($date = DateTime::createFromFormat('Y-m-d', $company->DOCNOEX)) ? $date->format('d-m-Y') : 'N/A'; ?></td>
                <td><?= $company->day_left; ?></td>
                <td><?= $company->status; ?></td>
                <td><a href="https://wa.me/60142159284?text=Sila Bayar Lesen SQL"><i class="fab fa-whatsapp text-success" style="font-size: 20px;"></i></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div> -->

<!-- DataTables Initialization -->
<!-- <script>
    $(document).ready(function () {
        // Add a custom sorting function for the status column
        $.fn.dataTable.ext.order['status'] = function (settings, col) {
            return this.api().column(col, { order: 'index' }).data().map(function (status) {
                if (status.includes('Expired')) {
                    return 1; // 'Expired' will have the highest priority
                } else if (status.includes('Active')) {
                    return 2; // 'Active' will come after 'Expired'
                } else if (status.includes('No subscription')) {
                    return 3; // 'No subscription' will be sorted last
                }
                return 4; // Default for unknown statuses
            });
        };

        
        $('#companiesTable').DataTable({
            pageLength: 10,          // Set default number of rows per page
            lengthMenu: [5, 10, 25], // Options for rows per page
            order: [[6, 'asc']],     // Default sorting (by first column)
            columnDefs: [
                { targets: [8], orderable: false } // Optional: Disable sorting for "Status"
            ]
        });
    });
</script>
</body>
</html> -->



 <!-- YG LAMA -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <title>Expired Support System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="  <?= base_url() ?>assets/artemis-assets/images/shuffle-for-bootstrap.png"> -->
    <!-- DataTables CSS -->
    <!-- <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet"> -->

    <!-- jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- Bootstrap 5 JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

    <!-- DataTables JS -->
    <!-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> -->


<!-- </head>
<body>
    <?php if ($this->session->flashdata('success')): ?>
        <div style="color:green; background-color: #e7f5e7; padding: 10px; 
                    border: 1px solid green; margin-bottom: 10px;">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div style="color: red; background-color: #f9e7e7; padding: 10px; 
                    border: 1px solid red; margin-bottom: 10px;">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?> 
    <div class="">
        <section>  
            <nav class="navbar d-lg-none navbar-dark bg-dark flex-wrap">    
                <div class="container-fluid">      
                    <div class="d-flex w-100 align-items-center">        
                        <a class="navbar-brand" href="#">          
                            <img class="img-fluid" src="<?= base_url() ?>assets/artemis-assets/logos/artemis-logo.svg" alt="alt" width="auto">        
                        </a>        <button class="navbar-burger navbar-toggler bg-primary ms-auto" type="button">          
                        <span class="navbar-toggler-icon"></span>        
                        </button>      
                    </div>    
                </div>  
            </nav>  
            <div class="position-relative navbar-menu d-none d-lg-block" style="z-index: 9999;">    
                <div class="navbar-backdrop d-lg-none position-fixed top-0 end-0 bottom-0 start-0 bg-dark" style="opacity: .5"></div>    
                <div class="position-fixed top-0 start-0 bottom-0 w-75 mw-sm-xs pt-6 bg-dark overflow-auto">      
                    <div class="px-6 pb-6 position-relative border-bottom border-secondary">        
                        <div class="d-inline-flex align-items-center">          
                            <a href="#">            
                                <img class="img-fluid" style="width:100%; height:100%" src="<?= base_url() ?>assets/artemis-assets/logos/NDSB.jpeg" alt="Artemis Logo" width="auto">          
                            </a>        
                        </div>     
                    </div>      
                    <div class="py-6 px-6">        
                        <div>          
                            <h3 class="mb-2 text-secondary text-uppercase small">Main</h3>          
                            <ul class="nav flex-column mb-8">            
                                <li class="nav-item nav-pills">              
                                    <a class="nav-link bg-primary text-white p-3 d-flex align-items-center" href="#">                
                                        <span class="d-inline-block text-secondary-light me-3">                  
                                            <svg width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000 svg">                    
                                                <path d="M14.9066 3.12873C14.9005 3.12223 14.8987 3.11358 14.8923 3.10722C14.8859 3.10086 14.8771 3.09893 14.8706 3.09278C13.3119 1.53907 11.2008 0.666626 8.99996 0.666626C6.79914 0.666626 4.68807 1.53907 3.12935 3.09278C3.12279 3.09893 3.11404 3.10081 3.10763 3.10722C3.10122 3.11363 3.09944 3.12222 3.09334 3.12873C1.93189 4.29575 1.14217 5.78067 0.823851 7.39609C0.505534 9.01151 0.672885 10.685 1.30478 12.2054C1.93668 13.7258 3.00481 15.025 4.37435 15.9389C5.7439 16.8528 7.35348 17.3405 8.99996 17.3405C10.6464 17.3405 12.256 16.8528 13.6256 15.9389C14.9951 15.025 16.0632 13.7258 16.6951 12.2054C17.327 10.685 17.4944 9.01151 17.1761 7.39609C16.8578 5.78067 16.068 4.29575 14.9066 3.12873ZM8.99992 15.6666C8.00181 15.6663 7.01656 15.4414 6.11714 15.0087C5.21773 14.5759 4.42719 13.9464 3.80409 13.1666H7.15015C7.38188 13.4286 7.66662 13.6383 7.98551 13.782C8.3044 13.9257 8.65017 14 8.99992 14C9.34968 14 9.69544 13.9257 10.0143 13.782C10.3332 13.6383 10.618 13.4286 10.8497 13.1666H14.1958C13.5727 13.9464 12.7821 14.5759 11.8827 15.0087C10.9833 15.4414 9.99804 15.6663 8.99992 15.6666ZM8.16659 11.5C8.16659 11.3351 8.21546 11.174 8.30703 11.037C8.3986 10.8999 8.52875 10.7931 8.68102 10.7301C8.83329 10.667 9.00085 10.6505 9.1625 10.6826C9.32415 10.7148 9.47263 10.7942 9.58918 10.9107C9.70572 11.0272 9.78509 11.1757 9.81724 11.3374C9.8494 11.499 9.83289 11.6666 9.76982 11.8189C9.70675 11.9711 9.59994 12.1013 9.4629 12.1929C9.32586 12.2844 9.16474 12.3333 8.99992 12.3333C8.77898 12.3331 8.56714 12.2452 8.41091 12.089C8.25468 11.9327 8.16681 11.7209 8.16659 11.5ZM15.1751 11.5017L15.1665 11.5H11.4999C11.4983 10.9846 11.3373 10.4824 11.0389 10.0623C10.7405 9.64218 10.3193 9.32472 9.83325 9.15352V6.49996C9.83325 6.27894 9.74546 6.06698 9.58918 5.9107C9.4329 5.75442 9.22093 5.66663 8.99992 5.66663C8.77891 5.66663 8.56695 5.75442 8.41067 5.9107C8.25439 6.06698 8.16659 6.27894 8.16659 6.49996V9.15352C7.68054 9.32472 7.25939 9.64218 6.96098 10.0623C6.66256 10.4824 6.50151 10.9846 6.49992 11.5H2.83334L2.82474 11.5017C2.60799 10.9669 2.46221 10.406 2.39114 9.83329H3.16659C3.3876 9.83329 3.59956 9.74549 3.75584 9.58921C3.91212 9.43293 3.99992 9.22097 3.99992 8.99996C3.99992 8.77894 3.91212 8.56698 3.75584 8.4107C3.59956 8.25442 3.3876 8.16663 3.16659 8.16663H2.39114C2.54005 6.9821 3.00621 5.85981 3.74037 4.91838L4.28597 5.46399C4.36335 5.54137 4.4552 5.60274 4.5563 5.64462C4.65739 5.68649 4.76574 5.70804 4.87517 5.70804C4.98459 5.70804 5.09294 5.68649 5.19404 5.64461C5.29513 5.60274 5.38699 5.54136 5.46436 5.46399C5.54173 5.38661 5.60311 5.29476 5.64498 5.19366C5.68686 5.09257 5.70841 4.98422 5.70841 4.87479C5.70841 4.76537 5.68686 4.65702 5.64498 4.55592C5.60311 4.45483 5.54173 4.36297 5.46435 4.2856L4.91881 3.74005C5.86016 3.00613 6.98227 2.5401 8.16659 2.39118V3.16663C8.16659 3.38764 8.25439 3.5996 8.41067 3.75588C8.56695 3.91216 8.77891 3.99996 8.99992 3.99996C9.22093 3.99996 9.4329 3.91216 9.58918 3.75588C9.74546 3.5996 9.83325 3.38764 9.83325 3.16663V2.39118C11.0176 2.5401 12.1397 3.00613 13.081 3.74005L12.5355 4.2856C12.3792 4.44186 12.2914 4.6538 12.2914 4.87479C12.2914 5.09578 12.3792 5.30772 12.5355 5.46399C12.6917 5.62025 12.9037 5.70804 13.1247 5.70804C13.3457 5.70804 13.5576 5.62026 13.7139 5.46399L14.2595 4.91838C14.9936 5.85981 15.4598 6.9821 15.6087 8.16663H14.8333C14.6122 8.16663 14.4003 8.25442 14.244 8.4107C14.0877 8.56698 13.9999 8.77894 13.9999 8.99996C13.9999 9.22097 14.0877 9.43293 14.244 9.58921C14.4003 9.74549 14.6122 9.83329 14.8333 9.83329H15.6087C15.5376 10.406 15.3919 10.9669 15.1751 11.5017Z" fill="#D7D5F8">
                                                </path>                  
                                            </svg>                
                                        </span>                
                                        <span class="small me-auto">Dashboard</span>                
                                    </a>            
                                </li>            
                                
                            </ul>          
                            <ul class="nav flex-column mb-auto">            
                                <li class="nav-item nav-pills">              
                                    <a class="nav-link text-white p-3 d-flex align-items-center" href="#">                
                                        <span class="d-inline-block text-secondary me-4">                  
                                            <svg width="14" height="17" viewbox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">                    
                                                <path d="M16.7666 6.9583L15.1916 6.4333L15.9333 4.94996C16.0085 4.7947 16.0336 4.61993 16.0053 4.44977C15.9769 4.27961 15.8964 4.12245 15.775 3.99996L14 2.22496C13.8768 2.1017 13.7182 2.02013 13.5463 1.99173C13.3743 1.96333 13.1979 1.98953 13.0416 2.06663L11.5583 2.8083L11.0333 1.2333C10.9778 1.06912 10.8726 0.926317 10.7322 0.824752C10.5918 0.723187 10.4232 0.667916 10.25 0.666629H7.74996C7.57526 0.666178 7.40483 0.720645 7.26277 0.82233C7.12071 0.924016 7.0142 1.06778 6.9583 1.2333L6.4333 2.8083L4.94996 2.06663C4.7947 1.99145 4.61993 1.9663 4.44977 1.99466C4.27961 2.02302 4.12245 2.10349 3.99996 2.22496L2.22496 3.99996C2.1017 4.1231 2.02013 4.28177 1.99173 4.45368C1.96333 4.62558 1.98953 4.80205 2.06663 4.9583L2.8083 6.44163L1.2333 6.96663C1.06912 7.02208 0.926317 7.12732 0.824752 7.26772C0.723187 7.40812 0.667916 7.57668 0.666629 7.74996V10.25C0.666178 10.4247 0.720645 10.5951 0.82233 10.7372C0.924016 10.8792 1.06778 10.9857 1.2333 11.0416L2.8083 11.5666L2.06663 13.05C1.99145 13.2052 1.9663 13.38 1.99466 13.5502C2.02302 13.7203 2.10349 13.8775 2.22496 14L3.99996 15.775C4.1231 15.8982 4.28177 15.9798 4.45368 16.0082C4.62558 16.0366 4.80205 16.0104 4.9583 15.9333L6.44163 15.1916L6.96663 16.7666C7.02253 16.9321 7.12904 17.0759 7.2711 17.1776C7.41317 17.2793 7.58359 17.3337 7.7583 17.3333H10.2583C10.433 17.3337 10.6034 17.2793 10.7455 17.1776C10.8875 17.0759 10.9941 16.9321 11.05 16.7666L11.575 15.1916L13.0583 15.9333C13.2126 16.0066 13.3856 16.0307 13.5541 16.0024C13.7225 15.9741 13.8781 15.8947 14 15.775L15.775 14C15.8982 13.8768 15.9798 13.7182 16.0082 13.5463C16.0366 13.3743 16.0104 13.1979 15.9333 13.0416L15.1916 11.5583L16.7666 11.0333C16.9308 10.9778 17.0736 10.8726 17.1752 10.7322C17.2767 10.5918 17.332 10.4232 17.3333 10.25V7.74996C17.3337 7.57526 17.2793 7.40483 17.1776 7.26277C17.0759 7.12071 16.9321 7.0142 16.7666 6.9583ZM15.6666 9.64996L14.6666 9.9833C14.4367 10.0579 14.2257 10.1816 14.0483 10.3459C13.871 10.5102 13.7315 10.711 13.6395 10.9346C13.5475 11.1582 13.5053 11.3991 13.5158 11.6406C13.5262 11.8821 13.5891 12.1185 13.7 12.3333L14.175 13.2833L13.2583 14.2L12.3333 13.7C12.1196 13.5935 11.8855 13.5342 11.6469 13.526C11.4083 13.5179 11.1707 13.5611 10.9502 13.6528C10.7298 13.7445 10.5316 13.8824 10.3691 14.0573C10.2066 14.2322 10.0835 14.44 10.0083 14.6666L9.67496 15.6666H8.34996L8.01663 14.6666C7.94204 14.4367 7.81832 14.2257 7.65404 14.0483C7.48977 13.871 7.28888 13.7315 7.06531 13.6395C6.84174 13.5475 6.60084 13.5053 6.35932 13.5158C6.11779 13.5262 5.88143 13.5891 5.66663 13.7L4.71663 14.175L3.79996 13.2583L4.29996 12.3333C4.41087 12.1185 4.47373 11.8821 4.48417 11.6406C4.49461 11.3991 4.45238 11.1582 4.36041 10.9346C4.26845 10.711 4.12894 10.5102 3.95158 10.3459C3.77422 10.1816 3.56325 10.0579 3.3333 9.9833L2.3333 9.64996V8.34996L3.3333 8.01663C3.56325 7.94204 3.77422 7.81832 3.95158 7.65404C4.12894 7.48977 4.26845 7.28888 4.36041 7.06531C4.45238 6.84174 4.49461 6.60084 4.48417 6.35932C4.47373 6.11779 4.41087 5.88143 4.29996 5.66663L3.82496 4.74163L4.74163 3.82496L5.66663 4.29996C5.88143 4.41087 6.11779 4.47373 6.35932 4.48417C6.60084 4.49461 6.84174 4.45238 7.06531 4.36041C7.28888 4.26845 7.48977 4.12894 7.65404 3.95158C7.81832 3.77422 7.94204 3.56325 8.01663 3.3333L8.34996 2.3333H9.64996L9.9833 3.3333C10.0579 3.56325 10.1816 3.77422 10.3459 3.95158C10.5102 4.12894 10.711 4.26845 10.9346 4.36041C11.1582 4.45238 11.3991 4.49461 11.6406 4.48417C11.8821 4.47373 12.1185 4.41087 12.3333 4.29996L13.2833 3.82496L14.2 4.74163L13.7 5.66663C13.5935 5.88033 13.5342 6.11442 13.526 6.35304C13.5179 6.59165 13.5611 6.82924 13.6528 7.0497C13.7445 7.27016 13.8824 7.46835 14.0573 7.63086C14.2322 7.79337 14.44 7.9164 14.6666 7.99163L15.6666 8.32496V9.64996ZM8.99996 5.66663C8.34069 5.66663 7.69623 5.86213 7.14806 6.2284C6.5999 6.59467 6.17266 7.11526 5.92036 7.72435C5.66807 8.33344 5.60206 9.00366 5.73068 9.65026C5.8593 10.2969 6.17676 10.8908 6.64294 11.357C7.10911 11.8232 7.70306 12.1406 8.34966 12.2692C8.99626 12.3979 9.66649 12.3319 10.2756 12.0796C10.8847 11.8273 11.4053 11.4 11.7715 10.8519C12.1378 10.3037 12.3333 9.65923 12.3333 8.99996C12.3333 8.11591 11.9821 7.26806 11.357 6.64294C10.7319 6.01782 9.88402 5.66663 8.99996 5.66663ZM8.99996 10.6666C8.67033 10.6666 8.34809 10.5689 8.07401 10.3857C7.79993 10.2026 7.58631 9.94231 7.46016 9.63777C7.33402 9.33322 7.30101 8.99811 7.36532 8.67481C7.42963 8.35151 7.58836 8.05454 7.82145 7.82145C8.05454 7.58836 8.35151 7.42963 8.67481 7.36532C8.99811 7.30101 9.33322 7.33402 9.63777 7.46016C9.94231 7.58631 10.2026 7.79993 10.3857 8.07401C10.5689 8.34809 10.6666 8.67033 10.6666 8.99996C10.6666 9.44199 10.491 9.86591 10.1785 10.1785C9.86591 10.491 9.44199 10.6666 8.99996 10.6666Z" fill="currentColor"></path>                  
                                            </svg>                
                                        </span>                
                                        <span class="small">Settings</span>              
                                    </a>            
                                </li>            
                                <li class="nav-item nav-pills">              
                                    <a class="nav-link text-white p-3 d-flex align-items-center" href="#">                
                                        <span class="d-inline-block text-secondary me-4">                  
                                            <svg width="14" height="16" viewbox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">                    
                                                <path d="M0.333618 8.99996C0.333618 9.22097 0.421416 9.43293 0.577696 9.58922C0.733976 9.7455 0.945938 9.83329 1.16695 9.83329H7.49195L5.57528 11.7416C5.49718 11.8191 5.43518 11.9113 5.39287 12.0128C5.35057 12.1144 5.32879 12.2233 5.32879 12.3333C5.32879 12.4433 5.35057 12.5522 5.39287 12.6538C5.43518 12.7553 5.49718 12.8475 5.57528 12.925C5.65275 13.0031 5.74492 13.0651 5.84647 13.1074C5.94802 13.1497 6.05694 13.1715 6.16695 13.1715C6.27696 13.1715 6.38588 13.1497 6.48743 13.1074C6.58898 13.0651 6.68115 13.0031 6.75862 12.925L10.0919 9.59163C10.1678 9.51237 10.2273 9.41892 10.2669 9.31663C10.3503 9.11374 10.3503 8.88618 10.2669 8.68329C10.2273 8.581 10.1678 8.48755 10.0919 8.40829L6.75862 5.07496C6.68092 4.99726 6.58868 4.93563 6.48716 4.89358C6.38564 4.85153 6.27683 4.82988 6.16695 4.82988C6.05707 4.82988 5.94826 4.85153 5.84674 4.89358C5.74522 4.93563 5.65298 4.99726 5.57528 5.07496C5.49759 5.15266 5.43595 5.2449 5.3939 5.34642C5.35185 5.44794 5.33021 5.55674 5.33021 5.66663C5.33021 5.77651 5.35185 5.88532 5.3939 5.98683C5.43595 6.08835 5.49759 6.18059 5.57528 6.25829L7.49195 8.16663H1.16695C0.945938 8.16663 0.733976 8.25442 0.577696 8.4107C0.421416 8.56698 0.333618 8.77895 0.333618 8.99996V8.99996ZM11.1669 0.666626H2.83362C2.17058 0.666626 1.53469 0.930018 1.06585 1.39886C0.59701 1.8677 0.333618 2.50358 0.333618 3.16663V5.66663C0.333618 5.88764 0.421416 6.0996 0.577696 6.25588C0.733976 6.41216 0.945938 6.49996 1.16695 6.49996C1.38797 6.49996 1.59993 6.41216 1.75621 6.25588C1.91249 6.0996 2.00028 5.88764 2.00028 5.66663V3.16663C2.00028 2.94561 2.08808 2.73365 2.24436 2.57737C2.40064 2.42109 2.6126 2.33329 2.83362 2.33329H11.1669C11.388 2.33329 11.5999 2.42109 11.7562 2.57737C11.9125 2.73365 12.0003 2.94561 12.0003 3.16663V14.8333C12.0003 15.0543 11.9125 15.2663 11.7562 15.4225C11.5999 15.5788 11.388 15.6666 11.1669 15.6666H2.83362C2.6126 15.6666 2.40064 15.5788 2.24436 15.4225C2.08808 15.2663 2.00028 15.0543 2.00028 14.8333V12.3333C2.00028 12.1123 1.91249 11.9003 1.75621 11.744C1.59993 11.5878 1.38797 11.5 1.16695 11.5C0.945938 11.5 0.733976 11.5878 0.577696 11.744C0.421416 11.9003 0.333618 12.1123 0.333618 12.3333V14.8333C0.333618 15.4963 0.59701 16.1322 1.06585 16.6011C1.53469 17.0699 2.17058 17.3333 2.83362 17.3333H11.1669C11.83 17.3333 12.4659 17.0699 12.9347 16.6011C13.4036 16.1322 13.6669 15.4963 13.6669 14.8333V3.16663C13.6669 2.50358 13.4036 1.8677 12.9347 1.39886C12.4659 0.930018 11.83 0.666626 11.1669 0.666626Z" fill="currentColor"></path>                  
                                            </svg>                
                                        </span>                
                                        <span class="small">Log Out</span>              
                                    </a>            
                                </li>          
                            </ul>        
                        </div>      
                    </div>    
                </div>  
            </div>  
            <div class="mx-auto ms-lg-80">    
                <section class="py-8">      
                    <div class="container">        
                        <div class="bg-white rounded shadow">          
                            <div class="px-6 pt-6 border-bottom border-secondary-light">                                
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px;"> -->
                                    <!-- Refresh Button (Aligned to Left) -->
                                    <!-- <button onclick="location.reload();" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                        Refresh
                                    </button> -->

                                    <!-- Title (Aligned to Center) -->
                                    <!-- <div style="text-align: center; flex-grow: 1;">
                                        <h3 style="margin: 0;">NADICOM DIGITAL SDN BHD</h3>
                                        <h4 style="margin: 0; font-size: 25px;">EXPIRED SUPPORT SYSTEM</h4>
                                    </div>
                                </div>           
                                <div>
                                    <a class="link-primary small px-3 pb-2 text-decoration-none border-bottom border-2 border-primary" href="#">Companies</a>
                                </div>          
                            </div>                                     
                            <div class="pt-4 table-responsive">            
                                <table border="1" class="table mb-0 table-borderless table-striped small">              
                                    <thead>                                                   
                                        <tr>
                                            <th class="py-4 px-2">                    
                                                <a class="btn text-secondary p-0 d-inline-flex align-items-center" href="#">                      
                                                    <span class="me-2">No.</span>                      
                                                    <span>                        
                                                        <svg width="9" height="12" viewbox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">                          
                                                            <path d="M7.85957 7.52667L4.99957 10.3933L2.13957 7.52667C2.01403 7.40114 1.84377 7.33061 1.66623 7.33061C1.4887 7.33061 1.31843 7.40114 1.1929 7.52667C1.06736 7.65221 0.996837 7.82247 0.996837 8.00001C0.996837 8.17754 1.06736 8.3478 1.1929 8.47334L4.52623 11.8067C4.65114 11.9308 4.82011 12.0005 4.99623 12.0005C5.17236 12.0005 5.34132 11.9308 5.46623 11.8067L8.79957 8.47334C8.86173 8.41118 8.91103 8.33739 8.94467 8.25617C8.97831 8.17496 8.99563 8.08791 8.99563 8.00001C8.99563 7.9121 8.97831 7.82505 8.94467 7.74384C8.91103 7.66262 8.86173 7.58883 8.79957 7.52667C8.73741 7.46451 8.66361 7.41521 8.5824 7.38157C8.50118 7.34793 8.41414 7.33061 8.32623 7.33061C8.23833 7.33061 8.15128 7.34793 8.07007 7.38157C7.98885 7.41521 7.91506 7.46451 7.8529 7.52667H7.85957ZM2.13957 4.47334L4.99957 1.60667L7.85957 4.47334C7.98447 4.59751 8.15344 4.6672 8.32957 4.6672C8.50569 4.6672 8.67466 4.59751 8.79957 4.47334C8.92373 4.34843 8.99343 4.17946 8.99343 4.00334C8.99343 3.82722 8.92373 3.65825 8.79957 3.53334L5.46623 0.200006C5.40426 0.137521 5.33052 0.0879247 5.24928 0.0540789C5.16804 0.0202331 5.08091 0.00280762 4.9929 0.00280762C4.90489 0.00280762 4.81775 0.0202331 4.73651 0.0540789C4.65527 0.0879247 4.58154 0.137521 4.51957 0.200006L1.18623 3.53334C1.06158 3.65976 0.992254 3.83052 0.993504 4.00805C0.994754 4.18559 1.06648 4.35535 1.1929 4.48001C1.31932 4.60466 1.49008 4.67398 1.66761 4.67273C1.84515 4.67148 2.01491 4.59976 2.13957 4.47334Z" fill="#67798E"></path>                        
                                                        </svg>                      
                                                    </span>                    
                                                </a>                  
                                            </th>              
                                            <th class="py-4 px-2">                    
                                                <a class="btn text-secondary p-0 d-inline-flex align-items-center" href="#">                      
                                                    <span class="me-2">Dockey</span>                      
                                                    <span>                        
                                                        <svg width="9" height="12" viewbox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">                          
                                                            <path d="M7.85957 7.52667L4.99957 10.3933L2.13957 7.52667C2.01403 7.40114 1.84377 7.33061 1.66623 7.33061C1.4887 7.33061 1.31843 7.40114 1.1929 7.52667C1.06736 7.65221 0.996837 7.82247 0.996837 8.00001C0.996837 8.17754 1.06736 8.3478 1.1929 8.47334L4.52623 11.8067C4.65114 11.9308 4.82011 12.0005 4.99623 12.0005C5.17236 12.0005 5.34132 11.9308 5.46623 11.8067L8.79957 8.47334C8.86173 8.41118 8.91103 8.33739 8.94467 8.25617C8.97831 8.17496 8.99563 8.08791 8.99563 8.00001C8.99563 7.9121 8.97831 7.82505 8.94467 7.74384C8.91103 7.66262 8.86173 7.58883 8.79957 7.52667C8.73741 7.46451 8.66361 7.41521 8.5824 7.38157C8.50118 7.34793 8.41414 7.33061 8.32623 7.33061C8.23833 7.33061 8.15128 7.34793 8.07007 7.38157C7.98885 7.41521 7.91506 7.46451 7.8529 7.52667H7.85957ZM2.13957 4.47334L4.99957 1.60667L7.85957 4.47334C7.98447 4.59751 8.15344 4.6672 8.32957 4.6672C8.50569 4.6672 8.67466 4.59751 8.79957 4.47334C8.92373 4.34843 8.99343 4.17946 8.99343 4.00334C8.99343 3.82722 8.92373 3.65825 8.79957 3.53334L5.46623 0.200006C5.40426 0.137521 5.33052 0.0879247 5.24928 0.0540789C5.16804 0.0202331 5.08091 0.00280762 4.9929 0.00280762C4.90489 0.00280762 4.81775 0.0202331 4.73651 0.0540789C4.65527 0.0879247 4.58154 0.137521 4.51957 0.200006L1.18623 3.53334C1.06158 3.65976 0.992254 3.83052 0.993504 4.00805C0.994754 4.18559 1.06648 4.35535 1.1929 4.48001C1.31932 4.60466 1.49008 4.67398 1.66761 4.67273C1.84515 4.67148 2.01491 4.59976 2.13957 4.47334Z" fill="#67798E"></path>                        
                                                        </svg>                      
                                                    </span>                    
                                                </a>                  
                                            </th>
                                            <th class="py-4 px-6">                    
                                                <a class="btn text-secondary p-0 d-inline-flex align-items-center" href="#">                      
                                                    <span class="me-2">Bill Date</span>                      <span>                        
                                                        <svg width="9" height="12" viewbox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">                          
                                                            <path d="M7.85957 7.52667L4.99957 10.3933L2.13957 7.52667C2.01403 7.40114 1.84377 7.33061 1.66623 7.33061C1.4887 7.33061 1.31843 7.40114 1.1929 7.52667C1.06736 7.65221 0.996837 7.82247 0.996837 8.00001C0.996837 8.17754 1.06736 8.3478 1.1929 8.47334L4.52623 11.8067C4.65114 11.9308 4.82011 12.0005 4.99623 12.0005C5.17236 12.0005 5.34132 11.9308 5.46623 11.8067L8.79957 8.47334C8.86173 8.41118 8.91103 8.33739 8.94467 8.25617C8.97831 8.17496 8.99563 8.08791 8.99563 8.00001C8.99563 7.9121 8.97831 7.82505 8.94467 7.74384C8.91103 7.66262 8.86173 7.58883 8.79957 7.52667C8.73741 7.46451 8.66361 7.41521 8.5824 7.38157C8.50118 7.34793 8.41414 7.33061 8.32623 7.33061C8.23833 7.33061 8.15128 7.34793 8.07007 7.38157C7.98885 7.41521 7.91506 7.46451 7.8529 7.52667H7.85957ZM2.13957 4.47334L4.99957 1.60667L7.85957 4.47334C7.98447 4.59751 8.15344 4.6672 8.32957 4.6672C8.50569 4.6672 8.67466 4.59751 8.79957 4.47334C8.92373 4.34843 8.99343 4.17946 8.99343 4.00334C8.99343 3.82722 8.92373 3.65825 8.79957 3.53334L5.46623 0.200006C5.40426 0.137521 5.33052 0.0879247 5.24928 0.0540789C5.16804 0.0202331 5.08091 0.00280762 4.9929 0.00280762C4.90489 0.00280762 4.81775 0.0202331 4.73651 0.0540789C4.65527 0.0879247 4.58154 0.137521 4.51957 0.200006L1.18623 3.53334C1.06158 3.65976 0.992254 3.83052 0.993504 4.00805C0.994754 4.18559 1.06648 4.35535 1.1929 4.48001C1.31932 4.60466 1.49008 4.67398 1.66761 4.67273C1.84515 4.67148 2.01491 4.59976 2.13957 4.47334Z" fill="#67798E"></path>                        
                                                        </svg>                      
                                                    </span>                    
                                                </a>                  
                                            </th>                  
                                            <th class="py-4 px-6">                    
                                                <div class="form-check mb-0 d-flex align-items-center">                      
                                                    <a class="btn text-secondary p-0 d-inline-flex align-items-center">                        
                                                        <span class="me-2 mb-n1">Company Name</span>                        <span>                          
                                                            <svg width="9" height="12" viewbox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">                            
                                                                <path d="M7.85957 7.52667L4.99957 10.3933L2.13957 7.52667C2.01403 7.40114 1.84377 7.33061 1.66623 7.33061C1.4887 7.33061 1.31843 7.40114 1.1929 7.52667C1.06736 7.65221 0.996837 7.82247 0.996837 8.00001C0.996837 8.17754 1.06736 8.3478 1.1929 8.47334L4.52623 11.8067C4.65114 11.9308 4.82011 12.0005 4.99623 12.0005C5.17236 12.0005 5.34132 11.9308 5.46623 11.8067L8.79957 8.47334C8.86173 8.41118 8.91103 8.33739 8.94467 8.25617C8.97831 8.17496 8.99563 8.08791 8.99563 8.00001C8.99563 7.9121 8.97831 7.82505 8.94467 7.74384C8.91103 7.66262 8.86173 7.58883 8.79957 7.52667C8.73741 7.46451 8.66361 7.41521 8.5824 7.38157C8.50118 7.34793 8.41414 7.33061 8.32623 7.33061C8.23833 7.33061 8.15128 7.34793 8.07007 7.38157C7.98885 7.41521 7.91506 7.46451 7.8529 7.52667H7.85957ZM2.13957 4.47334L4.99957 1.60667L7.85957 4.47334C7.98447 4.59751 8.15344 4.6672 8.32957 4.6672C8.50569 4.6672 8.67466 4.59751 8.79957 4.47334C8.92373 4.34843 8.99343 4.17946 8.99343 4.00334C8.99343 3.82722 8.92373 3.65825 8.79957 3.53334L5.46623 0.200006C5.40426 0.137521 5.33052 0.0879247 5.24928 0.0540789C5.16804 0.0202331 5.08091 0.00280762 4.9929 0.00280762C4.90489 0.00280762 4.81775 0.0202331 4.73651 0.0540789C4.65527 0.0879247 4.58154 0.137521 4.51957 0.200006L1.18623 3.53334C1.06158 3.65976 0.992254 3.83052 0.993504 4.00805C0.994754 4.18559 1.06648 4.35535 1.1929 4.48001C1.31932 4.60466 1.49008 4.67398 1.66761 4.67273C1.84515 4.67148 2.01491 4.59976 2.13957 4.47334Z" fill="#67798E"></path>                          
                                                            </svg>                        
                                                        </span>                      
                                                    </a>                    
                                                </div>                  
                                            </th>                  
                                            <th class="py-4 px-6">                    
                                                <a class="btn text-secondary p-0 d-inline-flex align-items-center" href="#">                      
                                                    <span class="me-2">Service</span>                      
                                                    <span>                        
                                                        <svg width="9" height="12" viewbox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">                          
                                                            <path d="M7.85957 7.52667L4.99957 10.3933L2.13957 7.52667C2.01403 7.40114 1.84377 7.33061 1.66623 7.33061C1.4887 7.33061 1.31843 7.40114 1.1929 7.52667C1.06736 7.65221 0.996837 7.82247 0.996837 8.00001C0.996837 8.17754 1.06736 8.3478 1.1929 8.47334L4.52623 11.8067C4.65114 11.9308 4.82011 12.0005 4.99623 12.0005C5.17236 12.0005 5.34132 11.9308 5.46623 11.8067L8.79957 8.47334C8.86173 8.41118 8.91103 8.33739 8.94467 8.25617C8.97831 8.17496 8.99563 8.08791 8.99563 8.00001C8.99563 7.9121 8.97831 7.82505 8.94467 7.74384C8.91103 7.66262 8.86173 7.58883 8.79957 7.52667C8.73741 7.46451 8.66361 7.41521 8.5824 7.38157C8.50118 7.34793 8.41414 7.33061 8.32623 7.33061C8.23833 7.33061 8.15128 7.34793 8.07007 7.38157C7.98885 7.41521 7.91506 7.46451 7.8529 7.52667H7.85957ZM2.13957 4.47334L4.99957 1.60667L7.85957 4.47334C7.98447 4.59751 8.15344 4.6672 8.32957 4.6672C8.50569 4.6672 8.67466 4.59751 8.79957 4.47334C8.92373 4.34843 8.99343 4.17946 8.99343 4.00334C8.99343 3.82722 8.92373 3.65825 8.79957 3.53334L5.46623 0.200006C5.40426 0.137521 5.33052 0.0879247 5.24928 0.0540789C5.16804 0.0202331 5.08091 0.00280762 4.9929 0.00280762C4.90489 0.00280762 4.81775 0.0202331 4.73651 0.0540789C4.65527 0.0879247 4.58154 0.137521 4.51957 0.200006L1.18623 3.53334C1.06158 3.65976 0.992254 3.83052 0.993504 4.00805C0.994754 4.18559 1.06648 4.35535 1.1929 4.48001C1.31932 4.60466 1.49008 4.67398 1.66761 4.67273C1.84515 4.67148 2.01491 4.59976 2.13957 4.47334Z" fill="#67798E"></path>                        
                                                        </svg>                      
                                                    </span>                    
                                                </a>                  
                                            </th>                                                                               
                                            <th class="py-4 px-6">                    
                                                <a class="btn text-secondary p-0 d-inline-flex align-items-center" href="#">                      
                                                    <span class="me-2">Expired Date</span>                      
                                                    <span>                        
                                                        <svg width="9" height="12" viewbox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">                          
                                                            <path d="M7.85957 7.52667L4.99957 10.3933L2.13957 7.52667C2.01403 7.40114 1.84377 7.33061 1.66623 7.33061C1.4887 7.33061 1.31843 7.40114 1.1929 7.52667C1.06736 7.65221 0.996837 7.82247 0.996837 8.00001C0.996837 8.17754 1.06736 8.3478 1.1929 8.47334L4.52623 11.8067C4.65114 11.9308 4.82011 12.0005 4.99623 12.0005C5.17236 12.0005 5.34132 11.9308 5.46623 11.8067L8.79957 8.47334C8.86173 8.41118 8.91103 8.33739 8.94467 8.25617C8.97831 8.17496 8.99563 8.08791 8.99563 8.00001C8.99563 7.9121 8.97831 7.82505 8.94467 7.74384C8.91103 7.66262 8.86173 7.58883 8.79957 7.52667C8.73741 7.46451 8.66361 7.41521 8.5824 7.38157C8.50118 7.34793 8.41414 7.33061 8.32623 7.33061C8.23833 7.33061 8.15128 7.34793 8.07007 7.38157C7.98885 7.41521 7.91506 7.46451 7.8529 7.52667H7.85957ZM2.13957 4.47334L4.99957 1.60667L7.85957 4.47334C7.98447 4.59751 8.15344 4.6672 8.32957 4.6672C8.50569 4.6672 8.67466 4.59751 8.79957 4.47334C8.92373 4.34843 8.99343 4.17946 8.99343 4.00334C8.99343 3.82722 8.92373 3.65825 8.79957 3.53334L5.46623 0.200006C5.40426 0.137521 5.33052 0.0879247 5.24928 0.0540789C5.16804 0.0202331 5.08091 0.00280762 4.9929 0.00280762C4.90489 0.00280762 4.81775 0.0202331 4.73651 0.0540789C4.65527 0.0879247 4.58154 0.137521 4.51957 0.200006L1.18623 3.53334C1.06158 3.65976 0.992254 3.83052 0.993504 4.00805C0.994754 4.18559 1.06648 4.35535 1.1929 4.48001C1.31932 4.60466 1.49008 4.67398 1.66761 4.67273C1.84515 4.67148 2.01491 4.59976 2.13957 4.47334Z" fill="#67798E"></path>                        
                                                        </svg>                      
                                                    </span>                    
                                                </a>                  
                                            </th>                  
                                            <th class="py-4 px-6">                    
                                                <a class="btn text-secondary p-0 d-inline-flex align-items-center" href="#">                      
                                                    <span class="me-2">Day Left</span>                      
                                                    <span>                        
                                                        <svg width="9" height="12" viewbox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">                          
                                                            <path d="M7.85957 7.52667L4.99957 10.3933L2.13957 7.52667C2.01403 7.40114 1.84377 7.33061 1.66623 7.33061C1.4887 7.33061 1.31843 7.40114 1.1929 7.52667C1.06736 7.65221 0.996837 7.82247 0.996837 8.00001C0.996837 8.17754 1.06736 8.3478 1.1929 8.47334L4.52623 11.8067C4.65114 11.9308 4.82011 12.0005 4.99623 12.0005C5.17236 12.0005 5.34132 11.9308 5.46623 11.8067L8.79957 8.47334C8.86173 8.41118 8.91103 8.33739 8.94467 8.25617C8.97831 8.17496 8.99563 8.08791 8.99563 8.00001C8.99563 7.9121 8.97831 7.82505 8.94467 7.74384C8.91103 7.66262 8.86173 7.58883 8.79957 7.52667C8.73741 7.46451 8.66361 7.41521 8.5824 7.38157C8.50118 7.34793 8.41414 7.33061 8.32623 7.33061C8.23833 7.33061 8.15128 7.34793 8.07007 7.38157C7.98885 7.41521 7.91506 7.46451 7.8529 7.52667H7.85957ZM2.13957 4.47334L4.99957 1.60667L7.85957 4.47334C7.98447 4.59751 8.15344 4.6672 8.32957 4.6672C8.50569 4.6672 8.67466 4.59751 8.79957 4.47334C8.92373 4.34843 8.99343 4.17946 8.99343 4.00334C8.99343 3.82722 8.92373 3.65825 8.79957 3.53334L5.46623 0.200006C5.40426 0.137521 5.33052 0.0879247 5.24928 0.0540789C5.16804 0.0202331 5.08091 0.00280762 4.9929 0.00280762C4.90489 0.00280762 4.81775 0.0202331 4.73651 0.0540789C4.65527 0.0879247 4.58154 0.137521 4.51957 0.200006L1.18623 3.53334C1.06158 3.65976 0.992254 3.83052 0.993504 4.00805C0.994754 4.18559 1.06648 4.35535 1.1929 4.48001C1.31932 4.60466 1.49008 4.67398 1.66761 4.67273C1.84515 4.67148 2.01491 4.59976 2.13957 4.47334Z" fill="#67798E"></path>                        
                                                        </svg>
                                                    </span>                    
                                                </a>                  
                                            </th>                  
                                            <th class="py-4 px-6">                    
                                                <a class="btn text-secondary p-0 d-inline-flex align-items-center" href="#">                      
                                                    <span class="me-2">Status</span>
                                                    <span>                        
                                                        <svg width="9" height="12" viewbox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">                          
                                                            <path d="M7.85957 7.52667L4.99957 10.3933L2.13957 7.52667C2.01403 7.40114 1.84377 7.33061 1.66623 7.33061C1.4887 7.33061 1.31843 7.40114 1.1929 7.52667C1.06736 7.65221 0.996837 7.82247 0.996837 8.00001C0.996837 8.17754 1.06736 8.3478 1.1929 8.47334L4.52623 11.8067C4.65114 11.9308 4.82011 12.0005 4.99623 12.0005C5.17236 12.0005 5.34132 11.9308 5.46623 11.8067L8.79957 8.47334C8.86173 8.41118 8.91103 8.33739 8.94467 8.25617C8.97831 8.17496 8.99563 8.08791 8.99563 8.00001C8.99563 7.9121 8.97831 7.82505 8.94467 7.74384C8.91103 7.66262 8.86173 7.58883 8.79957 7.52667C8.73741 7.46451 8.66361 7.41521 8.5824 7.38157C8.50118 7.34793 8.41414 7.33061 8.32623 7.33061C8.23833 7.33061 8.15128 7.34793 8.07007 7.38157C7.98885 7.41521 7.91506 7.46451 7.8529 7.52667H7.85957ZM2.13957 4.47334L4.99957 1.60667L7.85957 4.47334C7.98447 4.59751 8.15344 4.6672 8.32957 4.6672C8.50569 4.6672 8.67466 4.59751 8.79957 4.47334C8.92373 4.34843 8.99343 4.17946 8.99343 4.00334C8.99343 3.82722 8.92373 3.65825 8.79957 3.53334L5.46623 0.200006C5.40426 0.137521 5.33052 0.0879247 5.24928 0.0540789C5.16804 0.0202331 5.08091 0.00280762 4.9929 0.00280762C4.90489 0.00280762 4.81775 0.0202331 4.73651 0.0540789C4.65527 0.0879247 4.58154 0.137521 4.51957 0.200006L1.18623 3.53334C1.06158 3.65976 0.992254 3.83052 0.993504 4.00805C0.994754 4.18559 1.06648 4.35535 1.1929 4.48001C1.31932 4.60466 1.49008 4.67398 1.66761 4.67273C1.84515 4.67148 2.01491 4.59976 2.13957 4.47334Z" fill="#67798E"></path>                        
                                                        </svg>
                                                    </span>                    
                                                </a>                  
                                            </th>               
                                            <th class="py-4 px-6">                    
                                                <a class="btn text-secondary p-0 d-inline-flex align-items-center" href="#">                      
                                                    <span class="me-2">Actions</span>                      
                                                </a>                  
                                            </th>                
                                        </tr>                                             
                                    </thead>               -->
                            
                                    <!-- <tbody>                                                       
                                        <?php
                                            $row_number = 1;
                                            foreach ($combined as $company): ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $row_number++; ?></td> 
                                                <td style="text-align: center;"><?php echo $company->DOCKEY; ?></td> 
                                                <td style="text-align: center;">
                                                    <?= ($date = DateTime::createFromFormat('Y-m-d', $company->DOCDATE)) ? $date->format('d-m-Y') : 'N/A'; ?>
                                                </td>
                                                <td><?php echo $company->COMPANYNAME; ?></td>
                                                <td><?php echo $company->DESCRIPTION; ?></td>                                        
                                                <td style="text-align: center;">
                                                    <?= ($date = DateTime::createFromFormat('Y-m-d', $company->DOCNOEX)) ? $date->format('d-m-Y') : 'N/A'; ?>
                                                </td>
                                                <td style="text-align: center;"><?php echo $company->day_left; ?></td>
                                                <td style="text-align: center;"><?php echo $company->status; ?></td>
                                                <td style="white-space: nowrap;"></td> -->
                                                <!-- <td style="white-space: nowrap;">
                                                    <a href="<?php echo base_url('Control_comp/edit1/'.$company->DOCKEY)?>" 
                                                    class="btn-edit" style="font-size:13px; float: left; width: 45%; padding: 8px 0; background-color: #4CAF50; color: white; 
                                                    text-align: center; text-decoration: none; border-radius: 4px 4px 4px 4px; margin: 1px;">Edit</a>
                                                    <a href="<?php echo base_url('Control_comp/delete/'.$company->DOCKEY)?>" 
                                                    class="btn-delete" onclick="return confirm('Are you sure you want to delete this record?');" 
                                                    style="font-size:13px; float: left; width: 45%; padding: 8px 0; background-color: #f44336; color: white; text-align: center; 
                                                    text-decoration: none; border-radius: 4px 4px 4px 4px;  margin: 1px;">Delete</a>
                                                </td> -->
                                            <!-- </tr>
                                        <?php endforeach; ?>
                                    </tbody>            
                                </table>
                                
                                
                            </div>        
                        </div>      
                    </div>    
                </section>  
            </div>
        </section>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="<?= base_url('assets/js/charts-demo.js') ?>"></script>
    <script src="<?= base_url('assets/js/sortTable.js') ?>"></script>
    <script>
        $(document).ready(function () {
            $('#companiesTable').DataTable({
                processing: true, 
                serverSide: true, 
                ajax: {
                    url: "<?= base_url('Control_comp/get_companies') ?>", 
                    type: "POST",
                },
                columns: [
                    { data: 'DOCKEY' },        
                    { data: 'COMPANYNAME' },
                    { data: 'DESCRIPTION' },
                    { data: 'DOCDATE' },
                    { data: 'DOCNOEX' },
                    { data: 'day_left' },
                    { data: 'status' },
                ],
            });
        });
    </script>                                            


</body>

</html> -->
