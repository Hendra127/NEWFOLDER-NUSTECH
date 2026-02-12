<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Open Ticket</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    :root{
        --navy:#1e4a68;
        --navy2:#234f70;
        --text:#123247;
        --muted:#6f8797;

        --shadow-lg: 0 16px 30px rgba(0,0,0,.18);
        --shadow-md: 0 10px 18px rgba(0,0,0,.15);
        --shadow-sm: 0 6px 14px rgba(0,0,0,.12);
    }

    body{
        background: radial-gradient(ellipse at top, #f9fafb 0%, #eef2f5 40%, #e9edf1 100%);
        font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
        margin:0;
        color: var(--text);
    }

    /* ===== TOP BAR ===== */
    .topbar{
        height:76px;
        background: linear-gradient(180deg,#275b7d 0%, #1e4a68 100%);
        padding:0 26px;
        color:#fff;
        box-shadow:0 10px 22px rgba(0,0,0,.22);
        display:flex;
        align-items:center;
        justify-content:space-between;
        position: sticky;
        top:0;
        z-index: 20;
    }
    .topbar .title{
        font-weight:700;
        font-size:20px;
        opacity:.95;
    }
    .topbar .avatar{
        width:34px;height:34px;border-radius:999px;
        background:rgba(255,255,255,.92);
        display:grid;place-items:center;
        color:#0f2f45;
        box-shadow:0 10px 20px rgba(0,0,0,.18);
    }

    /* ===== MENU PILLS (sama seperti close ticket) ===== */
    .ticket-controls{
        display:flex;
        align-items:center;
        gap:18px;
        padding: 8px 6px 18px;
        flex-wrap: wrap;
    }
  .pill{
            height:38px;
            padding:0 16px;
            border-radius:10px;
            background:#fff;
            border:1px solid #e4eaef;
            color:#123247;
            font-weight:900;
            font-size:18px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            box-shadow:var(--shadow-sm);
            text-decoration:none;
        }
        .pill:hover{ transform:translateY(-1px); box-shadow:var(--shadow-md); }
        .pill.is-active{
            background:#214e6f;
            border-color:#214e6f;
            color:#fff;
        }
        .pill.compact{
            padding:0 12px;
            font-size:15px;
            height:32px;
        }

    .badge-mini{
        width:46px;height:30px;border-radius:12px;
        background:#f2f5f8;
        display:grid;place-items:center;
        font-weight:900;
        color:#0f2f45;
    }

    /* ===== CARD ===== */
    .card-main{
        background:rgba(255,255,255,.92);
        border-radius:22px;
        padding:18px;
        box-shadow:var(--shadow-lg);
        border:1px solid rgba(0,0,0,.06);
    }

    /* ===== TOOLBAR ===== */
    .toolbar{
        display:flex;
        align-items:center;
        gap:12px;
        margin-bottom:12px;
        flex-wrap: wrap;
    }
    .tool-left{
        display:flex;
        gap:12px;
        align-items:center;
    }

    .icon-pill{
        height:44px;
        min-width:54px;
        padding:0 18px;
        border-radius:999px;
        background:#f5f7f9;
        border:1px solid #e0e7ed;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        box-shadow:var(--shadow-sm);
        cursor:pointer;
        text-decoration:none;
        color:#14374f;
        transition:.15s;
    }
    .icon-pill:hover{
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    /* ===== SEARCH (sama gaya pill) ===== */
    .search-pill{
        margin-left:auto;
        height: 44px;
        width: min(300px, 52vw);
        background: #eef0f2;
        border-radius: 999px;
        border: 1px solid #e3e7ec;
        display: flex;
        align-items: center;
        padding: 0 10px;
        gap: 10px;
        box-shadow: 0 8px 16px rgba(0,0,0,.08);
    }
    .search-pill__icon{
        width: 44px;
        height: 34px;   
        border-radius: 14px;
        border: none;
        background: transparent;
        display: grid;
        place-items: center;
        cursor: pointer;
        color: #2b4c62;
    }
    .search-pill__input{
        flex: 1;
        height: 40px;
        border: none;
        outline: none;
        background: transparent;
        font-size: 18px;
        font-weight: 500;
        color: #2b4c62;
    }
    .search-pill__input::placeholder{
        color: #7b8f9e;
        font-weight: 500;
    }
    

    /* ===== TABLE ===== */
.table thead,
.table thead tr,
.table thead th{
    background-color: #13476a !important;
    color: #fff !important;
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

    @media (max-width: 980px){
        .search-pill{ width:100%; margin-left:0; }
        .spacer{ display:none; }
    }
</style>
</head>

<body>

{{-- TOP BAR --}}
<div class="topbar">
    <div class="title">Project &nbsp; | &nbsp; Operational</div>

    <div class="avatar">
        <i class="bi bi-person-circle fs-5"></i>
    </div>
</div>

<div class="container-fluid px-4 mt-4">

    {{-- MENU --}}
    <div class="ticket-controls">
        <a class="pill {{ request()->routeIs('open.ticket') ? 'is-active' : '' }}"
           href="{{ route('open.ticket') }}"> Open Ticket</a>
        <a class="pill {{ request()->routeIs('close.ticket') ? 'is-active' : '' }}"
           href="{{ route('close.ticket') }}">Close Ticket</a>
        <a class="pill" href="{{ route('detail.ticket.dashboard') }}">Detail Ticket</a>
        <a class="pill" href="{{ route('summary.ticket') }}">Summary</a>

        <div class="spacer"></div>
        <div class="pill compact">
            Close All
            <span style="opacity:.35;font-weight:900;">:</span>
            <span class="badge-mini">{{ $tickets->total() ?? 0 }}</span>
        </div>

        <div class="pill compact">
            Today
            <span style="opacity:.35;font-weight:900;">:</span>
            <span class="badge-mini">{{ $today ?? '00' }}</span>
        </div>
    </div>

    {{-- CARD --}}
    <div class="card-main">

        {{-- TOOLBAR --}}
        <div class="toolbar">

            <div class="tool-left">
                <button class="icon-pill" data-bs-toggle="modal" data-bs-target="#modalTambahTicket" title="Tambah Ticket">
                    <i class="bi bi-plus-lg"></i>
                </button>

                <a href="{{ route('open.ticket.export') }}" class="icon-pill" title="Download Excel">
                    <i class="bi bi-download"></i>
                </a>

                {{-- IMPORT HARUS POST --}}
                <button class="icon-pill" data-bs-toggle="modal" data-bs-target="#modalImportTicket" title="Import Excel">
                    <i class="bi bi-upload"></i>
                </button>
            </div>

            {{-- SEARCH --}}
            <form method="GET" class="search-pill" action="{{ route('open.ticket') }}">
                <button type="button" class="search-pill__icon" title="Filter">
                    <i class="bi bi-sliders"></i>
                </button>

                <input type="text" class="search-pill__input" name="q" value="{{ $search }}" placeholder="Search">

                <button type="submit" class="search-pill__icon" title="Search">
                    <i class="bi bi-search"></i>
                </button>
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
                            <td>{{ ($tickets->firstItem() ?? 0) + $i }}</td>
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
            {{ $tickets->appends(['q' => $search])->links() }}
        </div>

    </div>
</div>

{{-- MODAL TAMBAH TICKET --}}
<div class="modal fade" id="modalTambahTicket" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <form method="POST" action="{{ route('open.ticket.store') }}" class="modal-content">
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

{{-- MODAL IMPORT TICKET (POST) --}}
<div class="modal fade" id="modalImportTicket" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form method="POST" action="{{ route('open.ticket.import') }}" enctype="multipart/form-data" class="modal-content">
      @csrf

      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Import Open Ticket</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <label class="form-label">Upload file Excel</label>
        <input type="file" name="file" class="form-control" required>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">
          <i class="bi bi-upload"></i> Import
        </button>
      </div>

    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
