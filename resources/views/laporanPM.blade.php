<!DOCTYPE html>
<html>
<head>
    @include('components.nav-modal-structure')
    <title>Laporan PM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        <a href="{{ url('/laporanpm') }}" class="tab {{ request()->is('laporanpm*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Laporan PM</a>
        <a href="{{ url('/PMLiberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">PM Liberta</a>
        <a href="{{ url('/summarypm') }}" class="tab {{ request()->is('summarypm*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">PM Summary</a>
    </div>

<!-- CARD -->
<div class="card">
    <div class="card-header">
        <div class="actions">

            <!-- tombol plus -->
            <button type="button"
                    class="btn-action shadow-sm bi bi-plus"
                    data-bs-toggle="modal"
                    data-bs-target="#modalLaporanPM">
                <span"></span>
            </button>

            <button class="btn-action bi bi-upload" title="Upload"></button>
            <button class="btn-action bi bi-download" title="Download"></button>
        </div>

        <!-- search -->
        <form method="GET" action="{{ route('laporanpm') }}" class="search-form">
            <div class="search-box">
                <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                <button type="submit" class="search-btn">🔍</button>
            </div>
        </form>
    </div>

    <div style="overflow-x: auto; max-height: 600px; overflow-y: auto;">
        <table>
            <thead>
                <tr class="thead-dark">
                <th>NO</th>
                <th>TANGGAL SUBMIT</th>
                <th>SITE ID</th>
                <th>LOKASI SITE</th>
                <th>KABUPATEN / KOTA</th>
                <th>PROVINSI</th>
                <th>PM BULAN</th>
                <th>LAPORAN BA PM</th>
                <th>TEKNISI</th>
                <th>KENDALA</th>
                <th>ACTION</th>
                <th>KET. TAMBAHAN</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
            </thead>

            <tbody>
            @forelse($data as $item)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal_submit }}</td>
                    <td>{{ $item->site_id }}</td>
                    <td>{{ $item->lokasi_site ?? '-' }}</td>
                    <td>{{ $item->kabupaten_kota ?? '-' }}</td>
                    <td>{{ $item->provinsi ?? '-' }}</td>
                    <td>{{ $item->pm_bulan ?? '-' }}</td>
                    <td>{{ $item->laporan_ba_pm ?? '-' }}</td>
                    <td>{{ $item->teknisi ?? '-' }}</td>
                    <td>{{ $item->masalah_kendala ?? '-' }}</td>
                    <td>{{ $item->action ?? '-' }}</td>
                    <td>{{ $item->ket_tambahan ?? '-' }}</td>
                    <td>{{ $item->status ?? '-' }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-edit" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEditLaporanPM"
                                data-id="{{ $item->id }}"
                                data-tanggal="{{ $item->tanggal_submit }}"
                                data-site_id="{{ $item->site_id }}"
                                data-lokasi="{{ $item->lokasi_site }}"
                                data-kab="{{ $item->kabupaten_kota }}"
                                data-prov="{{ $item->provinsi }}"
                                data-bulan="{{ $item->pm_bulan }}"
                                data-teknisi="{{ $item->teknisi }}"
                                data-kendala="{{ $item->masalah_kendala }}"
                                data-action="{{ $item->action }}"
                                data-ket="{{ $item->ket_tambahan }}"
                                data-status="{{ $item->status }}">
                            <i class="bi bi-pencil" style="color: #0c2484;"></i>
                        </button>
                        <button type="button" class="btn btn-sm" 
                            onclick="confirmDelete('{{ $item->id }}', '{{ $item->lokasi_site }}')">
                        <i class="bi bi-trash" style="color: #dc3545;"></i></button>
                        <form id="delete-form-{{ $item->id }}" action="{{ route('laporanpm.destroy', $item->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="14" class="text-start p-3">
                        Showing 0 of 0 results
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ===================== MODAL TAMBAH LAPORAN PM ===================== -->
<div class="modal fade" id="modalLaporanPM" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg rounded-4 border-0">

            <!-- Header -->
            <div class="modal-header border-0 px-4 pt-4 " style="background-color: #071152; color: white;">
                <h4 class="modal-title fw-bold text-center w-100">Tambah Data Laporan PM</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 pb-4">
                <form action="{{ route('laporanpm.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        <!-- Tanggal Submit -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Submit</label>
                            <input type="date" name="tanggal_submit" id="tanggal_submit"
                                class="form-control form-control-lg rounded-3" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">PM Bulan</label>
                            <select name="pm_bulan" id="pm_bulan" class="form-select form-select-lg rounded-3" required>
                                <option value="">Select Month</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>

                        <!-- Nama Site -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Site</label>
                            <select name="site_id" id="siteSelect" class="form-select form-select-lg rounded-3 select2-enable" required>
                                <option value="">Pilih atau cari Nama Site</option>
                                @foreach($sites as $s)
                                    <option value="{{ $s->site_id }}"
                                            data-siteid="{{ $s->site_id }}"
                                            data-lokasi="{{ $s->sitename }}"
                                            data-kab="{{ $s->kabupaten ?? $s->kab ?? '' }}"
                                            data-prov="{{ $s->provinsi ?? '' }}">
                                        {{ $s->site_id }} - {{ $s->sitename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Site ID auto -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Site ID</label>
                            <input type="text" id="siteIdView"
                                   class="form-control form-control-lg rounded-3 bg-light"
                                   placeholder="Site ID" readonly>
                        </div>

                        <!-- Lokasi Site auto -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Lokasi Site</label>
                            <input type="text" name="lokasi_site" id="lokasiSiteView" 
                                class="form-control form-control-lg rounded-3 bg-light" 
                                placeholder="Lokasi akan terisi otomatis" readonly>
                        </div>

                        <!-- Kabupaten/Kota auto -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kabupaten / Kota</label>
                            <input type="text" name="kabupaten_kota" id="kabView"
                                   class="form-control form-control-lg rounded-3 bg-light"
                                   placeholder="Kabupaten / Kota" readonly>
                        </div>

                        <!-- Provinsi auto -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Provinsi</label>
                            <input type="text" name="provinsi" id="provView"
                                   class="form-control form-control-lg rounded-3 bg-light"
                                   placeholder="Provinsi" readonly>
                        </div>

                        <!-- Teknisi -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teknisi</label>
                            <input type="text" name="teknisi"
                                   class="form-control form-control-lg rounded-3"
                                   placeholder="Teknisi" required>
                        </div>

                        <!-- Laporan BA PM (file upload) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Laporan BA PM</label>
                            <input type="file" name="laporan_ba_pm"
                                   class="form-control form-control-lg rounded-3">
                        </div>

                        <!-- Kendala -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kendala</label>
                            <input type="text" name="masalah_kendala"
                                   class="form-control form-control-lg rounded-3"
                                   placeholder="Kendala (jika ada)">
                        </div>

                        <!-- Action -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Action</label>
                            <input type="text" name="action"
                                   class="form-control form-control-lg rounded-3"
                                   placeholder="Action (tindakan yang dilakukan)">
                        </div>

                        <!-- Keterangan Tambahan -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Keterangan Tambahan</label>
                            <textarea name="ket_tambahan"
                                      class="form-control form-control-lg rounded-3"
                                      rows="3"
                                      placeholder="Keterangan tambahan (opsional)"></textarea>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select form-select-lg rounded-3" required>
                                <option value="">Select Status</option>
                                <option value="Done">Done</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                        
                    </div>

                    <!-- Footer -->
                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-3 shadow-sm">
                            SIMPAN
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg px-5 rounded-3"
                                data-bs-dismiss="modal">
                            BATAL
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
{{-- ===================== MODAL EDIT LAPORAN PM ===================== --}}
<div class="modal fade" id="modalEditLaporanPM" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header border-0 px-4 pt-4" style="background-color: #0c2484; color: white;">
                <h4 class="modal-title fw-bold text-center w-100">Edit Data Laporan PM</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 pb-4">
                <form id="formEditLaporan" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Site ID</label>
                            <input type="text" id="edit_site_id" class="form-control bg-light" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Lokasi Site</label>
                            <input type="text" id="edit_lokasi" class="form-control bg-light" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">PM Bulan</label>
                            <input type="text" name="pm_bulan" id="edit_bulan" class="form-control bg-light" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kabupaten / Kota</label>
                            <input type="text" id="edit_kab" class="form-control bg-light" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Provinsi</label>
                            <input type="text" id="edit_prov" class="form-control bg-light" readonly>
                        </div>

                        <hr class="my-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Submit</label>
                            <input type="date" name="tanggal_submit" id="edit_tanggal" class="form-control form-control-lg rounded-3" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teknisi</label>
                            <input type="text" name="teknisi" id="edit_teknisi" class="form-control form-control-lg rounded-3" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kendala</label>
                            <input type="text" name="masalah_kendala" id="edit_kendala" class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Action</label>
                            <input type="text" name="action" id="edit_action" class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Update Laporan BA PM (Opsional)</label>
                            <input type="file" name="laporan_ba_pm" class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" id="edit_status" class="form-select form-select-lg rounded-3" required>
                                <option value="Done">Done</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Keterangan Tambahan</label>
                            <textarea name="ket_tambahan" id="edit_ket" class="form-control form-control-lg rounded-3" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-3 shadow-sm" style="background-color: #0c2484 !important;">
                            UPDATE DATA
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg px-5 rounded-3" data-bs-dismiss="modal">
                            BATAL
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (WAJIB biar modal jalan) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Script untuk inisialisasi Select2 pada modal --}}
<script>
    $(document).ready(function() {
    // Inisialisasi Select2
    $('#site_select').select2({
        theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
        placeholder: '-- Cari Site ID --',
        allowClear: true,
        dropdownParent: $('#modalLaporanPM') // PENTING: Jika di dalam modal, harus ada ini agar search box bisa diklik
    });

    // Logika Auto-fill tetap berjalan
    $('#site_select').on('select2:select', function (e) {
        const data = e.params.data.element; // Mendapatkan elemen option yang dipilih
        
        const lokasi = data.getAttribute("data-name") || "";
        const kab = data.getAttribute("data-kab") || "";
        const prov = data.getAttribute("data-prov") || "";

        // Isi field otomatis
        document.getElementById("lokasiSiteView").value = lokasi;
        document.getElementById("kabView").value = kab;
        document.getElementById("provView").value = prov;
    });
});
</script>
{{-- Script untuk auto-set field lokasi berdasarkan pilihan site --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const siteSelect = document.getElementById("siteSelect");

    const siteIdView = document.getElementById("siteIdView");
    const lokasiSiteView = document.getElementById("lokasiSiteView");
    const kabView = document.getElementById("kabView");
    const provView = document.getElementById("provView");

    if(siteSelect){
        siteSelect.addEventListener("change", function () {
            const opt = siteSelect.options[siteSelect.selectedIndex];

            const siteId = opt.getAttribute("data-siteid") || "";
            const lokasi = opt.getAttribute("data-lokasi") || "";
            const kab = opt.getAttribute("data-kab") || "";
            const prov = opt.getAttribute("data-prov") || "";

            if(siteIdView) siteIdView.value = siteId;
            if(lokasiSiteView) lokasiSiteView.value = lokasi;
            if(kabView) kabView.value = kab;
            if(provView) provView.value = prov;
        });
    }
});
</script>
{{-- Script untuk auto-set bulan berdasarkan tanggal submit --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const tanggalInput = document.getElementById("tanggal_submit");
    const bulanSelect = document.getElementById("pm_bulan");

    if (tanggalInput && bulanSelect) {
        tanggalInput.addEventListener("change", function () {
            const dateValue = new Date(this.value);
            
            if (!isNaN(dateValue.getTime())) {
                // Ambil bulan (0-11) dan tambah 1 agar jadi 1-12
                // Gunakan padStart untuk memastikan format 2 digit (misal: 01, 02)
                const month = (dateValue.getMonth() + 1).toString().padStart(2, '0');
                
                // Set nilai select pm_bulan otomatis
                bulanSelect.value = month;
            }
        });
    }
    
    // ... script siteSelect Anda yang sebelumnya di sini ...
});
document.addEventListener("DOMContentLoaded", function () {
    const siteSelect = document.getElementById("siteSelect");
    const tanggalInput = document.getElementById("tanggal_submit");
    const bulanSelect = document.getElementById("pm_bulan");

    // FUNGSI 1: Otomatisasi Data Site (Lokasi, Kab, Prov)
    if (siteSelect) {
        siteSelect.addEventListener("change", function () {
            const opt = this.options[this.selectedIndex];

            // Ambil data dari atribut data-*
            const lokasi = opt.getAttribute("data-lokasi") || "";
            const kab = opt.getAttribute("data-kab") || "";
            const prov = opt.getAttribute("data-prov") || "";

            // Masukkan ke input form
            document.getElementById("lokasiSiteView").value = lokasi;
            document.getElementById("kabView").value = kab;
            document.getElementById("provView").value = prov;
            
            // Opsional: Jika Anda punya input untuk Site ID terpisah
            if(document.getElementById("siteIdView")) {
                document.getElementById("siteIdView").value = opt.value;
            }
        });
    }

    // FUNGSI 2: Otomatisasi Bulan dari Tanggal
    if (tanggalInput && bulanSelect) {
        tanggalInput.addEventListener("change", function () {
            const dateValue = new Date(this.value);
            if (!isNaN(dateValue.getTime())) {
                // Ambil bulan (0-11) + 1, lalu buat jadi 2 digit (01, 02, dst)
                const month = (dateValue.getMonth() + 1).toString().padStart(2, '0');
                bulanSelect.value = month;
            }
        });
    }
});
</script>
<script>
    $(document).ready(function() {
    // 1. Inisialisasi Select2 (Fitur Search)
    const $siteSelect = $('#siteSelect').select2({
        theme: 'bootstrap-5',
        placeholder: 'Pilih atau cari Nama Site',
        allowClear: true,
        dropdownParent: $('#modalLaporanPM') // Agar bisa diketik di dalam modal
    });

    // 2. Logika Auto-Fill saat Site dipilih (Select2 Version)
    $siteSelect.on('select2:select', function (e) {
        const data = e.params.data.element; // Ambil elemen option yang dipilih
        
        const siteId = data.getAttribute("data-siteid") || "";
        const lokasi = data.getAttribute("data-lokasi") || "";
        const kab = data.getAttribute("data-kab") || "";
        const prov = data.getAttribute("data-prov") || "";

        // Isi field otomatis
        $('#siteIdView').val(siteId);
        $('#lokasiSiteView').val(lokasi);
        $('#kabView').val(kab);
        $('#provView').val(prov);
    });

    // 3. Logika Auto-Fill Bulan saat Tanggal Submit dipilih
    $('#tanggal_submit').on('change', function() {
        const dateValue = new Date(this.value);
        if (!isNaN(dateValue.getTime())) {
            // Format bulan menjadi 2 digit (01-12)
            const month = (dateValue.getMonth() + 1).toString().padStart(2, '0');
            $('#pm_bulan').val(month);
        }
    });
});
</script>
{{-- Script untuk membuka modal edit dan mengisi data ke form edit --}}
<script>
$(document).on('click', '.btn-edit', function() {
    // Ambil semua data dari atribut tombol yang diklik
    const id = $(this).data('id');
    const tanggal = $(this).data('tanggal');
    const site_id = $(this).data('site_id');
    const lokasi = $(this).data('lokasi');
    const kab = $(this).data('kab');
    const prov = $(this).data('prov');
    const bulan = $(this).data('bulan');
    const teknisi = $(this).data('teknisi');
    const kendala = $(this).data('kendala');
    const action = $(this).data('action');
    const ket = $(this).data('ket');
    const status = $(this).data('status');

    // Masukkan ke dalam field modal edit
    $('#edit_tanggal').val(tanggal);
    $('#edit_site_id').val(site_id);
    $('#edit_lokasi').val(lokasi);
    $('#edit_kab').val(kab);
    $('#edit_prov').val(prov);
    $('#edit_bulan').val(bulan);
    $('#edit_teknisi').val(teknisi);
    $('#edit_kendala').val(kendala);
    $('#edit_action').val(action);
    $('#edit_ket').val(ket);
    $('#edit_status').val(status);

    // Set Action URL Form (Sesuaikan dengan URL route update Anda)
    $('#formEditLaporan').attr('action', '/laporanpm/' + id);
});
</script>
{{-- Script untuk konfirmasi delete dengan SweetAlert2 --}}
<script>
function confirmDelete(id, lokasi) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        // Nama lokasi akan muncul di baris teks ini
        text: "Data Laporan PM untuk site " + lokasi + " akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0c2484',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
    });
@endif
</script>
</body>
</html>