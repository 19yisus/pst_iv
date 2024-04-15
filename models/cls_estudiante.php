<?php
	if(!class_exists("cls_db")) require_once("cls_db.php");

	class cls_estudiante extends cls_db{
		private $id_estudiante, $cedula_usuario, $turno_estudiante, $matricula_estudiante;
			public function __construct(){
			parent::__construct();
			$this->id_estudiante = $this->cedula_usuario = $this->turno_estudiante = $this->matricula_estudiante = "";
		}

		public function setDatos($d){
			$this->id_estudiante = isset($d['id_estudiante']) ? $this->Clean(intval($d['id_estudiante'])) : null;
			$this->cedula_usuario = isset($d['cedula_usuario']) ? $this->Clean(intval($d['cedula_usuario'])) : null;
			$this->turno_estudiante = isset($d['turno_estudiante']) ? $this->Clean($d['turno_estudiante']) : '';
			$this->matricula_estudiante = isset($d['matricula_estudiante']) ? $this->Clean($d['matricula_estudiante']) : '';
		}

		public function create(){
			$sqlConsulta = "SELECT * FROM estudiante WHERE cedula_usuario = '$this->cedula_usuario'";
			$result = $this->Query($sqlConsulta);
			
			if($result->num_rows > 0) return "err/02ERR";
			
			$sql = "INSERT INTO estudiante(cedula_usuario,turno_estudiante) VALUES('$this->cedula_usuario','$this->turno_estudiante');";
			$res = $this->Query($sql);

			if($this->Result_last_query()){
				$id = $this->Returning_id();
				return "estudiante/formulario_inscripcion/i/$id";
			}

			return "estudiante/index/err/01ERR";
			// if($this->Result_last_query()) return "msg/01DONE"; else return "err/01ERR";
		}

		public function update(){
			if($this->matricula_estudiante == '') return "estudiante/index/msg/01DONE";
			$sql = "UPDATE estudiante SET matricula_estudiante = '$this->matricula_estudiante' WHERE id_estudiante = $this->id_estudiante ;";
		
      $res = $this->Query($sql);
			if($res->num_rows > 0) return "estudiante/index/msg/01DONE"; else return "estudiante/index/err/01ERR";
		}

		public function Get_estudiantes($condicion = ''){
			if($condicion == '') $sql = "SELECT * FROM estudiante INNER JOIN usuario ON usuario.cedula_usuario = estudiante.cedula_usuario";
			if($condicion == 'NO-INS') $sql = "SELECT * FROM estudiante INNER JOIN usuario ON usuario.cedula_usuario = estudiante.cedula_usuario WHERE NOT EXISTS (SELECT * FROM inscripcion INNER JOIN ano_escolar ON ano_escolar.id_ano_escolar = inscripcion.id_ano_escolar WHERE estudiante.id_estudiante = inscripcion.id_estudiante AND ano_escolar.estado_ano_escolar = '1');";
			if($condicion == 'INS') $sql = "SELECT * FROM estudiante INNER JOIN usuario ON usuario.cedula_usuario = estudiante.cedula_usuario WHERE EXISTS (SELECT * FROM inscripcion INNER JOIN ano_escolar ON ano_escolar.id_ano_escolar = inscripcion.id_ano_escolar WHERE estudiante.id_estudiante = inscripcion.id_estudiante AND ano_escolar.estado_ano_escolar = '1');";
			$results = $this->Query($sql);
			return $this->Get_todos_array($results);
		}

		public function Get_estudiantesPorTipoCarrera($tipo){
			$sql = "SELECT estudiante.*,usuario.nombre_usuario FROM estudiante
				INNER JOIN usuario ON usuario.cedula_usuario = estudiante.cedula_usuario
				INNER JOIN inscripcion ON inscripcion.id_estudiante = estudiante.id_estudiante
				INNER JOIN ano_escolar ON ano_escolar.id_ano_escolar = inscripcion.id_ano_escolar
				INNER JOIN carrera ON carrera.id_carrera = inscripcion.id_carrera WHERE  ano_escolar.estado_ano_escolar = 1  AND carrera.admite_grupos_mixtos = $tipo 
				AND NOT EXISTS(
					SELECT * FROM grupo_alumno INNER JOIN grupo ON grupo.id_grupo = grupo_alumno.id_grupo WHERE grupo.estado_grupo = 1 AND grupo_alumno.id_alumno = estudiante.id_estudiante);
			";
			$results = $this->Query($sql);
			return $this->Get_todos_array($results);
		}

		public function consulta($id){
			$sql = "SELECT * FROM estudiante INNER JOIN usuario ON usuario.cedula_usuario = estudiante.cedula_usuario WHERE estudiante.id_estudiante = $id;";
			$results = $this->Query($sql);
			return $this->Get_array($results);
		}

		public function Get_me($cedula){
			$sql = "SELECT * FROM estudiante INNER JOIN usuario ON usuario.cedula_usuario = estudiante.cedula_usuario WHERE estudiante.cedula_usuario = '$cedula';";
			$results = $this->Query($sql);
			return $this->Get_array($results);
		}
	}
