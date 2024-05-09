<?php 

require_once("../models/config.php");
require_once("../models/cls_actividad.php");
require_once("../models/cls_asistencia_actividad.php");

if(isset($_POST['ope'])){
    switch($_POST['ope']){
        case "Registrar":
            print("Registrar");
        break;
            
        case "Actualizar":
            print("Actualizar");
        break;
    }
}