<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management1";

// Establish the connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all tasks
$sql = "SELECT task_name, assigned_to, due_date, status, priority FROM tasks ORDER BY due_date ASC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link rel="stylesheet" href="fetch_dates.css">
</head>
<body>
    <div class="container">
        <h1>Task Management</h1>
        <table>
            <thead>
                <tr>
                    <th>Task Name</th>
                    <th>Assigned To</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Priority</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    // Display each task in a table row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['task_name']) . "</td>
                                <td>" . htmlspecialchars($row['assigned_to']) . "</td>
                                <td>" . htmlspecialchars($row['due_date']) . "</td>
                                <td>" . htmlspecialchars($row['status']) . "</td>
                                <td>" . htmlspecialchars($row['priority']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No tasks found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <button><a href="mainpage.php" style="text-decoration: none; color: white;">Go Back</a></button>
    </div>
</body>
</html>

<?php
// Close the database connection if it was established
if ($conn) {
    $conn->close();
}
?>
