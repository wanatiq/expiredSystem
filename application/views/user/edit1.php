<!-- <script>
    document.getElementById('DOCDATE').addEventListener('change', calculateDaysLeft);
    document.getElementById('DOCNOEX').addEventListener('change', calculateDaysLeft);
    
    function calculateDaysLeft(){
        const startDate = new Date(document.getElementById('DOCDATE').value);
        const expDate = new Date(document.getElementById('DOCNOEX').value);

        if (!isNaN(startDate) && !isNaN(expDate)){
            const diffTime = expDate - startDate;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            document.getElementById('day_left').value = diffDays >= 0 ? diffDays: 0;
        }else{
            document.getElementById('day_left').value = 0;
        }
    }
</script> -->





<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <title>Expired Support System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="  <?= base_url() ?>assets/artemis-assets/images/shuffle-for-bootstrap.png"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->
    <!-- <style>
        body {
            display: flex;            /* Use flexbox to center the content */
            justify-content: center;  /* Center horizontally */
            align-items: center;      /* Center vertically */
            min-height: 100vh;        /* Ensure full viewport height */
            margin: 0;
            background-color: #f5f5f5; /* Optional: Add a light background */
        }

        form {
            background-color: white;  /* Optional: Add a background to the form */
            padding: 20px;            /* Add padding around the form */
            border-radius: 8px;       /* Optional: Round corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: Add a shadow */
            width: 100%;              /* Responsive width */
            max-width: 400px;         /* Limit the width on larger screens */
        }

        label {
            display: block;           /* Ensure labels are on their own line */
            margin-bottom: 5px;       /* Space below labels */
        }

        input, textarea, button {
            width: 100%;              /* Full width for inputs and textarea */
            margin-bottom: 15px;      /* Space between inputs */
            padding: 10px;            /* Padding inside inputs */
            border: 1px solid #ccc;   /* Add a light border */
            border-radius: 4px;       /* Rounded corners */
            box-sizing: border-box;   /* Include padding in width calculation */
        }

        button {
            background-color: #4CAF50; /* Green background */
            color: white;              /* White text */
            border: none;              /* Remove border */
            cursor: pointer;           /* Pointer cursor on hover */
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <form action="<?php echo base_url('Control_comp/edit1/' . $company['DOCKEY']); ?>" method="post">
        <label for="COMPANYNAME">Company Name:</label>
        <input type="text" id="COMPANYNAME" name="COMPANYNAME" value="<?php echo $company['COMPANYNAME']; ?>" required>

        <br>

        <label for="DESCRIPTION">Service:</label>
        <input type="text" id="DESCRIPTION" name="DESCRIPTION" value="<?php echo $company['DESCRIPTION']; ?>" required>

        <br>

        <label for="DOCDATE">Start Date:</label>
        <input type="date" id="DOCDATE" name="DOCDATE" value="<?php echo $company['DOCDATE']; ?>">

        <br>

        <label for="DOCNOEX">Expire Date:</label>
        <input type="date" id="DOCNOEX" name="DOCNOEX" value="<?= 
            $company['DOCNOEX'] ? DateTime::createFromFormat('d/m/Y', $company['DOCNOEX'])->format('d-m-Y') : ''; 
        ?>">

        <br>

        <button type="submit">Save Changes</button>
    </form>
</body> -->

<!-- script to calculate Day Left dynamically if date change -->

