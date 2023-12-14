<?php
$serverName = "dbcourse.cs.smu.ca";
$userName = "u09";
$password = "trueSTORYjune23";
$dbName = "u09";

// Establishes the connection
$conn = mysqli_connect($serverName, $userName, $password, $dbName);

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to get tables
function getTables($conn) {
    $tables = array();
    $result = mysqli_query($conn, "SHOW TABLES");

    if ($result !== false) {
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
        mysqli_free_result($result);
    }

    return $tables;
}

$tables = getTables($conn);

// Handle button click to show tables
if (isset($_POST['show_tables'])) {
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Tables</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e8eff1;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h2 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 15px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            margin-bottom: 10px;
            padding: 12px 15px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 25px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        select, input[type=submit] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type=submit] {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type=submit]:hover {
            background-color: #2980b9;
        }

        .run-report-btn {
            background-color: #27ae60;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
    // Display tables if available
    if (!empty($tables)) {
        echo "<h2>Tables in the Database:</h2>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";

        // Form to select table
        echo "<form method='post' action='display_table.php'>";
        echo "<label for='selected_table'>Select a table to view:</label>";
        echo "<select name='selected_table'>";
        foreach ($tables as $table) {
            echo "<option value='$table'>$table</option>";
        }
        echo "</select>";
        echo "<input type='submit' name='show_table' value='Show Table'>";
        echo "</form>";

        // Button to open and run Sus_report.php
        echo "<form method='post' action='Sus_report.php'>";
        echo "<input type='submit' name='run_sus_report' value='Run Suspicion Report' class='run-report-btn'>";
        echo "</form>";
    }
    ?>

</body>
</html>
