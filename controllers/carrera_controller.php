<?php
	require_once("../models/config.php");
	require_once("../models/cls_carrera.php");
	    
	if(isset($_POST['ope'])){
		switch($_POST['ope']){
			case "Registrar":
				fn_Registrar();
			break;
		}
	}

	function fn_Registrar(){
		$model_c = new cls_carrera();
				
		$model_c->setDatos($_POST);
		$mensaje = $model_c->create();

		header("Location: ".constant("URL")."carrera/formulario/$mensaje");	
	}
?>