<?php

namespace Vinyl\Helper;

class CommonHelper {
	/**
	 * @param string $date
	 * @return bool|string
	 */
	public static function reformatDate($date) {
		return date('d M, Y', strtotime($date));
	}

	/**
	 * @param string $date
	 * @return bool|string
	 */
	public static function deformatDate($date) {
		return date('Y-m-d', strtotime($date));
	}
}
