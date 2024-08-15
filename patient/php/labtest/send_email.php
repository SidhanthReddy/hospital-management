<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $to = $data['email'];
    $subject = 'Payment Confirmation';
    $message = 'Your payment has been successfully processed. Your ID is ' . $data['id'];
    $headers = 'From: no-reply@mayo.com' . "\r\n" .
               'Reply-To: no-reply@mayo.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email.']);
    }
}
?>
