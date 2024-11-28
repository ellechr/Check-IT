<?php
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "task_management1");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, store user data in session
            $_SESSION['user'] = $user; // Store user data (email) in session

            // Redirect to the user dashboard or main page
            header("Location: mainpage.php");
            exit(); // Stop script execution after redirect
        } else {
            // Incorrect password
            echo "Invalid password!";
        }
    } else {
        // No user found with the entered email
        echo "No user found with that email!";
    }

    // Close the database connection
    $conn->close();
}
?>
