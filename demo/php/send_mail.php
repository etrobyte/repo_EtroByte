<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $form_type = $_POST['form_type'];

    $name = htmlspecialchars($_POST['name']);
    $message = htmlspecialchars($_POST['message']);
    // Handle different form types
    if ($form_type === "contact") {
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $subject = "New Contact Form Submission";

        $body = "
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Message:</strong> $message</p>
        ";

        $altBody = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";
    } elseif ($form_type === "contact-for-service") {
        $phone = htmlspecialchars($_POST['phone']);
        $service = htmlspecialchars($_POST['service']);
        $subject = "Contact for - $service";

        $body = "
            <h2>Contact for service</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Service:</strong> $service</p>
            <p><strong>Message:</strong> $message</p>
        ";

        $altBody = "Name: $name\nPhone: $phone\nService: $service\nMessage: $message";
    } else {
        echo "Invalid form submission.";
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'darshanub.dev@gmail.com'; // Your email
        $mail->Password   = 'mjlc rtir aloy rnuj'; // Your email password or app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & Recipient
        $mail->setFrom('darshanub.dev@gmail.com', 'No-Reply');
        $mail->addAddress('darshanub.dev@gmail.com', 'Recipient Name');

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "$subject";
        $mail->Body    = $body;
        $mail->AltBody = $altBody;

        // Send Email
        $mail->send();
        echo "Email sent successfully!";
        header("Location: ../index.html");
        exit();
    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "<script>console.log(`Invalid request!`)</script>";
}
