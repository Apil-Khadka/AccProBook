<?php
include_once '../../Config/config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Validation/signIn.html');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $company_id = $_POST['company_id'];
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
        $query = "UPDATE Company SET companyName = :companyName, companyAddress = :companyAddress, contactName = :contactName, companyEmail = :companyEmail, phoneNumber = :phoneNumber, landLineNumber = :landLineNumber, state = :state, country = :country, URL = :URL WHERE user_id = :user_id AND company_id = :company_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':company_id', $company_id);
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
                "message" => "Failed to Update Company Info"
            ];
        }
    } catch (PDOException $e) {
        $response = [
            "success" => false,
            "message" => "Failed to Update Company Info"
        ];
        echo "Error: " . $e->getMessage();
    }
    echo json_encode($response);
}


