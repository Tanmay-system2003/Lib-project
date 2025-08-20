<?php
// Include the database connection
include('dbconnect.php');

// Get the eBook ID from the URL
$id = $_GET['id'] ?? "";

// If an ID is provided, fetch the eBook details
if ($id != "") {
    // Fetch the eBook data to confirm the details
    $query = "SELECT * FROM ebooks WHERE id='$id'";
    $result = mysqli_query($con, $query);
    
    // Check if the eBook exists
    if ($result && mysqli_num_rows($result) > 0) {
        $ebook = mysqli_fetch_assoc($result);

        // Display the details of the eBook to be deleted
        $title = $ebook['title'];
        $author = $ebook['author'];
        $file_url = $ebook['file_url'];

        // Display the confirmation message
        echo "<h2>Are you sure you want to delete the following eBook?</h2>";
        echo "<p><strong>Title:</strong> $title</p>";
        echo "<p><strong>Author:</strong> $author</p>";
        echo "<p><strong>File URL:</strong> $file_url</p>";
        
        // Create the delete form
        echo "<form method='POST'>
                <input type='hidden' name='id' value='$id'>
                <input type='submit' value='Delete eBook'>
                <button><a href='view.php'>Cancel</a></button>
              </form>";
    } else {
        echo "<script>alert('eBook not found!'); window.location.href='view.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='view.php';</script>";
}

// Check if the delete form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete the eBook from the database
    $idToDelete = $_POST['id'];
    $deleteQuery = "DELETE FROM ebooks WHERE id='$idToDelete'";

    if (mysqli_query($conn, $deleteQuery)) {
        // If successful, redirect to view.php with a success message
        echo "<script>alert('eBook deleted successfully!'); window.location.href='view.php';</script>";
    } else {
        // If an error occurred, display an error message
        echo "<script>alert('Error deleting eBook.'); window.location.href='view.php';</script>";
    }
}
?>
