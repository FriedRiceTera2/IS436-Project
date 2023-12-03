
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Appointment</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function validateForm() {
            // Get form elements
            var appointmentDate = document.getElementById('appointmentDate').value;
            var appointmentTime = document.getElementById('appointmentTime').value;
            var doctor = document.getElementById('doctor').value;
            var purpose = document.getElementById('purpose').value;

            // Perform basic validation
            if (appointmentDate === "" || appointmentTime === "" || doctor === "" || purpose === "") {
                alert("Please fill out all fields");
                return false;
            }

            // You can add more specific validation if needed

            return true;
        }
    </script>
</head>
<body>
    <header>
        <h1>Medical System</h1>
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
        </ul>
    </nav>
    <section>
        <h2>Make Appointment</h2>
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

        // Fetch patient ID based on the logged-in user's username
        $patient_username = $_SESSION['patient_username'];
        $sqlPatient = "SELECT PatientID FROM Patient WHERE Username = '$patient_username'";
        $resultPatient = $conn->query($sqlPatient);

        if ($resultPatient->num_rows > 0) {
            $rowPatient = $resultPatient->fetch_assoc();
            $patientID = $rowPatient['PatientID'];

            // Fetch doctors from the Doctor table
            $sql = "SELECT DoctorID, FirstName, LastName FROM Doctor";
            $result = $conn->query($sql);

            // Check if there are doctors
            if ($result->num_rows > 0) {
                echo '<form action="processappointment.php" method="post" onsubmit="return validateForm()">';
                echo '<label for="appointmentDate">Appointment Date:</label>';
                echo '<input type="date" id="appointmentDate" name="appointmentDate" required>';
                
                echo '<label for="appointmentTime">Appointment Time:</label>';
                echo '<input type="time" id="appointmentTime" name="appointmentTime" required>';
                
                echo '<label for="doctor">Select Doctor:</label>';
                echo '<select id="doctor" name="doctor" required>';
                
                // Output each doctor as an option in the dropdown
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['DoctorID'] . "'>" . $row['FirstName'] . " " . $row['LastName'] . "</option>";
                }
                
                echo '</select>';
                
                echo '<label for="purpose">Purpose of Appointment:</label>';
                echo '<textarea id="purpose" name="purpose" rows="4" required></textarea>';
                
                echo '<button type="submit">Submit Appointment</button>';
                echo '</form>';
            } else {
                echo "<p>No doctors available</p>";
            }
        } else {
            // Handle the case where the patient's information is not found
            echo "Error: Patient not found.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </section>
</body>
</html>

</html>
