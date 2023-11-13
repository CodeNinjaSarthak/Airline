<?php
$servername = "localhost";
$username = "root";
$password = "sarthak@1226";
$database = "test";

$socket = "/tmp/mysql.sock";
$conn = new mysqli($servername, $username, $password, $database, null, $socket);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = "John Doe";

// Fetch passenger data from the database using a prepared statement
$sql = "SELECT * FROM passengers WHERE passenger_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $passengerName = $row['passenger_name'];
    $bookingReference = $row['booking_reference'];
    $flightNumber = $row['flight_number'];
    $departure = $row['departure'];
    $arrival = $row['arrival'];
    $dateTime = $row['date_time'];
    $seat = $row['seat'];
    $gate = $row['gate'];
    $price = $row['price'];

    $stmt->close();
    $conn->close();

    include "ticket.html";
} else {
    echo "Passenger not found";
}
?>