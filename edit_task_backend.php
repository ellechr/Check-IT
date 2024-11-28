<?php
$conn = new mysqli("localhost", "root", "", "task_management1");

$id = htmlspecialchars($_POST['id']);
$task_name = htmlspecialchars($_POST['task_name']);
$assigned_to = htmlspecialchars($_POST['assigned_to']);
$due_date = htmlspecialchars($_POST['due_date']);
$status = htmlspecialchars($_POST['status']);
$priority = htmlspecialchars($_POST['priority']);

$sql = "UPDATE tasks SET 
        task_name = '$task_name',
        assigned_to = '$assigned_to',
        due_date = '$due_date',
        status = '$status',
        priority = '$priority'
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: fetch_dates.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
