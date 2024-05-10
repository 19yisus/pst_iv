<?php 

require_once("../models/config.php");
require_once("../models/cls_actividad.php");
require_once("../models/cls_asistencia_actividad.php");

if(isset($_POST['ope'])){
    switch($_POST['ope']){
        case "Registrar":
            crearActividad();
        break;
            
        case "Actualizar":
            print("Actualizar");
        break;
    }
}

function crearActividad(){
    $actividad_proyecto=json_decode($_POST['actividad_proyecto']);
    $asistencia_estudiantes=json_decode($_POST['asistencia_estudiantes']);
    
    $actividadModelo=new cls_actividad();
    $actividadModelo->setDatos($actividad_proyecto);

    print(json_encode(["msj" => "hola"]));
}

function actualizarActividad(){}

function eliminarActividad(){}

function crearAsistenciaHaUnaActividad(){}

function eliminarAsistenciaDeUnaActividad(){}

function consultarTodasLasActvidadesDelProyecto(){}

function consultarUnaActividadDelProyecto(){}

function consultarActividadesDelProyectoPorFecha(){}


