<?php
// Start a session
session_start();

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_username'])) {
    // Redirect to the login page if not logged in
    header("Location: DoctorLogin.php");
    exit();
}

$conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch doctor information based on the logged-in user's username
$doctor_username = $_SESSION['doctor_username'];
$sql = "SELECT FirstName FROM Doctor WHERE Username = '$doctor_username'";
$result = $conn->query($sql);

// Check if the query was successful
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $doctor_name = $row['FirstName'];
} else {
    // Handle the case where the doctor's information is not found
    $doctor_name = "Doctor";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
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
            <li><a href="logout.php">Logout</a></li>

        </ul>
    </nav>
    <section>
        <h2>Welcome, <?php echo $doctor_name; ?>!</h2>
        <p>As a valued member of our medical team, you have access to a variety of tools and information to enhance patient care and streamline your workflow.</p>

		<h3>Key Features:</h3>
			<ul>
    			<li><strong>Electronic Health Records:</strong> Review and update patient records efficiently.</li>
    			<li><strong>Resource Allocation:</strong> Manage bed availability, operating rooms, and medical equipment.</li>
    			<li><strong>Appointments:</strong> View and schedule patient appointments for personalized care.</li>
			</ul>

		<p>We appreciate your dedication to providing excellent healthcare services. If you have any questions or need assistance, please feel free to reach out to our support team.</p>

       

    </section>
</body>
</html>
