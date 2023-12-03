<?php include('Login1.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hopkins Medical System - Patient Login</title>
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
            <li><a href="PatientLogin.php">Patient Login</a></li>
            <li><a href="DoctorLogin.php">Doctor Login</a></li>
        </ul>
    </nav>
    <section>
        <h2>Patient Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="patient_username">Username:</label>
            <input type="text" id="patient_username" name="patient_username" placeholder="Enter your username" required>

            <label for="patient_password">Password:</label>
            <input type="password" id="patient_password" name="patient_password" placeholder="Enter your password" required>

            <button type="submit">Login as Patient</button>
        </form>
        
        <?php
            // Display any error messages or additional content from the PHP script if needed
            // For example, you can display an error message if the login fails
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($result) && $result->num_rows == 0) {
                echo "<p class='error-message'>Invalid username or password for patients.</p>";
            }
        ?>
    </section>
  
</body>
</html>
