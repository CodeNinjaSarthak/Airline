<?php
$message = ""; 

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

    $name = $_POST["name"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $sql = "INSERT INTO message_table (name, email, number, subject, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $name, $email, $number, $subject, $message);

    if ($stmt->execute()) {
        // $message = "Message sent successfully!";
        header("Location: message_success.html");
        
        exit();
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>