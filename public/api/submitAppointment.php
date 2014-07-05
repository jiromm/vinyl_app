<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(-1);

include "phpmailer/class.phpmailer.php";

header('Content-Type: application/json');

$result = ['status' => 'error'];

if (count($_POST)) {
	$image = $_POST['image'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$remarks = $_POST['remarks'];

	$message = '
		<p><img src="' . $image . '"></p>
		<p><b>Name:</b> ' . $name . '</p>
		<p><b>Phone:</b> ' . $phone . '</p>
		<p><b>Email:</b> ' . $email . '</p>
		<p><b>Remarks:</b> ' . $remarks . '</p>
	';

	$mail = new PHPMailer;

	$mail->isSMTP();
	$mail->Host = 'rsj32.rhostjh.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'info@frontgatevinyl.com';
	$mail->Password = 'AT61tlrWEQ';
	$mail->SMTPSecure = 'tls';

	$mail->From = 'info@frontgatevinyl.com';
	$mail->FromName = 'Info';
	$mail->addAddress('info@frontgatevinyl.com');

	$mail->WordWrap = 50;
	$mail->isHTML(true);

	$mail->Subject = 'Appointment from Vinyl Fencing App';
	$mail->Body    = $message;
	$mail->AltBody = strip_tags($message) . PHP_EOL . 'Image URL: ' . $image;

	$mail->send();

	$result = ['status' => 'success'];
}

return json_encode($result);
