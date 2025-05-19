<?php
header('Content-Type: text/plain');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form fields
    $name = strip_tags(trim($_POST["name"] ?? ''));
    $name = str_replace(["\r", "\n"], [" ", " "], $name);
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST["subject"] ?? '');
    $message = trim($_POST["message"] ?? '');

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email address.";
        exit;
    }

    // Set recipient email address
    $recipient = "vijayjuvvanapudi12@gmail.com"; // Replace with your email

    // Set email subject
    $email_subject = "New Contact: $subject";

    // Build email content
    $email_content = "Name: $name\n\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message: $message\n\n";

    // Build email headers
    $email_headers = "From: $name <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";

    // Send the email
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Successfully sent";
    } else {
        http_response_code(500);
        echo "Message not sent, try again";
    }
} else {
    http_response_code(403);
    echo "Message not sent, try again";
}
?>