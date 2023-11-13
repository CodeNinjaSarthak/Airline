<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $placeName = $_POST["place_name"];
    $seatNumber = $_POST["seatNumber"];
    $arrivalDate = $_POST["arrival_date"];
    $leavingDate = $_POST["leaving_date"];

    $bookingData = "Place Name: $placeName\nSeat Number: $seatNumber\nArrival Date: $arrivalDate\nLeaving Date: $leavingDate\n\n";

    $filePath = "booking_data.txt";

    $file = fopen($filePath, "a");

    if ($file) {
        fwrite($file, $bookingData);

        fclose($file);

        header("Location: success_page.html");
        exit();
    } else {
        header("Location: error_page.php?error_message=" . urlencode("Error: Unable to open the file."));
        exit();
    }
} else {
    header("Location: error_page.php?error_message=" . urlencode("Error: Invalid form submission."));
    exit();
}
?>
