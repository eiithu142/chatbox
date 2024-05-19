<?php


include  ("connect.php");

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
    $pass = $_POST['password'];
    
    // Validate form data
    if (empty($user) || empty($pass)) {
        echo "Both fields are required!";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        
        // Execute the statement
        $stmt->execute();
        
        // Store the result
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // Bind result variables
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();
            
            // Verify password
            if (password_verify($pass, $hashed_password)) {
                // Start a session and set session variables
                session_start();
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $user;
                echo "Login successful! Welcome, " . $user . ".";
            } else {
                echo "Invalid username or password!";
            }
        } else {
            echo "No user found with this username!";
        }
        
        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>



<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
</head>
<body>
    <h2>Login Form</h2>
    <form action="login.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Login">
    </form>
</body>
</html>
