-- MySQL dump 10.16  Distrib 10.1.10-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: notaris
-- ------------------------------------------------------
-- Server version	10.1.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `data_berkas`
--

DROP TABLE IF EXISTS `data_berkas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_berkas` (
  `id_data_berkas` int(11) NOT NULL AUTO_INCREMENT,
  `no_client` varchar(255) DEFAULT NULL,
  `no_pekerjaan` varchar(255) DEFAULT NULL,
  `no_nama_dokumen` varchar(255) DEFAULT NULL,
  `pemberi_pekerjaan` varchar(255) NOT NULL,
  `nama_folder` varchar(255) DEFAULT NULL,
  `nama_berkas` varchar(255) DEFAULT NULL,
  `nama_file` varchar(255) NOT NULL,
  `status_berkas` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `status_lihat` varchar(255) DEFAULT NULL,
  `pengupload` varchar(255) DEFAULT NULL,
  `pengurus_perizinan` varchar(255) DEFAULT NULL,
  `no_pengurus` varchar(255) DEFAULT NULL,
  `tanggal_tugas` varchar(255) DEFAULT NULL,
  `tanggal_proses_tugas` varchar(255) DEFAULT NULL,
  `target_kelar_perizinan` varchar(255) DEFAULT NULL,
  `tanggal_upload` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_data_berkas`),
  KEY `nama_berkas` (`nama_berkas`),
  KEY `no_client` (`no_client`),
  KEY `no_pekerjaan` (`no_pekerjaan`),
  KEY `no_nama_dokumen` (`no_nama_dokumen`),
  CONSTRAINT `data_berkas_ibfk_1` FOREIGN KEY (`no_client`) REFERENCES `data_client` (`no_client`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_berkas`
--

LOCK TABLES `data_berkas` WRITE;
/*!40000 ALTER TABLE `data_berkas` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_berkas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_buku_absen`
--

DROP TABLE IF EXISTS `data_buku_absen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_buku_absen` (
  `id_data_buku_absen` int(11) NOT NULL AUTO_INCREMENT,
  `tugas` text NOT NULL,
  `nama_karyawan` varchar(255) NOT NULL,
  `jam_datang` varchar(255) NOT NULL,
  `jam_pulang` varchar(255) NOT NULL,
  `penginput` varchar(255) NOT NULL,
  `no_user_penginput` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_buku_absen`),
  KEY `no_user_penginput` (`no_user_penginput`),
  CONSTRAINT `data_buku_absen_ibfk_1` FOREIGN KEY (`no_user_penginput`) REFERENCES `user` (`no_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_buku_absen`
--

LOCK TABLES `data_buku_absen` WRITE;
/*!40000 ALTER TABLE `data_buku_absen` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_buku_absen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_buku_tamu`
--

DROP TABLE IF EXISTS `data_buku_tamu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_buku_tamu` (
  `id_data_buku_tamu` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` varchar(255) NOT NULL,
  `penginput` varchar(255) NOT NULL,
  `no_user_penginput` varchar(255) NOT NULL,
  `keperluan_dengan` varchar(255) NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `nama_klien` varchar(255) NOT NULL,
  `alasan_keperluan` text NOT NULL,
  PRIMARY KEY (`id_data_buku_tamu`),
  KEY `no_user_penginput` (`no_user_penginput`),
  CONSTRAINT `data_buku_tamu_ibfk_1` FOREIGN KEY (`no_user_penginput`) REFERENCES `user` (`no_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_buku_tamu`
--

LOCK TABLES `data_buku_tamu` WRITE;
/*!40000 ALTER TABLE `data_buku_tamu` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_buku_tamu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_client`
--

DROP TABLE IF EXISTS `data_client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_client` (
  `id_data_client` int(11) NOT NULL AUTO_INCREMENT,
  `no_client` varchar(255) NOT NULL,
  `nama_client` varchar(255) NOT NULL,
  `jenis_client` varchar(255) NOT NULL,
  `alamat_client` varchar(255) NOT NULL,
  `tanggal_daftar` varchar(255) NOT NULL,
  `pembuat_client` varchar(255) NOT NULL,
  `no_user` varchar(255) NOT NULL,
  `nama_folder` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_client`),
  KEY `no_client` (`no_client`),
  KEY `no_user` (`no_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_client`
--

LOCK TABLES `data_client` WRITE;
/*!40000 ALTER TABLE `data_client` DISABLE KEYS */;
INSERT INTO `data_client` VALUES (7,'C000001','PT JAYA ABADI','Badan Hukum','JL.Muara Karang Blok L9 T No.8 Penjaringan Jakarta Utara','2019/07/23 16:23:51','Admin','0001','DokC000001','Bapak Saipudin','081289903664');
/*!40000 ALTER TABLE `data_client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_dokumen_utama`
--

DROP TABLE IF EXISTS `data_dokumen_utama`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_dokumen_utama` (
  `id_data_dokumen_utama` int(11) NOT NULL AUTO_INCREMENT,
  `nama_berkas` varchar(255) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `nama_folder` varchar(255) NOT NULL,
  `no_pekerjaan` varchar(255) NOT NULL,
  `waktu` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_dokumen_utama`),
  KEY `no_pekerjaan` (`no_pekerjaan`),
  CONSTRAINT `data_dokumen_utama_ibfk_1` FOREIGN KEY (`no_pekerjaan`) REFERENCES `data_pekerjaan` (`no_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_dokumen_utama`
--

LOCK TABLES `data_dokumen_utama` WRITE;
/*!40000 ALTER TABLE `data_dokumen_utama` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_dokumen_utama` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_histori_pekerjaan`
--

DROP TABLE IF EXISTS `data_histori_pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_histori_pekerjaan` (
  `id_data_histori_pekerjaan` int(11) NOT NULL AUTO_INCREMENT,
  `no_user` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_histori_pekerjaan`),
  KEY `no_user` (`no_user`),
  CONSTRAINT `data_histori_pekerjaan_ibfk_1` FOREIGN KEY (`no_user`) REFERENCES `user` (`no_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_histori_pekerjaan`
--

LOCK TABLES `data_histori_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_histori_pekerjaan` DISABLE KEYS */;
INSERT INTO `data_histori_pekerjaan` VALUES (2,'0001','Admin Membuat client asd dan pekerjaan ','2019/07/23 16:18:17'),(3,'0001','Admin Membuat client PT Jaya Abadi','2019/07/23 16:19:30'),(4,'0001','Admin Membuat client PT Jaya Abadi','2019/07/23 16:23:51');
/*!40000 ALTER TABLE `data_histori_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_informasi_pekerjaan`
--

DROP TABLE IF EXISTS `data_informasi_pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_informasi_pekerjaan` (
  `id_data_informasi_pekerjaan` int(11) NOT NULL AUTO_INCREMENT,
  `no_pekerjaan` varchar(255) NOT NULL,
  `nama_informasi` varchar(255) NOT NULL,
  `data_informasi` text NOT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `nama_folder` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_data_informasi_pekerjaan`),
  KEY `no_pekerjaan` (`no_pekerjaan`),
  CONSTRAINT `data_informasi_pekerjaan_ibfk_1` FOREIGN KEY (`no_pekerjaan`) REFERENCES `data_pekerjaan` (`no_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_informasi_pekerjaan`
--

LOCK TABLES `data_informasi_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_informasi_pekerjaan` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_informasi_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_jenis_pekerjaan`
--

DROP TABLE IF EXISTS `data_jenis_pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_jenis_pekerjaan` (
  `id_jenis_pekerjaan` int(11) NOT NULL AUTO_INCREMENT,
  `no_jenis_pekerjaan` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `nama_jenis` varchar(255) NOT NULL,
  `tanggal_dibuat` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `pembuat_jenis` varchar(255) NOT NULL,
  PRIMARY KEY (`id_jenis_pekerjaan`),
  KEY `no_jenis_dokumen` (`no_jenis_pekerjaan`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_jenis_pekerjaan`
--

LOCK TABLES `data_jenis_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_jenis_pekerjaan` DISABLE KEYS */;
INSERT INTO `data_jenis_pekerjaan` VALUES (1,'J_0001','NOTARIS','Akta pendirian Perseroan Terbatas ( PT )','2019-05-09 02:28:49.878210','Admin'),(2,'J_0002','NOTARIS','Akta perubahan perseroan terbatas ( PT )','2019-03-05 06:29:24.100515','Dedy Ibrahim'),(3,'J_0003','NOTARIS','Akta pendirian CV','2019-03-05 06:30:13.576017','Dedy Ibrahim'),(4,'J_0004','NOTARIS','Akta perubahan CV','2019-03-05 06:30:31.712436','Dedy Ibrahim'),(5,'J_0005','NOTARIS','Akta pendirian Firma','2019-03-05 06:31:49.696745','Dedy Ibrahim'),(6,'J_0006','NOTARIS','Akta perubahan Firma','2019-03-05 06:32:10.476590','Dedy Ibrahim'),(7,'J_0007','NOTARIS','Akta pendirian Koperasi','2019-03-05 06:33:01.350481','Dedy Ibrahim'),(8,'J_0008','NOTARIS','Akta perubahan Koperasi','2019-03-05 06:33:23.456080','Dedy Ibrahim'),(9,'J_0009','NOTARIS','Akta pendirian Yayasan','2019-03-05 06:37:31.682419','Dedy Ibrahim'),(10,'J_0010','NOTARIS','Akta perubahan Yayasan','2019-03-05 06:37:55.661141','Dedy Ibrahim'),(11,'J_0011','NOTARIS','Akta pendirian Perkumpulan','2019-03-05 06:38:39.618898','Dedy Ibrahim'),(12,'J_0012','NOTARIS','Akta perubahan Perkumpulan','2019-03-05 06:39:10.083953','Dedy Ibrahim'),(13,'J_0013','NOTARIS','Akta Pengakuan Hutang','2019-05-10 08:00:30.135319','Admin'),(14,'J_0014','NOTARIS','Akta Perjanjian Kawin','2019-05-10 08:00:07.451262','Admin'),(15,'J_0015','NOTARIS','Akta Perjanjian Pengikatan Jual Beli','2019-05-10 07:59:55.616911','Admin'),(16,'J_0016','NOTARIS','Akta Perjanjian Sewa Menyewa','2019-05-10 07:59:34.878470','Admin'),(17,'J_0017','NOTARIS','Akta Perjanjian Kerjasama','2019-05-10 07:59:16.773705','Admin'),(18,'J_0018','NOTARIS','Akta Perjanjian Kredit','2019-05-10 07:59:02.510424','Admin'),(20,'J_0019','NOTARIS','Akta Jual Beli Saham','2019-05-10 08:01:41.496718','Admin'),(21,'J_0020','NOTARIS','Akta Wasiat','2019-03-05 06:46:23.085321','Dedy Ibrahim'),(22,'J_0021','NOTARIS','Akta Corporate Guarantee','2019-05-10 08:03:50.450134','Admin'),(23,'J_0022','NOTARIS','Akta Personal Guarantee','2019-05-10 07:58:05.157704','Admin'),(24,'J_0023','NOTARIS','Akta Fidusia','2019-03-05 06:50:46.733389','Dedy Ibrahim'),(25,'J_0024','NOTARIS','Akta Hibah','2019-05-10 08:03:24.625917','Admin'),(27,'J_0025','NOTARIS','Akta Kuasa Untuk Menjual','2019-05-10 08:04:14.961903','Admin'),(28,'J_0026','NOTARIS','Waarmerking Dokumen','2019-05-10 07:57:25.277177','Admin'),(29,'J_0027','NOTARIS','Legalisasi Dokumen','2019-05-10 07:39:37.393049','Admin'),(30,'J_0028','PPAT','Akta Jual Beli (AJB)','2019-05-10 07:37:43.689411','Admin'),(31,'J_0029','PPAT','Akta Hibah','2019-05-10 07:37:22.904901','Admin'),(32,'J_0030','PPAT','Akta Tukar Menukar','2019-05-10 07:37:06.312726','Admin'),(33,'J_0031','PPAT','Akta Pembagian Hak Bersama (APHB)','2019-05-10 07:36:30.910911','Admin'),(34,'J_0032','NOTARIS','Akta Surat Kuasa Memberikan Hak Tanggungan (SKMHT)','2019-05-10 07:35:05.180965','Admin'),(35,'J_0033','PPAT','Akta Pemberian Hak Tanggungan (APHT)','2019-05-15 05:56:54.040414','Admin'),(36,'J_0034','NOTARIS','Akta Pernyataan (WARIS)','2019-05-10 08:45:35.985455','Admin'),(37,'J_0035','NOTARIS','Akta Pendirian PT PMA','2019-07-23 13:44:13.825399','Admin');
/*!40000 ALTER TABLE `data_jenis_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_meta`
--

DROP TABLE IF EXISTS `data_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_meta` (
  `id_data_meta` int(11) NOT NULL AUTO_INCREMENT,
  `no_nama_dokumen` varchar(255) NOT NULL,
  `nama_meta` varchar(25) NOT NULL,
  PRIMARY KEY (`id_data_meta`),
  KEY `no_nama_dokumen` (`no_nama_dokumen`),
  CONSTRAINT `data_meta_ibfk_1` FOREIGN KEY (`no_nama_dokumen`) REFERENCES `nama_dokumen` (`no_nama_dokumen`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_meta`
--

LOCK TABLES `data_meta` WRITE;
/*!40000 ALTER TABLE `data_meta` DISABLE KEYS */;
INSERT INTO `data_meta` VALUES (43,'N_0004','No TDP'),(45,'N_0002','No NPWP'),(46,'N_0001','No SIUP'),(47,'N_0009','Keterangan'),(48,'N_0008','Keterangan'),(49,'N_0007','Keterangan'),(51,'N_0006','Nama KTP'),(52,'N_0006','NIK'),(54,'N_0054','Nama bukti kepemilikan'),(55,'N_0053','Nama bukti setor'),(58,'N_0050','Pernyataan modal dan domi'),(59,'N_0048','Nama PT/Yay/Perkumpulan/C'),(60,'N_0048','Nama kekayaan yayasan/per'),(62,'N_0046','Nama berita acara rapat'),(70,'N_0014','Informasi'),(71,'N_0043','Informasi'),(72,'N_0039','Informasi'),(73,'N_0052','Surat pernyataan'),(74,'N_0051','Surat pernyataan'),(75,'N_0047','Surat BAR'),(76,'N_0046','Surat BAR'),(77,'N_0045','Informasi'),(78,'N_0044','Informasi'),(79,'N_0042','Informasi'),(80,'N_0041','Informasi'),(81,'N_0040','Informasi'),(82,'N_0038','Informasi'),(83,'N_0035','Informasi'),(84,'N_0034','Dokumen obyek wasiat'),(85,'N_0033','Dokumen obyek hibah'),(86,'N_0032','Dokumen lain'),(87,'N_0031','Surat ganti nama WNI'),(88,'N_0030','Izin lainnya'),(89,'N_0029','NIB'),(90,'N_0028','Surat keterangan waris'),(91,'N_0027','Akta Kematian'),(92,'N_0026','Dokumen Warmeking'),(93,'N_0025','Surat BAR Anggota'),(94,'N_0024','Fotocopy Deposito'),(95,'N_0023','Surat daftar hadir rapat'),(96,'N_0022','Nomor Induk Koperasi (NIK'),(97,'N_0021','Surat BAR '),(98,'N_0020','Nama passpor'),(99,'N_0020','No Passpor'),(100,'N_0019','Surat Akta kelahiran'),(101,'N_0018','Surat IMB'),(102,'N_0017','SPPT PBB'),(103,'N_0016','Surat persetujuan pasanga'),(104,'N_0015','Surat pernyataan dan lamp'),(105,'N_0013','Surat persetujuan dewan k'),(106,'N_0012','Buku Nikah'),(107,'N_0011','Sertifikat tanah'),(108,'N_0010','Nama KK'),(109,'N_0010','No KK'),(110,'N_0009','Anggara Dasar'),(111,'N_0008','Surat Persetujuan'),(112,'N_0007','Surat BKPM'),(113,'N_0005','Surat Domisili'),(114,'N_0003','Asli Dokumen legalisasi'),(115,'N_0055','Keterangan');
/*!40000 ALTER TABLE `data_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_meta_berkas`
--

DROP TABLE IF EXISTS `data_meta_berkas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_meta_berkas` (
  `id_data_meta_berkas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_berkas` varchar(255) NOT NULL,
  `no_client` varchar(255) NOT NULL,
  `no_pekerjaan` varchar(255) NOT NULL,
  `no_nama_dokumen` varchar(255) NOT NULL,
  `nama_meta` varchar(255) NOT NULL,
  `value_meta` varchar(255) NOT NULL,
  `nama_folder` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_meta_berkas`),
  KEY `nama_berkas` (`nama_berkas`),
  CONSTRAINT `data_meta_berkas_ibfk_1` FOREIGN KEY (`nama_berkas`) REFERENCES `data_berkas` (`nama_berkas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_meta_berkas`
--

LOCK TABLES `data_meta_berkas` WRITE;
/*!40000 ALTER TABLE `data_meta_berkas` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_meta_berkas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_notaris_rekanan`
--

DROP TABLE IF EXISTS `data_notaris_rekanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_notaris_rekanan` (
  `id_notaris_rekanan` int(11) NOT NULL AUTO_INCREMENT,
  `no_telpon` varchar(255) NOT NULL,
  `nama_notaris` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `penginput` varchar(255) NOT NULL,
  `no_user_penginput` varchar(255) NOT NULL,
  `tanggal_input` varchar(255) NOT NULL,
  PRIMARY KEY (`id_notaris_rekanan`),
  KEY `no_user_penginput` (`no_user_penginput`),
  CONSTRAINT `data_notaris_rekanan_ibfk_1` FOREIGN KEY (`no_user_penginput`) REFERENCES `user` (`no_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_notaris_rekanan`
--

LOCK TABLES `data_notaris_rekanan` WRITE;
/*!40000 ALTER TABLE `data_notaris_rekanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_notaris_rekanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_pekerjaan`
--

DROP TABLE IF EXISTS `data_pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_pekerjaan` (
  `id_data_pekerjaan` int(11) NOT NULL AUTO_INCREMENT,
  `no_client` varchar(255) NOT NULL,
  `no_pekerjaan` varchar(255) NOT NULL,
  `no_jenis_pekerjaan` varchar(255) NOT NULL,
  `no_user` varchar(255) NOT NULL,
  `status_pekerjaan` varchar(255) NOT NULL,
  `tanggal_dibuat` varchar(255) NOT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `pembuat_pekerjaan` varchar(255) NOT NULL,
  `tanggal_proses` varchar(255) NOT NULL,
  `target_kelar` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_pekerjaan`),
  KEY `no_client` (`no_client`),
  KEY `no_pekerjaan` (`no_pekerjaan`),
  KEY `no_persyaratan` (`no_jenis_pekerjaan`),
  CONSTRAINT `data_pekerjaan_ibfk_1` FOREIGN KEY (`no_client`) REFERENCES `data_client` (`no_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `data_pekerjaan_ibfk_2` FOREIGN KEY (`no_jenis_pekerjaan`) REFERENCES `data_jenis_pekerjaan` (`no_jenis_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_pekerjaan`
--

LOCK TABLES `data_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_pekerjaan` DISABLE KEYS */;
INSERT INTO `data_pekerjaan` VALUES (95,'C000001','P000001','J_0001','0001','Masuk','2019/07/23',NULL,'Admin','','2019/07/31');
/*!40000 ALTER TABLE `data_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_perizinan`
--

DROP TABLE IF EXISTS `data_perizinan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_perizinan` (
  `no_perizinan` char(255) NOT NULL,
  `no_pekerjaan` varchar(255) NOT NULL,
  `no_nama_dokumen` varchar(255) NOT NULL,
  PRIMARY KEY (`no_perizinan`),
  KEY `no_pekerjaan` (`no_pekerjaan`),
  CONSTRAINT `data_perizinan_ibfk_1` FOREIGN KEY (`no_pekerjaan`) REFERENCES `data_pekerjaan` (`no_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_perizinan`
--

LOCK TABLES `data_perizinan` WRITE;
/*!40000 ALTER TABLE `data_perizinan` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_perizinan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_persyaratan`
--

DROP TABLE IF EXISTS `data_persyaratan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_persyaratan` (
  `id_data_persyaratan` int(11) NOT NULL AUTO_INCREMENT,
  `no_nama_dokumen` varchar(255) NOT NULL,
  `no_jenis_pekerjaan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_persyaratan`),
  KEY `no_jenis_dokumen` (`no_jenis_pekerjaan`),
  KEY `no_nama_dokumen` (`no_nama_dokumen`),
  CONSTRAINT `data_persyaratan_ibfk_1` FOREIGN KEY (`no_jenis_pekerjaan`) REFERENCES `data_jenis_pekerjaan` (`no_jenis_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `data_persyaratan_ibfk_2` FOREIGN KEY (`no_nama_dokumen`) REFERENCES `nama_dokumen` (`no_nama_dokumen`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=342 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_persyaratan`
--

LOCK TABLES `data_persyaratan` WRITE;
/*!40000 ALTER TABLE `data_persyaratan` DISABLE KEYS */;
INSERT INTO `data_persyaratan` VALUES (7,'N_0003','J_0027'),(8,'N_0006','J_0027'),(9,'N_0032','J_0027'),(10,'N_0026','J_0026'),(11,'N_0006','J_0026'),(12,'N_0032','J_0026'),(26,'N_0006','J_0025'),(27,'N_0016','J_0025'),(28,'N_0010','J_0025'),(29,'N_0002','J_0025'),(33,'N_0011','J_0025'),(34,'N_0017','J_0025'),(35,'N_0018','J_0025'),(39,'N_0011','J_0032'),(40,'N_0017','J_0032'),(41,'N_0018','J_0032'),(42,'N_0006','J_0032'),(43,'N_0016','J_0032'),(46,'N_0002','J_0032'),(47,'N_0010','J_0032'),(48,'N_0009','J_0032'),(49,'N_0005','J_0032'),(50,'N_0029','J_0032'),(52,'N_0008','J_0032'),(53,'N_0013','J_0032'),(54,'N_0030','J_0032'),(55,'N_0009','J_0025'),(56,'N_0005','J_0025'),(57,'N_0029','J_0025'),(58,'N_0008','J_0025'),(59,'N_0013','J_0025'),(60,'N_0030','J_0025'),(61,'N_0006','J_0024'),(62,'N_0010','J_0024'),(63,'N_0016','J_0024'),(64,'N_0012','J_0024'),(65,'N_0012','J_0025'),(66,'N_0012','J_0032'),(68,'N_0027','J_0034'),(69,'N_0012','J_0034'),(70,'N_0019','J_0034'),(71,'N_0010','J_0034'),(73,'N_0033','J_0024'),(74,'N_0006','J_0021'),(75,'N_0031','J_0034'),(76,'N_0006','J_0023'),(77,'N_0009','J_0023'),(78,'N_0005','J_0023'),(79,'N_0015','J_0023'),(80,'N_0032','J_0023'),(81,'N_0020','J_0023'),(82,'N_0001','J_0023'),(83,'N_0004','J_0023'),(84,'N_0002','J_0023'),(85,'N_0006','J_0022'),(86,'N_0010','J_0022'),(87,'N_0012','J_0022'),(88,'N_0016','J_0022'),(89,'N_0020','J_0022'),(90,'N_0013','J_0023'),(91,'N_0008','J_0023'),(92,'N_0008','J_0022'),(93,'N_0009','J_0022'),(94,'N_0001','J_0021'),(95,'N_0005','J_0021'),(96,'N_0009','J_0021'),(97,'N_0008','J_0021'),(98,'N_0013','J_0021'),(99,'N_0020','J_0021'),(101,'N_0006','J_0018'),(102,'N_0020','J_0018'),(103,'N_0009','J_0018'),(104,'N_0008','J_0018'),(105,'N_0013','J_0018'),(107,'N_0005','J_0018'),(110,'N_0018','J_0018'),(111,'N_0035','J_0018'),(112,'N_0029','J_0021'),(113,'N_0006','J_0020'),(114,'N_0019','J_0020'),(115,'N_0027','J_0020'),(116,'N_0010','J_0020'),(117,'N_0034','J_0020'),(118,'N_0006','J_0019'),(119,'N_0010','J_0019'),(120,'N_0016','J_0019'),(121,'N_0012','J_0019'),(122,'N_0009','J_0019'),(123,'N_0029','J_0019'),(124,'N_0030','J_0019'),(125,'N_0008','J_0019'),(126,'N_0013','J_0019'),(127,'N_0006','J_0016'),(128,'N_0010','J_0016'),(129,'N_0016','J_0016'),(130,'N_0012','J_0016'),(131,'N_0011','J_0016'),(132,'N_0017','J_0016'),(133,'N_0018','J_0016'),(134,'N_0009','J_0016'),(135,'N_0029','J_0016'),(136,'N_0030','J_0016'),(137,'N_0006','J_0015'),(138,'N_0010','J_0015'),(139,'N_0016','J_0015'),(140,'N_0012','J_0015'),(141,'N_0011','J_0015'),(142,'N_0017','J_0015'),(143,'N_0018','J_0015'),(144,'N_0009','J_0015'),(145,'N_0029','J_0015'),(146,'N_0030','J_0015'),(147,'N_0008','J_0015'),(148,'N_0013','J_0015'),(149,'N_0008','J_0016'),(150,'N_0013','J_0016'),(151,'N_0006','J_0017'),(152,'N_0010','J_0017'),(153,'N_0016','J_0017'),(154,'N_0012','J_0017'),(155,'N_0009','J_0017'),(156,'N_0029','J_0017'),(157,'N_0030','J_0017'),(158,'N_0008','J_0017'),(159,'N_0013','J_0017'),(160,'N_0036','J_0017'),(161,'N_0006','J_0014'),(162,'N_0020','J_0014'),(163,'N_0010','J_0013'),(165,'N_0016','J_0013'),(166,'N_0009','J_0013'),(167,'N_0029','J_0013'),(168,'N_0030','J_0013'),(169,'N_0008','J_0013'),(170,'N_0013','J_0013'),(172,'N_0006','J_0013'),(173,'N_0012','J_0013'),(174,'N_0006','J_0012'),(178,'N_0009','J_0012'),(179,'N_0005','J_0012'),(180,'N_0002','J_0012'),(182,'N_0046','J_0012'),(183,'N_0030','J_0012'),(184,'N_0006','J_0011'),(186,'N_0045','J_0011'),(187,'N_0049','J_0011'),(188,'N_0048','J_0011'),(189,'N_0037','J_0011'),(190,'N_0039','J_0011'),(191,'N_0006','J_0010'),(192,'N_0002','J_0010'),(193,'N_0009','J_0010'),(194,'N_0005','J_0010'),(195,'N_0030','J_0010'),(196,'N_0047','J_0010'),(197,'N_0006','J_0009'),(198,'N_0049','J_0009'),(200,'N_0038','J_0012'),(201,'N_0038','J_0011'),(202,'N_0038','J_0010'),(203,'N_0037','J_0009'),(204,'N_0048','J_0009'),(205,'N_0039','J_0009'),(206,'N_0038','J_0009'),(207,'N_0042','J_0009'),(208,'N_0006','J_0008'),(209,'N_0002','J_0008'),(210,'N_0009','J_0008'),(211,'N_0030','J_0008'),(212,'N_0025','J_0008'),(213,'N_0038','J_0008'),(214,'N_0006','J_0007'),(215,'N_0002','J_0007'),(216,'N_0049','J_0007'),(217,'N_0037','J_0007'),(218,'N_0048','J_0007'),(219,'N_0039','J_0007'),(220,'N_0041','J_0007'),(222,'N_0038','J_0007'),(223,'N_0021','J_0007'),(224,'N_0021','J_0011'),(225,'N_0006','J_0006'),(226,'N_0002','J_0006'),(227,'N_0009','J_0006'),(228,'N_0005','J_0006'),(229,'N_0001','J_0006'),(230,'N_0004','J_0006'),(231,'N_0014','J_0006'),(232,'N_0006','J_0005'),(233,'N_0049','J_0005'),(234,'N_0014','J_0005'),(235,'N_0037','J_0005'),(236,'N_0039','J_0005'),(237,'N_0040','J_0005'),(238,'N_0043','J_0005'),(239,'N_0006','J_0004'),(240,'N_0002','J_0004'),(241,'N_0009','J_0004'),(242,'N_0005','J_0004'),(243,'N_0001','J_0004'),(244,'N_0004','J_0004'),(245,'N_0014','J_0004'),(246,'N_0006','J_0003'),(247,'N_0049','J_0003'),(248,'N_0037','J_0003'),(249,'N_0043','J_0003'),(250,'N_0044','J_0003'),(251,'N_0050','J_0011'),(252,'N_0052','J_0011'),(253,'N_0050','J_0009'),(254,'N_0051','J_0012'),(255,'N_0051','J_0010'),(256,'N_0050','J_0007'),(257,'N_0014','J_0003'),(258,'N_0022','J_0008'),(259,'N_0006','J_0002'),(260,'N_0002','J_0002'),(261,'N_0009','J_0002'),(262,'N_0029','J_0002'),(263,'N_0030','J_0002'),(264,'N_0008','J_0002'),(265,'N_0014','J_0002'),(266,'N_0053','J_0002'),(267,'N_0006','J_0001'),(268,'N_0002','J_0001'),(269,'N_0049','J_0001'),(270,'N_0037','J_0001'),(271,'N_0043','J_0001'),(272,'N_0040','J_0001'),(273,'N_0014','J_0001'),(274,'N_0050','J_0001'),(275,'N_0039','J_0001'),(276,'N_0039','J_0003'),(277,'N_0005','J_0022'),(278,'N_0002','J_0022'),(279,'N_0004','J_0022'),(280,'N_0029','J_0022'),(281,'N_0029','J_0018'),(282,'N_0054','J_0018'),(284,'N_0020','J_0035'),(285,'N_0049','J_0035'),(286,'N_0037','J_0035'),(287,'N_0039','J_0035'),(288,'N_0043','J_0035'),(289,'N_0040','J_0035'),(290,'N_0014','J_0035'),(291,'N_0050','J_0035'),(292,'N_0009','J_0035'),(293,'N_0030','J_0035'),(294,'N_0007','J_0035'),(295,'N_0006','J_0030'),(296,'N_0010','J_0030'),(297,'N_0016','J_0030'),(298,'N_0012','J_0030'),(299,'N_0011','J_0030'),(300,'N_0017','J_0030'),(301,'N_0018','J_0030'),(302,'N_0002','J_0030'),(303,'N_0006','J_0029'),(304,'N_0010','J_0029'),(305,'N_0019','J_0029'),(307,'N_0002','J_0029'),(308,'N_0012','J_0029'),(309,'N_0011','J_0029'),(310,'N_0017','J_0029'),(311,'N_0018','J_0029'),(313,'N_0055','J_0029'),(314,'N_0006','J_0028'),(315,'N_0010','J_0028'),(316,'N_0002','J_0028'),(317,'N_0017','J_0028'),(318,'N_0018','J_0028'),(319,'N_0012','J_0028'),(320,'N_0011','J_0028'),(321,'N_0016','J_0028'),(322,'N_0006','J_0033'),(323,'N_0010','J_0033'),(324,'N_0011','J_0033'),(325,'N_0017','J_0033'),(326,'N_0009','J_0033'),(327,'N_0016','J_0033'),(329,'N_0036','J_0033'),(330,'N_0006','J_0031'),(331,'N_0010','J_0031'),(332,'N_0012','J_0031'),(333,'N_0011','J_0031'),(334,'N_0017','J_0031'),(335,'N_0019','J_0031'),(336,'N_0016','J_0031'),(337,'N_0018','J_0033'),(338,'N_0018','J_0031'),(339,'N_0002','J_0031'),(340,'N_0006','J_0035'),(341,'N_0006','J_0034');
/*!40000 ALTER TABLE `data_persyaratan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_progress_pekerjaan`
--

DROP TABLE IF EXISTS `data_progress_pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_progress_pekerjaan` (
  `id_data_progress_pekerjaan` int(11) NOT NULL AUTO_INCREMENT,
  `no_pekerjaan` varchar(255) NOT NULL,
  `laporan_pekerjaan` varchar(255) NOT NULL,
  `waktu` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_progress_pekerjaan`),
  KEY `no_pekerjaan` (`no_pekerjaan`),
  CONSTRAINT `data_progress_pekerjaan_ibfk_1` FOREIGN KEY (`no_pekerjaan`) REFERENCES `data_pekerjaan` (`no_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_progress_pekerjaan`
--

LOCK TABLES `data_progress_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_progress_pekerjaan` DISABLE KEYS */;
INSERT INTO `data_progress_pekerjaan` VALUES (1,'P000001','Dalam tahap perizinan','2019/07/23'),(2,'P000001','Dalam tahap masd','2019/07/23');
/*!40000 ALTER TABLE `data_progress_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_progress_perizinan`
--

DROP TABLE IF EXISTS `data_progress_perizinan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_progress_perizinan` (
  `no_perizinan` char(11) NOT NULL,
  `laporan` text NOT NULL,
  `waktu` varchar(255) NOT NULL,
  KEY `no_perizinan` (`no_perizinan`),
  CONSTRAINT `data_progress_perizinan_ibfk_1` FOREIGN KEY (`no_perizinan`) REFERENCES `data_perizinan` (`no_perizinan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_progress_perizinan`
--

LOCK TABLES `data_progress_perizinan` WRITE;
/*!40000 ALTER TABLE `data_progress_perizinan` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_progress_perizinan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nama_dokumen`
--

DROP TABLE IF EXISTS `nama_dokumen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nama_dokumen` (
  `id_nama_dokumen` int(11) NOT NULL AUTO_INCREMENT,
  `no_nama_dokumen` varchar(255) NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `tanggal_dibuat` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `pembuat` varchar(255) NOT NULL,
  PRIMARY KEY (`id_nama_dokumen`),
  KEY `no_nama_dokumen` (`no_nama_dokumen`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nama_dokumen`
--

LOCK TABLES `nama_dokumen` WRITE;
/*!40000 ALTER TABLE `nama_dokumen` DISABLE KEYS */;
INSERT INTO `nama_dokumen` VALUES (1,'N_0001','Surat Izin Usaha Perdagangan ( SIUP )','2019-03-06 06:35:35.892906','Dedy Ibrahim'),(2,'N_0002','Nomor pokok wajib pajak (NPWP)','2019-03-06 06:36:01.479696','Dedy Ibrahim'),(3,'N_0003','Asli dokumen yang akan dilegalisasi ','2019-05-10 07:45:29.450496','Admin'),(4,'N_0004','Tanda daftar perusahaan ( TDP )','2019-03-06 06:36:57.464862','Dedy Ibrahim'),(5,'N_0005','Surat Keterangan Domisili','2019-05-10 07:51:55.156500','Admin'),(6,'N_0006','KTP (Kartu Tanda Penduduk)','2019-04-08 08:00:54.463990','Admin'),(7,'N_0007','SP BKPM','2019-04-15 04:10:33.049895','Admin'),(8,'N_0008','Persetujuan RUPS (BAR/PKR/PKPS)','2019-05-10 07:44:26.156078','Admin'),(9,'N_0009','Anggaran Dasar beserta SK','2019-05-10 07:42:22.873063','Admin'),(10,'N_0010','Kartu Keluarga (KK)','2019-05-10 07:43:39.535427','Admin'),(11,'N_0011','Sertifikat Tanah','2019-05-10 07:43:15.943957','Admin'),(12,'N_0012','Buku Nikah','2019-04-30 07:47:56.479177','Admin'),(13,'N_0013','Persetujuan Dewan Komisaris','2019-05-10 07:50:13.317528','Admin'),(16,'N_0014','No. HP dan alamat email pmg saham dan pengurus','2019-05-03 01:54:02.152595','Admin'),(17,'N_0015','Pernyataan Dan Lampiran Fidusia','2019-05-03 01:54:11.503389','Admin'),(18,'N_0016','Persetujuan Pasangan / Akta Perjanjian Kawin','2019-05-10 07:50:00.134728','Admin'),(19,'N_0017','SPPT PBB','2019-05-03 01:54:27.152313','Admin'),(20,'N_0018','Izin Mendirikan Bangunan (IMB)','2019-05-10 07:51:07.431326','Admin'),(21,'N_0019','Akta Kelahiran','2019-05-03 01:54:42.001677','Admin'),(29,'N_0020','Passpor','2019-05-06 01:10:20.137408','Admin'),(30,'N_0021','BAR Pendirian Koperasi / Perkumpulan','2019-05-14 08:21:02.632027','Admin'),(31,'N_0022','Nomor Induk Koperasi (NIK)','2019-05-10 07:48:43.580820','Admin'),(32,'N_0023','Daftar Hadir Rapat','2019-05-10 07:47:12.226951','Admin'),(33,'N_0024','Fc Deposito Bank pemerintah min Rp. 15 juta','2019-05-10 07:47:51.961846','Admin'),(34,'N_0025','BAR Anggota Koperasi','2019-05-10 07:49:24.552007','Admin'),(35,'N_0026','Asli Dokumen yang akan diwaarmerking','2019-05-10 07:52:20.287023','Admin'),(36,'N_0027','Akta Kematian','2019-05-10 07:53:18.840214','Admin'),(37,'N_0028','Surat Keterangan Waris','2019-05-10 07:53:41.544865','Admin'),(38,'N_0029','NIB (Nomor Induk Berusaha)','2019-05-10 07:54:45.201843','Admin'),(39,'N_0030','Izin khusus lainnya (apabila ada)','2019-05-10 07:55:31.250812','Admin'),(40,'N_0031','Surat ganti nama WNI','2019-05-10 07:56:08.829073','Admin'),(41,'N_0032','Dokumen lain terkait isi/jenis dokumen yang dilegalisasi/diwaarmerking','2019-05-10 08:07:08.198314','Admin'),(42,'N_0033','Dokumen obyek hibah (BPKB, Deposito, sertifikat saham, dsb)','2019-05-10 08:31:45.807237','Admin'),(43,'N_0034','Dokumen obyek wasiat (sertifikat tanah, BPKB, Deposito, Sertifikat saham, dsb)','2019-05-10 09:17:21.789182','Admin'),(44,'N_0035','No TLP Debitur dan Kreditur','2019-05-29 02:05:36.264987','Admin'),(45,'N_0036','Dokumen lain terkait isi perjanjian kerjasama','2019-05-14 07:40:11.988133','Admin'),(46,'N_0037','Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019-05-14 07:59:42.472566','Admin'),(47,'N_0038','No. HP Pengurus, Pengawas, Pembina, Penasehat Yay/Perkumpulan/Koperasi ','2019-05-14 08:28:11.997375','Admin'),(48,'N_0039','Maksud Tujuan dan Kegiatan Usaha  ','2019-05-14 08:18:43.682827','Admin'),(49,'N_0040','susunan pemegang saham dan pengurus','2019-05-14 08:05:40.555216','Admin'),(50,'N_0041','susunan pengurus dan pengawas','2019-05-14 08:06:10.967821','Admin'),(51,'N_0042','susunan pembina, pengurus dan pengawas','2019-05-14 08:07:54.260170','Admin'),(52,'N_0043','susunan permodalan (MD, MT, MS)','2019-05-14 08:08:26.242298','Admin'),(53,'N_0044','susunan pesero aktif dan pesero pasif','2019-05-14 08:09:08.918394','Admin'),(54,'N_0045','susunan pengurus, pengawas, penasehat','2019-05-14 08:11:04.564892','Admin'),(55,'N_0046','BAR Anggota Perkumpulan','2019-05-14 08:12:55.453340','Admin'),(56,'N_0047','BAR Pembina Yayasan','2019-05-14 08:13:20.829160','Admin'),(57,'N_0048','Kekayaan Yayasan / Perkumpulan','2019-05-14 08:18:17.701428','Admin'),(58,'N_0049','Nama PT/Yay/Perkumpulan/CV/Koperasi/Firma','2019-05-14 08:22:57.245329','Admin'),(59,'N_0050','Pernyataan modal dan domisili','2019-05-14 08:51:07.207657','Admin'),(60,'N_0051','Pernyataan tidak sengketa','2019-05-27 06:50:07.134496','Admin'),(61,'N_0052','Pernyataan kekayaan halal','2019-05-14 08:52:11.848560','Admin'),(62,'N_0053','Bukti Setor Modal/Neraca (jika modal naik)','2019-05-14 09:00:09.037832','Admin'),(63,'N_0054','Bukti kepemilikan jaminan (sertifikat tanah, hipotek kapal, BPKB,invoice,kontrak dll)','2019-05-15 02:33:30.263583','Admin'),(64,'N_0055','Persetujuan Saudara Yang Lain','2019-05-15 05:52:45.530750','Admin');
/*!40000 ALTER TABLE `nama_dokumen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sublevel_user`
--

DROP TABLE IF EXISTS `sublevel_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sublevel_user` (
  `id_sublevel_user` int(11) NOT NULL AUTO_INCREMENT,
  `no_user` varchar(255) NOT NULL,
  `sublevel` varchar(255) NOT NULL,
  PRIMARY KEY (`id_sublevel_user`),
  KEY `no_user` (`no_user`),
  CONSTRAINT `sublevel_user_ibfk_1` FOREIGN KEY (`no_user`) REFERENCES `user` (`no_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sublevel_user`
--

LOCK TABLES `sublevel_user` WRITE;
/*!40000 ALTER TABLE `sublevel_user` DISABLE KEYS */;
INSERT INTO `sublevel_user` VALUES (1,'0013','Level 3'),(5,'0012','Level 2'),(6,'0012','Level 3'),(7,'0011','Level 2'),(8,'0010','Level 2'),(9,'0009','Level 3'),(10,'0008','Level 2'),(11,'0007','Level 2'),(12,'0006','Level 2'),(13,'0005','Level 2'),(14,'0004','Level 2'),(17,'0002','Level 3'),(18,'0001','Level 3'),(19,'0001','Level 2'),(20,'0001','Level 1'),(21,'0014','Level 1'),(22,'0003','Level 4'),(23,'0001','Level 4');
/*!40000 ALTER TABLE `sublevel_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `no_user` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `tanggal_daftar` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `no_user` (`no_user`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (14,'0001','admin','Admin','dedy@notaris-jakarta.com','0887487772','Super Admin','2019-07-09 10:45:36.205114','21232f297a57a5a743894a0e4a801fc3','5d24705031ed2.png','Aktif'),(20,'0002','wisnu','Wisnu Subroto N.A','yuniaryanto679@gmail.com','087877912311','User','2019-06-24 06:09:21.404327','ea6b2efbdd4255a9f1b3bbc6399b58f4','5d10691150ece.png','Aktif'),(21,'0003','dian','Siti Rizki Dianti','dian@notaris-jakarta.com','085289885222','User','2019-06-18 05:05:57.895092','21232f297a57a5a743894a0e4a801fc3',NULL,'Aktif'),(22,'0004','prima','Prima Yuddy F Y','prima@notaris-jakarta.com','085263908704','User','2019-04-01 02:39:26.162350','d8f49869c8583b77ddb82847f3f1955f',NULL,'Aktif'),(23,'0005','dini','Pratiwi S Dini','dini@notaris-jakarta.com','081273602067','User','2019-04-01 02:39:10.277360','41a8e3d62e005f880e82ef061c571cc8',NULL,'Aktif'),(24,'0006','rifka','Rifka Ramadani','rifka@notaris-jakarta.com','087739397228','User','2019-04-01 02:38:59.368236','92d4f526576c8ad74cbab94ebb239790',NULL,'Aktif'),(25,'0007','yus','Yus Suwandari','yus@notaris-jakarta.com','081280716583','User','2019-06-13 02:13:45.582460','21232f297a57a5a743894a0e4a801fc3','5d01b1598e06d.png','Aktif'),(26,'0008','esthi','Esthi Herlina','esthi@notaris-jakarta.com','081517697047','User','2019-06-12 02:12:29.674979','debac5a803a64b50f4cf2211d921e589','5d005f8da4b9d.png','Aktif'),(27,'0009','ria','haryati Ardi','ria@notaris-jakarta.com','087871555505','User','2019-04-01 02:37:53.534903','85edfaa624cbcf1cfd892d0d9336976e',NULL,'Aktif'),(29,'0010','indy','indarty','indy@notaris-jakarta.com','087876227696','User','2019-04-30 07:58:46.952971','9fbefd6f3a1c3c29e341415e7d48c386',NULL,'Aktif'),(30,'0011','fitri','Fitri Senjayani','fitri@notaris-jakarta.com','08121923365','User','2019-04-30 08:01:14.303720','1df83ea9876252776d4b1e53baebc926',NULL,'Aktif'),(31,'0012','fadzri','MK Fadzri Patriajaya','fadzri@notaris-jakarta.com','087788105424','User','2019-05-21 08:03:22.489574','21232f297a57a5a743894a0e4a801fc3','5ce3b0ca77568.png','Aktif'),(32,'0013','rohmad300','agus rohmad','agusrohmad300@gmail.com','081806446192','User','2019-05-21 08:14:40.720325','21232f297a57a5a743894a0e4a801fc3','5cd8e0ff1ea56.png','Aktif'),(33,'0014','admin2','Dewantari Handayani SH.MPA','dewantari@notaris-jakarta.com','-','User','2019-06-18 03:52:20.702496','c84258e9c39059a89ab77d846ddab909',NULL,'Aktif');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-24  8:50:25
