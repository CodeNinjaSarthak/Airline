<?php

$file = fopen("passenger_queue.txt", "r");
$data = fread($file, filesize("passenger_queue.txt"));
fclose($file);


$lines = explode("\n", $data);

$passengerName = getValue($lines, "Passenger Name:");
$bookingReference = getValue($lines, "Booking Reference:");
$flightNumber = getValue($lines, "Flight Number:");
$departure = getValue($lines, "Departure:");
$arrival = getValue($lines, "Arrival:");
$dateTime = getValue($lines, "Date Time:");
$seat = getValue($lines, "Seat:");
$gate = getValue($lines, "Gate:");
$price = getValue($lines, "Price:");

$template = file_get_contents("ticket.html");

$template = str_replace("<?php echo $passengerName; ?>", $passengerName, $template);
$template = str_replace("<?php echo $bookingReference; ?>", $bookingReference, $template);
$template = str_replace("<?php echo $flightNumber; ?>", $flightNumber, $template);
$template = str_replace("<?php echo $departure; ?>", $departure, $template);
$template = str_replace("<?php echo $arrival; ?>", $arrival, $template);
$template = str_replace("<?php echo $dateTime; ?>", $dateTime, $template);
$template = str_replace("<?php echo $seat; ?>", $seat, $template);
$template = str_replace("<?php echo $gate; ?>", $gate, $template);
$template = str_replace("<?php echo $price; ?>", $price, $template);

echo $template;

function getValue($lines, $fieldName) {
    foreach ($lines as $line) {
        if (strpos($line, $fieldName) !== false) {
            return trim(str_replace($fieldName, "", $line));
        }
    }
    return "";
}
?>
