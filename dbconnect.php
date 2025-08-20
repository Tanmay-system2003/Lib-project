<?php
// Turn on MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "e_library";

try {
    // Try to connect
    $con = new mysqli($host, $user, $pass, $dbname);
    // echo "Connected successfully!";
} catch (mysqli_sql_exception $e) {
    // Catch and display connection error
    die("Connection failed: " . $e->getMessage());
}

?>
