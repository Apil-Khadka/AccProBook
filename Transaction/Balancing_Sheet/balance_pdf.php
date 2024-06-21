<?php
require '../../vendor/autoload.php'; // Adjust the path as necessary
use Dompdf\Dompdf;
use Dompdf\Options;

// Fetch data from your API or database
$url = 'localhost/website/project/Hakathon/API/Fetch/fetch_balance_sheet.php'; // Adjust the URL to your API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
curl_close($ch);
$response = json_decode($data, true);

ob_start();
include 'balancing_sheet_template.php';
$html = ob_get_clean();

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('invoice.pdf', ['Attachment' => 0]);