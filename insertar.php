<?php 
require "script/pdocrud.php";

$pdocrud = new PDOCrud();
$pdocrud->addPlugin("summernote");
$pdocrud->fieldCssClass("description", array("summernote"));
$pdocrud->addCallback("before_insert", "insert_class");
$pdocrud->fieldGroups("Name1",array("class_name","code"));
$pdocrud->fieldGroups("Name2",array("user_id","selection"));
$pdocrud->fieldTypes("state", "select");
$pdocrud->setSettings("required", false);
$pdocrud->fieldDataBinding("state", array("0"=>"Activo", "1"=>"Desactivado"), "", "","array");
$pdocrud->fieldTypes("class_file", "FILE_MULTI");
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
$render = $pdocrud->dbTable("class")->render("insertform");
$summernote = $pdocrud->loadPluginJsCode("summernote",".summernote");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	/* este enevnto se activa cuando pedocrud guarda los datos */
	$(document).on("pdocrud_after_submission", function(event, obj, data){
		$('.alert-success').hide();
		$('.alert-danger').hide();
		if(data == "class_name_vacio"){
			Swal.fire({
			  icon: 'error',
			  title: 'Lo siento...',
			  text: 'El campo class name esta vació!'
			})
		}
	});
</script>
</body>
</html>