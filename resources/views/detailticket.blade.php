<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Page - Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

    <style>
        :root{
            --navy:#1e4a68;
            --navy2:#234f70;
            --bg:#eef2f5;
            --text:#123247;
            --muted:#6f8797;

            --shadow-lg: 0 16px 30px rgba(0,0,0,.18);
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
        .ticket-page{ padding:22px 22px 40px; }

        /* PILLS */
        .ticket-controls{
            display:flex;
            align-items:center;
            gap:18px;
            padding:6px 6px 18px;
            flex-wrap:wrap;
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
            padding:0 10px;
            font-size:14px;
            height:32px;
        }


        /* GRID LAYOUT (persis gambar) */
        .grid{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap:22px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .card{
            background:rgba(255,255,255,.92);
            border-radius:16px;
            padding:16px;
            box-shadow:var(--shadow-lg);
            border:1px solid rgba(0,0,0,.06);
        }

        .card-title{
            text-align:center;
            font-weight:900;
            font-size:18px;
            color:#14374f;
            margin-bottom:10px;
        }

        /* CARD LIST OPEN */
        .ticket-list{
            height: 310px;
            overflow:auto;
            padding-right: 8px;
        }
        .ticket-item{
            display:flex;
            gap:10px;
            background:#eef2f5;
            border-radius:10px;
            padding:10px 12px;
            margin-bottom:10px;
            border:1px solid rgba(0,0,0,.06);
        }
        .ticket-icon{
            width:24px;
            height:24px;
            border-radius:6px;
            background:#214e6f;
            display:grid;
            place-items:center;
            color:#fff;
            flex: none;
        }
        .ticket-text{
            font-size:12px;
            font-weight:900;
            color:#123247;
            line-height:1.25;
        }
        .ticket-sub{
            font-size:10px;
            font-weight:800;
            color:#4c6474;
            margin-top:2px;
        }

        /* BIG CARDS */
        .card-full{
            grid-column: 1 / -1;
        }

        /* Chart container */
        .chart-wrap{
            height: 280px;
        }
        canvas{
            width:100% !important;
            height:100% !important;
        }

        /* Map */
        .map-wrap{
            height: 360px;
            overflow:hidden;
            border-radius:12px;
            border:1px solid rgba(0,0,0,.08);
        }
        .map-wrap iframe{
            width:100%;
            height:100%;
            border:0;
        }

        @media (max-width: 980px){
            .grid{ grid-template-columns: 1fr; }
            .card-full{ grid-column: auto; }
            .ticket-list{ height: 260px; }
        }
    </style>




<div class="ticket-page">

    {{-- MENU --}}
    <div class="flex justify-between items-center mb-6">
        <div class="tabs-section">
        <a href="{{ url('/open-ticket') }}" class="tab {{ request()->is('open-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Open Tiket</a>
        <a href="{{ url('/close-ticket') }}" class="tab {{ request()->is('close-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Close Tiket</a>
        <a href="{{ url('/detailticket') }}" class="tab {{ request()->is('detailticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Detail Tiket</a>
        <a href="{{ url('/summaryticket') }}" class="tab {{ request()->is('summaryticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Summary Tiket</a>
    </div>
    </div>

    <div class="grid">

        {{-- CARD 1: LIST OPEN --}}
        <div class="card">
            <div class="card-title">Detail Open Ticket</div>

            <div class="ticket-list">
                @forelse($openTickets as $t)
                    <div class="ticket-item">
                        <div class="ticket-icon">
                            <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                                <path d="M7 7h10M7 12h10M7 17h7"
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <div>
                            <div class="ticket-text">
                                #AO{{ str_pad($t->id, 10, '0', STR_PAD_LEFT) }}
                                {{ $t->site_code }}
                                {{ $t->nama_site }}
                            </div>

                            <div class="ticket-sub">
                                {{ strtoupper($t->kategori) }}
                                <br>
                                {{ $t->kendala ?? '-' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; font-weight:900; color:#6f8797; padding:16px;">
                        Tidak ada open ticket.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- CARD 2: LINE CHART --}}
        <div class="card">
            <div class="card-title">Jumlah Close Ticket per Bulan</div>

            <div class="chart-wrap">
                <canvas id="closeChart"></canvas>
            </div>
        </div>

        {{-- CARD 3: BAR CHART --}}
        <div class="card card-full">
            <div class="card-title">Total Open Ticket Berdasarkan Kabupaten</div>

            <div class="chart-wrap" style="height: 380px;">
                <canvas id="kabChart"></canvas>
            </div>
        </div>

        {{-- CARD 4: MAP --}}
        <div class="card card-full">
            <div class="map-wrap">
                <iframe
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d20274842.699450146!2d117.240355!3d-2.483382!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sid!2sid!4v1700000000000">
                </iframe>
            </div>
        </div>

    </div>
</div>

<script>
    // Data dari controller
    const closeLabels = @json($closeLabels);
    const closeTotals = @json($closeTotals);

    const kabLabels = @json($kabLabels);
    const kabTotals = @json($kabTotals);

    // LINE CHART
    new Chart(document.getElementById('closeChart'), {
        type: 'line',
        data: {
            labels: closeLabels,
            datasets: [{
                label: 'Close Ticket',
                data: closeTotals,
                borderWidth: 2,
                tension: 0.35,
                pointRadius: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // BAR CHART
    new Chart(document.getElementById('kabChart'), {
        type: 'bar',
        data: {
            labels: kabLabels,
            datasets: [{
                label: 'Total Open Ticket',
                data: kabTotals,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

</body>
</html>
