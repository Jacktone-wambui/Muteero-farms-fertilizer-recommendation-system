<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "fertilizerrecommendation";

// Establish a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables to store user input
$email = "";
$password = "";
$emailErr = $passwordErr = "";
$loginErr = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = $_POST["email"];
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    // If there are no validation errors, proceed with login
    if (empty($emailErr) && empty($passwordErr)) {
        // Prepare a SQL statement to retrieve the user from the database
        $sql = "SELECT * FROM farmers WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);

        // Check if a user with the given email and password exists
        if ($result->num_rows == 1) {
            // Redirect to the dashboard page
            header("Location: dashboard.php");
            exit;
        } else {
            $loginErr = "Invalid email or password";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .form-group {
            margin: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group .error {
            color: red;
        }

        .form-group .btn {
            width: 30%;
            margin-left: 200px;
            margin-top: 20px;
            height: 40px;
            font-weight: bolder;
            font-size: large;
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

        .signup-link {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailErr; ?></span>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password">
                <span class="error"><?php echo $passwordErr; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Login" class="btn">
            </div>
        </form>
        <div class="error">
            <?php echo $loginErr; ?>
        </div>
        <div class="signup-link">
            Don't have an account? <a href="signup.php">Sign up</a>
        </div>
    </div>
</body>
</html>