<?php
// Start the session
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Retrieve user data from the session
$user = $_SESSION['user'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "task_management1");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search and filter variables
$search = $_GET['search'] ?? '';
$filter_column = $_GET['filter_column'] ?? '';
$filter_order = $_GET['filter_order'] ?? '';
$where_clause = '';
$order_clause = '';

// Handle search functionality
if ($search) {
    $search = $conn->real_escape_string($search);
    $where_clause = "WHERE task_name LIKE '%$search%' 
                     
                     OR assigned_to LIKE '%$search%' 
                     OR status LIKE '%$search%'";
}

// Handle sorting functionality
if ($filter_column && $filter_order) {
    $filter_column = $conn->real_escape_string($filter_column);
    $filter_order = strtoupper($conn->real_escape_string($filter_order));
    if (in_array($filter_column, ['due_date', 'priority']) && in_array($filter_order, ['ASC', 'DESC'])) {
        $order_clause = "ORDER BY $filter_column $filter_order";
    }
}

// Fetch tasks based on search and filter criteria
$query = "SELECT id, task_name, assigned_to, due_date, status, priority 
          FROM tasks $where_clause $order_clause";
$tasks = $conn->query($query);

if (!$tasks) {
    die("Error fetching tasks: " . $conn->error);
}

// Fetch tasks with deadlines within the next 3 days for reminders
$current_date = date('Y-m-d');
$reminder_date = date('Y-m-d', strtotime('+3 days'));
$reminders = $conn->query("SELECT task_name, assigned_to, due_date FROM tasks 
                           WHERE due_date <= '$reminder_date' 
                           AND due_date >= '$current_date'");

if (!$reminders) {
    die("Error fetching reminders: " . $conn->error);
}

// Close the database connection after fetching data
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="mainpage.css">
    <style>
        /* Color-coded priorities */
        .priority-low { background-color: #d4edda; } /* Green */
        .priority-medium { background-color: #fff3cd; } /* Yellow */
        .priority-high { background-color: #f8d7da; } /* Red */
        .notifications { background-color: #fff8e1; border: 1px solid #ffe0b2; padding: 15px; margin: 15px 0; border-radius: 5px; }
        .notifications h3 { margin: 0; color: #ff6f00; }
        .notifications p { margin: 5px 0; }
        form { margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h1>
            <a href="logout.php">Log Out</a>
        </header>

        <main>
            <!-- Notifications for upcoming deadlines -->
            <?php if ($reminders && $reminders->num_rows > 0): ?>
                <div class="notifications">
                    <h3>Upcoming Deadlines:</h3>
                    <?php while ($reminder = $reminders->fetch_assoc()): ?>
                        <p>
                            Task: <?php echo htmlspecialchars($reminder['task_name']); ?> | 
                            Due Date: <?php echo htmlspecialchars($reminder['due_date']); ?> | 
                            Assigned To: <?php echo htmlspecialchars($reminder['assigned_to']); ?>
                        </p>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="notifications">
                    <p>No upcoming deadlines.</p>
                </div>
            <?php endif; ?>

            <h2>Task Management</h2>
            <!-- Search and Filter -->
            <form method="GET">
                <input type="text" name="search" placeholder="Search by name, status, etc." value="<?php echo htmlspecialchars($search); ?>">
                <select name="filter_column">
                    <option value="">Sort By</option>
                    <option value="due_date" <?php echo $filter_column === 'due_date' ? 'selected' : ''; ?>>Due Date</option>
                    <option value="priority" <?php echo $filter_column === 'priority' ? 'selected' : ''; ?>>Priority</option>
                </select>
                <select name="filter_order">
                    <option value="">Order</option>
                    <option value="ASC" <?php echo $filter_order === 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                    <option value="DESC" <?php echo $filter_order === 'DESC' ? 'selected' : ''; ?>>Descending</option>
                </select>
                <button type="submit">Search</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Assigned To</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($tasks && $tasks->num_rows > 0) {
                        while ($task = $tasks->fetch_assoc()) {
                            $id = htmlspecialchars($task['id']);
                            $priority_class = $task['priority'] === 'low' ? 'priority-low' : 
                                              ($task['priority'] === 'medium' ? 'priority-medium' : 
                                              ($task['priority'] === 'high' ? 'priority-high' : ''));

                            echo "<tr>
                                    <td>" . htmlspecialchars($task['task_name']) . "</td>
                                    <td>" . htmlspecialchars($task['assigned_to']) . "</td>
                                    <td>" . htmlspecialchars($task['due_date']) . "</td>
                                    <td>" . htmlspecialchars($task['status']) . "</td>
                                    <td class='$priority_class'>" . htmlspecialchars($task['priority']) . "</td>
                                    <td>
                                        <a href='edit_task.php?id={$id}'>Edit</a>
                                        <a href='delete_task.php?id={$id}'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No tasks available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="add_task.php">Add New Task</a>
        </main>
    </div>
</body>
</html>
