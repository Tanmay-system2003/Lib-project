<?php
include'dbconnect.php';
// ----------------
$filename = "subscribers.csv"; // Name of the CSV file
$data_directory = "data/"; // Directory to store the file (ensure it exists and is writable)
$filepath = $data_directory . $filename; // Full file path
$delimiter = ","; // CSV delimiter (comma)
$enclosure = '"'; // CSV enclosure character (double quote)
$header = ["Email", "First Name", "Last Name", "Subscription Date"]; // CSV header row

// 2. Function to Add Subscriber Data
// ----------------------------------
/**
 * Adds a new subscriber to the CSV file.
 *
 * @param string $email The subscriber's email address.
 * @param string $firstName The subscriber's first name.
 * @param string $lastName The subscriber's last name.
 * @param string $filepath The path to the CSV file.
 * @param string $delimiter The CSV delimiter.
 * @param string $enclosure The CSV enclosure character.
 * @param array $header The CSV header row.
 *
 * @return bool True on success, false on failure.
 */
function addSubscriber(string $email, string $firstName, string $lastName, string $filepath, string $delimiter, string $enclosure, array $header): bool
{
    // Sanitize the data to prevent CSV injection and other issues.
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $firstName = str_replace(["\r", "\n", $delimiter, $enclosure], '', $firstName); // Remove potentially problematic characters
    $lastName = str_replace(["\r", "\n", $delimiter, $enclosure], '', $lastName);  // Remove potentially problematic characters
    
    // Basic validation (you can add more robust validation if needed)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($firstName) || empty($lastName)) {
        error_log("Invalid data: Email: $email, First Name: $firstName, Last Name: $lastName");
        return false; // Indicate failure
    }

    $subscriptionDate = date("Y-m-d H:i:s"); // Get current date and time

    $data = [$email, $firstName, $lastName, $subscriptionDate];

    $file = @fopen($filepath, "a"); // Use @ to suppress warnings; handle errors explicitly.
    if ($file === false) {
        error_log("Failed to open file for writing: $filepath");
        return false; // Indicate failure
    }

    // Lock the file for writing to prevent data corruption from concurrent writes.
    if (!flock($file, LOCK_EX)) {
        error_log("Failed to lock file for writing: $filepath");
        fclose($file);
        return false;
    }
    
    // Check if the file is empty, and write the header if it is.
    if (filesize($filepath) == 0) {
        fputcsv($file, $header, $delimiter, $enclosure);
    }

    // Write the data to the CSV file using fputcsv()
    if (fputcsv($file, $data, $delimiter, $enclosure) === false) {
        error_log("Failed to write data to CSV file: $filepath");
        flock($file, LOCK_UN); // Unlock before closing.
        fclose($file);
        return false;
    }

    // Unlock the file.  This is crucial!
    flock($file, LOCK_UN);
    fclose($file);

    return true; // Indicate success
}

// 3. Main Execution Block (Example Usage)
// ---------------------------------------

// Ensure the data directory exists and is writable.
if (!is_dir($data_directory)) {
    if (!mkdir($data_directory, 0777, true)) { //Create dir and subdirs if they don't exist.
        error_log("Failed to create data directory: $data_directory");
        die("Error: Could not create data directory. Please check permissions."); // Stop execution.
    }
}
if (!is_writable($data_directory)) {
    die("Error: Data directory is not writable. Please check permissions.");
}
// Create the file if it doesn't exist.  We create it *before* adding subscribers.
if (!file_exists($filepath)) {
     $file = @fopen($filepath, "w");
     if ($file === false){
        error_log("Cannot create the file: $filepath");
        die("Error: Could not create file. Please check permissions.");
     }
     fclose($file);
}

// Add some subscriber data (replace with your actual data source, e.g., a form submission)
$subscribers = [
    ["john.doe@example.com", "John", "Doe"],
    ["jane.smith@test.com", "Jane", "Smith"],
    ["robert.jones@invalid.com", "Robert", "Jones"], // Example with an invalid email
    ["alice,wonder@example.com", "Alice", "Wonder"], //comma in name
];

foreach ($subscribers as $subscriberData) {
    list($email, $firstName, $lastName) = $subscriberData;
    if (addSubscriber($email, $firstName, $lastName, $filepath, $delimiter, $enclosure, $header)) {
        echo "Subscriber added successfully: $email<br>";
    } else {
        echo "Failed to add subscriber: $email<br>";
    }
}

echo "Data written to $filepath"; // Inform the user of the file path.
?>
