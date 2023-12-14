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

// Retrieve user ID from the query parameter
$userID = $_GET['id'];

// Delete associated records in Visits table
/*$deleteVisitsQuery = "DELETE FROM Visits WHERE UserID = $userID";
$resultVisits = mysqli_query($conn, $deleteVisitsQuery);

if (!$resultVisits) {
    die("Error deleting Visits records: " . mysqli_error($conn));
}*/

// Assuming $userID is the ID of the user you want to delete
$deleteUserFeedbackQuery = "DELETE FROM UserFeedback WHERE UserID = $userID";
$resultUserFeedback = mysqli_query($conn, $deleteUserFeedbackQuery);

if (!$resultUserFeedback) {
    die("Error deleting UserFeedback records: " . mysqli_error($conn));
}

// Delete record from the User table
$deleteUserQuery = "DELETE FROM UserTB WHERE UserID=$userID";
$result = mysqli_query($conn, $deleteUserQuery);

// Check for query execution error
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Redirect to display_table.php
header("Location: display_table.php?selected_table=UserTB");
exit();

// Close the connection
mysqli_close($conn);
?>
