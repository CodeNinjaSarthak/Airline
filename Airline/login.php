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

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            header("Location: index.html");
            exit(); 
        } else {
           
            header("Location: registration.html");
            exit();
        }
    } else {
        
        header("Location: registration.html");
        exit(); 
    }

   
    $stmt->close();
    $conn->close();
}
?>
