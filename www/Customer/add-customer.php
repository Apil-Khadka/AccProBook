<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Karla&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.0.2/css/countrySelect.min.css">
    <link rel="stylesheet" href="customer.css">
    <link rel="stylesheet" href="../Sidebar/styles.css">
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
<div class="container">
    <form id="registrationForm">
        <h2>Add Customer</h2><br>
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" class="first" required>

        <label for="lastName" class="last">Last Name:</label>
        <input type="text" id="lastName" name="lastName" class="second" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="first" required>

        <label for="phone" class="last">Phone:</label>
        <input type="text" id="phone" name="phone" class="second" required>

        <label for="street">Street:</label>
        <input type="text" id="street" name="street" class="first">

        <label for="city" class="last">City:</label>
        <input type="text" id="city" name="city" class="second" required>

        <label for="state">State/Region:</label>
        <input type="text" id="state" name="state" class="first">

        <label for="postalcode" class="last">Postal Code:</label>
        <input type="text" id="postalcode" name="postalcode" class="second">

        <div class="name">
            <label for="country">Country:</label><br>
            <input type="text" id="country" name="country" required>
        </div>

        <button type="submit">Register</button>
        <span id="serverError" class="error-message"></span>
        <span id="serverSuccess" class="success-message"></span>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.0.2/js/countrySelect.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $("#country").countrySelect({
            defaultCountry: "np"
        });

        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let serverError = document.getElementById('serverError');
            let serverSuccess = document.getElementById('serverSuccess');

            serverError.textContent = '';
            serverSuccess.textContent = '';

            const formData = new FormData(this);

            axios.post('../API/Insert/insert_customer.php', formData)
                .then(function(response) {
                    if (response.data.success) {
                        serverSuccess.textContent = response.data.message;
                        serverError.style.display = 'none';
                        serverSuccess.style.display = 'block';
                    } else {
                        serverError.textContent = response.data.message;
                        serverSuccess.style.display = 'none';
                        serverError.style.display = 'block';
                    }
                })
                .catch(function(error) {
                    console.error('Error submitting form:', error);
                    serverError.textContent = 'An error occurred. Please try again later.';
                });
        });
    });
</script>
<script src="../Sidebar/main.js"></script>
</body>
</html>
