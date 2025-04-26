<?php
include_once '../../Config/config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Validation/signIn.html');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $companyName = $_POST['companyName'];
    $companyAddress = $_POST['companyAddress'];
    $contactName = $_POST['contactName'];
    $companyEmail = $_POST['companyEmail'];
    $phoneNumber = $_POST['phoneNumber'];
    $landLineNumber = $_POST['landLineNumber'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $URL = $_POST['URL'];

    $response = [];

    try {
        $query = "INSERT INTO Company(user_id,companyName,companyAddress,contactName,companyEmail,phoneNumber,landLineNumber,state,country,URL) VALUES (:user_id,:companyName,:companyAddress,:contactName,:companyEmail,:phoneNumber,:landLineNumber,:state,:country,:URL) ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':companyName', $companyName);
        $stmt->bindParam(':companyAddress', $companyAddress);
        $stmt->bindParam(':contactName', $contactName);
        $stmt->bindParam(':companyEmail', $companyEmail);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':landLineNumber', $landLineNumber);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':URL', $URL);
        if ($stmt->execute()) {
            $response = [
                "success" => true,
                "message" => "Company Info Updated Successfully"
            ];
        } else {
            $response = [
                "success" => false,
                "message" => "Failed to Update Company Info during execution"
            ];
        }
    } catch (PDOException $e) {
        $response = [
            "success" => false,
            "message" => "Failed to Update Company Info" .$e->getMessage()
        ];
    }
    echo json_encode($response);
}


