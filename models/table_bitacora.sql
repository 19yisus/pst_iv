
CREATE TABLE `bitacora` (
  `id_operacion` int NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `tabla_change` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `hora_fecha` datetime DEFAULT NULL,
  `id_usuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;


ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id_operacion`),
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `bitacora`
  MODIFY `id_operacion` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`cedula_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE;
