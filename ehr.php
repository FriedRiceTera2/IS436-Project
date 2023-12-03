<?php
// Start or resume session
session_start();

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_username'])) {
    // Redirect to the login page if not logged in
    header("Location: login2.php");
    exit();
}

$conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Check if the form is submitted for updating
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Retrieve values from the form
    $assignedPatientID = $_POST['assignedPatientID'];
    $newMedicalHistory = $_POST['medicalHistory'];
    $newDiagnosis = $_POST['diagnosis'];
    $newTreatmentPlan = $_POST['treatmentPlan'];

    // Perform the update in the database
    // Replace this with your actual database update query
    $updateQuery = "UPDATE AssignedPatient SET MedicalHistory = '$newMedicalHistory', Diagnosis = '$newDiagnosis', TreatmentPlan = '$newTreatmentPlan' WHERE AssignedPatientID = $assignedPatientID";
    $updateResult = $conn->query($updateQuery);

    // Check if the query was successful
    if ($updateResult) {
        // Redirect back to the ehr.php page after the update is done
        header("Location: ehr.php");
        exit();
    } else {
        // Display an error message if the query fails
        echo "Error updating assigned patient information: " . $conn->error;
    }
}

// Fetch assigned patient records from the AssignedPatient table
// Replace this with your actual database connection and query
$conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctorUsername = $_SESSION['doctor_username'];
$assignedPatientsQuery = "SELECT * FROM AssignedPatient WHERE DoctorID = (SELECT DoctorID FROM Doctor WHERE Username = '$doctorUsername')";
$result = $conn->query($assignedPatientsQuery);

// Check if the query was successful
if (!$result) {
    die("Error executing the query: " . $conn->error);
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronic Health Records</title>
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
            <li><a href="doctorappointments.php">Appointments</a></li>
        </ul>
    </nav>
    <section>
        <h2>Electronic Health Records</h2>
        <!-- Display assigned patient records with inline edit form -->
        <table>
            <thead>
                <tr>
                    <th>PatientID</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>DateOfBirth</th>
                    <th>MedicalRecordNumber</th>
                    <th>MedicalHistory</th>
                    <th>Diagnosis</th>
                    <th>TreatmentPlan</th>
                    <th>LastUpdated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through assigned patient records and display them with inline edit form
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['PatientID']}</td>";
                    echo "<td>{$row['FirstName']}</td>";
                    echo "<td>{$row['LastName']}</td>";
                    echo "<td>{$row['DateOfBirth']}</td>";
                    echo "<td>{$row['MedicalRecordNumber']}</td>";
                    echo "<td>";
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='assignedPatientID' value='{$row['AssignedPatientID']}'>";
                    echo "<input type='text' name='medicalHistory' value='{$row['MedicalHistory']}'>";
                    echo "</td>";
                    echo "<td><input type='text' name='diagnosis' value='{$row['Diagnosis']}'></td>";
                    echo "<td><input type='text' name='treatmentPlan' value='{$row['TreatmentPlan']}'></td>";
                    echo "<td>{$row['LastUpdated']}</td>";
                    echo "<td><input type='submit' name='submit' value='Update'></form></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
   
</body>
</html>