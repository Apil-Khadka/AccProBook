<?php
include_once("../Config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Accounts</title>
    <link rel="stylesheet" href="../Sidebar/styles.css">
    <link rel="stylesheet" href="productlist.css">
</head>
<body class="h-full bg-light body-pd" id="body-pd">
<?php
include_once("../Sidebar/sidebar.html");
?>
 <h2>CRM Accounts</h2>
<div class='table-responsive'>
    <table class='table table-bordered table-sm'>
        <thead class='thead-light'>
        <tr>
            <th class='p-2'>Id</th>
            <th class='p-2'>Name</th>
            <th class='p-2'>Price</th>
            <th class='p-2'>Description</th>
            <th class='p-2'>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try{
            $user_id = $_SESSION['user_id'];
            $query = "SELECT * FROM Product where user_id= :user_id ORDER BY product_id DESC";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            echo '<tr><td colspan="6" class="text-center">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
        }
        try {
            if (count($product) > 0) {
                foreach ($product as $data) {
                    echo '
                    <tr>
                        <td class="p-2">'.htmlspecialchars($data['product_id']).'</td>
                        <td class="p-2">'.htmlspecialchars($data['productName']).'</td>
                        <td class="p-2">'.htmlspecialchars($data['productPrice']).'</td>
                        <td class="p-2">'.htmlspecialchars($data['productDescription']).'</td>
                        <td class="p-2">
                            <a href="summary_product.php?product_id='.htmlspecialchars($data['product_id']).'" class="btn btn-info btn-sm">View</a>
                            <a href="delete.php?product_id='.htmlspecialchars($data['product_id']).'" class="btn btn-danger btn-sm">Delete</a>
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

</body>
</html>
