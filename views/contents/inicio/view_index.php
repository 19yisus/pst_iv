<!DOCTYPE html>
<html lang="en">
<?php $this->GetHeader("SGSC | UNEFA"); ?>

<body x-data="{ page: 'signin', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="
          darkMode = JSON.parse(localStorage.getItem('darkMode'));
          $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">

	<!-- ===== Page Wrapper Start ===== -->
	<div class="flex h-screen overflow-hidden">
		<?php $this->GetComplement('sidebar_menu'); ?>
		<!-- ===== Content Area Start ===== -->
		<div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
			<?php 
				$this->GetComplement('header'); 

				require_once("models/cls_grupo.php");
				require_once("models/cls_proyecto.php");
				$data_proyecto = null;

				$proyecto = new cls_proyecto();
				$grupo = new cls_grupo();

				$data_grupo = $grupo->consultar_grupo($_SESSION['cedula']);

				if(isset($data_grupo['id_grupo'])) $data_proyecto = $proyecto->consultarPorGrupo($data_grupo['id_grupo']);			
				
			?>


			<main>

				<div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">

					<!-- ====== Form Layout Section Start -->
					<div class="grid grid-cols-1 gap-9 sm:grid-cols-1">

						<div class="flex flex-col gap-9">
						
							<!-- Contact Form -->
							<div class=" rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">

								<div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark justify-center items-center text-center flex mb-4 justify-center">
									<h2 class="text-xl font-semibold text-center text-primary dark:text-bodydark">Bienvenido: <span class="text-black text-md"><?php echo $_SESSION['username'];?></span></h2>		
								</div>
								<?php
									if($_SESSION['nom_rol'] == 'ESTUDIANTE') require_once("componente_inicio_estudiante.php");
								?>
								
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