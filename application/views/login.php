<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/artemis-assets/images/shuffle-for-bootstrap.png">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fc;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: #fff;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #343a40;
        }
        .login-header h1 {
            font-size: 2rem;
            font-weight: bold;
        }
        .login-header p {
            font-size: 1rem;
            color: #6c757d;
        }
        .form-control {
            border-radius: 25px;
            border: 1px solid #dee2e6;
            font-size: 1.1rem;
            padding: 0.8rem;
            text-align: center;
        }
        .form-control::placeholder{
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
        .google-login {
            background-color: #4285F4;
            border: none;
            border-radius: 25px;
            font-size: 1.3rem;
            padding: 0.6rem 1.2rem;
            color: #fff;
            margin-bottom: 2rem; /* Increased spacing below Google Login button */
        }
        .text-center.my-3{
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .google-login:hover {
            background-color: #357ae8;
        }
        .alert {
            font-size: 1rem;
            border-radius: 10px;
        }
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
        }
        .login-footer a {
            color: #007bff;
            text-decoration: none;
            font-size: 1.1rem;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }

        .alert-danger {
            font-size: 1.1rem;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="login-container">

        <!-- <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger" style="color:red">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?> -->

        <!-- Header -->
        <div class="login-header">
            <h1><i class="fas fa-user-circle"></i> Welcome Back!</h1>
            <p>Please log in to access your account</p>
        </div>

        <!-- Google Login Button -->
        <!-- <div class="d-grid mb-3">
            <a href="<?= base_url('login/google_auth') ?>" class="btn google-login">
                <i class="fab fa-google"></i> Sign in with Google
            </a>
        </div> -->

        <!-- Separator -->
        <!-- <div class="text-center my-3">
            <span>OR</span>
        </div> -->

        <!-- Manual Login Form -->
        <form method="post" action="<?php echo site_url('login/authenticate'); ?>">
            <div class="mb-4">
                <label for="USERNAME" class="form-label">Username</label>
                <input type="text" class="form-control" id="USERNAME" name="USERNAME" placeholder="Enter your username" required>
            </div>

            <div class="mb-4">
                <label for="PASSWORD" class="form-label">Password</label>
                <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" placeholder="Enter your password" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </div>
        </form>

        <!-- Footer Links -->
        <div class="login-footer">
            <p>
                <a href="<?= site_url('login/forgot_password') ?>">
                    <i class="fas fa-unlock-alt"></i> Forgot your password?
                </a>
            </p>
            <!-- <p>
                <a href="<?= site_url('createuser') ?>">
                    <i class="fas fa-user-alt"></i> Create new user
                </a>
            </p> -->
        </div>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
