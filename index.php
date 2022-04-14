<?php
require "script/pdocrud.php";

$pdocrud = new PDOCrud();

$pdomodel = $pdocrud->getPDOModelObj();
$result = $pdomodel->select("class");

if(isset($_POST['submit'])) {
	$class_name = $_POST['class_name'];
	$code = $_POST['code'];


	if(!empty($class_name)){
		$pdocrud->where("class_name", $class_name);
	} else if(!empty($code)){
		$pdocrud->where("code", $code);
	}

}

$pdocrud->recordsPerPage(2);
$pdocrud->addCallback("before_delete_selected", "eliminacion_masiva");
$pdocrud->setSettings("addbtn", false);
$pdocrud->setSettings("viewbtn", false);
$pdocrud->setSettings("delbtn", false);
$pdocrud->setSettings("editbtn", false);
$pdocrud->setSettings("sortable", false);

$pdocrud->setSettings("printBtn", false);
$pdocrud->setSettings("pdfBtn", false);
$pdocrud->setSettings("csvBtn", false);
$pdocrud->setSettings("excelBtn", false);

$pdocrud->enqueueActions(
	array("1" => "0", "0" => "1"), "switch",  
	array("1" => "<div class='btn btn-success'>approved</div>", "0" => "<div class='btn btn-danger'>unapproved</div>"), "booking_status", array()
);

$pdocrud->crudRemoveCol(array("class_id"));
$pdocrud->fieldTypes("class_file", "FILE_MULTI");
$pdocrud->tableColFormatting("class_file", "images", array("width"=>"80px"));
$pdocrud->addCallback("format_table_data", "formatTableDataClass");
$pdocrud->tableColUsingDatasource("user_id", "users", "user_id", "first_name", "db");

$pdocrud->enqueueBtnTopActions("Report",  "Agregar", "insertar.php", array(), "btn-report fa fa-plus");

$pdocrud->enqueueBtnActions("url btn btn-default", "tabla_anidada.php?id={pk}", "url","<i class='fa fa-tasks'></i>","", array("title"=>"Tabla"));

$pdocrud->enqueueBtnActions("url2 btn btn-warning", "edit.php?id={pk}", "url", "<i class='fa fa-edit'></i>","state", array("title"=>"Editar"));

$pdocrud->enqueueBtnActions("url3 btn btn-danger eliminar_class", "javascript:;", "url","<i class='fa fa-trash'></i>","", array("title"=>"Eliminar"));

$render = $pdocrud->dbTable("class")->render();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
</head>
<style>
	.swal2-popup {
		font-size: 15px!important;
	}
</style>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
			
			<div class="filtros" style="text-align: center;">
                <?php if(!empty($class_name) || !empty($code)) { ?>
                <div class="pdocrud-filter-selected">
                    <a href="index.php" class="btn btn-primary"><i class="fa fa-paint-brush"></i> Quitar Filtros</a><br><br>
                </div>
            	<?php } ?>

                <section class="panel panel-default" style="display: inline-block; margin: 2px 3px 10px; width:80%">
                    <header class="panel-heading panel-default">
                        Filtrar por
                    </header>
                    <div class="panel-body">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        
                          <div class="row">
                            <div class="col-md-6">
                                <label>Class name</label><br>
                                <select class="form-control" id="class_name" name="class_name">
                                    <option value="">Seleccionar</option>
                                  	<?php foreach ($result as $resultado) { ?>
                                  		<?php if($class_name == $resultado["class_name"]) { ?>
                                  		<option value="<?=$resultado["class_name"]?>" selected>
                                  			<?=$resultado["class_name"]?>
                                  		</option>
                                  		<?php } else { ?>
										<option value="<?=$resultado["class_name"]?>">
											<?=$resultado["class_name"]?>
										</option>
                                  		<?php } ?>

                                  	<?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Code</label><br>
                                <select class="form-control code" id="code" name="code">
                                    <option value="">Seleccionar</option>
                                </select>
                            </div>
                          </div>
                  
                            <button style="margin-top: 8px;" type="submit" name="submit" class="btn btn-primary btn-block">Filtrar</button>
                        </form>
                    </div>
                </section>

                </div>

			</div>
			<div class="col-md-12">
				<?=$render;?>
			</div>
		</div>
	</div>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script>
	$(document).ready(function(){
		$('#class_name').select2();
		$('#code').select2();
	});
	$(document).on("change", "#class_name", function(){
		let class_name = $('#class_name').val();

		$.ajax({
			type: "POST",
			url: "obtener_data.php",
			data: { class_name: class_name },
			dataType: "json",
			success: function(data){
				console.log(data);

				if(class_name != ""){
				  $('.select2-selection').effect("bounce", { direction:'down', times:6 }, 300);

				  $("#code").empty();
                  $('#code').html('<option value="">Seleccionar</option>');
                  $.each(data, function(index, obj){
                      $('#code').append(`
                          <option value="${obj.code}">${obj.code}</option>
                      `);
                  });
				} else {
				  $("#code").empty();
                  $('#code').html('<option value="">Seleccionar</option>');
				}
			}
		});
	});


$(document).on('click', '.eliminar_class', function () {
	let id_class = $(this).data("id");

	Swal.fire({
		title: 'Estas seguro que deseas eliminalo?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, estoy seguro!',
		cancelButtonText: "No"
		}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
			type: "POST",
			url: "eliminar_class.php",
			data: { id_class: id_class },
			dataType: "json",
			success: function(data){
				if(!data["error"]){
				swal.fire("Genial!", "Eliminado con éxito!","success").then((result) => {
					if(result.isConfirmed) {
						location.reload();
					}
				})

				
				}
			}
			});
		}
	})

});

function editable(){
 /*$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });*/
    $('.xedit').editable({
    	mode: 'inline',
        url: 'editable.php',
        title: 'Update',
        type: 'text',
        pk: 1,
        name: 'name',
        success: function (response, newValue) {
            //console.log('Updated', response)
            Swal.fire(
			  'Genial!',
			  'Texto modificado con éxito!',
			  'success'
			)
        },
        validate: function(value) {
		    if($.trim(value) == '') {
		        return 'Este campo es obligatorio';
		    }
		}
    });
}



function select_editable(){
	$('.status').editable({
    	mode: 'inline',
    	url: 'editable_select.php',
        source: [
	          {value: 'Active', text: 'Active'},
	          {value: 'Blocked', text: 'Blocked'},
	          {value: 'Deleted', text: 'Deleted'}
	       ],
	       validate: function(value) {
		    if($.trim(value) == '') {
		        return 'Selecciona un elemento de la lista';
		    }
		}
    });
}


function textarea_editable(){
	$('.xtextarea').editable({
    	mode: 'inline',
    	pk: 1,
    	escape: true,
    	placeholder: 'Ingresa tu contenido acá',
        url: 'textarea_editable.php',
        title: 'Enter comments',
        inputclass: 'summernote',
        rows: 10,
        wysihtml5: true,
        validate: function(value) {
	    	if($.trim(value) == '') {
	        	return 'Completa este campo';
			}
		}
    });
}




function ocultar_mostrar_boton_editar(state) {
    let sig_row = $('.pdocrud-button-url2');
    sig_row.each(function(i){
        if($(this).data('column-val') == state){
          //$(this).toggle();
          $(this).attr('disabled','disabled');
          //$(this).removeClass('pdocrud-button-edit');
          $(this).remove();
        } else {
          $(this).show();
          //$(this).removeAttr('disabled','disabled');
          //$(this).addClass('pdocrud-button-edit');
        }
      }
    )
}



function ocultar_checkbox(checkbox) {
    let selected_all = $('.pdocrud-select-cb');
    selected_all.each(function(i){
        if($(this).val() == checkbox){
          $(this).remove();
        } else {
          $(this).show();
        }
      }
    )
}

$(document).on("click", ".xtextarea", function(){
	$(".summernote").summernote({
		height: 200,
		width: 400
	});
});


$(document).ready(function() {
	ocultar_mostrar_boton_editar("<div class='alert alert-info'>Activo</div>");
	ocultar_checkbox(3);
	editable();
	select_editable();
	textarea_editable();

});
$(document).on("pdocrud_on_load pdocrud_before_ajax_action pdocrud_after_ajax_action", function(event, obj, data){
	ocultar_mostrar_boton_editar("<div class='alert alert-info'>Activo</div>");
	ocultar_checkbox(3);
	editable();
	select_editable();
	textarea_editable();
});

$(document).on("keyup", "#pdocrud_search_box", function(event){
    let busqueda = $("#pdocrud_search_box").val();

  if(busqueda == ""){
    $('#pdocrud_search_btn').click();
  }

});

$(document).on("click", ".ui-menu-item", function(event){
  $('#pdocrud_search_btn').click();
});
</script>
</body>
</html>