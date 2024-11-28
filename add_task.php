<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task</title>
    <link rel="stylesheet" href="add_task.css">
</head>
<body>
    <div class="container">
        <h1>Add New Task</h1>
        <form action="add_task_backend.php" method="POST">
            <div>
                <label for="task_name">Task Name:</label>
                <input type="text" id="task_name" name="task_name" required>
            </div>
            <div>
                <label for="task_description">Task Description:</label>
                <input type="text" id="task_description" name="task_description" required>
            </div>
            <div>
                <label for="assigned_to">Assigned To:</label>
                <input type="text" id="assigned_to" name="assigned_to">
            </div>
            <div>
                <label for="due_date">Due Date:</label>
                <input type="date" id="due_date" name="due_date" required>
            </div>
            <div>
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="stuck">Stuck</option>
                    <option value="working on it">Working on it</option>
                    <option value="done">Done</option>
                </select>
            </div>
            <div>
                <label for="priority">Priority:</label>
                <select id="priority" name="priority">
                    <option value="low" class="low-priority">Low</option>
                    <option value="medium" class="medium-priority">Medium</option>
                    <option value="high" class="high-priority">High</option>
                </select>
            </div>
            <button type="submit">Add Task</button>
        </form>
    </div>
</body>
</html>
