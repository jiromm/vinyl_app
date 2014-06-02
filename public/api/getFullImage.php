<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(-1);

include("WideImage/WideImage.php");
include("../../Config.php");

header('Content-Type: application/json');

if (count($_POST)) {
	$baseUrl = $_POST['images']['base'];
	$overUrl = $_POST['images']['over'];
	$baseWidth = $_POST['position']['baseWidth'];
	$baseHeight = $_POST['position']['baseHeight'];
	$overWidth = $_POST['position']['overWidth'];
	$overHeight = $_POST['position']['overHeight'];
	$left = $_POST['position']['left'];
	$top = $_POST['position']['top'];

	$destinationDirectory = '../archive/processed/';
	$imgUrl = HOST . BASE_DIR . 'archive/processed/';

	$base = WideImage::load($baseUrl);
	$over = WideImage::load($overUrl)->resize($overWidth, $overHeight);
	$new = $base->merge($over, $left, $top, 100);
	$name = mt_rand(1000000000, 9999999999) . '.jpg';
	$new->saveToFile($destinationDirectory . $name, 95);

	$result = [
		'url' => $imgUrl . $name,
	];
} else {
	$result = [
		'url' => null
	];
}

echo json_encode($result);
