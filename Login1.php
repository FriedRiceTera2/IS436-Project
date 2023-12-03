<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_username = $_POST['patient_username'];
    $patient_password = $_POST['patient_password'];

    // Establish a connection to the database (replace with your database credentials)
    $conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform the authentication
    $sql = "SELECT * FROM Patient WHERE Username = '$patient_username' AND Password = '$patient_password'";
    $result = $conn->query($sql);

    // Check if the authentication is successful
    if ($result->num_rows > 0) {
        // Authentication successful
        $_SESSION['patient_username'] = $patient_username; // Store username in the session
        $_SESSION['patient_id'] = $row['PatientID'];
        header("Location: patientdashboard.php");
        exit();
    } else {
        // Authentication failed
        echo "Invalid username or password for patients.";
        header("Location: Homepage.html");
        exit();
    }

    $conn->close();
}
?>
