<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fertilizerrecommendation";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables to store form data
$email = $name = $location = $contactInfo = $password = "";

// Process the form data upon submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $email = sanitizeInput($_POST["email"]);
    $name = sanitizeInput($_POST["name"]);
    $location = sanitizeInput($_POST["location"]);
    $contactInfo = sanitizeInput($_POST["contactInfo"]);
    $password = $_POST["password"]; // Password should not be sanitized

    // Insert the form data into the database
    $sql = "INSERT INTO user (email, name, location, contactInfo,  password, cpassword)
            VALUES ('$email', '$name', '$location', '$contactInfo', '$password', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("location:login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to sanitize form inputs
function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 500px; /* Adjust the width as desired */
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
        }

        .form-group {
            display: table-row;
        }

        .form-group label,
        .form-group input {
            display: table-cell;
            padding: 8px;
        }

        .form-group .error {
            color: red;
        }

        .form-group .btn {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            border: none;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        .form-group .btn:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <table>
                <tr class="form-group">
                    <td><label>Email:</label></td>
                    <td><input type="text" name="email" value="<?php echo $email; ?>"></td>
                    
                </tr>
                <tr class="form-group">
                    <td><label>Name:</label></td>
                    <td><input type="text" name="name" value="<?php echo $name; ?>"></td>
                   
                </tr>
                <tr class="form-group">
                    <td><label>Location:</label></td>
                    <td><input type="text" name="location" value="<?php echo $location; ?>"></td>
                    
                </tr>
                <tr class="form-group">
                    <td><label>Contacts:</label></td>
                    <td><input type="text" name="contactInfo" value="<?php echo $contactInfo; ?>"></td>
                   
                </tr>
                 
                <tr class="form-group">
                    <td><label>Password:</label></td>
                    <td><input type="password" name="password"></td>
                   
                </tr>
                <tr class="form-group">
                    <td><label>Confirm Password:</label></td>
                    <td><input type="password" name="cpassword"></td>
                   
                </tr>
                <tr class="form-group">
                    <td></td>
                    <td><input type="submit" class="btn" value="Sign Up"></td>
                    <td></td>
                </tr>
            </table>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Log In</a></p>
        </div>
    </div>
</body>
</html>
    
       