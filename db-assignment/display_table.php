<?php
$serverName = "dbcourse.cs.smu.ca";
$userName = "u09";
$password = "trueSTORYjune23";
$dbName = "u09";

$conn = mysqli_connect($serverName, $userName, $password, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$editableTables = array("UserTB");

$selectedTable = '';
$result = null;

if (isset($_POST['show_table'])) {
    $selectedTable = $_POST['selected_table'];
} elseif (isset($_GET['selected_table'])) {
    $selectedTable = $_GET['selected_table'];
}

if (!empty($selectedTable)) {
    $result = mysqli_query($conn, "SELECT * FROM $selectedTable");

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Data</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-column a {
            color: #3498db;
            text-decoration: none;
            margin-right: 10px;
        }

        .action-column a:hover {
            text-decoration: underline;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="index.php">Home</a>
    </div>

    <h2>Table Data</h2>

    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<h2>Contents of $selectedTable:</h2>";
        echo "<table>";
        $row = mysqli_fetch_assoc($result);
        echo "<tr>";
        foreach ($row as $column => $value) {
            echo "<th>$column</th>";
        }
        echo "<th>Action</th>"; 
        echo "</tr>";

        mysqli_data_seek($result, 0);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($row as $column => $value) {
                echo "<td>$value</td>";
            }

            if (in_array($selectedTable, $editableTables)) {
                echo "<td class='action-column'>";
                echo "<a href='edit.php?id={$row['UserID']}'>Edit</a>";
                echo "<a href='delete.php?id={$row['UserID']}'>Delete</a>";
                echo "<a href='provide_feedback.php?user_id={$row['UserID']}'>Provide Feedback</a>";
                echo "</td>";
            }

            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No data found in $selectedTable.";
    }

    mysqli_free_result($result);
    ?>

    <br>

    <?php
    if (!empty($selectedTable) && in_array($selectedTable, $editableTables)) {
        echo "<a href='create.php?table=$selectedTable'>Add New Record</a><br>";
    }
    ?>

</body>
</html>
