<!DOCTYPE html>
<html lang="id">
<head>
    @include('components.nav-modal-structure')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Ticket | Project Operational</title>
     <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .status-badge {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
        }
        .summary-badge {
            font-size: 12px;
            padding: 5px 15px;
            border-radius: 50px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            margin-right: 10px;
        }
    </style>
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
    <div class="tabs-section d-flex align-items-center">
        <a href="{{ url('/open-ticket') }}" class="tab {{ request()->is('open-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Open Tiket</a>
        <a href="{{ url('/close-ticket') }}" class="tab {{ request()->is('close-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Close Tiket</a>
        <a href="{{ url('/detailticket') }}" class="tab {{ request()->is('detailticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Detail Tiket</a>
        <a href="{{ url('/summaryticket') }}" class="tab {{ request()->is('summaryticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Summary Tiket</a>
        
        <div class="ms-auto d-flex align-items-center">
            <span class="summary-badge text-black">Total Open: <b>{{ $openAllCount }}</b></span>
            <span class="summary-badge text-black">Open Hari Ini: <b>{{ $openTodayCount }}</b></span>
            <span class="summary-badge text-dark">BMN: <b>{{ $countBMN }}</b></span>
            <span class="summary-badge text-dark">SL: <b>{{ $countSL }}</b></span>
        </div>
    </div>

    <!-- CARD -->
    <div class="card">
        <div class="card-header">
            <div class="actions">
                <button class="btn-action bi bi-plus" 
                        title="Add" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalTambahTicket">
                </button>
                <button class="btn-action bi bi-upload" title="Upload"></button>
                <button class="btn-action bi bi-download" title="Download"></button>
            </div>

            <form method="GET" action="{{ route('open.ticket') }}" class="search-form">
                <div class="search-box d-flex align-items-center">
                    <button type="button" class="filter-btn" data-bs-toggle="modal" data-bs-target="#modalFilter" style="background: none; border: none; padding-left: 15px;">
                        <i class="bi bi-sliders2"></i> </button>

                    <input type="text" id="searchInput" name="q" placeholder="Search..." value="{{ request('q') }}" style="flex-grow: 1; border: none; outline: none;">
                    
                    <button type="submit" class="search-btn">🔍</button>
                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div style="overflow-x: auto; max-height: 600px; overflow-y: auto;">
            <table>
                <thead>
                    <tr class="thead-dark">
                        <th>NO</th>
                        <th>SITE ID</th>
                        <th>NAMA SITE</th>
                        <th>DURASI</th>
                        <th>TANGGAL OPEN</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN</th>
                        <th>KATEGORI</th>
                        <th>STATUS</th>
                        <th>KENDALA</th>
                        <th>DETAIL PROBLEM</th>
                        <th>ACTION PLAN</th>
                        <th>CE</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $i => $t)
                    <tr>
                        <td>{{ $tickets->firstItem() + $i }}</td>
                        <td>{{ $t->site_code }}</td>
                        <td>{{ $t->nama_site }}</td>
                        <td class="text-center">
                            @php
                                $tanggalRekap = \Carbon\Carbon::parse($t->tanggal_rekap)->startOfDay();
                                $hariIni = now()->startOfDay();
                                $durasi = $tanggalRekap->diffInDays($hariIni);
                            @endphp

                            {{ $durasi }} Hari
                        </td>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal_rekap)->format('d M Y') }}</td>
                        <td>{{ $t->provinsi }}</td>
                        <td>{{ $t->kabupaten }}</td>
                        <td class="text-center">{{ $t->kategori }}</td>
                        <td class="text-center"><span>OPEN</span></td>
                        <td>{{ $t->kendala }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ $t->detail_problem }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ $t->plan_actions }}</td>
                        <td>{{ $t->ce }}</td>
                        <td class="text-center">
                            <form action="{{ route('open.ticket.close', $t->id) }}" method="POST" class="d-inline form-close">
                                @csrf
                                @method('PUT')
                                <button type="button" class="btn btn-sm bi bi-x-lg btn-close-ticket" 
                                        data-name="{{ $t->nama_site }}" 
                                        title="Close Ticket"
                                        style="color: #198754;">
                                </button>
                            </form>
                            <button class="btn btn-sm bi bi-pencil" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditTicket{{ $t->id }}">
                            </button>
                            <form action="{{ route('open.ticket.destroy', $t->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm bi bi-trash btn-delete" 
                                        data-name="{{ $t->nama_site }}">
                                </button>
                            </form>
                            <button type="button" class="btn btn-sm bi bi-info-circle" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalInfo{{ $t->id }}">
                            </button>

                            <div class="modal fade" id="modalInfo{{ $t->id }}" tabindex="-1" aria-labelledby="label{{ $t->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white d-flex justify-content-center position-relative">
                                            <h5 class="modal-title w-100 text-center" id="label{{ $t->id }}">
                                                Detail Tiket #{{ $t->nama_site }}
                                            </h5>
                                            <button type="button" 
                                                    class="btn-close btn-close-white position-absolute end-0 me-3" 
                                                    data-bs-dismiss="modal" 
                                                    aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-sm borderless">
                                                        <tr><th>Site ID</th><td>: {{ $t->site_code }}</td></tr>
                                                        <tr><th>Nama Site</th><td>: {{ $t->nama_site }}</td></tr>
                                                        <tr><th>Provinsi</th><td>: {{ $t->provinsi }}</td></tr>
                                                        <tr><th>Kabupaten</th><td>: {{ $t->kabupaten }}</td></tr>
                                                        <tr><th>Kategori</th><td>: {{ $t->kategori }}</td></tr>
                                                        <tr><th>Tgl Rekap</th><td>: {{ $t->tanggal_rekap }}</td></tr>
                                                        <tr><th>Bulan Open</th><td>: {{ $t->bulan_open }}</td></tr>
                                                        <tr><th>Status</th><td>: {{ $t->status }}</td></tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-sm borderless">
                                                        <tr><th>Status Tiket</th><td>: {{ $t->status }}</td></tr>
                                                        <tr><th>Durasi</th><td>: {{ $t->durasi }}</td></tr>
                                                        <tr><th>Durasi Akhir</th><td>: {{ $t->durasi_akhir }}</td></tr>
                                                        <tr><th>Kendala</th><td>: {{ $t->kendala }}</td></tr>
                                                        <tr><th>Evidence</th><td>: {{ $t->evidence }}</td></tr>
                                                        <tr><th>Detail Prob</th><td>: {{ $t->detail_problem }}</td></tr>
                                                        <tr><th>Plan Action</th><td>: {{ $t->plan_actions }}</td></tr>
                                                        <tr><th>CE</th><td>: {{ $t->ce }}</td></tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center py-4 text-muted">Belum ada tiket yang dibuka.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $tickets->links() }}</div>
    </div>
</div>

{{-- MODAL TAMBAH TICKET --}}
<div class="modal fade" id="modalTambahTicket" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form method="POST" action="{{ route('open.ticket.store') }}" class="modal-content">
            @csrf
            <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #1B435D;">
                <h5 class="modal-title text-center">Tambah Tiket Baru</h5>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Pilih Site ID</label>
                        <select name="site_id" id="site_select" class="form-select select2" required>
                            <option value="">-- Cari Site ID --</option>
                            @foreach($sites as $s)
                            <option value="{{ $s->id }}" 
                                    data-code="{{ $s->site_id }}" 
                                    data-name="{{ $s->sitename }}"
                                    data-prov="{{ $s->provinsi }}"
                                    data-kab="{{ $s->kab }}"
                                    data-tipe="{{ $s->tipe }}">
                                {{ $s->site_id }} - {{ $s->sitename }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Site Code</label>
                        <input type="text" name="site_code" id="site_code" class="form-control bg-light" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Site</label>
                        <input type="text" name="nama_site" id="nama_site" class="form-control bg-light" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="provinsi" id="provinsi" class="form-control bg-light" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kabupaten</label>
                        <input type="text" name="kabupaten" id="kabupaten" class="form-control bg-light" readonly required>
                    </div>
                    {{-- Input untuk Kategori --}}
                    <div class="col-md-4">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" id="kategori" class="form-control bg-light" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Rekap</label>
                        <input type="date" name="tanggal_rekap" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Durasi (Hari)</label>
                        <input type="text" name="durasi" id="durasi_input" class="form-control bg-light" value="0" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kendala</label>
                        <input type="text" name="kendala" class="form-control" placeholder="Contoh: Kabel Rusak, Perangkat Mati, dll." required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Detail Problem</label>
                        <textarea name="detail_problem" class="form-control" rows="3" required placeholder="Jelaskan detail masalah..."></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Action Plan</label>
                        <textarea name="plan_actions" class="form-control" rows="3" required placeholder="Jelaskan detail action plan..."></textarea>
                    </div>
                    <input type="hidden" name="status" value="open">
                    <div class="col-md-4">
                        <label class="form-label">CE</label>
                        <select name="ce" class="form-select" required>
                            <option value="">-- Pilih CE --</option>
                            <option value="Eka Mahatva Yudha">Eka Mahatva Yudha</option>
                            <option value="Herman Seprianto">Herman Seprianto</option>
                            <option value="Moh. Walangadi">Moh. Walangadi</option>
                            <option value="Ahmad Suhaini">Ahmad Suhaini</option>
                            <option value="Hasrul Fandi Serang">Hasrul Fandi Serang</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Simpan Tiket</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL FILTER --}}
<div class="modal fade" id="modalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Data Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="{{ route('open.ticket') }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">Semua Kategori</option>
                                <option value="BMN" {{ request('kategori') == 'BMN' ? 'selected' : '' }}>BMN</option>
                                <option value="SL" {{ request('kategori') == 'SL' ? 'selected' : '' }}>SL</option>
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
                    <a href="{{ route('open.ticket') }}" class="btn btn-light border">Reset</a>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT TICKET (Dibuat untuk setiap tiket yang ada) --}}
@foreach($tickets as $t)
<div class="modal fade" id="modalEditTicket{{ $t->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form method="POST" action="{{ route('open.ticket.update', $t->id) }}" class="modal-content">
            @csrf
            @method('PUT')
            
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Tiket - {{ $t->site_code }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <div class="row g-3">
                    {{-- Info Site (Read Only saat Edit) --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Site ID / Code</label>
                        <input type="text" class="form-control bg-light" value="{{ $t->site_code }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Site</label>
                        <input type="text" class="form-control bg-light" value="{{ $t->nama_site }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Durasi Berjalan (Hari)</label>
                        <input type="text" class="form-control bg-light" value="{{ floor($t->durasi) }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Provinsi</label>
                        <input type="text" class="form-control bg-light" value="{{ $t->provinsi }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kabupaten</label>
                        <input type="text" class="form-control bg-light" value="{{ $t->kabupaten }}" readonly>
                    </div>

                    {{-- Data yang Bisa Diedit --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-primary">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="BMN" {{ $t->kategori == 'BMN' ? 'selected' : '' }}>BMN</option>
                            <option value="SL" {{ $t->kategori == 'SL' ? 'selected' : '' }}>SL</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-primary">Tanggal Open/Rekap</label>
                        <input type="date" name="tanggal_rekap" class="form-control" value="{{ $t->tanggal_rekap }}" required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-bold text-primary">Kendala</label>
                        <input type="text" name="kendala" class="form-control" value="{{ $t->kendala }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold text-primary">Detail Problem</label>
                        <textarea name="detail_problem" class="form-control" rows="3" required>{{ $t->detail_problem }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold text-primary">Action Plan</label>
                        <textarea name="plan_actions" class="form-control" rows="3" required>{{ $t->plan_actions }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-primary">CE (Customer Engineer)</label>
                        <select name="ce" class="form-select" required>
                            <option value="">-- Pilih CE --</option>
                            <option value="Eka Mahatva Yudha" {{ $t->ce == 'Eka Mahatva Yudha' ? 'selected' : '' }}>Eka Mahatva Yudha</option>
                            <option value="Herman Seprianto" {{ $t->ce == 'Herman Seprianto' ? 'selected' : '' }}>Herman Seprianto</option>
                            <option value="Moh. Walangadi" {{ $t->ce == 'Moh. Walangadi' ? 'selected' : '' }}>Moh. Walangadi</option>
                            <option value="Ahmad Suhaini" {{ $t->ce == 'Ahmad Suhaini' ? 'selected' : '' }}>Ahmad Suhaini</option>
                            <option value="Hasrul Fandi Serang" {{ $t->ce == 'Hasrul Fandi Serang' ? 'selected' : '' }}>Hasrul Fandi Serang</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning px-4">Update Data Tiket</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script src="{{ asset('js/nav-modal.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
{{-- Script untuk menghitung durasi otomatis berdasarkan tanggal rekap --}}
<script>
    // SCRIPT AUTO-FILL BERDASARKAN PILIHAN SITE
    document.getElementById('site_select').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        document.getElementById('site_code').value = selected.getAttribute('data-code') || '';
        document.getElementById('nama_site').value = selected.getAttribute('data-name') || '';
        document.getElementById('provinsi').value = selected.getAttribute('data-prov') || '';
        document.getElementById('kabupaten').value = selected.getAttribute('data-kab') || '';
    });

    // SWEETALERT NOTIFIKASI
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
    @endif
</script>
{{-- Script untuk auto-fill berdasarkan pilihan site --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const siteSelect = document.getElementById('site_select');
        
        if(siteSelect) {
            siteSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                
                // Mengisi input berdasarkan data-attribute yang ada di <option>
                document.getElementById('site_code').value = selected.getAttribute('data-code') || '';
                document.getElementById('nama_site').value = selected.getAttribute('data-name') || '';
                document.getElementById('provinsi').value = selected.getAttribute('data-prov') || '';
                document.getElementById('kabupaten').value = selected.getAttribute('data-kab') || '';
            });
        }
    });
</script>
{{-- Script untuk menghitung durasi otomatis berdasarkan tanggal rekap --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const tanggalRekapInput = document.getElementsByName('tanggal_rekap')[0];
        const durasiInput = document.getElementById('durasi_input');

        function hitungDurasi() {
            const tanggalTerpilih = new Date(tanggalRekapInput.value);
            const hariIni = new Date();
            
            // Reset jam ke 00:00:00 agar perhitungan hari akurat
            tanggalTerpilih.setHours(0, 0, 0, 0);
            hariIni.setHours(0, 0, 0, 0);

            // Hitung selisih dalam milidetik
            const selisihMilidetik = hariIni.getTime() - tanggalTerpilih.getTime();
            
            // Konversi milidetik ke hari (1 hari = 24 * 60 * 60 * 1000 ms)
            const selisihHari = Math.floor(selisihMilidetik / (1000 * 60 * 60 * 24));

            // Jika tanggal rekap adalah hari ini, durasi 0. Jika kemarin, durasi 1.
            // Jika user memilih tanggal masa depan, kita set durasi ke 0
            durasiInput.value = selisihHari > 0 ? selisihHari : 0;
        }

        // Jalankan fungsi saat input tanggal berubah
        tanggalRekapInput.addEventListener('change', hitungDurasi);

        // Jalankan fungsi saat modal pertama kali dibuka (untuk default value)
        hitungDurasi();
    });
</script>
{{-- Script untuk submit form pencarian otomatis setelah user berhenti mengetik selama 500ms --}}
<script>
    let timeout = null;
    const searchInput = document.getElementById('searchInput');
    const form = searchInput.closest('form');

    searchInput.addEventListener('input', function() {
        // Hapus timeout sebelumnya jika user masih mengetik
        clearTimeout(timeout);

        // Setel waktu tunggu 500ms setelah ketikan terakhir
        timeout = setTimeout(() => {
            form.submit();
        }, 100); 
    });

    // Pindahkan kursor ke akhir teks setelah refresh halaman
    searchInput.focus();
    const val = searchInput.value;
    searchInput.value = '';
    searchInput.value = val;
</script>
{{-- Script untuk konfirmasi delete dengan SweetAlert2 --}}
<script>
    // SCRIPT KONFIRMASI DELETE DENGAN SWEETALERT2
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            // Ambil data nama site dari attribute data-name yang sudah Abang buat
            const siteName = this.getAttribute('data-name');
            const form = this.closest('form'); // Cari form pembungkusnya

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Tiket untuk " + siteName + " akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik Ya, jalankan submit form
                    form.submit();
                }
            });
        });
    });
</script>
{{-- Script untuk konfirmasi close ticket dengan SweetAlert2 --}}
<script>
    // SCRIPT KONFIRMASI CLOSE TICKET
    document.querySelectorAll('.btn-close-ticket').forEach(button => {
        button.addEventListener('click', function(e) {
            const siteName = this.getAttribute('data-name');
            const form = this.closest('.form-close');

            Swal.fire({
                title: 'Close Tiket Ini?',
                text: "Tiket untuk " + siteName + " Status akan dirubah menjadi (Closed).",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754', // Warna Hijau
                cancelButtonColor: '#6e7881',
                confirmButtonText: 'Ya, Close Tiket!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
{{-- Script untuk inisialisasi Select2 pada dropdown site --}}
<script>
    $(document).ready(function() {
    $('#site_select').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Cari Site ID --',
        allowClear: true,
        width: '100%',
        // Mengambil parent modal secara otomatis
        dropdownParent: $('#site_select').closest('.modal') 
    });
});
</script>
{{-- Script untuk inisialisasi Select2 pada dropdown site dengan perbaikan fokus di modal --}}
<script>
$(document).ready(function() {
    // 1. Inisialisasi Select2 & Perbaikan Fokus di Modal
    const $siteSelect = $('#site_select');
    
    $siteSelect.select2({
        theme: 'bootstrap-5',
        placeholder: '-- Cari Site ID --',
        allowClear: true,
        width: '100%',
        // Mengambil parent modal secara otomatis agar bisa diketik
        dropdownParent: $siteSelect.closest('.modal').length ? $siteSelect.closest('.modal') : $(document.body)
    });

    // Fix bug Select2: agar kursor otomatis fokus ke kolom pencarian saat diklik
    $(document).on('select2:open', () => {
        setTimeout(() => {
            const searchField = document.querySelector('.select2-search__field');
            if (searchField) searchField.focus();
        }, 10);
    });

    // 2. Event saat Site ID dipilih (Auto-fill & Mapping Kategori)
    $siteSelect.on('change', function() {
        const selectedOption = $(this).find(':selected');
        
        // Ambil data dasar dari atribut data-
        const code = selectedOption.data('code');
        const name = selectedOption.data('name');
        const prov = selectedOption.data('prov');
        const kab = selectedOption.data('kab');
        const tipeFull = selectedOption.data('tipe'); 

        // Logika Mapping Kategori: Mengubah teks panjang menjadi singkatan
        let kategoriSingkat = "";
        if (tipeFull) {
            const tipeUpper = tipeFull.toUpperCase(); // Ubah ke huruf besar semua agar pencarian akurat
            
            if (tipeUpper.includes("BARANG MILIK NEGARA") || tipeUpper.includes("BMN")) {
                kategoriSingkat = "BMN";
            } else if (tipeUpper.includes("SEWA LAYANAN") || tipeUpper.includes("SL")) {
                kategoriSingkat = "SL";
            } else {
                kategoriSingkat = tipeFull; // Pakai teks asli jika tidak ada kecocokan
            }
        }

        // Distribusikan data ke input masing-masing ID
        $('#site_code').val(code || '');
        $('#nama_site').val(name || '');
        $('#provinsi').val(prov || '');
        $('#kabupaten').val(kab || '');
        $('#kategori').val(kategoriSingkat); 
    });
});
</script>
</body>
</html>