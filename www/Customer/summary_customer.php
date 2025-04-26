<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        #serverError {
            color: red;
            font-weight: bold;
        }

        #serverSuccess {
            color: green;
            font-weight: bold;
        }

        .required {
            color: red;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="container mx-auto p-4">
    <?php
    include_once("../Config/config.php");

    if (isset($_GET['customer_id'])) {
        $customer_id = htmlspecialchars($_GET['customer_id']);

        $query = "SELECT * FROM Customer WHERE customer_id = :customer_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($customer) {
            echo '
        <h2 class="text-2xl font-bold mb-4">Customer Summary</h2>
        <form id="updateCompanyForm" action="../API/Update/update_customer.php" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            <input type="hidden" name="customer_id" value="' . htmlspecialchars($customer['customer_id']) . '">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyName">First Name <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyName" type="text" name="firstname" value="' . htmlspecialchars($customer['firstname']) . '" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyName">Last Name <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyName" type="text" name="lastname" value="' . htmlspecialchars($customer['lastname']) . '" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="contactName">Email <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="contactName" type="email" name="email" value="' . htmlspecialchars($customer['email']) . '" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyEmail">Phone <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyEmail" type="text" name="phone" value="' . htmlspecialchars($customer['phone']) . '" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phoneNumber">Street</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phoneNumber" type="text" name="street" value="' . htmlspecialchars($customer['street']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="landLineNumber">City <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="landLineNumber" type="text" name="city" value="' . htmlspecialchars($customer['city']) . '" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyAddress">State <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyAddress" type="text" name="state" value="' . htmlspecialchars($customer['state']) . '" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="country">Country <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="country" type="text" name="country" value="' . htmlspecialchars($customer['country']) . '" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="URL">Postal Code</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="URL" type="text" name="postalcode" value="' . htmlspecialchars($customer['postalcode']) . '">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update
                </button>
                <a href="customer_list.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Back to Customer List
                </a>
            </div>
        </form>';
        } else {
            echo '<p class="text-center text-red-500">No customer found with the given ID.</p>';
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
            axios.post('../API/Update/update_customer.php', formData)
                .then(function (response) {
                    if (response.data.success) {
                        console.log(response.data.message)
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
