<?php include('patientehr1.php'); ?>


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
                <a href="#" class="dropbtn">Electronic Health Records</a>
                <div class="dropdown-content">
                    <a href="patientehr.php">Overview</a>
                    <a href="pmedhist.php">Medical History</a>
                    <a href="makeappointment.php">Make Appointment</a>
                    <!-- Add more pages as needed -->
                </div>
            </li>
        </ul>
    </nav>
    <section>
        <h2>Electronic Health Records</h2>
        <!-- Your Electronic Health Records content goes here -->
        <p>This page provides an overview of Electronic Health Records.</p>
        
         <?php
        // Display Electronic Health Records content in a table
        if ($resultEHR->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Medical History</th><th>Diagnosis</th><th>Treatment Plan</th><th>Last Updated</th></tr>";
            while ($rowEHR = $resultEHR->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $rowEHR['MedicalHistory'] . "</td>";
                echo "<td>" . $rowEHR['Diagnosis'] . "</td>";
                echo "<td>" . $rowEHR['TreatmentPlan'] . "</td>";
                echo "<td>" . $rowEHR['LastUpdated'] . "</td>";
                // Add more fields as needed
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No Electronic Health Records found for this patient.</p>";
        }
        ?>
    </section>
   
</body>
</html>
