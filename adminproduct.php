<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "auctiondb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST actions for approving or rejecting products
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approve_product'])) {
        $product_id = $conn->real_escape_string($_POST['product_id']);
        $sql = "UPDATE productdescription SET Status = 'approved' WHERE id = '$product_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Product approved successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }

    if (isset($_POST['reject_product'])) {
        $product_id = $conn->real_escape_string($_POST['product_id']);
        $sql = "UPDATE productdescription SET Status = 'rejected' WHERE id = '$product_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Product rejected successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

// Fetch and filter products
$search_pending = isset($_GET['search_pending']) ? $conn->real_escape_string($_GET['search_pending']) : '';
$search_approved = isset($_GET['search_approved']) ? $conn->real_escape_string($_GET['search_approved']) : '';
$search_rejected = isset($_GET['search_rejected']) ? $conn->real_escape_string($_GET['search_rejected']) : '';

$sql_pending = "SELECT id, Product_name, userid, Bidding_starting_price, Date, Time, Product_description, Status 
                FROM productdescription 
                WHERE status = 'pending' AND (Product_name LIKE '%$search_pending%' OR userid LIKE '%$search_pending%')";
$result_pending = $conn->query($sql_pending);

$sql_approved = "SELECT id, Product_name, userid, Bidding_starting_price, Date, Time, Product_description, Status 
                 FROM productdescription 
                 WHERE status = 'approved' AND (Product_name LIKE '%$search_approved%' OR userid LIKE '%$search_approved%')";
$result_approved = $conn->query($sql_approved);

$sql_rejected = "SELECT id, Product_name, userid, Bidding_starting_price, Date, Time, Product_description, Status 
                 FROM productdescription 
                 WHERE status = 'rejected' AND (Product_name LIKE '%$search_rejected%' OR userid LIKE '%$search_rejected%')";
$result_rejected = $conn->query($sql_rejected);

// Convert results to arrays
$pending_products = $result_pending->fetch_all(MYSQLI_ASSOC);
$approved_products = $result_approved->fetch_all(MYSQLI_ASSOC);
$rejected_products = $result_rejected->fetch_all(MYSQLI_ASSOC);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Product Management</title>
    <style>
        /* Body and general styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            padding-top: 20px;
            position: fixed;
            height: 100%;
            top: 0;
            left: 0;
            border-radius: 0 12px 12px 0;
            color: #fff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #fff;
            font-size: 1.1em;
            font-weight: 500;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease-in-out;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #483d8b;
            border-left: 3px solid #fff;
            border-radius: 5px;
        }

        /* Main content styles */
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #6a0dad;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #6a0dad;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Button styles */
        .btn {
            display: inline-block;
            padding: 5px 10px;
            font-size: 1em;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-deactivate {
            background-color: #fbc02d;
        }

        .btn-activate {
            background-color: #4caf50;
        }

        .btn-delete {
            background-color: #d32f2f;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #6a0dad, #d506f0);
            color: #fff;
            margin-top: 30px;
            border-radius: 12px;
        }

        .navbar {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            padding: 15px 30px;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        .navbar h1 {
            font-size: 1.8em;
            font-weight: bold;
        }

        /* Search Bar Styles */
        form input[type="text"] {
            padding: 10px;
            font-size: 1em;
            width: 70%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            padding: 10px 15px;
            font-size: 1em;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1 style="color: white; margin-bottom:0;">Admin Dashboard</h1>
    </div>

    <div class="sidebar">
        <a href="adminhome.php">Dashboard</a>
    </div>

    <div class="main-content">
        <h1>Manage Seller Products</h1>

        <!-- Search and Display Pending Products -->
        <h2>Pending Products</h2>
        <form method="GET" style="margin-bottom: 20px;">
            <input type="text" name="search_pending" placeholder="Search pending products..." value="<?= htmlspecialchars($search_pending) ?>" />
            <button type="submit">Search</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>User ID</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($pending_products) > 0): ?>
                    <?php foreach ($pending_products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= htmlspecialchars($product['Product_name']) ?></td>
                            <td><?= htmlspecialchars($product['userid']) ?></td>
                            <td><?= htmlspecialchars($product['Bidding_starting_price']) ?></td>
                            <td><?= htmlspecialchars($product['Date']) ?></td>
                            <td><?= htmlspecialchars($product['Time']) ?></td>
                            <td><?= htmlspecialchars($product['Product_description']) ?></td>
                            <td><?= htmlspecialchars($product['Status']) ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" name="approve_product" class="action-btn approve">Approve</button>
                                </form>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" name="reject_product" class="action-btn reject">Reject</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align:center;">No pending products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Search and Display Approved Products -->
        <h2>Approved Products</h2>
        <form method="GET" style="margin-bottom: 20px;">
            <input type="text" name="search_approved" placeholder="Search approved products..." value="<?= htmlspecialchars($search_approved) ?>" />
            <button type="submit">Search</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>User ID</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($approved_products) > 0): ?>
                    <?php foreach ($approved_products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= htmlspecialchars($product['Product_name']) ?></td>
                            <td><?= htmlspecialchars($product['userid']) ?></td>
                            <td><?= htmlspecialchars($product['Bidding_starting_price']) ?></td>
                            <td><?= htmlspecialchars($product['Date']) ?></td>
                            <td><?= htmlspecialchars($product['Time']) ?></td>
                            <td><?= htmlspecialchars($product['Product_description']) ?></td>
                            <td><?= htmlspecialchars($product['Status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">No approved products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Search and Display Rejected Products -->
        <h2>Rejected Products</h2>
        <form method="GET" style="margin-bottom: 20px;">
            <input type="text" name="search_rejected" placeholder="Search rejected products..." value="<?= htmlspecialchars($search_rejected) ?>" />
            <button type="submit">Search</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>User ID</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($rejected_products) > 0): ?>
                    <?php foreach ($rejected_products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= htmlspecialchars($product['Product_name']) ?></td>
                            <td><?= htmlspecialchars($product['userid']) ?></td>
                            <td><?= htmlspecialchars($product['Bidding_starting_price']) ?></td>
                            <td><?= htmlspecialchars($product['Date']) ?></td>
                            <td><?= htmlspecialchars($product['Time']) ?></td>
                            <td><?= htmlspecialchars($product['Product_description']) ?></td>
                            <td><?= htmlspecialchars($product['Status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">No rejected products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        &copy; 2024 Admin Dashboard
    </div>
</body>
</html>
