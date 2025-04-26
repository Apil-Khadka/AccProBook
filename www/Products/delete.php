<?php
include_once("../Config/config.php");

if (isset($_GET['ProductID'])) {
    $id = htmlspecialchars($_GET['product_id']);

    try {
        $query = "DELETE FROM Product WHERE product_id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: Product-list.php"); // Redirect back to the main page
        exit;
    } catch (PDOException $e) {
        echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}