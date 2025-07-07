<?php
/**
 * PHP Email Sending Script for The Giant Movers Quote Form
 *
 * This script processes the form submission from get-a-quote.html,
 * formats the data, and sends it as an email.
 *
 * It uses a simple mail() function, which requires your server to be configured
 * to send emails. For more robust email sending (e.g., with SMTP, error handling,
 * and better spam prevention), consider using a library like PHPMailer.
 */

// Define your recipient email address
$receiving_email_address = 'info@thegiantmovers.com'; // Change this to your actual receiving email

// --- Configuration for messages (optional, can be passed back to JS) ---
$sent_message = 'Your moving quote request has been sent successfully. Thank You!';
$error_message = 'There was an error sending your message. Please try again later.';

// --- Process Form Data ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);

    $departure_location = filter_var($_POST['departure_location'], FILTER_SANITIZE_STRING);
    $delivery_location = filter_var($_POST['delivery_location'], FILTER_SANITIZE_STRING);
    $preferred_move_date = filter_var($_POST['preferred_move_date'], FILTER_SANITIZE_STRING);
    $type_of_property = filter_var($_POST['type_of_property'], FILTER_SANITIZE_STRING);
    $number_of_bedrooms = isset($_POST['number_of_bedrooms']) ? filter_var($_POST['number_of_bedrooms'], FILTER_SANITIZE_STRING) : 'Not specified';
    $service_needed = filter_var($_POST['service_needed'], FILTER_SANITIZE_STRING);
    $additional_message = filter_var($_POST['additional_message'], FILTER_SANITIZE_STRING);

    // --- Prepare Email Content ---
    $subject = "New Quote Request from Website: " . $name;

    $email_content = "Name: " . $name . "\n";
    $email_content .= "Email: " . $email . "\n";
    $email_content .= "Phone: " . $phone . "\n\n";

    $email_content .= "--- Moving Details ---\n";
    $email_content .= "Current Location: " . $departure_location . "\n";
    $email_content .= "Destination: " . $delivery_location . "\n";
    $email_content .= "Preferred Move Date: " . $preferred_move_date . "\n";
    $email_content .= "Type of Property: " . $type_of_property . "\n";
    $email_content .= "Number of Bedrooms: " . $number_of_bedrooms . "\n";
    $email_content .= "Service Needed: " . $service_needed . "\n\n";
    $email_content .= "Additional Message:\n" . $additional_message . "\n";

    // --- Set up Email Headers ---
    $headers = "From: Website Quote <noreply@yourdomain.com>\r\n"; // IMPORTANT: Change 'yourdomain.com' to your actual domain
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // --- Send Email ---
    if (mail($receiving_email_address, $subject, $email_content, $headers)) {
        // Success: Redirect back to the form with a success parameter or message
        // For simple redirect:
        header('Location: ../get-a-quote.html?status=success');
        exit;
    } else {
        // Failure: Redirect back to the form with an error parameter or message
        header('Location: ../get-a-quote.html?status=error');
        exit;
    }
} else {
    // Not a POST request, redirect to the form
    header('Location: ../get-a-quote.html');
    exit;
}
?>
