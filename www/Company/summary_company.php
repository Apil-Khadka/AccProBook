<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Summary</title>
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

    if (isset($_GET['company_id'])) {
        $company_id = htmlspecialchars($_GET['company_id']);

        $query = "SELECT * FROM Company WHERE company_id = :company_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':company_id', $company_id);
        $stmt->execute();
        $company = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($company) {
            echo '
        <h2 class="text-2xl font-bold mb-4">Company Summary</h2>
        <form id="updateCompanyForm" action="../API/Update/update_customer.php" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            <input type="hidden" name="company_id" value="' . htmlspecialchars($company['company_id']) . '">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyName">Company Name</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyName" type="text" name="companyName" value="' . htmlspecialchars($company['companyName']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="contactName">Contact Person</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="contactName" type="text" name="contactName" value="' . htmlspecialchars($company['contactName']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyEmail">Email</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyEmail" type="email" name="companyEmail" value="' . htmlspecialchars($company['companyEmail']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phoneNumber">Phone Number</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phoneNumber" type="text" name="phoneNumber" value="' . htmlspecialchars($company['phoneNumber']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="landLineNumber">Landline Number</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="landLineNumber" type="text" name="landLineNumber" value="' . htmlspecialchars($company['landLineNumber']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyAddress">Address</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyAddress" type="text" name="companyAddress" value="' . htmlspecialchars($company['companyAddress']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="state">State</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="state" type="text" name="state" value="' . htmlspecialchars($company['state']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="country">Country</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="country" type="text" name="country" value="' . htmlspecialchars($company['country']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="URL">URL</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="URL" type="text" name="URL" value="' . htmlspecialchars($company['URL']) . '">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update
                </button>
                <a href="company_list.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Back to Company List
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
            axios.post('../API/Update/update_company.php', formData)
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
