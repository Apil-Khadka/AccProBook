<?php
include_once '../../Config/config.php';
try {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM Debit where user_id= :user_id ORDER BY customer_id DESC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $debit = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode([]);
}
