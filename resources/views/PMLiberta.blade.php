<!DOCTYPE html>
<html>
<head>
    @include('components.nav-modal-structure')
    <title>Management PM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .search-box {;
            display: flex;
            align-items: center;
        }

        .search-box input {
            border: none;
            outline: none;
            padding: 20px;
            background: transparent;
        }

        .filter-btn i {
            color: #555;
            font-size: 1.1rem;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header class="main-header">
        <div class="header-logo-container">
            <a href="javascript:void(0)" class="header-brand-link" onclick="openNavModal()" style="text-decoration: none !important; color: white !important;">
                <div class="header-brand" style="display: flex; align-items: center; gap: 8px; font-weight: bold;">
                    Project <span style="opacity: 0.5;">|</span> Operational
                </div>
            </a>
        </div>

        <div class="user-profile-wrapper" style="position: relative;">
            <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor: pointer;">
                <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
            </div>

            <div id="profileDropdownMenu" class="hidden" style="position: absolute; right: 0; top: 100%; mt: 10px; width: 150px; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1000; display: none; flex-direction: column; overflow: hidden;">
                <div style="padding: 10px 15px; border-bottom: 1px solid #eee; font-size: 14px; font-weight: bold; color: #333;">
                    {{ auth()->user()->name }}
                </div>
                
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button type="submit" style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="tabs-section">
        <a href="{{ route('datasite') }}" class="tab {{ request()->is('datasite*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">All Sites</a>
        <a href="{{ url('/datapass') }}" class="tab {{ request()->is('datapass*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Management Password</a>
        <a href="{{ url('/laporanpm') }}" class="tab {{ request()->is('laporanpm*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Laporan PM</a>
        <a href="{{ url('/PMLiberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}" style="text-decoration: none; color: White;">PM Liberta</a>
        <a href="{{ url('/summarypm') }}" class="tab {{ request()->is('summarypm*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">PM Summary</a>
    </div>

    <!-- CARD -->
    <div class="card">
        <div class="card-header">
            <div class="actions">
                <!--<button type="button" class="btn-action bi bi-plus" title="Add" data-toggle="modal" data-target="#modalSite" onclick="addSite()"></button>-->
                <form action="{{ route('pmliberta.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <input type="file" name="file" id="fileInput" style="display: none;" 
                        accept=".xlsx, .xls, .csv" 
                        onchange="handleFileUpload()"> 
                    <button type="button" class="btn-action bi bi-upload" title="Upload" 
                            onclick="document.getElementById('fileInput').click();">
                    </button>
                </form>
               <a href="{{ route('pmliberta.export', ['search' => request('search')]) }}" 
                    class="btn-action bi bi-download" 
                    title="Download" 
                    style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                </a>
            </div>

            <form method="GET" action="{{ route('pmliberta') }}" class="search-form" id="searchForm">
                <div class="search-box d-flex align-items-center">
                    <button type="button" class="filter-btn" data-bs-toggle="modal" data-bs-target="#modalFilter" style="background: none; border: none; padding-left: 15px;">
                        <i class="bi bi-sliders2"></i>
                    </button>

                    <input type="text" id="searchInput" name="q" placeholder="Search..." value="{{ request('q') }}" autocomplete="off" style="flex-grow: 1; border: none; outline: none;">
                    
                    <button type="submit" class="search-btn">🔍</button>
                </div>
            </form>
        </div>

        <div style="overflow-x: auto; max-height: 600px; overflow-y: auto;">
        <table>
            <thead>
                <tr class="thead-dark">
                        <th>NO</th>
                        <th>SITE ID</th>
                        <th>NAMA LOKASI</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN / KOTA</th>
                        <th>PIC CE</th>
                        <th>MONTH</th>
                        <th>DATE</th>
                        <th>STATUS</th>
                        <th>WEEK</th>
                        <th>KATEGORI</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $item->site_id }}</td>
                        <td>{{ $item->nama_lokasi }}</td>
                        <td>{{ $item->provinsi }}</td>
                        <td>{{ $item->kabupaten }}</td>
                        <td>{{ $item->pic_ce }}</td>
                        <td class="text-center">{{ $item->month }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <span class="badge text-black{{ $item->status == 'Done' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-center">{{ $item->week }}</td>
                        <td class="text-center">{{ $item->kategori }}</td>
                        <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" 
                                        class="btn bi bi-pencil btn-edit" 
                                        data-id="{{ $item->id }}"
                                        data-site_id="{{ $item->site_id }}"
                                        data-nama_lokasi="{{ $item->nama_lokasi }}"
                                        data-provinsi="{{ $item->provinsi }}"
                                        data-kabupaten="{{ $item->kabupaten }}"
                                        data-date="{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('Y-m-d') : '' }}"
                                        data-month="{{ $item->month }}"
                                        data-status="{{ $item->status }}"
                                        data-week="{{ $item->week }}"
                                        data-kategori="{{ $item->kategori }}">
                                    </button>
                                    <form action="{{ route('pmliberta.destroy', $item->id) }}" method="POST" class="form-delete">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" class="btn bi bi-trash btn-delete-trigger" data-nama="{{ $item->nama_lokasi }}"> </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data PM Liberta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Site ID</label>
                            <input type="text" name="site_id" id="edit_site_id" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lokasi</label>
                            <input type="text" name="nama_lokasi" id="edit_nama_lokasi" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" id="edit_provinsi" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kabupaten</label>
                            <input type="text" name="kabupaten" id="edit_kabupaten" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date (Tanggal)</label>
                            <input type="date" name="date" id="edit_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Month</label>
                            <input type="text" name="month" id="edit_month" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Week</label>
                            <select name="week" id="edit_week" class="form-select">
                                <option value="WEEK 1">WEEK 1</option>
                                <option value="WEEK 2">WEEK 2</option>
                                <option value="WEEK 3">WEEK 3</option>
                                <option value="WEEK 4">WEEK 4</option>
                            </select>
                        </div>
                        <div class="col-md-4"> <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <option value="BMN">BMN</option>
                                <option value="SL">SL</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="DONE">DONE</option>
                                <option value="PENDING">PENDING</option>
                                <option value="ON PROGRESS">ON PROGRESS</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL FILTER --}}
<div class="modal fade" id="modalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Data PMLiberta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="{{ route('pmliberta') }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">Semua Kategori</option>
                                <option value="BMN" {{ request('kategori') == 'BMN' ? 'selected' : '' }}>BMN</option>
                                <option value="SL" {{ request('kategori') == 'SL' ? 'selected' : '' }}>SL</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="DONE" {{ request('status') == 'DONE' ? 'selected' : '' }}>DONE</option>
                                <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                <option value="ON PROGRESS" {{ request('status') == 'ON PROGRESS' ? 'selected' : '' }}>ON PROGRESS</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Dari Tanggal</label>
                            <input type="date" name="tgl_mulai" class="form-control" value="{{ request('tgl_mulai') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Sampai Tanggal</label>
                            <input type="date" name="tgl_selesai" class="form-control" value="{{ request('tgl_selesai') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('pmliberta') }}" class="btn btn-light border">Reset</a>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL FILTER -->
<script>
$(document).ready(function() {
    // Gunakan delegasi event agar tombol tetap berfungsi jika tabel di-refresh/filter
    $(document).on('click', '.btn-edit', function() {
        // 1. Ambil data dari atribut data-* tombol yang diklik
        let id          = $(this).data('id');
        let site_id     = $(this).data('site_id');
        let nama_lokasi = $(this).data('nama_lokasi');
        let provinsi    = $(this).data('provinsi');
        let kabupaten   = $(this).data('kabupaten');
        let status      = $(this).data('status');
        let week        = $(this).data('week');
        let kategori    = $(this).data('kategori');
        
        // 2. Penanganan khusus untuk Tanggal
        // Input type="date" HANYA menerima format YYYY-MM-DD
        let rawDate     = $(this).data('date'); 
        let formattedDate = '';
        if (rawDate) {
            // Memastikan jika ada jamnya (timestamp), kita ambil tanggalnya saja
            formattedDate = rawDate.split(' ')[0]; 
        }

        // 3. Masukkan nilai ke dalam input modal berdasarkan ID
        $('#edit_site_id').val(site_id);
        $('#edit_nama_lokasi').val(nama_lokasi);
        $('#edit_provinsi').val(provinsi);
        $('#edit_kabupaten').val(kabupaten);
        $('#edit_date').val(formattedDate); // Set tanggal hasil format
        $('#edit_status').val(status);
        $('#edit_week').val(week);
        $('#edit_kategori').val(kategori);

        // 4. Set action URL form secara dinamis ke route update
        // Pastikan route di web.php adalah /PMLiberta/{id}
        $('#formEdit').attr('action', '/PMLiberta/' + id);

        // 5. Tampilkan modal
        // Menggunakan cara Bootstrap 5 yang lebih stabil
        var editModal = new bootstrap.Modal(document.getElementById('modalEdit'));
        editModal.show();
    });
});
</script>
    <!-- SCRIPT UNTUK KONFIRMASI DELETE DENGAN SWEETALERT -->
    <script>
        // Otomatis Submit saat file Excel dipilih
        function handleFileUpload() {
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length > 0) {
                Swal.fire({
                    title: 'Memproses Excel...',
                    text: 'Harap tunggu, data sedang diunggah.',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                document.getElementById('importForm').submit();
            }
        }

        // SweetAlert Notifikasi Flash Message
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}" });
        @endif

        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}" });
        @endif
    </script>
<!-- SCRIPT UNTUK KONFIRMASI DELETE DENGAN SWEETALERT -->
<script>
$(document).ready(function() {
    $(document).on('click', '.btn-delete-trigger', function(e) {
        e.preventDefault();
        
        let form = $(this).closest('.form-delete');
        let namaSite = $(this).data('nama'); // Ambil nama site dari data-nama

        Swal.fire({
            title: 'Apakah Anda yakin?',
            // Gunakan backtick ( ` ) agar bisa memasukkan variabel ke dalam string
            html: "Data site <b>" + namaSite + "</b> akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                form.submit();
            }
        });
    });
});
</script>
{{-- SCRIPT UNTUK BULAN TERISI OTOMATIS SAAT UPDATE --}}
<script>
    document.getElementById('edit_date').addEventListener('change', function() {
        const dateValue = this.value; // Format: YYYY-MM-DD
        if (dateValue) {
            const dateObj = new Date(dateValue);
            
            // Daftar nama bulan dalam Bahasa Indonesia
            const months = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            
            // Ambil nama bulan berdasarkan index (0-11)
            const monthName = months[dateObj.getMonth()];
            
            // Masukkan ke input month
            document.getElementById('edit_month').value = monthName;
        } else {
            document.getElementById('edit_month').value = '';
        }
    });
</script>
<!-- SCRIPT UNTUK SUBMIT FORM PENCARIAN OTOMATIS SETELAH USER BERHENTI MENGETIK SELAMA 500MS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        let timer;

        searchInput.addEventListener('input', function() {
            // Hapus timer sebelumnya setiap kali user mengetik huruf baru
            clearTimeout(timer);

            // Set timer baru
            timer = setTimeout(() => {
                // Kirim form secara otomatis
                searchForm.submit();
            }, 100); // Jeda waktu dalam milidetik
        });

        // Trik agar kursor tetap di akhir teks setelah halaman refresh
        if (searchInput.value.length > 0) {
            searchInput.focus();
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
        }
    });
</script>
</body>
</html>