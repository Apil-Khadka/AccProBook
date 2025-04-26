<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Balance Sheet</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Sidebar/styles.css">
</head>
<body id="body-pd" class="body-pd p-6 bg-gray-100">
<?php
include_once("../../Sidebar/sidebar.html");
?>
<h1 class="text-3xl font-bold mb-6">Credit and Debit Information</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div id="credit-section" class="bg-white p-4 rounded shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Credits</h2>
        <table id="credit-table" class="w-full table-auto border-collapse">
            <thead>
            <tr>
                <th class="px-4 py-2 border border-gray-300 bg-gray-100">Name</th>
                <th class="px-4 py-2 border border-gray-300 bg-gray-100">Credit Date</th>
                <th class="px-4 py-2 border border-gray-300 bg-gray-100">Amount</th>
            </tr>
            </thead>
            <tbody>
            <!-- Credit rows will be inserted here -->
            </tbody>
        </table>
    </div>

    <div id="debit-section" class="bg-white p-4 rounded shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Debits</h2>
        <table id="debit-table" class="w-full table-auto border-collapse">
            <thead>
            <tr>
                <th class="px-4 py-2 border border-gray-300 bg-gray-100">Name</th>
                <th class="px-4 py-2 border border-gray-300 bg-gray-100">Debit Date</th>
                <th class="px-4 py-2 border border-gray-300 bg-gray-100">Amount</th>
            </tr>
            </thead>
            <tbody>
            <!-- Debit rows will be inserted here -->
            </tbody>
        </table>
    </div>
</div>

<div class="totals mt-8 bg-white p-4 rounded shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Totals</h2>
    <p class="text-lg">Total Credit: <span id="total-credit" class="font-bold"></span></p>
    <p class="text-lg">Total Debit: <span id="total-debit" class="font-bold"></span></p>
    <p class="text-lg">Net Amount: <span id="net-amount" class="font-bold"></span></p>
</div>
<a href="balance_pdf.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Generate Pdf</a>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        axios.get('../../API/Fetch/fetch_balance_sheet.php') // Adjust the path to your PHP script
            .then(function(response) {
                if (response.data) {
                    // Populate Credit Table
                    var creditRows = '';
                    response.data.credits.forEach(function(credit) {
                        creditRows += '<tr>';
                        if(credit.customer_name == null) {
                            creditRows += '<td>' + (credit.company_name ? credit.company_name : '') + '</td>';
                        } else {
                            creditRows += '<td>' + (credit.customer_name ? credit.customer_name : '') + '</td>';
                        }
                        creditRows += '<td>' + credit.credit_Date + '</td>'; // Adjust field names as necessary
                        creditRows += '<td>' + "Rs."+credit.credit_Amount + '</td>';
                        creditRows += '</tr>';
                    });
                    document.querySelector('#credit-table tbody').innerHTML = creditRows;

                    // Populate Debit Table
                    var debitRows = '';
                    response.data.debits.forEach(function(debit) {
                        debitRows += '<tr>';
                        if(debit.customer_name == null){
                            debitRows += '<td>' + (debit.company_name ? debit.company_name : '') + '</td>';
                        } else {
                            debitRows += '<td>' + (debit.customer_name ? debit.customer_name : '') + '</td>';
                        }
                        debitRows += '<td>' + debit.debit_Date + '</td>'; // Adjust field names as necessary
                        debitRows += '<td>' + "Rs."+debit.debit_Amount + '</td>';
                        debitRows += '</tr>';
                    });
                    document.querySelector('#debit-table tbody').innerHTML = debitRows;

                    // Display Totals
                    document.querySelector('#total-credit').textContent = "Rs."+response.data.totalCredit;
                    document.querySelector('#total-debit').textContent = "Rs."+response.data.totalDebit;
                    document.querySelector('#net-amount').textContent = "Rs."+response.data.netAmount;
                }
            })
            .catch(function(error) {
                console.log('Error fetching data:', error);
            });
    });
</script>
<script src="../../Sidebar/main.js"></script>
</body>
</html>
