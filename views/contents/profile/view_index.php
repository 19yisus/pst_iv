<!DOCTYPE html>
<html lang="en">
<?php 
	$this->GetHeader("SGSC | UNEFA"); 

	require_once("./models/cls_auth.php");
	$model = new cls_auth();

	$data = $model->consulta($_SESSION['cedula']);

	$nacionalidad = $cedula = $nombre = $correo = $edad = $sexo = null;
	$pregunta1 = $respuesta1 = $pregunta2 = $respuesta2 = $pregunta3 = $respuesta3 = null;
	$lista_preguntas = $model->getListOfPreguntas();
	$op = "Actualizar";

	if(isset($data)){
		$nacionalidad = $data['nacionalidad_usuario'];
		$cedula = $data['cedula_usuario'];
		$nombre = $data['nombre_usuario'];
		$correo = $data['correo_usuario'];
		$edad = $data['edad_usuario'];
		$sexo = $data['genero_usuario'];
		$telefono = $data['telefono_usuario'];
	
		$pregunta1 = $data['id_pregunta_1'];
		$respuesta1 = $data['respuesta_1'];
		$pregunta2 = $data['id_pregunta_2'];
		$respuesta2 = $data['respuesta_2'];
		$pregunta3 = $data['pregunta_3'];
		$respuesta3 = $data['respuesta_3'];
	}

?>

<body
	x-data="{ page: 'signin', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
	x-init="
          darkMode = JSON.parse(localStorage.getItem('darkMode'));
          $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
	:class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">

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
							<div
								class=" rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
								<div
									class="border-b border-stroke py-4 px-6.5 dark:border-strokedark justify-center items-center text-center flex mb-4 justify-center">
									<h3 class="font-semibold text-black dark:text-white">
										Gestión de mi Perfil
									</h3>
								</div>
								<form action="<?php $this->SetURL("controllers/auth_controller.php"); ?>" method="POST" autocomplete="off" class="flex flex-wrap items-center">
									<div class="w-full border-stroke dark:border-strokedark xl:border-l-2">
										<div class="w-full grid grid-cols-4 gap-4 p-4 sm:p-12.5 xl:p-17.5">
											<input type="hidden" name="ope" value="<?php echo $op; ?>">
											<!-- <input type="hidden" name="permisos_usuario" value="3">
											<input type="hidden" name="id_estudiante" value="<?php //echo $id_estudiante; ?>">
											<input type="hidden" name="tipo_usuario" value="ESTUDIANTE"> -->
											<!-- <input type="hidden" name="return" value=""> -->

											<div class="mb-6">
												<label class="mb-2.5 block font-medium text-black dark:text-white">Nacionalidad<span
														class="text-meta-1">*</span>:</label>
												<div class="flex items-center space-x-4">
													<div class="mr-3">
														<label for="checkRadioVenezolano" class="flex cursor-pointer select-none items-center">
															<div class="relative">
																<input type="radio" readonly="readonly" id="checkRadioVenezolano" required class=""
																	name="nacionalidad_usuario" value="V" <?php if (isset($nacionalidad) &&
																	$nacionalidad=="V" ) echo "checked" ; ?> />
															</div>
															Venezolano
														</label>
													</div>

													<div class="ml-3">
														<label for="checkRadioExtranjero" class="flex cursor-pointer select-none items-center">
															<div class="relative">
																<input type="radio" readonly="readonly" id="checkRadioExtranjero" required class=""
																	name="nacionalidad_usuario" value="E" <?php if (isset($nacionalidad) &&
																	$nacionalidad=="E" ) echo "checked" ; ?> />
															</div>
															Extranjero
														</label>
													</div>
												</div>
											</div>

											<div class="mb-4">
												<label class="mb-2.5 block font-medium text-black dark:text-white">Cédula<span
														class="text-meta-1">*</span></label>
												<div class="relative">
													<input type="text" required readonly="readonly" maxlength="8" autocomplete="off" title="solo se admiten numeros"
														pattern="[0-9]{7,8}" placeholder="Ingrese su cedula" name="cedula_usuario"
														value="<?php echo $cedula; ?>" <?php echo (isset($op) && $op=="Actualizar" ) ? "readonly"
														: "" ; ?> class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10
													outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark
													dark:bg-form-input dark:focus:border-primary" />
												</div>
											</div>

											<div class="mb-4">
												<label class="mb-2.5 block font-medium text-black dark:text-white">
													Nombre y Apellido<span class="text-meta-1">*</span>
												</label>
												<div class="relative">

													<input type="text" required maxlength="45" autocomplete="off" placeholder="Ingrese su Nombre"
														pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" name="nombre_usuario" value="<?php echo $nombre; ?>"
														class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
												</div>
											</div>

											<div class="mb-4">
												<label class="mb-2.5 block font-medium text-black dark:text-white">Correo<span
														class="text-meta-1">*</span></label>
												<div class="relative">
													<input type="email" required maxlength="120" autocomplete="off" placeholder="Ingrese su Correo"
														name="correo_usuario" value="<?php echo $correo; ?>"
														class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
												</div>
											</div>

											<div class="mb-4">
												<label class="mb-2.5 block font-medium text-black dark:text-white">Edad<span
														class="text-meta-1">*</span></label>
												<div class="relative">
													<input type="text" required maxlength="2" autocomplete="off" placeholder="edad" pattern="[0-9]{1,2}"
														title="solo se ingresan numeros" name="edad_usuario" value="<?php echo $edad; ?>"
														class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
												</div>
											</div>

											<div class="mb-6">
												<label class="mb-2.5 block font-medium text-black dark:text-white">Némero de teléfono<span
														class="text-meta-1">*</span></label>
												<div class="relative">
													<input type="text" id="telefono" required autocomplete="off" minmength="13" maxlength="13"
														title="solo se admiten numeros" placeholder="Ingrese su Numero de Teléfono"
														name="telefono_usuario" value="<?php echo $telefono; ?>"
														class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
												</div>
											</div>

											<div class="mb-6">
												<label class="mb-2.5 block font-medium text-black dark:text-white">Sexo<span class="text-meta-1">*</span>:</label>
												<div class="flex items-center space-x-4">
													<div class="mr-3">
														<label for="CheckRadioFemenino" class="flex cursor-pointer select-none items-center">
															<div class="relative">
																<input type="radio" id="CheckRadioFemenino" required class="" name="genero_usuario"
																	value="F" <?php if (isset($sexo) && $sexo=="F" ) echo "checked" ; ?> />
															</div>
															Femenino
														</label>
													</div>

													<div class="ml-3">
														<label for="CheckRadioMasculino" class="flex cursor-pointer select-none items-center">
															<div class="relative">
																<input type="radio" id="CheckRadioMasculino" required class="" name="genero_usuario"
																	value="M" <?php if (isset($sexo) && $sexo=="M" ) echo "checked" ; ?> />
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

											
											<div class="w-full">
												<label class="mb-3 block font-medium text-black dark:text-white">
													Seleccione su primera pregunta de seguridad <span class="text-meta-1">*</span>
												</label>
												<div class="relative z-20 bg-white dark:bg-form-input">
													<select required name="id_pregunta_1"
														class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
														<option value="">Seleccione una opcion</option>
														<?php foreach ($lista_preguntas as $item) { ?>
														<option value="<?php echo $item['id_pregunta']; ?>" <?php echo (isset($pregunta1) &&
															$pregunta1===$item['id_pregunta']) ? "selected" : "" ; ?>>
															<?php echo $item['des_pregunta']; ?>
														</option>
														<?php } ?>
													</select>
													<span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
															xmlns="http://www.w3.org/2000/svg">
															<g opacity="0.8">
																<path fill-rule="evenodd" clip-rule="evenodd"
																	d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
																	fill="#637381"></path>
															</g>
														</svg>
													</span>
												</div>
											</div>

											<div class="mb-6 col-span-2">
												<label class="mb-2.5 block font-medium text-black dark:text-white">Primera respuesta de
													seguridad</label>
												<div class="relative">
													<input type="text" maxlength="60" required minlength="4" autocomplete="off"
														placeholder="Ingrese su respuesta de seguridad" name="respuesta_1" value="<?php echo $respuesta1; ?>"
														class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
												</div>
											</div>

											<div class="w-full">
												<label class="mb-3 block font-medium text-black dark:text-white">
													Seleccione su segunda pregunta de seguridad <span class="text-meta-1">*</span>
												</label>
												<div class="relative z-20 bg-white dark:bg-form-input">
													<select required name="id_pregunta_2"
														class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
														<option value="">Seleccione una opcion</option>
														<?php foreach ($lista_preguntas as $item) { ?>
														<option value="<?php echo $item['id_pregunta']; ?>" <?php echo (isset($pregunta2) &&
															$pregunta2===$item['id_pregunta']) ? "selected" : "" ; ?>>
															<?php echo $item['des_pregunta']; ?>
														</option>
														<?php } ?>
													</select>
													<span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
															xmlns="http://www.w3.org/2000/svg">
															<g opacity="0.8">
																<path fill-rule="evenodd" clip-rule="evenodd"
																	d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
																	fill="#637381"></path>
															</g>
														</svg>
													</span>
												</div>
											</div>
											<div class="mb-6 col-span-2">
												<label class="mb-2.5 block font-medium text-black dark:text-white">Segunda respuesta de
													seguridad</label>
												<div class="relative">
													<input type="text" required minlength="4" maxlength="60" autocomplete="off"
														placeholder="Ingrese su respuesta de seguridad" name="respuesta_2"
														value="<?php echo $respuesta2; ?>"
														class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
												</div>
											</div>
											<div class="mb-6 col-span-1">
												<label class="mb-2.5 block font-medium text-black dark:text-white">Tercera pregunta de seguridad</label>
												<div class="relative">
													<input type="text" required minlength="4" maxlength="60" autocomplete="off" placeholder="Ingrese su pregunta de seguridad" name="pregunta_3" value="<?php echo $pregunta3; ?>" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
												</div>
											</div>

											<div class="mb-6 col-span-2">
												<label class="mb-2.5 block font-medium text-black dark:text-white">Tercera respuesta de seguridad</label>
												<div class="relative">
													<input type="text" required minlength="4" maxlength="60" autocomplete="off" placeholder="Ingrese su respuesta de seguridad" name="respuesta_3" value="<?php echo $respuesta3; ?>" class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
												</div>
											</div>
											<div class="w-full">
												<label class="mb-3 block font-medium text-black dark:text-white">Periodo de caducidad<span class="text-meta-1">*</span>
												</label>
												<div class="relative z-20 bg-white dark:bg-form-input">
													<select required name="periodo_caducidad"
														class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
														<option value="">Seleccione una opcion</option>
														<option value="30">30 Dias</option>
														<option value="60">60 Dias</option>
														<option value="120">120 Dias</option>
													</select>
													<span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
															xmlns="http://www.w3.org/2000/svg">
															<g opacity="0.8">
																<path fill-rule="evenodd" clip-rule="evenodd"
																	d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
																	fill="#637381"></path>
															</g>
														</svg>
													</span>
												</div>
											</div>
											<div class="mb-6 col-span-2">
												<label class="mb-2.5 block font-medium text-black dark:text-white">Contraseña <span
														class="text-meta-1">*</span></label>
												<div class="relative">
													<input type="password" onkeyup="validarPassword()" required autocomplete="off" minlength="8" maxlength="60" placeholder="Ingrese su clave"
														name="clave_usuario" id="clave_usuario" value=""
														class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
														<span class="absolute" style="right: 20px;bottom: 16px;" onclick="mostrarClave('clave_usuario',this)">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
														</span>
												</div>
												<div id="messages_clave"></div>
											</div>
											
										</div>
										<div class="mb-5 p-6">
											<input type="submit" value="Guardar"
												class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white transition hover:bg-opacity-90" />
										</div>
									</div>
								</form>
							</div>
						</div>
						</form>
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