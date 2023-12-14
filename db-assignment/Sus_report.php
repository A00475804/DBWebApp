<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suspicious Reports Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f8f8f8;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        select {
            margin-bottom: 10px;
            width: 100%;
            padding: 8px;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .home-button {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            z-index: 1;
        }
		.home-button {
			position: fixed;
			top: 10px;
			right: 10px;
			padding: 10px 15px;
			background-color: rgba(52, 152, 219, 0.7); /* Adjust the alpha value (0.7) for transparency */
			color: white;
			text-decoration: none;
			border-radius: 4px;
			font-weight: bold;
			z-index: 1;
			}

		.home-button:hover {
			background-color: rgba(41, 128, 185, 0.7); /* Adjust the alpha value (0.7) for transparency */
		}


        .home-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<?php
$servername = "dbcourse.cs.smu.ca";
$username = "u09";
$password = "trueSTORYjune23";
$dbname = "u09";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected risk level from the form
    $selectedRiskLevel = isset($_POST["risk_level"]) ? $_POST["risk_level"] : null;

    // Prepare and execute the SQL query without RiskLevel condition
    $sql = "SELECT
                sr.ReportDate,
                sr.Description AS ReportDescription,
                sr.ActionTaken,
                w.URL AS WebsiteURL,
                w.WebsiteName,
                w.Description AS WebsiteDescription,
                w.DetectionDate AS WebsiteDetectionDate,
                wp.WebpageURL,
                u.UserID,
                u.Name AS UserName,
                u.ContactInformation,
                u.DigitalExperienceLevel,
                uf.FeedbackDescription
            FROM
                SuspicionReport sr
            INNER JOIN
                Website w ON sr.WebsiteID = w.WebsiteID
            LEFT JOIN
                Webpage wp ON sr.WebpageID = wp.WebpageID
            LEFT JOIN
                UserTB u ON sr.UserID = u.UserID
            LEFT JOIN
                UserFeedback uf ON u.UserID = uf.UserID
            ORDER BY
                sr.ReportDate DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Default query without filtering by risk level
    $result = $conn->query("SELECT * FROM SuspicionReport ORDER BY ReportDate DESC");
}

?>

<h1>Suspicious Reports Dashboard</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="risk_level">Select Risk Level:</label>
    <select name="risk_level">
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
    </select>
    <button type="submit">Filter Reports</button>
</form>

<?php
// Display the results in a table
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Report Date</th><th>Report Description</th><th>Action Taken</th><th>Website URL</th><th>Website Name</th><th>Website Description</th><th>Website Detection Date</th><th>Webpage URL</th><th>User ID</th><th>User Name</th><th>Contact Information</th><th>Digital Experience Level</th><th>User Feedback</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['ReportDate']}</td>";
        echo "<td>{$row['ReportDescription']}</td>";
        echo "<td>{$row['ActionTaken']}</td>";
        echo "<td>{$row['WebsiteURL']}</td>";
        echo "<td>{$row['WebsiteName']}</td>";
        echo "<td>{$row['WebsiteDescription']}</td>";
        echo "<td>{$row['WebsiteDetectionDate']}</td>";
        echo "<td>{$row['WebpageURL']}</td>";
        echo "<td>{$row['UserID']}</td>";
        echo "<td>{$row['UserName']}</td>";
        echo "<td>{$row['ContactInformation']}</td>";
        echo "<td>{$row['DigitalExperienceLevel']}</td>";
        echo "<td>{$row['FeedbackDescription']}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No results found.";
}

// Close the connection
$conn->close();
?>

<a class="home-button" href="index.php">Home</a>

</body>
</html>
