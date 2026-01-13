<?php
//database connection file
require_once 'db_config.php';

$total_products = 0;
$all_products = array();
$error_message = "";

try {

    $sql = "SELECT COUNT(*) as total FROM product";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_products = $row['total'];

    // Get 5 most recent products
    $sql2 = "SELECT * FROM product ORDER BY created_at DESC LIMIT 5";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
    $all_products = $stmt2->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error_message = "Database Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #e9e9e9;
        }

        h1,
        h2,
        h3 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #999;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #999;
        }

        button,
        input[type="submit"] {
            padding: 8px 15px;
            border: 1px solid #666;
            background: #555;
            color: white;
            cursor: pointer;
        }

        a {
            color: #444;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .message {
            padding: 10px;
            border: 1px solid black;
            margin-bottom: 10px;
        }

        .navbar {
            background: #444;
            padding: 10px;
            margin-bottom: 20px;
        }

        .navbar a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .content {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .error {
            background: #d9d9d9;
            padding: 10px;
            border: 1px solid #888;
            margin-bottom: 15px;
            color: #333;
        }

        .stats-box {
            background: #d0d0d0;
            padding: 15px;
            border: 1px solid #aaa;
            margin-bottom: 20px;
            display: inline-block;
        }

        .stats-box p {
            font-size: 24px;
            font-weight: bold;
        }

        th {
            background: #bbb;
        }

        .empty-state {
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="inventory.php">Add Product</a>
    </div>


    <div class="content">
        <h1>Inventory Dashboard</h1>

        <!-- Show error  -->
        <?php if ($error_message != ""): ?>
            <div class="error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Statistics Box -->
        <div class="stats-box">
            <h3>Total Products</h3>
            <p><?php echo $total_products; ?></p>
        </div>

        <!-- Products Table -->
        <div class="products-table">
            <h2> 5 Most Recent Products</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Supplier</th>
                        <th>Description</th>
                        <th>Added Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($all_products) > 0) {
                        foreach ($all_products as $product) {
                            // Format date as DD-MM-YYYY
                            $formatted_date = date('d-m-Y', strtotime($product['created_at']));

                            echo "<tr>";
                            echo "<td><strong>#" . $product['id'] . "</strong></td>";
                            echo "<td class='product-name'>" . htmlspecialchars($product['product_name']) . "</td>";
                            echo "<td class='supplier'>" . htmlspecialchars($product['supplier_name']) . "</td>";
                            echo "<td class='description'>" . htmlspecialchars($product['item_description']) . "</td>";
                            echo "<td><span class='date-badge'>" . $formatted_date . "</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='empty-state'>No products found. Add some products first!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>