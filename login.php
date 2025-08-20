<?php

include 'dbconnect.php';
session_start();

// Check if the user is already logged in
if (isset($_SESSION['name'])) {
    header('Location: view.php'); // Redirect to view.php if already logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Check if the name and password are not empty
    if (!empty($name) && !empty($password)) {
        // Query to check if the user exists using prepared statements
        $sql = "SELECT * FROM `login` WHERE name = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $name); // 's' denotes string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['name'] = $name; // Store the name in session
                $_SESSION['last_time'] = time(); // Store the last login time
                header('Location: view.php'); // Redirect to view.php
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "User not found!";
        }

        $stmt->close();
    } else {
        $error = "Please enter both username and password.";
    }
}

$con->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: url('img/bg1.png') no-repeat center center/cover;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #333;
            text-align: center;
            padding: 20px;
        }

        /* Animated "Hello, Welcome" Text */
        .welcome-message {
            font-size: 36px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 0 0 10px rgba(255, 184, 77, 0.7);
            animation: fadeInUp 3s ease-out infinite;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            50% {
                opacity: 1;
                transform: translateY(0);
            }
            100% {
                opacity: 0;
                transform: translateY(20px);
            }
        }

        .container {
            background-color: #fff;
            padding: 40px 30px;
            width: 100%;
            max-width: 450px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(255, 184, 77, 0.3);
            animation: glow 2s ease-in-out infinite;
            text-align: center;
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 10px rgba(255, 184, 77, 0.3), 0 0 20px rgba(255, 184, 77, 0.2);
            }
            50% {
                box-shadow: 0 0 20px rgba(255, 184, 77, 0.5), 0 0 30px rgba(255, 184, 77, 0.3);
            }
            100% {
                box-shadow: 0 0 10px rgba(255, 184, 77, 0.3), 0 0 20px rgba(255, 184, 77, 0.2);
            }
        }

        h1, h2 {
            color: #222;
            margin-bottom: 20px;
            font-weight: 600;
        }

        form label {
            display: block;
            text-align: left;
            margin-bottom: 6px;
            font-weight: 500;
            color: #555;
        }

        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        form input:focus {
            border-color: #ffb84d;
            outline: none;
        }

        .btn {
            background-color: #ffb84d;
            border: none;
            padding: 12px 25px;
            color: black;
            font-size: 16px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #ffc76e;
            transform: translateY(-2px);
        }

        @media (max-width: 500px) {
            .container {
                padding: 25px 20px;
            }

            .btn {
                width: 100%;
            }

            .welcome-message {
                font-size: 24px;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Animated "Hello, Welcome" Message -->
    <div class="welcome-message">
        Hello, Welcome to the Login Page!
    </div>

    <div class="container">
        <h2>Login to Your Account</h2>

        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

        <form method="POST">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" placeholder="Enter your full name" required><br>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required><br>

            <button type="submit" class="btn">Login</button>
        </form>

        <p>Don't have an account? <a href="register1.php">Register here</a></p>
    </div>

</body>
</html>
