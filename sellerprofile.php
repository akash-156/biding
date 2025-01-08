<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection details
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'auctiondb';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname,3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the logged-in user's ID from the session
$id = $_SESSION['user_id'];

// Update user data in the database if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Allowed fields to prevent arbitrary updates
    $allowedFields = [
        'first_name',
        'last_name',
        'gender',
        'EmailID',
        'phonenumber',
        'aadhaar_number',
        'Address',
        'username',
        'password',
        'confirmpassword',
        'usertype',
        'date_of_birth',
    ];

    $field = $_POST['field'];
    $value = $_POST['value'];

    // Check if the field is allowed
    if (in_array($field, $allowedFields)) {
        $field = $conn->real_escape_string($field);
        $value = $conn->real_escape_string($value);

        // Update query
        $updateSql = "UPDATE signup SET $field = '$value' WHERE id = $id";
        if ($conn->query($updateSql) === TRUE) {
            echo json_encode(['status' => 'success', 'updated_value' => $value]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid field.']);
    }
    exit();
}

// Fetch user details from the signup table
$sql = "SELECT first_name, last_name, gender, EmailID, phonenumber, aadhaar_number, Address, username, password, confirmpassword, usertype, date_of_birth FROM signup WHERE id = $id";
$result = $conn->query($sql);
$userData = $result && $result->num_rows > 0 ? $result->fetch_assoc() : [];
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <!-- Font Awesome for icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', Arial, sans-serif;
      background-color: #f3f4f6;
      color: #333;
      line-height: 1.6;
    }

    .header {
      background-color: #6a1b9a;
      padding: 15px 0;
      text-align: center;
    }

    .header a {
      color: white;
      font-size: 18px;
      font-weight: bold;
      text-decoration: none;
      padding: 10px 20px;
      transition: background-color 0.3s;
    }

    .header a:hover {
      background-color: #541a73;
    }

    .container {
      margin: 20px auto;
      max-width: 1200px;
    }

    .profile-container {
      display: flex;
      flex-wrap: wrap;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .sidebar {
      flex: 1;
      max-width: 300px;
      background: #6a1b9a;
      color: #fff;
      padding: 30px 20px;
      text-align: center;
    }

    .sidebar img {
      border-radius: 50%;
      width: 100px;
      height: 100px;
      border: 4px solid #fff;
      margin-bottom: 15px;
    }

    .sidebar h2 {
      font-size: 1.5em;
      margin-bottom: 20px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar li {
      margin: 15px 0;
      font-size: 1em;
      color: #fff;
      font-weight: 500;
      cursor: pointer;
      transition: color 0.3s;
    }

    .sidebar li:hover {
      color: #d1c4e9;
    }

    .content {
      flex: 2;
      padding: 40px 30px;
    }

    .content h3 {
      font-size: 2em;
      margin-bottom: 20px;
      color: #6a1b9a;
    }

    .info-group {
      margin-bottom: 20px;
    }

    .info-group label {
      font-size: 1.1em;
      font-weight: 600;
      color: #555;
      margin-bottom: 5px;
      display: block;
    }

    .info-group span {
      font-size: 1.1em;
      color: #333;
    }

    .edit-input {
      display: none;
      margin-bottom: 10px;
      width: 100%;
      padding: 5px;
    }

    .edit-buttons {
      display: none;
    }

    .info-group button {
      padding: 5px 10px;
      background: #6a1b9a;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .info-group button:hover {
      background: #541a73;
    }

  </style>
</head>
<body>
  <div class="header">
    <a href="main.php">Home</a>
  </div>
  <div class="container">
    <div class="profile-container">
      <div class="sidebar">
        <h2>Hello, <?php echo htmlspecialchars($userData['first_name'] ?? 'User'); ?></h2>
      </div>
      <div class="content">
        <h3>Personal Information</h3>
        <?php foreach ($userData as $field => $value): ?>
        <div class="info-group">
          <label><?php echo ucfirst(str_replace('_', ' ', $field)); ?>:</label>
          <span class="display-value"><?php echo htmlspecialchars($value); ?></span>
          <input type="text" class="edit-input" data-field="<?php echo $field; ?>" value="<?php echo htmlspecialchars($value); ?>">
          <div class="edit-buttons">
            <button class="save-btn">Save</button>
            <button class="cancel-btn">Cancel</button>
          </div>
          <button class="edit-btn"><i class="fas fa-edit"></i></button>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <script>
    document.querySelectorAll('.info-group').forEach(group => {
      const editBtn = group.querySelector('.edit-btn');
      const saveBtn = group.querySelector('.save-btn');
      const cancelBtn = group.querySelector('.cancel-btn');
      const input = group.querySelector('.edit-input');
      const displayValue = group.querySelector('.display-value');
      const editButtons = group.querySelector('.edit-buttons');

      // Handle edit button click
      editBtn.addEventListener('click', () => {
        input.style.display = 'block';
        editButtons.style.display = 'block';
        displayValue.style.display = 'none';
        editBtn.style.display = 'none';
      });

      // Handle cancel button click
      cancelBtn.addEventListener('click', () => {
        input.style.display = 'none';
        editButtons.style.display = 'none';
        displayValue.style.display = 'inline-block';
        editBtn.style.display = 'block';
      });

      // Handle save button click
      saveBtn.addEventListener('click', () => {
        const field = input.getAttribute('data-field');
        const value = input.value;

        // Validation for each field before saving
        let isValid = true;
        let errorMessage = '';

        switch (field) {
          case 'EmailID':
            // Validate email
            const emailPattern = /@gmail\.com$/;
            if (!emailPattern.test(value)) {
              isValid = false;
              errorMessage = 'Please enter a valid email address.';
            }
            break;

          case 'phonenumber':
            // Validate phone number (only digits, 10 digits long)
            const phonePattern = /^\d{10}$/;
            if (!phonePattern.test(value)) {
              isValid = false;
              errorMessage = 'Phone number must be exactly 10 digits.';
            }
            break;

          case 'aadhaar_number':
            // Validate Aadhaar number (12 digits)
            const aadhaarPattern = /^\d{12}$/;
            if (!aadhaarPattern.test(value)) {
              isValid = false;
              errorMessage = 'Aadhaar number must be exactly 12 digits.';
            }
            break;

          case 'first_name':
          case 'last_name':
            // Validate name (letters only)
            const namePattern = /^[A-Za-z]+$/;
            if (!namePattern.test(value)) {
              isValid = false;
              errorMessage = 'Name can only contain letters.';
            }
            break;

          case 'username':
            // Validate username (letters and numbers, at least 3 characters)
            if (value.length < 3) {
              isValid = false;
              errorMessage = 'Username must be at least 3 characters long.';
            }
            break;

          case 'password':
            // Validate password (at least 6 characters)
            if (value.length < 6) {
              isValid = false;
              errorMessage = 'Password must be at least 6 characters long.';
            }
            break;

          case 'confirmpassword':
            // Check if password and confirm password match
            const password = document.querySelector('[data-field="password"]').value;
            if (value !== password) {
              isValid = false;
              errorMessage = 'Passwords do not match.';
            }
            break;

          case 'date_of_birth':
            // Validate date of birth (must be a valid date format)
            const dobPattern = /^\d{4}-\d{2}-\d{2}$/;
            if (!dobPattern.test(value)) {
              isValid = false;
              errorMessage = 'Please enter a valid date (YYYY-MM-DD).';
            }
            break;

          case 'Address':
            // Validate address (no special characters allowed)
            const addressPattern = /^[A-Za-z0-9\s,.-]+$/;
            if (!addressPattern.test(value)) {
              isValid = false;
              errorMessage = 'Address contains invalid characters.';
            }
            break;

          default:
            break;
        }

        // If validation fails, display an error message
        if (!isValid) {
          alert(errorMessage);
          return;
        }

        // If validation passes, proceed with updating the value
        fetch('', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({ field, value }),
        })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              displayValue.textContent = data.updated_value;
              input.style.display = 'none';
              editButtons.style.display = 'none';
              displayValue.style.display = 'inline-block';
              editBtn.style.display = 'block';
            } else {
              alert('Error updating field.');
            }
          });
      });
    });
  </script>
</body>
</html>
