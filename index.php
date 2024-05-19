<?php

include ("connect.php");


$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "user_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    
    // Validate form data
    if (empty($user) || empty($email) || empty($pass)) {
        echo "All fields are required!";
    } else {
        // Hash the password
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user, $email, $hashed_password);
        
        // Execute the statement
        if ($stmt->execute()) {
            //echo "Signup successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
        
      
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup Form</title>
</head>
<body>
    <h2>Signup Form</h2>
    <div class="container">
    <form   method="POST">
        
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required placeholder="username"><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required placeholder="email"><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required placeholder="password"><br><br>
        <div class="singup">
        <input type="submit" value="Signup" action="profile.html">
        <p> Create Your New Account <a href="login.php">login</a></p>

    </div>
    </form>
</div>
</body>
<style>
    
    h2{
        align-items: center;
        justify-content: center;
        display: grid;

    }
    .container{
        align-items: center;
        display: grid;
        justify-content: center;
    }
    .singup{
        justify-content: center;
        margin-left: 50px;
    }
</style>
</html>
