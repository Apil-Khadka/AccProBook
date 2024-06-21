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
        <h1><?= $businessInfo['business_name'] ?></h1>
        <p><?= $businessInfo['address'] ?></p>
        <p>Contact: <?= $businessInfo['contact_number'] ?> | Email: <?= $businessInfo['email'] ?> | Website: <?= $businessInfo['website'] ?></p>
        <img src="<?='http://localhost/'. $businessInfo['logo_path'] ?>" alt="Business Logo" style="max-width: 150px;">
    </div>

    <div class="invoice-info">
        <h2>Invoice</h2>
        <p><strong>Invoice Number:</strong> <?= $invoice['invoice_number'] ?></p>
        <p><strong>Invoice Date:</strong> <?= $invoice['invoice_date'] ?></p>
        <p><strong>Due Date:</strong> <?= $invoice['invoice_due_date'] ?></p>
        <p><strong>Terms:</strong> <?= $invoice['terms'] ?></p>
    </div>

    <?php if($type == "Customer"): ?>
        <div class="customer-info">
            <h3>Bill To:</h3>
            <p><?= $customer['firstname'] . ' ' . $customer['lastname'] ?></p>
            <p><?= $customer['street'] ?></p>
            <p><?= $customer['city'] . ', ' . $customer['state_region'] . ' ' . $customer['postalcode'] ?></p>
            <p>Email: <?= $customer['email'] ?> | Phone: <?= $customer['phone'] ?></p>
            <p><strong>Company:</strong> <?= $customer['company_id'] ?></p>
        </div>
    <?php else: ?>
        <div class="customer-info">
            <h3>Bill To:</h3>
            <p><?= $customer['companyName'] ?></p>
            <p><?= $customer['companyAddress'] ?></p>
            <p><?= $customer['city'] . ', ' . $customer['state'] ?></p>
            <p>Email: <?= $customer['companyEmail'] ?> | Phone: <?= $customer['phoneNumber'] ?></p>
            <p><strong>Company:</strong> <?= $customer['company_id'] ?></p>
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
                <td><?= $product['productName'] ?></td>
                <td><?= $product['productDescription'] ?></td>
                <td><?= number_format($invoice['rate'], 2) ?></td>
                <td><?= number_format($invoice['quantity'], 2) ?></td>
                <td><?= number_format($invoice['subtotal'], 2) ?></td>
                <td><?= number_format($invoice['discount'], 2) ?>%</td>
                <td><?= number_format($invoice['tax'], 2) ?></td>
                <td><?= number_format($invoice['total_amount'], 2) ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p><?= $businessInfo['business_name'] ?> | <?= $businessInfo['address'] ?></p>
        <p>Contact: <?= $businessInfo['contact_number'] ?> | Email: <?= $businessInfo['email'] ?> | Website: <?= $businessInfo['website'] ?></p>
    </div>
</div>
</body>
</html>
