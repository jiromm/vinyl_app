<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(-1);

header('Content-Type: application/json');

$result = ['status' => 'error'];

if (count($_POST)) {
	$image = $_POST['image'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$remarks = $_POST['remarks'];

	$result = ['status' => 'success'];
}

return json_encode($result);
