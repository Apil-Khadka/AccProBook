<?php
include_once '../../Config/config.php';

try {
    $user_id = $_SESSION['user_id'];

    // Fetch Credit Data
    $creditQuery = "
        SELECT  
            Credit.*, 
            Customer.firstname AS customer_name,
            Company.companyName AS company_name
        FROM Credit
        LEFT JOIN Customer ON Credit.customer_id = Customer.customer_id
        LEFT JOIN Company ON Credit.company_id = Company.company_id
        WHERE Credit.user_id = :user_id
        ORDER BY Credit.customer_id DESC
    ";
    $creditStmt = $conn->prepare($creditQuery);
    $creditStmt->bindParam(':user_id', $user_id);
    $creditStmt->execute();
    $credits = $creditStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Debit Data
    $debitQuery = "
        SELECT 
            Debit.*, 
            Customer.firstname AS customer_name,
            Company.companyName AS company_name
        FROM Debit
        LEFT JOIN Customer ON Debit.customer_id = Customer.customer_id
        LEFT JOIN Company ON Debit.company_id = Company.company_id
        WHERE Debit.user_id = :user_id
        ORDER BY Debit.customer_id DESC
    ";
    $debitStmt = $conn->prepare($debitQuery);
    $debitStmt->bindParam(':user_id', $user_id);
    $debitStmt->execute();
    $debits = $debitStmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate Totals
    $totalCredit = 0;
    foreach ($credits as $credit) {
        $totalCredit += $credit['credit_Amount'];
    }

    $totalDebit = 0;
    foreach ($debits as $debit) {
        $totalDebit += $debit['debit_Amount'];
    }

    $netAmount = $totalCredit - $totalDebit;

    // Prepare Response
    $response = [
        'credits' => $credits,
        'debits' => $debits,
        'totalCredit' => $totalCredit,
        'totalDebit' => $totalDebit,
        'netAmount' => $netAmount
    ];
    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode([]);
}