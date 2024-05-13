<!DOCTYPE html>
<html lang="en">
<?php
$this->GetHeader("SGSC | UNEFA");

require_once("./models/cls_actividad.php");
require_once("./models/cls_asistencia_actividad.php");

$cls_actividad=new cls_actividad();
$datosDelProyecto=$cls_actividad->consultarProyecto($_GET["id_proyecto"])[0];

$estudiantes=$cls_actividad->consultarEstudiantesGrupo($datosDelProyecto["id_grupo"]);
// var_dump($estudiantes);
$op = $_GET["ope"];
$id_actividad=null;

$id_proyecto=$_GET["id_proyecto"];
$datosActividad=null;
$datosAsistenciasActividad=null;

if(isset($_GET["id_actividad"])){
  $id_actividad=$_GET["id_actividad"];
  $dataActividad= new stdClass();
  $dataActividad->id_actividad=$id_actividad;
  $dataActividad->id_proyecto=$id_proyecto;
  $cls_actividad->setDatos($dataActividad);
  $datosActividad=$cls_actividad->consultarActividad()[0];

}


?>

<body x-data="{ page: 'signin', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="
          darkMode = JSON.parse(localStorage.getItem('darkMode'));
          $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">

  <!-- ===== Page Wrapper Start ===== -->
  <div class="flex h-screen overflow-hidden">
    <?php $this->GetComplement('sidebar_menu'); ?>
    <!-- ===== Content Area Start ===== -->
    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
      <?php $this->GetComplement('header'); ?>
      <main>
        <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
          <!-- ====== Form Layout Section Start -->
          <div class="grid grid-cols-1 gap-9 sm:grid-cols-1">
            <div class="flex flex-col gap-9">
              <!-- Contact Form -->
              <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                  <h3 class="font-semibold text-black dark:text-white">
                    <?php echo "Actividad del Proyecto: ".$datosDelProyecto["titulo_proyecto"]?>
                  </h3>
                </div>
                <!-- ACA ESTA EL FOMULARIO, EL ACTION CONTIENE LA URL ESTATICA QUE APUNTA AL CONTROLADOR DE CARRERA, DICHO FORMULARIO CONTIENE PRIMERO 2 INPUTS DE TIPO HIDDEN (ESCONDIDO), UNO ES PARA DEFINIR QUE OPERACION VAMOS A REALIZAR OPE, Y EL OTRO CAMPO ES PARA METER EL ID DE LA CARRERA -->
                <!-- action="<?php $this->SetURL('controllers/carrera_controller.php'); ?>" -->
                <form  autocomplete="off" onsubmit="guardar(event)">
                  <input type="hidden" id="url"  name="url" value="<?php echo $this->SetURL('controllers/actividad_controller.php'); ?>">
                  <input type="hidden" id="ope"  name="ope" value="<?php echo $op ?>">
                  <input type="hidden" id="id_actividad" name="id_actividad" value="<?php echo $id_actividad ?>">
                  <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $id_proyecto ?>">
                  <!-- OH BUENO, FALTA VER LA TRANSACCION -->
                  <div class="p-6.5">
                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                      
                      <div class="w-full xl:w-2/6">
                        <label class="mb-2.5 block text-black dark:text-white">
                          Descripción <span class="text-meta-1">*</span>
                        </label>
                        <input type="text" maxlength="200" value="<?php echo ($datosActividad!=null)?$datosActividad["descripcion"]:""?>" minlength="5" required placeholder="Ingresa el nombre de la carrera" id="descripcion" name="descripcion" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>
                      <div class="w-full xl:w-2/6">
                        <label class="mb-2.5 block text-black dark:text-white">
                          Fecha de la Actividad <span class="text-meta-1">*</span>
                        </label>
                        <?php $fecha_actividad=($datosActividad!=null)?new DateTime($datosActividad["fecha_actividad"]):null ?>
                        <?php $fecha_actividad=($fecha_actividad!=null)? $fecha_actividad->format("Y-m-d") :null ?>
                        <input type="date" required id="fecha_actividad" value="<?php echo $fecha_actividad?>" name="fecha_actividad" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>
                      <div class="w-full xl:w-2/6">
                        <label class="mb-2.5 block text-black dark:text-white">
                          Tiempo <span class="text-meta-1">*</span>
                        </label>
                        <input type="text" required pattern="^(0?[0-9]|1[0-9]|2[0-3])$" id="tiempo" value="<?php echo ($datosActividad!=null)?$datosActividad["tiempo"]:""?>" name="tiempo" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>
                  </div>
                  <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray">
                    Guardar
                  </button>
                </form>
              </div>
            </div>
            <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
              <h3 class="font-semibold text-black dark:text-white">
                Lista de Asistencia
              </h3>
            </div>
            <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                  <tr class="bg-gray-2 text-left dark:bg-meta-4">
                    <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                      Estudiante
                    </th>
                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                      
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php                     
                    foreach($estudiantes as $estudiante){
                      $dataAsistenciaActividad= new stdClass();
                      $cls_asistencia_actividad=new cls_asistencia_actividad();
                      $dataAsistenciaActividad->id_estudiante=$estudiante['id_estudiante'];
                      $dataAsistenciaActividad->id_actividad=$id_actividad;
                      $cls_asistencia_actividad->setDatos($dataAsistenciaActividad);
                      $datosAsistenciasActividad=$cls_asistencia_actividad->consultarAsistenciaEstudiante();
                      ?>
                      <tr>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                          <p class="text-black dark:text-white"><?php echo $estudiante['nombre_usuario'];?></p>
                        </td>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                          <input type="checkbox" name="" id="" class="asistencia-estudiante" value="<?php echo $estudiante['id_estudiante'] ?>"  <?php  echo ((count($datosAsistenciasActividad)!=0)?"checked":"") ?>  >
                        </td>
                      </tr>
                      
                      <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          </div>
        </div>
      </main>
    </div>
    <!-- ===== Content Area End ===== -->
  </div>
  <!-- ===== Page Wrapper End ===== -->
  <?php $this->GetComplement('scripts'); ?>
  <script>
    
    function guardar(e){
      e.preventDefault()
      let url=document.getElementById("url").value
      let descripcion=document.getElementById("descripcion").value
      let fecha_actividad=document.getElementById("fecha_actividad").value
      let tiempo=document.getElementById("tiempo").value
      let id_actividad=document.getElementById("id_actividad").value
      let id_proyecto=document.getElementById("id_proyecto").value
      let ope=document.getElementById("ope").value
      let asistencias = capturarAsistencias()
      let actividad_proyecto={
          id_actividad,
          id_proyecto,
          descripcion,
          fecha_actividad,
          tiempo
        }
      
      let asistencia_estudiantes =asistencias

      let data={
        ope,
        actividad_proyecto,
        asistencia_estudiantes,
      }
      console.log("datos a enviar => ",data)
      
      let datosFormulario=new FormData()
      datosFormulario.set("ope",ope)
      datosFormulario.set("actividad_proyecto",JSON.stringify(actividad_proyecto))
      datosFormulario.set("asistencia_estudiantes",JSON.stringify(asistencia_estudiantes))

      enviarDatos(url,datosFormulario)

    }

    function enviarDatos(url, datos) {
      const options = {
        method: 'POST', 
        body: datos
      };

      fetch(url, options)
        .then(response => {
          if (!response.ok) {
            throw new Error('Hubo un problema al enviar los datos.');
          }
          // return response.text();
          return response.json();
        })
        .then(data => {
          console.log('Datos enviados con éxito:', data);
          location.href="/actividad/index?id_proyecto=<?php echo $id_proyecto?>"
        })
        .catch(error => {
          console.error('Error al enviar los datos:', error);
        });
    }

    function capturarAsistencias(){
      let asistencias=[]
      let asistenciasCheck=document.querySelectorAll(".asistencia-estudiante")
      for (let index = 0; index < asistenciasCheck.length; index++) {
        const check = asistenciasCheck[index];
        let asistencia={
          id_estudiante:check.value,
          estado:check.checked
        }
        asistencias.push({...asistencia})
        
      }
      return asistencias
    }


  </script>
</body>

</html>