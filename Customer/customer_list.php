<?php
include_once("../Config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <link rel="stylesheet" href="../Sidebar/styles.css">
    <link rel="stylesheet" href="../CSS/bootstrap_css.css">


</head>
<body id="body-pd"  class="body-pd">
<?php
include_once("../Sidebar/sidebar.html");
?>
<div class="contain">

<h2>Customer List</h2>
<div class='table-responsive'>
    <table class='table table-bordered table-sm'>
        <thead class='thead-light'>
        <tr>
            <th class='p-2'>Id</th>
            <th class='p-2'>Name</th>
            <th class='p-2'>Email</th>
            <th class='p-2'>Phone</th>
            <th class='p-2'>Address</th>
            <th class='p-2'>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM Customer where user_id= :user_id ORDER BY customer_id DESC";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $customer = $stmt->fetchAll(PDO::FETCH_ASSOC);
        try {
            $result = $customer;
            if (count($result) > 0) {
                foreach ($result as $data) {
                    echo '
                    <tr>
                        <td class="p-2">'.htmlspecialchars($data['customer_id']).'</td>
                        <td class="p-2">'.htmlspecialchars($data['firstname'] .' '. $data['lastname']).'</td>
                        <td class="p-2">'.htmlspecialchars($data['email']).'</td>
                        <td class="p-2">'.htmlspecialchars($data['phone']).'</td>
                        <td class="p-2">'.htmlspecialchars($data['street'].', '.$data['city'].', '. $data['country']).'</td>
                        <td class="p-2">
                            <a href="summary_customer.php?customer_id='.htmlspecialchars($data['customer_id']).'" class="btn btn-info btn-sm">View</a>
                            <a href="delete_customer.php?customer_id='.htmlspecialchars($data['customer_id']).'" class="btn btn-danger btn-sm" onclick="return confirmDelete()">Delete</a>
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
</div>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this customer? All related data will be permanently removed.");
    }
</script>
<script src="../Sidebar/main.js"></script>
</body>
</html>
