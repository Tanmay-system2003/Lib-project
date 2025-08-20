<?php
// Include the database connection
include('dbconnect.php');

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current eBook data from the database
    $query = "SELECT * FROM ebooks WHERE id = $id";
    $result = mysqli_query($con, $query);
    $data = mysqli_fetch_assoc($result);

    // If no eBook is found with the given ID, redirect to view page
    if (!$data) {
        header("Location: view.php");
        exit();
    }
} else {
    // If no ID is provided, redirect to view page
    header("Location: view.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $file_url = $_POST['file_url'];

    // Update the eBook information in the database
    $update_query = "UPDATE ebooks SET id='id', title = '$title', author = '$author', file_url = '$file_url' WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        // On success, redirect back to the view page
        header("Location: view.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit eBook</title>
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #e0eafc, #cfdef3); /* Soft blue gradient */
    color: #333;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Form Container Styling */
.form-container {
    width:85vh;
    margin: 0 auto;
    padding: 40px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.form-container:hover {
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

/* Heading Styling */
.form-container h2 {
    text-align: center;
    color: #1f3c88; /* Deep navy blue */
    margin-bottom: 25px;
}

/* Input Fields Styling */
.form-container input[type="text"],
.form-container input[type="url"] {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
    background: #f9f9f9;
    color: #333;
    font-size: 16px;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

.form-container input[type="text"]:focus,
.form-container input[type="url"]:focus {
    border-color: #1f3c88;
    background-color: #fff;
    outline: none;
}

/* Submit Button Styling */
.form-container input[type="submit"] {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 6px;
    background: linear-gradient(to right, #1f3c88, #3a63a1);
    color: white;
    font-size: 17px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
}

.form-container input[type="submit"]:hover {
    background: linear-gradient(to right, #3a63a1, #1f3c88);
    transform: translateY(-2px);
}

/* Label Styling */
.form-container label {
    font-size: 15px;
    margin-bottom: 6px;
    display: block;
    color: #1f3c88;
    font-weight: 500;
}

/* Back Button Styling */
.form-container button {
    width: 100%;
    background: #f0f4f8;
    padding: 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    margin-top: 20px;
    transition: background 0.3s ease, color 0.3s ease;
}

.form-container button a {
    text-decoration: none;
    color: #1f3c88;
    display: block;
}

.form-container button:hover {
    background: #e0e7ef;
}

.form-container button a:hover {
    color: #3a63a1;
}


    </style>
</head>
<body>

   
    <!-- Form to edit the eBook -->
    <form method="POST">
    <div class="form-container">
    <h2>Edit eBook</h2>

        <label for="title">eBook Title:</label>
        <input type="text" id="title" name="title" value="<?= $data['title'] ?>" required><br><br>

        <label for="author">Author Name:</label>
        <input type="text" id="author" name="author" value="<?= $data['author'] ?>" required><br><br>

        <label for="file_url">eBook File URL:</label>
        <input type="url" id="file_url" name="file_url" value="<?= $data['file_url'] ?>" required><br><br>

        <input type="submit" value="Update eBook">
    </form>

    <!-- Back to view page -->
    <button><a href="view.php">Back to View eBooks</a></button>
</div>
</body>
</html>
