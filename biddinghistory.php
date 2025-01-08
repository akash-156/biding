<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password
$dbname = "auctiondb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT userid, product_id, name, phone, bid_amount, product_title,created_at
        FROM bids 
        WHERE name LIKE '%$search%' 
           OR product_title LIKE '%$search%' 
           OR phone LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Bids</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .navbar, .sidebar {
            background: linear-gradient(135deg, #6a0dad, #d506f0);
            color: white;
        }
        .navbar {
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
        }
        .navbar h1 {
            margin: 0 auto;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            padding-top: 20px;
            background: linear-gradient(135deg, #6a0dad, #d506f0);
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            color: white;
            display: block;
            font-size: 1.1em;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input[type="text"] {
            width: 80%;
            padding: 10px;
            border: 1px solid #6a0dad;
            border-radius: 5px;
        }
        .search-bar button {
            padding: 10px 15px;
            background-color: #6a0dad;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #d506f0;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .report-table th, .report-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        .report-table th {
            background: linear-gradient(135deg, #6a0dad, #d506f0);
            color: white;
        }
        .report-table tr:hover {
            background-color: #f4e8ff;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="adminhome.php">Dashboard</a>
    </div>
    <div class="main-content">
        <div class="navbar">
            <h1>Auction Bids</h1>
        </div>
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Bid Amount</th>
                    <th>Product Title</th>
                    <th>Bidding Time</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['userid']}</td>
                                <td>{$row['product_id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['bid_amount']}</td>
                                <td>{$row['product_title']}</td>
                                <td>{$row['created_at']}</td>

                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No results found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
