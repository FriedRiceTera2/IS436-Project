<?php


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve values from the form
    $bedID = $_POST['bed_id'];
    $newAvailability = $_POST['availability'];

    // Perform the update in the database
    // Replace this with your actual database update query
    $conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $updateQuery = "UPDATE Bed SET Availability = '$newAvailability' WHERE BedID = $bedID";
    $result = $conn->query($updateQuery);

    // Check if the query was successful
    if ($result) {
        // Redirect back to the beds.php page after the update is done
        header("Location: beds.php");
        exit();
    } else {
        // Display an error message if the query fails
        echo "Error updating bed availability: " . $conn->error;
    }

    $conn->close();
} else {
    // If the form is not submitted, redirect to the beds.php page
    header("Location: beds.php");
    exit();
}
?>
