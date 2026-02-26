<!DOCTYPE html>
<html lang="id">
<head>
    @include('components.nav-modal-structure')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Close Ticket | Project Operational</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
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
        <a href="{{ url('/open-ticket') }}" class="tab {{ request()->is('open-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Open Tiket</a>
        <a href="{{ url('/close-ticket') }}" class="tab {{ request()->is('close-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Close Tiket</a>
        <a href="{{ url('/detailticket') }}" class="tab {{ request()->is('detailticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Detail Tiket</a>
        <a href="{{ url('/summaryticket') }}" class="tab {{ request()->is('summaryticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Summary Tiket</a>
        
        <div class="ms-auto d-flex align-items-center">
            <span class="summary-badge text-black">Total Close: <b>{{ $closeAllCount }}</b></span>
            <span class="summary-badge text-black">Close Hari Ini: <b>{{ $todayCount }}</b></span>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="actions me-3">
                    <a href="{{ route('close.ticket.export') }}" class="btn-action bi bi-download" title="Download Excel" style="text-decoration: none; line-height: 1.8;"></a>
                </div>
            </div>

            <form method="GET" action="{{ route('close.ticket') }}" class="search-form">
                <div class="search-box d-flex align-items-center">
                    <button type="button" class="filter-btn" data-bs-toggle="modal" data-bs-target="#modalFilter" style="background: none; border: none; padding-left: 15px;">
                        <i class="bi bi-sliders2"></i> </button>

                    <input type="text" id="searchInput" name="q" placeholder="Search..." value="{{ request('q') }}" style="flex-grow: 1; border: none; outline: none;">
                    
                    <button type="submit" class="search-btn">🔍</button>
                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div style="overflow-x: auto; max-height: 600px;">
            <table>
                <thead>
                    <tr class="thead-dark">
                        <th>NO</th>
                        <th>SITE ID</th>
                        <th>NAMA SITE</th>
                        <th>KATEGORI</th>
                        <th>TANGGAL OPEN</th>
                        <th>TANGGAL CLOSE</th> <th>DURASI</th>
                        <th>STATUS</th>
                        <th>CE</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $i => $t)
                    <tr>
                        <td class="text-center">{{ $tickets->firstItem() + $i }}</td>
                        <td class="text-center">{{ $t->site_code }}</td>
                        <td>{{ $t->nama_site }}</td>
                        <td class="text-center">{{ $t->kategori }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($t->tanggal_rekap)->format('d M Y') }}</td>
                        <td class="text-center">
                            {{ $t->tanggal_close ? \Carbon\Carbon::parse($t->tanggal_close)->format('d M Y') : '-' }}
                        </td>
                        <td class="text-center">{{ number_format($t->durasi, 0) }} Hari</td>
                        <td class="text-center"><span class="status-badge" >{{ strtoupper($t->status) }}</span></td>
                        <td>{{ $t->ce }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center py-4 text-muted">Data close ticket tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
{{-- MODAL FILTER --}}
<div class="modal fade" id="modalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Data Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="{{ route('close.ticket') }}">
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
        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="small text-muted">
                Showing {{ $tickets->firstItem() ?? 0 }} to {{ $tickets->lastItem() ?? 0 }} of {{ $tickets->total() }} results
            </div>
            <div>
                {{ $tickets->appends(['q' => $search])->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Script untuk submit form pencarian otomatis setelah user berhenti mengetik selama 500ms --}}
    <script>
        // Search Otomatis
        let timeout = null;
        const searchInput = document.getElementById('searchInput');
        const form = searchInput.closest('form');

        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                form.submit();
            }, 500); 
        });

        // Autofocus kursor
        searchInput.focus();
        const val = searchInput.value;
        searchInput.value = '';
        searchInput.value = val;

        // SweetAlert untuk Sukses (Import/Store)
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
        @endif
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
</body>
</html>