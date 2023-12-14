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

// Handle form submission to update the record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $userID = $_POST['user_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $contactInfo = $_POST['contact_info'];
    $experienceLevel = $_POST['experience_level'];
    $address = $_POST['address'];

    // Update data in the User table
    $updateUserQuery = "UPDATE UserTB SET Name='$name', Age=$age, ContactInformation='$contactInfo', DigitalExperienceLevel='$experienceLevel', Address='$address' WHERE UserID=$userID";
    $result = mysqli_query($conn, $updateUserQuery);

    // Check for query execution error
    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    // Redirect to display_table.php
    header("Location: display_table.php?selected_table=UserTB");
    exit();
}

// Retrieve user ID from the query parameter
$userID = $_GET['id'];

// Fetch user details for editing
$selectUserQuery = "SELECT * FROM UserTB WHERE UserID=$userID";
$userResult = mysqli_query($conn, $selectUserQuery);

// Check for query execution error
if (!$userResult) {
    die("Error: " . mysqli_error($conn));
}

// Fetch user data
$userData = mysqli_fetch_assoc($userResult);

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
</head>
<body>

    <h2>Edit Record</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="user_id" value="<?php echo $userID; ?>">

        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $userData['Name']; ?>" required><br>

        <label for="age">Age:</label>
        <input type="number" name="age" value="<?php echo $userData['Age']; ?>" required><br>

        <label for="contact_info">Contact Information:</label>
        <input type="text" name="contact_info" value="<?php echo $userData['ContactInformation']; ?>" required><br>

        <label for="experience_level">Digital Experience Level:</label>
        <input type="text" name="experience_level" value="<?php echo $userData['DigitalExperienceLevel']; ?>" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $userData['Address']; ?>" required><br>

        <input type="submit" value="Update Record">
    </form>

    <br>

    <a href="display_table.php?selected_table=UserTB">Back to User Table</a>

</body>
</html>
