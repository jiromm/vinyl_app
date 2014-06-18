<?php

namespace Vinyl\Entity;

use Vinyl\Library\EntityBase;

class Category extends EntityBase {
	protected $id;
	protected $name;
	protected $order;

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setOrder($order) {
		$this->order = $order;
	}

	public function getOrder() {
		return $this->order;
	}
}
