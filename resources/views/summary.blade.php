<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Summary Ticket</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    :root{
        --navy:#1e4a68;
        --navy2:#234f70;
        --bg:#eef2f5;
        --text:#123247;
        --muted:#6f8797;

        --shadow-lg: 0 16px 30px rgba(0,0,0,.22);
        --shadow-md: 0 10px 18px rgba(0,0,0,.18);
        --shadow-sm: 0 6px 14px rgba(0,0,0,.14);
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
        color:#fff;
        display:flex;
        align-items:center;
        padding:0 26px;
        box-shadow:0 10px 22px rgba(0,0,0,.22);
        position:sticky;
        top:0;
        z-index:20;
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
    .ticket-page{
        padding:22px 22px 44px;
        max-width: 1460px;
        margin: 0 auto;
    }

    /* MENU + FILTER */
    .top-row{
        display:flex;
        align-items:center;
        gap:18px;
        flex-wrap:wrap;
        margin-bottom:18px;
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
            height:32px;
            font-size:14px;
        }

    .spacer{ flex:1; }

    .select-pill{
        height:48px;
        padding:0 16px 0 18px;
        border-radius:999px;
        background:#fff;
        border:1px solid #e4eaef;
        font-weight:900;
        color:#14374f;
        box-shadow:var(--shadow-sm);
        display:flex;
        align-items:center;
        gap:10px;
        min-width: 180px;
        justify-content:space-between;
    }
    .select-pill select{
        border:none;
        outline:none;
        background:transparent;
        font-weight:900;
        font-size:16px;
        color:#14374f;
        cursor:pointer;
        width:100%;
        appearance:none;
    }

    /* GRID */
    .grid{
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap:22px;
    }

    .card{
        background:rgba(255,255,255,.92);
        border-radius:18px;
        padding:18px 18px 14px;
        box-shadow:var(--shadow-lg);
        border:1px solid rgba(0,0,0,.06);
    }
    .card-full{ grid-column: 1 / -1; }

    .card-title{
        text-align:center;
        font-weight:900;
        font-size:20px;
        color:#14374f;
        margin:2px 0 12px;
    }

    /* CHART */
    .chart-wrap{
        height: 300px;
        padding: 0 6px 4px;
    }
    .chart-wrap.big{
        height: 380px;
        padding: 0 10px 8px;
    }

    canvas{ width:100% !important; height:100% !important; }

    /* TABLE */
    .table-shell{
        border-radius:12px;
        overflow:hidden;
        border:1px solid #dfe7ee;
        background:#fff;
    }
    table{
        width:100%;
        border-collapse:collapse;
        table-layout:fixed;
    }

    thead th{
        background:#234f70;
        color:#fff;
        padding:12px 12px;
        font-size:11px;
        text-transform:uppercase;
        font-weight:900;
        border-right:1px solid rgba(255,255,255,.18);
    }

    tbody td{
        padding:12px 12px;
        font-size:12px;
        font-weight:900;
        color:#1c4763;
        border-bottom:1px solid #e5edf3;
        border-right:1px solid #e5edf3;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    tbody tr:nth-child(even) td{ background:#fbfdff; }

    .text-center{ text-align:center; }

    /* 2 table small */
    .small-grid{
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap:22px;
    }

    /* spacing seperti gambar */
    .mt-6{ margin-top: 10px; }

    @media (max-width: 980px){
        .grid{ grid-template-columns:1fr; }
        .card-full{ grid-column:auto; }
        .small-grid{ grid-template-columns:1fr; }
        .select-pill{ width:100%; }
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

    {{-- MENU + FILTER --}}
    <div class="top-row">
        <a class="pill" href="{{ route('open.ticket') }}">Open Ticket</a>
        <a class="pill" href="{{ route('close.ticket') }}">Close Ticket</a>
        <a class="pill" href="{{ route('detail.ticket.dashboard') }}">Detail Ticket</a>
        <a class="pill is-active" href="{{ route('summary.ticket') }}">Summary</a>

        <div class="spacer"></div>

        <form class="select-pill" method="GET" action="{{ route('summary.ticket') }}">
            <select name="month" onchange="this.form.submit()">
                <option value="">Semua Bulan</option>
                @foreach($months as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ $m }}
                    </option>
                @endforeach
            </select>

            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path d="M7 10l5 5 5-5" stroke="#14374f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </form>
    </div>

    <div class="grid">

        {{-- CHART 1 --}}
        <div class="card">
            <div class="card-title">Chart Open Ticket</div>
            <div class="chart-wrap">
                <canvas id="openChart"></canvas>
            </div>
        </div>

        {{-- CHART 2 --}}
        <div class="card">
            <div class="card-title">Chart Durasi Open Ticket</div>
            <div class="chart-wrap">
                <canvas id="durasiChart"></canvas>
            </div>
        </div>

        {{-- TABLE OPEN CLOSE BULAN --}}
        <div class="card card-full">
            <div class="table-shell">
                <table>
                    <thead>
                        <tr>
                            <th style="width:55%;">OPEN AND CLOSE TICKET / BULAN</th>
                            <th colspan="2" class="text-center">STATUS TICKET</th>
                        </tr>
                        <tr>
                            <th>KATEGORI</th>
                            <th class="text-center">CLOSE</th>
                            <th class="text-center">OPEN</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($kategoriSummary as $row)
                            <tr>
                                <td>{{ $row->kategori }}</td>
                                <td class="text-center">{{ $row->close_total }}</td>
                                <td class="text-center">{{ $row->open_total }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td><b>Grand Total</b></td>
                            <td class="text-center"><b>{{ $grandClose }}</b></td>
                            <td class="text-center"><b>{{ $grandOpen }}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 2 SMALL TABLE --}}
        <div class="card card-full">
            <div class="small-grid">

                {{-- OPEN / HARI --}}
                <div class="table-shell">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:55%;">OPEN TICKET / HARI</th>
                                <th class="text-center">OPEN</th>
                                <th class="text-center">PERCENT</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($openByKategori as $row)
                                <tr>
                                    <td>{{ $row->kategori }}</td>
                                    <td class="text-center">{{ $row->total }}</td>
                                    <td class="text-center">
                                        @if($openGrand > 0)
                                            {{ number_format(($row->total / $openGrand) * 100, 2) }} %
                                        @else
                                            0 %
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td><b>Grand Total</b></td>
                                <td class="text-center"><b>{{ $openGrand }}</b></td>
                                <td class="text-center"><b>100.00 %</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- CLOSE / HARI --}}
                <div class="table-shell">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:70%;">CLOSE TICKET / HARI</th>
                                <th class="text-center">CLOSE</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($closeByKategori as $row)
                                <tr>
                                    <td>{{ $row->kategori }}</td>
                                    <td class="text-center">{{ $row->total }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td><b>Grand Total</b></td>
                                <td class="text-center"><b>{{ $closeGrand }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        {{-- TABLE KABUPATEN --}}
        <div class="card card-full">
            <div class="table-shell">
                <table>
                    <thead>
                        <tr>
                            <th style="width:60px;">NO.</th>
                            <th>KABUPATEN</th>
                            <th style="width:160px;" class="text-center">STATUS TICKET</th>
                            <th style="width:160px;" class="text-center">DURASI</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($kabupatenTable as $i => $row)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ strtoupper($row->kabupaten) }}</td>
                                <td class="text-center">{{ $row->status_total }}</td>
                                <td class="text-center">{{ $row->durasi_total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    const openLabels = @json($openLabels);
    const openTotals = @json($openTotals);

    const durasiLabels = @json($durasiLabels);
    const durasiTotals = @json($durasiTotals);

    // Chart Open Ticket
    new Chart(document.getElementById('openChart'), {
        type: 'bar',
        data: {
            labels: openLabels,
            datasets: [{
                label: 'Open Ticket',
                data: openTotals,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Chart Durasi Open Ticket
    new Chart(document.getElementById('durasiChart'), {
        type: 'bar',
        data: {
            labels: durasiLabels,
            datasets: [{
                label: 'Durasi Open',
                data: durasiTotals,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>

</body>
</html>
