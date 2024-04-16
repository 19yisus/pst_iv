<!DOCTYPE html>
<html lang="en">
<?php
$this->GetHeader("SGSC | UNEFA");

$formulario = 1;
$pregunta1 = $pregunta2 = $pregunta3 = null;
$cedula_usuario = null;

function getPregunta($id, $model)
{
  if ($id === null) return "?";
  $result = $model->consultarPreguntaFromUser($id);
  return $result['des_pregunta'];
}

if (isset($_POST['op'])) {
  require_once("./models/cls_auth.php");
  $model = new cls_auth();

  if ($_POST['op'] == "busqueda") {
    $datos = $model->consulta($_POST['cedula_usuario']);
    if (isset($datos)) {

      $pregunta1 = getPregunta($datos['id_pregunta_1'], $model);
      $pregunta2 = getPregunta($datos['id_pregunta_2'], $model);
      $pregunta3 = $datos['pregunta_3'];
      $cedula_usuario = $_POST['cedula_usuario'];

      $formulario = 2;
    } else header("Location: " . constant("URL") . "auth/login/err/05AUTH");
  }

  if ($_POST['op'] == "Preguntas") {
    $datos = $model->ValidaPreguntas($_POST);

    if (isset($datos)) {
      $cedula_usuario = $_POST['cedula_usuario'];

      $formulario = 3;
    } else header("Location: " . constant("URL") . "auth/login/err/08AUTH");
  }

  if ($_POST['op'] == "Cambio") {
    $datos = $model->ChangePsw($_POST);
    require_once("./models/config.php");

    if (isset($datos)) {
      header("Location: " . constant("URL") . "auth/login/msg/03AUTH");
    } else header("Location: " . constant("URL") . "auth/login/err/01AUTH");
  }
}
?>

<body x-data="{ page: 'signin', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="
          darkMode = JSON.parse(localStorage.getItem('darkMode'));
          $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">

  <!-- ===== Page Wrapper Start ===== -->
  <div class="flex h-screen overflow-hidden">
    <!-- ===== Content Area Start ===== -->
    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
      <main>
        <!-- FORMULARIO DE EJEMPLO -->
        <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
          <?php if ($formulario == 1) { ?>
            <!-- ====== Form Layout Section Start -->
            <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
              <!-- ====== Form Layout Section Start -->
              <div class="grid grid-cols-1 gap-9 sm:grid-cols-1">
                <div class="flex flex-col gap-9">
                  <!-- Contact Form -->
                  <div class=" rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                      <h3 class="font-semibold text-black dark:text-white text-center">
                        <!-- Consultar datos del usuario -->
                        Recuperación de clave de acceso
                      </h3>
                    </div>
                    <form action="#" method="POST" class="" autocomplete="off">
                      <input type="hidden" name="op" value="busqueda">
                      <div class="p-6.5">
                        <div class="mb-4.5 flex justify-center items-center">
                          <div class="w-1/2 xl:w-2/6">
                            <label class="mb-2.5 block text-black dark:text-white">
                              Ingrese la cedula del usuario para poder continuar con el proceso<span class="ml-4 text-meta-1 ">*</span>
                            </label>
                            <input type="text" placeholder="" name="cedula_usuario" pattern="[0-9]{7,8}" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                          </div>
                        </div>

                        <div id="abrir" class="flex flex-row justify-center items-center mb-6 ">
                          <button type="submit" class=" flex w-72 flex-col justify-center items-center rounded bg-primary p-3 font-medium text-gray cursor-pointer">
                            <label class="" for="btn">Enviar</label>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php
          }
          if ($formulario == 2) {
          ?>
            <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
              <!-- ====== Form Layout Section Start -->
              <div class="grid grid-cols-1 gap-9 sm:grid-cols-1">
                <div class="flex flex-col gap-9">
                  <!-- Contact Form -->
                  <div class=" rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                      <h3 class="font-semibold text-black dark:text-white text-center">
                        Preguntas de Seguridad
                      </h3>
                    </div>
                    <form action="#" method="POST" class="" autocomplete="off">
                      <input type="hidden" name="op" value="Preguntas">
                      <input type="hidden" name="cedula_usuario" value="<?php echo $cedula_usuario; ?>">
                      <div class="p-6.5">
                        <div class="mb-6">
                          <label class="mb-2.5 block font-medium text-black dark:text-white"><?php echo $pregunta1; ?>?</label>
                          <div class="relative">
                            <input type="text" placeholder="Ingrese Respuesta de Seguridad" name="respuesta_1" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                          </div>
                        </div>

                        <div class="mb-6">
                          <label class="mb-2.5 block font-medium text-black dark:text-white"><?php echo $pregunta2; ?>?</label>
                          <div class="relative">
                            <input type="text" placeholder="Ingrese Respuesta de Seguridad" name="respuesta_2" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                          </div>
                        </div>

                        <div class="mb-6">
                          <label class="mb-2.5 block font-medium text-black dark:text-white"><?php echo $pregunta3; ?>?</label>
                          <div class="relative">
                            <input type="text" placeholder="Ingrese Respuesta de Seguridad" name="respuesta_3" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                          </div>
                        </div>

                      </div>
                      <div class="flex flex-row justify-center items-center mb-6">
                        <button type="submit" class=" flex w-72 flex-col justify-center items-center rounded bg-primary p-3 font-medium text-gray cursor-pointer">
                          <label class="" for="btn">Enviar</label>
                        </button>
                      </div>
                  </div>

                  </form>
                </div>
              </div>
            </div>
          <?php
          }
          if ($formulario == 3) {
          ?>
            <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
              <!-- ====== Form Layout Section Start -->
              <div class="grid grid-cols-1 gap-9 sm:grid-cols-1">
                <div class="flex flex-col gap-9">
                  <!-- Contact Form -->
                  <div class=" rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                      <h3 class="font-semibold text-black dark:text-white text-center">
                        Actualicacion de Clave de acceso
                      </h3>
                    </div>
                    <form action="#" method="POST" class="" autocomplete="off">
                      <input type="hidden" name="op" value="Cambio">
                      <div class="p-6.5">
                        <div class="mb-4.5 flex justify-center items-center">
                          <div class="m-4 w-full xl:w-2/6">
                            <label class="mb-2.5 block text-black dark:text-white">
                              Cedula del Usuario<span class="ml-4 text-meta-1 ">*</span>
                            </label>
                            <input type="text" placeholder="" readonly value="<?php echo $cedula_usuario; ?>" name="cedula_usuario" class=" w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                            <span class="absolute" style="right: 20px;bottom: 14px;" onclick="mostrarClave('pass_user',this)">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </span>
                          </div>
                          <div class=" m-4 w-full xl:w-2/6 relative">
                            <label class="mb-2.5 block text-black dark:text-white">
                              Contraseña<span class="ml-4 text-meta-1 ">*</span>
                            </label>
                            <input type="password" placeholder=""  onkeyup="validarPassword()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="clave_usuario" id="clave_usuario" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                            <span class="absolute" style="right: 20px;bottom: 14px;" onclick="mostrarClave('clave_usuario',this)">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </span>
                          </div>
                        </div>
                        <div id="messages_clave"></div>
                        <div id="abrir" class="flex flex-row justify-center items-center mb-6 ">
                          <button type="submit" class=" flex w-72 flex-col justify-center items-center rounded bg-primary p-3 font-medium text-gray cursor-pointer">
                            <label class="" for="btn">Enviar</label>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              
            </div>
          <?php
          }
          ?>
      </main>
    </div>
    <!-- ===== Content Area End ===== -->
  </div>
  <!-- ===== Page Wrapper End ===== -->
  <?php $this->GetComplement('scripts'); ?>
  <script>
    function mostrarClave(idInputPass,contendorIcon){
			let input=document.getElementById(idInputPass)
			if(input.type=="password"){
				input.type="text"
				contendorIcon.innerHTML=`
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
				`
			}
			else{
				input.type="password"
				contendorIcon.innerHTML=`
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
				`
			}
		}

    function validarPassword() {
			const password = document.getElementById('clave_usuario').value;
			const messages = document.getElementById('messages_clave');
			messages.innerHTML = '';

			// Validaciones
			let valido = true;

			if (password.length < 7) {
				messages.innerHTML += 'La contraseña debe tener al menos 7 caracteres.<br>';
				valido = false;
			}

			if (!/[A-Z]/.test(password)) {
				messages.innerHTML += 'La contraseña debe contener al menos una mayúscula.<br>';
				valido = false;
			}

			if (!/\d/.test(password)) {
				messages.innerHTML += 'La contraseña debe contener al menos un número.<br>';
				valido = false;
			}

			if (!/[^a-zA-Z0-9]/.test(password)) {
				messages.innerHTML += 'La contraseña debe contener al menos un caracter especial ejemplo puede ser (@, #, &, $ etc...).<br>';
				valido = false;
			}

			if (valido) {
				messages.innerHTML = 'La contraseña cumple con todas las condiciones.';
			}
		}
  </script>
</body>

</html>