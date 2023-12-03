<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_username = $_POST['doctor_username'];
    $doctor_password = $_POST['doctor_password'];

    // Establish a connection to the database (replace with your database credentials)
    $conn = new mysqli("studentdb-maria.gl.umbc.edu", "ll41010", "ll41010", "ll41010");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform the authentication
    $sql = "SELECT * FROM Doctor WHERE Username = '$doctor_username' AND Password = '$doctor_password'";
    $result = $conn->query($sql);

    // Check if the authentication is successful
    if ($result->num_rows > 0) {
        // Authentication successful
        $_SESSION['doctor_username'] = $doctor_username;
        $_SESSION['doctor_id'] = $row['DoctorID'];
        header("Location: doctordashboard.php");
        exit();
    } else {
        // Authentication failed
        $_SESSION['login_error'] = "Invalid username or password for doctors.";
        header("Location: DoctorLogin.php");
        exit();
    }

    $conn->close();
}
?>
