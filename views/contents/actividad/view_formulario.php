<!DOCTYPE html>
<html lang="en">
<?php
$this->GetHeader("SGSC | UNEFA");

$op = "Registrar";
// $id_carrera = null;
// $codigo_carrera = null;
// $nombre_carrera = null;
// $estado_carrera = null;
// $turno_carrera = null;
// $admite_grupos_mixtos = null;
// AHORA, EN EL CASO DE QUE VAYAMOS A CONSULTAR, LA VARIABLE ID_CONSULTA YA ES DEFINIDA EN LA CLASE APP, AQUI VERIFICAMOS QUE DICHA ID EXISTA, SI EXISTE, REQUERIMOS LA CLASE CARRERA PARA PODER HACER LA CONSULTA DE LA INFORMACION Y ABAJO DEFINIR LAS VARIABLES
// EN EL CASO DE QUE NO VAYAMOS A EDITAR NADA, LA OPERACION SERA REGISTRAR, SINO, LA OPERACION SERA ACTUALIZAR
// if (isset($this->id_consulta)) {
//   require_once("./models/cls_carrera.php");
//   $model = new cls_carrera();
//   $datos = $model->consulta($this->id_consulta);

//   if (isset($datos['id_carrera'])) {
//     $op = "Actualizar";
//     $id_carrera = $datos['id_carrera'];
//     $codigo_carrera = $datos['codigo_carrera'];
//     $nombre_carrera = $datos['nombre_carrera'];
//     $estado_carrera = $datos['estado_carrera'];
//     $turno_carrera = $datos['turno_carrera'];
//     $admite_grupos_mixtos = $datos['admite_grupos_mixtos'];
//   }
// }

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
          <?php
          $this->GetComplement('breadcrumb', ['title_breadcrumb' => "Gestión De Carrera"]);
          ?>
          <!-- ====== Form Layout Section Start -->
          <div class="grid grid-cols-1 gap-9 sm:grid-cols-1">
            <div class="flex flex-col gap-9">
              <!-- Contact Form -->
              <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                  <h3 class="font-semibold text-black dark:text-white">
                    Gestión De Carrera (PREGRADO)
                  </h3>
                </div>
                <!-- ACA ESTA EL FOMULARIO, EL ACTION CONTIENE LA URL ESTATICA QUE APUNTA AL CONTROLADOR DE CARRERA, DICHO FORMULARIO CONTIENE PRIMERO 2 INPUTS DE TIPO HIDDEN (ESCONDIDO), UNO ES PARA DEFINIR QUE OPERACION VAMOS A REALIZAR OPE, Y EL OTRO CAMPO ES PARA METER EL ID DE LA CARRERA -->
                <form action="<?php $this->SetURL('controllers/carrera_controller.php'); ?>" autocomplete="off" method="POST">
                  <input type="hidden" name="ope" value="<?php echo $op; ?>">
                  <input type="hidden" name="id_carrera" value="<?php echo $id_carrera; ?>">
                  <!-- OH BUENO, FALTA VER LA TRANSACCION -->
                  <div class="p-6.5">
                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">

                      <div class="w-full xl:w-2/6">
                        <label class="mb-2.5 block text-black dark:text-white">
                          Nombre de la carrera <span class="text-meta-1">*</span>
                        </label>
                        <input type="text" maxlength="45" minlength="5" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" required placeholder="Ingresa el nombre de la carrera" name="nombre_carrera" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>

                    <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray">
                      Guardar
                    </button>
                  </div>
                </form>
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