<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve values from the form
    $roomID = $_POST['room_id'];
    $newAvailability = $_POST['availability'];

    // Perform the update in the database
    // Replace this with your actual database update query
    $conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $updateQuery = "UPDATE OperatingRoom SET Availability = '$newAvailability' WHERE RoomID = $roomID";
    $result = $conn->query($updateQuery);

    // Check if the query was successful
    if ($result) {
        // Redirect back to the operatingrooms.php page after the update is done
        header("Location: operatingrooms.php");
        exit();
    } else {
        // Display an error message if the query fails
        echo "Error updating operating room availability: " . $conn->error;
    }

    $conn->close();
} else {
    // If the form is not submitted, redirect to the operatingroom.php page
    header("Location: operatingrooms.php");
    exit();
}
?>
