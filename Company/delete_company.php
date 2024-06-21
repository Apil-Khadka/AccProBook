<?php
include_once("../Config/config.php");

if (isset($_GET['company_id'])) {
    $id = htmlspecialchars($_GET['company_id']);

    try {
        $query = "DELETE FROM Company WHERE company_id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: company_list.php"); // Redirect back to the main page
        exit;
    } catch (PDOException $e) {
        echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}