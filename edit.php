<?php
require "script/pdocrud.php";
$id = $_GET['id'];

$pdocrud = new PDOCrud();
$pdocrud->addPlugin("summernote");
$pdocrud->fieldCssClass("description", array("summernote"));
$pdocrud->fieldTypes("state", "select");
$pdocrud->fieldGroups("Name1",array("class_name","code"));
$pdocrud->fieldGroups("Name2",array("user_id","selection"));
$pdocrud->fieldDataBinding("state", array("0"=>"Activo", "1"=>"Desactivado"), "", "","array");
$pdocrud->fieldTypes("class_file", "FILE_MULTI");
$pdocrud->setPK("class_id");
$pdocrud->buttonHide("submitBtn");
$pdocrud->buttonHide("cancel");
$pdocrud->formStaticFields("botones", "html", "
	<div class='row text-center'>
		<div class='col-md-12'>
			<input type='submit' class='btn btn-success' value='Guardar'>
			<a href='index.php' class='btn btn-danger'>Regresar</a>
			<input class='btn btn-danger save' type='reset' value='Cancelar'>
		</div>
	</div>
");
$render = $pdocrud->dbTable("class")->render("editform", array("id"=>$id));
$summernote = $pdocrud->loadPluginJsCode("summernote",".summernote");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?=$render;?>
				<?=$summernote;?>
			</div>
		</div>
	</div>
</body>
</html>