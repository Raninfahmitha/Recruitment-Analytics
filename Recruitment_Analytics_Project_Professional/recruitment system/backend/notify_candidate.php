<?php
header('Content-Type: application/json');
require 'vendor/autoload.php'; // Composer autoloader
require 'db_config.php';
require 'mongodb_helper.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader if not already included
if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    require 'vendor/autoload.php';
}

// Function to send email notification
function sendNotificationEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'your_smtp_host';                     // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'your_smtp_username';                   // SMTP username
        $mail->Password   = 'your_smtp_password';                   // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS`

        // Recipients
        $mail->setFrom('your_sender_email', 'Recruitment System');
        $mail->addAddress($to);                                      // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = '<div style="background-color:#f0f4c3; padding:20px; border-radius:8px; font-family: sans-serif;">
                            <h2 style="color:#9ccc65;">' . $subject . '</h2>
                            <p style="color:#aed581;">' . $body . '</p>
                          </div>';
        $mail->AltBody = strip_tags($body); // Plain text version for non-HTML mail clients

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidateId = $_POST['candidate_id'] ?? '';
    $message = $_POST['message'] ?? '';
    $subject = $_POST['subject'] ?? 'Application Update'; // Default subject

    if ($candidateId && $message) {
        $collection = getMongoDBCollection();
        if ($collection) {
            $objectId = new MongoDB\BSON\ObjectId($candidateId);
            $candidate = $collection->findOne(['_id' => $objectId]);

            if ($candidate && isset($candidate['email'])) {
                $recipientEmail = $candidate['email'];
                if (sendNotificationEmail($recipientEmail, $subject, $message)) {
                    echo json_encode(['success' => true, 'message' => 'Notification sent successfully to ' . $recipientEmail]);

                    // Optionally, update the progress history in the database
                    $updateResult = $collection->updateOne(
                        ['_id' => $objectId],
                        ['$push' => ['progressHistory' => ['status' => 'Notification Sent: ' . $subject, 'timestamp' => new MongoDB\BSON\UTCDateTime()]]]
                    );
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to send notification email. Check server logs.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Candidate not found or email missing.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database connection error.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Candidate ID and message are required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>