<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Ticket | Project Operational</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <a href="{{ url('/open-ticket') }}" class="tab {{ request()->is('open-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Open Tiket</a>
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

            <form method="GET" action="{{ route('datapas') }}" class="search-form">
                <div class="search-box">
                    <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
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
                        <th>PROVINSI</th>
                        <th>KABUPATEN</th>
                        <th>KATEGORI</th>
                        <th>STATUS</th>
                        <th>KENDALA</th>
                        <th>DETAIL PROBLEM</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $i => $t)
                    <tr>
                        <td>{{ $tickets->firstItem() + $i }}</td>
                        <td>{{ $t->site_code }}</td>
                        <td>{{ $t->nama_site }}</td>
                        <td>{{ $t->durasi }}</td>
                        <td>{{ $t->provinsi }}</td>
                        <td>{{ $t->kabupaten }}</td>
                        <td>{{ $t->kategori }}</td>
                        <td><span class="badge bg-success">OPEN</span></td>
                        <td>{{ $t->kendala }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ $t->detail_problem }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="text-center py-4 text-muted">Belum ada tiket yang dibuka.</td></tr>
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
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Buka Tiket Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
                                    data-kab="{{ $s->kab }}">
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
                    <div class="col-md-4">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="RADIO">BMN</option>
                            <option value="FIBER">SL</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Rekap</label>
                        <input type="date" name="tanggal_rekap" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Durasi</label>
                        <input type="text" name="durasi" class="form-control" value="0" required placeholder>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kendala</label>
                        <input type="text" name="kendala" class="form-control" placeholder="Contoh: Kabel Rusak, Perangkat Mati, dll." required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Detail Problem</label>
                        <textarea name="detail_problem" class="form-control" rows="3" required placeholder="Jelaskan detail masalah..."></textarea>
                    </div>
                    <input type="hidden" name="status" value="open">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Simpan Tiket</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>