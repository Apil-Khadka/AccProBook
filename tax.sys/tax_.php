<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Rate Estimator - Nepal</title>
    <link rel="stylesheet" href="tax_sys.css">
    <link rel="stylesheet" href="../Sidebar/styles.css">
</head>
<body class="body-pd" id="body-pd">
    <?php include_once("../Sidebar/sidebar.html") 
    ?>
    <div class="container">
        <div class="form-container">
            <h2>Business address</h2>
            <form id="tax-form">
                <input type="text" id="address" placeholder="Address" required>
                <input type="text" id="city" placeholder="City" required>
                <select id="province" required>
                    <option value="" disabled selected>Choose a province</option>
                    <option value="Province 1">Province 1</option>
                    <option value="Province 2">Province 2</option>
                    <option value="Bagmati Province">Bagmati Province</option>
                    <option value="Gandaki Province">Gandaki Province</option>
                    <option value="Lumbini Province">Lumbini Province</option>
                    <option value="Karnali Province">Karnali Province</option>
                    <option value="Sudurpashchim Province">Sudurpashchim Province</option>
                </select>
                <select  id="district" required>
                    <option value="" disabled selected>Choose a district</option>
                    <!--  you can add more as needed -->
                    <option value="Kathmandu">Kathmandu</option>
                    <option value="Lalitpur">Lalitpur</option>
                    <option value="Bhaktapur">Bhaktapur</option>
                    <option value="Chitwan">Chitwan</option>
                    <option value="Pokhara">Pokhara</option>
                    <!-- Add more districts here -->
                </select>
                <input type="number" id="taxable-amount" placeholder="Enter amount to calculated" required>
                <button type="submit">Get rate estimate</button>
            </form>
            <p>*Enter the full street address for the most accurate rate.</p>
        </div>
        <div class="result-container">
            <div id="total-rate">
                <h2>0.00%</h2>
                <p>TOTAL ESTIMATED TAX RATE</p>
            </div>
            <div id="breakdown">
                <div>Province Tax: 0.00%</div>
                <div>District Tax: 0.00%</div>
            </div>
            <div id="calculated-tax">
                <h2>   0.00</h2>
            </div>
        <div id="remark"> <p>CALCULATED TAX AMOUNT</p></div>
        </div>
    </div>
    <script src="tax_sys.js"></script>
    <script src="../Sidebar/main.js"></script>
</body>
</html>
