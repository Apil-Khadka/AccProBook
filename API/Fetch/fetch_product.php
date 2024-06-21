<?php
include_once("../../Config/config.php");

try {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT product_id,productName,productPrice FROM Product where user_id= :user_id ORDER BY product_id DESC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        echo json_encode($product);
    }
} catch (PDOException $e) {
    echo json_encode([]);
}