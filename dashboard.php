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

$userId = $_SESSION["user_id"];
$sql = "SELECT name FROM user WHERE user_id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userName = $row["name"];
} else {
    echo "No UserName found";
    exit;
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
        <h1>Welcome <?php echo $userName; ?></h1>
       <div class="dropdown">
        <img src="person-icon.png" alt="Person Icon">
        <div class="dropdown-content">
            <a href="account.php">Account Information</a>
            <a href="settings.php">Settings</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="main-content">
    <h2>Fertilizer recommendation system</h2>
        <div class="links">
            <a href="data_collection.php">Collect Data</a>
            <a href="data_collection.php">Input data</a>
            <a href="results.php">View Results</a>
        </div>
    </div>
</body>
</html>
