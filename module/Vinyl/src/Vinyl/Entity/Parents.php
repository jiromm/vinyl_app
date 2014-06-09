<?php

namespace Vinyl\Entity;

use Vinyl\Helper\CommonHelper;
use Vinyl\Library\EntityBase;

class Parents extends EntityBase {
	protected $id;
	protected $name;
	protected $birthday;
	protected $region;
	protected $district;
	protected $address;
	protected $address_residence;
	protected $phone;
	protected $phone_alternative;
	protected $description;
	protected $single_mother;
	protected $in_need;
	protected $timestamp;

	public function getId() {
		return $this->id;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($value) {
		$this->name = $value;
	}

	public function getBirthday() {
		return CommonHelper::reformatDate($this->birthday);
	}

	public function setBirthday($value) {
		$this->birthday = $value;
	}

	public function getRegion() {
		return $this->region;
	}

	public function setRegion($value) {
		$this->region = $value;
	}

	public function getDistrict() {
		return $this->district;
	}

	public function setDistrict($value) {
		$this->district = $value;
	}

	public function getAddress() {
		return $this->address;
	}

	public function setAddress($value) {
		$this->address = $value;
	}

	public function setAddressResidence($value) {
		$this->address_residence = $value;
	}

	public function getAddressResidence() {
		return $this->address_residence;
	}

	public function getPhone() {
		return $this->phone;
	}

	public function setPhone($value) {
		$this->phone = $value;
	}

	public function getPhoneAlternative() {
		return $this->phone_alternative;
	}

	public function setPhoneAlternative($value) {
		$this->phone_alternative = $value;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($value) {
		$this->description = $value;
	}

	public function getSingleMother() {
		return $this->single_mother;
	}

	public function setSingleMother($value) {
		$this->single_mother = $value;
	}

	public function getInNeed() {
		return $this->in_need;
	}

	public function setInNeed($value) {
		$this->in_need = $value;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	public function setTimestamp($value) {
		$this->timestamp = $value;
	}
}
