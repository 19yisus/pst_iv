<?php
									if(isset($data_grupo['id_grupo'])){
										?>
								<div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
									<h4 class="font-semibold text-lg">Datos del grupo al que pertenece</h4>
									<div class="max-w-full overflow-x-auto">
										<table class="w-full table-auto">
											<thead>
												<tr class="bg-gray-2 text-left dark:bg-meta-4">
													<th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
														Nombre del grupo
													</th>
													<th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
														Cantidad de estudiantes
													</th>
													<th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
														Estado
													</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
														<p class="text-black dark:text-white"><?php echo $data_grupo['nombre_grupo'];?></p>
													</td>
													<td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
														<p class="text-black dark:text-white"><?php echo $data_grupo['cantidad_estudiantes'];?></p>
													</td>
													<td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
														<?php $text = ($data_grupo['estado_grupo'] == '1') ? "text-success" : "text-danger";?>
														<p class="inline-flex rounded-full bg-success bg-opacity-10 py-1 px-3 text-sm font-medium <?php echo $text;?>">
														<?php echo ($data_grupo['estado_grupo'] == '1') ? "Activo" : "Inactivo";?>
														</p>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>	
								<?php
									}else{
										?>
										<h1 class="font-bold text-lg p-10">No hay grupo registrado</h1>
										<?php
									}

									if(isset($data_proyecto['id_proyecto'])){
										?>
									<div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
										<h4 class="font-semibold text-lg">Datos del proyecto</h4>
										<div class="max-w-full overflow-x-auto">
											<table class="w-full table-auto">
												<thead>
													<tr class="bg-gray-2 text-left dark:bg-meta-4">
														<th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
															Titulo
														</th>
														<th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
															Comunidad
														</th>
														<th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
															Grupo
														</th>
														<th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
															Lapso académico
														</th>
														<th class="min-w-[40px] py-4 px-4 font-medium text-black dark:text-white">
															Estado
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
															<p class="text-black dark:text-white"><?php echo $data_proyecto['titulo_proyecto'];?></p>
														</td>
														<td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
															<p class="text-black dark:text-white"><?php echo $data_proyecto['nombre_comunidad'];?></p>
														</td>
														<td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
															<p class="text-black dark:text-white"><?php echo $data_proyecto['nombre_grupo'];?></p>
														</td>
														<td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
															<p class="text-black dark:text-white"><?php echo $data_proyecto['ano_escolar_nombre'];?></p>
														</td>
														<td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
															<?php 
																$text = ($data_proyecto['estado_proyecto'] == '1') ? "text-success" : "text-danger";
																$mensaje = "";

																if($data_proyecto['estado_proyecto'] == '0') $mensaje = "En proceso";
																if($data_proyecto['estado_proyecto'] == '1') $mensaje = "Aprobado";
																if($data_proyecto['estado_proyecto'] == '2') $mensaje = "Reprobado";

															?>
															<p class="inline-flex rounded-full bg-success bg-opacity-10 py-1 px-3 text-sm font-medium <?php echo $text;?>">
															<?php echo $mensaje;?>
															</p>
														</td>
													</tr>
												</tbody>
												
											</table>
										</div>
									</div>	


										<?php
									}else{
										?>
										<h1 class="font-bold text-lg p-10">No hay proyecto registrado</h1>
										<?php
									}
								?>