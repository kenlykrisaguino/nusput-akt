<?php
mysqli_report (MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	session_start();
include 'connect.php';
	
if(empty($_SESSION['adminsatu']) && empty($_SESSION['admintiga'])) {
    header("location: login.php");
    exit(); // Pastikan exit() untuk menghentikan eksekusi lebih lanjut
}

?>	
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistem Akuntansi Nusaputera</title>

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

 </head>

 <body id="page-top">
  <div id="wrapper">
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon rotate-n-0">
    <img src="nusput.png" alt="Nusaputera Logo" style="width: 40px; height: 40px;">  </div>
  <div class="sidebar-brand-text mx-2">Nusaputera</div>
      </a>

	  <!-- Divider -->
      <hr class="sidebar-divider my-0">

<?php
if (isset($_SESSION['adminsatu']) || isset($_SESSION['admindua'])) {
    $user = $_SESSION['adminsatu'] ?? $_SESSION['admindua'];
}
$sql =$konektor->query("select * from user where id='$user'");
$data = $sql->fetch_assoc();
?>

      <li class="nav-item active">
        <a class="nav-link" href="?page=home">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
      Menu :
      </div>
	 
      <li class="nav-item active">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseData" aria-expanded="true" aria-controls="collapseData">
      <i class="fas fa-fw fa-folder"></i>
      <span>Data Master</span>
    </a>
    <div id="collapseData" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Data Master :</h6>
      <a class="collapse-item" href="?page=jenjang">Jenjang</a>
        <a class="collapse-item" href="?page=th_ajaran">Tahun Ajaran</a>
        <a class="collapse-item" href="?page=coa">Chart of Account</a>
        <a class="collapse-item" href="?page=master_transaksi">Jurnal</a>

        <!-- <a class="collapse-item" href="?page=kegiatan">Master Kegiatan</a>
        <a class="collapse-item" href="?page=lokasi">Master Lokasi</a> -->
      </div>
    </div>
  </li>

      <!-- <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsetransaksi" aria-expanded="true" aria-controls="collapsetransaksi">
        <i class="bi bi-building"></i>
        <span>Aset Tetap</span>
        </a>
        <div id="collapsetransaksi" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Jenis Transaksi :</h6>
          <a class="collapse-item" href="?page=aset">Aset Tetap</a>
          <a class="collapse-item" href="?page=transaksi_kas">Transaksi Kas</a>
          <a class="collapse-item" href="?page=transaksi_memorial">Transaksi Memorial</a>
          </div>
        </div>
      </li> -->

      <!-- <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseanggaran" aria-expanded="true" aria-controls="collapseanggaran">
        <i class="bi bi-cart-check-fill"></i>
        <span>Budgeting</span>
        </a>
        <div id="collapseanggaran" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Jenis Transaksi :</h6>
          <a class="collapse-item" href="?page=aset">Aset Tetap</a>
          <a class="collapse-item" href="?page=transaksi_kas">Transaksi Kas</a>
          <a class="collapse-item" href="?page=transaksi_memorial">Transaksi Memorial</a>
          </div>
        </div>
      </li> -->

      <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsebudgeting" aria-expanded="true" aria-controls="collapsebudgeting">
        <i class="far fa-money-bill-alt"></i>
          <span>Transaksi Keuangan</span>
        </a>
        <div id="collapsebudgeting" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Jenis Transaksi :</h6>
          <!-- <a class="collapse-item" href="?page=transaksi_bank">Transaksi Bank</a>
          <a class="collapse-item" href="?page=transaksi_kas">Transaksi Kas</a> -->
          <a class="collapse-item" href="?page=transaksi&aksi=data">Transaksi Keuangan</a>
          <a class="collapse-item" href="?page=transaksi_memorial&aksi=data">Penjurnalan Memorial</a>
          </div>
        </div>
      </li>

  <li class="nav-item active">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapselaporan" aria-expanded="true" aria-controls="collapselaporan">
      <i class="fas fa-chart-line"></i>
      <span>Laporan</span>
    </a>
    <div id="collapselaporan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Jenis Laporan :</h6>
        <!-- <a class="collapse-item" href="?page=tunggakan">Tunggakan Kasbon</a> -->
        <a class="collapse-item" href="?page=buku_besar">Buku Besar</a>    
        <a class="collapse-item" href="?page=neracasaldo">Neraca Saldo</a>
        <a class="collapse-item" href="?page=labarugi">Laporan Laba Rugi</a>
        <a class="collapse-item" href="?page=neraca">Laporan Posisi Keuangan</a>
        <!-- <a class="collapse-item" href="?page=cashflow">Cash Flow</a> -->

        <!-- Tambah button di bawah menu -->
        <!-- <button id="hitung_dan_unggah" class="btn btn-primary" style="margin-left: 20px;">Hitung Ulang</button> -->
        <script>
        document.getElementById('hitung_dan_unggah').addEventListener('click', function() {
            hitungDanUnggah();
        });
        function hitungDanUnggah() {
            var now = new Date(); // Mendapatkan tanggal saat ini
            var tahun = now.getFullYear(); // Mendapatkan tahun saat ini
            var bulan = now.getMonth() + 1; // Mendapatkan bulan saat ini (dimulai dari 0)

            // Mengatur tanggal awal sebagai hari pertama bulan ini
            var tanggal_awal = tahun + '-' + ('0' + bulan).slice(-2) + '-01';

            // Mendapatkan hari terakhir dari bulan ini
            var tanggal_akhir = new Date(tahun, bulan, 0).toISOString().split('T')[0];

            // Kirim tanggal awal dan akhir ke server untuk diolah dan diunggah ke database
            kirimPermintaan(tanggal_awal, tanggal_akhir);
        }

        function kirimPermintaan(tanggal_awal, tanggal_akhir) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Berhasil melakukan permintaan, lakukan sesuatu jika diperlukan
                        console.log('Perhitungan dan unggah ke database berhasil.');
                        alert('Perhitungan dan unggah ke database berhasil.');
                    } else {
                        // Gagal melakukan permintaan, tampilkan pesan kesalahan jika diperlukan
                        console.error('Gagal melakukan permintaan:', xhr.status);
                    }
                }
            };
            xhr.open('GET', 'closing.php?tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir, true);
            xhr.send();
        }
    </script>


      </div>
    </div>
  </li>
	        <hr class="sidebar-divider d-none d-md-block">

      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

		<!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
			 <div class="top-menu">
        <ul class="nav pull-right top-menu">
           <li><a onclick="return confirm('Apakah anda yakin akan logout?')" class="btn btn-danger" class="logout" href="logout.php">Logout</a></li>
        </ul>
      </div>
</li>
          </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
		 <section class="content">
     <?php
$page = $_GET['page'];
$aksi = $_GET['aksi'];
   
   if ($page == "jenjang") {
	   if ($aksi == "") {
		   include "page/jenjang/jenjang.php";
	   }
	   else if ($aksi == "tambah") {
		   include "page/jenjang/tambah.php";
	   }
	   else if($aksi == "ubah1") {
		   include "page/jenjang/ubah1.php";
	   }
     else if($aksi == "ubah2") {
      include "page/jenjang/ubah2.php";
     }
	   else if ($aksi == "hapus") {
		   include "page/jenjang/hapus.php";
	   }
	   else if ($aksi == "backup") {
		   include "page/jenjang/backup.php";
	   }
   }
   
   else if ($page == "coa") {
	   if ($aksi == "") {
		   include "page/coa/coa.php";
	   }
	   else  if ($aksi == "tambah") {
		   include "page/coa/tambahdata.php";
	   }
	   else if ($aksi == "ubah1") {
		   include "page/coa/ubah1.php";
	   }
     else if ($aksi == "ubah2") {
      include "page/coa/ubah2.php";
     }
	   else if ($aksi == "hapus") {
		   include "page/coa/hapuscoa.php";
	   }
	   else if ($aksi == "backup") {
		   include "page/coa/backup.php";
	   }
     else if ($aksi == 'export') {
      include "page/labarugi/export.php";
     }
   }

   else if ($page == "th_ajaran") {
    if ($aksi == "") {
      include "page/th_ajaran/thajaran.php";
    }
    else  if ($aksi == "tambah") {
      include "page/th_ajaran/tambah.php";
    }
    else if ($aksi == "ubah1") {
      include "page/th_ajaran/ubah1.php";
    }
    else if ($aksi == "ubah2") {
     include "page/th_ajaran/ubah2.php";
    }
    else if ($aksi == "hapus") {
      include "page/th_ajaran/hapus.php";
    }
    else if ($aksi == "backup") {
      include "page/th_ajaran/backup.php";
    }
  }

  else if ($page == "master_transaksi") {
    if ($aksi == "") {
      include "page/master_transaksi/data.php";
    }
    else  if ($aksi == "tambah") {
      include "page/master_transaksi/tambahdata.php";
    }
    else if ($aksi == "ubah1") {
      include "page/master_transaksi/ubah1.php";
    }
    else if ($aksi == "ubah2") {
     include "page/master_transaksi/ubah2.php";
    }
    else if ($aksi == "hapus") {
      include "page/master_transaksi/hapus.php";
    }
    else if ($aksi == "backup") {
      include "page/master_transaksi/backup.php";
    }
    else if ($aksi == 'export') {
     include "page/master_transaksi/export.php";
    }
  }

  else if ($page == "transaksi") {
    if ($aksi == "") {
      include "page/transaksi/transaksi.php";
    }
    else if ($aksi == "data") {
      include "page/transaksi/data.php";
    }
    else if ($aksi == "print") {
      include "page/transaksi/print.php";
    }
    else if ($aksi == "jurnal") {
      include "page/transaksi/jurnal.php";
    }
    else if ($aksi == "transaksi_cancel") {
      include "page/transaksi/transaksi_cancel.php";
    }
    else if ($aksi == "cancel") {
      include "page/transaksi/cancel.php";
    }
    else if ($aksi == "export") {
      include "page/transaksi/export.php";
    }
    else if ($aksi == "bukti") {
      include "page/transaksi/bukti.php";
    }
  }

  else if ($page == "kegiatan") {
    if ($aksi == "") {
      include "page/kegiatan/kegiatan.php";
    }
    else  if ($aksi == "tambah") {
      include "page/kegiatan/tambahdata.php";
    }
    else if ($aksi == "ubah1") {
      include "page/kegiatan/ubah1.php";
    }
    else if ($aksi == "ubah2") {
     include "page/kegiatan/ubah2.php";
    }
    else if ($aksi == "hapus") {
      include "page/kegiatan/hapus.php";
    }
    else if ($aksi == "backup") {
      include "page/kegiatan/backup.php";
    }
  }

  else if ($page == "lokasi") {
    if ($aksi == "") {
      include "page/lokasi/lokasi.php";
    }
    else  if ($aksi == "tambah") {
      include "page/lokasi/tambahdata.php";
    }
    else if ($aksi == "ubah1") {
      include "page/lokasi/ubah1.php";
    }
    else if ($aksi == "ubah2") {
     include "page/lokasi/ubah2.php";
    }
    else if ($aksi == "hapus") {
      include "page/lokasi/hapus.php";
    }
    else if ($aksi == "backup") {
      include "page/lokasi/backup.php";
    }
  }

  else if ($page == "transaksi_kas") {
    if ($aksi == "") {
      include "page/transaksi_kas/input_transaksi.php";
    }
    else if ($aksi == "data") {
      include "page/transaksi_kas/data.php";
    }
    else if ($aksi == "print") {
      include "page/transaksi_kas/print.php";
    }
    else if ($aksi == "detail") {
      include "page/transaksi_kas/detail.php";
    }
    else if ($aksi == "transaksi_cancel") {
      include "page/transaksi_kas/transaksi_cancel.php";
    }
    else if ($aksi == "cancel") {
      include "page/transaksi_kas/cancel.php";
    }
    else if ($aksi == "export") {
      include "page/transaksi_kas/bukti.php";
    }
  }

   else if ($page == "transaksi_bank") {
    if ($aksi == "") {
      include "page/transaksi_bank/input_transaksi.php";
    }
    else if ($aksi == "cancel") {
      include "page/transaksi_bank/cancel.php";
    }
    else if ($aksi == "data") {
      include "page/transaksi_bank/data.php";
    }
    else if ($aksi == "detail") {
      include "page/transaksi_bank/detail.php";
    }
    else if ($aksi == "print") {
      include "page/transaksi_bank/print.php";
    }
    else if ($aksi == "export") {
      include "page/transaksi_bank/bukti.php";
    }
    else if ($aksi == "transaksi_cancel") {
      include "page/transaksi_bank/transaksi_cancel.php";
    }
    else if ($aksi == "kasbon") {
      include "page/transaksi_bank/searchkasbon.php";
    }
    else if ($aksi == "kasbon2") {
      include "page/transaksi_bank/kasbon.php";
    }
  }

  else if ($page == "transaksi_kasbon") {
    if ($aksi == "") {
      include "page/transaksi_kasbon/data.php";
    }
    else if ($aksi == "cancel") {
      include "page/transaksi_kasbon/cancel.php";
    }
    else if ($aksi == "input") {
      include "page/transaksi_kasbon/searchkasbon.php";
    }
    else if ($aksi == "detail") {
      include "page/transaksi_kasbon/detail.php";
    }
    else if ($aksi == "print") {
      include "page/transaksi_kasbon/print.php";
    }
    else if ($aksi == "export") {
      include "page/transaksi_kasbon/bukti.php";
    }
    else if ($aksi == "transaksi_cancel") {
      include "page/transaksi_kasbon/transaksi_cancel.php";
    }
    else if ($aksi == "kasbon2") {
      include "page/transaksi_kasbon/kasbon.php";
    }
  }

  else if ($page == "transaksi_memorial") {
    if ($aksi == "") {
      include "page/transaksi_memorial/input_transaksi.php";
    }
    else if ($aksi == "data") {
      include "page/transaksi_memorial/data.php";
    }
    else if ($aksi == "detail") {
      include "page/transaksi_memorial/detail.php";
    }
    else if ($aksi == "print") {
      include "page/transaksi_memorial/print.php";
    }
    else if ($aksi == "cancel") {
      include "page/transaksi_memorial/cancel.php";
    }
    else if ($aksi == "transaksi_cancel") {
      include "page/transaksi_memorial/transaksi_cancel.php";
    }
    else if ($aksi == "export") {
      include "page/transaksi_memorial/bukti.php";
    }
  }

  else if ($page == "labarugi") {
    if ($aksi == "") {
      include "page/labarugi/export.php";
    }
  }

  else if ($page == "neracasaldo") {
    if ($aksi == "") {
      include "page/neracasaldo/export.php";
    }
  }

  else if ($page == "neraca") {
    if ($aksi == "") {
      include "page/neraca/export.php";
    }
  }  

  else if ($page == "tunggakan") {
    if ($aksi == "") {
      include "page/tunggakan/export.php";
    }
  }
  
  else if ($page == "buku_besar") {
    if ($aksi == "") {
      include "page/buku_besar/export.php";
    }
  }

  else if ($page == "budgeting") {
    if ($aksi == "") {
      include "page/budgeting/budget.php";
    }
  }

  else if ($page == "aset") {
    if ($aksi == "") {
      include "page/aset/data_aset.php";
    }
    else if ($aksi == "input") {
      include "page/aset/input_aset.php";
    }
    else if ($aksi == "detail") {
      include "page/aset/detail_aset.php";
    }
    else if ($aksi == "ubah") {
      include "page/aset/ubah_aset.php";
    }
    else if ($aksi == "hapus") {
      include "page/aset/hapus_aset.php";
    }
  }

  else {
    include "home2.php";
  }
 
?>
    </section>
</div>
  


    </div>
    <footer class="sticky-footer bg-white">
    <div class="copyright text-center my-auto">
    <span>2023 - Alvin Handoyo & Ervina Graciella</span>
    </div>
    </div>
  </footer>
  </div>
  </div>
  

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="js/demo/datatables-demo.js"></script>
  
</body>
</html>