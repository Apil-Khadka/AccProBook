<?php
include_once '../../Config/config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Validation/signIn.html');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $productName = $_POST['Name'];
    $productPrice = $_POST['Price'];
    $productDescription = $_POST['Description'];

    $response = [];

    try {
        $query = "INSERT INTO Product(user_id,productName,productPrice,productDescription) VALUES (:user_id,:productName,:productPrice,:productDescription)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':productPrice', $productPrice);
        $stmt->bindParam(':productDescription', $productDescription);
        if ($stmt->execute()) {
            $response = [
                "success" => true,
                "message" => "Product Info Updated Successfully"
            ];
        } else {
            $response = [
                "success" => false,
                "message" => "Failed to Update Product Info"
            ];
        }
    } catch (PDOException $e) {
        $response = [
            "success" => false,
            "message" => "Failed to Update Product Info"
        ];
        echo "Error: " . $e->getMessage();
    }
    echo json_encode($response);
}

