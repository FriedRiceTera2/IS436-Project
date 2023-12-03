<?php
// Start a session
session_start();

// Check if the patient is logged in
if (!isset($_SESSION['patient_username'])) {
    // Redirect to the login page if not logged in
    header("Location: PatientLogin.php");
    exit();
}

// Establish a connection to the database (replace with your database credentials)
$conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch patient information based on the logged-in user's username
$patient_username = $_SESSION['patient_username'];
$sqlPatient = "SELECT PatientID FROM Patient WHERE Username = '$patient_username'";
$resultPatient = $conn->query($sqlPatient);

if ($resultPatient->num_rows > 0) {
    $rowPatient = $resultPatient->fetch_assoc();
    $patientID = $rowPatient['PatientID'];

    // Fetch Electronic Health Records for the patient
    $sqlEHR = "SELECT * FROM ElectronicHealthRecord WHERE PatientID = '$patientID'";
    $resultEHR = $conn->query($sqlEHR);

    // Check if the query was successful
    if ($resultEHR === false) {
        die("Error executing query: " . $conn->error);
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle the case where the patient's information is not found
    $conn->close();
    die("Error: Patient not found.");
}
?>
