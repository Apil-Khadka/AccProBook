<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Balance Sheet</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .section {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .totals {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .table th, .table td,p{
            font-size: 12px; /* Reduced font size for table cells */
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="section">
                <h2 class="text-center">Credits</h2>
                <table class="table table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Credit Date</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($response['credits'] as $credit): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($credit['customer_name'] ?? $credit['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($credit['credit_Date']); ?></td>
                            <td>Rs. <?php echo htmlspecialchars($credit['credit_Amount']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="section">
                <h2 class="text-center">Debits</h2>
                <table class="table table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Debit Date</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($response['debits'] as $debit): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($debit['customer_name'] ?? $debit['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($debit['debit_Date']); ?></td>
                            <td>Rs. <?php echo htmlspecialchars($debit['debit_Amount']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row totals">
        <div class="col-md-12">
            <h2 class="text-center">Totals</h2>
            <p class="text-center">Total Credit: <span class="font-weight-bold">Rs. <?php echo htmlspecialchars($response['totalCredit']); ?></span></p>
            <p class="text-center">Total Debit: <span class="font-weight-bold">Rs. <?php echo htmlspecialchars($response['totalDebit']); ?></span></p>
            <p class="text-center">Net Amount: <span class="font-weight-bold">Rs. <?php echo htmlspecialchars($response['netAmount']); ?></span></p>
        </div>
    </div>
</div>
</body>
</html>
