<?php
/**
 * SMTP configuration - TEMPLATE.
 *
 * Copy this file to `mail-config.php` (same folder) and fill in your real
 * credentials. `mail-config.php` is gitignored so secrets never reach the repo.
 *
 *   cp mail-config.example.php mail-config.php
 *
 * On Hostinger, create an email account (e.g. no-reply@pramishthapa.com) in
 * hPanel > Emails, then use its SMTP details below.
 */

return [
    // SMTP server - Hostinger uses smtp.hostinger.com
    'host'       => 'smtp.hostinger.com',
    'port'       => 465,          // 465 = SMTPS (SSL), 587 = STARTTLS
    'encryption' => 'ssl',        // 'ssl' for 465, 'tls' for 587
    'username'   => 'no-reply@pramishthapa.com',
    'password'   => 'YOUR_SMTP_PASSWORD_HERE',

    // The message is sent FROM you TO you (contents in the body).
    'from_email' => 'no-reply@pramishthapa.com',
    'from_name'  => 'Portfolio Contact Form',
    'to_email'   => 'you@example.com',   // where you want to receive messages
    'to_name'    => 'Pramish Thapa',
];
