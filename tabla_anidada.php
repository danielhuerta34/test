<?php 
require "script/pdocrud.php";
$id = $_GET["id"];


$settings["template"] = "bootstrap";
$settings["skin"] = "dark";

$pdocrud = new PDOCrud(false, "","", $settings);
$pdomodel = $pdocrud->getPDOModelObj();
$pdomodel->where("class_id", $id);
$table = $pdomodel->select("section");

$pdomodel->where("class_id", $id);
$table2 = $pdomodel->select("student");
$pdocrud->setPK("section_id");
$pdocrud->formDisplayInPopup();
$pdocrud->where("class_id", $id);
$pdocrud->formFieldValue("class_id", $id);
$pdocrud->fieldHideLable("class_id");
$pdocrud->fieldDataAttr("class_id", array("style"=>"display:none"));


/* crear campo tipo select con campos staticos y filed data binding */
$pdocrud->formStaticFields("seleccion", "input", array());

$pdocrud->fieldTypes("seleccion", "select");
$pdocrud->fieldDataBinding("seleccion", "country", "country_id", "country_name", "db");

/* crear campo tipo select con campos staticos y related data */
$pdocrud->formStaticFields("estatico", "input", array());
//$pdocrud->relatedData('estatico','class','class_id','class_name');

$render = $pdocrud->dbTable("section")->render();
?>


<!DOCTYPE html>
<html lang="es">
<head>
	<title></title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?=$render;?>
				<a href="index.php" class="btn btn-info">Regresar</a>
			</div>
		</div>
	</div>
</body>
</html>