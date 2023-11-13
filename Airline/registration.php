<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "sarthak@1226";
    $database = "test";

    $socket = "/tmp/mysql.sock";

    $conn = new mysqli($servername, $username, $password, $database, null, $socket);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST["user_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Debugging statements
    echo "Debug: Password: $password, Confirm Password: $confirmPassword";

    // Check if email is unique
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkEmailQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Email already exists
        header("Location: error_page.php?error_message=" . urlencode("Error: Email already exists."));
        exit();
    }

    // Check if password is at least 6 characters long and confirm password matches
    if (strlen($password) < 6 || $password !== $confirmPassword) {
        header("Location: error_page.php?error_message=" . urlencode("Error: Password must be at least 6 characters long and confirm password must match."));
       // exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: registration_done.html");
    } else {
        // Handle other errors
        header("Location: error_page.php?error_message=" . urlencode("Error: " . $stmt->error));
        exit();
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
