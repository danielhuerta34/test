<?php
require "script/pdocrud.php";
$pdocrud = new PDOCrud();
$pdomodel = $pdocrud->getPDOModelObj();
if(isset($_POST)){
	$pk = $_POST["pk"];
	$class_name = $_POST["value"];

	$pdomodel->where("class_id", $pk);
	$pdomodel->update("class", array("class_name"=>$class_name));
	echo json_encode($pdomodel);
}