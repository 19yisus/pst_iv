<?php 

require_once("../models/config.php");
require_once("../models/cls_actividad.php");
require_once("../models/cls_asistencia_actividad.php");

if(isset($_POST['ope'])){
    switch($_POST['ope']){
        case "Registrar":
            crearActividad();
        break;
            
        case "actualizarActividad":
            actualizarActividad();
        break;
        case "consultarUnaActividadDelProyecto":
            consultarUnaActividadDelProyecto();
        break;
        case "consultarActividadesDelProyectoPorFecha":
            consultarActividadesDelProyectoPorFecha();
        break;
        case "consultarTodasLasActvidadesDelProyecto":
            consultarTodasLasActvidadesDelProyecto();
        break;
        case "eliminarAsistenciaDeUnaActividad":
            eliminarAsistenciaDeUnaActividad();
        break;
        case "eliminarActividad":
            eliminarActividad();
        break;
        case "crearAsistenciaHaUnaActividad":
            crearAsistenciaHaUnaActividad();
        break;
    }
}

if(isset($_GET['ope'])){
    switch($_GET['ope']){
        case "eliminarActividad":
            eliminarActividad();
        break;

        case "Registrar":
            formulario();
        break;

    }
}

function formulario(){
    header("Location: ".constant("URL")."/actividad/formulario?id_proyecto=".$_GET['id_proyecto']);	
}

function crearActividad(){
    // $actividad_proyecto=$_POST['actividad_proyecto'];
    $actividad_proyecto=json_decode($_POST['actividad_proyecto']);
    $asistencia_estudiantes=json_decode($_POST['asistencia_estudiantes']);
    
    $actividadModelo=new cls_actividad();
    $actividadModelo->setDatos($actividad_proyecto);
    $id_actividad=$actividadModelo->create();

    $idsAsistencias=[];

    for ($index=0; $index < count($asistencia_estudiantes); $index++) { 
        # code...
        $asistencia=$asistencia_estudiantes[$index];
        $asistencia->id_actividad=$id_actividad;
        $asistenciaActividadModelo=new cls_asistencia_actividad();
        $id_asistencia_actividad=$asistenciaActividadModelo->setDatos($asistencia);
        // $consulta=$asistenciaActividadModelo->consultarAsistenciaEstudiante();
        // if(count($consulta)==0){
        //     $id_asistencia_actividad=$asistenciaActividadModelo->create();
        //     $idsAsistencias[]=$id_asistencia_actividad;
        // }
        $id_asistencia_actividad=$asistenciaActividadModelo->create();
        $idsAsistencias[]=$id_asistencia_actividad;
    }



    print(json_encode(["msj" => $idsAsistencias]));
}

function actualizarActividad(){

    $actividad_proyecto=json_decode($_POST['actividad_proyecto']);
    $actividadModelo=new cls_actividad();
    $actividadModelo->setDatos($actividad_proyecto);
    $id_actividad=$actividadModelo->actualizarActividad();
    
    print(json_encode(["msj" => $id_actividad]));
}

function eliminarActividad(){
    $data= new stdClass();
    $data->id_actividad=$_GET["id_actividad"];
    $actividadModelo=new cls_actividad();
    $actividadModelo->setDatos($data);
    $respuestaConsulta=$actividadModelo->eliminarActividad();
    // print(json_encode(["msj" => $respuestaConsulta]));
    header("Location: ".constant("URL")."actividad/index?id_proyecto=".$_GET['id_proyecto']);	
}

function crearAsistenciaHaUnaActividad(){

    $asistencia_estudiantes=json_decode($_POST["asistencia_estudiantes"]);
    $asistenciaActividadModelo=new cls_asistencia_actividad();
    $asistenciaActividadModelo->setDatos($asistencia_estudiantes);
    $consulta=$asistenciaActividadModelo->consultarAsistenciaEstudiante();
    $respuestaConsulta=null;
    if(count($consulta)==0){
        $respuestaConsulta=$asistenciaActividadModelo->create();
    }
    print(json_encode(["msj" => $respuestaConsulta]));
}

function eliminarAsistenciaDeUnaActividad(){
    $data= new stdClass();
    $data->id_actividad=$_POST["id_actividad"];
    $data->id_asistencia_actividad=$_POST["id_asistencia_actividad"];
    $asistenciaActividadModelo=new cls_asistencia_actividad();
    $asistenciaActividadModelo->setDatos($data);
    $respuestaConsulta=$asistenciaActividadModelo->eliminarAsistenciaDeUnaActividad();
    print(json_encode(["msj" => $respuestaConsulta]));
}

function consultarTodasLasActvidadesDelProyecto(){
    $data= new stdClass();
    $data->id_proyecto=$_POST["id_proyecto"];
    $actividadModelo=new cls_actividad();
    $actividadModelo->setDatos($data);
    $respuestaConsulta=$actividadModelo->consultarTodasLasActvidadesDelProyecto();
    print(json_encode(["msj" => $respuestaConsulta]));
}

function consultarUnaActividadDelProyecto(){
    $data= new stdClass();
    $data->id_proyecto=$_POST["id_proyecto"];
    $data->id_actividad=$_POST["id_actividad"];
    $actividadModelo=new cls_actividad();
    $actividadModelo->setDatos($data);
    $respuestaConsulta=$actividadModelo->consultarUnaActividadDelProyecto();
    print(json_encode(["msj" => $respuestaConsulta]));
}

function consultarActividadesDelProyectoPorFecha(){
    $data= new stdClass();
    $data->fecha_actividad=$_POST["fecha_actividad"];
    $data->id_proyecto=$_POST["id_proyecto"];
    $actividadModelo=new cls_actividad();
    $actividadModelo->setDatos($data);
    $respuestaConsulta=$actividadModelo->consultarActividadesDelProyectoPorFecha();
    print(json_encode(["msj" => $respuestaConsulta]));
}

?>

