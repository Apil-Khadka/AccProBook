
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="add-product.css">
    <link rel="stylesheet" href="../Sidebar/styles.css">
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

<div class="reg">
    <form id="registrationForm">
        <h2> Product Registration</h2>
        <label for="Name">Name</label>
        <input type="text" id="Name" name="Name" required placeholder="Enter product name"><br>

        <label for="Price">Price</label>
        <input type="number" id="Price" name="Price" placeholder="Enter amount" required><br>
        
        <label for="Description">Description</label>
        <input type="text" id="Description" name="Description" placeholder="Description"><br>
        
        <button type="submit">Register</button>
    </form>
        <span id="serverError" class="error-message"></span>
        <span id="serverSuccess" class="success-message"></span>
     </div>

    <script>
            document.getElementById('registrationForm').addEventListener('submit', function(event) {
                event.preventDefault();
                let serverError = document.getElementById('serverError');
                let serverSuccess= document.getElementById('serverSuccess');

                serverError.textContent ='';
                serverSuccess.textContent='';
                const formData = new FormData(this);
                axios.post('../API/Insert/insert_product.php', formData)
                    .then(function(response){
                        if(response.data.success){
                            serverSuccess.textContent=response.data.message;
                            serverSuccess.style.display='block';
                            serverError.style.display='none';
                        } else{
                            serverError.textContent=response.data.message;
                            serverError.style.display='block';
                            serverSuccess.style.display='none';
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting form:', error);
                        serverError.textContent = 'An error occurred. Please try again later.';
                    });
            });
    </script>

<script src="../Sidebar/main.js"></script>
<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>

</body>
</html>
