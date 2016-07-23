<?php
//Employee class
//Used to create employees and track their boss and subordinate employees as well as depth from ceo
class Employee {

	public $id;
	public $name;
	public $bossId;
	public $bossName;
	public $depth;
	public $numSubordinates = 0;
	public $subordinates = array();
	
	//Create an employee with id, name, boss and depth
	public function __construct($id, $name, $bossId, $depth) {
		$this->setId($id);
		$this->setName($name);
		$this->setBossId($bossId);
		$this->setDepth($depth);
	}
	//Add subordinate employee to current employee
	public function addSubordinate($subordinate) {
		$this->subordinates[] = $subordinate;
	}
	//Setters and Getters
	public function setId($id) {
		$this->id = $id;
	}
	public function setName($name) {
		$this->name = $name;
	}
	public function setBossId($bossId) {
		$this->bossId = $bossId;
	}
	public function setBossName($name) {
		$this->bossName = $name;
	}
	public function setDepth($depth) {
		$this->depth = $depth;
	}
	public function setNumSubordinates($numSubordinates) {
		$this->numSubordinates = $numSubordinates;
	}
	public function getId() {return $this->id;}
	public function getName() {return $this->name;}
	public function getBossId() {return $this->bossId;}
	public function getBossName() {return $this->bossName;}
	public function getDepth() {return $this->depth;}
	public function getSubordinates() {return $this->subordinates;}

	//Destroy subordinates attribute.
	public function destroySubordinates() {
		unset($this->subordinates);
	}
}