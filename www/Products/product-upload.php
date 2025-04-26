<?php
include_once("../Config/config.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST['Name'];
    $Price = $_POST['Price'];
    $Description = $_POST['Description'];

    $user_id = $_SERVER['user_id'];

    $response = [];

    if (empty($Name) || empty($Price)) {
        $response = [
            'success' => false,
            'message' => "All fields are required"
        ];
    } else {
        try {
            $query = "INSERT INTO Product (user_id, productName, productPrice, productDescription) VALUES (:user_id,:Name, :Price, :Description)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':Name', $Name);
            $stmt->bindParam(':Price', $Price);
            $stmt->bindParam(':Description', $Description);

            if ($stmt->execute()) {
                $response = [
                    'success' => true,
                    'message' => "Product registered successfully"
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => "Error registering Product"
                ];
            }
        } catch (PDOException $e) {
            $response = [
                'success' => false,
                'message' => "Error: " . $e->getMessage()
            ];
        }
    }
    echo json_encode($response);
}