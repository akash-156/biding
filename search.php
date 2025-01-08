<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        /* Body and general styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
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
            color:rgb(241, 241, 241);
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
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="adminhome.php">Dashboard</a>
    </div>
    <div class="main-content">
        <div class="navbar">
            <h1>User Details</h1>
        </div>
        <form method="POST" action="">
            <input type="text" name="user_id" placeholder="Enter User ID" required>
            <button type="submit">Search</button>
        </form>
        <div class="user-details">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
                // Database connection
                $servername = "localhost";
                $db_username = "root";
                $db_password = "";
                $dbname = "auctiondb";

                $conn = new mysqli($servername, $db_username, $db_password, $dbname, 3307);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $searched_user_id = $_POST['user_id'];

                // Fetch user details
                $user_sql = "SELECT id, first_name, last_name, EmailID, aadhaar_number, phonenumber, Address, username FROM signup WHERE id = ?";
                $user_stmt = $conn->prepare($user_sql);
                $user_stmt->bind_param("i", $searched_user_id);
                $user_stmt->execute();
                $user_result = $user_stmt->get_result();

                if ($user_result->num_rows > 0) {
                    $user_row = $user_result->fetch_assoc();
                    echo "<table>";
                    echo "<tr><th>ID</th><td>{$user_row['id']}</td></tr>";
                    echo "<tr><th>First Name</th><td>{$user_row['first_name']}</td></tr>";
                    echo "<tr><th>Last Name</th><td>{$user_row['last_name']}</td></tr>";
                    echo "<tr><th>Email</th><td>{$user_row['EmailID']}</td></tr>";
                    echo "<tr><th>Username</th><td>{$user_row['username']}</td></tr>";
                    echo "<tr><th>Address</th><td>{$user_row['Address']}</td></tr>";
                    echo "<tr><th>Phone Number</th><td>{$user_row['phonenumber']}</td></tr>";
                    echo "<tr><th>Aadhaar Number</th><td>{$user_row['aadhaar_number']}</td></tr>";
                    echo "</table>";
                } else {
                    echo "<p>User not found.</p>";
                }

                $conn->close();
            }
            ?>
        </div>
    </div>
</body>
</html>
