<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "auctiondb";

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in to submit a report.");
}

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $report_content = $_POST['report_content'];

    // Insert data into the database
    $insert_sql = "INSERT INTO reports (userid, username, report_content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("iss", $user_id, $user_name, $report_content);

    if ($stmt->execute()) {
        echo "<script>alert('Report submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error submitting report. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #6a0dad;
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 1.5rem;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input, textarea, button {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        textarea {
            resize: none;
        }
        button {
            background-color: #6a0dad;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #5a0cbd;
        }
        .back-btn {
            background-color: #ddd;
            color: #333;
            border: none;
            cursor: pointer;
            padding: 10px;
            text-align: center;
            font-size: 1rem;
            width: 100%;
        }
        .back-btn:hover {
            background-color: #bbb;
        }
    </style>
</head>
<body>
    <header>Submit Report</header>
    <div class="container">
        <form method="POST" action="">
            <label for="user_id">User ID</label>
            <input type="number" id="user_id" name="user_id" placeholder="Enter your ID" required>

            <label for="user_name">User Name</label>
            <input type="text" id="user_name" name="user_name" placeholder="Enter your name" required>

            <label for="report_content">Report Content</label>
            <textarea id="report_content" name="report_content" rows="5" placeholder="Write your report here" required></textarea>

            <button type="submit">Submit Report</button>
        </form>
        <button class="back-btn" onclick="window.history.back();">Back</button>
    </div>
</body>
</html>
