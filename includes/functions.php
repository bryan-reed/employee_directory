<?php
//Function to generate the data that will be passed to javascript for dataTables to render
//Grabs all rows from the database and builds a tree structure with the CEO as the root
function generate_data() {
	// Boss map, employees array, queue array and ceo array
	$boss_map = array();
	$employees = array();
	$queue = array();
	$ceo = array();
	//Get all employees
	$sql = "SELECT * FROM employees";
	$res = query($sql);
	while($j = fetch($res)) {
		//Map employee id to name
		$employees[$j['id']] = $j['name'];
		//Add all employees to boss_map except ceo
		if($j['bossId'] !== $j['id'])
			$boss_map[$j['bossId']][] = $j['id'];
		else
			$ceo = $j;
	}
	//If no employees or no ceo, return empty array so dataTables shows error message
	if(empty($employees) || empty($ceo))
		return json_encode(array());

	//Set up CEO obj - Root of the tree
	$ceoObj = new Employee($ceo['id'], $ceo['name'], $ceo['id'], 0);

	//Add the ceo to the queue
	$queue[] = $ceoObj;
	$i = 0;
	$total_employees = count($employees);
	//Loop through every employee
	while($i < $total_employees) {
		//If corrupt data/missing employees, return empty array
		if(!array_key_exists($i, $queue))
			return json_encode(array());
		//Get boss from queue
		$boss = $queue[$i];
		//Set boss name
		$boss->setBossName($employees[$boss->getBossId()]);
		$subordinates = array();
		//Check if bossId is in the boss_map to get all direct subordinates
		if(array_key_exists($boss->getId(), $boss_map)) {
			$subordinates = $boss_map[$boss->getId()];
		}
		//Loop through direct subordinates and create new employee objects for each while increasing the depth from ceo by bosses depth+1
		foreach ($subordinates as $subordinateId) {
			$employeeObj = new Employee($subordinateId, $employees[$subordinateId], $boss->getId(), $boss->getDepth()+1);
			//Add newly created employee objects as subordinates of current boss object
			$boss->addSubordinate($employeeObj);
			//Push the employee object on to the queue
			$queue[] = $employeeObj;
		}
		$i++;
	}
	//Assign numSubordinates count
	assign_subordinate_count($ceoObj);

	return json_encode($queue);
}
//Calculate total number of subordinate employees for a given employee using recursion
function assign_subordinate_count($employee) {
	$count = 0;
	//Get subordinate employees of current employee
	$employees = $employee->getSubordinates();
	//Add to count
	$count += count($employees);
	//Recursively add all subordinate employees number of employees to current employees count
	foreach($employees AS $emp) {
		$count += assign_subordinate_count($emp);
	}
	//Update number of subordinate employees for this employee
	$employee->setNumSubordinates($count);
	//Destroy the subordinates attribute so returned data will be flat array/chop off multidimensional array
	$employee->destroySubordinates();
	return $count;
}
//Generic query function
function query($sql) {
	global $mysqli;
	$res = $mysqli->query($sql);
	return $res;
}
//Generic fetch function
function fetch($res) {
	$j = $res->fetch_assoc();
	return $j;
}