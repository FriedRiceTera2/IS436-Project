<?php
$conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

// Check if the form is submitted for update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Retrieve values from the form
    $appointmentID = $_POST['appointmentID'];
    $status = $_POST['status'];
    $purpose = $_POST['purpose'];
    $appointmentDateTime = date('Y-m-d H:i:s', strtotime($_POST['appointmentDateTime']));

    // Perform the update in the database
    // Replace this with your actual database update query
    $conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $updateQuery = "UPDATE PatientAppointment SET Status = '$status', Purpose = '$purpose', AppointmentDateTime = '$appointmentDateTime' WHERE AppointmentID = $appointmentID";
    $result = $conn->query($updateQuery);

    // Check if the query was successful
    if ($result) {
        // Redirect back to the doctorappointments.php page after the update is done
        header("Location: doctorappointments.php");
        exit();
    } else {
        // Display an error message if the query fails
        echo "Error updating appointment: " . $conn->error;
    }

    $conn->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    // Check if the form is submitted for delete
    $deleteAppointmentID = $_POST['deleteAppointmentID'];

    // Perform the delete operation in the database
    // Replace this with your actual database delete query
    $conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $deleteQuery = "DELETE FROM PatientAppointment WHERE AppointmentID = $deleteAppointmentID";
    $result = $conn->query($deleteQuery);

    // Check if the query was successful
    if ($result) {
        // Redirect back to the doctorappointments.php page after the delete is done
        header("Location: doctorappointments.php");
        exit();
    } else {
        // Display an error message if the query fails
        echo "Error deleting appointment: " . $conn->error;
    }

    $conn->close();
} else {
    // If the form is not submitted, redirect to the doctorappointments.php page
    header("Location: doctorappointments.php");
    exit();
}
?>
