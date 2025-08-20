
<?php
// Include your database connection file
include('dbconnect.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check if the email is provided in the POST data
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Validate email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            // Sanitize the email (important to prevent SQL injection)
            $email = $con->real_escape_string($email);

            // SQL query to insert the email into the database
            $sql = "INSERT INTO subcriber (email) VALUES ('$email')";

            // Execute the query and check if it was successful
            if ($con->query($sql) === TRUE) {
                echo "<h2 style='color: green;'>Thank you for subscribing! We received your email: $email</h2>";
            } else {
                // Display the error message and SQL query for debugging
                echo "<h2 style='color: red;'>Error: " . $con->error . "</h2>";
                echo "<h3>SQL Query: " . $sql . "</h3>";
            }

        } else {
            echo "<h2 style='color: red;'>Invalid email format!</h2>";
        }

        // Close the database connection
        $con->close();

    } else {
        // If the email wasn't provided, display an error message
        echo "<h2 style='color: red;'>Error: No email provided.</h2>";
    }

} else {
    // If the request method is not POST, show an error message
    echo "<h2 style='color: red;'>Invalid request method.</h2>";
}
?>
