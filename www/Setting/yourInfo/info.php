<?php
include_once("../../Config/config.php");

?>
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
            display: none;
        }

        #serverSuccess {
            color: green;
            font-weight: bold;
            display: none;
        }

        .required {
            color: red;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="../../Sidebar/styles.css">
</head>
<body class="bg-gray-100 text-gray-800 body-pd" id="body-pd">

<?php
include_once("../../Sidebar/sidebar.html");
?>

<div class="container mx-auto p-4">
    <?php
    $user_id = $_SESSION['user_id'];
    $query = "SELECT *, COUNT(*) AS count FROM BusinessInfo WHERE user_id=:user_id ORDER BY business_id DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $business = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($business['count'] == 0) {
        echo '
        <h2 class="text-2xl font-bold mb-4">Business</h2>
        <form id="insertCompanyForm" class="bg-white p-6 rounded-lg shadow-lg" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyName">Business Name <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyName" type="text" name="business_name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyAddress">Address <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyAddress" type="text" name="address" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyEmail">Email <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyEmail" type="email" name="email" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyPhone">Phone <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyPhone" type="text" name="contact_number" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyWebsite">Website</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyWebsite" type="text" name="website">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyLogoFile">Upload Logo</label>
                <input class="appearance-none block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id="companyLogoFile" type="file" name="logo_path">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Submit</button>
            </div>
        </form>';
    } else {
        echo '
        <h2 class="text-2xl font-bold mb-4">Business</h2>
        <form id="updateCompanyForm" class="bg-white p-6 rounded-lg shadow-lg" enctype="multipart/form-data">
            <input type="hidden" name="business_id" value="' . htmlspecialchars($business['business_id']) . '">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyName">Business Name <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyName" type="text" name="business_name" value="' . htmlspecialchars($business['business_name']) . '" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyAddress">Address <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyAddress" type="text" name="address" value="' . htmlspecialchars($business['address']) . '" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyEmail">Email <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyEmail" type="email" name="email" value="' . htmlspecialchars($business['email']) . '" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyPhone">Phone <span class="required">*</span></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyPhone" type="text" name="contact_number" value="' . htmlspecialchars($business['contact_number']) . '" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyWebsite">Website</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="companyWebsite" type="text" name="website" value="' . htmlspecialchars($business['website']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyLogo">Logo</label>
                <img src="' . 'http://localhost/' . htmlspecialchars($business['logo_path']) . '" alt="Logo" class="rounded-lg shadow-lg" style="max-width: 200px; max-height: 200px;">
                <input type="hidden" name="logo_path" value="' . htmlspecialchars($business['logo_path']) . '">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="companyLogoFile">Upload New Logo</label>
                <input class="appearance-none block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id="companyLogoFile" type="file" name="logo_path_up">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Update</button>
            </div>
        </form>';
    }
    ?>
    <span id="serverError" class="error-message"></span>
    <span id="serverSuccess" class="success-message"></span>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let serverError = document.getElementById('serverError');
        let serverSuccess = document.getElementById('serverSuccess');

        const insertCompanyForm = document.getElementById('insertCompanyForm');
        const updateCompanyForm = document.getElementById('updateCompanyForm');

        if (insertCompanyForm) {
            insertCompanyForm.addEventListener('submit', function (event) {
                event.preventDefault();
                serverError.textContent = '';
                serverSuccess.textContent = '';

                const formData = new FormData(this);
                axios.post('/website/project/Hakathon/API/Insert/insert_business_info.php', formData)
                    .then(function (response) {
                        console.log(response.data)
                        if (response.data.success) {
                            serverSuccess.textContent = response.data.message;
                            serverError.style.display = 'none';
                            serverSuccess.style.display = 'block';
                            location.reload();
                        } else {
                            serverError.textContent = response.data.message;
                            serverError.style.display = 'block';
                            serverSuccess.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting form:', error);
                        serverError.textContent = 'An error occurred. Please try again later.';
                        serverError.style.display = 'block';
                        serverSuccess.style.display = 'none';
                    });
            });
        }

        if (updateCompanyForm) {
            updateCompanyForm.addEventListener('submit', function (event) {
                event.preventDefault();
                serverError.textContent = '';
                serverSuccess.textContent = '';

                const formData = new FormData(this);
                axios.post('/website/project/Hakathon/API/Update/update_business_info.php', formData)
                    .then(function (response) {
                        if (response.data.success) {
                            serverSuccess.textContent = response.data.message;
                            serverError.style.display = 'none';
                            serverSuccess.style.display = 'block';
                            location.reload();
                        } else {
                            serverError.textContent = response.data.message;
                            serverError.style.display = 'block';
                            serverSuccess.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting form:', error);
                        serverError.textContent = 'An error occurred. Please try again later.';
                        serverError.style.display = 'block';
                        serverSuccess.style.display = 'none';
                    });
            });
        }
    });
</script>

<script src="../../Sidebar/main.js"></script>

</body>
</html>
