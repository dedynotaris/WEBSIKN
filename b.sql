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
  `status_berkas` varchar(11) NOT NULL,
  PRIMARY KEY (`id_data_berkas`),
  KEY `nama_berkas` (`nama_berkas`),
  KEY `no_client` (`no_client`),
  KEY `no_pekerjaan` (`no_pekerjaan`),
  KEY `no_nama_dokumen` (`no_nama_dokumen`),
  KEY `no_berkas` (`no_berkas`),
  CONSTRAINT `data_berkas_ibfk_1` FOREIGN KEY (`no_client`) REFERENCES `data_client` (`no_client`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_berkas`
--

LOCK TABLES `data_berkas` WRITE;
/*!40000 ALTER TABLE `data_berkas` DISABLE KEYS */;
INSERT INTO `data_berkas` VALUES (1,'BK20200227000000','C000001','P000001','N_0009','00f39e4963a5d6e5ba5b264b43bba654.doc','0019','2020/02/27',''),(2,'BK20200227000001','C000001','P000001','N_0004','24__AKTA_PKR_NO__9_TGL_07052019_PERUBAHAN_AD.pdf','0019','2020/02/27',''),(3,'BK20200227000002','C000001','P000001','N_0008','2255e184e1dc831012961f06196829a6.docx','0019','2020/02/27',''),(4,'BK20200227000003','C000001','P000002',NULL,'00f39e4963a5d6e5ba5b264b43bba6541.doc','0019','2020/02/27',''),(5,'BK20200227000004','C000002','P000001','N_0105','24__AKTA_PKR_NO__9_TGL_07052019_PERUBAHAN_AD.pdf','0019','2020/02/27','');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_berkas_perizinan`
--

LOCK TABLES `data_berkas_perizinan` WRITE;
/*!40000 ALTER TABLE `data_berkas_perizinan` DISABLE KEYS */;
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
  `no_identitas` varchar(255) NOT NULL,
  `nama_client` varchar(255) NOT NULL,
  `jenis_client` varchar(255) NOT NULL,
  `alamat_client` varchar(255) NOT NULL,
  `tanggal_daftar` varchar(255) NOT NULL,
  `pembuat_client` varchar(255) NOT NULL,
  `no_user` varchar(255) NOT NULL,
  `nama_folder` varchar(255) NOT NULL,
  `jenis_kontak` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id_data_client`),
  KEY `no_client` (`no_client`),
  KEY `no_user` (`no_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_client`
--

LOCK TABLES `data_client` WRITE;
/*!40000 ALTER TABLE `data_client` DISABLE KEYS */;
INSERT INTO `data_client` VALUES (1,'C000001','24555855','PT SHARADADI','Badan Hukum','','2020/02/27','Prima Yuddy F Y','0004','DokC000001','Pribadi','Fadzri','0352568258588',''),(2,'C000002','525585866855','SHARA NURACHMA FARADILLA','Perorangan','','2020/02/27','Dokumen Arsip','0019','DokC000002','Pribadi','SHARA','065285552858555','');
/*!40000 ALTER TABLE `data_client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_daftar_lemari`
--

DROP TABLE IF EXISTS `data_daftar_lemari`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_daftar_lemari` (
  `id_lemari` int(11) NOT NULL AUTO_INCREMENT,
  `no_lemari` varchar(100) NOT NULL,
  `nama_tempat` varchar(100) NOT NULL,
  PRIMARY KEY (`id_lemari`),
  KEY `no_loker` (`no_lemari`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_daftar_lemari`
--

LOCK TABLES `data_daftar_lemari` WRITE;
/*!40000 ALTER TABLE `data_daftar_lemari` DISABLE KEYS */;
INSERT INTO `data_daftar_lemari` VALUES (19,'LM001','Lemari Gantung Lantai 3'),(20,'LM002','Lemari Folder Lantai 3'),(21,'LM003','Lemari Folder Lantai 4 ');
/*!40000 ALTER TABLE `data_daftar_lemari` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_daftar_loker`
--

DROP TABLE IF EXISTS `data_daftar_loker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_daftar_loker` (
  `id_loker` int(11) NOT NULL AUTO_INCREMENT,
  `no_loker` varchar(100) NOT NULL,
  `no_lemari` varchar(100) NOT NULL,
  `status_loker` varchar(100) NOT NULL,
  PRIMARY KEY (`id_loker`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_daftar_loker`
--

LOCK TABLES `data_daftar_loker` WRITE;
/*!40000 ALTER TABLE `data_daftar_loker` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_daftar_loker` ENABLE KEYS */;
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
  `no_akta` varchar(255) NOT NULL,
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
INSERT INTO `data_dokumen_utama` VALUES (1,'Salinan PT SHARADADI Akta pendirian Perseroan Terbatas ( PT )','24__AKTA_PKR_NO__9_TGL_07052019_PERUBAHAN_AD1.pdf','P000001','2020/02/27','2020/02/27','12','Salinan');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_histori_pekerjaan`
--

LOCK TABLES `data_histori_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_histori_pekerjaan` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_input_pilihan`
--

LOCK TABLES `data_input_pilihan` WRITE;
/*!40000 ALTER TABLE `data_input_pilihan` DISABLE KEYS */;
INSERT INTO `data_input_pilihan` VALUES (2,'M_14','Kartu tanda penduduk KTP'),(3,'M_14','Passport'),(7,'M_14','Buku Nikah'),(12,'M_47','PPH'),(13,'M_47','BPHTB'),(14,'M_53','Setifikat tanah'),(15,'M_53','Hipotek kapal'),(16,'M_53','BPKB'),(17,'M_53','Invoice'),(18,'M_53','Kontrak'),(19,'M_53','Dll'),(26,'M_67','Perkumpulan'),(27,'M_67','Yayasan'),(35,'M_86','Perseroan Terbatas PT'),(36,'M_86','Yayasan'),(37,'M_86','Perkumpulan'),(38,'M_86','CV'),(39,'M_86','Firma'),(40,'M_86','Koperasi'),(41,'M_92','BPKB'),(42,'M_92','Deposito'),(43,'M_92','Sertifikat saham'),(44,'M_92','dll'),(45,'M_93','BPKB'),(46,'M_93','Deposito'),(47,'M_93','Sertifikat saham'),(48,'M_93','dll'),(49,'M_145','Berita acara rapat / BAR'),(50,'M_145','Pernyataan keputusan rapat / PKR'),(51,'M_145','Pernyataan keputusan pemegang saham / PKPR'),(52,'M_154','Rupiah'),(53,'M_154','Dolar'),(54,'M_165','Jaminan Fidusia'),(55,'M_165','Jaminan Hak Tanggungan'),(56,'M_165','Hipotek Kapal'),(57,'M_165','Jaminan Perseorangan'),(58,'M_165','Jaminan Perusahaan'),(59,'M_165','Cash Defisit Guarantee'),(60,'M_170','Jaminan Fidusia'),(61,'M_170','Jaminan Hak Tanggungan'),(62,'M_170','Jaminan Hipotek Kapal'),(63,'M_170','Jaminan Perseorangan'),(64,'M_170','Jaminan Perusahaan'),(65,'M_170','Cahn Defisit Guarantee'),(66,'M_175','Jaminan Fidusia'),(67,'M_175','Jaminan Hipotek Kapal'),(68,'M_175','Jaminan Perseorangan'),(69,'M_175','Jaminan Perusahaan'),(70,'M_175','Cash Defisit Guarantee'),(77,'M_188','Jaminan Fidusia'),(78,'M_188','Jaminan Hak Tanggungan'),(79,'M_188','Jaminan Hipotek Kapal'),(80,'M_188','Jaminan Perseorangan'),(81,'M_188','Jaminan Perusahaan'),(82,'M_188','Cash Defisit Guarantee'),(83,'M_218','dokumen bpjs'),(84,'M_218','ijin lokasi'),(85,'M_219','referensi bank'),(97,'M_219','SERTIFIKAT KOMINFO'),(100,'M_14','SIM'),(101,'M_219','kartu izin tinggal tetap'),(102,'M_219','kartu izin tinggal terbatas'),(107,'M_219','detail perusahaan'),(108,'M_219','dokumen pendukung'),(110,'M_219','profil perusahaan'),(112,'M_219','resi pembayaran'),(113,'M_218','kartu indonesia sehat'),(114,'M_219','surat izin lokasi'),(116,'M_218','SP3P'),(117,'M_219','daftar perseroan'),(118,'M_219','kesepakatan penyelesaian'),(119,'M_219','status pendirian pt'),(120,'M_219','bukti pesan nama'),(121,'M_219','syarat pendirian PT'),(122,'M_218','sertifikat'),(124,'M_218','tanda daftar usaha penyediaan akomodasi PMA'),(127,'M_243','Online Single Submission'),(128,'M_243','Jakevo'),(129,'M_243','Pelayanan Terpadu Satu Pintu (PTSP)'),(130,'M_243','Hak Tanggungan Elektronik (HTEL)'),(131,'M_243','Email /Gmail/Yahoo Dll'),(132,'M_218','Izin Prinsip Perubahan Penanaman Modal Asing'),(133,'M_250','Surat Kuasa'),(134,'M_254','Perubahan'),(135,'M_254','Pendirian'),(136,'M_254','Penyesuaian'),(137,'M_254','Pengesahan'),(138,'M_218','Izin Usaha Industri'),(139,'M_218','Izin Usaha Perusahaan Penyedia Jasa Pekerja / Buruh'),(141,'M_260','Curriculum Vitae'),(142,'M_260','Profil Perusahaan'),(143,'M_219','Laporan Keuangan / Neraca'),(144,'M_219','Data Direksi'),(145,'M_218','Izin Tempat Penampungan '),(146,'M_218','Izin Perusahaan Penempatan Pekerja Migran Indonesia'),(147,'M_250','Surat Keterangan Terdaftar'),(148,'M_250','Surat Pengunduran Diri'),(149,'M_250','Surat Penawaran Biaya Notaris'),(150,'M_250','Surat Keterangan'),(151,'M_250','Surat Keluar'),(152,'M_250','Surat Pernyataan'),(153,'M_250','Surat Perjanjian'),(154,'M_219','Surat Keputusan Umum'),(156,'M_250','Surat Permohonan'),(157,'M_250','Surat Pengesahan'),(158,'M_250','Surat Pencatatan'),(160,'M_250','Surat Persetujuan'),(162,'M_250','Surat Keputusan'),(164,'M_219','Nomor hp & Alamat email'),(165,'M_219','Konfirmasi Akun'),(166,'M_250','Surat Penetapan'),(167,'M_219','Izin Operasional'),(168,'M_250','Surat Pengukuhan'),(169,'M_250','Surat Pindah'),(170,'M_219','Formulir'),(172,'M_219','time planning'),(173,'M_254','Persetujuan'),(175,'M_218','Izin Usaha Jasa Kontruksi Nasional'),(176,'M_219','Neraca'),(177,'M_219','Rekening Koran'),(178,'M_219','Bukti Pembayaran'),(179,'M_219','Pemesanan Penjualan'),(183,'M_250','Surat Penunjukan Notaris'),(184,'M_250','Surat Jaminan'),(185,'M_250','Surat Perubahan'),(186,'M_250','Surat Setoran Pajak Daerah'),(187,'M_254','Penerimaan'),(188,'M_218','Faktur Pajak'),(189,'M_219','Invoice'),(190,'M_219','BPKB'),(191,'M_219','Pesanan Pembelian'),(192,'M_250','Surat Pemberitahuan'),(193,'M_219','Custodian'),(194,'M_250','Surat Keterlambatan Pengiriman Dokumen'),(195,'M_250','Surat Pengiriman Aset'),(196,'M_219','Pemesanan Layanan'),(197,'M_219','Pemesanan Pembayaran'),(198,'M_219','Perjanjian Kerja Sama'),(199,'M_250','Surat Kontrak Tambahan'),(200,'M_250','Surat Penunjukan Notaris'),(201,'M_250','Surat Setoran Pajak'),(203,'M_219','Kesepakatan'),(204,'M_219','Pakta Integritas'),(205,'M_250','Penyampaian Keputusan Pemegang Saham'),(206,'M_219','Syarat Perjanjian Kredit'),(207,'M_219','Daftar Piutang'),(208,'M_219','Peraturan Menteri'),(209,'M_218','Izin Usaha'),(210,'M_219','Kartu Herregistrasi'),(211,'M_250','Surat Perizinan'),(212,'M_219','Daftar Riwayat Hidup'),(213,'M_219','Daftar Kompetensi'),(214,'M_250','Surat Pengangkatan'),(215,'M_250','Surat Pengantar'),(216,'M_250','Surat Pembiayaan Modal'),(217,'M_250','Surat Pemberhentian'),(218,'M_250','Surat Perintah'),(219,'M_250','Surat Saham'),(220,'M_250','Pemasangan Hak Tanggungan'),(221,'M_250','Surat Catatan'),(222,'M_219','Bukti Penerimaan Surat'),(223,'M_250','Surat Undangan'),(224,'M_219','Email'),(225,'M_219','Hubungan Afiliasi'),(226,'M_219','Lembar Sidik Jari'),(227,'M_219','Time Charter'),(228,'M_218','Izin Prinsip Penanaman Modal Asing');
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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_jenis_pekerjaan`
--

LOCK TABLES `data_jenis_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_jenis_pekerjaan` DISABLE KEYS */;
INSERT INTO `data_jenis_pekerjaan` VALUES (1,'J_0001','NOTARIS','Akta pendirian Perseroan Terbatas ( PT )','2019-05-09 02:28:49.878210','Admin'),(2,'J_0002','NOTARIS','Akta perubahan perseroan terbatas ( PT )','2020-02-03 06:55:50.025810','Admin'),(3,'J_0003','NOTARIS','Akta pendirian CV','2019-03-05 06:30:13.576017','Dedy Ibrahim'),(4,'J_0004','NOTARIS','Akta perubahan CV','2019-03-05 06:30:31.712436','Dedy Ibrahim'),(5,'J_0005','NOTARIS','Akta pendirian Firma','2019-03-05 06:31:49.696745','Dedy Ibrahim'),(6,'J_0006','NOTARIS','Akta perubahan Firma','2019-03-05 06:32:10.476590','Dedy Ibrahim'),(7,'J_0007','NOTARIS','Akta pendirian Koperasi','2019-03-05 06:33:01.350481','Dedy Ibrahim'),(8,'J_0008','NOTARIS','Akta perubahan Koperasi','2019-03-05 06:33:23.456080','Dedy Ibrahim'),(9,'J_0009','NOTARIS','Akta pendirian Yayasan','2019-03-05 06:37:31.682419','Dedy Ibrahim'),(10,'J_0010','NOTARIS','Akta perubahan Yayasan','2019-03-05 06:37:55.661141','Dedy Ibrahim'),(11,'J_0011','NOTARIS','Akta pendirian Perkumpulan','2019-03-05 06:38:39.618898','Dedy Ibrahim'),(12,'J_0012','NOTARIS','Akta perubahan Perkumpulan','2019-03-05 06:39:10.083953','Dedy Ibrahim'),(13,'J_0013','NOTARIS','Akta Pengakuan Hutang','2019-05-10 08:00:30.135319','Admin'),(14,'J_0014','NOTARIS','Akta Perjanjian Kawin','2019-05-10 08:00:07.451262','Admin'),(15,'J_0015','NOTARIS','Akta Perjanjian Pengikatan Jual Beli','2019-05-10 07:59:55.616911','Admin'),(16,'J_0016','NOTARIS','Akta Perjanjian Sewa Menyewa','2019-05-10 07:59:34.878470','Admin'),(17,'J_0017','NOTARIS','Akta Perjanjian Kerjasama','2019-05-10 07:59:16.773705','Admin'),(18,'J_0018','NOTARIS','Akta Perjanjian Kredit','2019-05-10 07:59:02.510424','Admin'),(20,'J_0019','NOTARIS','Akta Jual Beli Saham','2019-05-10 08:01:41.496718','Admin'),(21,'J_0020','NOTARIS','Akta Wasiat','2019-03-05 06:46:23.085321','Dedy Ibrahim'),(22,'J_0021','NOTARIS','Akta Corporate Guarantee','2019-05-10 08:03:50.450134','Admin'),(23,'J_0022','NOTARIS','Akta Personal Guarantee','2019-05-10 07:58:05.157704','Admin'),(24,'J_0023','NOTARIS','Akta Fidusia','2019-03-05 06:50:46.733389','Dedy Ibrahim'),(25,'J_0024','NOTARIS','Akta pekerjaan','2019-10-17 06:56:27.898912','Admin'),(27,'J_0025','NOTARIS','Akta Kuasa Untuk Menjual','2019-05-10 08:04:14.961903','Admin'),(28,'J_0026','NOTARIS','Waarmerking Dokumen','2019-05-10 07:57:25.277177','Admin'),(29,'J_0027','NOTARIS','Legalisasi Dokumen','2019-05-10 07:39:37.393049','Admin'),(30,'J_0028','PPAT','Akta Jual Beli (AJB)','2019-05-10 07:37:43.689411','Admin'),(31,'J_0029','PPAT','Akta Hibah','2019-05-10 07:37:22.904901','Admin'),(32,'J_0030','PPAT','Akta Tukar Menukar','2019-05-10 07:37:06.312726','Admin'),(33,'J_0031','PPAT','Akta Pembagian Hak Bersama (APHB)','2019-05-10 07:36:30.910911','Admin'),(34,'J_0032','NOTARIS','Akta Surat Kuasa Memberikan Hak Tanggungan (SKMHT)','2019-05-10 07:35:05.180965','Admin'),(35,'J_0033','PPAT','Akta Pemberian Hak Tanggungan (APHT)','2019-05-15 05:56:54.040414','Admin'),(36,'J_0034','NOTARIS','Akta Pernyataan (WARIS)','2019-05-10 08:45:35.985455','Admin'),(37,'J_0035','NOTARIS','Akta Pendirian PT PMA','2019-07-23 13:44:13.825399','Admin'),(38,'J_0036','NOTARIS','Akta Perubahan Perjanjian kredit','2019-08-29 07:55:22.266661','Admin'),(39,'J_0037','NOTARIS','Akta Adendum Perjanjian Kredit ','2019-09-17 02:23:59.105274','Admin'),(40,'J_0038','NOTARIS','Balik Nama Waris','2019-10-18 07:11:43.345348','Admin'),(41,'J_0039','NOTARIS','Pecah Sertifikat','2019-10-18 07:14:41.775255','Admin'),(42,'J_0040','NOTARIS','Peningkatan Hak','2019-10-18 07:15:44.876684','Admin'),(43,'J_0041','NOTARIS','Penurunan Hak','2019-10-18 07:17:05.775364','Admin'),(44,'J_0042','NOTARIS','Roya Sertifikat','2019-11-13 02:07:58.248879','Admin'),(46,'J_0044','NOTARIS','Akta Perjanjian Utang Piutang','2020-01-24 02:32:33.643394','Admin'),(47,'J_0045','NOTARIS','Akta Perpanjangan Perjanjian Sewa Menyewa','2020-01-15 02:58:52.542032','Admin');
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
  `jenis_bilangan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_meta`),
  KEY `no_nama_dokumen` (`no_nama_dokumen`),
  KEY `id_data_meta` (`id_data_meta`),
  CONSTRAINT `data_meta_ibfk_1` FOREIGN KEY (`no_nama_dokumen`) REFERENCES `nama_dokumen` (`no_nama_dokumen`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=284 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_meta`
--

LOCK TABLES `data_meta` WRITE;
/*!40000 ALTER TABLE `data_meta` DISABLE KEYS */;
INSERT INTO `data_meta` VALUES (11,'M_1','N_0006','Tanggal lahir','date','100',''),(12,'M_12','N_0006','Tempat','text','100',''),(13,'M_13','N_0006','No Identitas','text','100',''),(14,'M_14','N_0006','Jenis Identitas','select','100',''),(33,'M_33','N_0078','No Akte','text','100',''),(45,'M_34','N_0078','Nama Sertifikat','text','100',''),(46,'M_46','N_0078','No Sertifikat','text','100',''),(47,'M_47','N_0077','Jenis Pajak','select','100',''),(48,'M_48','N_0077','No Validasi','text','100',''),(52,'M_52','N_0055','Nama surat persetujuan','text','100',''),(53,'M_53','N_0054','Jenis Jaminan','select','100',''),(54,'M_54','N_0054','No Sertifikat','text','100',''),(58,'M_58','N_0052','Nama surat','text','100',''),(59,'M_59','N_0052','No surat','text','100',''),(60,'M_60','N_0051','Nama surat','text','100',''),(61,'M_61','N_0051','No surat','text','100',''),(62,'M_62','N_0050','Nama surat','text','100',''),(63,'M_63','N_0050','No surat','text','100',''),(66,'M_66','N_0048','Jumlah kekayaan','text','100',''),(67,'M_67','N_0048','Jenis Kekayaan','select','100',''),(68,'M_68','N_0047','Maksud dan tujuan rapat','text','100',''),(69,'M_69','N_0046','Maksud dan tujuan Bar','text','300',''),(70,'M_70','N_0045','Nama Pengurus','text','300',''),(71,'M_71','N_0045','Nama Penasehat','text','100',''),(72,'M_72','N_0045','Nama Pengawas','text','300',''),(73,'M_73','N_0044','Nama Badan Hukum','text','100',''),(86,'M_86','N_0037','Nama Badan Hukum','select','100',''),(92,'M_92','N_0034','Jenis Dokumen','select','100',''),(93,'M_93','N_0033','Jenis Dokumen','select','100',''),(94,'M_94','N_0032','Jenis Dokumen','text','100',''),(95,'M_95','N_0031','No Surat','text','100',''),(96,'M_96','N_0031','Nama Asal','text','100',''),(97,'M_97','N_0031','Nama Sekarang','text','100',''),(99,'M_99','N_0029','Nomor NIB','text','100',''),(100,'M_100','N_0028','Tanggal Dikerluarkan','date','100',''),(101,'M_101','N_0028','No Surat','text','100',''),(102,'M_102','N_0028','Nama Ahli Waris','text','100',''),(103,'M_103','N_0028','Nama','text','100',''),(104,'M_104','N_0027','Nama','text','100',''),(105,'M_105','N_0027','Tanggal Kematian','date','100',''),(106,'M_106','N_0027','No Surat Kematian','text','100',''),(107,'M_107','N_0027','Nama Institusi','text','100',''),(108,'M_108','N_0027','Tanggal Surat kematian','date','100',''),(109,'M_109','N_0026','Nama Dokumen Warmeking','text','100',''),(110,'M_110','N_0025','No BAR','text','100',''),(111,'M_111','N_0025','Maksud dan tujuan BAR','text','300',''),(112,'M_112','N_0024','Fotocopy Deposito','text','100',''),(114,'M_114','N_0022','No Induk','text','100',''),(116,'M_115','N_0022','Jenis Koperasi','text','100',''),(117,'M_117','N_0019','Tempat lahir','text','100',''),(118,'M_118','N_0019','Tanggal lahir','date','100',''),(119,'M_119','N_0019','No Surat','text','100',''),(120,'M_120','N_0018','Tanggal IMB','date','100',''),(121,'M_121','N_0018','No IMB','text','100',''),(122,'M_122','N_0018','Pejabat yang mengeluarkan','text','100',''),(123,'M_123','N_0017','No Obyek Pajak NOP','text','100',''),(126,'M_126','N_0015','Nama Pejabat','text','100',''),(127,'M_127','N_0015','Persetujuan PT','text','100',''),(128,'M_128','N_0015','Jenis Fidusia','text','100',''),(133,'M_133','N_0013','No Surat','text','200',''),(134,'M_134','N_0013','Nama Komisaris','text','100',''),(135,'M_135','N_0013','Tanggal Surat','text','200',''),(136,'M_136','N_0011','No Sertifikat','text','200',''),(137,'M_137','N_0011','Luas Tanah','text','100',''),(138,'M_138','N_0011','Lokasi','text','100',''),(139,'M_139','N_0010','Nama KK','text','100',''),(140,'M_140','N_0010','No KK','text','100',''),(141,'M_141','N_0009','No Akte','text','100',''),(142,'M_142','N_0009','No SK / KP','text','100',''),(145,'M_145','N_0008','Jenis RUPS','select','100',''),(146,'M_146','N_0007','No SP','text','100',''),(147,'M_147','N_0007','Nama PT','text','100',''),(148,'M_148','N_0005','No surat','text','100',''),(149,'M_149','N_0005','Nama Badan Hukum','text','100',''),(150,'M_150','N_0004','No TDP','text','100',''),(151,'M_151','N_0004','Nama Badan Hukum','text','100',''),(152,'M_152','N_0001','No SIUP','text','100',''),(153,'M_153','N_0001','Nama Badan Hukum','text','100',''),(156,'M_154','N_0043','Jenis Mata Uang','select','100',''),(157,'M_157','N_0043','Modal dasar','number','100','Desimal'),(159,'M_159','N_0037','Alamat lengkap','textarea','3000','Pilih Jenis Bilangan'),(161,'M_160','N_0043','Modal disetor dan ditempatkan','number','100','Desimal'),(162,'M_162','N_0079','Nama Bank','text','100','Pilih Jenis Bilangan'),(163,'M_163','N_0079','Nama Nasabah  Debitur','text','100','undefined'),(165,'M_165','N_0079','Jenis Jaminan','select','100','undefined'),(166,'M_166','N_0079','Jangka Waktu Kredit','text','100','undefined'),(167,'M_167','N_0080','Nama Bank','text','100','undefined'),(168,'M_168','N_0080','Nama Nasabah Debitur','text','100','undefined'),(169,'M_169','N_0080','Jumlah  Hutang','number','100','Bulat'),(170,'M_170','N_0080','Jenis Jaminan','select','100','undefined'),(171,'M_171','N_0080','Jangka Waktu Kredit','text','100','undefined'),(172,'M_172','N_0081','Nama Bank','text','100','undefined'),(173,'M_173','N_0081','Nama Nasabah Debitur','text','100','undefined'),(175,'M_175','N_0081','Jenis Jaminan','select','100','undefined'),(178,'M_177','N_0081','Pemberi Jaminan','text','100','undefined'),(186,'M_186','N_0083','Nama Nasabah Debitur','text','100','undefined'),(188,'M_188','N_0083','Jenis Jaminan','select','100','undefined'),(190,'M_190','N_0083','Pemberi Jaminan','text','100','undefined'),(191,'M_191','N_0083','Nama Bank','text','100','undefined'),(192,'M_192','N_0083','Jumlah Hutang','number','100','Desimal'),(197,'M_197','N_0080','Jumlah Hutang','number','100','Desimal'),(198,'M_198','N_0079','Jumlah Hutang','number','100','Desimal'),(199,'M_199','N_0081','Jumlah Hutang','number','100','Desimal'),(200,'M_200','N_0085','No NPWP','number','100','Bulat'),(201,'M_201','N_0086','Nama suami','text','100','undefined'),(202,'M_202','N_0086','Nama Istri','text','100','undefined'),(203,'M_203','N_0087','No surat','text','100','Pilih Jenis Bilangan'),(205,'M_205','N_0087','Nama pemberi kuasa','text','100','undefined'),(206,'M_206','N_0055','Nama saudara','text','100','Pilih Jenis Bilangan'),(207,'M_207','N_0055','Status saudara ','text','100','undefined'),(208,'M_208','N_0087','Tanggal surat','date','100','Pilih Jenis Bilangan'),(210,'M_210','N_0088','No Surat','text','100','undefined'),(211,'M_211','N_0090','Nama Foto','text','100','Pilih Jenis Bilangan'),(212,'M_212','N_0092','No Akta','text','100','Pilih Jenis Bilangan'),(213,'M_213','N_0091','No Surat','text','100','undefined'),(214,'M_214','N_0093','Nominal Transfer','number','100','Desimal'),(215,'M_215','N_0094','Jenis Cover Note ','text','100','undefined'),(216,'M_216','N_0095','Jumlah Nominal','number','100','Desimal'),(217,'M_217','N_0096','nama note','text','100','Pilih Jenis Bilangan'),(218,'M_218','N_0097','jenis dokumen','select','100','Pilih Jenis Bilangan'),(219,'M_219','N_0098','jenis dokumen','select','100','undefined'),(221,'M_221','N_0099','TANGGAL','date','100','undefined'),(237,'M_236','N_0023','TANGGAL RAPAT','date','100','undefined'),(242,'M_241','N_0113','Kode Nomor','text','100',NULL),(243,'M_243','N_0110','Jenis Akun','select','100',NULL),(244,'M_244','N_0110','Username / Email','text','100',NULL),(245,'M_245','N_0110','Password','text','100',NULL),(247,'M_246','N_0109','Tanggal Pengumuman','date','100',NULL),(249,'M_248','N_0097','Nomor Perizinan','text','100',NULL),(250,'M_250','N_0108','Jenis Surat','select','100',NULL),(251,'M_251','N_0108','Nomor Surat','text','100',NULL),(253,'M_253','N_0106','Nama Penerima','text','100',NULL),(254,'M_254','N_0105','Jenis Berita Negara','select','100',NULL),(256,'M_256','N_0102','Tanggal','date','100',NULL),(257,'M_257','N_0102','Periode','text','100',NULL),(258,'M_258','N_0101','Nomor Surat','text','100',NULL),(259,'M_259','N_0100','Nomor Surat','text','100',NULL),(260,'M_260','N_0112','Jenis Dokumen','select','100',NULL),(261,'M_261','N_0120','Judul Anggaran Dasar','text','100',NULL),(263,'M_262','N_0121','Judul Anggaran Dasar','text','200',NULL),(264,'M_264','N_0122','Nomor Pesanan','text','100',NULL),(265,'M_265','N_0123','Tanggal','date','100',NULL),(266,'M_266','N_0023','Jumlah peserta','number','100','Bulat'),(268,'M_267','N_0104','Jenis Laporan','text','100',NULL),(270,'M_269','N_0040','Periode','text','100',NULL),(271,'M_271','N_0107','Jenis Lampiran','text','100',NULL),(272,'M_272','N_0124','Tanggal IPB','date','100',NULL),(273,'M_273','N_0124','Nomor IPB','text','100',NULL),(274,'M_274','N_0124','Pejabat Yang Mmengeluarkan','text','100',NULL),(275,'M_275','N_0127','No Rekening','text','100',NULL),(276,'M_276','N_0127','Nama Pemilik Rekening','text','100',NULL),(277,'M_277','N_0106','Tanggal','date','100',NULL),(279,'M_278','N_0130','Nomor','text','100',NULL),(280,'M_280','N_0130','Nama Badan Hukum','text','100',NULL),(281,'M_281','N_0134','Tanggal','date','100',NULL),(282,'M_282','N_0134','Agenda','text','200',NULL),(283,'M_283','N_0089','No Sertifikat','text','100',NULL);
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
  `no_loker` varchar(100) DEFAULT NULL,
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
  KEY `no_loker` (`no_loker`),
  CONSTRAINT `data_pekerjaan_ibfk_1` FOREIGN KEY (`no_client`) REFERENCES `data_client` (`no_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `data_pekerjaan_ibfk_2` FOREIGN KEY (`no_jenis_pekerjaan`) REFERENCES `data_jenis_pekerjaan` (`no_jenis_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_pekerjaan`
--

LOCK TABLES `data_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_pekerjaan` DISABLE KEYS */;
INSERT INTO `data_pekerjaan` VALUES (1,'C000001','P000001','J_0001','','0004','ArsipSelesai','2020/02/27','28/02/2020','Prima Yuddy F Y','','2020/02/27'),(2,'C000001','P000002','J_0004','','0004','ArsipProses','2020/02/27',NULL,'Prima Yuddy F Y','','2020/02/27');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_pemilik`
--

LOCK TABLES `data_pemilik` WRITE;
/*!40000 ALTER TABLE `data_pemilik` DISABLE KEYS */;
INSERT INTO `data_pemilik` VALUES (1,'PK000000','C000001','P000001'),(2,'PK000001','C000001','P000002'),(3,'PK000002','C000002','P000001');
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
) ENGINE=InnoDB AUTO_INCREMENT=677 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_persyaratan`
--

LOCK TABLES `data_persyaratan` WRITE;
/*!40000 ALTER TABLE `data_persyaratan` DISABLE KEYS */;
INSERT INTO `data_persyaratan` VALUES (8,'N_0006','J_0027'),(9,'N_0032','J_0027'),(10,'N_0026','J_0026'),(11,'N_0006','J_0026'),(12,'N_0032','J_0026'),(26,'N_0006','J_0025'),(28,'N_0010','J_0025'),(33,'N_0011','J_0025'),(34,'N_0017','J_0025'),(35,'N_0018','J_0025'),(39,'N_0011','J_0032'),(40,'N_0017','J_0032'),(41,'N_0018','J_0032'),(42,'N_0006','J_0032'),(47,'N_0010','J_0032'),(48,'N_0009','J_0032'),(49,'N_0005','J_0032'),(50,'N_0029','J_0032'),(52,'N_0008','J_0032'),(53,'N_0013','J_0032'),(55,'N_0009','J_0025'),(56,'N_0005','J_0025'),(57,'N_0029','J_0025'),(58,'N_0008','J_0025'),(59,'N_0013','J_0025'),(61,'N_0006','J_0024'),(62,'N_0010','J_0024'),(68,'N_0027','J_0034'),(70,'N_0019','J_0034'),(71,'N_0010','J_0034'),(73,'N_0033','J_0024'),(74,'N_0006','J_0021'),(75,'N_0031','J_0034'),(76,'N_0006','J_0023'),(77,'N_0009','J_0023'),(78,'N_0005','J_0023'),(79,'N_0015','J_0023'),(80,'N_0032','J_0023'),(83,'N_0004','J_0023'),(85,'N_0006','J_0022'),(86,'N_0010','J_0022'),(90,'N_0013','J_0023'),(91,'N_0008','J_0023'),(92,'N_0008','J_0022'),(93,'N_0009','J_0022'),(95,'N_0005','J_0021'),(96,'N_0009','J_0021'),(97,'N_0008','J_0021'),(98,'N_0013','J_0021'),(101,'N_0006','J_0018'),(103,'N_0009','J_0018'),(104,'N_0008','J_0018'),(105,'N_0013','J_0018'),(107,'N_0005','J_0018'),(110,'N_0018','J_0018'),(112,'N_0029','J_0021'),(113,'N_0006','J_0020'),(114,'N_0019','J_0020'),(115,'N_0027','J_0020'),(116,'N_0010','J_0020'),(117,'N_0034','J_0020'),(118,'N_0006','J_0019'),(119,'N_0010','J_0019'),(122,'N_0009','J_0019'),(123,'N_0029','J_0019'),(125,'N_0008','J_0019'),(126,'N_0013','J_0019'),(127,'N_0006','J_0016'),(128,'N_0010','J_0016'),(131,'N_0011','J_0016'),(132,'N_0017','J_0016'),(133,'N_0018','J_0016'),(134,'N_0009','J_0016'),(135,'N_0029','J_0016'),(137,'N_0006','J_0015'),(138,'N_0010','J_0015'),(141,'N_0011','J_0015'),(142,'N_0017','J_0015'),(143,'N_0018','J_0015'),(144,'N_0009','J_0015'),(145,'N_0029','J_0015'),(147,'N_0008','J_0015'),(148,'N_0013','J_0015'),(149,'N_0008','J_0016'),(150,'N_0013','J_0016'),(151,'N_0006','J_0017'),(152,'N_0010','J_0017'),(155,'N_0009','J_0017'),(156,'N_0029','J_0017'),(158,'N_0008','J_0017'),(159,'N_0013','J_0017'),(161,'N_0006','J_0014'),(163,'N_0010','J_0013'),(166,'N_0009','J_0013'),(167,'N_0029','J_0013'),(169,'N_0008','J_0013'),(170,'N_0013','J_0013'),(172,'N_0006','J_0013'),(174,'N_0006','J_0012'),(178,'N_0009','J_0012'),(179,'N_0005','J_0012'),(182,'N_0046','J_0012'),(184,'N_0006','J_0011'),(186,'N_0045','J_0011'),(188,'N_0048','J_0011'),(189,'N_0037','J_0011'),(191,'N_0006','J_0010'),(193,'N_0009','J_0010'),(194,'N_0005','J_0010'),(196,'N_0047','J_0010'),(197,'N_0006','J_0009'),(203,'N_0037','J_0009'),(204,'N_0048','J_0009'),(208,'N_0006','J_0008'),(210,'N_0009','J_0008'),(212,'N_0025','J_0008'),(214,'N_0006','J_0007'),(217,'N_0037','J_0007'),(218,'N_0048','J_0007'),(225,'N_0006','J_0006'),(227,'N_0009','J_0006'),(228,'N_0005','J_0006'),(230,'N_0004','J_0006'),(232,'N_0006','J_0005'),(235,'N_0037','J_0005'),(237,'N_0040','J_0005'),(238,'N_0043','J_0005'),(239,'N_0006','J_0004'),(241,'N_0009','J_0004'),(242,'N_0005','J_0004'),(244,'N_0004','J_0004'),(246,'N_0006','J_0003'),(248,'N_0037','J_0003'),(249,'N_0043','J_0003'),(250,'N_0044','J_0003'),(251,'N_0050','J_0011'),(252,'N_0052','J_0011'),(253,'N_0050','J_0009'),(254,'N_0051','J_0012'),(255,'N_0051','J_0010'),(256,'N_0050','J_0007'),(258,'N_0022','J_0008'),(259,'N_0006','J_0002'),(261,'N_0009','J_0002'),(262,'N_0029','J_0002'),(264,'N_0008','J_0002'),(267,'N_0006','J_0001'),(270,'N_0037','J_0001'),(271,'N_0043','J_0001'),(272,'N_0040','J_0001'),(277,'N_0005','J_0022'),(279,'N_0004','J_0022'),(280,'N_0029','J_0022'),(281,'N_0029','J_0018'),(282,'N_0054','J_0018'),(286,'N_0037','J_0035'),(288,'N_0043','J_0035'),(289,'N_0040','J_0035'),(291,'N_0050','J_0035'),(292,'N_0009','J_0035'),(294,'N_0007','J_0035'),(295,'N_0006','J_0030'),(296,'N_0010','J_0030'),(299,'N_0011','J_0030'),(300,'N_0017','J_0030'),(301,'N_0018','J_0030'),(303,'N_0006','J_0029'),(304,'N_0010','J_0029'),(305,'N_0019','J_0029'),(309,'N_0011','J_0029'),(310,'N_0017','J_0029'),(311,'N_0018','J_0029'),(313,'N_0055','J_0029'),(314,'N_0006','J_0028'),(315,'N_0010','J_0028'),(317,'N_0017','J_0028'),(318,'N_0018','J_0028'),(320,'N_0011','J_0028'),(322,'N_0006','J_0033'),(323,'N_0010','J_0033'),(324,'N_0011','J_0033'),(325,'N_0017','J_0033'),(326,'N_0009','J_0033'),(330,'N_0006','J_0031'),(331,'N_0010','J_0031'),(333,'N_0011','J_0031'),(334,'N_0017','J_0031'),(335,'N_0019','J_0031'),(337,'N_0018','J_0033'),(338,'N_0018','J_0031'),(340,'N_0006','J_0035'),(341,'N_0006','J_0034'),(342,'N_0013','J_0001'),(344,'N_0029','J_0035'),(345,'N_0009','J_0028'),(346,'N_0005','J_0028'),(347,'N_0004','J_0028'),(348,'N_0001','J_0028'),(350,'N_0008','J_0028'),(351,'N_0013','J_0028'),(354,'N_0077','J_0028'),(358,'N_0009','J_0037'),(359,'N_0005','J_0037'),(360,'N_0001','J_0037'),(361,'N_0013','J_0037'),(362,'N_0008','J_0037'),(363,'N_0006','J_0037'),(364,'N_0079','J_0037'),(366,'N_0083','J_0037'),(368,'N_0080','J_0037'),(369,'N_0081','J_0037'),(370,'N_0085','J_0028'),(371,'N_0086','J_0028'),(372,'N_0031','J_0028'),(373,'N_0028','J_0028'),(374,'N_0027','J_0028'),(375,'N_0055','J_0028'),(377,'N_0085','J_0029'),(381,'N_0031','J_0029'),(382,'N_0027','J_0029'),(383,'N_0028','J_0029'),(384,'N_0077','J_0029'),(385,'N_0087','J_0028'),(386,'N_0011','J_0038'),(387,'N_0017','J_0038'),(388,'N_0006','J_0038'),(389,'N_0010','J_0038'),(390,'N_0019','J_0038'),(391,'N_0085','J_0038'),(392,'N_0027','J_0038'),(393,'N_0028','J_0038'),(394,'N_0086','J_0038'),(395,'N_0006','J_0039'),(396,'N_0010','J_0039'),(397,'N_0011','J_0039'),(398,'N_0017','J_0039'),(399,'N_0006','J_0040'),(400,'N_0010','J_0040'),(401,'N_0011','J_0040'),(402,'N_0017','J_0040'),(403,'N_0006','J_0041'),(404,'N_0010','J_0041'),(405,'N_0011','J_0041'),(406,'N_0017','J_0041'),(407,'N_0078','J_0028'),(408,'N_0006','J_0042'),(409,'N_0087','J_0042'),(410,'N_0011','J_0042'),(411,'N_0089','J_0042'),(412,'N_0088','J_0042'),(413,'N_0017','J_0042'),(414,'N_0086','J_0029'),(415,'N_0019','J_0028'),(416,'N_0090','J_0028'),(420,'N_0085','J_0001'),(421,'N_0090','J_0029'),(422,'N_0092','J_0029'),(423,'N_0091','J_0029'),(424,'N_0091','J_0028'),(425,'N_0093','J_0028'),(426,'N_0086','J_0032'),(427,'N_0090','J_0032'),(428,'N_0085','J_0032'),(429,'N_0089','J_0032'),(430,'N_0080','J_0032'),(431,'N_0087','J_0032'),(432,'N_0094','J_0032'),(433,'N_0095','J_0028'),(434,'N_0090','J_0001'),(435,'N_0040','J_0001'),(436,'N_0009','J_0001'),(437,'N_0004','J_0001'),(438,'N_0005','J_0001'),(439,'N_0096','J_0001'),(440,'N_0008','J_0001'),(441,'N_0097','J_0001'),(442,'N_0098','J_0001'),(444,'N_0001','J_0001'),(445,'N_0023','J_0007'),(446,'N_0099','J_0007'),(447,'N_0008','J_0007'),(448,'N_0045','J_0001'),(449,'N_0009','J_0001'),(452,'N_0040','J_0007'),(453,'N_0009','J_0007'),(455,'N_0005','J_0007'),(456,'N_0100','J_0007'),(457,'N_0101','J_0007'),(458,'N_0102','J_0009'),(459,'N_0102','J_0007'),(460,'N_0103','J_0007'),(461,'N_0104','J_0007'),(462,'N_0085','J_0007'),(463,'N_0105','J_0002'),(464,'N_0085','J_0002'),(465,'N_0106','J_0002'),(466,'N_0098','J_0002'),(467,'N_0105','J_0001'),(468,'N_0107','J_0001'),(469,'N_0108','J_0001'),(470,'N_0109','J_0001'),(471,'N_0110','J_0001'),(472,'N_0005','J_0002'),(473,'N_0108','J_0002'),(474,'N_0107','J_0002'),(475,'N_0032','J_0001'),(476,'N_0011','J_0044'),(477,'N_0111','J_0044'),(479,'N_0093','J_0001'),(481,'N_0104','J_0001'),(482,'N_0112','J_0001'),(483,'N_0010','J_0001'),(484,'N_0050','J_0001'),(485,'N_0087','J_0016'),(486,'N_0106','J_0001'),(487,'N_0113','J_0001'),(488,'N_0008','J_0029'),(489,'N_0009','J_0029'),(490,'N_0108','J_0029'),(492,'N_0033','J_0029'),(493,'N_0098','J_0002'),(494,'N_0005','J_0002'),(495,'N_0029','J_0001'),(496,'N_0087','J_0001'),(497,'N_0023','J_0001'),(498,'N_0078','J_0029'),(499,'N_0092','J_0001'),(500,'N_0092','J_0002'),(502,'N_0010','J_0007'),(503,'N_0001','J_0007'),(504,'N_0106','J_0007'),(505,'N_0098','J_0007'),(507,'N_0010','J_0002'),(508,'N_0006','J_0045'),(509,'N_0010','J_0045'),(510,'N_0011','J_0045'),(511,'N_0017','J_0045'),(512,'N_0018','J_0045'),(514,'N_0009','J_0045'),(515,'N_0029','J_0045'),(516,'N_0008','J_0045'),(517,'N_0013','J_0045'),(518,'N_0087','J_0045'),(519,'N_0086','J_0045'),(520,'N_0085','J_0045'),(521,'N_0011','J_0001'),(522,'N_0005','J_0045'),(523,'N_0005','J_0016'),(524,'N_0105','J_0001'),(525,'N_0085','J_0016'),(526,'N_0001','J_0016'),(527,'N_0004','J_0016'),(529,'N_0116','J_0001'),(530,'N_0099','J_0001'),(531,'N_0117','J_0001'),(532,'N_0090','J_0002'),(533,'N_0040','J_0002'),(534,'N_0118','J_0002'),(536,'N_0085','J_0009'),(537,'N_0105','J_0009'),(538,'N_0098','J_0009'),(539,'N_0009','J_0009'),(540,'N_0104','J_0002'),(541,'N_0097','J_0002'),(544,'N_0108','J_0007'),(546,'N_0095','J_0007'),(547,'N_0011','J_0007'),(548,'N_0097','J_0007'),(549,'N_0100','J_0001'),(550,'N_0053','J_0001'),(551,'N_0095','J_0001'),(552,'N_0018','J_0001'),(553,'N_0019','J_0001'),(554,'N_0098','J_0019'),(555,'N_0108','J_0019'),(556,'N_0085','J_0019'),(557,'N_0106','J_0019'),(558,'N_0097','J_0019'),(560,'N_0043','J_0002'),(561,'N_0110','J_0002'),(562,'N_0112','J_0002'),(563,'N_0085','J_0012'),(564,'N_0120','J_0012'),(565,'N_0008','J_0012'),(566,'N_0108','J_0012'),(567,'N_0099','J_0012'),(568,'N_0023','J_0012'),(570,'N_0121','J_0012'),(571,'N_0121','J_0011'),(572,'N_0008','J_0011'),(573,'N_0113','J_0011'),(574,'N_0029','J_0011'),(575,'N_0085','J_0011'),(576,'N_0009','J_0011'),(577,'N_0108','J_0011'),(578,'N_0122','J_0011'),(579,'N_0123','J_0011'),(580,'N_0098','J_0011'),(581,'N_0004','J_0008'),(582,'N_0001','J_0008'),(583,'N_0085','J_0008'),(584,'N_0005','J_0008'),(585,'N_0023','J_0008'),(586,'N_0099','J_0008'),(587,'N_0108','J_0008'),(588,'N_0098','J_0008'),(591,'N_0104','J_0008'),(592,'N_0086','J_0016'),(593,'N_0108','J_0016'),(594,'N_0040','J_0008'),(595,'N_0018','J_0008'),(596,'N_0113','J_0002'),(597,'N_0011','J_0002'),(598,'N_0018','J_0002'),(600,'N_0124','J_0002'),(601,'N_0122','J_0001'),(602,'N_0019','J_0002'),(603,'N_0086','J_0002'),(604,'N_0085','J_0003'),(605,'N_0004','J_0003'),(606,'N_0108','J_0003'),(607,'N_0001','J_0003'),(608,'N_0090','J_0003'),(609,'N_0010','J_0003'),(610,'N_0005','J_0003'),(611,'N_0098','J_0003'),(614,'N_0001','J_0002'),(615,'N_0004','J_0002'),(616,'N_0127','J_0001'),(617,'N_0128','J_0002'),(618,'N_0127','J_0002'),(619,'N_0100','J_0002'),(620,'N_0105','J_0019'),(621,'N_0004','J_0019'),(622,'N_0005','J_0019'),(623,'N_0107','J_0019'),(624,'N_0015','J_0002'),(625,'N_0077','J_0002'),(626,'N_0093','J_0002'),(627,'N_0006','J_0036'),(628,'N_0098','J_0036'),(629,'N_0107','J_0036'),(630,'N_0108','J_0036'),(631,'N_0008','J_0036'),(632,'N_0011','J_0036'),(633,'N_0089','J_0036'),(634,'N_0009','J_0036'),(635,'N_0010','J_0042'),(636,'N_0108','J_0042'),(637,'N_0015','J_0036'),(638,'N_0085','J_0036'),(639,'N_0086','J_0036'),(640,'N_0105','J_0036'),(641,'N_0127','J_0036'),(642,'N_0005','J_0036'),(643,'N_0018','J_0036'),(644,'N_0097','J_0036'),(645,'N_0001','J_0036'),(646,'N_0010','J_0036'),(647,'N_0095','J_0036'),(648,'N_0106','J_0036'),(649,'N_0004','J_0036'),(650,'N_0077','J_0036'),(651,'N_0085','J_0023'),(652,'N_0105','J_0023'),(653,'N_0098','J_0023'),(654,'N_0097','J_0023'),(655,'N_0108','J_0023'),(656,'N_0106','J_0023'),(657,'N_0130','J_0002'),(658,'N_0134','J_0002'),(659,'N_0089','J_0002'),(660,'N_0086','J_0023'),(661,'N_0010','J_0023'),(662,'N_0107','J_0023'),(663,'N_0011','J_0023'),(664,'N_0001','J_0023'),(665,'N_0130','J_0023'),(666,'N_0089','J_0023'),(667,'N_0085','J_0018'),(668,'N_0086','J_0018'),(669,'N_0010','J_0018'),(670,'N_0108','J_0018'),(671,'N_0097','J_0018'),(672,'N_0098','J_0018'),(673,'N_0001','J_0018'),(674,'N_0004','J_0018'),(675,'N_0105','J_0018'),(676,'N_0107','J_0018');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_progress_pekerjaan`
--

LOCK TABLES `data_progress_pekerjaan` WRITE;
/*!40000 ALTER TABLE `data_progress_pekerjaan` DISABLE KEYS */;
INSERT INTO `data_progress_pekerjaan` VALUES (4,'P000002','Sedang menunggu dokumen persetujuan dari Debitur. Untuk draft Perjanjian telah direview bapak Hafid.','2019/09/19'),(5,'P000004','Draft addendum sedang direview Bapak Hafid. Dan masih menunggu kekurangan dokumen dari Debitur terkait akta pengangkatan kembali Direksi dan Dewan Komisaris perseroan.','2019/09/19'),(6,'P000001','','2019/10/08'),(7,'P000012','Sedang dalam proses pembuatan salinan akta','2019/10/18'),(8,'P000014','Laporan Selesai','2019/11/05'),(9,'P000015','Menunggu Konfirmasi jadwal tandatangan','2019/11/21'),(10,'P000048','sedang dalam proses pengerjaan (revisi dari para pihak)','2020/01/08');
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
INSERT INTO `data_progress_perizinan` VALUES ('PRZ000000','sedang proses validasi PPh dan BPHTB','2019/10/17'),('PRZ000000','validasi PPhnya sudah selesai, selanjutnya masih menunggu proses validasi bphtbnya.','2019/10/28'),('PRZ000006','Baru Input Online di PPAT Nur Rahmah','2019/11/13'),('PRZ000005','Masih dalam Proses Balik Nama Di BPN','2019/11/13'),('PRZ000007','Sedang Dalam Tahap proses SKB Hibah','2019/11/21'),('PRZ000009','belum selesai karena sedang pemindah bukuan','2020/01/03'),('PRZ000022','Wisnu Subroto N.A Menolak Tugas dengan alasan berkas belum ada,, dan coba coba','2020/01/29'),('PRZ000022','Wisnu Subroto N.A Menolak Tugas dengan alasan berkas belum ada,, dan coba coba','2020/01/29'),('PRZ000022','Wisnu Subroto N.A Menolak Tugas dengan alasan berkas belum ada,, dan coba coba','2020/01/29');
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
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nama_dokumen`
--

LOCK TABLES `nama_dokumen` WRITE;
/*!40000 ALTER TABLE `nama_dokumen` DISABLE KEYS */;
INSERT INTO `nama_dokumen` VALUES (1,'N_0001','Surat Izin Usaha Perdagangan ( SIUP )','2020-01-30 07:53:27.488977','Admin','Badan Hukum','Perorangan'),(4,'N_0004','Tanda daftar perusahaan ( TDP )','2020-01-30 07:53:37.182328','Admin','Badan Hukum','Perorangan'),(5,'N_0005','Surat Keterangan Domisili','2019-08-26 07:07:51.954546','Admin','Badan Hukum','Perorangan'),(6,'N_0006','Kartu Identitas','2020-01-02 09:45:34.866987','Admin','Badan Hukum','Perorangan'),(7,'N_0007','SP BKPM','2019-08-26 07:07:35.002779','Admin','Badan Hukum','undefined'),(8,'N_0008','Persetujuan RUPS (BAR/PKR/PKPS)','2019-08-26 07:07:24.276094','Admin','Badan Hukum','Perorangan'),(9,'N_0009','Anggaran Dasar beserta SK','2020-01-30 07:54:46.179222','Admin','Badan Hukum','Perorangan'),(10,'N_0010','Kartu Keluarga (KK)','2020-02-14 05:06:10.363530','Admin','','Perorangan'),(11,'N_0011','Sertifikat Tanah','2019-08-26 07:07:01.507129','Admin','Badan Hukum','Perorangan'),(13,'N_0013','Persetujuan Dewan Komisaris','2019-08-26 07:06:52.298354','Admin','undefined','Perorangan'),(17,'N_0015','Pernyataan Dan Lampiran Fidusia','2019-08-26 07:06:34.842978','Admin','Badan Hukum','undefined'),(19,'N_0017','SPPT PBB','2019-08-26 07:06:17.433660','Admin','Badan Hukum','Perorangan'),(20,'N_0018','Izin Mendirikan Bangunan (IMB)','2019-08-26 07:06:08.433020','Admin','Badan Hukum','Perorangan'),(21,'N_0019','Akta Kelahiran','2020-01-23 03:49:17.321920','Admin','Badan Hukum','Perorangan'),(31,'N_0022','Nomor Induk Koperasi (NIK)','2019-08-26 07:05:52.113467','Admin','Badan Hukum','undefined'),(32,'N_0023','Daftar Hadir Rapat','2019-08-26 07:05:40.179043','Admin','Badan Hukum','Perorangan'),(33,'N_0024','Fc Deposito Bank pemerintah min Rp. 15 juta','2019-10-28 02:28:52.463194','Admin','Badan Hukum','Perorangan'),(34,'N_0025','BAR Anggota Koperasi','2019-08-26 07:04:50.160543','Admin','Badan Hukum','undefined'),(35,'N_0026','Asli Dokumen yang akan diwaarmerking','2019-08-26 07:04:41.385374','Admin','Badan Hukum','Perorangan'),(36,'N_0027','Akta Kematian','2019-08-26 07:04:27.714028','Admin','undefined','Perorangan'),(37,'N_0028','Surat Keterangan Waris','2019-08-26 07:04:20.921575','Admin','undefined','Perorangan'),(38,'N_0029','NIB (Nomor Induk Berusaha)','2020-01-10 02:09:44.317626','Admin','Badan Hukum','Perorangan'),(40,'N_0031','Surat ganti nama WNI','2019-08-26 07:03:43.361576','Admin','undefined','Perorangan'),(41,'N_0032','Dokumen lain terkait isi/jenis dokumen yang dilegalisasi/diwaarmerking','2019-08-26 07:03:19.561025','Admin','Badan Hukum','Perorangan'),(42,'N_0033','Dokumen obyek hibah ','2020-01-09 04:42:28.530100','Admin','Badan Hukum','Perorangan'),(43,'N_0034','Dokumen Obyek Wasiat','2020-01-24 03:18:42.014726','Admin','','Perorangan'),(46,'N_0037','Kedudukan Atau Alamat Lengkap Badan Hukum','2020-01-24 03:18:25.326449','Admin','Badan Hukum',''),(49,'N_0040','Susunan Pemegang Saham Dan Pengurus','2020-01-24 03:17:50.023274','Admin','Badan Hukum','Perorangan'),(52,'N_0043','Susunan Permodalan (MD, MT, MS)','2020-01-24 03:17:22.428968','Admin','Badan Hukum','Perorangan'),(53,'N_0044','Susunan Persero Aktif Dan Persero Pasif','2020-01-24 03:16:36.811927','Admin','Badan Hukum','Perorangan'),(54,'N_0045','Susunan Pengurus Pengawas Dan Penasehat','2020-01-24 03:17:02.029674','Admin','','Perorangan'),(55,'N_0046','BAR Anggota Perkumpulan','2019-08-26 06:58:31.487420','Admin','undefined','Perorangan'),(56,'N_0047','BAR Pembina Yayasan','2019-08-26 06:58:20.393386','Admin','undefined','Perorangan'),(57,'N_0048','Kekayaan Yayasan / Perkumpulan','2019-08-26 06:58:06.608858','Admin','Badan Hukum','Perorangan'),(59,'N_0050','Pernyataan modal','2019-08-26 06:57:48.047131','Admin','Badan Hukum','Perorangan'),(60,'N_0051','Pernyataan tidak sengketa','2019-08-26 06:57:37.904606','Admin','Badan Hukum','Perorangan'),(61,'N_0052','Pernyataan kekayaan halal','2019-08-26 06:57:18.096832','Admin','Badan Hukum','Perorangan'),(62,'N_0053','Bukti Setor Modal/Neraca (jika modal naik)','2019-08-26 06:56:31.095494','Admin','Badan Hukum','undefined'),(63,'N_0054','Bukti kepemilikan jaminan','2019-09-06 02:10:14.702087','Admin','Badan Hukum','Perorangan'),(64,'N_0055','Persetujuan Saudara Yang Lain','2019-08-26 06:55:41.474673','Admin','undefined','Perorangan'),(78,'N_0077','Validasi Jenis Pajak ','2019-10-24 02:47:30.681133','Admin','Badan Hukum','Perorangan'),(79,'N_0078','Balik Nama sertifikat','2019-10-28 02:19:34.582448','Admin','Badan Hukum','Perorangan'),(80,'N_0079','Surat Bank Offering Letter','2019-09-17 02:30:21.070412','Admin','Badan Hukum','undefined'),(81,'N_0080','Akta Perjanjian Kredit Sebelumnya','2019-11-21 09:43:35.636883','Admin','Badan Hukum','Perorangan'),(82,'N_0081','Akta Jaminan Existing','2019-09-17 02:30:06.736266','Admin','Badan Hukum','Perorangan'),(84,'N_0083','Data Sertifikat Jaminan','2019-10-28 07:18:45.211983','Admin','Badan Hukum','Perorangan'),(86,'N_0085','NPWP','2019-10-16 06:52:20.069054','Admin','Badan Hukum','Perorangan'),(87,'N_0086','Akte nikah','2020-01-30 04:48:14.620098','Admin','Badan Hukum','Perorangan'),(88,'N_0087','Surat kuasa','2019-10-16 06:54:42.419024','Admin','Badan Hukum','Perorangan'),(89,'N_0088','Surat Roya','2019-11-13 02:13:16.320911','Admin','Badan Hukum','Perorangan'),(90,'N_0089','Sertifikat Hak Tanggungan HT','2019-11-13 02:13:07.994811','Admin','Badan Hukum','Perorangan'),(91,'N_0090','Dokumen Foto','2019-11-21 03:11:47.023007','Admin','Badan Hukum','Perorangan'),(92,'N_0091','Perjanjian Kawin','2019-11-21 07:26:54.996167','Admin','undefined','Perorangan'),(93,'N_0092','Akta Cerai','2020-01-10 04:10:59.279950','Admin','Badan Hukum','Perorangan'),(94,'N_0093','Bukti Transfer','2019-11-21 09:37:08.947512','Admin','Badan Hukum','Perorangan'),(95,'N_0094','Cover Note','2019-11-21 09:40:09.539884','Admin','Badan Hukum','Perorangan'),(96,'N_0095','Dokumen Kwitansi','2020-01-22 04:51:28.861028','Admin','Badan Hukum','Perorangan'),(97,'N_0096','note dokumen','2020-01-02 04:27:50.577783','Admin','Badan Hukum','Perorangan'),(98,'N_0097','Dokumen Perizinan','2020-01-24 02:49:57.191274','Admin','Badan Hukum','Perorangan'),(99,'N_0098','Dokumen Pendukung','2020-01-24 03:14:57.318326','Admin','Badan Hukum','Perorangan'),(100,'N_0099','Daftar Anggota','2020-01-24 03:15:35.277494','Admin','Badan Hukum','Perorangan'),(101,'N_0100','Dokumen Auditor Independen','2020-01-24 03:15:19.299610','Admin','Badan Hukum','Perorangan'),(102,'N_0101','Jenis Operasional','2020-01-24 03:13:24.105200','Admin','Badan Hukum','Perorangan'),(103,'N_0102','Dokumen Hasil Voting','2020-01-24 03:12:30.433414','Admin','Badan Hukum','Perorangan'),(104,'N_0103','Nomor Induk Koperasi','2020-01-24 03:09:09.836314','Admin','Badan Hukum','Perorangan'),(105,'N_0104','Dokumen Laporan','2020-01-24 03:11:29.074915','Admin','Badan Hukum','Perorangan'),(106,'N_0105','Dokumen Berita Negara','2020-01-24 03:09:39.977110','Admin','Badan Hukum','Perorangan'),(107,'N_0106','Tanda Terima','2020-01-24 03:08:09.225041','Admin','Badan Hukum','Perorangan'),(108,'N_0107','Dokumen Lampiran','2020-01-24 03:05:54.819325','Admin','Badan Hukum','Perorangan'),(109,'N_0108','Dokumen Surat','2020-01-24 03:04:51.122629','Admin','Badan Hukum','Perorangan'),(110,'N_0109','Pengumuman Koran','2020-01-24 02:42:30.070151','Admin','Badan Hukum','Perorangan'),(111,'N_0110','Data Akun Perusahaan','2020-01-24 02:37:17.418481','Admin','Badan Hukum','Perorangan'),(112,'N_0111','Daftar Hak Guna Bangunan (HGB)','2020-01-24 02:36:47.855169','Admin','Badan Hukum','Perorangan'),(113,'N_0112','Data Perusahaan','2020-01-24 02:35:38.543456','Admin','Badan Hukum','Perorangan'),(115,'N_0113','Bukti Pemesanan Nomor','2020-01-24 02:34:56.680097','Admin','Badan Hukum','Perorangan'),(117,'N_0116','Izin Usaha Perfilman (IUP)','2020-01-24 02:34:38.719181','Admin','Badan Hukum','Perorangan'),(118,'N_0117','Daftar Inventaris','2020-01-24 02:33:56.952155','Admin','Badan Hukum','Perorangan'),(119,'N_0118','Akta Hibah Saham','2020-01-24 02:33:21.534589','Admin','Badan Hukum','Perorangan'),(120,'N_0120','Anggran Dasar Rumah Tangga Perkumpulan','2020-01-28 02:18:24.205781','Admin','Badan Hukum','Perorangan'),(121,'N_0121','Anggaran Dasar','2020-01-28 04:03:39.792667','Admin','Badan Hukum',''),(122,'N_0122','Bukti Pesan Nama','2020-01-28 04:07:41.485070','Admin','Badan Hukum',''),(123,'N_0123','Notulen Rapat','2020-01-28 04:11:47.069164','Admin','Badan Hukum',''),(126,'N_0124','Izin Penggunaan Bangunan (IPB)','2020-01-29 06:47:47.405928','Admin','Badan Hukum',''),(127,'N_0127','Bukti Setoran','2020-01-31 02:46:42.287471','Admin','Badan Hukum',''),(129,'N_0128','Akte Jual Beli Saham','2020-01-31 03:39:47.520793','Admin','Badan Hukum',''),(133,'N_0130','Angka Pengenal Importir','2020-02-11 04:09:02.163711','Admin','Badan Hukum',''),(134,'N_0134','Keputusan Rapat Direksi','2020-02-11 08:33:33.483993','Admin','Badan Hukum','');
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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sublevel_user`
--

LOCK TABLES `sublevel_user` WRITE;
/*!40000 ALTER TABLE `sublevel_user` DISABLE KEYS */;
INSERT INTO `sublevel_user` VALUES (1,'0013','Level 3'),(5,'0012','Level 2'),(6,'0012','Level 3'),(7,'0011','Level 2'),(8,'0010','Level 2'),(10,'0008','Level 2'),(11,'0007','Level 2'),(12,'0006','Level 2'),(13,'0005','Level 2'),(14,'0004','Level 2'),(17,'0002','Level 3'),(19,'0001','Level 2'),(20,'0001','Level 1'),(21,'0014','Level 1'),(22,'0003','Level 4'),(23,'0001','Level 4'),(24,'0001','Level 3'),(36,'0017','Level 4'),(37,'0002','Level 4'),(38,'0018','Level 3'),(39,'0016','Level 3'),(40,'0017','Level 3'),(41,'0019','Level 4'),(42,'0039','Level 2'),(43,'0039','Level 3');
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (14,'0001','admin','Admin','dedy@notaris-jakarta.com','0887487772','Super Admin','2020-01-24 07:40:41.150819','227ba595ba8e6ca77e86fb1c4e1980c4','5e05d624acc14.png','Aktif'),(20,'0002','wisnu','Wisnu Subroto N.A','yuniaryanto679@gmail.com','087877912311','User','2019-12-11 08:23:56.610831','67340a8acc49d521d7fdd25db913bf9d','5df0a79c94e92.png','Aktif'),(21,'0003','dian','Siti Rizki Dianti','dian@notaris-jakarta.com','085289885222','User','2019-08-26 09:07:13.043943','f97de4a9986d216a6e0fea62b0450da9',NULL,'Aktif'),(22,'0004','prima','Prima Yuddy F Y','prima@notaris-jakarta.com','085263908704','User','2019-08-26 09:07:13.195274','3c00ab9ee5f47c8afc7ab4fc62342ef4',NULL,'Aktif'),(23,'0005','dini','Pratiwi S Dini','dini@notaris-jakarta.com','081273602067','User','2019-08-26 09:07:13.293964','83476316a972856163fb987b861a0a2c',NULL,'Aktif'),(24,'0006','rifka','Rifka Ramadani','rifka@notaris-jakarta.com','087739397228','User','2019-08-26 09:07:13.375698','7642cc8b570d5aa995acfb1a14267499',NULL,'Aktif'),(25,'0007','yus','Yus Suwandari','yus@notaris-jakarta.com','081280716583','User','2019-08-26 09:07:13.457325','efb6e5a9e90a1126301802ee0b3f11b8','5d01b1598e06d.png','Aktif'),(26,'0008','esthi','Esthi Herlina','esthi@notaris-jakarta.com','081517697047','User','2019-06-12 02:12:29.674979','debac5a803a64b50f4cf2211d921e589','5d005f8da4b9d.png','Aktif'),(29,'0010','indy','indarty','indy@notaris-jakarta.com','087876227696','User','2019-08-26 09:07:50.527950','9678817d0423ffa93446767b944e2b11',NULL,'Aktif'),(30,'0011','fitri','Fitri Senjayani','fitri@notaris-jakarta.com','08121923365','User','2019-08-26 09:07:42.099923','534a0b7aa872ad1340d0071cbfa38697',NULL,'Aktif'),(31,'0012','fadzri','MK Fadzri Patriajaya','fadzri@notaris-jakarta.com','087788105424','User','2019-12-13 01:51:41.083947','21232f297a57a5a743894a0e4a801fc3','5df2eead14666.png','Aktif'),(32,'0013','rohmad300','agus rohmad','agusrohmad300@gmail.com','081806446192','User','2019-05-21 08:14:40.720325','21232f297a57a5a743894a0e4a801fc3','5cd8e0ff1ea56.png','Aktif'),(33,'0014','admin2','Dewantari Handayani SH.MPA','dewantari@notaris-jakarta.com','-','User','2020-01-27 09:15:48.412115','18fe193144e4fb51d8679a9ce1818fd1',NULL,'Aktif'),(35,'0016','imam','Imam Syafi\'i','imamsyafii060179@gmail.com','087878914988','User','2019-08-30 09:18:49.440073','eaccb8ea6090a40a98aa28c071810371',NULL,'Aktif'),(36,'0017','Sastra','Sastra Wardana','sastrawardana@notaris-jakarta.com','081292235391','User','2019-10-08 04:06:13.137135','aa5f729915041e3709e2ad3f96076f18',NULL,'Aktif'),(37,'0018','eka','Eka Andriani','eka@notaris-jakarta.com','0','User','2019-10-17 07:29:46.875546','79ee82b17dfb837b1be94a6827fa395a',NULL,'Aktif'),(38,'0019','arsip','Dokumen Arsip','arsip@gmail.com','081289903664','User','2020-01-02 01:53:42.014106','3ac53a0f0b6ee2a6203176a72c61a153',NULL,'Aktif'),(39,'0039','hanto','Srihanto Nugroho','hanto@notaris-jakarta.com','081xxxxxx','User','2020-01-27 09:11:20.800916','18fe193144e4fb51d8679a9ce1818fd1',NULL,'Admin');
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

-- Dump completed on 2020-02-28 17:15:54
