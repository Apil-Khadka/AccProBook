<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Company</title>
    <link rel="stylesheet" href="company.css">
    <link rel="stylesheet" href="../Sidebar/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Karla&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.0.2/css/countrySelect.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<style>
    .success-message {
        color: green;
        border: 2px solid green;
        padding: 10px;
        display: none;
        border-radius: 5px;
    }

    .error-message {
        color: red;
        border: 2px solid red;
        padding: 10px;
        display: none;
        border-radius: 5px;
    }
</style>
</head>
<body id="body-pd">
<?php
include_once("../Sidebar/sidebar.html");
?>
    <div class="main-content">
        <h1 class="heading">Add Company</h1>
        <div class="container">
            <form id="companyForm">
                <div class="name">
                    <label for="companyName" class="companyName">Company Name:</label><br>
                    <input type="text" id="companyName" name="companyName" required>
                </div>
                
                <div class="name">
                    <label for="companyAddress" class="address">Company Address:</label><br>
                    <input type="text" id="companyAddress" name="companyAddress" placeholder="Enter address of company" required>
                </div>

                <div class="name">
                    <label for="contactName" class="name">Primary Contact Person:</label><br>
                    <input type="text" id="contactName" name="contactName" placeholder="Enter name of contact person">
                </div><br>

                <div>

                    <h2>Contact Information</h2>

                    <div class="name">
                        <label for="companyEmail" class="email">Email:</label><br>
                        <input type="email" id="companyEmail" name="companyEmail" placeholder="Enter email" required>
                        <span id="emailError" class="error-message"></span><br>
                    </div>

                    <div class="name">
                        <label for="phoneNumber">Phone Number:</label><br>
                        <input type="text" id="phoneNumber" name="phoneNumber" placeholder="98XXXXXXXX">
                        <p id="message"></p>
                    </div>

                    <div class="name">
                        <label for="landLineNumber">Landline Number:</label><br>
                        <input type="text" id="landLineNumber" name="landLineNumber" placeholder="025-XXXXXXX">
                    </div>
                    
                    <div class="name">
                        <label for="state" class="state">State/Region:</label><br>
                        <input type="text" id="state" name="state" required>
                    </div>
                    
                    <div class="name">
                        <label for="country">Country:</label><br>
                        <input type="text" id="country" name="country" required>
                        <span id="countryError" class="error-message"></span>
                    </div><br>
                    <div class="name">
                        <div class="url">
                            <br>
                            <br>
                        <label for="URL">URL</label><br>
                        <input type="url" id="URL" name="URL">
                    </div>
                </div><br>
                    <button type="submit">Save</button>
                </div>
            </form>
            <span id="success-message" class="success-message"></span>
            <span id="error-message" class="error-message"></span>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.0.2/js/countrySelect.min.js"></script>
    <script>

        $(document).ready(function() {
            // Initialize country dropdown using country-select-js library
            $("#country").countrySelect({
                defaultCountry: "np"
            });
            // Form submission handling
            $("#companyForm").submit(function(event) {
                event.preventDefault(); // Prevent the form from submitting

                const serverSuccess = document.getElementById("success-message");
                const serverError = document.getElementById("error-message");

                serverSuccess.textContent = '';
                serverError.textContent = '';

                const formData = new FormData(this);

                axios.post('../API/Insert/insert_company.php', formData)
                    .then(function(response) {
                        if (response.data.success) {
                            serverSuccess.textContent = response.data.message;
                            serverSuccess.style.display = 'block';
                            serverError.style.display = 'none';
                        } else {
                            serverError.textContent = response.data.message;
                            serverError.style.display = 'block';
                            serverSuccess.style.display = 'none';
                        }
                    })
                    .catch(function(error) {
                        serverError.textContent = 'There was an error. Please try again.';
                        serverError.style.display = 'block';
                        serverSuccess.style.display = 'none';
                        console.error(error);
                    });
            });
        });
    </script>
    <script src="../Sidebar/main.js"></script>
</body>
</html>


                