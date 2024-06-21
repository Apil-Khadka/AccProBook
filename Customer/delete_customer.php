<?php
include_once("../Config/config.php");

if (isset($_GET['customer_id'])) {
    $id = htmlspecialchars($_GET['customer_id']);

    try {
        $query = "DELETE FROM Customer WHERE customer_id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: customer_list.php"); // Redirect back to the main page
        exit;
    } catch (PDOException $e) {
        echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}