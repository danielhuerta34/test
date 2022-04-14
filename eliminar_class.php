<?php
require "script/pdocrud.php";
$pdocrud = new PDOCrud();
$pdomodel = $pdocrud->getPDOModelObj();

$id_class = $_POST['id_class'];
$pdomodel->where("class_id", $id_class);
$pdomodel->delete("class");

echo json_encode($pdomodel);