<?php
// Database connection credentials
$servername = "localhost";  // Change this if your server is different
$username = "root";
$password = "";
$database = "task_management1";
 
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
 
// Check connection 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
 
// Close the connection
$conn->close();
?>
