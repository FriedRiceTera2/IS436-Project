<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve values from the form
    $equipmentID = $_POST['equipment_id'];
    $newAvailability = $_POST['availability'];
    $newPatientID = $_POST['patient_id'];

    // Perform the update in the database
    // Replace this with your actual database update query
    $conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $updateQuery = "UPDATE MedicalEquipment SET Availability = '$newAvailability', InUseByPatientID = '$newPatientID' WHERE EquipmentID = $equipmentID";
    $result = $conn->query($updateQuery);

    // Check if the query was successful
    if ($result) {
        // Redirect back to the medicalequipment.php page after the update is done
        header("Location:medicalequipment.php");
        exit();
    } else {
        // Display an error message if the query fails
        echo "Error updating medical equipment: " . $conn->error;
    }

    $conn->close();
} else {
    // If the form is not submitted, redirect to the medicalequipment.php page
    header("Location:medicalequipment.php");
    exit();
}
?>
