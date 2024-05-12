<?php 

if (!class_exists("cls_db")) require_once("cls_db.php");

class cls_asistencia_actividad extends cls_db {

    private $id_asistencia_actividad;
    private $id_actividad;
    private $id_estudiante;

    function __construct()
    {
        parent::__construct();
        $this->id_asistencia_actividad="";
        $this->id_actividad="";
        $this->id_estudiante="";
    }

    public function setDatos($datos){
        $this->id_asistencia_actividad=isset($datos->id_asistencia_actividad) ? $this->Clean(intval($datos->id_asistencia_actividad)) : null;
        $this->id_actividad=isset($datos->id_actividad) ? $this->Clean(intval($datos->id_actividad)) : null;
        $this->id_estudiante=isset($datos->id_estudiante) ? $this->Clean(intval($datos->id_estudiante)) : null;
    }

    public function create(){
        $sqlConsulta = "SELECT * FROM actividad WHERE id_actividad = $this->id_actividad";
        $result = $this->Query($sqlConsulta);

        if($result->num_rows < 0) return "err/02ERR";

        try{
            // $this->Start_transacction();

            $sql = "INSERT INTO asistencia_actividad(id_actividad,id_estudiante) VALUES($this->id_actividad,$this->id_estudiante);";
            $this->Query($sql);

			$id = $this->Returning_id();
            
            // $this->reg_bitacora([
            //     'user_id' => $_SESSION['cedula'], 
            //     'table_name'=> "ACTIVIDAD", 
            //     'des' => "REGISTRO DE ACTIVIDAD DEL PROYECTO ESTUDIANTE: ".$result->num_rows
            // ]);


            // if($this->Result_last_query()){
            //     $this->End_transacction();
            //     return "msg/01DONE"; 
            // }
            // else{
            //     $this->Rollback();
            //     return "err/01ERR";
            // }
            return $id;
        }
        catch (Exception $e) {
            die("AH OCURRIDO UN ERROR: " . $e->getMessage());
        }		
    }

    function consultarAsistenciaEstudiante(){
        $sqlConsulta = "SELECT * FROM asistencia_actividad  WHERE id_estudiante = $this->id_estudiante AND id_actividad = $this->id_actividad";
        $results = $this->Query($sqlConsulta);
        return $this->Get_todos_array($results);
    }

    function consultarAsistenciaActividad(){
        $sqlConsulta = "SELECT * FROM asistencia_actividad  WHERE id_actividad = $this->id_actividad";
        $results = $this->Query($sqlConsulta);
        return $this->Get_todos_array($results);
    }

    function eliminarAsistenciaDeUnaActividad(){
        $sqlConsulta = "DELETE FROM asistencia_actividad WHERE id_asistencia_actividad = $this->id_asistencia_actividad AND id_actividad = $this->id_actividad";
        $result = $this->Query($sqlConsulta);
        return $result;
    }
    

    function eliminarAsistenciasPorIdActividad($id_actividad){
        $sqlConsulta = "DELETE FROM asistencia_actividad WHERE id_actividad=$id_actividad";
        $result = $this->Query($sqlConsulta);
        return $result;
    }

}

?>