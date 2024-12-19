<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/artemis-assets/images/shuffle-for-bootstrap.png">

    <!-- Custom CSS -->
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1449157291145-7efd050a4d0e?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8ZmluYW5jaWFsJTIwZGlzdHJpY3R8ZW58MHx8MHx8fDA%3D');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
        }

        .forgot-password-container {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            padding: 2.5rem; /* Slightly reduced padding */
            border-radius: 15px; /* Reduced border radius */
            box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.3), /* Main deep shadow */
                        0px 4px 6px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px; /* Reduced container width */
            text-align: center;
            transition: box-shadow 0.3s ease-in-out; /* Smooth transition for hover effect */
        }

        .forgot-password-container:hover{
            box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.4), /* Slightly deeper on hover */
                        0px 6px 8px rgba(0, 0, 0, 0.3);
            transform: translateY(-px); /* Adds a slight "lift" effect */
        }

        .forgot-password-header {
            text-align: center;
            color: #343a40;
        }

        .forgot-password-header h1 {
            font-size: 1.8rem; /* Reduced font size */
            font-weight: bold;
        }

        .form-group {
            position: relative;
            margin-bottom: 1rem; /* Add spacing between fields */
        }

        .form-group i {
            position: absolute;
            left: 15px; 
            top: 50%;
            transform: translateY(-100%);
            font-size: 1rem;
            color: #000; 
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            font-size: 1rem; /* Slightly smaller text size */
            padding: 0.6rem 0.6rem 0.6rem 2.5rem; 
            text-align: left; /* Align text and placeholder to the left */
            margin-bottom: 1rem; /* Slightly less spacing between inputs */
            width: 100%;
            box-sizing: border-box;
            height: 40px;
        }

        .form-control:focus {
            outline: none; /* Remove shadow */
            border-color: #00c851; /* Highlight the field with green when focused */
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            background-color: #003366; /* Deep navy blue */
            border: none;
            border-radius: 25px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff; /* White text for contrast */
            padding: 0.8rem 1.5rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-primary:hover {
            background-color: #ff7b00; /* Orange tone from logo */
            transform: translateY(-3px);
        }

        .alert {
            font-size: 1.1rem; /* Slightly smaller alert text */
            border-radius: 10px;
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
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" 
                    class="form-control <?= $this->session->flashdata('username_error') ? 'is-invalid' : '' ?>" 
                    id="USERNAME" 
                    name="USERNAME" 
                    placeholder="Username" 
                    required>
            </div>
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" 
                    class="form-control <?= $this->session->flashdata('email_error') ? 'is-invalid' : '' ?>" 
                    id="EMAIL" 
                    name="EMAIL" 
                    placeholder="Email">
            </div>
            <div class="form-group">
                <i class="fas fa-key"></i>
                <input type="password" 
                    class="form-control" 
                    id="PASSWORD" 
                    name="PASSWORD" 
                    placeholder="Password" 
                    required>
            </div>
            <div class="form-group">
                <i class="fas fa-key"></i>
                <input type="password" 
                    class="form-control" 
                    id="CONFIRM_PASSWORD" 
                    name="CONFIRM_PASSWORD" 
                    placeholder="Confirm password" required>
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
