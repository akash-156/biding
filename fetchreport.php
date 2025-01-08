<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "auctiondb";

$conn = new mysqli($host, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch reports from the reports table
$sql = "SELECT * FROM reports";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Report</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg,rgba(248, 245, 250, 0),rgb(238, 234, 239));
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .navbar {
            background: linear-gradient(135deg, #6a0dad, #d506f0);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .navbar h1 {
            margin: 0 auto;
            font-size: 1.8em;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background: linear-gradient(135deg, #6a0dad, #d506f0);
            padding-top: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            color: white;
            display: block;
            font-size: 1.1em;
            border-left: 3px solid transparent;
            transition: all 0.3s ease-in-out;
        }

        .sidebar a:hover {
            background: #483d8b;
            border-left: 3px solid #fff;
            border-radius: 5px;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            color: #333;
        }

        .report-table th, .report-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .report-table th {
            background-color: #6a0dad;
            color: white;
        }

        .report-table tr:hover {
            background-color: #f1f1f1;
        }

        h2 {
            color: #fff;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>User - Reports</h1>
</div>

<div class="sidebar">
    <a href="adminhome.php">Dashboard</a>
</div>

<div class="main-content">
    <h2>Reports</h2>
    <table class="report-table">
        <thead>
            <tr>
                <th>Report ID</th>
                <th>User ID</th>
                <th>User Name</th>
                <th>Report Content</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['userid'] . "</td>
                            <td>" . $row['username'] . "</td>
                            <td>" . $row['report_content'] . "</td>
                            <td>" . $row['created_at'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No reports found</td></tr>";
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
