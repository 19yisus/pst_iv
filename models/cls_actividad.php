<?php 

if (!class_exists("cls_db")) require_once("cls_db.php");

class cls_actividad extends cls_db {

    private $id_actividad;
    private $id_proyecto;
    private $descripcion;
    private $fecha_actividad;
    private $tiempo;

    function __construct()
    {
        parent::__construct();
        $this->id_actividad="";
        $this->id_proyecto="";
        $this->descripcion="";
        $this->fecha_actividad="";
        $this->tiempo="";
    }

    public function setDatos($datos){
        $this->id_actividad=isset($datos->id_actividad) ? $this->Clean(intval($datos->id_actividad)) : null;
        $this->id_proyecto=isset($datos->id_proyecto) ? $this->Clean(intval($datos->id_proyecto)) : null;
        $this->descripcion=isset($datos->descripcion) ? $datos->descripcion : null;
        $this->fecha_actividad=isset($datos->fecha_actividad) ? $datos->fecha_actividad : null;
        $this->tiempo=isset($datos->tiempo) ? $datos->tiempo : null;
    }

    public function create(){
        $sqlConsulta = "SELECT * FROM proyecto WHERE id_proyecto = $this->id_proyecto AND estado_proyecto = '1'";
        $result = $this->Query($sqlConsulta);

        if($result->num_rows < 0) return "err/02ERR";

        try{
            // $this->Start_transacction();

            $sql = "INSERT INTO actividad(id_proyecto,descripcion,fecha_actividad,tiempo) VALUES($this->id_proyecto,'$this->descripcion','$this->fecha_actividad','$this->tiempo');";
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

    function actualizarActividad(){
        $sqlConsulta = "SELECT * FROM actividad WHERE id_actividad = $this->id_actividad";
        $result = $this->Query($sqlConsulta);

        if($result->num_rows < 0) return "err/02ERR";

        $sql = "UPDATE actividad SET id_proyecto=$this->id_proyecto,descripcion='$this->descripcion',fecha_actividad='$this->fecha_actividad',tiempo='$this->tiempo' where id_actividad=$this->id_actividad;";
        $this->Query($sql);
        return $this->Returning_id();
    }

    function eliminarActividad(){
        $sqlConsulta = "DELETE FROM actividad WHERE id_actividad = $this->id_actividad";
        $result = $this->Query($sqlConsulta);
        return $result;
    }
    
    function consultarTodasLasActvidadesDelProyecto(){
        $sqlConsulta = "SELECT * FROM actividad INNER JOIN asistencia_actividad ON asistencia_actividad.id_actividad=actividad.id_actividad where actividad.id_proyecto=$this->id_proyecto ;";
        $results = $this->Query($sqlConsulta);
        return $this->Get_todos_array($results);
    }
    
    function consultarUnaActividadDelProyecto(){
        $sqlConsulta = "SELECT * FROM actividad INNER JOIN asistencia_actividad ON asistencia_actividad.id_actividad=actividad.id_actividad where actividad.id_actividad=$this->id_actividad AND actividad.id_proyecto=$this->id_proyecto ;";
        $results = $this->Query($sqlConsulta);
        return $this->Get_todos_array($results);
    }

    function consultarActividadesDelProyectoPorFecha(){
        $sqlConsulta = "SELECT * FROM actividad INNER JOIN asistencia_actividad ON asistencia_actividad.id_actividad=actividad.id_actividad where actividad.fecha_actividad='$this->fecha_actividad' AND actividad.id_proyecto=$this->id_proyecto ;";
        $results = $this->Query($sqlConsulta);
        return $this->Get_todos_array($results);
    }

}

?>
