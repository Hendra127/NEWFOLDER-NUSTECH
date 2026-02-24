<!DOCTYPE html>
<html lang="id">
<head>
    @include('components.nav-modal-structure')
    <title>Management PM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>

    <style>
        /* Memastikan body tidak memiliki margin default yang merusak layout */
        body { margin: 0; padding: 0; }
        
        .tabs-section {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .tab {
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            background-color: white;
            border: 1px solid #e5e7eb;
            transition: all 0.3s;
        }
        .tab.active {
            background-color: #2C4E68;
            color: white !important;
        }
    </style>
</head>
<body class="bg-gray-100">

    <header class="main-header bg-[#2C4E68] text-white p-3">
        <div class="header-logo-container">
            <a href="javascript:void(0)" class="header-brand-link" onclick="openNavModal()" style="text-decoration: none !important; color: white !important;">
                <div class="header-brand" style="display: flex; align-items: center; gap: 8px; font-weight: bold;">
                    Project <span style="opacity: 0.5;">|</span> Operational
                </div>
            </a>
        </div>
    </header>

    <main class="p-6 font-sans">
        
        <div class="tabs-section">
            <a href="{{ route('datasite') }}" class="tab {{ request()->is('datasite*') ? 'active' : '' }}" style="text-decoration: none; color: black;">All Sites</a>
            <a href="{{ url('/datapass') }}" class="tab {{ request()->is('datapass*') ? 'active' : '' }}" style="text-decoration: none; color: black;">Management Password</a>
            <a href="{{ url('/laporanpm') }}" class="tab {{ request()->is('laporanpm*') ? 'active' : '' }}" style="text-decoration: none; color: black;">Laporan PM</a>
            <a href="{{ url('/PMLiberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}" style="text-decoration: none; color: black;">PM Liberta</a>
            <a href="{{ url('/summarypm') }}" class="tab {{ request()->is('summarypm*') ? 'active' : '' }}" style="text-decoration: none; color: black;">PM Summary</a>
        </div>

        <div class="flex gap-4 mb-6">
            <select class="bg-white border rounded-lg px-4 py-2 shadow-sm outline-none">
                <option>Semua Bulan</option>
            </select>
            <select class="bg-white border rounded-lg px-4 py-2 shadow-sm outline-none">
                <option>DONE</option>
            </select>
            <select class="bg-white border rounded-lg px-4 py-2 shadow-sm outline-none">
                <option>ALL</option>
            </select>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-center font-bold text-[#2C4E68] text-lg mb-4">Chart Total Done per Date</h3>
                <div class="flex justify-center gap-4 mb-4">
                    <span class="bg-gray-100 px-4 py-1 rounded-full text-sm font-bold">BMN : 237</span>
                    <span class="bg-gray-100 px-4 py-1 rounded-full text-sm font-bold">SL : 121</span>
                    <span class="bg-gray-100 px-4 py-1 rounded-full text-sm font-bold uppercase">Total : 358</span>
                </div>
                <canvas id="doneChart" height="150"></canvas>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-center font-bold text-[#2C4E68] text-lg mb-4">Summary Done per Bulan</h3>
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-[#2C4E68] text-white text-center">
                            <tr>
                                <th class="p-2 border border-gray-300">BULAN</th>
                                <th class="p-2 border border-gray-300">BMN</th>
                                <th class="p-2 border border-gray-300">SL</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach(['JANUARY', 'FEBRUARY', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS'] as $month)
                            <tr>
                                <td class="p-2 border border-gray-200 bg-gray-50 font-medium">{{ $month }}</td>
                                <td class="p-2 border border-gray-200 text-center">-</td>
                                <td class="p-2 border border-gray-200 text-center">-</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-[#2C4E68] text-lg">List Site PM</h3>
                <div class="relative w-64">
                    <input type="text" placeholder="Search..." class="w-full pl-4 pr-10 py-2 border rounded-full bg-gray-50 focus:outline-none focus:ring-1 focus:ring-blue-400">
                    <span class="absolute right-3 top-2.5 text-gray-400">🔍</span>
                </div>
            </div>
            
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-[12px] border-collapse">
                    <thead class="bg-[#2C4E68] text-white">
                        <tr>
                            <th class="p-2 border border-gray-400">NO.</th>
                            <th class="p-2 border border-gray-400">SITE ID</th>
                            <th class="p-2 border border-gray-400">NAMA SITE</th>
                            <th class="p-2 border border-gray-400">PROVINSI</th>
                            <th class="p-2 border border-gray-400">KABUPATEN</th>
                            <th class="p-2 border border-gray-400">MONTH</th>
                            <th class="p-2 border border-gray-400">DATE</th>
                            <th class="p-2 border border-gray-400">STATUS</th>
                            <th class="p-2 border border-gray-400">KATEGORI</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @for($i = 1; $i <= 5; $i++)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border border-gray-200 text-center">{{ $i }}</td>
                            <td class="p-2 border border-gray-200 font-mono">AO16224586147209N</td>
                            <td class="p-2 border border-gray-200">SMK ANALIS KESEHATAN KOTA SORONG</td>
                            <td class="p-2 border border-gray-200 text-blue-600 font-semibold">SULAWESI TENGAH</td>
                            <td class="p-2 border border-gray-200">KAB. TOJO UNA UNA</td>
                            <td class="p-2 border border-gray-200 text-center">Februari</td>
                            <td class="p-2 border border-gray-200 text-center">2024-02-27</td>
                            <td class="p-2 border border-gray-200 text-center"><span class="font-bold text-gray-800">DONE</span></td>
                            <td class="p-2 border border-gray-200 text-center font-bold">BMN</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ctx = document.getElementById('doneChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: Array.from({length: 30}, (_, i) => i + 1),
                datasets: [{
                    label: 'Total Done',
                    data: [11, 8, 16, 15, 5, 6, 12, 7, 9, 13, 8, 15, 18, 7, 8, 15, 12, 6, 15, 12, 5, 15, 5, 18, 6, 11, 5],
                    borderColor: '#2C4E68',
                    backgroundColor: 'rgba(44, 78, 104, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 2
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, max: 20 },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>