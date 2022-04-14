<?php

@session_start();
/*enable this for development purpose */
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
date_default_timezone_set(@date_default_timezone_get());
define('PDOCrudABSPATH', dirname(__FILE__) . '/');
require_once PDOCrudABSPATH . "config/config.php";
spl_autoload_register('pdocrudAutoLoad');

function pdocrudAutoLoad($class) {
    if (file_exists(PDOCrudABSPATH . "classes/" . $class . ".php"))
        require_once PDOCrudABSPATH . "classes/" . $class . ".php";
}

if (isset($_REQUEST["pdocrud_instance"])) {
    $fomplusajax = new PDOCrudAjaxCtrl();
    $fomplusajax->handleRequest();
}

function insert_class($data, $obj){
    $class_name = $data["class"]["class_name"];

    if(empty($class_name)){
        die("class_name_vacio");
    }
    return $data;
}


function eliminacion_masiva($data, $obj){
    $id = $data["selected_ids"];

    foreach ($id as $pk) {
        $pdomodel = $obj->getPDOModelObj();
        $pdomodel->where("class_id", $pk);
        $consulta = $pdomodel->select("class");
        print_r($consulta);
           
    }

    //return $data;
}


function formatTableDataClass($data, $obj){
    if($data){
        for ($i = 0; $i < count($data); $i++) {
            if($data[$i]["state"] == 0) {
                $data[$i]["state"] = "<div class='alert alert-info'>Activo</div>";
            } else {
                $data[$i]["state"] = "<div class='alert alert-danger'>Desactivado</div>";
            }
            $data[$i]["class_name"] = "<a href='#' class='xedit' data-pk='". $data[$i]["class_id"]."' data-type='text' data-title='Enter name' data-name='name'>".$data[$i]["class_name"]."</a>";

            $data[$i]["selection"] = "<a href='#' class='status' data-type='select' data-pk='". $data[$i]["class_id"]."' data-title='Select status' data-name='name'>".$data[$i]["selection"]."</a>";

            $data[$i]["description"] = "<a href='#'  class='xtextarea' data-pk='". $data[$i]["class_id"]."' data-type='textarea' data-title='Enter name' data-name='name'>".$data[$i]["description"]."</a>";
        }
    }
    return $data;
}