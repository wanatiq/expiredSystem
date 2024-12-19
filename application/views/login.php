<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/artemis-assets/images/shuffle-for-bootstrap.png">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


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
        .login-container {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.3), /* Main deep shadow */
                        0px 4px 6px rgba(0, 0, 0, 0.2);  /* Secondary subtle shadow */
            width: 100%;
            max-width: 400px;
            text-align: center;
            transition: box-shadow 0.3s ease-in-out; /* Smooth transition for hover effect */
        }
        .login-container:hover {
            box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.4), /* Slightly deeper on hover */
                        0px 6px 8px rgba(0, 0, 0, 0.3);
            transform: translateY(-px); /* Adds a slight "lift" effect */
        }
        .image-header {
            margin-bottom: 1.5rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem; /* Add spacing between fields */
        }

        .form-group i {
            position: absolute;
            left: 15px; 
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            color: #000; 
        }

        .form-control {
            width: 100%; /* Ensure the input fills the container */
            border-radius: 8px;
            border: 1px solid #dee2e6;
            font-size: 1rem;
            padding: 0.6rem 0.6rem 0.6rem 2.5rem;
            box-sizing: border-box;
            height: 40px;
        }

        .form-control:focus {
            border-color: #00c851; /* Highlight input on focus */
            outline: none; /* Remove shadow */
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

        .powered-by {
            font-family: 'Arial', sans-serif;
            font-size: 0.6rem;
            color: #003366; /* Navy blue text for consistency */
            font-weight: bold;
            text-align: center;
        }

        .powered-by span {
            color: #ff7b00; /* Highlight 'Nadicom Digital' in orange */
        }

        .login-footer a {
            color:rgb(4, 32, 62);
            text-decoration: none;
            font-size: 1.1rem;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }


    </style>
</head>
<body>
    <div class="login-container">

        <div class="image-header">
            <img src="<?= base_url('assets/artemis-assets/logos/NDSB-removebg-preview.png') ?>" alt="nadicom.jpg" width="75%" height="75%">
        </div>

        <!-- Header -->
        <div class="login-header">
            
        </div>

        <!-- Manual Login Form -->
        <form method="post" action="<?php echo site_url('login/authenticate'); ?>">
            <!-- Username -->
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" id="USERNAME" name="USERNAME" class="form-control" placeholder="Username" required>
            </div>
            <!-- Password -->
            <div class="form-group">
                <i class="fas fa-key"></i>
                <input type="password" id="PASSWORD" name="PASSWORD" class="form-control" placeholder="Password" required>
            </div>
            <!-- Login Button -->
            <button type="submit" class="btn-primary">Login</button>
        </form>


        <!-- Footer Links -->
        <div class="login-footer">
            <p>
                <a href="<?= site_url('login/forgot_password') ?>">
                    <i class="fas fa-unlock-alt"></i> Forgot your password?
                </a>
            </p>
            <br>
        </div>
        <div class="powered-by mt-4">
            Powered by <span>Nadicom Digital Sdn Bhd</span>
            <!-- <p>
                <a href="<?= site_url('createuser') ?>">
                    <i class="fas fa-user-alt"></i> Create new user
                </a>
            </p> -->
            <!-- Optional: Admin-only action link -->
            <!-- <p class="text-center">
                <a href="<?= site_url('login/alter_database') ?>" class="btn btn-danger">
                    <i class="fas fa-database"></i> Alter Database
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
