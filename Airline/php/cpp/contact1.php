<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];


    $contactData = "Name: $name\nEmail: $email\nNumber: $number\nSubject: $subject\nMessage: $message\n\n";


    $filePath = "contact_data.txt";


    $file = fopen($filePath, "a");


    if ($file) {

        fwrite($file, $contactData);


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
