<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #edf0f7, #cfd9df);
    margin: 0;
    padding: 30px 0;
    color: #333;
}

/* Table Styles */
table {
    width: 85%;
    margin-top: 30px;
    border-collapse: collapse;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    background: #fefefe;
    border-radius: 8px;
    overflow: hidden;
}

th {
    padding: 14px;
    background: linear-gradient(to right, #4b6cb7, #182848); /* Deep blue gradient */
    color: white;
    font-size: 15px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    text-align: center;
}

td {
    padding: 12px;
    text-align: center;
    font-size: 15px;
    background: linear-gradient(145deg, #ffffff, #f3f6f9);
    color: #333;
    border-bottom: 1px solid #ddd;
    transition: background 0.3s ease;
}

tr:hover td {
    background: #e9f0f7;
}

/* Link Button Styles */
a {
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 5px;
    font-weight: 600;
    font-size: 14px;
    color: white;
    transition: all 0.3s ease;
}

a[href*='update.php'] {
    background-color: #3498db;
}

a[href*='delete.php'] {
    background-color: #e74c3c;
}

a[href*='http'] {
    background-color: #27ae60;
}

a:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Form Styles */
form {
    margin-top: 20px;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    display: inline-block;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

form label {
    font-weight: 600;
    margin-right: 10px;
    font-size: 15px;
    color: #333;
}

form select, form input[type="text"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-right: 10px;
    font-size: 14px;
    width: 180px;
}

form input[type="submit"], form button {
    padding: 9px 16px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    background: #4b6cb7;
    color: white;
    cursor: pointer;
    transition: background 0.3s ease;
}

form input[type="submit"]:hover, form button:hover {
    background: #3751a0;
}

form button a {
    color: white;
    text-decoration: none;
}

form button a:hover {
    color: #ffd97d;
}

    </style>
</head>
<body>
    <?php
     include('dbconnect.php');

     session_start();

// Check if the user is logged in
// if (!isset($_SESSION['name'])) {
//     header('Location: login.php'); // Redirect to login page if not logged in
//     exit();
// }

// // Logout functionality
// if (isset($_GET['logout'])) {
//     session_destroy();
//     header('Location: login.php'); // Redirect to login page after logout
//     exit();
// }


     $query = "SELECT * FROM ebooks";
     if (isset($_GET['Searchbtn'])) {
        $searchby = $_GET['searchlist']; 
        $searchtext = $_GET['search'] ?? "";
        if ($searchby == "Id") {
            $query = "SELECT * FROM ebooks WHERE id = " . $searchtext;
        } elseif ($searchby == "Title") {
            $query = "SELECT * FROM ebooks WHERE title = '$searchtext'";
        } elseif ($searchby == "Author") {
            $query = "SELECT * FROM ebooks WHERE author = '$searchtext'";
        } else {
            echo "<script>alert('Please select any field')</script>";
        }
     }

     $rows = mysqli_query($con, $query);
     $totalrows = mysqli_num_rows($rows);
    //  echo $totalrows;

     if ($totalrows != 0) {
    ?>
    <center>
    <form method="get">
        <label for="">Search By:</label>
        <select name="searchlist">
            <option value="select">Select</option>
            <option value="Id">Id</option>
            <option value="Title">Title</option>
            <option value="Author">Author</option>
        </select>
        <input type="text" name="search" required>
        <input type="submit" value="search" name="Searchbtn">
        <button type="reset"><a href="view.php">Reset</a></button>

        <table border="1" cellspacing="0" align="center">
            <tr>  
                <th>ID</th>
                <th>Title</th>
                <th>File URL</th>
                <th>Author</th>
                <th>View</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

            <?php
            while ($data = mysqli_fetch_assoc($rows)) {
                echo "          
                <tr>
                    <td>".$data['id']."</td>
                    <td>".$data['title']."</td>
                    <td>".$data['file_url']."</td>
                    <td>".$data['author']."</td>
                    <td><a href='".$data['file_url']."' target='_blank'>Open</a></td>
                    <td><a href='update.php?id=$data[id]'>Edit</a></td>
                    <td><a href='delete.php?id=$data[id]' onclick='return confirmation();'>Delete</a></td>
                </tr>";
            }
            echo "</table>";
        } elseif (isset($_GET['Searchbtn'])) {
            echo "<p style='color:red;'>Please give proper information</p>";
        }
    ?>

    <script>
    function confirmation() {
        return confirm('Are you sure you want to delete this data?');
    }
    </script>

</center> <br>

<center>
<a href="logout.php" style="padding: 10px 15px; background-color: #e74c3c; color: white; text-decoration: none; border-radius: 5px;">Logout</a>
</center>
</body>
</html>
