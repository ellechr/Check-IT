<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the current user's email from the session
$user_email = $_SESSION['user']['email'];

// Check if the user is an admin (case-insensitive check for 'admin' in the email)
if (stripos($user_email, "admin") === false) { // `stripos` is case-insensitive
    echo "Error: You do not have permission to delete tasks.";
    exit();
}

// Validate the task ID from the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Error: Invalid task ID.";
    exit();
}

$task_id = intval($_GET['id']);

// Connect to the database
$conn = new mysqli("localhost", "root", "", "task_management1");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->bind_param("i", $task_id);

if ($stmt->execute()) {
    // Redirect back to the tasks page
    header("Location: fetch_dates.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
