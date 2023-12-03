<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the form data
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];
    $doctorID = $_POST['doctor'];
    $purpose = $_POST['purpose'];

    // You should add more validation as needed

    // Fetch patient ID based on the logged-in user's username
    $patient_username = $_SESSION['patient_username'];
    $conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");
    $sqlPatient = "SELECT PatientID FROM Patient WHERE Username = '$patient_username'";
    $resultPatient = $conn->query($sqlPatient);

    if ($resultPatient->num_rows > 0) {
        $rowPatient = $resultPatient->fetch_assoc();
        $patientID = $rowPatient['PatientID'];

        // Insert the appointment into the PatientAppointment table
        $sqlInsert = "INSERT INTO PatientAppointment (PatientID, DoctorID, AppointmentDateTime, Purpose) VALUES ('$patientID', '$doctorID', '$appointmentDate $appointmentTime', '$purpose')";
        
        if ($conn->query($sqlInsert) === TRUE) {
            echo "Appointment created successfully";
            header("Location: patientdashboard.php");
        } else {
            echo "Error: " . $sqlInsert . "<br>" . $conn->error;
        }
    } else {
        echo "Error: Patient not found.";
    }

    // Close the database connection
    $conn->close();
}
?>
