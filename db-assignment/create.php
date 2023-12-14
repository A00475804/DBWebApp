<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Handle form submission to add a new record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $name = $_POST['name'];
    $age = $_POST['age'];
    $contactInfo = $_POST['contact_info'];
    $experienceLevel = $_POST['experience_level'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postalCode = $_POST['postal_code'];

    // Begin a transaction to ensure both queries are executed together
    mysqli_begin_transaction($conn);

    // Insert data into the UserTB table
    $insertUserQuery = "INSERT INTO UserTB (Name, Age, ContactInformation, DigitalExperienceLevel) VALUES (?, ?, ?, ?)";
    
    $stmtUser = mysqli_prepare($conn, $insertUserQuery);
    mysqli_stmt_bind_param($stmtUser, "siss", $name, $age, $contactInfo, $experienceLevel);
    $resultUser = mysqli_stmt_execute($stmtUser);

    // Check for query execution error
    if (!$resultUser) {
        mysqli_rollback($conn);
        die("Error inserting into UserTB: " . mysqli_error($conn));
    }

    // Get the last inserted UserID
    $lastUserID = mysqli_insert_id($conn);

    // Insert data into the AddressTB table
    $insertAddressQuery = "INSERT INTO AddressTB (UserID, Street, City, State, PostalCode) VALUES (?, ?, ?, ?, ?)";
    
    $stmtAddress = mysqli_prepare($conn, $insertAddressQuery);
    mysqli_stmt_bind_param($stmtAddress, "issss", $lastUserID, $street, $city, $state, $postalCode);
    $resultAddress = mysqli_stmt_execute($stmtAddress);

    // Check for query execution error
    if (!$resultAddress) {
        mysqli_rollback($conn);
        die("Error inserting into AddressTB: " . mysqli_error($conn));
    }

    // Commit the transaction if both queries succeed
    mysqli_commit($conn);

    // Redirect to display_table.php
    header("Location: display_table.php?selected_table=UserTB");
    exit();
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Record</title>
    <style>
        /* Your CSS styling remains unchanged */
    </style>
</head>
<body>

    <h2>Add New Record</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Note: No need to include UserID as it is auto-incremented and handled by the database -->
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="age">Age:</label>
        <input type="number" name="age" required><br>

        <label for="contact_info">Contact Information:</label>
        <input type="text" name="contact_info" required><br>

        <label for="experience_level">Digital Experience Level:</label>
        <input type="text" name="experience_level" required><br>

        <label for="street">Street:</label>
        <input type="text" name="street" required><br>

        <label for="city">City:</label>
        <input type="text" name="city"><br>

        <label for="state">State:</label>
        <input type="text" name="state"><br>

        <label for="postal_code">Postal Code:</label>
        <input type="text" name="postal_code"><br>

        <input type="submit" value="Add Record">
    </form>

    <br>

    <a href="display_table.php?selected_table=UserTB">Back to User Table</a>

</body>
</html>
