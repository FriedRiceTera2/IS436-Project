<?php
// Start or resume session
session_start();

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_username'])) {
    // Redirect to the login page if not logged in
    header("Location: DoctorLogin.php");
    exit();
}

// Retrieve and store doctor's name
$doctorUsername = $_SESSION['doctor_username'];

// Include database connection code here

// Fetch medical equipment information from the database
// Replace this with your actual database connection and query
$conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$equipmentQuery = "SELECT * FROM MedicalEquipment";
$result = $conn->query($equipmentQuery);

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
    <title>Hopkins Medical Equipment - Resource Allocation</title>
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
        <h2>Medical Equipment - Resource Allocation</h2>
        <!-- Display medical equipment information here -->
        <table>
            <thead>
                <tr>
                    <th>Equipment ID</th>
                    <th>Equipment Name</th>
                    <th>Availability</th>
                    <th>In Use By Patient ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the medical equipment records and display them
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['EquipmentID']}</td>";
                    echo "<td>{$row['EquipmentName']}</td>";
                    echo "<td>{$row['Availability']}</td>";
                    echo "<td>{$row['InUseByPatientID']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Manage medical equipment availability and PatientID -->
        <h3>Manage Medical Equipment</h3>
        <form action="manage_medicalequipment_availability.php" method="post">
            <label for="equipment_id">Equipment ID:</label>
            <input type="text" name="equipment_id" required>
            <label for="availability">New Availability:</label>
            <select name="availability" required>
                <option value="Available">Available</option>
                <option value="In Use">In Use</option>
            </select>
            <label for="patient_id">New Patient ID:</label>
            <input type="text" name="patient_id" required>
            <input type="submit" value="Update Availability and Patient ID">
        </form>
    </section>
</body>
</html>