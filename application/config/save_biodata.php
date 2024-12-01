<?php
 
if (isset($_POST['expired_system'])) {
 
    $servername = "";
    $username = "root";
    $password = "";
    $dbname = "expired_system";
  // Connection variables
 
  try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
      $stmt = $conn->prepare("INSERT INTO expired_table(no,  company_name, service,
      strt_date, exp_date, day_left, description) VALUES (:no, : :company_name, :service,
      :strt_date, :exp_date, :day_left, :description)");
      // Prepare the SQL statement
       
      $stmt->bindParam(':no', $no, PDO::PARAM_INT);
      $stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);
      $stmt->bindParam(':service', $service, PDO::PARAM_STR);
      $stmt->bindParam(':strt_date', $strt_date, PDO::PARAM_STR);
      $stmt->bindParam(':exp_date', $exp_date, PDO::PARAM_STR);
      $stmt->bindParam(':day_left', $day_left, PDO::PARAM_INT);
      $stmt->bindParam(':description', $description, PDO::PARAM_STR);
      // Bind the parameters
       
      $no = $_POST['no'];
      $company_name = $_POST['company_name'];
      $service = $_POST['service'];
      $strt_date = $_POST['strt_date'];
      $exp_date = $_POST['exp_date'];
      $day_left = $_POST['day_left'];
      $description = $_POST['description'];
      // insert a row
       
      $stmt->execute();
     
      echo "New records created successfully";
      }
 
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
 
    $conn = null;
  }
 
 ?>