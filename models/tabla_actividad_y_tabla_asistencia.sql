CREATE TABLE `actividad` (
    `id_actividad` int NOT NULL,
    `id_proyecto` int NOT NULL,
    `descripcion` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
    `fecha_actividad` datetime DEFAULT NULL,
    `tiempo` time DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_spanish_ci;

ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `fk_proyecto_actividad` (`id_proyecto`);

ALTER TABLE `actividad`
  MODIFY `id_actividad` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `asistencia_actividad` (
    `id_asistencia_actividad` int NOT NULL,
    `id_actividad` int NOT NULL,
    `id_estudiante` int NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_spanish_ci;

ALTER TABLE `asistencia_actividad`
  ADD PRIMARY KEY (`id_asistencia_actividad`),
  ADD KEY `fk_actividad_asistencia_actividad` (`id_actividad`),
  ADD KEY `fk_estudiante_asistencia_actividad` (`id_estudiante`);

ALTER TABLE `asistencia_actividad`
  MODIFY `id_asistencia_actividad` int NOT NULL AUTO_INCREMENT;