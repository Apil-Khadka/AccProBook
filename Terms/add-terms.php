<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New credit</title>
    <link rel="stylesheet" href="terms.css">
    <link rel="stylesheet" href="../../Sidebar/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        #successMessage, #errorMessage {
            color: green;
            font-weight: bold;
            display: none;
            font-size: 20px;
        }

        #errorMessage {
            color: red;
        }
    </style>
</head>
<body id="body-pd" class="body-pd">
<?php
include_once("../../Sidebar/sidebar.html");
?>
    <div class="container">
        <div class="new-credits">
         <h2>New Terms</h2>
            <form id="terms-form" >
                <div class="form-group">
                  
        <div class="form-group">
            <label for="name">name</label>
            <input type="text" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="amount">terms</label>
            <input type="text" id="terms" name="terms">
        </div>
        <button type="submit">Submit</button>
         <span id="successMessage"></span>
         <span id="errorMessage"></span>
    </form>
    </div>
    <div class="recent-terms">
        <h2>Recent Terms</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Terms</th>
                </tr>
            </thead>
            <tbody id="recent-terms-body">
            <?php

            $totalCredit=0;
            include_once("../../Config/config.php");
            include_once("../../API/Fetch/fetch_credit.php");
            try {
                if (count($credit) > 0) {
                    foreach ($credit as $data) {
                        $totalCredit=$totalCredit+$data['credit_Amount'];
                        echo '
                    <tr>
                    <td class="p-2">'.htmlspecialchars($data['credit_Date']).'</td>
                    <td class="p-2">'.htmlspecialchars($data['credit_Amount']).'</td>
                        
                    </tr>';
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-center">No records found.</td></tr>';
                }
            } catch (PDOException $e) {
                echo '<tr><td colspan="6" class="text-center">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
            }
            ?>
            </tbody>
        </table>
     </div>
 </div>
<script>
    document.addEventListener("DOMcontentloaded", function(){
        let successMessage = document.getElementById('successMessage0');
        let errorMessage = document.getElementById('errorMessage');
        
        
    
      const creditForm = document.getElementById('terms-form');
        creditForm.addEventListener('submit', function(event) {
            event.preventDefault();
            successMessage.textContent = '';
            errorMessage.textContent = '';
            const formData = new FormData(creditForm);
            console.log(formData)
            axios.post('../API/Insert/insert_terms.php', formData)
                .then(response => {
                    if(response.data.success) {
                        console.log(response.data.message);
                        successMessage.textContent = response.data.message;
                        successMessage.style.display = 'block';
                        errorMessage.style.display = 'none';
                        
                    } else {
                        errorMessage.textContent = response.data.message;
                        successMessage.style.display = 'none';
                        errorMessage.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error creating credit:', error);
                    errorMessage.textContent = 'An error occurred. Please try again.';
                });
            });
        });
  
</script>
 <script src="../../Sidebar/main.js"></script>

</body>
</html>