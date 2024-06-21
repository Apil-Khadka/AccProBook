<?php  require_once("../Config/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company List</title>
 <link rel="stylesheet" href="../Sidebar/styles.css">
    <link rel="stylesheet" href="../CSS/bootstrap_css.css">
</head>
<body id="body-pd" class="body-pd" >
<?php
include_once("../Sidebar/sidebar.html");
?>
<h2>Company List</h2>
<div >
    <table class='table table-bordered table-sm'>
        <thead class='thead-light'>
        <tr>
            <th class="p-2">Id</th>
            <th class="p-2">Name</th>
            <th class="p-2">Contact Person</th>
            <th class="p-2">Email</th>
            <th class="p-2">Phone Number</th>
            <th class="p-2">Landline Number</th>
            <th class="p-2">Address</th>
            <th class="p-2">URL</th>
            <th class="p-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try {
            $user_id = $_SESSION['user_id'];
            $query = "SELECT * FROM Company where user_id= :user_id ORDER BY company_id DESC";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $company = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            echo '<tr><td colspan="6" class="text-center">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
        }
        try {

            if (count($company) > 0) {
                foreach ($company as $data) {
                    echo '
                    <tr>
                        <td class="p-2">'.htmlspecialchars($data['company_id']).'</td>
                        <td class="p-2">'.htmlspecialchars($data['companyName'] ).'</td>
                        <td class="p-2">'.htmlspecialchars($data['contactName'] ).'</td>
                        <td class="p-2">'.htmlspecialchars($data['companyEmail']).'</td>
                        <td class="p-2">'.htmlspecialchars($data['phoneNumber']).'</td>
                        <td class="p-2">'.htmlspecialchars($data['landLineNumber']).'</td>
                         <td class="p-2">'.htmlspecialchars($data['companyAddress'].', '.$data['state'].', '.$data['country'] ).'</td>
                        <td class="p-2">'.htmlspecialchars($data['URL']).'</td>
                        <td class="p-2">
                            <a href="summary_company.php?company_id='.htmlspecialchars($data['company_id']).'" class="btn btn-info btn-sm">View</a>
                            <a href="delete_company.php?company_id='.htmlspecialchars($data['company_id']).'" class="btn btn-danger btn-sm" onclick="return confirmDelete()">Delete</a>
                        </td>
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

<script src="../Sidebar/main.js"></script>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this customer? All related data will be permanently removed.");
    }
</script>
</body>
</html>
