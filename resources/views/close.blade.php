<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Close Ticket</title>

    <style>
        :root{
            --navy:#1e4a68;
            --navy2:#234f70;
            --bg:#eef2f5;
            --text:#123247;
            --muted:#6f8797;

            --shadow-lg: 0 16px 30px rgba(18, 38, 141, 0.18);
            --shadow-md: 0 10px 18px rgba(0,0,0,.15);
            --shadow-sm: 0 6px 14px rgba(0,0,0,.12);
        }

        *{box-sizing:border-box}

        body{
            margin:0;
            font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
            background: radial-gradient(ellipse at top, #f9fafb 0%, #eef2f5 40%, #e9edf1 100%);
            color:var(--text);
        }

        /* NAVBAR */
        .ticket-navbar{
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
        .nav-left{
            display:flex;
            align-items:center;
            gap:28px;
            font-weight:700;
        }
        .nav-item{
            font-size:20px;
            opacity:.95;
        }
        .nav-right{margin-left:auto;}
        .avatar{
            width:34px;height:34px;border-radius:999px;
            background:rgba(255,255,255,.92);
            display:grid;place-items:center;
            color:#0f2f45;
            box-shadow:0 10px 20px rgba(0,0,0,.18);
        }

        /* PAGE */
        .ticket-page{ padding:22px 22px 40px; }

        /* PILLS */
        .ticket-controls{
            display:flex;
            align-items:center;
            gap:18px;
            padding:6px 6px 18px;
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
        .spacer{ flex:1; }
        .pill.compact{ padding:0 18px; gap:12px; }
        .badge{
            width:46px;height:30px;border-radius:12px;
            background:#f2f5f8;
            display:grid;place-items:center;
            font-weight:900;
            color:#0f2f45;
        }

        /* CARD */
        .ticket-card{
            background:rgba(255,255,255,.92);
            border-radius:22px;
            padding:18px 18px 14px;
            box-shadow:var(--shadow-lg);
            border:1px solid rgba(49, 12, 98, 0.06);
        }

        /* TOP BAR CARD */
        .ticket-card-top{
            display:flex;
            align-items:center;
            gap:16px;
            margin-bottom:12px;
        }

        .grow{ flex: 1; } /* INI YANG HILANG DI KODE KAMU */

        .icon-pill{
            height:44px;
            min-width:90px;
            padding:0 18px;
            border-radius:999px;
            background:#f5f7f9;
            border:1px solid #e0e7ed;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            box-shadow:var(--shadow-sm);
            cursor:pointer;
            text-decoration: none;
            color: #14374f;
        }

       /* SEARCH PILL SMALL (seperti gambar) */
.search-pill{
    height: 40px;
    width: min(300px, 48vw);
    background: #eef0f2;
    border-radius: 999px;
    border: 1px solid #e3e7ec;
    display: flex;
    align-items: center;
    padding: 0 10px;
    gap: 8px;
    box-shadow: 0 8px 16px rgba(0,0,0,.08);
}

.search-pill__icon{
    width: 38px;
    height: 30px;
    border-radius: 12px;
    border: none;
    background: transparent;
    display: grid;
    place-items: center;
    cursor: pointer;
    color: #2b4c62;
}

.search-pill__icon svg{
    width: 18px;
    height: 18px;
}

.search-pill__input{
    flex: 1;
    height: 34px;
    border: none;
    outline: none;
    background: transparent;
    font-size: 16px;
    font-weight: 500;
    color: #2b4c62;
}

.search-pill__input::placeholder{
    color: #7b8f9e;
    font-weight: 500;
}


        /* TABLE */
        .table-shell{
            border-radius:0px;   /* jadi kotak */
            overflow:hidden;
        }

        table{
            width:100%;
            border-collapse:collapse;
            table-layout:fixed;
        }
        thead th{
            background:#234f70;
            color:#fff;
            padding:12px 10px;
            font-size:12px;
            text-transform:uppercase;
            font-weight:900;
            border-right:1px solid rgba(255,255,255,.18);
        }
        tbody td{
            padding:12px 10px;
            font-size:12px;
            font-weight:800;
            color:#1c4763;
            border-bottom:1px solid #e5edf3;
            border-right:1px solid #e5edf3;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
        tbody tr:nth-child(even) td{ background:#fbfdff; }
        tbody tr:hover td{ background:#f3f8fd; }

        .col-no{ width:44px; text-align:center; }
        .col-siteid{ width:170px; }
        .col-sitename{ width:290px; }
        .col-tipe{ width:110px; }
        .col-batch{ width:190px; }
        .col-prov{ width:140px; }
        .col-kab{ width:140px; }

        /* PAGINATION LARAVEL */
        .pagination-wrap{
            margin-top:16px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            flex-wrap:wrap;
        }
        .pagination-wrap .info{
            font-size:12px;
            font-weight:900;
            color:var(--muted);
        }

        /* bikin pagination Laravel jadi bulat */
        .pagination{
            display:flex;
            gap:10px;
            list-style:none;
            padding:0;
            margin:0;
        }
        .pagination li a,
        .pagination li span{
            width:30px;height:30px;
            border-radius:999px;
            display:grid;
            place-items:center;
            font-weight:900;
            font-size:12px;
            text-decoration:none;
            background:#f0f3f6;
            border:1px solid #dfe7ee;
            color:#1e4a68;
        }
        .pagination li.active span{
            background:#e6ebef;
            border-color:#cfdbe4;
        }

        @media (max-width: 980px){
            .ticket-controls{ flex-wrap:wrap; }
            .spacer{ display:none; }
            .search-pill{ width:100%; }
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<div class="ticket-navbar">
    <div class="nav-left">
        <div class="nav-item">Project</div>
        <div class="nav-item">Operational</div>
    </div>

    <div class="nav-right">
        <div class="avatar">
            <svg viewBox="0 0 24 24" fill="none" width="18" height="18">
                <path d="M12 12a4.5 4.5 0 1 0-4.5-4.5A4.5 4.5 0 0 0 12 12Z" stroke="currentColor" stroke-width="2"/>
                <path d="M20 20a8 8 0 0 0-16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
    </div>
</div>

<div class="ticket-page">

    {{-- BUTTONS --}}
    <div class="ticket-controls">
        <a class="pill" href="{{ route('open.ticket') }}">Open Ticket</a>
        <a class="pill is-active" href="{{ route('close.ticket') }}">Close Ticket</a>
        <a class="pill" href="{{ route('detail.ticket.dashboard') }}">Detail Ticket</a>
        <a class="pill" href="{{ route('summary.ticket') }}">Summary</a>

        <div class="spacer"></div>

        <div class="pill compact">
            Close All
            <span style="opacity:.35;font-weight:900;">:</span>
            <span class="badge">{{ $closeAllCount }}</span>
        </div>

        <div class="pill compact">
            Today
            <span style="opacity:.35;font-weight:900;">:</span>
            <span class="badge">{{ str_pad($todayCount, 2, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>

    {{-- CARD --}}
    <div class="ticket-card">

        {{-- TOP BAR --}}
        <div class="ticket-card-top">

            <a class="icon-pill" href="{{ route('close.ticket.export') }}" title="Download Excel">
                <svg viewBox="0 0 24 24" fill="none" width="22" height="22">
                    <path d="M12 3v10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M8 11l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 20h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </a>

            <div class="grow"></div>

            {{-- SEARCH --}}
            <form class="search-pill" method="GET" action="{{ route('close.ticket') }}">
                <button type="button" class="search-pill__icon" title="Filter">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 6h16M7 12h10M10 18h4"
                              stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <input
                    class="search-pill__input"
                    type="text"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Search"
                >

                <button type="submit" class="search-pill__icon" title="Search">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"
                              stroke="currentColor" stroke-width="2"/>
                        <path d="M16.5 16.5 21 21"
                              stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </form>

        </div> {{-- ✅ INI PENUTUP ticket-card-top yang kamu lupa --}}

        {{-- TABLE --}}
        <div class="table-shell">
            <table>
                <thead>
                    <tr>
                        <th class="col-no">NO.</th>
                        <th class="col-siteid">SITE ID</th>
                        <th class="col-sitename">SITE NAME</th>
                        <th class="col-tipe">TIPE</th>
                        <th class="col-batch">BATCH</th>
                        <th class="col-prov">PROVINSI</th>
                        <th class="col-kab">KABUPATEN</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tickets as $i => $t)
                        <tr>
                            <td class="col-no">{{ ($tickets->firstItem() ?? 0) + $i }}</td>
                            <td class="col-siteid">{{ $t->site_code }}</td>
                            <td class="col-sitename">{{ $t->nama_site }}</td>
                            <td class="col-tipe">{{ $t->kategori }}</td>
                            <td class="col-batch">{{ $t->detail_problem }}</td>
                            <td class="col-prov">{{ $t->provinsi }}</td>
                            <td class="col-kab">{{ $t->kabupaten }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:18px; font-weight:900; color:#6f8797;">
                                Data close ticket tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="pagination-wrap">
            <div class="info">
                Showing {{ $tickets->firstItem() ?? 0 }} to {{ $tickets->lastItem() ?? 0 }} of {{ $tickets->total() }} results
            </div>

            <div>
                {{ $tickets->appends(['q' => $search])->links() }}
            </div>
        </div>

    </div>
</div>

</body>
</html>
