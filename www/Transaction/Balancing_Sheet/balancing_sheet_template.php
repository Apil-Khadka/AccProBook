<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Balance Sheet</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: Arial, sans-serif; }
    .section { margin-bottom:20px; padding:20px; border:1px solid #ccc; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); }
    .totals { margin-top:20px; padding:20px; border:1px solid #ccc; border-radius:8px; }
    .table th, .table td, p { font-size:12px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <!-- Credits Section -->
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
              <?php foreach ((array) ($response['credits'] ?? []) as $credit): ?>
                <tr>
                  <td>
                    <?php
                    // show customer_name or company_name or dash
                    echo htmlspecialchars(
                        $credit['customer_name']
                            ?? $credit['company_name']
                            ?? '—'
                    );
                    ?>
                  </td>
                  <td><?php echo htmlspecialchars($credit['credit_Date'] ?? '—'); ?></td>
                  <td>Rs. <?php echo htmlspecialchars($credit['credit_Amount'] ?? '0'); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Debits Section -->
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
              <?php foreach ((array) ($response['debits'] ?? []) as $debit): ?>
                <tr>
                  <td>
                    <?php
                    echo htmlspecialchars(
                        $debit['customer_name']
                            ?? $debit['company_name']
                            ?? '—'
                    );
                    ?>
                  </td>
                  <td><?php echo htmlspecialchars($debit['debit_Date'] ?? '—'); ?></td>
                  <td>Rs. <?php echo htmlspecialchars($debit['debit_Amount'] ?? '0'); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Totals Section -->
    <div class="row totals">
      <div class="col-md-12 text-center">
        <h2>Totals</h2>
        <p>Total Credit: Rs. <?php echo htmlspecialchars($response['totalCredit'] ?? 0); ?></p>
        <p>Total Debit:  Rs. <?php echo htmlspecialchars($response['totalDebit'] ?? 0); ?></p>
        <p>Net Amount:   Rs. <?php echo htmlspecialchars($response['netAmount'] ?? 0); ?></p>
      </div>
    </div>
  </div>
</body>
</html>
