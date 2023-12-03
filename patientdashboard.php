<?php
// Start a session
session_start();

$conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

    // Check the connection
	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
// Check if the patient is logged in
if (!isset($_SESSION['patient_username'])) {
    // Redirect to the login page if not logged in
    header("Location: PatientLogin.php");
    exit();
}

// Fetch patient information based on the logged-in user's username
$patient_username = $_SESSION['patient_username'];
$sql = "SELECT FirstName FROM Patient WHERE Username = '$patient_username'";
$result = $conn->query($sql);

// Check if the query was successful
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $patient_name = $row['FirstName'];
} else {
    // Handle the case where the patient's information is not found
    $patient_name = "Patient";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
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
                <a href="#" class="dropbtn">Patient Services</a>
                <div class="dropdown-content">
                    <a href="patientdashboard.php">Patient Dashboard</a>
                    <a href="patientehr.php">View Electronic Health Records</a>
                    <a href="makeappointment.php">Make Appointment</a>
                </div>
            </li>
            
            <li><a href="logout.php">Logout</a></li>

        </ul>
    </nav>
    <section>
        <h2>Welcome, <?php echo $patient_name; ?>!</h2>
        <!-- Your patient dashboard content goes here -->
        
    	<p>Welcome to your Patient Dashboard! Here, you have convenient access to your Electronic Health Records, medical history, and the ability to schedule medical appointments.</p>
    	
    	<p>Ready to schedule your next medical appointment? 
    	<p>Use the "Patient Services" dropdown and click "Make Appointment" to choose a date, time, and your preferred doctor.</p>
    	<p>We're here to help you receive the care you need.</p>

    </section>
</body>
</html>
