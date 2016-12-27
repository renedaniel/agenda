/*
	SQL para la generación de la base de datos de agenda
	René Daniel Galicia Vázquez

 	Target Server Type    : MySQL
 	Target Server Version : 100119
 	File Encoding         : utf-8

 	Date: 12/26/2016 22:14:30 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `contacto`
-- ----------------------------
DROP TABLE IF EXISTS `contacto`;
CREATE TABLE `contacto` (
  `contacto_id` int(11) NOT NULL AUTO_INCREMENT,
  `contacto_nombres` varchar(255) NOT NULL,
  `contacto_apellidos` varchar(255) DEFAULT NULL,
  `contacto_direccion` varchar(255) NOT NULL,
  `contacto_telefono` varchar(255) NOT NULL,
  `contacto_correo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`contacto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Procedure structure for `getContactos`
-- ----------------------------
DROP PROCEDURE IF EXISTS getContactos;

CREATE PROCEDURE getContactos()

SELECT *
FROM
  contacto;

-- ----------------------------
--  Procedure structure for `getContactoById`
-- ----------------------------
DROP PROCEDURE IF EXISTS getContactoById;

CREATE PROCEDURE getContactoById(contactoId INT)

SELECT *
FROM
  contacto WHERE contacto_id = contactoId;


SET FOREIGN_KEY_CHECKS = 1;
