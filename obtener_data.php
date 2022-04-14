<?php
require "script/pdocrud.php";
$pdocrud = new PDOCrud();
$pdomodel = $pdocrud->getPDOModelObj();

$class_name = $_POST["class_name"];
$pdomodel->where("class_name", $class_name);
$data = $pdomodel->select("class");

echo json_encode($data);

