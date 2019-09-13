-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: notaris
-- ------------------------------------------------------
-- Server version	5.7.20-log

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--


-- Table structure for table `data_berkas`
--

DROP TABLE IF EXISTS `data_berkas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_berkas` (
  `id_data_berkas` int(11) NOT NULL AUTO_INCREMENT,
  `no_berkas` varchar(255) NOT NULL,
  `no_client` varchar(255) DEFAULT NULL,
  `no_pekerjaan` varchar(255) DEFAULT NULL,
  `no_nama_dokumen` varchar(255) DEFAULT NULL,
  `nama_berkas` varchar(255) DEFAULT NULL,
  `pengupload` varchar(255) DEFAULT NULL,
  `tanggal_upload` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_data_berkas`),
  KEY `nama_berkas` (`nama_berkas`),
  KEY `no_client` (`no_client`),
  KEY `no_pekerjaan` (`no_pekerjaan`),
  KEY `no_nama_dokumen` (`no_nama_dokumen`),
  KEY `no_berkas` (`no_berkas`),
  CONSTRAINT `data_berkas_ibfk_1` FOREIGN KEY (`no_client`) REFERENCES `data_client` (`no_client`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_berkas`
--

LOCK TABLES `data_berkas` WRITE;
/*!40000 ALTER TABLE `data_berkas` DISABLE KEYS */;
INSERT INTO `data_berkas` VALUES (223,'BK20190911000000','C000003','P000001','N_0006',NULL,'0001','2019/09/11'),(224,'BK20190911000223','C000003','P000001','N_0006',NULL,'0001','2019/09/11'),(225,'BK20190911000224','C000003','P000001','N_0043',NULL,'0001','2019/09/11'),(226,'BK20190911000225','C000006','P000002','N_0037',NULL,'0001','2019/09/11'),(227,'BK20190911000226','C000006','P000002','N_0043',NULL,'0001','2019/09/11'),(228,'BK20190911000227','C000001','P000001','N_0043',NULL,'0002','2019/09/11'),(229,'BK20190911000228','C000005','P000001','N_0040',NULL,'0001','2019/09/11'),(230,'BK20190911000229','C000001','P000001','N_0043','0fee2bb55d8cba2ba52938fc2c50b1f8.PDF','0002','2019/09/11');
/*!40000 ALTER TABLE `data_berkas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_berkas_perizinan`
--

DROP TABLE IF EXISTS `data_berkas_perizinan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_berkas_perizinan` (
  `id_perizinan` int(11) NOT NULL AUTO_INCREMENT,
  `no_berkas_perizinan` char(255) NOT NULL,
  `no_pekerjaan` varchar(255) NOT NULL,
  `no_client` varchar(100) NOT NULL,
  `no_pemilik` varchar(100) NOT NULL,
  `no_nama_dokumen` varchar(255) NOT NULL,
  `no_user_perizinan` char(255) DEFAULT NULL,
  `no_user_penugas` varchar(255) DEFAULT NULL,
  `status_lihat` varchar(255) DEFAULT NULL,
  `status_berkas` varchar(255) DEFAULT NULL,
  `target_selesai_perizinan` varchar(255) DEFAULT NULL,
  `tanggal_penugasan` varchar(255) NOT NULL,
  `tanggal_selesai` varchar(255) NOT NULL,
  PRIMARY KEY (`id_perizinan`),
  KEY `no_pekerjaan` (`no_pekerjaan`),
  KEY `no_berkas_perizinan` (`no_berkas_perizinan`),
  CONSTRAINT `data_berkas_perizinan_ibfk_1` FOREIGN KEY (`no_pekerjaan`) REFERENCES `data_pekerjaan` (`no_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_berkas_perizinan`
--

LOCK TABLES `data_berkas_perizinan` WRITE;
/*!40000 ALTER TABLE `data_berkas_perizinan` DISABLE KEYS */;
INSERT INTO `data_berkas_perizinan` VALUES (1,'PRZ000000','P000001','C000001','PK000000','N_0037','0002','0001','Dilihat','Masuk',NULL,'2019/09/11',''),(2,'PRZ000001','P000001','C000001','PK000000','N_0043','0002','0001','Dilihat','Proses','2019/09/27','2019/09/11','');
/*!40000 ALTER TABLE `data_berkas_perizinan` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_client`
--

LOCK TABLES `data_client` WRITE;
/*!40000 ALTER TABLE `data_client` DISABLE KEYS */;
INSERT INTO `data_client` VALUES (107,'C000001','PT ANGKASINDO DUNIA','Badan Hukum','Jl.Muara Karang Blok L9 T No.8 Penjaringan Jakarta Utara','2019/09/11','Admin','0001','DokC000001','Sulaiman','081289903664'),(108,'C000002','ABDUL AZIZ','Perorangan','Kp.Sumurwangi RT 01 RW 07 Kel Kayumanis Kec Tanah Sareal','2019/09/11','Admin','0001','DokC000002','Abdul Aziz','082558566858'),(109,'C000003','NAZARUDIN','Perorangan','Kp Rawa Buaya Bogor','2019/09/11','Admin','0001','DokC000003','Nazarudin','0252528555'),(110,'C000004','ISMAIL','Perorangan','Kp Rawa Badak','2019/09/11','Admin','0001','DokC000004','Ismail','082558558588'),(111,'C000005','PT SEKAR GUNA ABADI','Badan Hukum','Jl Rawa Lumbu Makasar','2019/09/11','Admin','0001','DokC000005','PT Sekar Guna Abadi','02585588588'),(112,'C000006','PT BANGUN PERSADA','Badan Hukum','Jl.Muara Karang Blok L9 T No 8','2019/09/11','Admin','0001','DokC000006','Lukman','0216697706');
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
  `no_pekerjaan` varchar(255) NOT NULL,
  `waktu` varchar(255) NOT NULL,
  `tanggal_akta` varchar(100) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_dokumen_utama`),
  KEY `no_pekerjaan` (`no_pekerjaan`),
  CONSTRAINT `data_dokumen_utama_ibfk_1` FOREIGN KEY (`no_pekerjaan`) REFERENCES `data_pekerjaan` (`no_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_dokumen_utama`
--

LOCK TABLES `data_dokumen_utama` WRITE;
/*!40000 ALTER TABLE `data_dokumen_utama` DISABLE KEYS */;
INSERT INTO `data_dokumen_utama` VALUES (1,'Minuta PT ANGKASINDO DUNIA Akta pendirian Perseroan Terbatas ( PT )','1c9fe3252a2bd1e4130ba60fcd76d24b.PDF','P000001','2019/09/11','2019/09/20','Minuta');
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
) ENGINE=InnoDB AUTO_INCREMENT=318 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_histori_pekerjaan`
--

LOCK TABLES `data_histori_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_histori_pekerjaan` DISABLE KEYS */;
INSERT INTO `data_histori_pekerjaan` VALUES (2,'0001','Admin Membuat client asd dan pekerjaan ','2019/07/23 16:18:17'),(3,'0001','Admin Membuat client PT Jaya Abadi','2019/07/23 16:19:30'),(4,'0001','Admin Membuat client PT Jaya Abadi','2019/07/23 16:23:51'),(5,'0001','Admin Membuat client PT Jaya Agung','2019/07/24 09:59:22'),(6,'0001','Admin Menghapus File Persyaratan ','2019/07/25 09:10:53'),(7,'0001','Admin Menghapus File Persyaratan ','2019/07/25 09:11:24'),(8,'0001','Admin Menghapus File Persyaratan ','2019/07/25 09:11:30'),(9,'0001','Admin Menghapus File Persyaratan ','2019/07/25 09:11:31'),(10,'0001','Admin Menghapus File Persyaratan ','2019/07/25 09:13:37'),(11,'0001','Admin Menghapus File Persyaratan ','2019/07/25 09:14:55'),(12,'0001','Admin Menghapus File Persyaratan ','2019/07/25 09:15:15'),(13,'0001','Admin Menghapus File Persyaratan ','2019/07/25 09:16:37'),(14,'0001','Admin Menghapus File Persyaratan ','2019/07/25 10:02:53'),(15,'0001','Admin Menghapus File Persyaratan ','2019/07/25 10:03:22'),(16,'0001','Admin Menghapus File Persyaratan ','2019/07/25 10:12:34'),(17,'0001','Admin Menghapus File Persyaratan ','2019/07/25 10:14:04'),(18,'0001','Admin Menghapus File Persyaratan ','2019/07/25 10:17:24'),(19,'0001','Admin Menghapus File Persyaratan ','2019/07/25 10:18:42'),(20,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 10:19:30'),(21,'0001','Admin Membuat client PT Jaya Agung','2019/07/25 10:21:34'),(22,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 10:22:41'),(23,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 10:57:21'),(24,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 10:57:22'),(25,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 10:57:23'),(26,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 14:06:01'),(27,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 14:15:51'),(28,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 14:15:52'),(29,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 14:15:54'),(30,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 14:18:55'),(31,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/07/25 14:18:56'),(32,'0001','Admin Menghapus File Persyaratan Nama PT/Yay/Perkumpulan/CV/Koperasi/Firma','2019/07/25 14:18:57'),(33,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 14:58:33'),(34,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/07/25 15:22:46'),(35,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/07/25 15:22:47'),(36,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 15:22:48'),(37,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 15:23:00'),(38,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 15:23:20'),(39,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 15:23:54'),(40,'0012','MK Fadzri Patriajaya Membuat client PT. AZURA TECHNINDO UTAMA','2019/07/25 16:26:17'),(41,'0012','MK Fadzri Patriajaya Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/25 16:26:30'),(42,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/07/26 08:33:40'),(43,'0001','Admin Menghapus File Persyaratan susunan pemegang saham dan pengurus','2019/07/26 08:33:41'),(44,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/26 08:33:41'),(45,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/26 08:33:42'),(46,'0012','MK Fadzri Patriajaya Membuat client PT Jaya Agung','2019/07/26 16:43:14'),(47,'0007','Yus Suwandari Membuat client PT Komarudin','2019/07/26 16:48:04'),(48,'0012','MK Fadzri Patriajaya Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/26 17:04:22'),(49,'0012','MK Fadzri Patriajaya Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/26 17:05:27'),(50,'0012','MK Fadzri Patriajaya Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/26 17:06:09'),(51,'0007','Yus Suwandari Menghapus File Persyaratan Nama PT/Yay/Perkumpulan/CV/Koperasi/Firma','2019/07/26 17:12:35'),(52,'0007','Yus Suwandari Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/07/26 17:12:42'),(53,'0001','Admin Membuat client PT Jaya Agung','2019/07/29 08:16:34'),(54,'0001','Admin Menghapus File Persyaratan susunan pemegang saham dan pengurus','2019/07/29 11:05:24'),(55,'0001','Admin Menghapus File Persyaratan susunan pemegang saham dan pengurus','2019/07/29 11:05:32'),(56,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/07/29 11:05:35'),(57,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 11:05:38'),(58,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 11:05:41'),(59,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/07/29 11:05:44'),(60,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 11:11:01'),(61,'0001','Admin Menghapus File Persyaratan susunan pemegang saham dan pengurus','2019/07/29 11:19:28'),(62,'0001','Admin Menghapus File Persyaratan susunan pemegang saham dan pengurus','2019/07/29 11:19:33'),(63,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 11:19:36'),(64,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 11:19:38'),(65,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:07:10'),(66,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:07:12'),(67,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:07:15'),(68,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:07:36'),(69,'0001','Admin Menghapus File Persyaratan susunan pemegang saham dan pengurus','2019/07/29 12:08:10'),(70,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:08:33'),(71,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:10:25'),(72,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:10:38'),(73,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:10:59'),(74,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:11:19'),(75,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:12:07'),(76,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:16:40'),(77,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:20:39'),(78,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 12:20:41'),(79,'0012','MK Fadzri Patriajaya Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 13:17:26'),(80,'0012','MK Fadzri Patriajaya Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 13:17:27'),(81,'0012','MK Fadzri Patriajaya Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 13:17:29'),(82,'0012','MK Fadzri Patriajaya Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/07/29 13:17:33'),(83,'0012','MK Fadzri Patriajaya Memproses perizinan  client PT JAYA AGUNG','2019/07/29 13:40:22'),(84,'0012','MK Fadzri Patriajaya Memproses perizinan NOTARIS client PT JAYA AGUNG','2019/07/29 13:44:00'),(85,'0012','MK Fadzri Patriajaya Membuat client PT Jaya Agung','2019/07/29 13:44:34'),(86,'0012','MK Fadzri Patriajaya Memproses perizinan NOTARIS client PT JAYA AGUNG','2019/07/29 13:45:23'),(87,'0001','Admin Memproses perizinan NOTARIS client PT JAYA AGUNG','2019/07/29 15:34:07'),(88,'0001','Admin Menghapus sad','2019/07/29 18:49:05'),(89,'0001','Admin Menghapus sad','2019/07/29 18:50:24'),(90,'0001','Admin Menghapus sad','2019/07/29 18:50:27'),(91,'0001','Admin Membuat client PT Angkasindo Dunia','2019/07/29 19:01:28'),(92,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/07/29 19:15:21'),(93,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/29 19:15:24'),(94,'0001','Admin Memproses perizinan NOTARIS client PT ANGKASINDO DUNIA','2019/07/30 08:24:09'),(95,'0001','Admin Memproses ulang pekerjaan ','2019/07/30 10:00:05'),(96,'0001','Admin Memproses ulang pekerjaan ','2019/07/30 10:13:41'),(97,'0001','Admin Memproses ulang pekerjaan ','2019/07/30 10:16:41'),(98,'0001','Admin Memproses ulang pekerjaan ','2019/07/30 10:26:44'),(99,'0001','Admin Memproses ulang pekerjaan ','2019/07/30 10:36:58'),(100,'0001','Admin Memproses ulang pekerjaan ','2019/07/30 10:43:35'),(101,'0001','Admin Memproses ulang pekerjaan ','2019/07/30 10:43:40'),(102,'0007','Yus Suwandari Memproses perizinan NOTARIS client PT KOMARUDIN','2019/07/30 11:18:33'),(103,'0001','Admin Membuat client PT Angkasindo Dunia','2019/07/30 15:53:05'),(104,'0002','Wisnu Subroto N.A Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/07/30 18:23:58'),(105,'0002','Wisnu Subroto N.A Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/07/30 18:24:15'),(106,'0002','Wisnu Subroto N.A Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/07/30 18:24:26'),(107,'0002','Wisnu Subroto N.A Menghapus File Persyaratan susunan pemegang saham dan pengurus','2019/07/30 18:24:39'),(108,'0007','Yus Suwandari Membuat client PT Angkasindo Dunia','2019/07/31 08:16:34'),(109,'0007','Yus Suwandari Memproses perizinan NOTARIS client PT ANGKASINDO DUNIA','2019/07/31 08:17:12'),(110,'0012','MK Fadzri Patriajaya Membuat client PT Jaya Agung','2019/07/31 08:20:10'),(111,'0012','MK Fadzri Patriajaya Memproses perizinan NOTARIS client PT JAYA AGUNG','2019/07/31 08:21:22'),(112,'0001','Admin Membuat client PT BBQ Indonesia','2019/07/31 09:27:34'),(113,'0001','Admin Memproses perizinan NOTARIS client PT BBQ INDONESIA','2019/07/31 09:27:57'),(114,'0012','MK Fadzri Patriajaya Membuat client PT Komarudin','2019/07/31 10:15:19'),(115,'0012','MK Fadzri Patriajaya Memproses perizinan NOTARIS client PT KOMARUDIN','2019/07/31 10:15:24'),(116,'0012','MK Fadzri Patriajaya Menghapus Akta perubahan ke satu','2019/07/31 10:16:10'),(117,'0001','Admin Menghapus akta pendirian','2019/08/01 12:28:04'),(118,'0001','Admin Menghapus akta pendirian','2019/08/01 12:30:19'),(119,'0007','Yus Suwandari Membuat client PT Jaya Abadi','2019/08/01 14:40:10'),(120,'0007','Yus Suwandari Memproses perizinan NOTARIS client PT JAYA ABADI','2019/08/01 15:13:59'),(121,'0001','Admin Membuat client PT Sarah bUANA','2019/08/06 08:50:08'),(122,'0001','Admin Membuat client Komarudin','2019/08/06 09:03:36'),(123,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 12:43:34'),(124,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 12:43:35'),(125,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 12:43:39'),(126,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/08/08 12:43:51'),(127,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/08/08 12:43:53'),(128,'0001','Admin Memproses perizinan NOTARIS client PT SARAH BUANA','2019/08/08 12:44:18'),(129,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 12:54:35'),(130,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 12:54:36'),(131,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 12:54:37'),(132,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 12:54:37'),(133,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 12:54:38'),(134,'0001','Admin Membuat client Marpuah','2019/08/08 13:55:26'),(135,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 14:01:58'),(136,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/08/08 14:02:23'),(137,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 14:02:52'),(138,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 14:02:53'),(139,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/08/08 14:03:03'),(140,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/08/08 14:07:09'),(141,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 14:08:18'),(142,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 14:08:56'),(143,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/08/08 14:10:38'),(144,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/08/08 14:12:31'),(145,'0001','Admin Menghapus File Persyaratan ','2019/08/08 14:12:44'),(146,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 14:13:02'),(147,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 14:13:37'),(148,'0001','Admin Memproses perizinan NOTARIS client MARPUAH','2019/08/08 14:14:06'),(149,'0001','Admin Menghapus File Persyaratan KTP (Kartu Tanda Penduduk)','2019/08/08 15:47:46'),(150,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/08 15:59:40'),(151,'0001','Admin Membuat client PT Sarah bUANA','2019/08/08 16:03:28'),(152,'0001','Admin Memproses perizinan NOTARIS client KOMARUDIN','2019/08/08 16:10:18'),(153,'0001','Admin Membuat client PT Sarah Sehan','2019/08/08 16:51:57'),(154,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/09 08:10:11'),(155,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/09 08:10:29'),(156,'0001','Admin Memproses perizinan NOTARIS client PT SARAH SEHAN','2019/08/09 08:11:20'),(157,'0001','Admin Membuat client PT ABC','2019/08/09 08:18:07'),(158,'0001','Admin Memproses perizinan NOTARIS client PT ABC','2019/08/09 08:28:29'),(159,'0001','Admin Membuat client PT ABC','2019/08/09 08:28:57'),(160,'0001','Admin Memproses perizinan NOTARIS client PT ABC','2019/08/09 08:29:18'),(161,'0001','Admin Membuat client PT BCC','2019/08/09 08:55:50'),(162,'0001','Admin Memproses perizinan NOTARIS client PT BCC','2019/08/09 08:56:42'),(163,'0001','Admin Membuat client PT ABC','2019/08/09 09:43:33'),(164,'0007','Yus Suwandari Membuat client PT ZZZZ','2019/08/09 10:23:00'),(165,'0001','Admin Membuat client PT Jaya Abadi','2019/08/09 10:35:01'),(166,'0007','Yus Suwandari Membuat client PT Jaya Abadi','2019/08/09 10:45:58'),(167,'0007','Yus Suwandari Membuat client PT ABC','2019/08/09 10:47:11'),(168,'0007','Yus Suwandari Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/09 10:59:12'),(169,'0007','Yus Suwandari Memproses perizinan NOTARIS client PT ABC','2019/08/09 11:03:26'),(170,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/12 08:10:20'),(171,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/12 08:10:30'),(172,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/12 08:19:49'),(173,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/12 08:19:54'),(174,'0001','Admin Membuat client 123','2019/08/12 08:20:23'),(175,'0001','Admin Memproses perizinan NOTARIS client 123','2019/08/12 09:15:42'),(176,'0001','Admin Membuat client PT Arya Pemadi','2019/08/13 09:19:42'),(177,'0001','Admin Membuat client PT Sekar Buana','2019/08/13 09:20:39'),(178,'0001','Admin Memproses perizinan NOTARIS client PT ARYA PEMADI','2019/08/13 09:38:26'),(179,'0001','Admin Memproses perizinan NOTARIS client PT SEKAR BUANA','2019/08/13 09:39:03'),(180,'0001','Admin Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/13 11:20:52'),(181,'0001','Admin Membuat client dasd','2019/08/14 10:49:42'),(182,'0001','Admin Memproses perizinan NOTARIS client PT ARYA PEMADI','2019/08/15 09:20:03'),(183,'0001','Admin Menghapus draft pt jaya abadi','2019/08/15 14:45:56'),(184,'0001','Admin Menghapus Draft PT ARYA PEMADI Akta perubahan perseroan terbatas ( PT )','2019/08/15 15:03:50'),(185,'0001','Admin Menghapus Minuta PT ARYA PEMADI Akta perubahan perseroan terbatas ( PT )','2019/08/15 15:03:54'),(186,'0001','Admin Menghapus Salinan PT ARYA PEMADI Akta perubahan perseroan terbatas ( PT )','2019/08/15 15:03:57'),(187,'0001','Admin Memproses perizinan NOTARIS client DASD','2019/08/19 10:30:35'),(188,'0001','Admin Memproses perizinan NOTARIS client ZAINUDIN','2019/08/20 14:59:18'),(189,'0001','Admin Menghapus Salinan PT ARYA PEMADI Akta pendirian Perseroan Terbatas ( PT )','2019/08/20 16:05:25'),(190,'0001','Admin Menghapus Draft PT ARYA PEMADI Waarmerking Dokumen','2019/08/20 16:07:16'),(191,'0001','Admin Menghapus Draft PT ARYA PEMADI Akta perubahan perseroan terbatas ( PT )','2019/08/20 16:15:20'),(192,'0001','Admin Menghapus ','2019/08/20 16:15:35'),(193,'0007','Yus Suwandari Membuat client PT Jaya Makmur','2019/08/21 09:30:49'),(194,'0007','Yus Suwandari Memproses perizinan NOTARIS client PT JAYA MAKMUR','2019/08/21 14:44:16'),(195,'0007','Yus Suwandari Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/21 16:04:54'),(196,'0007','Yus Suwandari Menghapus File Persyaratan Nomor pokok wajib pajak (NPWP)','2019/08/21 16:07:28'),(197,'0007','Yus Suwandari Membuat client PT ABC','2019/08/22 14:08:25'),(198,'0007','Yus Suwandari Memproses perizinan NOTARIS client PT ABC','2019/08/22 14:21:02'),(199,'0001','Admin Membuat client PT Jaya Makmur','2019/08/26 09:22:51'),(200,'0001','Admin Membuat client PT Jaya Makmur','2019/08/26 15:48:28'),(201,'0001','Admin Membuat client PT Jaya Makmur','2019/08/26 15:51:31'),(202,'0010','indarty Membuat client PT Jaya Makmur ert324','2019/08/26 16:13:51'),(203,'0001','Admin Membuat client PT Jaya asdasad','2019/08/26 16:26:25'),(204,'0004','Prima Yuddy F Y Membuat client PT AKAY','2019/08/26 17:02:26'),(205,'0005','Pratiwi S Dini Membuat client PT. SANGGARAGRO PERSADA','2019/08/26 17:04:41'),(206,'0011','Fitri Senjayani Membuat client pt angin ribut','2019/08/26 17:06:43'),(207,'0007','Yus Suwandari Membuat client Yayasan Masjid Jami\' Bintaro Jaya','2019/08/26 17:12:06'),(208,'0005','Pratiwi S Dini Memproses perizinan NOTARIS client PT. SANGGARAGRO PERSADA','2019/08/26 17:13:59'),(209,'0015','erzal elvaro Membuat client PT. COBA COBA','2019/08/26 17:16:30'),(210,'0011','Fitri Senjayani Memproses perizinan NOTARIS client PT ANGIN RIBUT','2019/08/26 17:24:37'),(211,'0011','Fitri Senjayani Memproses perizinan NOTARIS client PT ANGIN RIBUT','2019/08/26 17:24:37'),(212,'0015','erzal elvaro Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/26 17:43:59'),(213,'0004','Prima Yuddy F Y Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/26 17:46:05'),(214,'0007','Yus Suwandari Memproses perizinan PPAT client YAYASAN MASJID JAMI\' BINTARO JAYA','2019/08/26 18:02:59'),(215,'0007','Yus Suwandari Membuat client PT Jaya Makmur','2019/08/29 13:29:05'),(216,'0007','Yus Suwandari Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/08/29 13:53:05'),(217,'0007','Yus Suwandari Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/08/29 13:53:10'),(218,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 13:56:36'),(219,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 13:59:03'),(220,'0007','Yus Suwandari Membuat client PT Jaya Makmur','2019/08/29 14:10:53'),(221,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 14:14:27'),(222,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 14:14:30'),(223,'0007','Yus Suwandari Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/08/29 14:15:19'),(224,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 14:19:53'),(225,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 14:20:27'),(226,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 14:20:41'),(227,'0007','Yus Suwandari Menghapus File Persyaratan ','2019/08/29 14:21:50'),(228,'0007','Yus Suwandari Menghapus File Persyaratan ','2019/08/29 14:21:52'),(229,'0007','Yus Suwandari Menghapus File Persyaratan ','2019/08/29 14:22:35'),(230,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 14:22:45'),(231,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 14:23:00'),(232,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 14:23:10'),(233,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 14:33:53'),(234,'0007','Yus Suwandari Memproses perizinan NOTARIS client PT JAYA MAKMUR','2019/08/29 14:35:17'),(235,'0007','Yus Suwandari Membuat client PT Abadi Sentosa','2019/08/29 16:09:33'),(236,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:15:01'),(237,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:16:15'),(238,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:18:32'),(239,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:18:46'),(240,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:20:58'),(241,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:23:29'),(242,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:23:59'),(243,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:24:02'),(244,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:24:36'),(245,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:24:37'),(246,'0007','Yus Suwandari Menghapus File Persyaratan NIB (Nomor Induk Berusaha)','2019/08/29 16:25:35'),(247,'0007','Yus Suwandari Menghapus File Persyaratan NIB (Nomor Induk Berusaha)','2019/08/29 16:25:36'),(248,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:25:46'),(249,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:25:48'),(250,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:26:12'),(251,'0007','Yus Suwandari Menghapus File Persyaratan Anggaran Dasar beserta SK','2019/08/29 16:28:32'),(252,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 16:29:50'),(253,'0007','Yus Suwandari Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/08/29 16:30:20'),(254,'0007','Yus Suwandari Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/08/29 16:40:09'),(255,'0007','Yus Suwandari Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/08/29 16:40:44'),(256,'0007','Yus Suwandari Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/08/29 16:40:46'),(257,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 16:41:15'),(258,'0007','Yus Suwandari Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/29 16:41:16'),(259,'0007','Yus Suwandari Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/08/29 16:47:57'),(260,'0001','Admin Membuat client PT Jaya Abadi','2019/08/30 09:18:07'),(261,'0001','Admin Membuat client Jaya Kumar','2019/08/30 09:21:04'),(262,'0001','Admin Membuat client PT Komar Sejahtera','2019/08/30 09:33:10'),(263,'0001','Admin Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/30 10:41:49'),(264,'0001','Admin Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/30 10:41:50'),(265,'0001','Admin Memproses perizinan NOTARIS client PT KOMAR SEJAHTERA','2019/08/30 14:19:33'),(266,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/08/30 14:39:46'),(267,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/08/30 15:40:48'),(268,'0001','Admin Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/30 15:55:54'),(269,'0001','Admin Menghapus File Persyaratan Kedudukan, almt lengkap PT, Yay, Perkumpulan, CV, Firma, Koperasi','2019/08/30 15:55:55'),(270,'0001','Admin Membuat client PT ABC ','2019/09/04 10:02:19'),(271,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/09/05 11:31:22'),(272,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/09/05 11:31:24'),(273,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/09/05 11:31:26'),(274,'0001','Admin Memproses perizinan NOTARIS client PT ABC ','2019/09/05 11:46:56'),(275,'0001','Admin Membuat client PT Sulaiman','2019/09/05 14:15:02'),(276,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:41:17'),(277,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:41:19'),(278,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:41:20'),(279,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:41:22'),(280,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:41:23'),(281,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:41:24'),(282,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:41:25'),(283,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:41:26'),(284,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:41:27'),(285,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:41:28'),(286,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:59:23'),(287,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:59:24'),(288,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 14:59:25'),(289,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/09/05 15:01:04'),(290,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/09/05 15:01:05'),(291,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/09/05 15:01:06'),(292,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/09/05 15:01:06'),(293,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/09/05 15:01:08'),(294,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 15:01:40'),(295,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 15:17:17'),(296,'0001','Admin Menghapus File Persyaratan Kartu Identitas','2019/09/05 15:17:18'),(297,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/09/05 15:21:14'),(298,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/09/05 15:21:16'),(299,'0001','Admin Menghapus File Persyaratan susunan permodalan (MD, MT, MS)','2019/09/05 15:23:55'),(300,'0001','Admin Membuat client PT Sulaiman','2019/09/09 11:30:28'),(301,'0001','Admin Membuat client PT Jaya Abadi','2019/09/09 11:32:54'),(302,'0001','Admin Membuat client PT Sulaiman','2019/09/09 11:34:02'),(303,'0001','Admin Membuat client PT Angkasindo Dunia','2019/09/10 07:58:10'),(304,'0001','Admin Membuat client PT Angkasindo Dunia','2019/09/10 07:59:53'),(305,'0001','Admin Memproses perizinan NOTARIS client PT ANGKASINDO DUNIA','2019/09/10 08:45:40'),(306,'0001','Admin Membuat client PT Jaya Abadi','2019/09/10 08:46:52'),(307,'0001','Admin Memproses perizinan NOTARIS client PT JAYA ABADI','2019/09/10 09:14:37'),(308,'0001','Admin Membuat client PT Sekar Guna Abadi','2019/09/10 09:49:47'),(309,'0001','Admin Memproses perizinan NOTARIS client PT SEKAR GUNA ABADI','2019/09/10 10:02:28'),(310,'0001','Admin Membuat client PT Bangun Persada','2019/09/10 10:05:26'),(311,'0001','Admin Memproses perizinan NOTARIS client PT BANGUN PERSADA','2019/09/10 10:55:20'),(312,'0001','Admin Membuat client Markonagh','2019/09/10 11:33:37'),(313,'0001','Admin Membuat client PT surya 16','2019/09/10 12:27:49'),(314,'0001','Admin Membuat client PT Angkasindo Dunia','2019/09/10 14:52:09'),(315,'0001','Admin Membuat client PT Angkasindo Dunia','2019/09/11 10:06:17'),(316,'0001','Admin Memproses perizinan NOTARIS client PT ANGKASINDO DUNIA','2019/09/11 10:29:36'),(317,'0001','Admin Membuat client PT Bangun Persada','2019/09/11 13:37:38');
/*!40000 ALTER TABLE `data_histori_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_input_pilihan`
--

DROP TABLE IF EXISTS `data_input_pilihan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_input_pilihan` (
  `id_data_input_pilihan` int(11) NOT NULL AUTO_INCREMENT,
  `id_data_meta` varchar(255) NOT NULL,
  `jenis_pilihan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_input_pilihan`),
  KEY `id_data_meta` (`id_data_meta`),
  CONSTRAINT `data_input_pilihan_ibfk_1` FOREIGN KEY (`id_data_meta`) REFERENCES `data_meta` (`id_data_meta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_input_pilihan`
--

LOCK TABLES `data_input_pilihan` WRITE;
/*!40000 ALTER TABLE `data_input_pilihan` DISABLE KEYS */;
INSERT INTO `data_input_pilihan` VALUES (2,'M_14','Kartu tanda penduduk KTP'),(3,'M_14','Passport'),(7,'M_14','Buku Nikah'),(12,'M_47','PPH'),(13,'M_47','BPHTB'),(14,'M_53','Setifikat tanah'),(15,'M_53','Hipotek kapal'),(16,'M_53','BPKB'),(17,'M_53','Invoice'),(18,'M_53','Kontrak'),(19,'M_53','Dll'),(20,'M_64','Perseroan Terbatas PT'),(21,'M_64','Yayasan'),(22,'M_64','Perkumpulan'),(23,'M_64','CV'),(24,'M_64','Koperasi'),(25,'M_64','Firma'),(26,'M_67','Perkumpulan'),(27,'M_67','Yayasan'),(28,'M_84','Pengurus'),(29,'M_84','Pengawas'),(30,'M_84','Pembina'),(31,'M_84','Penasehat'),(32,'M_85','Yayasan'),(33,'M_85','Perkumpulan'),(34,'M_85','Koperasi'),(35,'M_86','Perseroan Terbatas PT'),(36,'M_86','Yayasan'),(37,'M_86','Perkumpulan'),(38,'M_86','CV'),(39,'M_86','Firma'),(40,'M_86','Koperasi'),(41,'M_92','BPKB'),(42,'M_92','Deposito'),(43,'M_92','Sertifikat saham'),(44,'M_92','dll'),(45,'M_93','BPKB'),(46,'M_93','Deposito'),(47,'M_93','Sertifikat saham'),(48,'M_93','dll'),(49,'M_145','Berita acara rapat / BAR'),(50,'M_145','Pernyataan keputusan rapat / PKR'),(51,'M_145','Pernyataan keputusan pemegang saham / PKPR'),(52,'M_154','Rupiah'),(53,'M_154','Dolar');
/*!40000 ALTER TABLE `data_input_pilihan` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_jenis_pekerjaan`
--

LOCK TABLES `data_jenis_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_jenis_pekerjaan` DISABLE KEYS */;
INSERT INTO `data_jenis_pekerjaan` VALUES (1,'J_0001','NOTARIS','Akta pendirian Perseroan Terbatas ( PT )','2019-05-09 02:28:49.878210','Admin'),(2,'J_0002','NOTARIS','Akta perubahan perseroan terbatas ( PT )','2019-03-05 06:29:24.100515','Dedy Ibrahim'),(3,'J_0003','NOTARIS','Akta pendirian CV','2019-03-05 06:30:13.576017','Dedy Ibrahim'),(4,'J_0004','NOTARIS','Akta perubahan CV','2019-03-05 06:30:31.712436','Dedy Ibrahim'),(5,'J_0005','NOTARIS','Akta pendirian Firma','2019-03-05 06:31:49.696745','Dedy Ibrahim'),(6,'J_0006','NOTARIS','Akta perubahan Firma','2019-03-05 06:32:10.476590','Dedy Ibrahim'),(7,'J_0007','NOTARIS','Akta pendirian Koperasi','2019-03-05 06:33:01.350481','Dedy Ibrahim'),(8,'J_0008','NOTARIS','Akta perubahan Koperasi','2019-03-05 06:33:23.456080','Dedy Ibrahim'),(9,'J_0009','NOTARIS','Akta pendirian Yayasan','2019-03-05 06:37:31.682419','Dedy Ibrahim'),(10,'J_0010','NOTARIS','Akta perubahan Yayasan','2019-03-05 06:37:55.661141','Dedy Ibrahim'),(11,'J_0011','NOTARIS','Akta pendirian Perkumpulan','2019-03-05 06:38:39.618898','Dedy Ibrahim'),(12,'J_0012','NOTARIS','Akta perubahan Perkumpulan','2019-03-05 06:39:10.083953','Dedy Ibrahim'),(13,'J_0013','NOTARIS','Akta Pengakuan Hutang','2019-05-10 08:00:30.135319','Admin'),(14,'J_0014','NOTARIS','Akta Perjanjian Kawin','2019-05-10 08:00:07.451262','Admin'),(15,'J_0015','NOTARIS','Akta Perjanjian Pengikatan Jual Beli','2019-05-10 07:59:55.616911','Admin'),(16,'J_0016','NOTARIS','Akta Perjanjian Sewa Menyewa','2019-05-10 07:59:34.878470','Admin'),(17,'J_0017','NOTARIS','Akta Perjanjian Kerjasama','2019-05-10 07:59:16.773705','Admin'),(18,'J_0018','NOTARIS','Akta Perjanjian Kredit','2019-05-10 07:59:02.510424','Admin'),(20,'J_0019','NOTARIS','Akta Jual Beli Saham','2019-05-10 08:01:41.496718','Admin'),(21,'J_0020','NOTARIS','Akta Wasiat','2019-03-05 06:46:23.085321','Dedy Ibrahim'),(22,'J_0021','NOTARIS','Akta Corporate Guarantee','2019-05-10 08:03:50.450134','Admin'),(23,'J_0022','NOTARIS','Akta Personal Guarantee','2019-05-10 07:58:05.157704','Admin'),(24,'J_0023','NOTARIS','Akta Fidusia','2019-03-05 06:50:46.733389','Dedy Ibrahim'),(25,'J_0024','NOTARIS','Akta Hibah','2019-05-10 08:03:24.625917','Admin'),(27,'J_0025','NOTARIS','Akta Kuasa Untuk Menjual','2019-05-10 08:04:14.961903','Admin'),(28,'J_0026','NOTARIS','Waarmerking Dokumen','2019-05-10 07:57:25.277177','Admin'),(29,'J_0027','NOTARIS','Legalisasi Dokumen','2019-05-10 07:39:37.393049','Admin'),(30,'J_0028','PPAT','Akta Jual Beli (AJB)','2019-05-10 07:37:43.689411','Admin'),(31,'J_0029','PPAT','Akta Hibah','2019-05-10 07:37:22.904901','Admin'),(32,'J_0030','PPAT','Akta Tukar Menukar','2019-05-10 07:37:06.312726','Admin'),(33,'J_0031','PPAT','Akta Pembagian Hak Bersama (APHB)','2019-05-10 07:36:30.910911','Admin'),(34,'J_0032','NOTARIS','Akta Surat Kuasa Memberikan Hak Tanggungan (SKMHT)','2019-05-10 07:35:05.180965','Admin'),(35,'J_0033','PPAT','Akta Pemberian Hak Tanggungan (APHT)','2019-05-15 05:56:54.040414','Admin'),(36,'J_0034','NOTARIS','Akta Pernyataan (WARIS)','2019-05-10 08:45:35.985455','Admin'),(37,'J_0035','NOTARIS','Akta Pendirian PT PMA','2019-07-23 13:44:13.825399','Admin'),(38,'J_0036','NOTARIS','Akta Perubahan Perjanjian kredit','2019-08-29 07:55:22.266661','Admin');
/*!40000 ALTER TABLE `data_jenis_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_meta`
--

DROP TABLE IF EXISTS `data_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_meta` (
  `id_meta` int(100) NOT NULL AUTO_INCREMENT,
  `id_data_meta` varchar(100) NOT NULL,
  `no_nama_dokumen` varchar(255) NOT NULL,
  `nama_meta` varchar(255) NOT NULL,
  `jenis_inputan` varchar(255) NOT NULL,
  `maksimal_karakter` varchar(255) NOT NULL,
  `jenis_bilangan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_meta`),
  KEY `no_nama_dokumen` (`no_nama_dokumen`),
  KEY `id_data_meta` (`id_data_meta`),
  CONSTRAINT `data_meta_ibfk_1` FOREIGN KEY (`no_nama_dokumen`) REFERENCES `nama_dokumen` (`no_nama_dokumen`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_meta`
--

LOCK TABLES `data_meta` WRITE;
/*!40000 ALTER TABLE `data_meta` DISABLE KEYS */;
INSERT INTO `data_meta` VALUES (11,'M_1','N_0006','Tanggal lahir','date','100',''),(12,'M_12','N_0006','Tempat','text','100',''),(13,'M_13','N_0006','No Identitas','text','100',''),(14,'M_14','N_0006','Jenis Identitas','select','100',''),(33,'M_33','N_0078','No Akte','text','100',''),(45,'M_34','N_0078','Nama Sertifikat','text','100',''),(46,'M_46','N_0078','No Sertifikat','text','100',''),(47,'M_47','N_0077','Jenis Pajak','select','100',''),(48,'M_48','N_0077','No Validasi','text','100',''),(49,'M_49','N_0064','Nama Penerima','text','100',''),(50,'M_50','N_0064','Nama Pemberi','text','100',''),(51,'M_51','N_0064','Jenis Kuasa','text','100',''),(52,'M_52','N_0055','Nama surat persetujuan','text','100',''),(53,'M_53','N_0054','Jenis Jaminan','select','100',''),(54,'M_54','N_0054','No Sertifikat','text','100',''),(55,'M_55','N_0054','NIB','text','100',''),(56,'M_56','N_0054','Surat Ukur / Gambar situasi','text','100',''),(57,'M_57','N_0054','No surat ukur','text','100',''),(58,'M_58','N_0052','Nama surat','text','100',''),(59,'M_59','N_0052','No surat','text','100',''),(60,'M_60','N_0051','Nama surat','text','100',''),(61,'M_61','N_0051','No surat','text','100',''),(62,'M_62','N_0050','Nama surat','text','100',''),(63,'M_63','N_0050','No surat','text','100',''),(64,'M_64','N_0049','Jenis Badan Hukum','select','100',''),(66,'M_66','N_0048','Jumlah kekayaan','text','100',''),(67,'M_67','N_0048','Jenis Kekayaan','select','100',''),(68,'M_68','N_0047','Maksud dan tujuan rapat','text','100',''),(69,'M_69','N_0046','Maksud dan tujuan Bar','text','300',''),(70,'M_70','N_0045','Nama Pengurus','text','300',''),(71,'M_71','N_0045','Nama Penasehat','text','100',''),(72,'M_72','N_0045','Nama Pengawas','text','300',''),(73,'M_73','N_0044','Nama Badan Hukum','text','100',''),(74,'M_74','N_0042','Nama Pembina','text','100',''),(75,'M_75','N_0042','Nama Pengurus','text','100',''),(77,'M_76','N_0042','Nama Pengawas','text','100',''),(79,'M_78','N_0041','Nama Pengurus','text','100',''),(80,'M_80','N_0041','Nama Pengawas','text','100',''),(81,'M_81','N_0040','Jabatan','text','100',''),(82,'M_82','N_0040','Jumlah Saham','text','100',''),(83,'M_83','N_0039','Maksud dan tujuan','text','300',''),(84,'M_84','N_0038','Jenis Jabatan','select','100',''),(85,'M_85','N_0038','Jenis Badan Hukum','select','100',''),(86,'M_86','N_0037','Nama Badan Hukum','select','100',''),(88,'M_88','N_0036','Jenis Dokumen','text','100',''),(90,'M_89','N_0035','No Telepon Debitur','number','100',''),(91,'M_91','N_0035','No Telepon Keditur','number','100',''),(92,'M_92','N_0034','Jenis Dokumen','select','100',''),(93,'M_93','N_0033','Jenis Dokumen','select','100',''),(94,'M_94','N_0032','Jenis Dokumen','text','100',''),(95,'M_95','N_0031','No Surat','text','100',''),(96,'M_96','N_0031','Nama Asal','text','100',''),(97,'M_97','N_0031','Nama Sekarang','text','100',''),(98,'M_98','N_0030','Jenis perizinan Khusus','text','100',''),(99,'M_99','N_0029','Nomor NIB','text','100',''),(100,'M_100','N_0028','Tanggal Dikerluarkan','date','100',''),(101,'M_101','N_0028','No Surat','text','100',''),(102,'M_102','N_0028','Nama Ahli Waris','text','100',''),(103,'M_103','N_0028','Nama','text','100',''),(104,'M_104','N_0027','Nama','text','100',''),(105,'M_105','N_0027','Tanggal Kematian','date','100',''),(106,'M_106','N_0027','No Surat Kematian','text','100',''),(107,'M_107','N_0027','Nama Institusi','text','100',''),(108,'M_108','N_0027','Tanggal Surat kematian','date','100',''),(109,'M_109','N_0026','Nama Dokumen Warmeking','text','100',''),(110,'M_110','N_0025','No BAR','text','100',''),(111,'M_111','N_0025','Maksud dan tujuan BAR','text','300',''),(112,'M_112','N_0024','Fotocopy Deposito','text','100',''),(113,'M_113','N_0023','Nama Nama Yang Hadir','text','100',''),(114,'M_114','N_0022','No Induk','text','100',''),(116,'M_115','N_0022','Jenis Koperasi','text','100',''),(117,'M_117','N_0019','Tempat lahir','text','100',''),(118,'M_118','N_0019','Tanggal lahir','date','100',''),(119,'M_119','N_0019','No Surat','text','100',''),(120,'M_120','N_0018','Tanggal IMB','date','100',''),(121,'M_121','N_0018','No IMB','text','100',''),(122,'M_122','N_0018','Pejabat yang mengeluarkan','text','100',''),(123,'M_123','N_0017','No Obyek Pajak NOP','text','100',''),(124,'M_124','N_0016','Nama Pasangan','text','100',''),(125,'M_125','N_0016','Tujuan Lampiran','text','100',''),(126,'M_126','N_0015','Nama Pejabat','text','100',''),(127,'M_127','N_0015','Persetujuan PT','text','100',''),(128,'M_128','N_0015','Jenis Fidusia','text','100',''),(129,'M_129','N_0014','No HP','text','100',''),(130,'M_130','N_0014','Email','text','100',''),(131,'M_131','N_0014','Nama Pemegang Saham','text','100',''),(132,'M_132','N_0014','Nama Pengurus','text','100',''),(133,'M_133','N_0013','No Surat','text','200',''),(134,'M_134','N_0013','Nama Komisaris','text','100',''),(135,'M_135','N_0013','Tanggal Surat','text','200',''),(136,'M_136','N_0011','No Sertifikat','text','200',''),(137,'M_137','N_0011','Luas Tanah','text','100',''),(138,'M_138','N_0011','Lokasi','text','100',''),(139,'M_139','N_0010','Nama KK','text','100',''),(140,'M_140','N_0010','No KK','text','100',''),(141,'M_141','N_0009','No Akte','text','100',''),(142,'M_142','N_0009','No SK / KP','text','100',''),(143,'M_143','N_0008','Nama Perseroan Terbatas','text','100',''),(144,'M_144','N_0008','Maksud dan tujuan RUPS','text','100',''),(145,'M_145','N_0008','Jenis RUPS','select','100',''),(146,'M_146','N_0007','No SP','text','100',''),(147,'M_147','N_0007','Nama PT','text','100',''),(148,'M_148','N_0005','No surat','text','100',''),(149,'M_149','N_0005','Nama Badan Hukum','text','100',''),(150,'M_150','N_0004','No TDP','text','100',''),(151,'M_151','N_0004','Nama Badan Hukum','text','100',''),(152,'M_152','N_0001','No SIUP','text','100',''),(153,'M_153','N_0001','Nama Badan Hukum','text','100',''),(156,'M_154','N_0043','Jenis Mata Uang','select','100',''),(157,'M_157','N_0043','Modal dasar','number','100','Desimal'),(159,'M_159','N_0037','Alamat lengkap','textarea','3000','Pilih Jenis Bilangan'),(161,'M_160','N_0043','Modal disetor dan ditempatkan','number','100','Desimal');
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
  `no_berkas` varchar(255) DEFAULT NULL,
  `no_pekerjaan` varchar(255) NOT NULL,
  `no_nama_dokumen` varchar(255) NOT NULL,
  `nama_meta` varchar(255) DEFAULT NULL,
  `value_meta` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_data_meta_berkas`),
  KEY `nama_berkas` (`no_berkas`),
  CONSTRAINT `data_meta_berkas_ibfk_1` FOREIGN KEY (`no_berkas`) REFERENCES `data_berkas` (`no_berkas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=510 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_meta_berkas`
--

LOCK TABLES `data_meta_berkas` WRITE;
/*!40000 ALTER TABLE `data_meta_berkas` DISABLE KEYS */;
INSERT INTO `data_meta_berkas` VALUES (486,'BK20190911000000','P000001','N_0006','Tanggal lahir','2019/09/11'),(487,'BK20190911000000','P000001','N_0006','Tempat','bOGOR'),(488,'BK20190911000000','P000001','N_0006','No Identitas','123'),(489,'BK20190911000000','P000001','N_0006','Jenis Identitas','Kartu tanda penduduk KTP'),(490,'BK20190911000223','P000001','N_0006','Tanggal lahir','2019/09/11'),(491,'BK20190911000223','P000001','N_0006','Tempat','sUMUEDA'),(492,'BK20190911000223','P000001','N_0006','No Identitas','123123123'),(493,'BK20190911000223','P000001','N_0006','Jenis Identitas','Buku Nikah'),(494,'BK20190911000224','P000001','N_0043','Jenis Mata Uang','Dolar'),(495,'BK20190911000224','P000001','N_0043','Modal dasar','10,023,333'),(496,'BK20190911000224','P000001','N_0043','Modal disetor dan ditempatkan','1,002,333,333'),(497,'BK20190911000225','P000002','N_0037','Nama Badan Hukum','Perseroan Terbatas PT'),(498,'BK20190911000225','P000002','N_0037','Alamat lengkap','Jl. Muara Karang Blok L9 T no 8'),(499,'BK20190911000226','P000002','N_0043','Jenis Mata Uang','Rupiah'),(500,'BK20190911000226','P000002','N_0043','Modal dasar','500,000,000'),(501,'BK20190911000226','P000002','N_0043','Modal disetor dan ditempatkan','250,000,000'),(502,'BK20190911000227','P000001','N_0043','Jenis Mata Uang','Dolar'),(503,'BK20190911000227','P000001','N_0043','Modal dasar','234,234'),(504,'BK20190911000227','P000001','N_0043','Modal disetor dan ditempatkan','99,999,999'),(505,'BK20190911000228','P000001','N_0040','Jabatan','Direktur Utama'),(506,'BK20190911000228','P000001','N_0040','Jumlah Saham','150'),(507,'BK20190911000229','P000001','N_0043','Jenis Mata Uang','Rupiah'),(508,'BK20190911000229','P000001','N_0043','Modal dasar','135,000,000'),(509,'BK20190911000229','P000001','N_0043','Modal disetor dan ditempatkan','100,000,000');
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
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_pekerjaan`
--

LOCK TABLES `data_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_pekerjaan` DISABLE KEYS */;
INSERT INTO `data_pekerjaan` VALUES (193,'C000001','P000001','J_0001','0001','Proses','2019/09/11',NULL,'Admin','2019/09/11','2019/09/14'),(194,'C000006','P000002','J_0001','0001','Masuk','2019/09/11',NULL,'Admin','','2019/09/13');
/*!40000 ALTER TABLE `data_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_pemilik`
--

DROP TABLE IF EXISTS `data_pemilik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_pemilik` (
  `id_data_pemilik` int(11) NOT NULL AUTO_INCREMENT,
  `no_pemilik` varchar(255) NOT NULL,
  `no_client` varchar(255) NOT NULL,
  `no_pekerjaan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_pemilik`),
  KEY `no_client` (`no_client`),
  KEY `no_pemilik` (`no_pemilik`),
  CONSTRAINT `data_pemilik_ibfk_1` FOREIGN KEY (`no_client`) REFERENCES `data_client` (`no_client`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_pemilik`
--

LOCK TABLES `data_pemilik` WRITE;
/*!40000 ALTER TABLE `data_pemilik` DISABLE KEYS */;
INSERT INTO `data_pemilik` VALUES (133,'PK000000','C000001','P000001'),(134,'PK000133','C000003','P000001'),(135,'PK000134','C000005','P000001'),(136,'PK000135','C000004','P000001'),(137,'PK000136','C000006','P000002');
/*!40000 ALTER TABLE `data_pemilik` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=358 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_persyaratan`
--

LOCK TABLES `data_persyaratan` WRITE;
/*!40000 ALTER TABLE `data_persyaratan` DISABLE KEYS */;
INSERT INTO `data_persyaratan` VALUES (7,'N_0003','J_0027'),(8,'N_0006','J_0027'),(9,'N_0032','J_0027'),(10,'N_0026','J_0026'),(11,'N_0006','J_0026'),(12,'N_0032','J_0026'),(26,'N_0006','J_0025'),(27,'N_0016','J_0025'),(28,'N_0010','J_0025'),(33,'N_0011','J_0025'),(34,'N_0017','J_0025'),(35,'N_0018','J_0025'),(39,'N_0011','J_0032'),(40,'N_0017','J_0032'),(41,'N_0018','J_0032'),(42,'N_0006','J_0032'),(43,'N_0016','J_0032'),(47,'N_0010','J_0032'),(48,'N_0009','J_0032'),(49,'N_0005','J_0032'),(50,'N_0029','J_0032'),(52,'N_0008','J_0032'),(53,'N_0013','J_0032'),(54,'N_0030','J_0032'),(55,'N_0009','J_0025'),(56,'N_0005','J_0025'),(57,'N_0029','J_0025'),(58,'N_0008','J_0025'),(59,'N_0013','J_0025'),(60,'N_0030','J_0025'),(61,'N_0006','J_0024'),(62,'N_0010','J_0024'),(63,'N_0016','J_0024'),(68,'N_0027','J_0034'),(70,'N_0019','J_0034'),(71,'N_0010','J_0034'),(73,'N_0033','J_0024'),(74,'N_0006','J_0021'),(75,'N_0031','J_0034'),(76,'N_0006','J_0023'),(77,'N_0009','J_0023'),(78,'N_0005','J_0023'),(79,'N_0015','J_0023'),(80,'N_0032','J_0023'),(83,'N_0004','J_0023'),(85,'N_0006','J_0022'),(86,'N_0010','J_0022'),(88,'N_0016','J_0022'),(90,'N_0013','J_0023'),(91,'N_0008','J_0023'),(92,'N_0008','J_0022'),(93,'N_0009','J_0022'),(95,'N_0005','J_0021'),(96,'N_0009','J_0021'),(97,'N_0008','J_0021'),(98,'N_0013','J_0021'),(101,'N_0006','J_0018'),(103,'N_0009','J_0018'),(104,'N_0008','J_0018'),(105,'N_0013','J_0018'),(107,'N_0005','J_0018'),(110,'N_0018','J_0018'),(111,'N_0035','J_0018'),(112,'N_0029','J_0021'),(113,'N_0006','J_0020'),(114,'N_0019','J_0020'),(115,'N_0027','J_0020'),(116,'N_0010','J_0020'),(117,'N_0034','J_0020'),(118,'N_0006','J_0019'),(119,'N_0010','J_0019'),(120,'N_0016','J_0019'),(122,'N_0009','J_0019'),(123,'N_0029','J_0019'),(124,'N_0030','J_0019'),(125,'N_0008','J_0019'),(126,'N_0013','J_0019'),(127,'N_0006','J_0016'),(128,'N_0010','J_0016'),(129,'N_0016','J_0016'),(131,'N_0011','J_0016'),(132,'N_0017','J_0016'),(133,'N_0018','J_0016'),(134,'N_0009','J_0016'),(135,'N_0029','J_0016'),(136,'N_0030','J_0016'),(137,'N_0006','J_0015'),(138,'N_0010','J_0015'),(139,'N_0016','J_0015'),(141,'N_0011','J_0015'),(142,'N_0017','J_0015'),(143,'N_0018','J_0015'),(144,'N_0009','J_0015'),(145,'N_0029','J_0015'),(146,'N_0030','J_0015'),(147,'N_0008','J_0015'),(148,'N_0013','J_0015'),(149,'N_0008','J_0016'),(150,'N_0013','J_0016'),(151,'N_0006','J_0017'),(152,'N_0010','J_0017'),(153,'N_0016','J_0017'),(155,'N_0009','J_0017'),(156,'N_0029','J_0017'),(157,'N_0030','J_0017'),(158,'N_0008','J_0017'),(159,'N_0013','J_0017'),(160,'N_0036','J_0017'),(161,'N_0006','J_0014'),(163,'N_0010','J_0013'),(165,'N_0016','J_0013'),(166,'N_0009','J_0013'),(167,'N_0029','J_0013'),(168,'N_0030','J_0013'),(169,'N_0008','J_0013'),(170,'N_0013','J_0013'),(172,'N_0006','J_0013'),(174,'N_0006','J_0012'),(178,'N_0009','J_0012'),(179,'N_0005','J_0012'),(182,'N_0046','J_0012'),(183,'N_0030','J_0012'),(184,'N_0006','J_0011'),(186,'N_0045','J_0011'),(187,'N_0049','J_0011'),(188,'N_0048','J_0011'),(189,'N_0037','J_0011'),(190,'N_0039','J_0011'),(191,'N_0006','J_0010'),(193,'N_0009','J_0010'),(194,'N_0005','J_0010'),(195,'N_0030','J_0010'),(196,'N_0047','J_0010'),(197,'N_0006','J_0009'),(198,'N_0049','J_0009'),(200,'N_0038','J_0012'),(201,'N_0038','J_0011'),(202,'N_0038','J_0010'),(203,'N_0037','J_0009'),(204,'N_0048','J_0009'),(205,'N_0039','J_0009'),(206,'N_0038','J_0009'),(207,'N_0042','J_0009'),(208,'N_0006','J_0008'),(210,'N_0009','J_0008'),(211,'N_0030','J_0008'),(212,'N_0025','J_0008'),(213,'N_0038','J_0008'),(214,'N_0006','J_0007'),(216,'N_0049','J_0007'),(217,'N_0037','J_0007'),(218,'N_0048','J_0007'),(219,'N_0039','J_0007'),(220,'N_0041','J_0007'),(222,'N_0038','J_0007'),(225,'N_0006','J_0006'),(227,'N_0009','J_0006'),(228,'N_0005','J_0006'),(230,'N_0004','J_0006'),(231,'N_0014','J_0006'),(232,'N_0006','J_0005'),(233,'N_0049','J_0005'),(234,'N_0014','J_0005'),(235,'N_0037','J_0005'),(236,'N_0039','J_0005'),(237,'N_0040','J_0005'),(238,'N_0043','J_0005'),(239,'N_0006','J_0004'),(241,'N_0009','J_0004'),(242,'N_0005','J_0004'),(244,'N_0004','J_0004'),(245,'N_0014','J_0004'),(246,'N_0006','J_0003'),(247,'N_0049','J_0003'),(248,'N_0037','J_0003'),(249,'N_0043','J_0003'),(250,'N_0044','J_0003'),(251,'N_0050','J_0011'),(252,'N_0052','J_0011'),(253,'N_0050','J_0009'),(254,'N_0051','J_0012'),(255,'N_0051','J_0010'),(256,'N_0050','J_0007'),(257,'N_0014','J_0003'),(258,'N_0022','J_0008'),(259,'N_0006','J_0002'),(261,'N_0009','J_0002'),(262,'N_0029','J_0002'),(263,'N_0030','J_0002'),(264,'N_0008','J_0002'),(265,'N_0014','J_0002'),(267,'N_0006','J_0001'),(270,'N_0037','J_0001'),(271,'N_0043','J_0001'),(272,'N_0040','J_0001'),(273,'N_0014','J_0001'),(275,'N_0039','J_0001'),(276,'N_0039','J_0003'),(277,'N_0005','J_0022'),(279,'N_0004','J_0022'),(280,'N_0029','J_0022'),(281,'N_0029','J_0018'),(282,'N_0054','J_0018'),(285,'N_0049','J_0035'),(286,'N_0037','J_0035'),(287,'N_0039','J_0035'),(288,'N_0043','J_0035'),(289,'N_0040','J_0035'),(290,'N_0014','J_0035'),(291,'N_0050','J_0035'),(292,'N_0009','J_0035'),(293,'N_0030','J_0035'),(294,'N_0007','J_0035'),(295,'N_0006','J_0030'),(296,'N_0010','J_0030'),(297,'N_0016','J_0030'),(299,'N_0011','J_0030'),(300,'N_0017','J_0030'),(301,'N_0018','J_0030'),(303,'N_0006','J_0029'),(304,'N_0010','J_0029'),(305,'N_0019','J_0029'),(309,'N_0011','J_0029'),(310,'N_0017','J_0029'),(311,'N_0018','J_0029'),(313,'N_0055','J_0029'),(314,'N_0006','J_0028'),(315,'N_0010','J_0028'),(317,'N_0017','J_0028'),(318,'N_0018','J_0028'),(320,'N_0011','J_0028'),(321,'N_0016','J_0028'),(322,'N_0006','J_0033'),(323,'N_0010','J_0033'),(324,'N_0011','J_0033'),(325,'N_0017','J_0033'),(326,'N_0009','J_0033'),(327,'N_0016','J_0033'),(329,'N_0036','J_0033'),(330,'N_0006','J_0031'),(331,'N_0010','J_0031'),(333,'N_0011','J_0031'),(334,'N_0017','J_0031'),(335,'N_0019','J_0031'),(336,'N_0016','J_0031'),(337,'N_0018','J_0033'),(338,'N_0018','J_0031'),(340,'N_0006','J_0035'),(341,'N_0006','J_0034'),(342,'N_0013','J_0001'),(343,'N_0064','J_0035'),(344,'N_0029','J_0035'),(345,'N_0009','J_0028'),(346,'N_0005','J_0028'),(347,'N_0004','J_0028'),(348,'N_0001','J_0028'),(350,'N_0008','J_0028'),(351,'N_0013','J_0028'),(354,'N_0077','J_0028'),(357,'N_0009','J_0028');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_progress_pekerjaan`
--

LOCK TABLES `data_progress_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_progress_pekerjaan` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_progress_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_progress_perizinan`
--

DROP TABLE IF EXISTS `data_progress_perizinan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_progress_perizinan` (
  `no_berkas_perizinan` char(11) NOT NULL,
  `laporan` text NOT NULL,
  `waktu` varchar(255) NOT NULL,
  KEY `no_perizinan` (`no_berkas_perizinan`),
  CONSTRAINT `data_progress_perizinan_ibfk_1` FOREIGN KEY (`no_berkas_perizinan`) REFERENCES `data_berkas_perizinan` (`no_berkas_perizinan`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `badan_hukum` varchar(255) NOT NULL,
  `perorangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_nama_dokumen`),
  KEY `no_nama_dokumen` (`no_nama_dokumen`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nama_dokumen`
--

LOCK TABLES `nama_dokumen` WRITE;
/*!40000 ALTER TABLE `nama_dokumen` DISABLE KEYS */;
INSERT INTO `nama_dokumen` VALUES (1,'N_0001','Surat Izin Usaha Perdagangan ( SIUP )','2019-08-26 07:08:13.979270','Admin','Badan Hukum','undefined'),(3,'N_0003','Asli dokumen yang akan dilegalisasi ','2019-08-26 07:08:08.362347','Admin','Badan Hukum','Perorangan'),(4,'N_0004','Tanda daftar perusahaan ( TDP )','2019-08-26 07:08:00.162648','Admin','Badan Hukum','undefined'),(5,'N_0005','Surat Keterangan Domisili','2019-08-26 07:07:51.954546','Admin','Badan Hukum','Perorangan'),(6,'N_0006','Kartu Identitas','2019-09-03 07:02:24.177218','Admin','undefined','Perorangan'),(7,'N_0007','SP BKPM','2019-08-26 07:07:35.002779','Admin','Badan Hukum','undefined'),(8,'N_0008','Persetujuan RUPS (BAR/PKR/PKPS)','2019-08-26 07:07:24.276094','Admin','Badan Hukum','Perorangan'),(9,'N_0009','Anggaran Dasar beserta SK','2019-08-26 07:07:15.003574','Admin','Badan Hukum','undefined'),(10,'N_0010','Kartu Keluarga (KK)','2019-08-26 07:07:08.132267','Admin','undefined','Perorangan'),(11,'N_0011','Sertifikat Tanah','2019-08-26 07:07:01.507129','Admin','Badan Hukum','Perorangan'),(13,'N_0013','Persetujuan Dewan Komisaris','2019-08-26 07:06:52.298354','Admin','undefined','Perorangan'),(16,'N_0014','No. HP dan alamat email pmg saham dan pengurus','2019-08-08 03:01:32.750826','Admin','undefined','Perorangan'),(17,'N_0015','Pernyataan Dan Lampiran Fidusia','2019-08-26 07:06:34.842978','Admin','Badan Hukum','undefined'),(18,'N_0016','Persetujuan Pasangan / Akta Perjanjian Kawin','2019-08-26 07:06:24.169482','Admin','undefined','Perorangan'),(19,'N_0017','SPPT PBB','2019-08-26 07:06:17.433660','Admin','Badan Hukum','Perorangan'),(20,'N_0018','Izin Mendirikan Bangunan (IMB)','2019-08-26 07:06:08.433020','Admin','Badan Hukum','Perorangan'),(21,'N_0019','Akta Kelahiran','2019-08-26 07:05:58.971240','Admin','undefined','Perorangan'),(31,'N_0022','Nomor Induk Koperasi (NIK)','2019-08-26 07:05:52.113467','Admin','Badan Hukum','undefined'),(32,'N_0023','Daftar Hadir Rapat','2019-08-26 07:05:40.179043','Admin','Badan Hukum','Perorangan'),(33,'N_0024','Fc Deposito Bank pemerintah min Rp. 15 juta','2019-05-10 07:47:51.961846','Admin','',''),(34,'N_0025','BAR Anggota Koperasi','2019-08-26 07:04:50.160543','Admin','Badan Hukum','undefined'),(35,'N_0026','Asli Dokumen yang akan diwaarmerking','2019-08-26 07:04:41.385374','Admin','Badan Hukum','Perorangan'),(36,'N_0027','Akta Kematian','2019-08-26 07:04:27.714028','Admin','undefined','Perorangan'),(37,'N_0028','Surat Keterangan Waris','2019-08-26 07:04:20.921575','Admin','undefined','Perorangan'),(38,'N_0029','NIB (Nomor Induk Berusaha)','2019-08-26 07:04:09.691368','Admin','Badan Hukum','undefined'),(39,'N_0030','Izin khusus lainnya (apabila ada)','2019-08-26 07:04:02.529371','Admin','Badan Hukum','undefined'),(40,'N_0031','Surat ganti nama WNI','2019-08-26 07:03:43.361576','Admin','undefined','Perorangan'),(41,'N_0032','Dokumen lain terkait isi/jenis dokumen yang dilegalisasi/diwaarmerking','2019-08-26 07:03:19.561025','Admin','Badan Hukum','Perorangan'),(42,'N_0033','Dokumen obyek hibah ','2019-09-09 02:00:22.790273','Admin','undefined','Perorangan'),(43,'N_0034','Dokumen obyek wasiat ','2019-09-09 01:58:59.454069','Admin','undefined','Perorangan'),(44,'N_0035','No TLP Debitur dan Kreditur','2019-08-26 07:02:14.945029','Admin','Badan Hukum','Perorangan'),(45,'N_0036','Dokumen lain terkait isi perjanjian kerjasama','2019-08-26 07:01:38.787335','Admin','Badan Hukum','Perorangan'),(46,'N_0037','Kedudukan atau alamat lengkap Badan Hukum','2019-09-10 01:16:09.525684','Admin','Badan Hukum','undefined'),(47,'N_0038','No. HP Pengurus, Pengawas, Pembina, Penasehat Yay/Perkumpulan/Koperasi ','2019-08-26 07:00:48.498108','Admin','undefined','Perorangan'),(48,'N_0039','Maksud Tujuan dan Kegiatan Usaha  ','2019-08-08 03:01:51.479357','Admin','Badan Hukum','undefined'),(49,'N_0040','susunan pemegang saham dan pengurus','2019-08-26 07:00:16.176187','Admin','Badan Hukum','Perorangan'),(50,'N_0041','susunan pengurus dan pengawas','2019-05-14 08:06:10.967821','Admin','',''),(51,'N_0042','susunan pembina, pengurus dan pengawas','2019-08-26 07:00:08.088720','Admin','undefined','Perorangan'),(52,'N_0043','susunan permodalan (MD, MT, MS)','2019-08-08 03:00:09.070903','Admin','Badan Hukum','Perorangan'),(53,'N_0044','susunan pesero aktif dan pesero pasif','2019-08-26 06:59:53.502970','Admin','undefined','Perorangan'),(54,'N_0045','susunan pengurus, pengawas, penasehat','2019-08-26 06:59:46.886899','Admin','undefined','Perorangan'),(55,'N_0046','BAR Anggota Perkumpulan','2019-08-26 06:58:31.487420','Admin','undefined','Perorangan'),(56,'N_0047','BAR Pembina Yayasan','2019-08-26 06:58:20.393386','Admin','undefined','Perorangan'),(57,'N_0048','Kekayaan Yayasan / Perkumpulan','2019-08-26 06:58:06.608858','Admin','Badan Hukum','Perorangan'),(58,'N_0049','Nama Badan Hukum','2019-09-06 02:16:47.718939','Admin','Badan Hukum','undefined'),(59,'N_0050','Pernyataan modal','2019-08-26 06:57:48.047131','Admin','Badan Hukum','Perorangan'),(60,'N_0051','Pernyataan tidak sengketa','2019-08-26 06:57:37.904606','Admin','Badan Hukum','Perorangan'),(61,'N_0052','Pernyataan kekayaan halal','2019-08-26 06:57:18.096832','Admin','Badan Hukum','Perorangan'),(62,'N_0053','Bukti Setor Modal/Neraca (jika modal naik)','2019-08-26 06:56:31.095494','Admin','Badan Hukum','undefined'),(63,'N_0054','Bukti kepemilikan jaminan','2019-09-06 02:10:14.702087','Admin','Badan Hukum','Perorangan'),(64,'N_0055','Persetujuan Saudara Yang Lain','2019-08-26 06:55:41.474673','Admin','undefined','Perorangan'),(74,'N_0064','POA Power Of Attorney','2019-08-26 07:10:21.243282','Admin','',''),(78,'N_0077','Validasi Pajak  PPH dan BHTB','2019-08-27 09:20:37.697188','Admin','Badan Hukum','Perorangan'),(79,'N_0078','Balik Nama sertifikat','2019-09-06 01:59:05.760015','Admin','','');
/*!40000 ALTER TABLE `nama_dokumen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_aplikasi`
--

DROP TABLE IF EXISTS `status_aplikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_aplikasi` (
  `app_managemen` varchar(15) NOT NULL,
  `app_admin` varchar(15) NOT NULL,
  `app_workflow` varchar(15) NOT NULL,
  `app_resepsionis` varchar(15) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_aplikasi`
--

LOCK TABLES `status_aplikasi` WRITE;
/*!40000 ALTER TABLE `status_aplikasi` DISABLE KEYS */;
INSERT INTO `status_aplikasi` VALUES ('on','on','on','off',1);
/*!40000 ALTER TABLE `status_aplikasi` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sublevel_user`
--

LOCK TABLES `sublevel_user` WRITE;
/*!40000 ALTER TABLE `sublevel_user` DISABLE KEYS */;
INSERT INTO `sublevel_user` VALUES (1,'0013','Level 3'),(5,'0012','Level 2'),(6,'0012','Level 3'),(7,'0011','Level 2'),(8,'0010','Level 2'),(9,'0009','Level 3'),(10,'0008','Level 2'),(11,'0007','Level 2'),(12,'0006','Level 2'),(13,'0005','Level 2'),(14,'0004','Level 2'),(17,'0002','Level 3'),(19,'0001','Level 2'),(20,'0001','Level 1'),(21,'0014','Level 1'),(22,'0003','Level 4'),(23,'0001','Level 4'),(24,'0001','Level 3'),(25,'0015','Level 2');
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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (14,'0001','admin','Admin','dedy@notaris-jakarta.com','0887487772','Super Admin','2019-08-14 07:27:06.576059','21232f297a57a5a743894a0e4a801fc3','5d53b7ca8c7c5.png','Aktif'),(20,'0002','wisnu','Wisnu Subroto N.A','yuniaryanto679@gmail.com','087877912311','User','2019-09-11 06:43:45.751698','21232f297a57a5a743894a0e4a801fc3','5d10691150ece.png','Aktif'),(21,'0003','dian','Siti Rizki Dianti','dian@notaris-jakarta.com','085289885222','User','2019-08-26 09:07:13.043943','f97de4a9986d216a6e0fea62b0450da9',NULL,'Aktif'),(22,'0004','prima','Prima Yuddy F Y','prima@notaris-jakarta.com','085263908704','User','2019-08-26 09:07:13.195274','3c00ab9ee5f47c8afc7ab4fc62342ef4',NULL,'Aktif'),(23,'0005','dini','Pratiwi S Dini','dini@notaris-jakarta.com','081273602067','User','2019-08-26 09:07:13.293964','83476316a972856163fb987b861a0a2c',NULL,'Aktif'),(24,'0006','rifka','Rifka Ramadani','rifka@notaris-jakarta.com','087739397228','User','2019-08-26 09:07:13.375698','7642cc8b570d5aa995acfb1a14267499',NULL,'Aktif'),(25,'0007','yus','Yus Suwandari','yus@notaris-jakarta.com','081280716583','User','2019-08-26 09:07:13.457325','efb6e5a9e90a1126301802ee0b3f11b8','5d01b1598e06d.png','Aktif'),(26,'0008','esthi','Esthi Herlina','esthi@notaris-jakarta.com','081517697047','User','2019-06-12 02:12:29.674979','debac5a803a64b50f4cf2211d921e589','5d005f8da4b9d.png','Aktif'),(27,'0009','ria','haryati Ardi','ria@notaris-jakarta.com','087871555505','User','2019-04-01 02:37:53.534903','85edfaa624cbcf1cfd892d0d9336976e',NULL,'Aktif'),(29,'0010','indy','indarty','indy@notaris-jakarta.com','087876227696','User','2019-08-26 09:07:50.527950','9678817d0423ffa93446767b944e2b11',NULL,'Aktif'),(30,'0011','fitri','Fitri Senjayani','fitri@notaris-jakarta.com','08121923365','User','2019-08-26 09:07:42.099923','534a0b7aa872ad1340d0071cbfa38697',NULL,'Aktif'),(31,'0012','fadzri','MK Fadzri Patriajaya','fadzri@notaris-jakarta.com','087788105424','User','2019-07-30 04:13:48.810816','21232f297a57a5a743894a0e4a801fc3','5d3fc3fcc5dbf.png','Aktif'),(32,'0013','rohmad300','agus rohmad','agusrohmad300@gmail.com','081806446192','User','2019-05-21 08:14:40.720325','21232f297a57a5a743894a0e4a801fc3','5cd8e0ff1ea56.png','Aktif'),(33,'0014','admin2','Dewantari Handayani SH.MPA','dewantari@notaris-jakarta.com','-','User','2019-06-18 03:52:20.702496','c84258e9c39059a89ab77d846ddab909',NULL,'Aktif'),(34,'0015','erzal','erzal elvaro','erzal@notaris-jakarta.com','081289903664','User','2019-08-26 09:49:56.382732','f5e13cf6dc1c7faebe107fbc008fdd13',NULL,'Aktif'),(35,'0016','imam','Imam Syafi\'i','imamsyafii060179@gmail.com','087878914988','User','2019-08-30 09:18:49.440073','eaccb8ea6090a40a98aa28c071810371',NULL,'Aktif');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-11 15:52:34
