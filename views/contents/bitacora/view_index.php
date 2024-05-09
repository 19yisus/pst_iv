<!DOCTYPE html>
<html lang="en">
<?php 
  $this->GetHeader("SGSC | UNEFA");
?>
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
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Bitacora
          </h2>          
        </div>
        <!-- Breadcrumb End -->
          <!-- ====== Table Three Start -->
          <div class="rounded-sm border border-stroke bg-white px-5 mb-2 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <div class="max-w-full overflow-x-auto">
              <table class="w-full table-auto overflow-x-auto my-2" id="tabla">
                <thead>
                  <tr class="bg-gray-2 text-left dark:bg-meta-4">
                    <th class="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                      ID
                    </th>
                    <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                      Módulo
                    </th>
                    <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                      hora y fecha
                    </th>
                    <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                      Responsable
                    </th>
                    <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                      Descripción
                    </th>
                  </tr>
                </thead>
                <tbody>
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
  <script>
      $(document).ready(function () {
        let table = $("#tabla").dataTable({
          "ajax": {
            "url": "<?php $this->SetURL('controllers/auth_controller.php?ope=Get_bitacora');?>",
            "dataSrc": "data"
          },
          "columns": [
          { data: "id_operacion" },
          { data: "tabla_change"},
          { data: "hora_fecha",
            // render: function(data){
            //  return moment(data).format("DD/MM/YYYY h:mm A")
            // }
          },
          { data: "nombre_usuario"},
          { data: "descripcion"},
          ],
          language: {
            url: `<?php $this->SetURL('views/js/DataTable.config.json');?>`
          },
          "pagingType": "simple",
        });

        setTimeout(() => {
          $("#tabla tr td").addClass("border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11 text-center")
          $("#tabla_length").addClass("p-2 flex flex-end")
          $("#tabla_filter").addClass("p-2 flex flex-end")
          $("#tabla_filter input").addClass("w-2/1 rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary")
          $("#tabla_previous").addClass("p-2 rounded-md bg-meta-4 text-white")
          $("#tabla_next").addClass("p-2 rounded-md bg-meta-4 text-white")  
        }, 100);
      });
  </script>
</body>

</html>