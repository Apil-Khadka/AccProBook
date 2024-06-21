<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../../Sidebar/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Karla&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            font-family: karla;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .container {
            background-color: white;
            padding: 20px;
            width: 50%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label,
        input {
            margin-bottom: 15px;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            border: none;
            background-color: #202557;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #262779;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
            display: none;

        }
        .success-message {
            color: green;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
            display: none;
        }

        .companyName {
            margin-right: 50px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #202557;
            font-size: 50px;
        }

        .logo {
            width: 300px;
            height: 300px;
        }

    </style>
</head>

<body id="body-pd" class="body-pd">
<?php
include_once("../../Sidebar/sidebar.html");
?>
<div>
    <img class="logo" src="star_sparkle_stars_sparkles_icon_new.png" alt="">
</div>

<div class="companyName">PROBOOK</div>
<div class="container">
    <form id="loginForm">
        <h2>Sign up User for your Organization </h2>
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName"  required>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <span id="emailError" class="error-message"></span>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
        <span id="passwordError" class="error-message"></span>

        <button type="submit">Submit</button>
    </form>
</div>
<span id="serverError" class="error-message"></span>
<span id="serverSuccess" class="success-message"></span>
<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirmPassword').value;

        let emailError = document.getElementById('emailError');
        let passwordError = document.getElementById('passwordError');
        let serverError = document.getElementById('serverError');
        let serverSuccess = document.getElementById('serverSuccess');

        // Reset error messages
        emailError.textContent = '';
        passwordError.textContent = '';
        serverError.textContent = '';
        serverSuccess.textContent = '';

        // Client-side validation
        if (!validateEmail(email)) {
            emailError.textContent = 'Please enter a valid email address.';
            return;
        }

        if (password.length < 7) {
            passwordError.textContent = 'Password must be at least 7 characters long.';
            return;
        }

        if (password !== confirmPassword) {
            passwordError.textContent = 'Passwords must match.';
            return;
        }

        const formData = new FormData(this);
        // Axios POST request
        axios.post('../../API/Insert/insert_users.php', formData)
            .then(function(response) {
                if (response.data.success) {
                    // Display success message to the user
                    serverSuccess.textContent = response.data.message;
                    serverError.style.display = 'none';
                    serverSuccess.style.display = 'block';
                } else {
                    // Display error message to the user
                    serverError.textContent = response.data.message;
                    serverSuccess.style.display = 'none';
                    serverError.style.display = 'block';
                }
            })
            .catch(function(error) {
                // Log any error
                console.error(error);
                // Display error message to the user
                serverError.textContent='There was an error submitting the form.';
            });
    });

    function validateEmail(email) {
        let re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
</script>
<script src="../../Sidebar/main.js"></script>

</body>
</html>