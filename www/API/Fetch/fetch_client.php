<?php

include_once("../../Config/config.php");

$user_id = $_SESSION['user_id'];

try {
    $customerQuery = "Select customer_id as id, firstname as name,'Customer' as type from Customer where user_id=:user_id order by customer_id desc";
    $customerResult = $conn->prepare($customerQuery);
    $customerResult->bindParam(':user_id', $user_id);
    $customerResult->execute();

    $companyQuery = "Select company_id as id, companyName as name,'Company' as type from Company where user_id=:user_id order by company_id desc";
    $companyResult = $conn->prepare($companyQuery);
    $companyResult->bindParam(':user_id', $user_id);
    $companyResult->execute();

    $customer = $customerResult->fetchAll(PDO::FETCH_ASSOC);
    $company = $companyResult->fetchAll(PDO::FETCH_ASSOC);

    $client = array_merge($customer, $company);
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        echo json_encode($client);
    }
}catch (PDOException $e) {
    echo json_encode([]);
}

