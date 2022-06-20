/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.24-MariaDB : Database - seafood2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`seafood2` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `seafood2`;

/*Table structure for table `barang` */

DROP TABLE IF EXISTS `barang`;

CREATE TABLE `barang` (
  `ID_BARANG` char(4) NOT NULL,
  `ID_JENIS` char(2) NOT NULL,
  `NAMA_BARANG` varchar(30) DEFAULT NULL,
  `STOK_BARANG` int(11) DEFAULT NULL,
  `BERAT_BARANG` float(8,2) DEFAULT NULL,
  `HARGA_JUAL` float(8,2) DEFAULT NULL,
  `GAMBAR_BARANG` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_BARANG`),
  KEY `BARANG_J_BARANG_FK` (`ID_JENIS`),
  CONSTRAINT `BARANG_J_BARANG_FK` FOREIGN KEY (`ID_JENIS`) REFERENCES `jenis_barang` (`ID_JENIS`),
  CONSTRAINT `BARANG_STOK_CK` CHECK (`STOK_BARANG` between 0 and 99999)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `barang` */

insert  into `barang`(`ID_BARANG`,`ID_JENIS`,`NAMA_BARANG`,`STOK_BARANG`,`BERAT_BARANG`,`HARGA_JUAL`,`GAMBAR_BARANG`) values 
('1001','11','Tuna',22,2.00,25000.00,NULL);

/*Table structure for table `calon_konsumen` */

DROP TABLE IF EXISTS `calon_konsumen`;

CREATE TABLE `calon_konsumen` (
  `ID_CALON_KONSUMEN` char(8) NOT NULL,
  `ID_NEGARA` char(4) NOT NULL,
  `NAMA_CALON_KONSUMEN` varchar(50) DEFAULT NULL,
  `EMAIL_CALON_KONSUMEN` varchar(100) DEFAULT NULL,
  `PASSWORD_CALON_KONSUMEN` varchar(255) DEFAULT NULL,
  `TGL_PENAWARAN_TERAKHIR` date DEFAULT NULL,
  PRIMARY KEY (`ID_CALON_KONSUMEN`),
  KEY `CKONS_NEGARA_FK` (`ID_NEGARA`),
  CONSTRAINT `CKONS_NEGARA_FK` FOREIGN KEY (`ID_NEGARA`) REFERENCES `negara` (`ID_NEGARA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `calon_konsumen` */

insert  into `calon_konsumen`(`ID_CALON_KONSUMEN`,`ID_NEGARA`,`NAMA_CALON_KONSUMEN`,`EMAIL_CALON_KONSUMEN`,`PASSWORD_CALON_KONSUMEN`,`TGL_PENAWARAN_TERAKHIR`) values 
('10010001','1001','Hilmi Zain','hilmi123@gmail.com','$2y$10$vKuO18k5TBVwgdq6Q2zLEeKfOIztJY.fUSsJfuJlY/dpR3skUrXyu','2022-06-06'),
('10010002','1001','hilmi','hilm@gmail.com','$2y$10$tPDE7ISim0T1tZ7fsk5aOeF/3yto6t0TQ8Etjvpm16PhGCBYMlLr6','2022-06-06');

/*Table structure for table `detail_katalog` */

DROP TABLE IF EXISTS `detail_katalog`;

CREATE TABLE `detail_katalog` (
  `ID_KATALOG` char(6) NOT NULL,
  `ID_BARANG` char(4) NOT NULL,
  `JMLH_BARANG` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_KATALOG`,`ID_BARANG`),
  KEY `DKAT_BARANG_FK` (`ID_BARANG`),
  CONSTRAINT `DKAT_BARANG_FK` FOREIGN KEY (`ID_BARANG`) REFERENCES `barang` (`ID_BARANG`),
  CONSTRAINT `DKAT_KATALOG_FK` FOREIGN KEY (`ID_KATALOG`) REFERENCES `katalog` (`ID_KATALOG`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `detail_katalog` */

insert  into `detail_katalog`(`ID_KATALOG`,`ID_BARANG`,`JMLH_BARANG`) values 
('100001','1001',5);

/*Table structure for table `detail_pemesanan` */

DROP TABLE IF EXISTS `detail_pemesanan`;

CREATE TABLE `detail_pemesanan` (
  `ID_PEMESANAN` char(8) NOT NULL,
  `ID_BARANG` char(4) NOT NULL,
  `SUB_TOTAL` float(8,2) DEFAULT NULL,
  `TOTAL_BERAT` float(8,2) DEFAULT NULL,
  PRIMARY KEY (`ID_PEMESANAN`,`ID_BARANG`),
  KEY `DPEMESANAN_BARANG_FK` (`ID_BARANG`),
  CONSTRAINT `DPEMESANAN_BARANG_FK` FOREIGN KEY (`ID_BARANG`) REFERENCES `barang` (`ID_BARANG`),
  CONSTRAINT `DPEMESANAN_PEMESANAN_FK` FOREIGN KEY (`ID_PEMESANAN`) REFERENCES `pemesanan` (`ID_PEMESANAN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `detail_pemesanan` */

insert  into `detail_pemesanan`(`ID_PEMESANAN`,`ID_BARANG`,`SUB_TOTAL`,`TOTAL_BERAT`) values 
('20062201','1001',50000.00,4.00);

/*Table structure for table `detail_penawaran` */

DROP TABLE IF EXISTS `detail_penawaran`;

CREATE TABLE `detail_penawaran` (
  `ID_DETAIL_PENAWARAN` int(11) NOT NULL,
  `ID_PENAWARAN` char(8) NOT NULL,
  `ID_CALON_KONSUMEN` char(8) NOT NULL,
  `STATUS_PENAWARAN` int(11) DEFAULT NULL,
  `BALASAN` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_DETAIL_PENAWARAN`),
  KEY `DPENAWARAN_CKONS_FK` (`ID_CALON_KONSUMEN`),
  KEY `DPENAWARAN_PENAWARAN_FK` (`ID_PENAWARAN`),
  CONSTRAINT `DPENAWARAN_CKONS_FK` FOREIGN KEY (`ID_CALON_KONSUMEN`) REFERENCES `calon_konsumen` (`ID_CALON_KONSUMEN`),
  CONSTRAINT `DPENAWARAN_PENAWARAN_FK` FOREIGN KEY (`ID_PENAWARAN`) REFERENCES `penawaran` (`ID_PENAWARAN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `detail_penawaran` */

insert  into `detail_penawaran`(`ID_DETAIL_PENAWARAN`,`ID_PENAWARAN`,`ID_CALON_KONSUMEN`,`STATUS_PENAWARAN`,`BALASAN`) values 
(1,'10000001','10010001',NULL,NULL),
(2,'10000001','10010001',NULL,NULL),
(3,'10000001','10010001',NULL,NULL),
(4,'10000001','10010002',NULL,NULL),
(5,'10000001','10010001',NULL,NULL),
(6,'10000001','10010001',NULL,NULL),
(7,'10000001','10010001',NULL,NULL),
(8,'10000001','10010001',NULL,NULL),
(9,'10000001','10010001',NULL,NULL),
(10,'10000001','10010001',NULL,NULL),
(11,'10000001','10010001',NULL,NULL),
(12,'10000001','10010002',NULL,NULL);

/*Table structure for table `jabatan` */

DROP TABLE IF EXISTS `jabatan`;

CREATE TABLE `jabatan` (
  `ID_JABATAN` char(2) NOT NULL,
  `NAMA_JABATAN` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID_JABATAN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `jabatan` */

insert  into `jabatan`(`ID_JABATAN`,`NAMA_JABATAN`) values 
('',NULL),
('11','Owner'),
('12','Restaurant Manager'),
('13','Headwaiter'),
('14','Assistant Headwaiter'),
('15','Wine Butler'),
('16','Captain'),
('17','Hostess'),
('18','Assistant Captain'),
('19','Waiter'),
('20','Busboy');

/*Table structure for table `jenis_barang` */

DROP TABLE IF EXISTS `jenis_barang`;

CREATE TABLE `jenis_barang` (
  `ID_JENIS` char(2) NOT NULL,
  `NAMA_JENIS` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID_JENIS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `jenis_barang` */

insert  into `jenis_barang`(`ID_JENIS`,`NAMA_JENIS`) values 
('11','Ikan');

/*Table structure for table `katalog` */

DROP TABLE IF EXISTS `katalog`;

CREATE TABLE `katalog` (
  `ID_KATALOG` char(6) NOT NULL,
  `NAMA_KATALOG` varchar(30) DEFAULT NULL,
  `FILE_KATALOG` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID_KATALOG`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `katalog` */

insert  into `katalog`(`ID_KATALOG`,`NAMA_KATALOG`,`FILE_KATALOG`) values 
('100001','katalog1',NULL);

/*Table structure for table `negara` */

DROP TABLE IF EXISTS `negara`;

CREATE TABLE `negara` (
  `ID_NEGARA` char(4) NOT NULL,
  `NAMA_NEGARA` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID_NEGARA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `negara` */

insert  into `negara`(`ID_NEGARA`,`NAMA_NEGARA`) values 
('1001','Indonesia'),
('1002','Malaysia'),
('1003','China'),
('1004','Korea'),
('1005','Amerika');

/*Table structure for table `pegawai` */

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `ID_PEGAWAI` char(4) NOT NULL,
  `ID_JABATAN` char(2) NOT NULL,
  `NAMA_PEGAWAI` varchar(30) DEFAULT NULL,
  `TELP_PEGAWAI` varchar(15) DEFAULT NULL,
  `EMAIL_PEGAWAI` varchar(50) DEFAULT NULL,
  `ALAMAT_PEGAWAI` varchar(50) DEFAULT NULL,
  `JK_PEGAWAI` tinyint(1) DEFAULT NULL,
  `PASS_PEGAWAI` varchar(20) NOT NULL,
  PRIMARY KEY (`ID_PEGAWAI`),
  UNIQUE KEY `PEGAWAI_TELP_PEG_UK` (`TELP_PEGAWAI`),
  UNIQUE KEY `PEGAWAI_EMAIL_PEG_UK` (`EMAIL_PEGAWAI`),
  KEY `PEG_JABATAN_FK` (`ID_JABATAN`),
  CONSTRAINT `PEG_JABATAN_FK` FOREIGN KEY (`ID_JABATAN`) REFERENCES `jabatan` (`ID_JABATAN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `pegawai` */

insert  into `pegawai`(`ID_PEGAWAI`,`ID_JABATAN`,`NAMA_PEGAWAI`,`TELP_PEGAWAI`,`EMAIL_PEGAWAI`,`ALAMAT_PEGAWAI`,`JK_PEGAWAI`,`PASS_PEGAWAI`) values 
('1001','12','Hilmi','082563125485','hilmi@gmail.com','Trenggalek',1,'admin');

/*Table structure for table `pembayaran` */

DROP TABLE IF EXISTS `pembayaran`;

CREATE TABLE `pembayaran` (
  `ID_PEMBAYARAN` char(8) NOT NULL,
  `ID_PEGAWAI` char(4) NOT NULL,
  `ID_PEMESANAN` char(8) NOT NULL,
  `TGL_PEMBAYARAN` date DEFAULT curdate(),
  `BUKTI_PEMBAYARAN` varchar(100) DEFAULT NULL,
  `JENIS_PEMBAYARAN` varchar(20) DEFAULT NULL,
  `STATUS_PEMBAYARAN` int(1) NOT NULL,
  `TOTAL_PEMBAYARAN` float(10,2) DEFAULT NULL,
  PRIMARY KEY (`ID_PEMBAYARAN`),
  KEY `PEMBAYARAN_PEGAWAI_FK` (`ID_PEGAWAI`),
  KEY `PEMBAYARAN_PEMESANAN_FK` (`ID_PEMESANAN`),
  CONSTRAINT `PEMBAYARAN_PEGAWAI_FK` FOREIGN KEY (`ID_PEGAWAI`) REFERENCES `pegawai` (`ID_PEGAWAI`),
  CONSTRAINT `PEMBAYARAN_PEMESANAN_FK` FOREIGN KEY (`ID_PEMESANAN`) REFERENCES `pemesanan` (`ID_PEMESANAN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `pembayaran` */

insert  into `pembayaran`(`ID_PEMBAYARAN`,`ID_PEGAWAI`,`ID_PEMESANAN`,`TGL_PEMBAYARAN`,`BUKTI_PEMBAYARAN`,`JENIS_PEMBAYARAN`,`STATUS_PEMBAYARAN`,`TOTAL_PEMBAYARAN`) values 
('20062201','1001','20062201','2022-06-20','62afe69b3bd3e.png','COD',3,50000.00);

/*Table structure for table `pemesanan` */

DROP TABLE IF EXISTS `pemesanan`;

CREATE TABLE `pemesanan` (
  `ID_PEMESANAN` char(8) NOT NULL,
  `ID_PEGAWAI` char(4) NOT NULL,
  `ID_CALON_KONSUMEN` char(8) NOT NULL,
  `TGL_PEMESANAN` date DEFAULT curdate(),
  `STATUS_PEMESANAN` char(2) DEFAULT NULL,
  `ALAMAT_PENGIRIMAN` varchar(100) DEFAULT NULL,
  `TOTAL_HARGA` float(8,2) DEFAULT NULL,
  PRIMARY KEY (`ID_PEMESANAN`),
  KEY `PEMESANAN_PEGAWAI_FK` (`ID_PEGAWAI`),
  KEY `PEMESANAN_CKONS_FK` (`ID_CALON_KONSUMEN`),
  CONSTRAINT `PEMESANAN_CKONS_FK` FOREIGN KEY (`ID_CALON_KONSUMEN`) REFERENCES `calon_konsumen` (`ID_CALON_KONSUMEN`),
  CONSTRAINT `PEMESANAN_PEGAWAI_FK` FOREIGN KEY (`ID_PEGAWAI`) REFERENCES `pegawai` (`ID_PEGAWAI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `pemesanan` */

insert  into `pemesanan`(`ID_PEMESANAN`,`ID_PEGAWAI`,`ID_CALON_KONSUMEN`,`TGL_PEMESANAN`,`STATUS_PEMESANAN`,`ALAMAT_PENGIRIMAN`,`TOTAL_HARGA`) values 
('20062201','1001','10010001','2022-06-20','05','Trenggalek',50000.00);

/*Table structure for table `penawaran` */

DROP TABLE IF EXISTS `penawaran`;

CREATE TABLE `penawaran` (
  `ID_PENAWARAN` char(8) NOT NULL,
  `ID_KATALOG` char(6) NOT NULL,
  `ID_PEGAWAI` char(4) NOT NULL,
  `TGL_PENAWARAN` date DEFAULT curdate(),
  PRIMARY KEY (`ID_PENAWARAN`),
  KEY `PENAWARAN_KATALOG_FK` (`ID_KATALOG`),
  KEY `PENAWARAN_PEGAWAI_FK` (`ID_PEGAWAI`),
  CONSTRAINT `PENAWARAN_KATALOG_FK` FOREIGN KEY (`ID_KATALOG`) REFERENCES `katalog` (`ID_KATALOG`),
  CONSTRAINT `PENAWARAN_PEGAWAI_FK` FOREIGN KEY (`ID_PEGAWAI`) REFERENCES `pegawai` (`ID_PEGAWAI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `penawaran` */

insert  into `penawaran`(`ID_PENAWARAN`,`ID_KATALOG`,`ID_PEGAWAI`,`TGL_PENAWARAN`) values 
('10000001','100001','1001','2022-06-06'),
('10000003','100001','1001','2022-06-15');

/*Table structure for table `pengiriman` */

DROP TABLE IF EXISTS `pengiriman`;

CREATE TABLE `pengiriman` (
  `NO_RESI` char(12) NOT NULL,
  `ID_PEGAWAI` char(4) DEFAULT NULL,
  `ID_PEMBAYARAN` char(8) DEFAULT NULL,
  `STATUS_PENGIRIMAN` tinyint(4) DEFAULT NULL,
  `TANGGAL_PENGIRIMAN` date DEFAULT NULL,
  PRIMARY KEY (`NO_RESI`),
  KEY `PENGIRIMAN_PEMBAYARAN_FK` (`ID_PEMBAYARAN`),
  KEY `PENGIRIMAN_PEGAWAI_FK` (`ID_PEGAWAI`),
  CONSTRAINT `PENGIRIMAN_PEGAWAI_FK` FOREIGN KEY (`ID_PEGAWAI`) REFERENCES `pegawai` (`ID_PEGAWAI`),
  CONSTRAINT `PENGIRIMAN_PEMBAYARAN_FK` FOREIGN KEY (`ID_PEMBAYARAN`) REFERENCES `pembayaran` (`ID_PEMBAYARAN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `pengiriman` */

insert  into `pengiriman`(`NO_RESI`,`ID_PEGAWAI`,`ID_PEMBAYARAN`,`STATUS_PENGIRIMAN`,`TANGGAL_PENGIRIMAN`) values 
('20062202','1001','20062201',2,'2022-06-20');

/*Table structure for table `sequence_calon_konsumen` */

DROP TABLE IF EXISTS `sequence_calon_konsumen`;

CREATE TABLE `sequence_calon_konsumen` (
  `idHitung` int(11) NOT NULL AUTO_INCREMENT,
  `negara` char(4) DEFAULT NULL,
  PRIMARY KEY (`idHitung`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `sequence_calon_konsumen` */

insert  into `sequence_calon_konsumen`(`idHitung`,`negara`) values 
(1,'1001'),
(2,'1001');

/*Table structure for table `sequence_pembayaran` */

DROP TABLE IF EXISTS `sequence_pembayaran`;

CREATE TABLE `sequence_pembayaran` (
  `idHitung` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`idHitung`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `sequence_pembayaran` */

insert  into `sequence_pembayaran`(`idHitung`,`tanggal`) values 
(5,'2022-06-06'),
(6,'2022-06-16'),
(7,'2022-06-16'),
(8,'2022-06-16'),
(9,'2022-06-16'),
(10,'2022-06-16'),
(11,'2022-06-16'),
(12,'2022-06-16'),
(13,'2022-06-16'),
(14,'2022-06-16'),
(15,'2022-06-16'),
(16,'2022-06-16'),
(17,'2022-06-16'),
(18,'2022-06-16'),
(19,'2022-06-20');

/*Table structure for table `sequence_pemesanan` */

DROP TABLE IF EXISTS `sequence_pemesanan`;

CREATE TABLE `sequence_pemesanan` (
  `idHitung` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`idHitung`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

/*Data for the table `sequence_pemesanan` */

insert  into `sequence_pemesanan`(`idHitung`,`tanggal`) values 
(6,'2022-06-06'),
(7,'2022-06-06'),
(8,'2022-06-07'),
(9,'2022-06-07'),
(10,'2022-06-16'),
(11,'2022-06-16'),
(12,'2022-06-16'),
(13,'2022-06-16'),
(14,'2022-06-16'),
(15,'2022-06-16'),
(16,'2022-06-16'),
(17,'2022-06-16'),
(18,'2022-06-16'),
(19,'2022-06-16'),
(20,'2022-06-16'),
(21,'2022-06-16'),
(23,'2022-06-19'),
(24,'2022-06-20');

/*Table structure for table `sequence_pengiriman` */

DROP TABLE IF EXISTS `sequence_pengiriman`;

CREATE TABLE `sequence_pengiriman` (
  `idHitung` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`idHitung`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `sequence_pengiriman` */

insert  into `sequence_pengiriman`(`idHitung`,`tanggal`) values 
(1,'2022-06-20'),
(2,'2022-06-20');

/* Trigger structure for table `calon_konsumen` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `id_calon_konsumen` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `id_calon_konsumen` BEFORE INSERT ON `calon_konsumen` FOR EACH ROW 
BEGIN 
	DECLARE id INT; 
	INSERT INTO sequence_calon_konsumen (negara) VALUES (NEW.id_negara);
	SELECT count(*) INTO id FROM sequence_calon_konsumen
	where negara = NEW.id_negara;
	SET NEW.id_calon_konsumen = CONCAT(NEW.id_negara, LPAD(id,4,'0')); 
END */$$


DELIMITER ;

/* Trigger structure for table `detail_penawaran` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tgl_penawaran_terakhir` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tgl_penawaran_terakhir` AFTER INSERT ON `detail_penawaran` FOR EACH ROW 
BEGIN 
	DECLARE tanggal date;
	SELECT tgl_penawaran INTO tanggal FROM penawaran
	where penawaran.id_penawaran = NEW.id_penawaran;
	UPDATE calon_konsumen
	SET tgl_penawaran_terakhir = tanggal
	WHERE id_calon_konsumen = NEW.id_calon_konsumen;	
END */$$


DELIMITER ;

/* Trigger structure for table `pembayaran` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `id_pembayaran` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `id_pembayaran` BEFORE INSERT ON `pembayaran` FOR EACH ROW 
BEGIN 
	DECLARE id INT;
	INSERT INTO sequence_pembayaran (tanggal) VALUES (CURDATE()); 
	SELECT COUNT(*) INTO id FROM sequence_pembayaran
	WHERE tanggal = CURDATE();
	SET NEW.id_pembayaran = CONCAT(DATE_FORMAT(CURDATE(), '%d%m%y'), LPAD(id,2,'0')); 
END */$$


DELIMITER ;

/* Trigger structure for table `pemesanan` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `id_pemesanan` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `id_pemesanan` BEFORE INSERT ON `pemesanan` FOR EACH ROW 
BEGIN 
	DECLARE id INT;
	INSERT INTO sequence_pemesanan (tanggal) VALUES (curdate()); 
	SELECT count(*) INTO id FROM sequence_pemesanan
	WHERE tanggal = CURDATE();
	SET NEW.id_pemesanan = CONCAT(DATE_FORMAT(CURDATE(), '%d%m%y'), LPAD(id,2,'0')); 
END */$$


DELIMITER ;

/* Trigger structure for table `pengiriman` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `no_resi` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `no_resi` BEFORE INSERT ON `pengiriman` FOR EACH ROW 
BEGIN 
	DECLARE id INT;
	INSERT INTO sequence_pengiriman (tanggal) VALUES (CURDATE()); 
	SELECT COUNT(*) INTO id FROM sequence_pengiriman
	WHERE tanggal = CURDATE();
	SET NEW.no_resi = CONCAT(DATE_FORMAT(CURDATE(), '%d%m%y'), LPAD(id,2,'0')); 
END */$$


DELIMITER ;

/* Function  structure for function  `nama` */

/*!50003 DROP FUNCTION IF EXISTS `nama` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `nama`(email VARCHAR(100)) RETURNS varchar(50) CHARSET utf8mb4
BEGIN
	DECLARE nama varchar(50);
	SELECT nama_calon_konsumen INTO nama FROM calon_konsumen WHERE email_calon_konsumen = email;
	RETURN nama;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getBarangPenawaran` */

/*!50003 DROP PROCEDURE IF EXISTS  `getBarangPenawaran` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getBarangPenawaran`(email VARCHAR(100))
BEGIN 
	DECLARE tanggal DATE;
	declare idPenawaran char(8);
	DECLARE idKatalog CHAR(6);
	SELECT tgl_penawaran_terakhir INTO tanggal FROM calon_konsumen WHERE email_calon_konsumen = email;
	SELECT id_penawaran into idPenawaran FROM penawaran WHERE tgl_penawaran = tanggal;
	SELECT id_katalog INTO idKatalog FROM penawaran WHERE id_penawaran = idPenawaran;
	SELECT id_barang FROM detail_katalog WHERE id_katalog = idKatalog;
END */$$
DELIMITER ;

/*Table structure for table `barangtoko` */

DROP TABLE IF EXISTS `barangtoko`;

/*!50001 DROP VIEW IF EXISTS `barangtoko` */;
/*!50001 DROP TABLE IF EXISTS `barangtoko` */;

/*!50001 CREATE TABLE  `barangtoko`(
 `id_barang` char(4) ,
 `nama_barang` varchar(30) ,
 `harga_jual` float(8,2) 
)*/;

/*View structure for view barangtoko */

/*!50001 DROP TABLE IF EXISTS `barangtoko` */;
/*!50001 DROP VIEW IF EXISTS `barangtoko` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `barangtoko` AS select `barang`.`ID_BARANG` AS `id_barang`,`barang`.`NAMA_BARANG` AS `nama_barang`,`barang`.`HARGA_JUAL` AS `harga_jual` from `barang` */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
