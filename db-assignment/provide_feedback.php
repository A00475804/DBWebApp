<?php
$serverName = "dbcourse.cs.smu.ca";
$userName = "u09";
$password = "trueSTORYjune23";
$dbName = "u09";

// Enable error reporting for debugging
error_reporting(E_ALL);

$conn = mysqli_connect($serverName, $userName, $password, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process the feedback form submission
    $userId = trim($_POST['user_id']);
    $feedbackDate = $_POST['feedback_date'];
    $feedbackDescription = $_POST['feedback_description'];

    // Debugging statement
    echo "UserID: $userId<br>";

    // Check if the user exists before proceeding
    $userCheckQuery = "SELECT COUNT(*) FROM UserTB WHERE UserID = ?";
    $userCheckStmt = mysqli_prepare($conn, $userCheckQuery);
    mysqli_stmt_bind_param($userCheckStmt, "s", $userId);  // Assuming UserID is a string, change to "i" if it's an integer
    mysqli_stmt_execute($userCheckStmt);
    mysqli_stmt_bind_result($userCheckStmt, $userCount);
    mysqli_stmt_fetch($userCheckStmt);
    mysqli_stmt_close($userCheckStmt);

    // Debugging statement
    echo "User Count: $userCount<br>";

    if ($userCount > 0) {
        // User exists, proceed with inserting into UserFeedback
        $query = "INSERT INTO UserFeedback (UserID, FeedbackDate, FeedbackDescription) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sss", $userId, $feedbackDate, $feedbackDescription);  // Assuming FeedbackDate and FeedbackDescription are strings, change to "s" or "i" as needed

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Data inserted successfully
            echo "Data inserted successfully!";
        } else {
            // Error occurred
            echo "Error: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // User does not exist, handle accordingly
        echo "Error: User does not exist.";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provide Feedback</title>
    <!-- Add any additional styles if needed -->
</head>
<body>

    <h2>Provide Feedback</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">

        <!-- Add other form fields as needed -->
        <!-- For example, you can add a date picker and a textarea for feedback description -->

        <label for="feedback_date">Feedback Date:</label>
        <input type="date" id="feedback_date" name="feedback_date" required>

        <label for="feedback_description">Feedback Description:</label>
        <textarea id="feedback_description" name="feedback_description" rows="4" required></textarea>

        <input type="submit" value="Submit Feedback">
    </form>

</body>
</html>
