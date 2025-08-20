<?php 
include('dbconnect.php'); // Make sure this file connects to your database

if(isset($_POST['submitbtn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Securely hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert query
    $query = "INSERT INTO registration (name, email, phone, password) 
              VALUES ('$name', '$email', '$phone', '$hashed_password')";

    $run = mysqli_query($con, $query);

    if ($run) {
        echo "<script>
            alert('Registration successful!');
            window.location.href='index.html';
        </script>";
    } else {
        echo "Registration failed: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
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

    .welcome {
      font-size: 32px;
      font-weight: bold;
      color: #fff;
      margin-bottom: 30px;
      text-shadow: 0 0 10px rgba(255, 184, 77, 0.7);
      animation: fadeIn 2s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
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
    form input[type="email"],
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

      .welcome {
        font-size: 24px;
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Welcome Message -->
  <div class="welcome">Hello, Welcome!</div>

  <!-- Registration Form -->
  <div class="container">
    <h2>Register for the Event</h2>
    <form method="POST" action="">
      <label for="name">Name:</label>
      <input type="text" name="name" required>

      <label for="email">Email:</label>
      <input type="email" name="email" required>

      <label for="phone">Phone:</label>
      <input type="text" name="phone" required>

      <label for="password">Password:</label>
      <input type="password" name="password" required>

      <button type="submit" name="submitbtn" class="btn">Submit</button>
    </form>
  </div>

</body>
</html>
