<!DOCTYPE html>
<html lang="en">
<?php
$this->GetHeader("SGSC | UNEFA");

require_once("./models/cls_actividad.php");

$cls_actividad=new cls_actividad();
$datosDelProyecto=$cls_actividad->consultarProyecto($_GET["id_proyecto"])[0];

$estudiantes=$cls_actividad->consultarEstudiantesGrupo($datosDelProyecto["id_grupo"]);
// var_dump($estudiantes);
$op = $_GET["ope"];

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
                <form action="<?php $this->SetURL('controllers/carrera_controller.php'); ?>" autocomplete="off" method="POST">
                  <input type="hidden" name="ope" value="">
                  <input type="hidden" name="id_carrera" value="">
                  <!-- OH BUENO, FALTA VER LA TRANSACCION -->
                  <div class="p-6.5">
                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">

                      <div class="w-full xl:w-2/6">
                        <label class="mb-2.5 block text-black dark:text-white">
                          Descripción <span class="text-meta-1">*</span>
                        </label>
                        <input type="text" maxlength="200" minlength="5" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" required placeholder="Ingresa el nombre de la carrera" name="nombre_carrera" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>
                      <div class="w-full xl:w-2/6">
                        <label class="mb-2.5 block text-black dark:text-white">
                          Fecha de la Actividad <span class="text-meta-1">*</span>
                        </label>
                        <input type="date" required name="" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>
                      <div class="w-full xl:w-2/6">
                        <label class="mb-2.5 block text-black dark:text-white">
                          Tiempo <span class="text-meta-1">*</span>
                        </label>
                        <input type="time" required name="" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
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

                    // $data= new stdClass();
                    // $data->id_proyecto=$_GET["id_proyecto"];
                    // $actividadModelo=new cls_actividad();
                    // $actividadModelo->setDatos($data);
                    // $actividades=$actividadModelo->consultarTodasLasActvidadesDelProyectoSinAsistencias();
                    // var_dump($actividades);
                    
                    foreach($estudiantes as $estudiante){
                      ?>
                      <tr>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                          <p class="text-black dark:text-white"><?php echo $estudiante['nombre_usuario'];?></p>
                        </td>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                          <input type="checkbox" name="" id="">
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
</body>

</html>