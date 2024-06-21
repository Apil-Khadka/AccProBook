<!DOCTYPE html>
<html>
<head>
    <title>Form in Table</title>
    <link rel="stylesheet" href="staffs.css">
    <link rel="stylesheet" href="../Sidebar/styles.css">
</head>
<body id="body-pd" class="body-pd">
<?php
include_once("../Sidebar/sidebar.html");
?>    
<h3>Staff List</h3>
    <form id="dataForm" >
        <table id="dataTable">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody id="dataBody">
                <tr>
                    <th>1</th>
                    <td><input type="text" name="username" required></td>
                    <td><input type="email" name="email" required></td>
                    <td><input type="text" name="address" required></td>
                </tr>
            </tbody>
        </table>
        <div style="text-align: center; margin-top: 10px;">
             <button
             onclick="addData()"
             >Submit</button>
        </div>
    </form>

    <script>
        let rowCount = 1;

        function addData() {
            const form = document.forms['dataForm'];
            const username = form['username'].value;
            const email = form['email'].value;
            const address = form['address'].value;

            if (username && email && address) {
                rowCount++;
                const tableBody = document.getElementById('dataBody');
                const newRow = tableBody.insertRow();

                const cell1 = newRow.insertCell(0);
                const cell2 = newRow.insertCell(1);
                const cell3 = newRow.insertCell(2);
                const cell4 = newRow.insertCell(3);

                cell1.textContent = rowCount;
                cell2.textContent = username;
                cell3.textContent = email;
                cell4.textContent = address;

                // Clear the input fields after adding data
                form['username'].value = '';
                form['email'].value = '';
                form['address'].value = '';

                // Set focus back to the first input field
                form['username'].focus();
            } else {
                alert('Please fill out all fields.');
            }
        }
    </script>
    <script src="../Sidebar/main.js"></script>
    <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
</body>
</html>