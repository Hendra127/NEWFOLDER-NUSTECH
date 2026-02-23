<!DOCTYPE html>
<html lang="id">
<head>
    @include('components.nav-modal-structure')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket</title>
     <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/detailtiket.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
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
        <a href="{{ url('/open-ticket') }}" class="tab {{ request()->is('open-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Open Tiket</a>
        <a href="{{ url('/close-ticket') }}" class="tab {{ request()->is('close-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Close Tiket</a>
        <a href="{{ url('/detailticket') }}" class="tab {{ request()->is('detailticket*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Detail Tiket</a>
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
