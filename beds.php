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

// Fetch bed information from the database
// Replace this with your actual database connection and query
$conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bedsQuery = "SELECT * FROM Bed";
$result = $conn->query($bedsQuery);

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
    <title>Beds - Resource Allocation</title>
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
        <h2>Beds - Resource Allocation</h2>
        <!-- Display bed information here -->
        <table>
            <thead>
                <tr>
                    <th>Bed ID</th>
                    <th>Room Number</th>
                    <th>Availability</th>
                    <th>Patient ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the bed records and display them
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['BedID']}</td>";
                    echo "<td>{$row['RoomNumber']}</td>";
                    echo "<td>{$row['Availability']}</td>";
                    echo "<td>{$row['PatientID']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Manage bed availability -->
        <form action="manage_bed_availability.php" method="post">
            <label for="bed_id">Bed ID:</label>
            <input type="text" name="bed_id" required>
            <label for="availability">New Availability:</label>
            <select name="availability" required>
                <option value="Available">Available</option>
                <option value="Occupied">Occupied</option>
            </select>
            <input type="submit" value="Update Availability">
        </form>
    </section>
</body>
</html>
