<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operasional</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<header class="main-header">
        <div class="header-brand">
            Project <span class="separator">|</span> Operational
        </div>
        <div class="user-profile-icon">
            <i class="bi bi-person-circle"></i>
        </div>
    </header>

    <div class="tabs-section">
        <a href="{{ route('pergantianperangkat') }}" class="tab {{ request()->is('pergantianperangkat*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Pergantian Perangkat</a>
        <a href="{{ url('/logpergantian') }}" class="tab {{ request()->is('logpergantian*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Log Perangkat</a>
        <a href="{{ url('/spaetaracker') }}" class="tab {{ request()->is('sparetracker*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Spare Tracker</a>
        <a href="{{ url('/summary') }}" class="tab {{ request()->is('summary*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Summary</a>
        
    </div>

    <!-- CARD -->
    <div class="card">
        <div class="card-header">
            <div class="actions">
                <button type="button"class="btn-action bi bi-plus" title="Tambah Data"data-bs-toggle="modal"data-bs-target="#modalTambahSpare"></button>
                <button class="btn-action bi bi-upload" title="Upload"></button>
                <button class="btn-action bi bi-download" title="Download"></button>
            </div>

            <form method="GET" action="{{ route('datapas') }}" class="search-form">
                <div class="search-box">
                    <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                    <button type="submit" class="search-btn">🔍</button>
                </div>
            </form>
            <div class="modal fade" id="modalTambahSpare" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg">

            <div class="modal-header border-0 pb-0">
                <h4 class="modal-title fw-bold">Tambah Data Spare Tracker</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-3">
                <form action="{{ route('sparetracker.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label label-blue">SN</label>
                            <input type="text" name="sn" class="form-control input-custom" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label label-blue">Nama Perangkat</label>
                            <input type="text" name="nama_perangkat" class="form-control input-custom">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label label-blue">Jenis</label>
                            <select name="jenis" class="form-select input-custom">
                                <option value="">-- Pilih --</option>
                                <option value="MODEM">MODEM</option>
                                <option value="ROUTER">ROUTER</option>
                                <option value="SWITCH">SWITCH</option>
                                <option value="AP1">AP1</option>
                                <option value="AP2">AP2</option>
                                <option value="STAVOL">STAVOL</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label label-blue">Type</label>
                            <input type="text" name="type" class="form-control input-custom">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label label-blue">Kondisi</label>
                            <select name="kondisi" class="form-select input-custom">
                                <option value="">-- Pilih --</option>
                                <option value="BAIK">BAIK</option>
                                <option value="RUSAK">RUSAK</option>
                                <option value="BARU">BARU</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label label-blue">Pengadaan By</label>
                            <input type="text" name="pengadaan_by" class="form-control input-custom">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label label-blue">Lokasi Asal</label>
                            <input type="text" name="lokasi_asal" class="form-control input-custom">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label label-blue">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control input-custom">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label label-blue">Bulan Masuk</label>
                            <input type="text" name="bulan_masuk" class="form-control input-custom">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label label-blue">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control input-custom">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label label-blue">Status Penggunaan</label>
                            <input type="text" name="status_penggunaan_sparepart" class="form-control input-custom">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label label-blue">Lokasi Realtime</label>
                            <input type="text" name="lokasi_realtime" class="form-control input-custom">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label label-blue">Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control input-custom">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label label-blue">Bulan Keluar</label>
                            <input type="text" name="bulan_keluar" class="form-control input-custom">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label label-blue">Tanggal Keluar</label>
                            <input type="date" name="tanggal_keluar" class="form-control input-custom">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label label-blue">Layanan AI</label>
                            <input type="text" name="layanan_ai" class="form-control input-custom">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label label-blue">Keterangan</label>
                            <textarea name="keterangan" rows="2" class="form-control input-custom"></textarea>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary px-4 rounded-3">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
        </div>

        <table>
            <thead class="table-dark">
                <tr>
                    <th>NO</th>
                    <th>SN</th>
                    <th>NAMA PERANGKAT</th>
                    <th>JENIS</th>
                    <th>TYPE</th>
                    <th>KONDISI</th>
                    <th>PENGADAAN BY</th>
                    <th>LOKASI ASAL</th>
                    <th>LOKASI</th>
                    <th>TANGGAL MASUK</th>
                    <th>TANGGAL KELUAR</th>
                    <th>STATUS PENGGUNAAN</th>
                    <th>LOKASI REALTIME</th>
                    <th>KABUPATEN</th>
                    <th>LAYANAN AI</th>
                    <th>KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="16" class="empty text-center">
                        Showing 0 of 0 results
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
    

</body>
</html>