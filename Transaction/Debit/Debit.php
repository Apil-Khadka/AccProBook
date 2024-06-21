<?php
include_once("../../Config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Debit</title>
    <link rel="stylesheet" href="Debit.css">
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
        <div class="new-deposits">
         <h2>New Debit</h2>
            <form id="debit-form" method="post" action="Debitback.php">
                <div class="form-group">
                    <label for="clientSelect">Client Name</label>
                    <select id="clientSelect" name="client" class="form-control" required>
                        <option value="">Select a client</option>
                    </select>
                </div>
        <div class="form group">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" value="2024-06-09">
        </div>
        <div class="form group">
            <label for="description">Description</label>
            <input type="text" id="description" name="description">
        </div>
        <div class="form group">
            <label for="amount">Amount</label>
            <input type="number" id="amount" name="amount">
        </div>
        <button type="submit">Submit</button>
                <span id="successMessage"></span>
                <span id="errorMessage"></span>
    </form>
    </div>
    <div class="recent-deposits">
        <h2>Recent Debits</h2>
        <table>
            <thead >
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody id="recent-deposits-body">
            <?php
            $totalDebit=0;
            include_once("../../API/Fetch/fetch_debit.php");
            try {
                if (count($debit) > 0) {
                    foreach ($debit as $data) {
                        $totalDebit += $data['debit_Amount'];
                        echo '
                    <tr>
                    <td class="p-2">'.htmlspecialchars($data['debit_Date']).'</td>
                    <td class="p-2">'.htmlspecialchars($data['debit_Amount']).'</td>
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
        <div id="totalDebit">Total Debit: <?php echo $totalDebit; ?></div>
     </div>
 </div>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        let successMessage = document.getElementById('successMessage');
        let errorMessage = document.getElementById('errorMessage');

        axios.get('../../API/Fetch/fetch_client.php')
            .then(response => {
                const clients = response.data;
                const clientSelect = document.getElementById('clientSelect');
                if (clients.length === 0) {
                    alert('No clients found. Add a customer or company.');
                } else {
                    clients.forEach(client => {
                        const option = document.createElement('option');
                        option.value = `${client.type}-${client.id}`;
                        option.textContent = `${client.name} (${client.type})`;
                        clientSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching clients:', error);
            });

        const creditForm = document.getElementById('debit-form');
        creditForm.addEventListener('submit', function(event) {
            event.preventDefault();
            successMessage.textContent = '';
            errorMessage.textContent = '';
            const formData = new FormData(creditForm);
            axios.post('Debitback.php', formData)
                .then(response => {
                    if(response.data.success) {
                        successMessage.textContent = response.data.message;
                        successMessage.style.display = 'block';
                        errorMessage.style.display = 'none';
                       location.reload();
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
<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
</body>
</html>