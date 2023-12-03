<?php
// Start or resume session
session_start();

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_username'])) {
    // Redirect to the login page if not logged in
    header("Location:DoctorLogin.php");
    exit();
}

// Include database connection code here

// Fetch doctor-assigned appointments and patient-made appointments from the database
// Replace this with your actual database connection and query
$conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctorUsername = $_SESSION['doctor_username'];

// Query for doctor-assigned appointments
$doctorAppointmentsQuery = "SELECT * FROM PatientAppointment WHERE DoctorID = (SELECT DoctorID FROM Doctor WHERE Username = '$doctorUsername')";

$doctorResult = $conn->query($doctorAppointmentsQuery);

// Check if the query was successful
if (!$doctorResult) {
    die("Error executing the query: " . $conn->error);
}

// Query for patient-made appointments
$patientAppointmentsQuery = "SELECT * FROM PatientAppointment WHERE DoctorID IS NULL";

$patientResult = $conn->query($patientAppointmentsQuery);

// Check if the query was successful
if (!$patientResult) {
    die("Error executing the query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointments</title>
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
                <a href="#" class="dropbtn">Resource Allocation</a>
                <div class="dropdown-content">
                    <a href="beds.php">Beds</a>
                    <a href="operatingrooms.php">Operating Rooms</a>
                    <a href="medicalequipment.php">Medical Equipment</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Electronic Health Records</a>
                <div class="dropdown-content">
                    <a href="ehr.php">Overview</a>

                    <!-- Add more pages as needed -->
                </div>
            </li>
             <li><a href="doctorappointments.php">Appointments</a></li>
        
       
        </ul>
    </nav>
   <section>
        <h2>Doctor Appointments</h2>
        <!-- Display doctor-assigned and patient-made appointments information with inline edit form -->
        <h3>Doctor-Assigned Appointments</h3>
        <table>
            <thead>
                <tr>
                    <th>AppointmentID</th>
                    <th>PatientID</th>
                    <th>AppointmentDateTime</th>
                    <th>Status</th>
                    <th>Purpose</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through doctor-assigned appointments and display them with inline edit form
                while ($row = mysqli_fetch_assoc($doctorResult)) {
                    echo "<tr>";
                    echo "<td>{$row['AppointmentID']}</td>";
                    echo "<td>{$row['PatientID']}</td>";
                    echo "<td>{$row['AppointmentDateTime']}</td>";
                    echo "<td>{$row['Status']}</td>";
                    echo "<td>{$row['Purpose']}</td>";
                    echo "<td>";
                    echo "<form action='update_appointment.php' method='post'>";
                    echo "<input type='hidden' name='appointmentID' value='{$row['AppointmentID']}'>";
                    echo "<input type='text' name='status' value='{$row['Status']}'>";
                    echo "<input type='text' name='purpose' value='{$row['Purpose']}'>";
                    echo "<input type='datetime-local' name='appointmentDateTime' value='" . date('Y-m-d\TH:i', strtotime($row['AppointmentDateTime'])) . "'>";
                    echo "<input type='submit' name='submit' value='Update'>";
                    echo "</form>";

                    // Add delete button
                    echo "<form action='update_appointment.php' method='post'>";
                    echo "<input type='hidden' name='deleteAppointmentID' value='{$row['AppointmentID']}'>";
                    echo "<input type='submit' name='delete' value='Delete'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>