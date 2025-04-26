<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ERROR | E_PARSE);
session_start();

require '../../vendor/autoload.php';
include_once '../../Config/config.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die('User not authenticated');
}

$creditStmt = $conn->prepare(
    'SELECT Credit.*, Customer.firstname AS customer_name, Company.companyName AS company_name
     FROM Credit
     LEFT JOIN Customer ON Credit.customer_id = Customer.customer_id
     LEFT JOIN Company ON Credit.company_id = Company.company_id
     WHERE Credit.user_id = :user_id
     ORDER BY Credit.credit_Date DESC'
);
$creditStmt->execute([':user_id' => $user_id]);
$credits = $creditStmt->fetchAll(PDO::FETCH_ASSOC);

$debitStmt = $conn->prepare(
    'SELECT Debit.*, Customer.firstname AS customer_name, Company.companyName AS company_name
     FROM Debit
     LEFT JOIN Customer ON Debit.customer_id = Customer.customer_id
     LEFT JOIN Company ON Debit.company_id = Company.company_id
     WHERE Debit.user_id = :user_id
     ORDER BY Debit.debit_Date DESC'
);
$debitStmt->execute([':user_id' => $user_id]);
$debits = $debitStmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate totals
$totalCredit = array_sum(array_map(fn($c) => (float) $c['credit_Amount'], $credits));
$totalDebit = array_sum(array_map(fn($d) => (float) $d['debit_Amount'], $debits));
$netAmount = $totalCredit - $totalDebit;

$response = [
    'credits' => $credits,
    'debits' => $debits,
    'totalCredit' => $totalCredit,
    'totalDebit' => $totalDebit,
    'netAmount' => $netAmount,
];

ob_start();
include 'balancing_sheet_template.php';
$html = ob_get_clean();

$options = (new Options())
    ->set('isHtml5ParserEnabled', true)
    ->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

if (ob_get_length())
    ob_end_clean();
$dompdf->stream('balance_sheet.pdf', ['Attachment' => 0]);
exit;
