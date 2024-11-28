<?php
$task_id = $_GET['id'];

$conn = new mysqli("localhost", "root", "", "task_management1");

$sql = "SELECT * FROM tasks WHERE id = $task_id";
$result = $conn->query($sql);
$task = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="fetch_dates.css">
</head>
<body>
    <div class="container">
        <h1>Edit Task</h1>
        <form action="edit_task_backend.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
            <div>
                <label for="task_name">Task Name:</label>
                <input type="text" id="task_name" name="task_name" value="<?php echo $task['task_name']; ?>" required>
            </div>
            <div>
                <label for="assigned_to">Assigned To:</label>
                <input type="text" id="assigned_to" name="assigned_to" value="<?php echo $task['assigned_to']; ?>">
            </div>
            <div>
                <label for="due_date">Due Date:</label>
                <input type="date" id="due_date" name="due_date" value="<?php echo $task['due_date']; ?>" required>
            </div>
            <div>
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="stuck" <?php if ($task['status'] === 'stuck') echo 'selected'; ?>>Stuck</option>
                    <option value="working on it" <?php if ($task['status'] === 'working on it') echo 'selected'; ?>>Working on it</option>
                    <option value="done" <?php if ($task['status'] === 'done') echo 'selected'; ?>>Done</option>
                </select>
            </div>
            <div>
                <label for="priority">Priority:</label>
                <select id="priority" name="priority">
                    <option value="low" <?php if ($task['priority'] === 'low') echo 'selected'; ?>>Low</option>
                    <option value="medium" <?php if ($task['priority'] === 'medium') echo 'selected'; ?>>Medium</option>
                    <option value="high" <?php if ($task['priority'] === 'high') echo 'selected'; ?>>High</option>
                </select>
            </div>
            <button type="submit">Update Task</button>
        </form>
    </div>
</body>
</html>
