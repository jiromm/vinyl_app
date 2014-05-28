<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

include("WideImage/WideImage.php");
include("../../Config.php");

header('Content-Type: application/json');

define('IMG', 'house-img-form');

define('UNKNOWN', 'Unknown type of request');
define('UNKNOWN_CODE', 2);

define('MISSING', 'Something wrong with uploaded file, something missing!');
define('MISSING_CODE', 3);

define('UNSUPPORTED', 'Unsupported file type');
define('UNSUPPORTED_CODE', 4);

define('RESIZE_ERROR', 'Image processing error. Please try again later');
define('RESIZE_ERROR_CODE', 5);

define('CROP_ERROR', 'Image processing error. Please try again later');
define('CROP_ERROR_CODE', 6);

$result = [
	'status' => 'error',
	'code' => 1,
	'message' => 'Something went wrong. Please try again later',
];

try {
	if (isset($_POST)) {
		$imgHeight = 200;
		$imgWidth = 500;
		$destinationDirectory = '../archive/uploaded/';
		$imgUrl = HOST . BASE_DIR . 'archive/uploaded/';
		$quality = 96;

		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			throw new Exception(UNKNOWN, UNKNOWN_CODE);
		}

		if(!isset($_FILES[IMG])) {
			throw new Exception(MISSING, MISSING_CODE);
		}

		$randomNumber = rand(0, 9999999999);

		$imageName = str_replace(' ', '-', strtolower($_FILES[IMG]['name']));
		$imageSize = $_FILES[IMG]['size'];
		$tempSrc = $_FILES[IMG]['tmp_name'];
		$imageType = $_FILES[IMG]['type'];

		if (!in_array($imageType, ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg'])) {
			throw new Exception(UNSUPPORTED, UNSUPPORTED_CODE);
		}

		list($curWidth, $curHeight) = getimagesize($tempSrc);

		$imageExt = 'jpg';
		$imageName = pathinfo($_FILES[IMG]['tmp_name'], PATHINFO_FILENAME);
		$newImageName = $imageName . '-' . $randomNumber . '.' . $imageExt;
		$destRandImageName = $destinationDirectory . $newImageName;
		$urlRandImageName = $imgUrl . $newImageName;

		$image = WideImage::load($_FILES[IMG]['tmp_name']);

		if ($curWidth / $curHeight > 5 / 3) {
			$image = $image->resize(500, 300, 'inside', 'down');
		} else {
			$image = $image->resize(500, 300, 'outside', 'down');
		}

		$image = $image->crop('center', 'center', 500, 300);

		$image->saveToFile($destRandImageName);

		$result = [
			'status' => 'success',
			'code' => 0,
			'url' => $urlRandImageName,
		];
	}
} catch (Exception $ex) {
	$result['code'] = $ex->getCode();
	$result['message'] = $ex->getMessage();
}

echo json_encode($result);
