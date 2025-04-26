<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; margin: 0 auto; }
        .header, .footer { text-align: center; }
        .header { margin-bottom: 20px; }
        .footer { margin-top: 20px; }
        .invoice-info { margin-bottom: 20px; }
        .invoice-details { width: 100%; border-collapse: collapse; }
        .invoice-details th, .invoice-details td { border: 1px solid #ddd; padding: 8px; }
        .invoice-details th { background-color: #f2f2f2; text-align: left; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1><?= htmlspecialchars($businessInfo['business_name'] ?? '') ?></h1>
        <p><?= htmlspecialchars($businessInfo['address'] ?? '') ?></p>
        <p>Contact: <?= htmlspecialchars($businessInfo['contact_number'] ?? '') ?> | Email: <?= htmlspecialchars($businessInfo['email'] ?? '') ?> | Website: <?= htmlspecialchars($businessInfo['website'] ?? '') ?></p>
        <?php if (!empty($businessInfo['logo_path'])): ?>
            <img src="<?= htmlspecialchars('http://localhost/' . ltrim($businessInfo['logo_path'], '/')) ?>" alt="Business Logo" style="max-width: 150px;">
        <?php endif; ?>
    </div>

    <div class="invoice-info">
        <h2>Invoice</h2>
        <p><strong>Invoice Number:</strong> <?= htmlspecialchars($invoice['invoice_number'] ?? '') ?></p>
        <p><strong>Invoice Date:</strong> <?= htmlspecialchars($invoice['invoice_date'] ?? '') ?></p>
        <p><strong>Due Date:</strong> <?= htmlspecialchars($invoice['invoice_due_date'] ?? '') ?></p>
        <p><strong>Terms:</strong> <?= htmlspecialchars($invoice['terms'] ?? '') ?></p>
    </div>

    <?php if (($type ?? '') === 'Customer'): ?>
        <div class="customer-info">
            <h3>Bill To:</h3>
            <p><?= htmlspecialchars(($customer['firstname'] ?? '') . ' ' . ($customer['lastname'] ?? '')) ?></p>
            <p><?= htmlspecialchars($customer['street'] ?? '') ?></p>
            <p><?= htmlspecialchars(($customer['city'] ?? '') . ', ' . ($customer['state'] ?? '') . ' ' . ($customer['postalcode'] ?? '')) ?></p>
            <p>Email: <?= htmlspecialchars($customer['email'] ?? '') ?> | Phone: <?= htmlspecialchars($customer['phone'] ?? '') ?></p>
            <p><strong>Company:</strong> <?= htmlspecialchars($customer['customer_id'] ?? '') ?></p>
        </div>
    <?php else: ?>
        <div class="customer-info">
            <h3>Bill To:</h3>
            <p><?= htmlspecialchars($customer['companyName'] ?? '') ?></p>
            <p><?= htmlspecialchars($customer['companyAddress'] ?? '') ?></p>
            <p><?= htmlspecialchars(($customer['state'] ?? '') . ', ' . ($customer['country'] ?? '')) ?></p>
            <p>Email: <?= htmlspecialchars($customer['companyEmail'] ?? '') ?> | Phone: <?= htmlspecialchars($customer['phoneNumber'] ?? '') ?></p>
            <p><strong>Company:</strong> <?= htmlspecialchars($customer['company_id'] ?? '') ?></p>
        </div>
    <?php endif; ?>

    <div class="invoice-details">
        <table>
            <thead>
            <tr>
                <th>Product/Service</th>
                <th>Description</th>
                <th>Rate</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Discount</th>
                <th>Tax (13%)</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= htmlspecialchars($product['productName'] ?? '') ?></td>
                <td><?= htmlspecialchars($product['productDescription'] ?? '') ?></td>
                <td><?= number_format((float) ($invoice['rate'] ?? 0), 2) ?></td>
                <td><?= number_format((float) ($invoice['quantity'] ?? 0), 2) ?></td>
                <td><?= number_format((float) ($invoice['subtotal'] ?? 0), 2) ?></td>
                <td><?= number_format((float) ($invoice['discount'] ?? 0), 2) ?>%</td>
                <td><?= number_format((float) ($invoice['tax'] ?? 0), 2) ?></td>
                <td><?= number_format((float) ($invoice['total_amount'] ?? 0), 2) ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p><?= htmlspecialchars($businessInfo['business_name'] ?? '') ?> | <?= htmlspecialchars($businessInfo['address'] ?? '') ?></p>
        <p>Contact: <?= htmlspecialchars($businessInfo['contact_number'] ?? '') ?> | Email: <?= htmlspecialchars($businessInfo['email'] ?? '') ?> | Website: <?= htmlspecialchars($businessInfo['website'] ?? '') ?></p>
    </div>
</div>
</body>
</html>
