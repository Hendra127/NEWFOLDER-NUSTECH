<!DOCTYPE html>
<html>
<head>
    <title>Management Password</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>

<div class="page">

    <!-- TOP BAR -->
    <div class="topbar">
        <div class="top-left">
            <span>Project</span>
            <span class="active">Operational</span>
        </div>
        <div class="profile"></div>
    </div>

    <!-- TABS -->
    <div class="tabs">
        <a href="{{ route('datasite') }}" class="tab {{ request()->is('datasite*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">All Sites</a>
        <a href="{{ url('/datapass') }}" class="tab {{ request()->is('datapass*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Management Password</a>
        <a href="{{ url('/laporanpm') }}" class="tab {{ request()->is('laporanpm*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Laporan PM</a>
        <a href="{{ url('/PMLiberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">PM Liberta</a>
        <a href="{{ url('/pm-summary') }}" class="tab {{ request()->is('pm-summary*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">PM Summary</a>
    </div>

    <!-- CARD -->
    <div class="card">
        <div class="card-header">
            <div class="actions">
                <button class="btn-action bi bi-plus" title="Add" id="addDataModall"></button>
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

        <table class="table">
            <thead>
                <tr>
                    <th>Site ID</th>
                    <th>Nama Lokasi</th>
                    <th>Kabupaten</th>
                    <th>ADOP</th>
                    <th>PASS AP1</th>
                    <th>PASS AP2</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($datapass as $row)
                <tr>
                    <td>{{ $row->site->site_id }}</td>
                    <td>{{ $row->nama_lokasi }}</td>
                    <td>{{ $row->kabupaten }}</td>
                    <td>{{ $row->adop }}</td>
                    <td>{{ $row->pass_ap1 }}</td>
                    <td>{{ $row->pass_ap2 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $datapass->count() > 0 ? $datapass->firstItem() : 0 }}
                to {{ $datapass->lastItem() ?? 0 }}
                of {{ $datapass->total() }} results
            </div>
            <div class="pagination-links">
                {{ $datapass->links() }}
            </div>
        </div>
    </div>

</div>
{{-- MODAL TAMBAH DATA --}}
<div class="modal" id="addDataModal">
    <div class="modal-content">
        <span class="close-btn" id="closeModal">&times;</span>
        <h2>Add New Data</h2>
        <form method="POST" action="{{ route('datapas.store') }}">
            @csrf
            <select name="site_id" required>
                <option value="">-- Pilih Site --</option>
                @foreach ($sites as $site)
                    <option value="{{ $site->id }}">
                        {{ $site->site_id }} - {{ $site->sitename }}
                    </option>
                @endforeach
            </select>
            <div class="form-group">
                <label for="nama_lokasi">Nama Lokasi</label>
                <input type="text" id="nama_lokasi" name="nama_lokasi" required>
            </div>
            <div class="form-group">
                <label for="kabupaten">Kabupaten</label>
                <input type="text" id="kabupaten" name="kabupaten" required>
            </div>
            <div class="form-group">
                <label for="adop">ADOP</label>
                <input type="text" id="adop" name="adop" required>
            </div>
            <div class="form-group">
                <label for="pass_ap1">PASS AP1</label>
                <input type="text" id="pass_ap1" name="pass_ap1" required>
            </div>
            <div class="form-group">
                <label for="pass_ap2">PASS AP2</label>
                <input type="text" id="pass_ap2" name="pass_ap2" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" id="cancelModal">Cancel</button>
        </form>
    </div>
</div>

<script>
    // Modal script untuk Add Modal Tambah
    const addDataModall = document.getElementById('addDataModall');
    const addDataModal = document.getElementById('addDataModal');
    const closeModal = document.getElementById('closeModal');
    const cancelModal = document.getElementById('cancelModal');

    // Open modal saat tombol Add diklik
    addDataModall.addEventListener('click', function() {
        addDataModal.style.display = 'block';
    });

    // Close modal saat tombol X diklik
    closeModal.addEventListener('click', function() {
        addDataModal.style.display = 'none';
    });

    // Close modal saat tombol Cancel diklik
    cancelModal.addEventListener('click', function() {
        addDataModal.style.display = 'none';
    });

    // Close modal jika klik di luar modal
    window.addEventListener('click', function(event) {
        if (event.target == addDataModal) {
            addDataModal.style.display = 'none';
        }
    });
</script>
</body>
</html>
