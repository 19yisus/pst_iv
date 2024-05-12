<!DOCTYPE html>
<html lang="en">
<?php
$this->GetHeader("SGSC | UNEFA");

$op = "Registrar";
$id_estudiante = $cedula = $nombre = $correo = $edad = $sexo = null;
$telefono = null;
$if_tutor = false;
$if_estudiante = true;
$matricula = null;
$categoria = null;
$nacionalidad = null;
$pregunta1 = "";
$respuesta1 = "";
$pregunta2 = "";
$respuesta2 = "";
$pregunta3 = "";
$respuesta3 = "";

if (isset($this->id_consulta)) {
  require_once("./models/cls_estudiante.php");
  $model = new cls_estudiante();
  $datos = $model->consulta($this->id_consulta);

  if (isset($datos['cedula_usuario'])) {
    $op = "Actualizar";
    $id_estudiante = $this->id_consulta;
    $cedula = $datos['cedula_usuario'];
    $nombre = $datos['nombre_usuario'];
    $correo = $datos['correo_usuario'];
    $nacionalidad = $datos['nacionalidad_usuario'];
    $edad = $datos['edad_usuario'];
    $sexo = $datos['genero_usuario'];
    $telefono = $datos['telefono_usuario'];
    $matricula = $datos['matricula_estudiante'];

    $lista_preguntas = $model->getListOfPreguntas();
    $if_estudiante = ($_SESSION['cedula'] === $datos['cedula_usuario']) ? true : false;

    $pregunta1 = $datos['id_pregunta_1'];
    $respuesta1 = "";
    $pregunta2 = $datos['id_pregunta_2'];
    $respuesta2 = "";
    $pregunta3 = $datos['pregunta_3'];
    $respuesta3 = "";
  } else {
    $if_estudiante = false;
  }
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
          <?php
          $this->GetComplement('breadcrumb', ['title_breadcrumb' => "Gestión Estudiante"]);
          ?>
          <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
              <h3 class="font-semibold text-black dark:text-white">
                Gestión de Estudiante
              </h3>
            </div>
            <form action="<?php $this->SetURL("controllers/estudiante_controller.php"); ?>" method="POST" autocomplete="off" class="flex flex-wrap items-center">
              <div class="w-full border-stroke dark:border-strokedark xl:border-l-2">
                <div class="w-full grid grid-cols-4 gap-4 p-4 sm:p-12.5 xl:p-17.5">
                  <input type="hidden" name="ope" value="<?php echo $op; ?>">
                  <input type="hidden" name="permisos_usuario" value="3">
                  <input type="hidden" name="id_estudiante" value="<?php echo $id_estudiante; ?>">
                  <input type="hidden" name="tipo_usuario" value="ESTUDIANTE">
                  <!-- <input type="hidden" name="return" value=""> -->

                  <div class="mb-6">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Nacionalidad<span class="text-meta-1">*</span>:</label>
                    <div class="flex items-center space-x-4">
                      <div class="mr-3">
                        <label for="radioVenezolano" class="flex cursor-pointer select-none items-center">
                          <div class="relative">
                            <input type="radio" id="radioVenezolano" required class="" name="nacionalidad_usuario" value="V" <?php if (isset($nacionalidad) && $nacionalidad == "V") echo "checked"; ?> />
                          </div>
                          Venezolano
                        </label>
                      </div>

                      <div class="ml-3">
                        <label for="radioExtranjero" class="flex cursor-pointer select-none items-center">
                          <div class="relative">
                            <input type="radio" id="radioExtranjero" required class="" name="nacionalidad_usuario" value="E" <?php if (isset($nacionalidad) && $nacionalidad == "E") echo "checked"; ?> />
                          </div>
                          Extranjero
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Cédula<span class="text-meta-1">*</span></label>
                    <div class="relative">
                      <input type="text" maxlength="8" autocomplete="off" title="solo se admiten numeros" pattern="[0-9]{7,8}" placeholder="Ingrese su cédula" name="cedula_usuario" value="<?php echo $cedula; ?>" <?php echo (isset($op) && $op == "Actualizar") ? "readonly" : ""; ?> class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">
                      Nombres y Apellidos<span class="text-meta-1">*</span>
                    </label>
                    <div class="relative">

                      <input type="text" maxlength="45" autocomplete="off" placeholder="Ingrese su nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" name="nombre_usuario" value="<?php echo $nombre; ?>" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Correo<span class="text-meta-1">*</span></label>
                    <div class="relative">
                      <input type="email" maxlength="120" autocomplete="off" placeholder="Ingrese su correo electrónico" name="correo_usuario" value="<?php echo $correo; ?>" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Edad<span class="text-meta-1">*</span></label>
                    <div class="relative">
                      <input type="text" maxlength="2" autocomplete="off" placeholder="edad" pattern="[0-9]{1,2}" title="solo se ingresan numeros" name="edad_usuario" value="<?php echo $edad; ?>" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                  </div>

                  <div class="mb-6">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Número de Teléfono<span class="text-meta-1">*</span></label>
                    <div class="relative">
                      <input type="text" id="telefono" autocomplete="off" minmength="13" maxlength="13" title="solo se admiten números" placeholder="Ingrese su número de teléfono" name="telefono_usuario" value="<?php echo $telefono; ?>" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                  </div>

                  <div class="mb-6">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Sexo<span class="text-meta-1">*</span>:</label>
                    <div class="flex items-center space-x-4">
                      <div class="mr-3">
                        <label for="radioSexoF" class="flex cursor-pointer select-none items-center">
                          <div class="relative">
                            <input type="radio" id="radioSexoF" required class="" name="genero_usuario" value="F" <?php if (isset($sexo) && $sexo == "F") echo "checked"; ?> />
                          </div>
                          Femenino
                        </label>
                      </div>

                      <div class="ml-3">
                        <label for="RadioSexoM" class="flex cursor-pointer select-none items-center">
                          <div class="relative">
                            <input type="radio" id="RadioSexoM" required class="" name="genero_usuario" value="M" <?php if (isset($sexo) && $sexo == "M") echo "checked"; ?> />
                          </div>
                          Masculino
                        </label>
                      </div>
                    </div>
                  </div>

                  <!-- <div class="mb-6">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Matricula<span class="text-meta-1">*</span></label>
                    <div class="relative">
                      <input type="text" minmength="2" maxlength="12" placeholder="Ingrese la matricula" name="matricula_estudiante" value="<?php //echo $matricula; ?>" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                  </div> -->
                  <div class="col-span-3"></div>

                  <?php if ($op === "Actualizar" && $if_estudiante === true) { ?>
                    <div class="w-full">
                      <label class="mb-3 block font-medium text-black dark:text-white">
                        Seleccione su primera pregunta de seguridad <span class="text-meta-1">*</span>
                      </label>
                      <div class="relative z-20 bg-white dark:bg-form-input">
                        <select required name="id_pregunta_1" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                          <option value="">Seleccione una opción</option>
                          <?php foreach ($lista_preguntas as $item) { ?>
                            <option value="<?php echo $item['id_pregunta']; ?>" <?php echo (isset($pregunta1) && $pregunta1 === $item['id_pregunta']) ? "selected" : ""; ?>><?php echo $item['des_pregunta']; ?></option>
                          <?php } ?>
                        </select>
                        <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.8">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill="#637381"></path>
                            </g>
                          </svg>
                        </span>
                      </div>
                    </div>

                    <div class="mb-6 col-span-2">
                      <label class="mb-2.5 block font-medium text-black dark:text-white">Primera respuesta de seguridad</label>
                      <div class="relative">
                        <input type="text" maxlength="60" autocomplete="off" placeholder="Ingrese su respuesta de seguridad" name="2" value="<?php echo $respuesta1; ?>" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>
                    </div>

                    <div class="w-full">
                      <label class="mb-3 block font-medium text-black dark:text-white">
                        Seleccione su segunda pregunta de seguridad <span class="text-meta-1">*</span>
                      </label>
                      <div class="relative z-20 bg-white dark:bg-form-input">
                        <select required name="id_pregunta_2" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                          <option value="">Seleccione una opción</option>
                          <?php foreach ($lista_preguntas as $item) { ?>
                            <option value="<?php echo $item['id_pregunta']; ?>" <?php echo (isset($pregunta2) && $pregunta2 === $item['id_pregunta']) ? "selected" : ""; ?>><?php echo $item['des_pregunta']; ?></option>
                          <?php } ?>
                        </select>
                        <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.8">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill="#637381"></path>
                            </g>
                          </svg>
                        </span>
                      </div>
                    </div>
                    <div class="mb-6 col-span-2">
                      <label class="mb-2.5 block font-medium text-black dark:text-white">Segunda respuesta de seguridad</label>
                      <div class="relative">
                        <input type="text" maxlength="60" autocomplete="off" placeholder="Ingrese su respuesta de seguridad" name="respuesta_2" value="<?php echo $respuesta2; ?>" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>
                    </div>

                    <div class="w-full">
                      <label class="mb-2.5 block font-medium text-black dark:text-white">Tercera pregunta de seguridad</label>
                      <div class="relative">
                        <input type="text" maxlength="60" autocomplete="off" placeholder="Ingrese su pregunta de seguridad" name="pregunta_3" value="<?php echo $pregunta3; ?>" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>
                    </div>

                    <div class="mb-6 col-span-2">
                      <label class="mb-2.5 block font-medium text-black dark:text-white">Tercera respuesta de seguridad</label>
                      <div class="relative">
                        <input type="text" maxlength="60" autocomplete="off" placeholder="Ingrese su respuesta de seguridad" name="respuesta_3" value="<?php echo $respuesta3; ?>" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>
                    </div>
                    
                    <div class="mb-6 col-span-2">
                      <label class="mb-2.5 block font-medium text-black dark:text-white">Contraseña <span class="text-meta-1">*</span></label>
                      <div class="relative">
                        <input type="password" autocomplete="off" maxlength="60" id="pass_user" placeholder="Ingrese su clave" name="clave_usuario" value="" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        <span class="absolute right-4 top-4" style="right: 60px;" onclick="mostrarClave('pass_user',this)">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
												</span>
												<span class="absolute right-4 top-4">
													<svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
														<g opacity="0.5">
															<path d="M16.1547 6.80626V5.91251C16.1547 3.16251 14.0922 0.825009 11.4797 0.618759C10.0359 0.481259 8.59219 0.996884 7.52656 1.95938C6.46094 2.92188 5.84219 4.29688 5.84219 5.70626V6.80626C3.84844 7.18438 2.33594 8.93751 2.33594 11.0688V17.2906C2.33594 19.5594 4.19219 21.3813 6.42656 21.3813H15.5016C17.7703 21.3813 19.6266 19.525 19.6266 17.2563V11C19.6609 8.93751 18.1484 7.21876 16.1547 6.80626ZM8.55781 3.09376C9.31406 2.40626 10.3109 2.06251 11.3422 2.16563C13.1641 2.33751 14.6078 3.98751 14.6078 5.91251V6.70313H7.38906V5.67188C7.38906 4.70938 7.80156 3.78126 8.55781 3.09376ZM18.1141 17.2906C18.1141 18.7 16.9453 19.8688 15.5359 19.8688H6.46094C5.05156 19.8688 3.91719 18.7344 3.91719 17.325V11.0688C3.91719 9.52189 5.15469 8.28438 6.70156 8.28438H15.2953C16.8422 8.28438 18.1141 9.52188 18.1141 11V17.2906Z" fill="" />
															<path d="M10.9977 11.8594C10.5852 11.8594 10.207 12.2031 10.207 12.65V16.2594C10.207 16.6719 10.5508 17.05 10.9977 17.05C11.4102 17.05 11.7883 16.7063 11.7883 16.2594V12.6156C11.7883 12.2031 11.4102 11.8594 10.9977 11.8594Z" fill="" />
														</g>
													</svg>
												</span>
												<span id="messages_clave"></span>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <div class="mb-5 p-6">
                  <input type="submit" value="Guardar" class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white transition hover:bg-opacity-90" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>
    <!-- ===== Content Area End ===== -->
  </div>
  <!-- ===== Page Wrapper End ===== -->
  <?php $this->GetComplement('scripts'); ?>
  <script>
    $("#pass_user").on("keyup", (e) => {
			// var regex = new RegExp('(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}');
			// console.log(regex.test(e.target.value))
			console.log(e.target.value, $("#cedula_user").val())
			if (e.target.value === $("#cedula_user").val()) $("#pass_user").removeAttr("pattern", "");
			else $("#pass_user").attr("pattern", '(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{7,}');
		});

		function validarNumerico(input) {
			// Reemplazar cualquier caracter que no sea un número con una cadena vacía
			input.value = input.value.replace(/[^\d]/g, '');
		}

		function validarPassword() {
			const password = document.getElementById('pass_user').value;
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
				messages.innerHTML += 'La contraseña debe contener al menos un carácter especial ejemplo puede ser (@, #, &, $ etc...).<br>';
				valido = false;
			}

			if (valido) {
				messages.innerHTML = 'La contraseña cumple con todas las condiciones.';
			}
		}

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
  </script>
</body>

</html>