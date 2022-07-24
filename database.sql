USE prueba IF NOT EXISTS CREATE DATABASE prueba

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Apellidos` varchar(200) NOT NULL,
  `Genero` varchar(200) NOT NULL,
  `Anios` int(11) NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaModificacion` datetime NOT NULL,
  `Email` text NOT NULL,
  `pass` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `user` (`id`, `Nombre`, `Apellidos`, `Genero`, `Anios`, `FechaCreacion`, `FechaModificacion`, `Email`, `pass`) VALUES
(4, 'Jair', 'Hernandez', 'male', 29, '2022-07-23 19:24:02', '2022-07-23 19:24:02', 'ptb.jair@gmail.com', '1234567890'),
(5, 'Joel', 'Medina', 'Male', 22, '2022-07-23 19:27:38', '2022-07-23 19:27:38', 'asd@gmail.com', '1122'),
(6, 'Valentin', 'Lopez', 'Male', 34, '2022-07-23 23:22:23', '2022-07-23 23:22:23', 'Vale@gmail.com', '1122');

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;



CREATE TABLE `user_data` (
  `id_user` int(11) NOT NULL,
  `Ciudad` text NOT NULL,
  `Estado` text NOT NULL,
  `Pais` text NOT NULL,
  `Fecha_creacion` datetime NOT NULL,
  `Fecha_Modificacion` datetime NOT NULL,
  `Personaje` varchar(500) NOT NULL,
  `Comic` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id_user`, `Ciudad`, `Estado`, `Pais`, `Fecha_creacion`, `Fecha_Modificacion`, `Personaje`, `Comic`) VALUES
(4, 'Cotazacoaocs', 'Veracruz', 'México', '2022-07-23 19:24:02', '2022-07-23 19:24:02', 'WOLVERINE', 'OLD MAN LOGAN'),
(5, 'Yoro', 'Yoro', 'Honduras', '2022-07-23 19:27:38', '2022-07-23 19:27:38', 'HULK', 'WORLD WARD HULK'),
(6, 'Arriaga', 'Oaxaca', 'México', '2022-07-23 23:22:23', '2022-07-23 23:22:23', 'Domino', 'Deapol Pulp');







DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `INDATA`(IN `Correo` VARCHAR(50), IN `passwords` VARCHAR(500), IN `Nombre` VARCHAR(500), IN `Apelido` VARCHAR(500), IN `Edad` INT(11), IN `PaisS` VARCHAR(500), IN `EstadoS` VARCHAR(500), IN `CiudadS` VARCHAR(500), IN `Personaje` VARCHAR(500), IN `Comic` VARCHAR(500), IN `Generos` VARCHAR(500))
    DETERMINISTIC
BEGIN
DECLARE IDS INT(11);

INSERT INTO user (user.Nombre,user.Apellidos,user.Genero,user.Anios,user.FechaCreacion,user.FechaModificacion,user.Email,user.pass) values (Nombre,Apelido,Generos,Edad,now(),now(),Correo,passwords);
SELECT MAX(id) INTO IDS FROM user;
INSERT INTO user_data (user_data.id_user,user_data.Ciudad,user_data.Estado,user_data.Pais,user_data.Fecha_creacion,user_data.Fecha_Modificacion,user_data.Personaje,user_data.Comic) VALUES (IDS,CiudadS,EstadoS,PaisS,now(),now(),Personaje,Comic);


END$$
DELIMITER ;



DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `Logins`(`Correo` VARCHAR(300), `passwords` VARCHAR(500)) RETURNS varchar(20) CHARSET utf8mb4
    DETERMINISTIC
BEGIN
DECLARE Valor VARCHAR(200);
SELECT user.Email into Valor FROM user WHERE user.Email = Correo AND user.pass = passwords;     

IF(Valor != '')THEN
RETURN 'DENTRO';
ELSE
RETURN '';
END IF;

END$$
DELIMITER ;