<?php
include_once '../../Config/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $product_name = $_POST['productName'];
    $product_price = $_POST['productPrice'];
    $product_description = $_POST['productDescription'];

    $response = [];

    try {
        $query = "UPDATE Product SET productName = :productName, productPrice = :productPrice, productDescription = :productDescription WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':productName', $product_name);
        $stmt->bindParam(':productPrice', $product_price);
        $stmt->bindParam(':productDescription', $product_description);
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

