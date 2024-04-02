<!DOCTYPE html>
<html>
<head>
    <title>View History of Data Collected</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            border-collapse: collapse;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e9e9e9;
        }

        /* Navigation Bar Styles */
        .navbar {
            background-color: #333;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .navbar-logo {
            height: 40px;
        }

        .navbar-links {
            display: flex;
        }

        .navbar-links a {
            margin-right: 270px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }
        .navbar-links a.log {
            margin-right: 20px;
            text-decoration: none;
            color: blue;
            font-weight: bold;
        }

        .navbar-links a:hover {
            color: #ccc;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img src="logo.png" alt="Company Logo" class="navbar-logo">
        <div class="navbar-links">
            <a href="http://127.0.0.1:5000">Input Data</a>
            <a href="http://127.0.0.1:8080">Sensor Data</a>
            <a href="#">View History</a>
            <a class="log" href="index.html">Logout</a>
        </div>
    </div>

    <h1>View History of sensor Data Collected</h1>
    <table>
        <?php
        $file = fopen('C:\xampp\htdocs\Fertilizer/Fertilizer Prediction.csv', 'r');

        while (($row = fgetcsv($file)) !== false) {
            echo "<tr>";
            echo "<td>" . $row[0] . "</td>";
            echo "<td>" . $row[1] . "</td>";
            echo "<td>" . $row[2] . "</td>";
            echo "<td>" . $row[3] . "</td>";
            echo "<td>" . $row[4] . "</td>";
            echo "<td>" . $row[5] . "</td>";
            echo "<td>" . $row[6] . "</td>";
            echo "<td>" . $row[7] . "</td>";
            echo "<td>" . $row[8] . "</td>";
            echo "</tr>";
        }

        fclose($file);
        ?>
    </table>
</body>
</html>