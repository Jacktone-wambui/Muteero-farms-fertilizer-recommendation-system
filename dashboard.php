<?php
session_start();

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

// Retrieve user information from the database
function getUserInfo($conn, $userId) {
    $sql = "SELECT name, email FROM user WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    }

    return null;
}

// Update user information in the database
function updateUserInfo($conn, $userId, $name, $email, $password) {
    $sql = "UPDATE user SET name = '$name', email = '$email', password = '$password' WHERE user_id = $userId";
    return $conn->query($sql);
}

$userId = $_SESSION["user_id"];
$userInfo = getUserInfo($conn, $userId);

if ($userInfo === null) {
    echo "No user found";
    exit;
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Handle form submission for updating user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST["name"];
    $newEmail = $_POST["email"];
    $newPassword = $_POST["password"];
    
    if (updateUserInfo($conn, $userId, $newName, $newEmail, $newPassword)) {
        $message = "User information updated successfully";
        $userInfo["name"] = $newName;
        $userInfo["email"] = $newEmail;
    } else {
        $message = "Error updating user information: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .dashboard {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f2f2f2;
        }
        
        .main-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .main-content h1 {
            margin-top: 0;
        }

         .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .logout-btn {
            background-color: blue;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
            margin-right: 20px;
        }

        .logout-btn:hover {
            background-color: #555;
        }
        
        .links {
            display: flex;
            gap: 20px;
            flex-direction: column;
            margin-top: 20px;
        }

        .links a {
            background-color: #555;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .links a:hover {
            background-color: #777;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Welcome <?php echo $userInfo["name"]; ?></h1>
        <div class="dropdown">
            <img src="person-icon.png" alt="Person Icon">
            <div class="dropdown-content">
                <a href="#account-info">Account Information</a>
                <a href="#settings">Settings</a>
                <a href="?logout">Logout</a>
            </div>
        </div>
    </div>
    <div class="main-content">
        <h2>Fertilizer recommendation system</h2>
        <div class="links">
            <a href="">Collect Data</a>
            <a href="">Input data</a>
            <a href="">View Results</a>
        </div>
    </div>

    <div id="account-info" class="main-content">
        <h2>Account Information</h2>
        <p>Name: <?php echo $userInfo["name"]; ?></p>
        <p>Email: <?php echo $userInfo["email"]; ?></p>
    </div>

    <div id="settings" class="main-content">
        <h2>Settings</h2>
        <form method="post" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $userInfo["name"]; ?>"><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $userInfo["email"]; ?>"><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" value="Update">
        </form>
        <?php if (isset($message)) echo $message; ?>
    </div>
</body>
</html>
