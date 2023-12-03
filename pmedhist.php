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
$sqlPatient = "SELECT * FROM Patient WHERE Username = '$patient_username'";
$resultPatient = $conn->query($sqlPatient);

if ($resultPatient->num_rows > 0) {
    $rowPatient = $resultPatient->fetch_assoc();
    $patientID = $rowPatient['PatientID'];

    // Fetch Medical History for the patient
    $sqlMedicalHistory = "SELECT * FROM MedicalHistory WHERE PatientID = '$patientID'";
    $resultMedicalHistory = $conn->query($sqlMedicalHistory);

    // Check if the query was successful
    if ($resultMedicalHistory === false) {
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical History</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Hopkins Medical System</h1>
    </header>
    <nav>
        <ul>
            <li><a href="Homepage.html">Home</a></li>
            <li><a href="AboutPage.html">About</a></li>
            <li><a href="Contact.html">Contact</a></li>
         
            <li class="dropdown">
                <a href="#" class="dropbtn">Electronic Health Records</a>
                <div class="dropdown-content">
                    <a href="patientehr.php">Overview</a>
                    <a href="pmedhis.php">Medical History</a>
                    <a href="makeappointment.php">Make Appointment</a>
                    <!-- Add more pages as needed -->
                </div>
            </li>
        </ul>
    </nav>
    <section>
        <h2>Medical History</h2>
        <?php
        // Display patient information
        echo "<p>Welcome, " . $rowPatient['FirstName'] . " " . $rowPatient['LastName'] . "!</p>";

        // Display Medical History in a table
        if ($resultMedicalHistory->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Record ID</th><th>Visit Date</th><th>Condition</th><th>Prescription</th></tr>";
            while ($rowMedicalHistory = $resultMedicalHistory->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $rowMedicalHistory['RecordID'] . "</td>";
                echo "<td>" . $rowMedicalHistory['VisitDate'] . "</td>";
                echo "<td>" . $rowMedicalHistory['Conditions'] . "</td>";
                echo "<td>" . $rowMedicalHistory['Prescription'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No Medical History found.</p>";
        }
        ?>
    </section>
</body>
</html>
