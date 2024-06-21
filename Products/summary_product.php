<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        #serverError {
            color: red;
            font-weight: bold;
            /* Add any other styles you want for error messages */
        }

        #serverSuccess {
            color: green;
            font-weight: bold;
            /* Add any other styles you want for success messages */
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="container mx-auto p-4">
    <?php
    include_once("../Config/config.php");

    if (isset($_GET['product_id'])) {
        $company_id = htmlspecialchars($_GET['product_id']);

        $query = "SELECT * FROM Product WHERE product_id = :product_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':product_id', $company_id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo '
        <h2 class="text-2xl font-bold mb-4">Product Summary</h2>
        <form id="updateCompanyForm" action="../API/Update/update_customer.php" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            <input type="hidden" name="product_id" value="' . htmlspecialchars($product['product_id']) . '">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyName">Product Name</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyName" type="text" name="productName" value="' . htmlspecialchars($product['productName']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="contactName">Product Price</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="contactName" type="number" name="productPrice" value="' . htmlspecialchars($product['productPrice']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyAddress">Address</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyAddress" type="text" name="productDescription" value="' . htmlspecialchars($product['productDescription']) . '">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update
                </button>
                <a href="product-list.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Back to Product List
                </a>
            </div>
        </form>';
        } else {
            echo '<p class="text-center text-red-500">No company found with the given ID.</p>';
        }
    }
    ?>
    <span id="serverError" class="error-message"></span>
    <span id="serverSuccess" class="success-message"></span>
</div>
<script>
    document.addEventListener("DOMContentLoaded",function () {

        document.getElementById('updateCompanyForm').addEventListener('submit', function (event) {
            event.preventDefault();

            let serverError = document.getElementById('serverError');
            let serverSuccess = document.getElementById('serverSuccess');

            serverError.textContent = '';
            serverSuccess.textContent = '';
            const formData = new FormData(this);
            axios.post('../API/Update/update_product.php', formData)
                .then(function (response) {
                    if (response.data.success) {
                        serverSuccess.textContent = response.data.message;
                    } else {
                        serverError.textContent = response.data.message;

                    }
                })
                .catch(error => {
                    console.error('Error submitting form:', error);
                    serverError.textContent = 'An error occurred. Please try again later.';
                });
        });
    });
</script>

</body>
</html>
