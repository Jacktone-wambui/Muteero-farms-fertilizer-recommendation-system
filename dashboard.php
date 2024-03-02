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
$adminId = 6; 
$sql = "SELECT name FROM user WHERE user_id = $adminId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $adminName = $row["name"];
} else {
    echo "No admin found with the given ID";
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
        <h1>Welcome <?php echo $adminName; ?></h1>
        <a href="../index.html" class="logout-btn">Logout</a>
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