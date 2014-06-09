<?php

namespace Haymayrer\Helper;

use Haymayrer\Entity\Parents;

class ParentsHelper {
	/**
	 * @param Parents[]|null $entityArray
	 * @return array
	 */
	public static function reconstructList($entityArray) {
		$output = [];

		if ($entityArray) {
			foreach ($entityArray as $parent) {
				$output[$parent->getId()] = $parent->getName();
			}
		}

		return $output;
	}
}
