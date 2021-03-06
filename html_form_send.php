<?php
if(isset($_POST['email'])) {

	// CHANGE THE TWO LINES BELOW
	$email_to = "kkygammaservice@gmail.com";

	$email_subject = "Jr/Sr Day";

	function died($error) {
		header('Location: http://students.washington.edu/kkpsi/jrsrday/#error');
		// your error code can go here
		echo "We're sorry, but there's errors found with the form you submitted.<br /><br />";
		echo $error."<br /><br />";
		echo "Please go back and fix these errors.<br /><br />";
		die();
	}

	// validation expected data exists
	if(!isset($_POST['name']) ||
		!isset($_POST['email']) ||
		!isset($_POST['message'])) {
		died('We are sorry, but there appears to be a problem with the form you submitted.');
	}

	$name = $_POST['name']; // required
	$email = $_POST['email']; // required
	$message = $_POST['message']; // required

	$error_message = "";
	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email)) {
  	$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }

	/*if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
  	echo("$email is a valid email address");
	} else {
	  $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
	}*/

	$string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$name)) {
  	$error_message .= 'The name you entered does not appear to be valid.<br />';
  }
  if(strlen($message) < 2) {
  	$error_message .= 'The message you entered do not appear to be valid.<br />';
  }
  if(strlen($error_message) > 0) {
  	died($error_message);
  }
	$email_message = "Form details below.\n\n";

	function clean_string($string) {
	  $bad = array("content-type","bcc:","to:","cc:","href");
	  return str_replace($bad,"",$string);
	}

	$email_message .= "Name: ".clean_string($name)."\n";
	$email_message .= "Email: ".clean_string($email)."\n";
	$email_message .= "message: ".clean_string($message)."\n";


// create email headers
$headers = 'From: '.$email."\r\n".
'Reply-To: '.$email."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);

//Success redirect
header('Location: http://students.washington.edu/kkpsi/jrsrday');
}
?>
