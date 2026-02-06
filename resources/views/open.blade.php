<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Open Ticket</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:#f4f6f8;
    font-family:'Segoe UI',sans-serif;
}

/* ===== TOP BAR ===== */
.topbar{
    background:linear-gradient(135deg,#163b52,#1f4d67);
    padding:18px 30px;
    color:#fff;
    box-shadow:0 8px 20px rgba(0,0,0,.2);
}

/* ===== BUTTONS ===== */
.btn-pill{
    border-radius:22px;
    padding:8px 22px;
    font-weight:500;
}
.btn-soft{
    background:#fff;
    color:#163b52;
    box-shadow:0 4px 10px rgba(0,0,0,.15);
}
.btn-soft.active{
    background:#163b52;
    color:#fff;
}

/* ===== CARD ===== */
.card-main{
    background:#fff;
    border-radius:20px;
    padding:22px;
    box-shadow:0 12px 25px rgba(0,0,0,.15);
}

/* ===== SEARCH ===== */
.search-box{
    background:#f1f1f1;
    border-radius:25px;
    padding:6px 16px;
    display:flex;
    align-items:center;
    gap:10px;
    width:260px;
}
.search-box input{
    border:none;
    background:none;
    outline:none;
    width:100%;
}

/* ===== TABLE ===== */
.table thead{
    background:#1f4d67;
    color:#fff;
}
.table th, .table td{
    vertical-align:middle;
    font-size:13px;
    white-space:nowrap;
}
.table-hover tbody tr:hover{
    background:#f0f7ff;
}

/* ===== PAGINATION ===== */
.pagination{
    justify-content:center;
}
.page-item.active .page-link{
    background:#1f4d67;
    border-color:#1f4d67;
}
</style>
</head>

<body>

{{-- TOP BAR --}}
<div class="topbar d-flex justify-content-between align-items-center">
    <div class="fw-semibold fs-5">Project &nbsp; | &nbsp; Operational</div>
    <i class="bi bi-person-circle fs-4"></i>
</div>

<div class="container-fluid px-4 mt-4">

{{-- MENU --}}
<div class="d-flex align-items-center gap-3 mb-4">
    <a class="btn btn-pill btn-soft {{ request()->is('open-ticket*') ? 'active' : '' }}">Open Ticket</a>
    <a class="btn btn-pill btn-soft">Close Ticket</a>
    <a class="btn btn-pill btn-soft">Detail Ticket</a>
    <a class="btn btn-pill btn-soft">Summary</a>

    <div class="ms-auto d-flex gap-3">
        <div class="btn btn-pill btn-soft">
            Close All &nbsp; : &nbsp; <b>{{ $tickets->total() ?? 0 }}</b>
        </div>
        <div class="btn btn-pill btn-soft">
            Today &nbsp; : &nbsp; <b>{{ $today ?? '00' }}</b>
        </div>
    </div>
</div>

{{-- CARD --}}
<div class="card-main">

{{-- TOOLBAR --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <button class="btn btn-pill btn-soft" data-bs-toggle="modal" data-bs-target="#modalTambahTicket">
            <i class="bi bi-plus"></i>
        </button>

        <a href="{{ url('/open-ticket/export') }}" class="btn btn-pill btn-soft">
            <i class="bi bi-download"></i>
        </a>

        <a href="{{ url('/open-ticket/import') }}" class="btn btn-pill btn-soft">
            <i class="bi bi-upload"></i>
        </a>
    </div>

    <form method="GET" class="search-box">
        <i class="bi bi-sliders"></i>
        <input type="text" name="q" value="{{ $search }}" placeholder="Search">
        <i class="bi bi-search"></i>
    </form>
</div>
{{-- TABLE --}}
<div class="table-responsive">
<table class="table table-bordered table-hover">
<thead>
<tr>
    <th>NO</th>
    <th>SITE ID</th>
    <th>NAMA SITE</th>
    <th>PROVINSI</th>
    <th>KABUPATEN</th>
    <th>KATEGORI</th>
    <th>STATUS</th>
    <th>DURASI</th>
    <th>KENDALA</th>
    <th>DETAIL PROBLEM</th>
</tr>
</thead>

<tbody>
@forelse($tickets as $i => $t)
<tr>
    <td>{{ $tickets->firstItem() + $i }}</td>
    <td>{{ $t->site_code }}</td>
    <td>{{ $t->nama_site }}</td>
    <td>{{ strtoupper($t->provinsi) }}</td>
    <td>{{ strtoupper($t->kabupaten) }}</td>
    <td>{{ $t->kategori }}</td>
    <td>
        <span class="badge {{ $t->status == 'open' ? 'bg-success' : 'bg-secondary' }}">
            {{ strtoupper($t->status) }}
        </span>
    </td>
    <td>{{ $t->durasi ?? '-' }}</td>
    <td>{{ $t->kendala ?? '-' }}</td>
    <td>{{ $t->detail_problem }}</td>
</tr>
@empty
<tr>
    <td colspan="10" class="text-center text-muted">
        Tidak ada data
    </td>
</tr>
@endforelse
</tbody>
</table>
</div>

{{-- PAGINATION --}}
<div class="mt-3">
    {{ $tickets->links() }}
</div>

</div>
</div>
{{-- MODAL TAMBAH TICKET --}}
<div class="modal fade" id="modalTambahTicket" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <form method="POST" action="{{ url('/open-ticket/store') }}" class="modal-content">
      @csrf

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Tambah Open Ticket</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="row g-3">

          <div class="col-md-4">
            <label class="form-label">Site ID</label>
            <input type="text" name="site_id" class="form-control" required>
          </div>

            <div class="col-md-4">
                <label class="form-label">Site Code</label>
                <input type="text" name="site_code" class="form-control" required>
            </div>

          <div class="col-md-4">
            <label class="form-label">Nama Site</label>
            <input type="text" name="nama_site" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Provinsi</label>
            <input type="text" name="provinsi" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Kabupaten</label>
            <input type="text" name="kabupaten" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Tanggal Rekap</label>
            <input type="date" name="tanggal_rekap" class="form-control">
          </div>

          <div class="col-md-3">
            <label class="form-label">Durasi</label>
            <input type="number" name="durasi" class="form-control">
          </div>

          <div class="col-md-3">
            <label class="form-label">Durasi Akhir</label>
            <input type="number" name="durasi_akhir" class="form-control">
          </div>

          <div class="col-md-6">
            <label class="form-label">Kendala</label>
            <input type="text" name="kendala" class="form-control">
          </div>

          <div class="col-md-12">
            <label class="form-label">Detail Problem</label>
            <textarea name="detail_problem" class="form-control" rows="3" required></textarea>
          </div>

          <input type="hidden" name="status" value="open">

        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save"></i> Simpan Ticket
        </button>
      </div>

    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
