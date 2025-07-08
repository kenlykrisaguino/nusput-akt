<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Akuntansi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .dashboard-card {
            border-radius: 15px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .dashboard-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 50px;
        }

        .category-btn {
            margin: 5px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container mt-4">
        <!-- <img src="nusput.png" alt="Logo Nusaputera" class="mb-3" width="50"> -->
        <h1 class="mb-2">Dashboard</h1>
        <h3 class="text-muted">Selamat Datang di Sistem Pencatatan Aset Sekolah Nusaputera</h3>

        <!-- Tombol Kategori -->
        <div class=" mt-3">
            <button class="btn btn-primary category-btn" onclick="filterCategory('semua')">Semua</button>
            <button class="btn btn-secondary category-btn" onclick="filterCategory('master')">Master Data</button>
            <button class="btn btn-success category-btn" onclick="filterCategory('aset')">Manajemen Aset</button>
            <button class="btn btn-warning category-btn" onclick="filterCategory('budgeting')">Budgeting</button>
            <!-- <button class="btn btn-info category-btn" onclick="filterCategory('transaksi')">Transaksi</button>
            <button class="btn btn-danger category-btn" onclick="filterCategory('laporan')">Laporan</button> -->
        </div>

        <!-- Kartu-Kartu -->
        <div class="row mt-4" id="card-container">

            <!-- Master Data -->
            <div class="col-xl-3 col-md-6 mb-4 card-item master semua">
                <div class="card dashboard-card shadow-sm border-left-primary p-3">
                    <a href="?page=jenjang" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-folder card-icon text-primary"></i>
                            <h5 class="mt-3">Data Master Jenjang</h5>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 card-item master semua">
                <div class="card dashboard-card shadow-sm border-left-success p-3">
                    <a href="?page=th_ajaran" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-folder card-icon text-success"></i>
                            <h5 class="mt-3">Data Master Tahun Ajaran</h5>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 card-item master semua">
                <div class="card dashboard-card shadow-sm border-left-warning p-3">
                    <a href="?page=coa" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-folder card-icon text-warning"></i>
                            <h5 class="mt-3">Data Master COA</h5>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 card-item master aset semua">
                <div class="card dashboard-card shadow-sm border-left-danger p-3">
                    <a href="?page=lokasi" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt card-icon text-danger"></i>
                            <h5 class="mt-3">Data Master Lokasi</h5>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 card-item master budgeting semua">
                <div class="card dashboard-card shadow-sm border-left-info p-3">
                    <a href="?page=kegiatan" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-alt card-icon text-info"></i>
                            <h5 class="mt-3">Data Master Kegiatan</h5>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Manajemen Aset -->
            <div class="col-xl-3 col-md-6 mb-4 card-item aset semua">
                <div class="card dashboard-card shadow-sm border-left-dark p-3">
                    <a href="?page=aset" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-boxes card-icon text-dark"></i>
                            <h5 class="mt-3">Aset</h5>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Budgeting -->
            <div class="col-xl-3 col-md-6 mb-4 card-item budgeting semua">
                <div class="card dashboard-card shadow-sm border-left-primary p-3">
                    <a href="?page=budgeting" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-pie card-icon text-primary"></i>
                            <h5 class="mt-3">Budgeting</h5>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Transaksi -->
            <!-- <div class="col-xl-3 col-md-6 mb-4 card-item transaksi semua">
                <div class="card dashboard-card shadow-sm border-left-success p-3">
                    <a href="?page=transaksi_bank" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-university card-icon text-success"></i>
                            <h5 class="mt-3">Transaksi Bank</h5>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 card-item transaksi semua">
                <div class="card dashboard-card shadow-sm border-left-primary p-3">
                    <a href="?page=transaksi_memorial" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-book card-icon text-secondary"></i>
                            <h5 class="mt-3">Transaksi Memorial</h5>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 card-item transaksi semua">
                <div class="card dashboard-card shadow-sm border-left-primary p-3">
                    <a href="?page=transaksi_kas" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="far fa-money-bill-alt card-icon text-primary"></i>
                            <h5 class="mt-3">Transaksi Kas</h5>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 card-item transaksi semua">
                <div class="card dashboard-card shadow-sm border-left-secondary p-3">
                    <a href="?page=transaksi_oto" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-sync-alt card-icon text-secondary"></i>
                            <h5 class="mt-3">Transaksi Otomatis</h5>
                        </div>
                    </a>
                </div>
            </div>

            Laporan
            <div class="col-xl-3 col-md-6 mb-4 card-item laporan semua">
                <div class="card dashboard-card shadow-sm border-left-dark p-3">
                    <a href="?page=labarugi" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line card-icon text-dark"></i>
                            <h5 class="mt-3">Laba Rugi</h5>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 card-item laporan semua">
                <div class="card dashboard-card shadow-sm border-left-dark p-3">
                    <a href="?page=posisi_keuangan" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-balance-scale card-icon text-dark"></i>
                            <h5 class="mt-3">Neraca</h5>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 card-item laporan semua">
                <div class="card dashboard-card shadow-sm border-left-danger p-3">
                    <a href="?page=buku_besar" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-book card-icon text-danger"></i>
                            <h5 class="mt-3">Buku Besar</h5>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 card-item laporan semua">
                <div class="card dashboard-card shadow-sm border-left-primary p-3">
                    <a href="?page=neraca_saldo" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-file-invoice card-icon text-primary"></i>
                            <h5 class="mt-3">Neraca Saldo</h5>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 card-item laporan semua">
                <div class="card dashboard-card shadow-sm border-left-success p-3">
                    <a href="?page=tunggakan_kasbon" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-money-bill-wave card-icon text-success"></i>
                            <h5 class="mt-3"> Tunggakan Kasbon</h5>
                        </div>
                    </a>
                </div>
            </div>  -->


        </div> <!-- End Row -->
    </div>

    <script>
        function filterCategory(category) {
            let cards = document.querySelectorAll('.card-item');
            cards.forEach(card => {
                if (category === 'semua' || card.classList.contains(category)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>