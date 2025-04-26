<?php
include_once '../../Config/config.php';

try {
    $user_id = $_SESSION['user_id'];

    // Fetch Credit Data
    $InvoiceQuery = "
        SELECT  
            Invoice.*, 
           CONCAT(Customer.firstname, ' ', Customer.lastname) AS customer_name,
            Company.companyName AS company_name,
            Product.productName AS product_name
        FROM Invoice
        LEFT JOIN Customer ON Invoice.customer_id = Customer.customer_id
        LEFT JOIN Company ON Invoice.company_id = Company.company_id
        LEFT JOIN Product ON Invoice.product_id = Product.product_id
        WHERE Invoice.user_id = :user_id
        ORDER BY Invoice.invoice_id DESC
    ";
    $invoiceStmt = $conn->prepare($InvoiceQuery);
    $invoiceStmt->bindParam(':user_id', $user_id);
    $invoiceStmt->execute();
    $invoice = $invoiceStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo json_encode([]);
}