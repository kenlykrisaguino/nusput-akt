-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS db_nusput_akt;
CREATE DATABASE 		db_nusput_akt;
USE						db_nusput_akt;


-- Dumping structure for table db_nusput_akt.akun
CREATE TABLE IF NOT EXISTS `akun` (
  `kode_akun` varchar(50) NOT NULL,
  `nama_akun` varchar(255) NOT NULL,
  `klasifikasi` varchar(255) NOT NULL,
  `saldo_normal` varchar(255) NOT NULL,
  `arus_kas` varchar(50) NOT NULL,
  `jenis` varchar(30) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`kode_akun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.akun: ~258 rows (approximately)
INSERT INTO `akun` (`kode_akun`, `nama_akun`, `klasifikasi`, `saldo_normal`, `arus_kas`, `jenis`, `status`) VALUES
	('100', 'KAS', '10. ASET LANCAR', 'Debit', '', '', 1),
	('110', 'BANK', '10. ASET LANCAR', 'Debit', 'BANK', '', 1),
	('111', 'BANK MAYAPADA INDUK', '10. ASET LANCAR', 'Debit', 'BANK', '', 1),
	('112', 'BANK BRI AGRO', '10. ASET LANCAR', 'Debit', 'BANK', '', 1),
	('113', 'BANK BNI', '10. ASET LANCAR', 'Debit', 'BANK', '', 1),
	('114', 'DEPOSITO', '10. ASET LANCAR', 'Debit', '', '', 1),
	('115', 'BANK BNI BERHADIAH', '10. ASET LANCAR', 'Debit', 'BANK', '', 1),
	('116', 'BANK MANDIRI', '10. ASET LANCAR', 'Debit', 'BANK', '', 1),
	('117', 'BANK BCA', '10. ASET LANCAR', 'Debit', 'BANK', '', 1),
	('118', 'BANK MAYAPADA 889.1', '10. ASET LANCAR', 'Debit', 'BANK', '', 1),
	('119', 'BANK KESAHTERAAN', '10. ASET LANCAR', 'Debit', 'BANK', '', 1),
	('120', 'PIUT. UANG SEKOLAH', '10. ASET LANCAR', 'Debit', '', '', 1),
	('121', 'PIUT. UANG TAB.EBTA', '10. ASET LANCAR', 'Debit', '', '', 1),
	('122', 'PIUT.  UANG POM', '10. ASET LANCAR', 'Debit', '', '', 1),
	('123', 'PIUT. UANG KOMP', '10. ASET LANCAR', 'Debit', '', '', 1),
	('124', 'PIUT. UANG PRAKTEK', '10. ASET LANCAR', 'Debit', '', '', 1),
	('125', 'PIUT. UANG ALAT/JAMINAN SEKOLAH', '10. ASET LANCAR', 'Debit', '', '', 1),
	('126', 'PIUT. UANG DENDA', '10. ASET LANCAR', 'Debit', '', '', 1),
	('129', 'PIUT. LAIN2', '10. ASET LANCAR', 'Debit', '', '', 1),
	('130', 'PERSEDIAAN - ALAT SEKOLAH', '19. PERSEDIAAN', 'Debit', 'Investasi', '', 1),
	('131', 'PERSEDIAAN - BAHAN PRAKTIKUM', '19. PERSEDIAAN', 'Debit', 'Investasi', '', 1),
	('132', 'PERSEDIAAN - ALAT OLAH RAGA', '19. PERSEDIAAN', 'Debit', 'Investasi', '', 1),
	('133', 'PERSEDIAAN - PAKAIAN/SERAGAM', '19. PERSEDIAAN', 'Debit', 'Investasi', '', 1),
	('139', 'PERSEDIAAN - LAIN2', '19. PERSEDIAAN', 'Debit', 'Investasi', '', 1),
	('140', 'UANG MUKA PEMBELIAN', '10. ASET LANCAR', 'Debit', '', '', 1),
	('141', 'UANG MUKA (BIAYA DIBYR DMK)', '10. ASET LANCAR', 'Debit', '', '', 1),
	('142', 'PIUTANG MODAL BISNIS CENTER', '10. ASET LANCAR', 'Debit', '', '', 1),
	('150', 'BANK BNI', '10. ASET LANCAR', 'Debit', '', '', 1),
	('200', 'TANAH', '11. ASET TETAP', 'Debit', 'Investasi', '', 1),
	('201', 'BANGUNAN LAMA', '11. ASET TETAP', 'Debit', 'Investasi', '', 1),
	('202', 'BANGUNAN BARU', '11. ASET TETAP', 'Debit', 'Investasi', '', 1),
	('203', 'LAPANGAN OLAH RAGA & PAGAR', '11. ASET TETAP', 'Debit', 'Investasi', '', 1),
	('204', 'KENDARAAN', '11. ASET TETAP', 'Debit', 'Investasi', '', 1),
	('205', 'INVENTARIS KANTOR / KELAS', '11. ASET TETAP', 'Debit', 'Investasi', '', 1),
	('206', 'INVENTARIS LAB', '11. ASET TETAP', 'Debit', 'Investasi', '', 1),
	('207', 'INVENTARIS UMUM', '11. ASET TETAP', 'Debit', 'Investasi', '', 1),
	('208', 'INVENTARIS PERPUSTAKAAN (BUKU,VCD,DLL)', '11. ASET TETAP', 'Debit', 'Investasi', '', 1),
	('209', 'BANGUNAN DALAM PROSES', '11. ASET TETAP', 'Debit', 'Investasi', '', 1),
	('210', 'AKM. PENYUSUTAN BANGUNAN LAMA ', '11. ASET TETAP', 'Kredit', '', '', 1),
	('211', 'AKM. PENYUSUTAN BANGUNAN BARU', '11. ASET TETAP', 'Kredit', '', '', 1),
	('212', 'AKM. PENYUSUTAN LAPANGAN OR', '11. ASET TETAP', 'Kredit', '', '', 1),
	('213', 'AKM. PENYUSUTAN KENDARAAN', '11. ASET TETAP', 'Kredit', '', '', 1),
	('214', 'AKM. PENYUSUTAN INVENTARIS KANTOR', '11. ASET TETAP', 'Kredit', '', '', 1),
	('215', 'AKM. PENYUSUTAN INVENTARIS LABORAT ', '11. ASET TETAP', 'Kredit', '', '', 1),
	('216', 'AKM. PENYUSUTAN INVENTARIS UMUM', '11. ASET TETAP', 'Kredit', '', '', 1),
	('217', 'DANA PEMB - BANGUNAN', '11. ASET TETAP', 'Debit', '', '', 1),
	('218', 'DANA PEMB - PERLENGKAPAN + LAB (KEL - 1 )', '11. ASET TETAP', 'Debit', '', '', 1),
	('219', 'DANA PEMB - PERLENGKAPAN + LAB (KEL - 2)', '11. ASET TETAP', 'Debit', '', '', 1),
	('220', 'DANA PEMB - INVENTARIS (KEL - 1)', '11. ASET TETAP', 'Debit', '', '', 1),
	('221', 'DANA PEMB - INVENTARIS (KEL - 2)', '11. ASET TETAP', 'Debit', '', '', 1),
	('222', 'DANA PEMB - KENDARAAN', '11. ASET TETAP', 'Debit', '', '', 1),
	('300', 'HTG. DAGANG', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('301', 'HTG. BI. LAB', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('302', 'HTG. BI. KANTOR', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('303', 'HTG. BI. GAJI & TUNJ', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('304', 'HTG. BI. PENGAJARAN', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('305', 'HTG. BUKU', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('307', 'HTG. BI. EBTA', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('308', 'HTG. BI. RAPAT & PEJL.DINAS', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('309', 'HTG. BI. PRAMUKA', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('310', 'HTG. BI. PERPUSTAKAAN', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('311', 'HTG. BI. LAIN2', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('312', 'HTG. BI. POM/KOMITE SEKOLAH', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('313', 'HTG. BI. UANG JAMINAN ALAT', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('314', 'HTG. BI. PAJAK PENGHASILAN', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('315', 'HTG. BI.YAYASAN DANAGAS', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('316', 'HTG. BI.YAYASAN UANG SUMBANGAN', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('317', 'HTG. PLT', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('318', 'TITIPAN BEASISWA/BOSS/BPP/DIG/SUMB.PEM/BOOMM', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('319', 'TITIPAN UANG SERAGAM', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('320', 'UANG MUKA - SEKOLAH', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('321', 'UANG MUKA - TAB.EBTA/UJIAN', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('322', 'UANG MUKA - PKL/PRAKERIN', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('323', 'UANG MUKA - KOMPUTER', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('324', 'UANG MUKA - PRAKTEK', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('325', 'UANG MUKA - DAFTAR (ADM)', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('326', 'UANG MUKA - FORMULIR', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('327', 'UANG MUKA - KARYAWISATA', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('328', 'UANG MUKA - UKS', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('329', 'UANG MUKA - STP2K/MKKS', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('330', 'UANG MUKA - TES', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('331', 'UANG MUKA - PSIKOTES', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('332', 'UANG MUKA - ALAT', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('333', 'UANG MUKA - MASAK', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('334', 'UANG MUKA - SARPRA', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('335', 'UANG MUKA - EKSTRA', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('336', 'UANG TITIPAN HUMAS', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('337', 'UANG MUKA - PERPUSTAKAAN', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('338', 'UANG MUKA - MOS/OSPEK', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('339', 'UANG MUKA - LAIN2 (METERAI)', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('340', 'UANG MUKA - D P P', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('341', 'UANG MUKA - MAJALAH/MEKA NECI', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('342', 'UANG MUKA - ASURANSI', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('343', 'UANG MUKA - KALENDER', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('344', 'UANG MUKA - KEROHANIAN', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('345', 'UANG MUKA - KEGIATAN SISWA', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('346', 'UANG MUKA - FOTO,KARTU SISWA, MAP, PLAKAT', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('347', 'UANG MUKA - PENTAS SENI', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('348', 'UANG MUKA - SKS', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('360', 'UANG MUKA - OPERASIONAL PENDIDIKAN', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('361', 'UANG MUKA - SKS', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('362', '', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('363', 'UANG MUKA - KEMAHASISWAAN', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('364', 'UANG MUKA - SKRIPSI', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('390', 'UANG MUKA - TITIPAN', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('398', 'SALDO AWAL UANG MUKA-KAS BON', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('399', 'HUTANG LAIN2', '14. HUTANG JK PENDEK', 'Kredit', 'Operasional', ' ', 1),
	('401', 'MODAL', '20. MODAL', 'Kredit', 'Pendanaan', '', 1),
	('402', 'LABA RUGI DITAHAN', '20. MODAL', 'Kredit', '', '', 1),
	('403', 'LABA RUGI TAHUN BERJALAN', '20. MODAL', 'Kredit', '', '', 1),
	('404', 'LABA RUGI BULAN BERJALAN', '20. MODAL', 'Kredit', '', '', 1),
	('500', 'PENERIMAAN - UANG SEKOLAH', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('501', 'PENERIMAAN - UANG UJIAN', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('502', 'PENERIMAAN - UANG KARYAWISATA', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('503', 'PENERIMAAN - UANG UKS', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('504', 'PENERIMAAN - UANG STP2K', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('505', 'PENERIMAAN - UANG EXTRA KUL', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('506', 'PENERIMAAN - UANG KOMPUTER/IT', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('507', 'PENERIMAAN - UANG MASAK', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('508', 'PENERIMAAN - UANG BUKU/LKS/MODUL', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('509', 'PENERIMAAN - UANG UANG PKL / PRAKERIN', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('510', 'PENERIMAAN - UANG MAJALAH/BULETIN', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('511', 'PENERIMAAN - UANG PENGAJARAN', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('512', 'PENERIMAAN - YG AKAN DITERIMA', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('513', 'PENERIMAAN - SARPRA', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('514', 'PENERIMAAN - DAY CARE', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('515', 'PENERIMAAN - PRA PLAYGROUP', '17. PENERIMAAN RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('529', 'PENERIMAAN - UANG HARI BESAR', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('530', 'PENERIMAAN - UANG TEST', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('531', 'PENERIMAAN - UANG PRAKTEK', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('532', 'PENERIMAAN - UANG ALAT', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('533', 'PENERIMAAN - LABA PENJ AKTIVA', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('534', 'PENERIMAAN - UANG UANG FORMULIS PPD', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('535', 'PENERIMAAN - UANG MOS', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('536', 'PENERIMAAN - UANG SERAGAM', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('537', 'PENERIMAAN - UANG DENDA', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('538', 'PENERIMAAN - BOSS/BPP', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('539', 'PENERIMAAN - UANG PERPUSTAKAAN', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('540', 'PENERIMAAN - UANG D.P.P', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('541', 'PENERIMAAN - UANG TEST PSIKOLOGI/IQ', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('542', 'PENERIMAAN - UANG ASURANSI', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('543', 'PENERIMAAN - UANG KALENDER', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('544', 'PENERIMAAN - UANG IURAN KEGIATAN KEAGAMAAN', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('545', 'PENERIMAAN - UANG KEGIATAN OSIS/KEPEMIMPINAN', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('546', 'PENERIMAAN - UANG FOTO,KARTU SISWA, DLL', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('547', 'PENERIMAAN - UANG SKS', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('548', 'PENERIMAAN - UANG P.P.D/OPEN HOUSE', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('549', 'PENERIMAAN - UANG GEDUNG', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('550', 'PENERIMAAN - KOMITE', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('557', 'PENERIMAAN - UANG METERAI', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('558', 'PENERIMAAN - UANG METERAI', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('559', 'PENERIMAAN - CUTI MAHASISWA', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('560', 'PENERIMAAN - OPERASIONAL PENDIDIKAN', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('561', 'PENERIMAAN - SKS TEORI', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('562', 'PENERIMAAN - SKS PRAKTEK', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('563', 'PENERIMAAN - SKS KEMAHASISWAAN', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('564', 'PENERIMAAN - SKS SKRIPSI', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('565', 'PENERIMAAN - SEWA ATM', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('599', 'PENERIMAAN - DANA BOMM/MANDARIN/KOMITE', '18. PENERIMAAN TDK RUTIN', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('600', 'BI - GAJI & TUNJ GURU TETAP', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('601', 'BI - GAJI & TUNJ GURU TIDAK TETAP', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('602', 'BI - KESEJAHTERAAN & PENGOBATAN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('603', 'BI - PRAMUKA & EX SCHOOL', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('604', 'BI - PENGAJARAN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('605', 'BI - PERAWATAN KELAS', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('606', 'BI - ALAT TULIS & CETAKAN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('607', 'BI - RAPAT & PERJALANAN DINAS', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('608', 'BI - PRAKERIN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('609', 'BI - BAHAN PRAKTIKUM', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('610', 'BI - REPEM INVENTARIS', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('611', 'BI - PENYUSUTAN INV. KANTOR', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('612', 'BI - PENYUSUTAN INV. LABORAT', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('613', 'BI - BAHAN HABIS PAKAI', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('614', 'BEBAN GAJI - GURU EKSTRA', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('615', 'BI - LPMP', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('620', 'BI - UUB/UUS/UTS/UAS, TRY OUT,US, UN, UKK', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('621', 'BI - STP 2 K', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('622', 'BI - KARYAWISATA', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('623', 'BI - UKS', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('624', 'BI - WISUDA, PKL, PELEPASAN KELULUSAN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('625', 'BI - P.P.D (PENDAFTARAN)', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('626', 'BI - SERAGAM GURU', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('627', 'BI - THR GURU', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('628', 'BI - IKLAN & PROMOSI', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('629', 'BI - HARI BESAR', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('630', 'BI - PERPUSTAKAAN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('631', 'BI - SUMBANGAN/REPRES', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('632', 'BI - RAPAT INTERN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('633', 'BI - ALAT HABIS PAKAI', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('634', 'BI - PENGGANDAAN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('635', 'BI - PENELITIAN/LPMP', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('636', 'BI - PENGABDIAN MASYARAKAT', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('637', 'BI - BUKU', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('638', 'BI - SUBSIDI BIMBINGAN BELAJAR', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('639', 'BI - MASAK (TK)', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('640', 'BI - MAJALAH/BULETIN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('641', 'BI - SERAGAM SISWA/MAHASISWA', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('642', 'BI - ASURANSI JIWA', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('643', 'BI - REWARD GURU (TALI ASIH)', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('644', 'BI - KEGIATAN KEAGAMAAN', '15. OPERASIONAL RUTIN', 'Debit\r\n', 'Operasional', 'Pengeluaran', 1),
	('645', 'BI - KEGIATAN KE OSIS AN / KEPEMIMPINAN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('646', 'BI - LOMBA EXTRA', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('647', 'BI - LOMBA PELAJARAN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('648', 'BI - PEL. TAMBAHAN', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('697', 'BI - REWARD GURU/ THR GURU KONTRAK', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('699', 'BI - LAIN2 (AKREDITASI & PENUNTASAN UN)', '15. OPERASIONAL RUTIN', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('700', 'BI - GAJI & TUNJ KARY', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('701', 'BI - KESEJAHTERAAN & PENGOBATAN KARY', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('702', 'BI - SERAGAM KARY', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('703', 'BI - THR KARY', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('704', 'BI - MAKAN, MINUM, DAPUR', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('705', 'BI - REPEM BANGUNAN', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('706', 'BI - ALAT TULIS& CETAKAN', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('707', 'BI - TELP / FAX / INTERNET / HP', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('708', 'BI - ASURANSI', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('709', 'BI - REPRES', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('710', 'BI - LISTRIK,AIR, SAMPAH, KSM', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('711', 'BI - REKRUT KARY', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('712', 'BI - PENYUSUTAN BANGUNAN', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('713', 'BI - PENYUSUTAN INVENTARIS', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('714', 'BI - PPH', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('715', 'BI - HUMAS', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('716', 'BI - PEMELIHARAAN INVENTARIS', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('717', 'BI - PELATIHAN KARY', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('718', 'BI - BAHAN HABIS PAKAI', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('719', 'BI - UANG DINAS KARYAWAN', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('720', 'BI - REPEM KENDARAAN', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('721', 'BI - BEA SISWA DARI YAYASAN', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('722', 'BI - PENYUSUTAN KENDARAAN', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('728', 'BI - IKLAN PROMOSI', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('729', 'BI - BAHAN BAKAR KENDARAAN SEKOLAH', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('733', 'BI - ALAT HABIS PAKAI', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('796', 'BI - KONSUMSI RAPAT MANAGER DGN YAYASAN ', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('797', 'BI - REWARD KARY (TALI ASIH)', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('798', 'BI - PENINGKATAN MUTU GURU', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('799', 'BI - LAIN2 (TABUNG PEMADAM KEBAKARAN)', '13. BIAYA UMUM & ADM', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('800', 'PENDAPATAN - UANG SAMPAH & AIR (KANTIN)', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('801', 'PENDAPATAN - PEMAKAIAN TELP', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('802', 'PENDAPATAN - LABORATORIUM', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('803', 'PENDAPATAN - JASA GIRO', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('804', 'PENDAPATAN - BAZAR', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('805', 'PENDAPATAN - SUMB DARI PEMERINTAH', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('806', 'PENDAPATAN - SUMB DARI YAYASAN', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('807', 'PENDAPATAN - SELISIH HRG / STOCK OPNAME', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('808', 'PENDAPATAN - DISCOUNT PEMBELIAN', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('809', 'PENDAPATAN - FOTO COPY', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('810', 'PENDAPATAN - BUNGA DEPOSITO', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('890', 'PENDAPATAN - KEDAI', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('891', 'PENDAPATAN - ASRAMA', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('899', 'PENDAPATAN - LAIN2', '16. PENDAPATAN DI LUAR USAHA', 'Kredit', 'Operasional', 'Penerimaan', 1),
	('900', 'BI - BUNGA BANK (ADM BANK)', '12. BIAYA DI LUAR USAHA', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('901', 'BI - HARI BESAR', '12. BIAYA DI LUAR USAHA', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('902', 'BI - PERIJINAN', '12. BIAYA DI LUAR USAHA', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('903', 'BI - KONSULTAN', '12. BIAYA DI LUAR USAHA', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('904', 'BI - PPN ATAS PEMBELIAN & JASA', '12. BIAYA DI LUAR USAHA', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('905', 'BI - MELALUI KOMITE', '12. BIAYA DI LUAR USAHA', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('909', 'BI - FOTOCOPY', '12. BIAYA DI LUAR USAHA', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('990', 'BI - KEDAI', '12. BIAYA DI LUAR USAHA', 'Debit', 'Operasional', 'Pengeluaran', 1),
	('991', 'BI - ASRAMA', '12. BIAYA DI LUAR USAHA', 'Debit', 'Operasional', 'Pengeluaran', 1);

-- Dumping structure for table db_nusput_akt.aset
CREATE TABLE IF NOT EXISTS `aset` (
  `kode_aset` varchar(255) NOT NULL,
  `nama_aset` varchar(50) NOT NULL,
  `jenis_aset` varchar(50) NOT NULL,
  `lokasi_aset` varchar(50) NOT NULL,
  `harga_perolehan` int NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `umur_ekonomis` int NOT NULL,
  `foto` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.aset: ~0 rows (approximately)

-- Dumping structure for table db_nusput_akt.labarugi_ditahan
CREATE TABLE IF NOT EXISTS `labarugi_ditahan` (
  `nominal` bigint NOT NULL,
  `periode` varchar(10) NOT NULL,
  PRIMARY KEY (`periode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.labarugi_ditahan: ~1 rows (approximately)
INSERT INTO `labarugi_ditahan` (`nominal`, `periode`) VALUES
	(50000000, '2023-06-30');

-- Dumping structure for table db_nusput_akt.laba_rugi
CREATE TABLE IF NOT EXISTS `laba_rugi` (
  `nominal` bigint NOT NULL,
  `periode` varchar(6) NOT NULL,
  PRIMARY KEY (`periode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.laba_rugi: ~1 rows (approximately)
INSERT INTO `laba_rugi` (`nominal`, `periode`) VALUES
	(40000000, '202409');

-- Dumping structure for table db_nusput_akt.master_jenjang
CREATE TABLE IF NOT EXISTS `master_jenjang` (
  `kode_jenjang` varchar(255) NOT NULL,
  `nama_jenjang` varchar(255) NOT NULL,
  `kelompok` varchar(255) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`kode_jenjang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.master_jenjang: ~12 rows (approximately)
INSERT INTO `master_jenjang` (`kode_jenjang`, `nama_jenjang`, `kelompok`, `status`) VALUES
	('1', 'DAY CARE', 'DAY CARE', 1),
	('10', 'SEKOLAH BASKET', 'SEKOLAH BASKET', 1),
	('11', 'LES MANDARIN', 'LES MANDARIN', 1),
	('12', 'UMUM', 'UMUM', 1),
	('2', 'TK', 'TK', 1),
	('3', 'SD', 'SD', 1),
	('4', 'SMP', 'SMP', 1),
	('5', 'SMA', 'SMA', 1),
	('6', 'SMK1', 'SMK1-TKJ, MM', 1),
	('7', 'SMK2', 'SMK2-F, FA, H', 1),
	('8', 'STIFERA', 'STIFERA', 1),
	('9', 'MESS', 'MESS', 1);

-- Dumping structure for table db_nusput_akt.master_transaksi
CREATE TABLE IF NOT EXISTS `master_transaksi` (
  `status` int NOT NULL,
  `kode_transaksi` varchar(50) NOT NULL,
  `kategori_transaksi` varchar(255) NOT NULL,
  `akun_debit` varchar(255) NOT NULL,
  `akun_kredit` varchar(255) NOT NULL,
  `kode_akun_debit` int NOT NULL,
  `kode_akun_kredit` int NOT NULL,
  PRIMARY KEY (`kode_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.master_transaksi: ~24 rows (approximately)
INSERT INTO `master_transaksi` (`status`, `kode_transaksi`, `kategori_transaksi`, `akun_debit`, `akun_kredit`, `kode_akun_debit`, `kode_akun_kredit`) VALUES
	(1, 'PAS-2', 'Pembayaran Asuransi', 'BI - ASURANSI', 'BANK BCA', 708, 117),
	(1, 'PAT-3', 'Pembelian Alat Tulis', 'BI - ALAT TULIS& CETAKAN', 'KAS', 706, 100),
	(1, 'PBB-1', 'Penyusutan Bangunan Baru', 'BI - PENYUSUTAN BANGUNAN', 'AKM. PENYUSUTAN BANGUNAN BARU', 712, 211),
	(1, 'PBBK-2', 'Pembelian Bahan Bakar', 'BI - BAHAN BAKAR KENDARAAN SEKOLAH', 'BANK BCA', 729, 117),
	(1, 'PBDL', 'Penerbitan Denda Lunas', 'BANK BNI', 'PIUT. UANG DENDA', 113, 126),
	(1, 'PBP-2', 'Pembelian Bahan Praktikum', 'PERSEDIAAN - BAHAN PRAKTIKUM', 'BANK BCA', 131, 117),
	(1, 'PBPS-1', 'Pembayaran Biaya Promosi Sekolah', 'BI - IKLAN & PROMOSI', 'BANK MANDIRI', 628, 116),
	(1, 'PBU-1', 'Pembayaran Biaya Utilitas', 'BI - LISTRIK,AIR, SAMPAH, KSM', 'BANK MANDIRI', 710, 116),
	(1, 'PGG-1', 'Pembayaran Gaji & Tunjangan Guru', 'BI - GAJI & TUNJ GURU TETAP', 'BANK MANDIRI', 600, 116),
	(1, 'PIL-1', 'Penyusutan Inventaris Lab', 'BI - PENYUSUTAN INV. KANTOR', 'AKM. PENYUSUTAN INVENTARIS LABORAT ', 611, 215),
	(1, 'PIP-2', 'Pembelian Inventaris Perpustakaan', 'INVENTARIS PERPUSTAKAAN (BUKU,VCD,DLL)', 'BANK BCA', 208, 117),
	(1, 'PK', 'Penyusutan Kendaraan', 'BI - PENYUSUTAN KENDARAAN', 'AKM. PENYUSUTAN KENDARAAN', 722, 213),
	(1, 'PLUS', 'Pelunasan Uang Sekolah', 'BANK BNI', 'PIUT. UANG SEKOLAH', 113, 120),
	(1, 'PNBD', 'Penerbitan Denda', 'PIUT. UANG DENDA', 'PENERIMAAN - UANG DENDA', 126, 537),
	(1, 'PHPD', 'Penghapusan Denda', 'PENERIMAAN - UANG DENDA', 'PIUT. UANG DENDA', 537, 126),
	(1, 'PPPD-3', 'Penerimaan PPD/Open House', 'KAS', 'PENERIMAAN - UANG P.P.D/OPEN HOUSE', 100, 548),
	(1, 'PPSK', 'Pembelian Peralatan Sekolah (kredit)', 'PERSEDIAAN - ALAT SEKOLAH', 'HUTANG LAIN2', 130, 399),
	(1, 'PPUS-1', 'Pelunasan Piutang Uang Sekolah', 'BANK MANDIRI', 'PIUT. UANG SEKOLAH', 116, 120),
	(1, 'PSG-1', 'Pembelian Seragam Guru', 'BI - SERAGAM GURU', 'BANK MANDIRI', 626, 116),
	(1, 'PSSK', 'Pembelian Seragam Siswa (kredit)', 'PERSEDIAAN - PAKAIAN/SERAGAM', 'HUTANG LAIN2', 133, 399),
	(1, 'PTUS', 'Penerbitan Uang Sekolah', 'PIUT. UANG SEKOLAH', 'PENERIMAAN - UANG SEKOLAH', 120, 500),
	(1, 'PUD-1', 'Penerimaan Uang Denda Uang Sekolah', 'BANK MANDIRI', 'PENERIMAAN - UANG DENDA', 116, 537),
	(1, 'PUG-1', 'Pendapatan Uang Gedung', 'BANK MANDIRI', 'PENERIMAAN - UANG GEDUNG', 116, 549),
	(1, 'PUP-3', 'Pendapatan Uang Praktik', 'KAS', 'PENERIMAAN - UANG PRAKTEK', 100, 531),
	(1, 'PUS-1', 'Penerimaan Uang Sekolah (Mandiri)', 'BANK MANDIRI', 'PENERIMAAN - UANG SEKOLAH', 116, 500),
	(1, 'PUSR-2', 'Pendapatan Uang Seragam Siswa', 'BANK BCA', 'PENERIMAAN - UANG SERAGAM', 117, 536),
	(1, 'PUU-3', 'Penerimaan Uang Ujian (Kas)', 'KAS', 'PENERIMAAN - UANG UJIAN', 100, 501);

-- Dumping structure for table db_nusput_akt.th_ajaran
CREATE TABLE IF NOT EXISTS `th_ajaran` (
  `kode_tahun` varchar(255) NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.th_ajaran: ~2 rows (approximately)
INSERT INTO `th_ajaran` (`kode_tahun`, `tahun_ajaran`, `status`) VALUES
	('16', '2022 - 2023', 1),
	('18', '2024 - 2025', 1),
	('19', '2025 - 2026', 1);

-- Dumping structure for table db_nusput_akt.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `debit_account` varchar(100) NOT NULL,
  `credit_account` varchar(100) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.transactions: ~2 rows (approximately)
INSERT INTO `transactions` (`id`, `date`, `description`, `debit_account`, `credit_account`, `amount`) VALUES
	(1, '2025-02-15', 'www', 'Kas', 'Pendapatan', 2000.00),
	(2, '2025-02-15', 'www', 'Kas', 'Pendapatan', 2000.00);

-- Dumping structure for table db_nusput_akt.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `status` int NOT NULL,
  `tanggal` date NOT NULL,
  `kode_transaksi` varchar(50) NOT NULL,
  `kategori_transaksi` varchar(255) NOT NULL,
  `kode_tahun` int NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `nama_akun` varchar(255) NOT NULL,
  `kode_jenjang` int NOT NULL,
  `nama_jenjang` varchar(255) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `debit` bigint NOT NULL,
  `kredit` bigint NOT NULL,
  `no_transaksi` int NOT NULL,
  `sumber_dana` varchar(50) NOT NULL,
  `kode_akun` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.transaksi: ~50 rows (approximately)
INSERT INTO `transaksi` (`status`, `tanggal`, `kode_transaksi`, `kategori_transaksi`, `kode_tahun`, `tahun_ajaran`, `nama_akun`, `kode_jenjang`, `nama_jenjang`, `keterangan`, `debit`, `kredit`, `no_transaksi`, `sumber_dana`, `kode_akun`) VALUES
	(1, '2024-12-01', 'PUS-1', 'Penerimaan Uang Sekolah (Mandiri)', 18, '2024 - 2025', 'BANK MANDIRI', 5, 'SMA', 'Penerimaan uang sekolah SMA bulan Desember', 50000000, 0, 1, 'Rutin', '116'),
	(1, '2024-12-01', 'PUS-1', 'Penerimaan Uang Sekolah (Mandiri)', 18, '2024 - 2025', 'PENERIMAAN - UANG SEKOLAH', 5, 'SMA', 'Penerimaan uang sekolah SMA bulan Desember', 0, 50000000, 1, '', '500'),
	(1, '2024-12-02', 'PIP-2', 'Pembelian Inventaris Perpustakaan', 18, '2024 - 2025', 'INVENTARIS PERPUSTAKAAN (BUKU,VCD,DLL)', 5, 'SMA', 'Pembelian buku untuk perpustakaan', 5000000, 0, 2, 'Rutin', '208'),
	(1, '2024-12-02', 'PIP-2', 'Pembelian Inventaris Perpustakaan', 18, '2024 - 2025', 'BANK BCA', 5, 'SMA', 'Pembelian buku untuk perpustakaan', 0, 5000000, 2, '', '117'),
	(1, '2024-12-03', 'PGG-1', 'Pembayaran Gaji & Tunjangan Guru', 18, '2024 - 2025', 'BI - GAJI & TUNJ GURU TETAP', 5, 'SMA', 'Pembayaran gaji guru SMA bulan Desember', 30000000, 0, 3, 'Rutin', '600'),
	(1, '2024-12-03', 'PGG-1', 'Pembayaran Gaji & Tunjangan Guru', 18, '2024 - 2025', 'BANK MANDIRI', 5, 'SMA', 'Pembayaran gaji guru SMA bulan Desember', 0, 30000000, 3, '', '116'),
	(1, '2024-12-04', 'PUU-3', 'Penerimaan Uang Ujian (Kas)', 18, '2024 - 2025', 'KAS', 5, 'SMA', 'Penerimaan uang ujian SMA', 10000000, 0, 4, 'Rutin', '100'),
	(1, '2024-12-04', 'PUU-3', 'Penerimaan Uang Ujian (Kas)', 18, '2024 - 2025', 'PENERIMAAN - UANG UJIAN', 5, 'SMA', 'Penerimaan uang ujian SMA', 0, 10000000, 4, '', '501'),
	(1, '2024-12-05', 'PBP-2', 'Pembelian Bahan Praktikum', 18, '2024 - 2025', 'PERSEDIAAN - BAHAN PRAKTIKUM', 5, 'SMA', 'Pembelian Bahan Praktikum SMA', 3000000, 0, 5, 'Rutin', '131'),
	(1, '2024-12-05', 'PBP-2', 'Pembelian Bahan Praktikum', 18, '2024 - 2025', 'BANK BCA', 5, 'SMA', 'Pembelian Bahan Praktikum SMA', 0, 3000000, 5, '', '117'),
	(1, '2024-12-06', 'PUP-3', 'Pendapatan Uang Praktik', 18, '2024 - 2025', 'KAS', 5, 'SMA', 'Pendapatan uang praktik SMA', 7500000, 0, 6, 'Rutin', '100'),
	(1, '2024-12-06', 'PUP-3', 'Pendapatan Uang Praktik', 18, '2024 - 2025', 'PENERIMAAN - UANG PRAKTEK', 5, 'SMA', 'Pendapatan uang praktik SMA', 0, 7500000, 6, '', '531'),
	(1, '2024-12-07', 'PBU-1', 'Pembayaran Biaya Utilitas', 18, '2024 - 2025', 'BI - LISTRIK,AIR, SAMPAH, KSM', 5, 'SMA', 'Biaya utilitas SMA', 5000000, 0, 7, 'Rutin', '710'),
	(1, '2024-12-07', 'PBU-1', 'Pembayaran Biaya Utilitas', 18, '2024 - 2025', 'BANK MANDIRI', 5, 'SMA', 'Biaya utilitas SMA', 0, 5000000, 7, '', '116'),
	(1, '2024-12-08', 'PUSR-2', 'Pendapatan Uang Seragam Siswa', 18, '2024 - 2025', 'BANK BCA', 5, 'SMA', 'Pendapatan uang seragam SMA', 8000000, 0, 8, 'Rutin', '117'),
	(1, '2024-12-08', 'PUSR-2', 'Pendapatan Uang Seragam Siswa', 18, '2024 - 2025', 'PENERIMAAN - UANG SERAGAM', 5, 'SMA', 'Pendapatan uang seragam SMA', 0, 8000000, 8, '', '536'),
	(1, '2024-12-09', 'PAS-2', 'Pembayaran Asuransi', 18, '2024 - 2025', 'BI - ASURANSI', 5, 'SMA', 'Asuransi sekolah SMA', 4000000, 0, 9, 'Rutin', '708'),
	(1, '2024-12-09', 'PAS-2', 'Pembayaran Asuransi', 18, '2024 - 2025', 'BANK BCA', 5, 'SMA', 'Asuransi sekolah SMA', 0, 4000000, 9, '', '117'),
	(1, '2024-12-10', 'PUG-1', 'Pendapatan Uang Gedung', 18, '2024 - 2025', 'BANK MANDIRI', 5, 'SMA', 'Pendapatan uang gedung SMA', 20000000, 0, 10, 'Rutin', '116'),
	(1, '2024-12-10', 'PUG-1', 'Pendapatan Uang Gedung', 18, '2024 - 2025', 'PENERIMAAN - UANG GEDUNG', 5, 'SMA', 'Pendapatan uang gedung SMA', 0, 20000000, 10, '', '549'),
	(1, '2024-12-11', 'PAT-3', 'Pembelian Alat Tulis', 18, '2024 - 2025', 'BI - ALAT TULIS& CETAKAN', 5, 'SMA', 'Pembelian pensil dan penghapus SMA', 2500000, 0, 11, 'Rutin', '706'),
	(1, '2024-12-11', 'PAT-3', 'Pembelian Alat Tulis', 18, '2024 - 2025', 'KAS', 5, 'SMA', 'Pembelian pensil dan penghapus SMA', 0, 2500000, 11, '', '100'),
	(1, '2024-12-12', 'PBB-1', 'Penyusutan Bangunan Baru', 18, '2024 - 2025', 'BI - PENYUSUTAN BANGUNAN', 5, 'SMA', 'Penyusutan gedung baru SMA', 6000000, 0, 12, 'Rutin', '712'),
	(1, '2024-12-12', 'PBB-1', 'Penyusutan Bangunan Baru', 18, '2024 - 2025', 'AKM. PENYUSUTAN BANGUNAN BARU', 5, 'SMA', 'Penyusutan gedung baru SMA', 0, 6000000, 12, '', '211'),
	(1, '2024-12-13', 'PSG-1', 'Pembelian Seragam Guru', 18, '2024 - 2025', 'BI - SERAGAM GURU', 5, 'SMA', 'Pembelian seragam guru SMA', 3500000, 0, 13, 'Rutin', '626'),
	(1, '2024-12-13', 'PSG-1', 'Pembelian Seragam Guru', 18, '2024 - 2025', 'BANK MANDIRI', 5, 'SMA', 'Pembelian seragam guru SMA', 0, 3500000, 13, '', '116'),
	(1, '2024-12-14', 'PPPD-3', 'Penerimaan PPD/Open House', 18, '2024 - 2025', 'KAS', 5, 'SMA', 'Pendapatan open house SMA', 5000000, 0, 14, 'Rutin', '100'),
	(1, '2024-12-14', 'PPPD-3', 'Penerimaan PPD/Open House', 18, '2024 - 2025', 'PENERIMAAN - UANG P.P.D/OPEN HOUSE', 5, 'SMA', 'Pendapatan open house SMA', 0, 5000000, 14, '', '548'),
	(1, '2024-12-15', 'PBBK-2', 'Pembelian Bahan Bakar', 18, '2024 - 2025', 'BI - BAHAN BAKAR KENDARAAN SEKOLAH', 5, 'SMA', 'Pembelian bahan bakar mobil SMA', 2000000, 0, 15, 'Rutin', '729'),
	(1, '2024-12-15', 'PBBK-2', 'Pembelian Bahan Bakar', 18, '2024 - 2025', 'BANK BCA', 5, 'SMA', 'Pembelian bahan bakar mobil SMA', 0, 2000000, 15, '', '117'),
	(1, '2024-12-16', 'PK', 'Penyusutan Kendaraan', 18, '2024 - 2025', 'BI - PENYUSUTAN KENDARAAN', 5, 'SMA', 'Penyusutan mobil SMA', 3000000, 0, 16, 'Rutin', '722'),
	(1, '2024-12-16', 'PK', 'Penyusutan Kendaraan', 18, '2024 - 2025', 'AKM. PENYUSUTAN KENDARAAN', 5, 'SMA', 'Penyusutan mobil SMA', 0, 3000000, 16, '', '213'),
	(1, '2024-12-22', 'PPSK', 'Pembelian Peralatan Sekolah (kredit)', 18, '2024 - 2025', 'PERSEDIAAN - ALAT SEKOLAH', 5, 'SMA', 'Pembelian seluruh papan tulis SMA', 12000000, 0, 17, 'Rutin', '130'),
	(1, '2024-12-22', 'PPSK', 'Pembelian Peralatan Sekolah (kredit)', 18, '2024 - 2025', 'HUTANG LAIN2', 5, 'SMA', 'Pembelian seluruh papan tulis SMA', 0, 12000000, 17, '', '399'),
	(1, '2024-12-23', 'PPUS-1', 'Pelunasan Piutang Uang Sekolah', 18, '2024 - 2025', 'BANK MANDIRI', 5, 'SMA', 'Pembayaran uang sekolah siswa terlambat', 15000000, 0, 18, 'Rutin', '116'),
	(1, '2024-12-23', 'PPUS-1', 'Pelunasan Piutang Uang Sekolah', 18, '2024 - 2025', 'PIUT. UANG SEKOLAH', 5, 'SMA', 'Pembayaran uang sekolah siswa terlambat', 0, 15000000, 18, '', '120'),
	(1, '2024-12-26', 'PSSK', 'Pembelian Seragam Siswa (kredit)', 18, '2024 - 2025', 'PERSEDIAAN - PAKAIAN/SERAGAM', 5, 'SMA', 'Pembelian seragam SMA secara kredit', 3000000, 0, 19, 'Rutin', '133'),
	(1, '2024-12-26', 'PSSK', 'Pembelian Seragam Siswa (kredit)', 18, '2024 - 2025', 'HUTANG LAIN2', 5, 'SMA', 'Pembelian seragam SMA secara kredit', 0, 3000000, 19, '', '399'),
	(1, '2024-12-30', 'PBPS-1', 'Pembayaran Biaya Promosi Sekolah', 18, '2024 - 2025', 'BI - IKLAN & PROMOSI', 5, 'SMA', 'Biaya promosi SMA ke SMP di Semarang', 5000000, 0, 20, 'Rutin', '628'),
	(1, '2024-12-30', 'PBPS-1', 'Pembayaran Biaya Promosi Sekolah', 18, '2024 - 2025', 'BANK MANDIRI', 5, 'SMA', 'Biaya promosi SMA ke SMP di Semarang', 0, 5000000, 20, '', '116'),
	(1, '2024-12-24', 'PBPS-1', 'Pembayaran Biaya Promosi Sekolah', 18, '2024 - 2025', 'BI - IKLAN & PROMOSI', 5, 'SMA', 'Promosi ke SMP di kota Salatiga', 8000000, 0, 21, 'Rutin', '628'),
	(1, '2024-12-24', 'PBPS-1', 'Pembayaran Biaya Promosi Sekolah', 18, '2024 - 2025', 'BANK MANDIRI', 5, 'SMA', 'Promosi ke SMP di kota Salatiga', 0, 8000000, 21, '', '116'),
	(1, '2024-12-25', 'PUD-1', 'Penerimaan Uang Denda Uang Sekolah', 18, '2024 - 2025', 'BANK MANDIRI', 5, 'SMA', 'penerimaan uang denda keterlambatan pembayaran uang sekolah', 2500000, 0, 22, 'Rutin', '116'),
	(1, '2024-12-25', 'PUD-1', 'Penerimaan Uang Denda Uang Sekolah', 18, '2024 - 2025', 'PENERIMAAN - UANG DENDA', 5, 'SMA', 'penerimaan uang denda keterlambatan pembayaran uang sekolah', 0, 2500000, 22, '', '537'),
	(1, '2024-12-20', 'PIL-1', 'Penyusutan Inventaris Lab', 18, '2024 - 2025', 'BI - PENYUSUTAN INV. KANTOR', 5, 'SMA', 'Penyusutan peralatan laboratorium SMA', 850000, 0, 23, 'Rutin', '611'),
	(1, '2024-12-20', 'PIL-1', 'Penyusutan Inventaris Lab', 18, '2024 - 2025', 'AKM. PENYUSUTAN INVENTARIS LABORAT ', 5, 'SMA', 'Penyusutan peralatan laboratorium SMA', 0, 850000, 23, '', '215'),
	(1, '2025-04-03', 'PUS-1', 'Penerimaan Uang Sekolah (Mandiri)', 18, '2024 - 2025', 'BANK MANDIRI', 5, 'SMA', 'Pendapatan uang sekolah siswa teralambat', 5000000, 0, 24, 'Rutin', '116'),
	(1, '2025-04-03', 'PUS-1', 'Penerimaan Uang Sekolah (Mandiri)', 18, '2024 - 2025', 'PENERIMAAN - UANG SEKOLAH', 5, 'SMA', 'Pendapatan uang sekolah siswa teralambat', 0, 5000000, 24, '', '500'),
	(0, '2024-12-31', 'PUS-1', 'Penerimaan Uang Sekolah (Mandiri)', 18, '2024 - 2025', 'BANK MANDIRI', 5, 'SMA', 'penerimaan uang seklah SMP', 1000000, 0, 25, 'Rutin', '116'),
	(0, '2024-12-31', 'PUS-1', 'Penerimaan Uang Sekolah (Mandiri)', 18, '2024 - 2025', 'PENERIMAAN - UANG SEKOLAH', 5, 'SMA', 'penerimaan uang seklah SMP', 0, 1000000, 25, '', '500');

-- Dumping structure for table db_nusput_akt.transaksi_bank
CREATE TABLE IF NOT EXISTS `transaksi_bank` (
  `status` int NOT NULL,
  `jenis_transaksi` varchar(255) NOT NULL,
  `no_transaksi` bigint NOT NULL,
  `tanggal` date NOT NULL,
  `sumber_dana` varchar(255) NOT NULL,
  `kode_tahun` varchar(255) NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `no_kasbon` varchar(255) NOT NULL,
  `kode_akun` varchar(255) NOT NULL,
  `nama_akun` varchar(255) NOT NULL,
  `kode_jenjang` varchar(255) NOT NULL,
  `nama_jenjang` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `debit` bigint NOT NULL,
  `kredit` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.transaksi_bank: ~0 rows (approximately)

-- Dumping structure for table db_nusput_akt.transaksi_kas
CREATE TABLE IF NOT EXISTS `transaksi_kas` (
  `status` int NOT NULL,
  `jenis_transaksi` varchar(255) NOT NULL,
  `no_transaksi` bigint NOT NULL,
  `tanggal` date NOT NULL,
  `kode_tahun` varchar(255) NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `sumber_dana` varchar(255) NOT NULL,
  `kode_akun` varchar(255) NOT NULL,
  `nama_akun` varchar(255) NOT NULL,
  `kode_jenjang` varchar(255) NOT NULL,
  `nama_jenjang` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `debit` bigint NOT NULL,
  `kredit` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.transaksi_kas: ~0 rows (approximately)

-- Dumping structure for table db_nusput_akt.transaksi_memorial
CREATE TABLE IF NOT EXISTS `transaksi_memorial` (
  `status` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `sumber_dana` varchar(255) NOT NULL,
  `no_transaksi` varchar(255) NOT NULL,
  `kode_jenjang` varchar(255) NOT NULL,
  `nama_jenjang` varchar(255) NOT NULL,
  `kode_tahun` varchar(255) NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `kode_akun` varchar(255) NOT NULL,
  `nama_akun` varchar(255) NOT NULL,
  `debit` bigint NOT NULL,
  `kredit` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.transaksi_memorial: ~102 rows (approximately)
INSERT INTO `transaksi_memorial` (`status`, `tanggal`, `sumber_dana`, `no_transaksi`, `kode_jenjang`, `nama_jenjang`, `kode_tahun`, `tahun_ajaran`, `keterangan`, `kode_akun`, `nama_akun`, `debit`, `kredit`) VALUES
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '100', 'KAS', 15000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '116', 'BANK MANDIRI', 480000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '117', 'BANK BCA', 867518500, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '120', 'PIUT. UANG SEKOLAH', 86000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '124', 'PIUT. UANG PRAKTEK', 2000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '129', 'PIUT. LAIN2', 4000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '130', 'PERSEDIAAN - ALAT SEKOLAH', 6500000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '131', 'PERSEDIAAN - BAHAN PRAKTIKUM', 9700000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '132', 'PERSEDIAAN - ALAT OLAH RAGA', 13250000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '133', 'PERSEDIAAN - PAKAIAN/SERAGAM', 8600000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '139', 'PERSEDIAAN - LAIN2', 3100000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '140', 'UANG MUKA PEMBELIAN', 4700000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '141', 'UANG MUKA (BIAYA DIBYR DMK)', 1000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '142', 'PIUTANG MODAL BISNIS CENTER', 13000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '200', 'TANAH', 9000000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '201', 'BANGUNAN LAMA', 15000000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '202', 'BANGUNAN BARU', 20238465000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '203', 'LAPANGAN OLAH RAGA & PAGAR', 350000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '204', 'KENDARAAN', 875000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '205', 'INVENTARIS KANTOR / KELAS', 390000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '206', 'INVENTARIS LAB', 120000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '207', 'INVENTARIS UMUM', 87000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '208', 'INVENTARIS PERPUSTAKAAN (BUKU,VCD,DLL)', 35000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '210', 'AKM. PENYUSUTAN BANGUNAN LAMA', 0, 177000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '211', 'AKM. PENYUSUTAN BANGUNAN BARU', 0, 154000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '212', 'AKM. PENYUSUTAN LAPANGAN OR', 0, 70000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '213', 'AKM. PENYUSUTAN KENDARAAN', 0, 23000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '214', 'AKM. PENYUSUTAN INVENTARIS KANTOR', 0, 8000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '215', 'AKM. PENYUSUTAN INVENTARIS LABORAT', 0, 9800000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '216', 'AKM. PENYUSUTAN INVENTARIS UMUM', 0, 7600000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '301', 'HTG. BI. LAB', 0, 13500000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '302', 'HTG. BI. KANTOR', 0, 14750000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '303', 'HTG. BI. GAJI & TUNJ', 0, 7500000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '304', 'HTG. BI. PENGAJARAN', 0, 8955000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '305', 'HTG. BUKU', 0, 9500000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '309', 'HTG. BI. PRAMUKA', 0, 2760000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '310', 'HTG. BI. PERPUSTAKAAN', 0, 4560000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '311', 'HTG. BI. LAIN2', 0, 79000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '319', 'TITIPAN UANG SERAGAM', 0, 45000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '320', 'UANG MUKA - SEKOLAH', 0, 285000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '324', 'UANG MUKA - PRAKTEK', 0, 33765000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '327', 'UANG MUKA - KARYAWISATA', 0, 48750000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '328', 'UANG MUKA - UKS', 0, 750000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '333', 'UANG MUKA - MASAK', 0, 8000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '335', 'UANG MUKA - EKSTRA', 0, 35000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '345', 'UANG MUKA - KEGIATAN SISWA', 0, 85000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '346', 'UANG MUKA - FOTO,KARTU SISWA, MAP, PLAKAT', 0, 5000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '360', 'UANG MUKA - OPERASIONAL PENDIDIKAN', 0, 75000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '399', 'HUTANG LAIN2', 0, 47000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '401', 'MODAL', 0, 20000000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '402', 'LABA RUGI DITAHAN', 0, 24956075000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '403', 'LABA RUGI TAHUN BERJALAN', 0, 1256033500),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '500', 'PENERIMAAN - UANG SEKOLAH', 0, 693020000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '501', 'PENERIMAAN - UANG UJIAN', 0, 7200000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '502', 'PENERIMAAN - UANG KARYAWISATA', 0, 35000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '503', 'PENERIMAAN - UANG UKS', 0, 350000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '505', 'PENERIMAAN - UANG EXTRA KUL', 0, 2500000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '506', 'PENERIMAAN - UANG KOMPUTER/IT', 0, 4500000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '507', 'PENERIMAAN - UANG MASAK', 0, 3000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '508', 'PENERIMAAN - UANG BUKU/LKS/MODUL', 0, 2750000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '511', 'PENERIMAAN - UANG PENGAJARAN', 0, 6500000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '514', 'PENERIMAAN - DAY CARE', 0, 18650000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '515', 'PENERIMAAN - PRA PLAYGROUP', 0, 23450000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '531', 'PENERIMAAN - UANG PRAKTEK', 0, 2000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '536', 'PENERIMAAN - UANG SERAGAM', 0, 2300000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '537', 'PENERIMAAN - UANG DENDA', 0, 4950000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '538', 'PENERIMAAN - BOSS/BPP', 0, 50000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '548', 'PENERIMAAN - UANG P.P.D/OPEN HOUSE', 0, 8500000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '549', 'PENERIMAAN - UANG GEDUNG', 0, 150000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '550', 'PENERIMAAN - KOMITE', 0, 15000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '899', 'PENDAPATAN - LAIN2', 0, 3000000),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '611', 'BI - PENYUSUTAN INV. KANTOR', 8000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '612', 'BI - PENYUSUTAN INV. LABORAT', 1300000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '712', 'BI - PENYUSUTAN BANGUNAN', 273000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '713', 'BI - PENYUSUTAN INVENTARIS', 7600000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '722', 'BI - PENYUSUTAN KENDARAAN', 12000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '600', 'BI - GAJI & TUNJ GURU TETAP', 175000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '700', 'BI - GAJI & TUNJ KARY', 135000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '626', 'BI - SERAGAM GURU', 185000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '702', 'BI - SERAGAM KARY', 375000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '602', 'BI - KESEJAHTERAAN & PENGOBATAN', 200000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '603', 'BI - PRAMUKA & EX SCHOOL', 750000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '604', 'BI - PENGAJARAN', 550000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '605', 'BI - PERAWATAN KELAS', 230000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '606', 'BI - ALAT TULIS & CETAKAN', 360000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '609', 'BI - BAHAN PRAKTIKUM', 1450000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '622', 'BI - KARYAWISATA', 38000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '628', 'BI - IKLAN & PROMOSI', 35000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '630', 'BI - PERPUSTAKAAN', 725000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '636', 'BI - PENGABDIAN MASYARAKAT', 6500000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '637', 'BI - BUKU', 250000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '641', 'BI - SERAGAM SISWA/MAHASISWA', 160000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '645', 'BI - KEGIATAN KE OSIS AN / KEPEMIMPINAN', 3000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '647', 'BI - LOMBA PELAJARAN', 4500000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '704', 'BI - MAKAN, MINUM, DAPUR', 6000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '706', 'BI - ALAT TULIS& CETAKAN', 1500000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '708', 'BI - ASURANSI', 24000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '710', 'BI - LISTRIK,AIR, SAMPAH, KSM', 130000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '717', 'BI - PELATIHAN KARY', 8000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '729', 'BI - BAHAN BAKAR KENDARAAN SEKOLAH', 2500000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '798', 'BI - PENINGKATAN MUTU GURU', 15000000, 0),
	('1', '2024-11-30', 'Rutin', '1', '12', 'UMUM', '18', '2024 - 2025', '', '799', 'BI - LAIN2 (TABUNG PEMADAM KEBAKARAN)', 2000000, 0);

-- Dumping structure for table db_nusput_akt.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_nusput_akt.user: ~6 rows (approximately)
INSERT INTO `user` (`id`, `username`, `password`, `admin`) VALUES
	(26, 'adminutama', '50aad2aef7fab68190b407f0ca0724650ecf4f483ef7c5b509d2836118d64a86e524bc1f35e1a15de3e0963c5ef31620ccf12d4ae94623adf9c9d3ff05f79447', 'adminutama'),
	(27, 'adminsatu', '96df0d3b353e7fe0f5f08d6835260b76bdca195a7c7c4798ee7ae3f69dc70f641806360cbd06a32bf3fc738746347ccd9bf8cd584e92c70769c47c435a363f89', 'adminsatu'),
	(28, 'admindua', '2048944ea49003e1d6a71bedf88fa76084c5356a86415b7d07b2b36762e607cc513a11c1d69b726cf20ef6c9b6b85eabeb75c9d13f8b16d04055b204e11dad68', 'admindua'),
	(29, 'admintiga', 'b1d537d78c9a59da59c4e218a63bccc74d83461ad1c89998b952dc1edd671328587a73a1c77f1e3b44e031ab5ce9b343776ed11b816d2d9b8e5841b771bc801e', 'admintiga'),
	(30, 'adminempat', '1d6b4106242ca7bf836f93f30e1c3f7ba6f667b854b7be26f6aafeec84e9b094628874d05c2cec97b41f2dc984db140b5c41cd1f81f9a7c02214d0ae8871b5a1', 'adminempat'),
	(31, 'adminlima', '432765c1a5b3499758f848d3158393f4380045905648a69f2592cc42141aa3fc32c2d17ea3bd107040d9ea831179f7f6218ef6d7e273b614cf9fc1a56b831280', 'adminlima'),
	(32, 'admin', '2048944ea49003e1d6a71bedf88fa76084c5356a86415b7d07b2b36762e607cc513a11c1d69b726cf20ef6c9b6b85eabeb75c9d13f8b16d04055b204e11dad68', 'admin');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
