<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $contact_id = $_POST['contact_id'];
    $contact_email = $_POST['contact_email'];
    $reply_message = $_POST['reply_message'];

    // Kirim email (misalnya menggunakan mail() atau PHPMailer)
    $to = $contact_email;
    $subject = "Reply to your message";
    $message = $reply_message;
    $headers = "From: your-email@example.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Reply sent successfully!";
    } else {
        echo "Failed to send reply.";
    }
}

?>