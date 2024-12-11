<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
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

        .forgot-password-container {
            background: #fff;
            padding: 2.5rem; /* Slightly reduced padding */
            border-radius: 15px; /* Reduced border radius */
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Reduced container width */
            text-align: center;
        }

        .forgot-password-header {
            text-align: center;
            margin-bottom: 1.5rem; /* Reduced spacing below header */
            color: #343a40;
        }

        .forgot-password-header h1 {
            font-size: 1.8rem; /* Reduced font size */
            font-weight: bold;
        }

        .forgot-password-header p {
            font-size: 1rem; /* Slightly smaller subheading text */
            color: #6c757d;
        }

        .form-control {
            border-radius: 20px; /* Slightly less rounded input fields */
            border: 1px solid #dee2e6;
            font-size: 1.2rem; /* Slightly smaller text size */
            padding: 0.8rem; /* Reduced padding */
            text-align: left; /* Align text and placeholder to the left */
            margin-bottom: 1rem; /* Slightly less spacing between inputs */
            width: 100%;
        }

        .form-control::placeholder {
            text-align: left; /* Align the placeholder text to the left */
            color: #6c757d; /* Optional: Lighter placeholder color */
            font-size: 1.1rem; /* Slightly smaller placeholder text */
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #00c851; /* Highlight the field with green when focused */
        }

        .btn-primary {
            background-color: #00c851;
            border: none;
            border-radius: 20px;
            font-size: 1.2rem; /* Slightly smaller button text */
            padding: 0.6rem 1.2rem; /* Reduced button padding */
            margin-top: 1.5rem; /* Slightly reduced spacing above the button */
        }

        .btn-primary:hover {
            background-color: #007e33;
        }

        .alert {
            font-size: 1.1rem; /* Slightly smaller alert text */
            border-radius: 10px;
        }

        .form-label {
            font-size: 1.1rem; /* Reduced label size */
            font-weight: bold; /* Bold labels for better visibility */
            color: #343a40;
        }

        .is-invalid {
            border-color: red !important;
        }


    </style>
</head>
<body>
    <div class="forgot-password-container">
        <!-- Header -->
        <div class="forgot-password-header">
            <h1>Forgot Password</h1>
        </div>

        <!-- Forgot Password Form -->
        <form method="post" action="<?php echo site_url('login/forgot_password'); ?>">
            <div>
                <label for="USERNAME" class="form-label">Username</label>
                <input type="text" 
                    class="form-control <?= $this->session->flashdata('username_error') ? 'is-invalid' : '' ?>" 
                    id="USERNAME" 
                    name="USERNAME" 
                    placeholder="Enter your username" 
                    required>
            </div>
            <div>
                <label for="EMAIL" class="form-label">Email</label>
                <input type="email" 
                    class="form-control <?= $this->session->flashdata('email_error') ? 'is-invalid' : '' ?>" 
                    id="EMAIL" 
                    name="EMAIL" 
                    placeholder="Enter your email" 
                    required>
            </div>
            <div>
                <label for="PASSWORD" class="form-label">New Password</label>
                <input type="password" 
                    class="form-control" 
                    id="PASSWORD" 
                    name="PASSWORD" 
                    placeholder="Enter new password" 
                    required>
            </div>
            <div>
                <label for="CONFIRM_PASSWORD" class="form-label">Confirm Password</label>
                <input type="password" 
                    class="form-control" 
                    id="CONFIRM_PASSWORD" 
                    name="CONFIRM_PASSWORD" 
                    placeholder="Confirm new password" required>
            </div>
            
            <!-- Flashdata Error Message -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger mt-2" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    Reset Password
                </button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script>
        $(document).ready(function() {
            $(".form-control").on("input", function() {
                $(this).removeClass("is-invalid");
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
