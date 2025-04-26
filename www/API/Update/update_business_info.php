<?php
include_once('../../Config/config.php');
use League\Flysystem\FilesystemException;

require '../../vendor/autoload.php';
require '../image_upload.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $business_id = $_POST['business_id'];
    $business_name = $_POST['business_name'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $website = $_POST['website'];
    $logo_path = $_POST['logo_path'];

    // Define upload directory
    $uploadDir = '/opt/lampp/htdocs/website/project/file_upload';

    $fileType = '';
    $response = [];

    if (isset($_FILES['logo_path_up']) && $_FILES['logo_path_up']['error'] == 0) {
        try {
            $fileType = uploadFile($_FILES['logo_path_up'], $uploadDir);
        } catch (FilesystemException $e) {
            $response = [
                "success" => false,
                "message" => "Failed to Upload Logo: " . $e->getMessage()
            ];
        } catch (Exception $e) {
            $response = [
                "success" => false,
                "message" => "Failed to Upload Logo: " . $e->getMessage()
            ];
        }
    } else {
        $response = [
            "success" => false,
            "message" => "Failed to Upload Logo"
        ];
    }

    if ($fileType) {
        $logo_path = $fileType;
    }

    try {
        $query = "UPDATE BusinessInfo SET business_name = :business_name, address = :address, contact_number = :contact_number, email = :email, website = :website, logo_path = :logo_path WHERE user_id = :user_id AND business_id = :business_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':business_id', $business_id, PDO::PARAM_INT);
        $stmt->bindParam(':business_name', $business_name, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':contact_number', $contact_number, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':website', $website, PDO::PARAM_STR);
        $stmt->bindParam(':logo_path', $logo_path, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $response = [
                "success" => true,
                "message" => "Info Updated Successfully"
                 //send reload to refresh page

            ];
        } else {
            $response = [
                "success" => false,
                "message" => "Failed to Update Info"
            ];
        }
    } catch (PDOException $e) {
        $response = [
            "success" => false,
            "message" => "Failed to Update Info: " . $e->getMessage()
        ];
    }

    echo json_encode($response);
}