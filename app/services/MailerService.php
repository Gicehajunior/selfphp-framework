<?php

namespace App\services;

use SelfPhp\SP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Class MailerService
 * Handles email sending using PHPMailer library.
 *
 * @since Class available since Release 1.0.0
 */
class MailerService
{
    /**
     * @var null|array The configuration array.
     */
    public $config;

    /**
     * @var string The driver for email service (e.g., 'smtp').
     */
    public $mail_driver;

    /**
     * @var string The SMTP server host.
     */
    public $mail_host;

    /**
     * @var int The SMTP server port.
     */
    public $mail_port;

    /**
     * @var string The encoding type for email (e.g., 'UTF-8').
     */
    public $mail_encoding;

    /**
     * @var int The timeout for the email service.
     */
    public $mail_timeout;

    /**
     * @var int The debug level for SMTP (0 for no output, 1 for client messages, 2 for client and server messages).
     */
    public $mail_debug;

    /**
     * @var string The encryption criteria for SMTP (e.g., 'tls', 'ssl').
     */
    public $mail_encryption_criteria;

    /**
     * @var string The default method for sending mail service.
     */
    public $mail_service_default_method;

    /**
     * @var string The sender's email address.
     */
    public $sender_email_address;

    /**
     * @var string The username associated with the sender's email address.
     */
    public $sender_email_username;

    /**
     * @var string The sender's email address password.
     */
    public $sender_email_address_password;

    /**
     * @var string|array The recipient email address or an array of addresses.
     */
    public $recipient_email_address;

    /**
     * @var string The name to be used as the sender's name in the email header.
     */
    public $header_name;

    /**
     * @var string|null The subject of the email.
     */
    public $subject;

    /**
     * @var string|null The plain text version of the email.
     */
    public $message;

    /**
     * @var string|null The HTML body of the email.
     */
    public $html_body;

    /**
     * @var array An array of file paths for email attachments.
     */
    public $attachment;

    /**
     * @var string The path to the directory containing email templates.
     */
    public $email_templates_path;

    /**
     * @var string|null The name of the template file for rendering HTML content.
     */
    public $template_file;

    /**
     * Constructor for the MailerService class.
     * 
     * @param string $header_name The name to be used as the sender's name in the email header.
     * @param string|array $recipient The recipient email address or an array of addresses.
     * @param string|null $html_body The HTML body of the email.
     * @param string|null $subject The subject of the email.
     * @param string|null $sender_email_address The sender's email address.
     * @param string|null $sender_email_address_password The sender's email address password.
     * @param string|null $message The plain text version of the email.
     * @param string|null $sender_email_username The username associated with the sender's email address.
     * @param array $attachment An array of file paths for email attachments.
     */

    public function __construct($header_name, $recipient, $html_body = null, $subject = null, $sender_email_address = null, $sender_email_address_password = null, $message = null, $sender_email_username = null, $attachment = [])
    {
        $this->config = null;
        $this->header_name = $header_name;
        $this->subject = $subject;
        $this->message = $message;
        $this->html_body = $html_body;
        $this->attachment = $attachment;
        $this->recipient_email_address = $recipient;

        $this->config = (new SP())->request_config("mailer");

        $this->mail_driver = $this->config['mail_driver'];
        $this->mail_host = $this->config['mailer']['smtp']['host'];
        $this->mail_port = $this->config['mailer']['smtp']['port'];
        $this->mail_encoding = $this->config['mailer']['smtp']['encoding'];
        $this->mail_timeout = $this->config['mailer']['smtp']['timeout'];
        $this->mail_debug = $this->config['mailer']['smtp']['debug'];
        $this->mail_encryption_criteria = $this->config['mailer']['smtp']['encryption_criteria'];
        $this->mail_service_default_method = $this->config['mail_service_default_method'];
        $this->sender_email_address = ($sender_email_address) ? $this->config['source']['email_address'] : $this->config['source']['email_address'];
        $this->sender_email_username = ($sender_email_username) ? $sender_email_username : (($sender_email_address) ? $sender_email_address : $this->config['source']['email_username']);
        $this->sender_email_address_password = ($sender_email_address_password) ? $sender_email_address_password : ($this->config['source']['email_password']);
        $this->email_templates_path = $this->config['markup_lang']['default']['path'];
    }

    /**
     * Sends an email using PHPMailer.
     * 
     * @param string|null $template_file The name of the template file for rendering HTML content.
     * @return bool True if the email is sent successfully, false otherwise.
     */
    public function php_mailer($template_file = null)
    {
        if (is_array($this->html_body)) {
            $this->template_file = $template_file;

            $this->email_template = $this->email_templates_path . DIRECTORY_SEPARATOR . $this->template_file . '.php'; 

            if (is_file($this->email_template)) { 
                $this->html_body = fileParser(
                    $this->html_body, 
                    $this->email_template
                ); 
            } 
        }
        
        if (isset($this->mail_service_default_method)) {  
            if (__FUNCTION__ == $this->mail_service_default_method) {
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

                    $mail->Port     = $this->mail_port;                       // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
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
                    SP::debugBacktraceShow($e);
                    return false;
                }
            }
            else {
                $e = "No default mailing service method set!";
                SP::debugBacktraceShow($e);
    
                return false;
            }
        }
        else {
            $e = "No default mailing service set!";
            SP::debugBacktraceShow($e);

            return false;
        }
    }
}
