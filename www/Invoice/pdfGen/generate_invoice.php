<?php
require("../../vendor/autoload.php");
include_once '../../Config/config.php';
use Dompdf\Dompdf;
use Dompdf\Options;

try {

    $type = null;
    $user_id = $_SESSION['user_id'];
    $invoice_id = $_GET['invoice_id'];
    // Fetching invoice data
    $stmt = $conn->prepare('SELECT * FROM Invoice WHERE invoice_id = :invoice_id');
    $stmt->bindValue(':invoice_id', $invoice_id, PDO::PARAM_INT);
    $stmt->execute();
    $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

     // Assuming invoice_id is passed as a query parameter
    if( $invoice['customer_id'] == null) {
        $company_id = $invoice['company_id'];
        $stmt = $conn->prepare('SELECT * FROM Company WHERE company_id = :company_id');
        $stmt->bindValue(':company_id', $company_id, PDO::PARAM_INT);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        $type="Company";
    } else {
        $customer_id = $invoice['customer_id'];
        $stmt = $conn->prepare('SELECT * FROM Customer WHERE customer_id = :customer_id');
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        $type="Customer";
    }

    $product_id = $invoice['product_id'];
    // Fetching customer data


    // Fetching product data
    $stmt = $conn->prepare('SELECT * FROM Product WHERE product_id = :product_id');
    $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetching business info data
    $stmt = $conn->prepare('SELECT * FROM BusinessInfo WHERE user_id = :user_id order by business_id desc');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $businessInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Load and render HTML template
    ob_start();
    include 'template_invoice.php';
    $html = ob_get_clean();

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('invoice.pdf', ['Attachment' => 0]);

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}