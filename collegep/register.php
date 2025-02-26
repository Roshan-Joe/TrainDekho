<?php
session_start(); // Start the session

// Database connection
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "collegep";  

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $full_name = trim($_POST["full_name"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $email = trim($_POST["email"]);
    $country_code = $_POST["country_code"];
    $mobile = trim($_POST["mobile"]);
    $captcha_input = $_POST["captcha_input"];

    // Dummy captcha validation
    $expected_captcha = "fTy4LP";  
    if ($captcha_input !== $expected_captcha) {
        die("Captcha verification failed!");
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match!");
    }

    // Check if username already exists
    $check_username = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $check_username->store_result();

    if ($check_username->num_rows > 0) {
        die("Error: Username already exists. Please choose a different username.");
    }
    $check_username->close();

    // Hash password securely
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO users (username, full_name, password_hash, email, country_code, mobile) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $full_name, $password_hash, $email, $country_code, $mobile);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Registration successful! Redirecting to login...";
        header("Location: login1.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IRCTC Account Creation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
        }

        .header {
            background-color: #003366;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }

        .header a:hover {
            text-decoration: underline;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 20px;
        }

        .form-container {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            font-size: 22px;
            color: #003366;
            margin-bottom: 10px;
        }

        .instructions {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }

        .instructions p {
            margin: 5px 0;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .captcha-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .captcha {
            background-color: #003366;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
        }

        .refresh-captcha {
            cursor: pointer;
        }

        .submit-btn {
            background-color: #ff6f00;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .submit-btn:hover {
            opacity: 0.9;
        }

        .fraud-alert {
            margin-left: 20px;
        }

        .fraud-alert img {
            width: 300px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="nav">
            <a href="rose.html">HOME</a>
            <a href="contactus.html">CONTACT US</a>
            <a href="#">HELP & SUPPORT</a>
            <a href="#">DAILY DEALS</a>
            <a href="#">ALERTS</a>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <h1>Create Your IRCTC Account</h1>
            <div class="instructions">
                <p>1. Please use valid E-Mail ID, Mobile number, and correct personal details in the registration form. This may be required for verification purposes.</p>
                <p>2. Garbage / Junk values in profile may lead to deactivation of IRCTC account.</p>
            </div>
            <form action="register.php" method="POST">
    <input type="text" name="username" placeholder="User Name" required>
    <input type="text" name="full_name" placeholder="Full Name" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    <input type="email" name="email" placeholder="Email" required>
    <select name="country_code" required>
        <option value="+91">+91 - India</option>
        <option value="+1">+1 - USA</option>
        <option value="+44">+44 - UK</option>
    </select>
    <input type="text" name="mobile" placeholder="Mobile" required>
    <div class="captcha-container">
        <div class="captcha">fTy4LP</div>
        <input type="text" name="captcha_input" placeholder="Enter Captcha" required>
    </div>
    <button type="submit" class="submit-btn">Submit</button>
</form>

        </div>
        <div class="fraud-alert">
            <img src="file:///D:/collegep/Screenshot%202025-01-16%20213946.png" alt="Fraud Alert">
        </div>
    </div>
</body>
</html>