<?php
require "script/pdocrud.php";
$pdocrud = new PDOCrud();
$pdomodel = $pdocrud->getPDOModelObj();
if(isset($_POST)){
	$pk = $_POST["pk"];
	$textarea = $_POST["value"];

	$pdomodel->where("class_id", $pk);
	$pdomodel->update("class", array("description"=>$textarea));
	echo json_encode($pdomodel);
}