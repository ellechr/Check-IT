<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect data from the form
$task_name = htmlspecialchars($_POST['task_name']);
$assigned_to = htmlspecialchars($_POST['assigned_to']);
$due_date = htmlspecialchars($_POST['due_date']);
$status = htmlspecialchars($_POST['status']);
$priority = htmlspecialchars($_POST['priority']);

$sql = "INSERT INTO tasks (task_name, assigned_to, due_date, status, priority) 
        VALUES ('$task_name', '$assigned_to', '$due_date', '$status', '$priority')";

if ($conn->query($sql) === TRUE) {
    header("Location: fetch_dates.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
