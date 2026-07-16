<?php
/**
 * AJAX contact-form endpoint.
 *
 * Receives the contact form via POST, sanitises the input server-side,
 * and sends an email FROM the site address TO Pramish using PHPMailer
 * over authenticated SMTP. Always responds with JSON so the front end
 * can show a success/failure message without reloading the page.
 *
 * SMTP credentials live in mail-config.php (gitignored).
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

/** Send a JSON response and stop. */
function respond(string $status, string $message, int $code = 200): void
{
    http_response_code($code);
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// Only accept POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond('error', 'Invalid request method.', 405);
}

// Load gitignored SMTP config.
$configPath = __DIR__ . '/mail-config.php';
if (!is_file($configPath)) {
    respond('error', 'Mail is not configured yet. Please try again later.', 500);
}
$config = require $configPath;

// ---- Server-side sanitisation -------------------------------------------
function clean(string $value): string
{
    // Strip tags, trim, collapse control chars.
    $value = trim($value);
    $value = strip_tags($value);
    return preg_replace('/[\r\n\t]+/', ' ', $value) ?? '';
}

$name    = clean($_POST['name']    ?? '');
$email   = trim($_POST['email']    ?? '');
$subject = clean($_POST['subject'] ?? '');
$message = trim(strip_tags($_POST['message'] ?? ''));
$honey   = trim($_POST['website']  ?? ''); // honeypot - must stay empty

// ---- Anti-spam honeypot: silently succeed so bots don't retry -----------
if ($honey !== '') {
    respond('success', 'Your message has been sent. Thank you!');
}

// ---- Server-side validation ---------------------------------------------
$errors = [];
if ($name === '' || mb_strlen($name) > 100)          $errors[] = 'name';
if ($subject === '' || mb_strlen($subject) > 150)    $errors[] = 'subject';
if ($message === '' || mb_strlen($message) > 3000)   $errors[] = 'message';
if (!filter_var($email, FILTER_VALIDATE_EMAIL))      $errors[] = 'email';

if ($errors) {
    respond('error', 'Please complete all fields with a valid email address.', 422);
}

$email = filter_var($email, FILTER_SANITIZE_EMAIL);

// ---- Compose and send ----------------------------------------------------
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = $config['host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $config['username'];
    $mail->Password   = $config['password'];
    $mail->SMTPSecure = $config['encryption'] === 'tls'
        ? PHPMailer::ENCRYPTION_STARTTLS
        : PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = (int) $config['port'];
    $mail->CharSet    = 'UTF-8';

    // FROM the site address, TO Pramish, REPLY-TO the visitor.
    $mail->setFrom($config['from_email'], $config['from_name']);
    $mail->addAddress($config['to_email'], $config['to_name']);
    $mail->addReplyTo($email, $name);

    $mail->Subject = 'Portfolio contact: ' . $subject;

    $bodyLines = [
        'You have a new message from your portfolio contact form.',
        '',
        'Name:    ' . $name,
        'Email:   ' . $email,
        'Subject: ' . $subject,
        '',
        'Message:',
        $message,
    ];
    $mail->Body = implode("\n", $bodyLines);

    $mail->send();
    respond('success', 'Your message has been sent. Thank you!');
} catch (Exception $e) {
    // Log the detailed error server-side; never leak SMTP details to the client.
    error_log('Contact form mail error: ' . $mail->ErrorInfo);
    respond('error', 'Sorry, your message could not be sent. Please try again later.', 500);
}
