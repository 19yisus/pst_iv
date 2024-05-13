<!DOCTYPE html>
<html lang="en">
<?php 

require_once("./models/cls_actividad.php");

$cls_actividad=new cls_actividad();
$datosDelProyecto=$cls_actividad->consultarProyecto($_GET["id_proyecto"])[0];

?>
<?php $this->GetHeader("SGSC | UNEFA");?>
<body
	x-data="{ page: 'signin', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
	x-init="
          darkMode = JSON.parse(localStorage.getItem('darkMode'));
          $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
	:class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">

	<!-- ===== Page Wrapper Start ===== -->
	<div class="flex h-screen overflow-hidden">
		<?php $this->GetComplement('sidebar_menu');?>
		<!-- ===== Content Area Start ===== -->
		<div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
		<?php $this->GetComplement('header');?>
      <main>
        <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
        <?php 
          // $this->GetComplement('breadcrumb',['title_breadcrumb' => "Actividades del Proyecto: ".$datosDelProyecto["titulo_proyecto"]]);
        ?>
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <h2 class="text-title-md2 font-bold text-black dark:text-white">
            <?php echo" Actividades del Proyecto: ".$datosDelProyecto["titulo_proyecto"];?>
          </h2>
          <nav>
            <ol class="flex items-center gap-2">
              <li><a class="font-medium text-capitalize" href="<?php $this->SetURL("proyecto/index");?>">Gestión de proyectos/</a></li>
              <li class="font-medium text-primary"><a class="font-medium" href="<?php $this->SetURL($this->controlador."/formulario?id_proyecto=".$_GET["id_proyecto"]."&ope=Guardar");?>">Registrar</a></li>
            </ol>
          </nav>
        </div>
        <?php

        ?>
          <!-- ====== Table Three Start -->
          <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                  <tr class="bg-gray-2 text-left dark:bg-meta-4">
                    <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                      Descripción
                    </th>
                    <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                      Fecha
                    </th>
                    <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                      Duración
                    </th>
                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                      
                    </th>
                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                      
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $data= new stdClass();
                    $data->id_proyecto=$_GET["id_proyecto"];
                    $actividadModelo=new cls_actividad();
                    $actividadModelo->setDatos($data);
                    $actividades=$actividadModelo->consultarTodasLasActvidadesDelProyectoSinAsistencias();
                    // var_dump($actividades);
                    
                    foreach($actividades as $actividad){
                        $fecha_actividad=new DateTime($actividad['fecha_actividad']);
                      ?>
                      <tr>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                          <p class="text-black dark:text-white"><?php echo $actividad['descripcion'];?></p>
                        </td>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                          <p class="text-black dark:text-white"><?php echo $fecha_actividad->format("d-m-Y");?></p>
                        </td>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                          <p class="text-black dark:text-white"><?php echo $actividad['tiempo'];?> H</p>
                        </td>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                          <div class="flex items-center space-x-3.5">
                            <a href="<?php $this->SetURL('actividad/formulario?id_proyecto='.$_GET["id_proyecto"]."&ope=Guardar&id_actividad=".$actividad['id_actividad']);?>">Editar</a>
                          </div>
                        </td>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                          <div class="flex items-center space-x-3.5">
                            <a href="<?php $this->SetURL('/controllers/actividad_controller.php?id_actividad='.$actividad['id_actividad']."&ope=eliminarActividad&id_proyecto=".$_GET["id_proyecto"]);?>">eliminar</a>
                          </div>
                        </td>
                      </tr>
                      
                      <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- ====== Table Three End -->
        </div>
      </main>
		</div>
		<!-- ===== Content Area End ===== -->
	</div>
	<!-- ===== Page Wrapper End ===== -->
	<?php $this->GetComplement('scripts');?>
</body>

</html>