<?php
$task_id = $_GET['id'];

$conn = new mysqli("localhost", "root", "", "task_management1");

$sql = "DELETE FROM tasks WHERE id = $task_id";

if ($conn->query($sql) === TRUE) {
    header("Location: fetch_dates.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
