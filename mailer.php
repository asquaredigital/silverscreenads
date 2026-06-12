<?php
header('Content-Type: application/json');

// Allowed origin (set to your domain in production)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Collect and sanitize inputs
$name     = htmlspecialchars(strip_tags(trim($_POST['name'] ?? '')));
$phone    = htmlspecialchars(strip_tags(trim($_POST['phone'] ?? '')));
$business = htmlspecialchars(strip_tags(trim($_POST['business'] ?? '')));
$adtype   = htmlspecialchars(strip_tags(trim($_POST['adtype'] ?? '')));
$message  = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

// Basic validation
if (empty($name) || empty($phone) || empty($business) || empty($adtype)) {
    echo json_encode(['success' => false, 'message' => 'Required fields are missing.']);
    exit;
}

// Recipient
$to      = 'silverscreenads25@gmail.com';
$subject = "New Ad Enquiry from $name – Silver Screen Ads Website";

// Email body
$body = "
New Enquiry Received — Silver Screen Ads Website
=================================================

Name           : $name
Phone          : $phone
Business/Brand : $business
Ad Type        : $adtype

Message:
$message

-------------------------------------------------
Sent from the Silver Screen Ads website contact form.
";

// Headers
$headers  = "From: noreply@silverscreenads.in\r\n";
$headers .= "Reply-To: $phone\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send mail
$sent = mail($to, $subject, $body, $headers);

if ($sent) {
    echo json_encode(['success' => true, 'message' => 'Email sent successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send email.']);
}
?>
