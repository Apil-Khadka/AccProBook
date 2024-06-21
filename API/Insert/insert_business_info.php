<?php
include_once('../../Config/config.php');

require '../../vendor/autoload.php';

use League\Flysystem\FilesystemException;

require '../image_upload.php';

if($_SERVER["REQUEST_METHOD"]=="POST") {
    $user_id = $_SESSION['user_id'];
    $business_name = $_POST['business_name'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $website = $_POST['website'];

    $uploadDir = '/opt/lampp/htdocs/website/project/file_upload';

    $fileType = '';
    $response = [];

    if (isset($_FILES['logo_path']) && $_FILES['logo_path']['error'] == 0) {
        try {
            $fileType = uploadFile($_FILES['logo_path'], $uploadDir);
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
    if($fileType) {
        $logo_path = $fileType;
    }
    try {
        $query ="INSERT INTO BusinessInfo(user_id,business_name,address,contact_number,email,website,logo_path) VALUES(:user_id,:business_name,:address,:contact_number,:email,:website,:logo_path)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':business_name', $business_name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':contact_number', $contact_number);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':website', $website);
        $stmt->bindParam(':logo_path', $logo_path);
        if($stmt->execute()){
            $response =[
                "success"=> true,
                "message" => "Info Updated Successfully"
            ];
        } else {
            $response =[
                "success" => false,
                "message" => "Failed to Update Info"
            ];
        }
    } catch (PDOException $e) {
        $response =[
            "success" => false,
            "message" => "Failed to Update Info"
        ];
        echo "Error: " . $e->getMessage();
    }
    echo json_encode($response);
}