<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $message = test_input($_POST["message"]);

    // Display a thank you message
    echo "<h2>Thank you, $name!</h2>";
    echo "<p>Your message has been received. We will get back to you soon.</p>";
    header("Location:Contact.html");
} else {
    // Redirect back to the contact page if accessed without form submission
    header("Location:Contact.html");
    exit();
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
