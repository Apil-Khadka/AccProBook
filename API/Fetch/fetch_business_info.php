<?php
include_once '../../Config/config.php';
if(!isset($_SESSION['user_id'])){
    header('Location: ../Validation/signIn.html');
    exit();
}
try {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM BusinessInfo where user_id= :user_id ORDER BY business_id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $business = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        echo json_encode($business);
    }
} catch (PDOException $e) {
    echo json_encode([]);
}