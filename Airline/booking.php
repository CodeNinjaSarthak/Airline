<?php
$servername = "localhost";
$username = "root";
$password = "sarthak@1226";
$database = "test";
$socket = "/tmp/mysql.sock";

$conn = new mysqli($servername, $username, $password, $database, null, $socket);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$placeName = $conn->real_escape_string($_POST['place_name']);
$seatNumber = $conn->real_escape_string($_POST['seatNumber']);
$arrivalDate = $conn->real_escape_string($_POST['arrival_date']);
$departureDate = $conn->real_escape_string($_POST['leaving_date']);
$passengerName = "John Doe";

$checkSeatQuery = "SELECT * FROM booking WHERE seatNumber = '$seatNumber' AND arrivalDate = '$arrivalDate'";
$result = $conn->query($checkSeatQuery);

if ($result->num_rows > 0) {

    header("Location: seat_already_booked.html"); 
} else {
    $passengerInsertQuery = "";

    $airflightDetailsQuery = "SELECT booking_reference, flight_number, date_time, gate, price FROM airflight_details WHERE placeName='$placeName'"; // Fix the query, add single quotes around place_name
    $result = $conn->query($airflightDetailsQuery);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $bookingReference = $row['booking_reference'];
        $flightNumber = $row['flight_number'];
        $date_time = $row['date_time'];
        $gate = $row['gate'];
        $price = $row['price'];
        $passengerInsertQuery = "INSERT INTO passengers (passenger_name, booking_reference, flight_number, departure, arrival, date_time, seat, gate, price) VALUES ('$passengerName', '$bookingReference', '$flightNumber', '$departureDate', '$arrivalDate', '$date_time', '$seatNumber', '$gate', '$price')";
    }
    
    $bookingInsertQuery = "INSERT INTO booking (placeName, seatNumber, arrivalDate, departureDate) VALUES ('$placeName', '$seatNumber', '$arrivalDate', '$departureDate')";
    
    if ($conn->query($bookingInsertQuery) === TRUE) {

        if (!empty($passengerInsertQuery)) {
            if ($conn->query($passengerInsertQuery) === TRUE) {
                header("Location: booking_success.html");
            } else {
                echo "<p>Error: " . $passengerInsertQuery . "<br>" . $conn->error . "</p>";
            }
        } else {
            echo "Passenger data query is empty."; // Handle the case where passenger data query is empty
        }
    } else {
        echo "<p>Error: " . $bookingInsertQuery . "<br>" . $conn->error . "</p>";
    }
}

// Close the database connection
$conn->close();
?>
