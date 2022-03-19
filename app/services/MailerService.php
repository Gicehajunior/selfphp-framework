<?php

namespace App\services;

use SelfPhp\SP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailerService
{

    public $config;

    public $mail_driver;
    public $mail_host;
    public $mail_port;
    public $mail_encryption_criteria;
    public $mail_encoding;
    public $mail_timeout;
    public $mail_debug;
    public $sender_email_username;

    public $sender_email_address;
    public $sender_email_address_password;

    public $recipient_email_address;

    public $header_name;
    public $subject;
    public $message;
    public $html_body;
    public $attachment;

    public function __construct($header_name, $subject = null, $message = null, $html_body = null, $attachment = [], $recipient)
    {
        $this->config = null;
        $this->header_name = $header_name;
        $this->subject = $subject;
        $this->message = $message;
        $this->html_body = $html_body;
        $this->attachment = $attachment;
        $this->recipient_email_address = $recipient;

        $this->config = SP::request_config("mailer");

        $this->mail_driver = $this->config['mail_driver'];
        $this->mail_host = $this->config['mailer']['smtp']['host'];
        $this->mail_port = $this->config['mailer']['smtp']['port'];
        $this->mail_encoding = $this->config['mailer']['smtp']['encoding'];
        $this->mail_timeout = $this->config['mailer']['smtp']['timeout'];
        $this->mail_debug = $this->config['mailer']['smtp']['debug'];
        $this->mail_encryption_criteria = $this->config['mailer']['smtp']['encryption_criteria'];
        $this->sender_email_address = $this->config['source']['email_address'];
        $this->sender_email_username = $this->config['source']['email_username'];
    }

    public function php_mailer()
    {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = $this->mail_debug;                       // Disable verbose debug output

            if ($this->mail_driver == 'smtp') {                         // Send using SMTP or else
                $mail->isSMTP();
            }

            $mail->Host       = $this->mail_host;                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Timeout    = $this->mail_timeout;                    // Apply Timeout    
            $mail->Username   = $this->sender_email_address;            // SMTP username
            $mail->Password   = $this->sender_email_address_password;   // SMTP password
            
            // Enable encryption
            if ($this->mail_encryption_criteria == 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } else if ($this->mail_encryption_criteria == 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            }
            else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            }

            $mail->Port       = $this->mail_port;                       // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->CharSet  = $this->mail_encoding;

            //Recipients
            $mail->setFrom($this->sender_email_address, $this->header_name);

            if (is_array($this->recipient_email_address)) {
                if (count($this->recipient_email_address) > 0) {
                    foreach ($this->recipient_email_address as $email_address) {
                        $mail->addAddress($email_address);              // Add a recipient
                    }
                }
            } else {
                if (!empty($this->recipient_email_address)) {
                    $email_address = $this->recipient_email_address;
                    $mail->addAddress($email_address);
                }
            }

            // Attachmentsmail.urbanviewhotel@booking.com
            if (is_array($this->attachment)) {
                if (count($this->attachment) > 0) {
                    foreach ($this->attachment as $attachment) {
                        $mail->addAttachment($attachment);              // Add attachments 
                    }
                }
            } else {
                if (!empty($this->attachment)) {
                    $attachment = $this->attachment;
                    $mail->addAttachment($attachment);                   // Add attachment
                }
            }

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = $this->subject;
            $mail->Body    = $this->html_body;
            $mail->AltBody = $this->message;

            if ($mail->send()) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
