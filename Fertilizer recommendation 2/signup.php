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

// Define variables to store user input
$name = "";
$email = "";
$phone = "";
$password = "";
$cpassword = "";
$nameErr = $emailErr = $phoneErr = $passwordErr = $cpasswordErr = "";
$signupErr = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Username is required";
    } else {
        $name = $_POST["name"];
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = $_POST["email"];
    }

    // Validate phone
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone is required";
    } else {
        $phone = $_POST["phone"];
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    // Validate confirm password
    if (empty($_POST["cpassword"])) {
        $cpasswordErr = "Confirm Password is required";
    } else {
        $cpassword = $_POST["cpassword"];
    }

    // Insert the form data into the database
    if ($password === $cpassword) {
        $stmt = $conn->prepare("INSERT INTO farmers (name, email, phone, password, cpassword) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $password, $cpassword);

        if ($stmt->execute()) {
            
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $signupErr = "Passwords do not match.";
    }
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
        <h2>Sign up</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="name" value="<?php echo $name; ?>">
                <span class="error"><?php echo $nameErr; ?></span>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailErr; ?></span>
            </div>
            <div class="form-group">
                <label>Phone Number:</label>
                <input type="number" name="phone" value="<?php echo $phone; ?>">
                <span class="error"><?php echo $phoneErr; ?></span>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password">
                <span class="error"><?php echo $passwordErr; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="cpassword">
                <span class="error"><?php echo $cpasswordErr; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Signup" class="btn">
            </div>
        </form>
        <div class="error">
            <?php echo $signupErr; ?>
        </div>
        <div class="signup-link">
            Already having an account? <a href="login.php">Login</a>
        </div>
    </div>
</body>
</html>
    
       