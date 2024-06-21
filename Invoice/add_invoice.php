<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Form</title>
    <link rel="stylesheet" href="../Sidebar/styles.css">
    <link rel="stylesheet" href="invoice.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        .Success {
            color: green;
            border: 2px solid green;
            padding: 10px;
            display: none;
            border-radius: 5px;
        }

        .Failure {
            color: red;
            border: 2px solid red;
            padding: 10px;
            display: none;
            border-radius: 5px;
        }
    </style>
</head>
<body id="body-pd">
<?php include("../Sidebar/sidebar.html"); ?>
<div class="container mt-4">
    <div class="row">
        <!-- Client Info Section -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Client Info</h4>
                </div>
                <div class="card-body">
                    <form id="clientForm">
                        <div class="form-group">
                            <label for="clientSelect">Client Name</label>
                            <select id="clientSelect" name="client" class="form-control" required>
                                <option value="">Select a client</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="billTo">Bill to</label>
                            <input type="text" name="billTo" class="form-control" id="billTo" placeholder="Bill to">
                        </div>
                        <div class="form-group">
                            <label for="invoiceNumber">Invoice Number</label>
                            <input type="text" name="invoiceNumber" class="form-control" id="invoiceNumber" placeholder="Invoice Number" required>
                        </div>
                        <div class="form-group">
                            <label for="invoiceDate">Invoice Date</label>
                            <input type="date" name="invoiceDate" class="form-control" id="invoiceDate" required>
                        </div>
                        <div class="form-group">
                            <label for="invoiceDueDate">Invoice Due Date</label>
                            <input type="date" name="invoiceDueDate" class="form-control" id="invoiceDueDate" required>
                        </div>
                        <div class="form-group">
                            <label for="terms">Terms</label>
                            <select name="terms" class="form-control" id="terms">
                                <option value="thinking">Thinking</option>
                                <option value="to-fulfill">To fulfill</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Fetch Details Section -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Invoice Details</h4>
                </div>
                <div class="card-body">
                    <form id="invoiceForm">
                        <div class="form-group">
                            <label for="productSelect">Product/Service</label>
                            <select id="productSelect" name="ProductID" class="form-control" required>
                                <option value="">Select a product</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rate">Rate</label>
                            <input type="number" name="rate" class="form-control" id="rate" placeholder="Rate" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="quantityHours">Qty/Hrs</label>
                            <input type="number" name="quantityHours" class="form-control" id="quantityHours" placeholder="Quantity/Hours" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount (%)</label>
                            <input type="number" id="discount" name="discount" class="form-control" oninput="calculateAmount()" placeholder="Discount" step="0.01" >
                        </div>
                        <div class="form-group">
                            <label for="subtotal">Subtotal</label>
                            <input type="number" id="subtotal" name="subtotal" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tax">Tax (13%)</label>
                            <input type="number" id="tax" name="tax" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="amount">Total Amount</label>
                            <input type="number" id="amount" name="amount" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" class="form-control" id="notes" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-primary" onclick="submitForm()">Generate Invoice</button>
                            </div>
                        </div>
                        <span id="Success"></span>
                        <span id="Failure"></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="fetch_data.js"></script>
<script>
    function submitForm() {
        const clientForm = document.getElementById('clientForm');
        const invoiceForm = document.getElementById('invoiceForm');
        const successMessage = document.getElementById('Success');
        const failureMessage = document.getElementById('Failure');

        const formData = new FormData(clientForm);
        const invoiceData = new FormData(invoiceForm);

        invoiceData.forEach((value, key) => {
            formData.append(key, value);
        });
        console.log(formData);
        axios.post('invoice_back.php', formData)
            .then(response => {
              if(response.data.success) {
                  successMessage.textContent = response.data.message;
                  successMessage.style.display = 'block';
                  failureMessage.style.display = 'none';
              }else{
                    failureMessage.textContent = response.data.message;
                    failureMessage.style.display = 'block';
                    successMessage.style.display = 'none';
              }
            })
            .catch(error => {
                console.log(error);
                failureMessage.textContent= 'Error: ' + error.message;
                failureMessage.style.display = 'block';
                successMessage.style.display = 'none';
            });
    }
</script>
<script src="../Sidebar/main.js"></script>
<x></x>
</body>
</html>
