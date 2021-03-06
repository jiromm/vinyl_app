<?php

namespace Vinyl\Entity;

use Vinyl\Library\EntityBase;

class Fence extends EntityBase {
	protected $id;
	protected $category_id;
	protected $category;
	protected $category_order;
	protected $name;

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setCategoryId($category_id) {
		$this->category_id = $category_id;
	}

	public function getCategoryId() {
		return $this->category_id;
	}

	public function getCategory() {
		return $this->category;
	}

	public function getCategoryOrder() {
		return $this->category_order;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}
}
