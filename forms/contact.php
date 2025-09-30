<?php
  $receiving_email_address = 'basmala30311@gmail.com';

if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
  include( $php_email_form );
} else {
  die( 'Unable to load the "PHP Email Form" Library!');
}

// Sanitize and validate inputs
$name    = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
$email   = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
$subject = isset($_POST['subject']) ? trim(strip_tags($_POST['subject'])) : '';
$message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';

if (!$name || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$subject || !$message) {
  http_response_code(400);
  echo 'Invalid input. Please check your entries and try again.';
  exit;
}

$contact = new PHP_Email_Form;
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = $name;
$contact->from_email = $email;
$contact->subject = $subject;

// Optional SMTP settings if your server blocks mail()
// Fill with your SMTP provider credentials (e.g., hosting SMTP, Gmail with App Password)
// $contact->smtp = array(
//   'host' => 'smtp.yourprovider.com', // e.g., smtp.gmail.com
//   'username' => 'your_email@example.com',
//   'password' => 'your_smtp_or_app_password',
//   'port' => '587' // 587 for TLS, 465 for SSL depending on provider
// );

$contact->add_message( $name, 'From');
$contact->add_message( $email, 'Email');
$contact->add_message( $message, 'Message', 10);

echo $contact->send();

?>
