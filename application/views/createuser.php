<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/artemis-assets/images/shuffle-for-bootstrap.png">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fc; /* Soft light gray */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .create-user-container {
            background: #fff;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .create-user-header {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #343a40;
        }
        .create-user-header h1 {
            font-size: 2rem;
            font-weight: bold;
        }
        .form-control {
            border-radius: 25px;
            border: 1px solid #dee2e6;
            font-size: 1.1rem;
            padding: 0.8rem;
            text-align: center;
        }
        .form-control::placeholder {
            text-align: center;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #00c851;
        }
        .btn-primary {
            background-color: #00c851;
            border: none;
            border-radius: 25px;
            font-size: 1.3rem;
            padding: 0.6rem 1.2rem;
            margin-top: 1rem;
        }
        .btn-primary:hover {
            background-color: #007e33;
        }
    </style>
</head>
<body>
    <div class="create-user-container">
        <!-- Header -->
        <div class="create-user-header">
            <h1><i class="fas fa-user-plus"></i> Create New User</h1>
            <p>Fill in the details to create a new user</p>
        </div>

        <!-- Create User Form -->
        <form method="post" action="<?= site_url('createuser/store_user'); ?>">
            <div class="mb-4">
                <label for="USERNAME" class="form-label">Username</label>
                <input type="text" class="form-control" id="USERNAME" name="USERNAME" placeholder="Enter username" required>
            </div>

            <div class="mb-4">
                <label for="COMPANYNAME" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="COMPANYNAME" name="COMPANYNAME" placeholder="Enter company name" required>
            </div>

            <div class="mb-4">
                <label for="PASSWORD" class="form-label">Password</label>
                <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" placeholder="Enter password" required>
            </div>

            <div class="mb-4">
                <label for="EMAIL" class="form-label">Email</label>
                <input type="email" class="form-control" id="EMAIL" name="EMAIL" placeholder="Enter email">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Create User
                </button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
