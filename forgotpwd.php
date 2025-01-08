<?php
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "auctiondb";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname,3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Step 1: Handle the form for entering email
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_email'])) {
    $email = $_POST['email'];

    if (!empty($email)) {
        // Check if email exists in the database
        $sql = "SELECT EmailID FROM signup WHERE EmailID = ?"; // Use EmailID as column name
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Email found, proceed to password reset step
            $message = "Email verified! Please reset your password.";
            $email_verified = true; // Flag to show reset form
        } else {
            $message = "Email not found!";
        }

        $stmt->close();
    } else {
        $message = "Please enter your email!";
    }
}

// Step 2: Handle password reset
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_password'])) {
    $email = $_POST['email']; // Hidden field to pass email
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($new_password) && !empty($confirm_password)) {
        if ($new_password === $confirm_password) {
            // Store password as plain text (no hashing)
            $sql = "UPDATE signup SET password = ? WHERE EmailID = ?"; // Use EmailID as column name
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $new_password, $email);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $message = "Password has been successfully reset! You can now log in.";
            } else {
                $message = "Failed to reset password! Please try again.";
            }

            $stmt->close();
        } else {
            $message = "Passwords do not match!";
        }
    } else {
        $message = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f5ff; /* Light lavender background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for the whole form section */
        .container {
            width: 100%;
            max-width: 420px;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            text-align: center;
            border: 1px solid #dcd0f7; /* Light purple border */
        }

        /* Heading style */
        h2 {
            color: #6a0dad; /* Deep purple */
            font-size: 2rem;
            margin-bottom: 10px;
        }

        /* Message styling for success/error */
        p {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 20px;
            color: #9b59b6; /* Medium purple */
        }

        /* Form styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Input fields styling */
        input[type="email"], input[type="password"] {
            padding: 14px;
            margin: 10px 0;
            border: 1px solid #c1a1e8; /* Lavender border */
            border-radius: 8px;
            font-size: 1em;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #8e44ad; /* Rich purple */
            outline: none;
        }

        /* Button styling */
        button[type="submit"] {
            padding: 14px;
            background-color: #8e44ad; /* Rich purple */
            color: white;
            font-size: 1.1em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #5e3370; /* Darker purple */
        }

        /* Styling for additional form elements */
        label {
            font-size: 1.1em;
            color: #555;
            align-self: flex-start;
            margin-bottom: 5px;
        }

        .footer-text {
            margin-top: 15px;
            font-size: 1rem;
            color: #999;
        }

        .footer-text a {
            text-decoration: none;
            color: #6a0dad; /* Deep purple link */
            font-weight: bold;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        /* Error message styling */
        p.style-error {
            color: red;
        }

        /* Adjust the layout for responsiveness */
        @media screen and (max-width: 600px) {
            .container {
                width: 85%;
                padding: 20px;
            }

            h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forget Password</h2>
        <p><?php echo $message; ?></p>

        <!-- Step 1: Enter Email -->
        <?php if (empty($email_verified) && !isset($_POST['reset_password'])) { ?>
            <form method="POST" action="">
                <label for="email">Enter Your Email:</label>
                <input type="email" id="email" name="email" required>
                <br><br>
                <button type="submit" name="submit_email">Verify Email</button>
            </form>

        <!-- Step 2: Reset Password -->
        <?php } else { ?>
            <form method="POST" action="">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <button type="submit" name="reset_password">Reset Password</button>
            </form>
        <?php } ?>

        <!-- Footer text for user navigation (optional) -->
        <div class="footer-text">
            <p>Remembered your password? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
