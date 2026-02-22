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

    <div class="flex justify-between items-center mb-6">
        <div class="tabs-section">
        <a href="{{ url('/open-ticket') }}" class="tab {{ request()->is('open-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Open Tiket</a>
        <a href="{{ url('/close-ticket') }}" class="tab {{ request()->is('close-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Close Tiket</a>
        <a href="{{ url('/detailticket') }}" class="tab {{ request()->is('detailticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Detail Tiket</a>
        <a href="{{ url('/summaryticket') }}" class="tab {{ request()->is('summaryticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black ;">Summary Tiket</a>
    </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="card p-4">
            <h3 class="text-center font-bold text-header text-xl mb-4">Chart Open Ticket</h3>
            <canvas id="chartOpen" height="150"></canvas>
        </div>
        <div class="card p-4">
            <h3 class="text-center font-bold text-header text-xl mb-4">Chart Durasi Open Ticket</h3>
            <canvas id="chartDurasi" height="150"></canvas>
        </div>
    </div>

    <div class="card overflow-hidden mb-6">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="table-header">
                    <th class="p-3 border-r border-slate-500">OPEN AND CLOSE TICKET / BULAN</th>
                    <th colspan="2" class="p-3 text-center">STATUS TICKET</th>
                </tr>
                <tr class="bg-[#2d5d77] text-white">
                    <th class="p-2 border-r border-slate-500 uppercase">Kategori</th>
                    <th class="p-2 border-r border-slate-500 text-center uppercase">Close</th>
                    <th class="p-2 text-center uppercase">Open</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategoriSummary as $item)
                <tr class="border-b">
                    <td class="p-3 font-medium text-slate-600">{{ $item->kategori }}</td>
                    <td class="p-3 text-center text-slate-600">{{ $item->close_total }}</td>
                    <td class="p-3 text-center text-slate-600">{{ $item->open_total }}</td>
                </tr>
                @endforeach
                <tr class="font-bold bg-slate-50">
                    <td class="p-3">Grand Total</td>
                    <td class="p-3 text-center text-header">{{ $grandClose }}</td>
                    <td class="p-3 text-center text-header">{{ $grandOpen }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="card overflow-hidden">
            <table class="w-full text-xs">
                <thead class="table-header uppercase">
                    <tr>
                        <th class="p-2 border-r border-slate-500">Open Ticket / Hari</th>
                        <th class="p-2 border-r border-slate-500 text-center">Open</th>
                        <th class="p-2 text-center">Percent</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($openByKategori as $item)
                    <tr class="border-b">
                        <td class="p-2 font-medium">{{ $item->kategori }}</td>
                        <td class="p-2 text-center">{{ $item->total }}</td>
                        <td class="p-2 text-center">{{ $openGrand > 0 ? number_format(($item->total / $openGrand) * 100, 2) : 0 }} %</td>
                    </tr>
                    @endforeach
                    <tr class="font-bold bg-slate-50">
                        <td class="p-2">Grand Total</td>
                        <td class="p-2 text-center">{{ $openGrand }}</td>
                        <td class="p-2 text-center">100.00 %</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card overflow-hidden">
            <table class="w-full text-xs h-full">
                <thead class="table-header uppercase">
                    <tr>
                        <th class="p-2 border-r border-slate-500">Close Ticket / Hari</th>
                        <th class="p-2 text-center">Close</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($closeByKategori as $item)
                    <tr class="border-b">
                        <td class="p-2 font-medium">{{ $item->kategori }}</td>
                        <td class="p-2 text-center">{{ $item->total }}</td>
                    </tr>
                    @endforeach
                    <tr class="font-bold bg-slate-50">
                        <td class="p-2">Grand Total</td>
                        <td class="p-2 text-center">{{ $closeGrand }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-xs">
            <thead class="table-header uppercase">
                <tr>
                    <th class="p-2 border-r border-slate-500 text-center w-12">No.</th>
                    <th class="p-2 border-r border-slate-500">Kabupaten</th>
                    <th class="p-2 border-r border-slate-500 text-center">Status Ticket</th>
                    <th class="p-2 text-center">Durasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kabupatenTable as $index => $row)
                <tr class="{{ $index % 2 == 1 ? 'table-row-even' : '' }} border-b">
                    <td class="p-2 text-center border-r">{{ $index + 1 }}</td>
                    <td class="p-2 border-r font-medium">{{ $row->kabupaten }}</td>
                    <td class="p-2 border-r text-center">{{ $row->status_total }}</td>
                    <td class="p-2 text-center">{{ $row->durasi_total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        const chartOptions = {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#e2e8f0' } },
                x: { grid: { display: false } }
            }
        };

        // Chart Open Ticket
        new Chart(document.getElementById('chartOpen'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($openLabels) !!},
                datasets: [{
                    data: {!! json_encode($openTotals) !!},
                    backgroundColor: '#1e4d66',
                    barPercentage: 0.7
                }]
            },
            options: chartOptions
        });

        // Chart Durasi
        new Chart(document.getElementById('chartDurasi'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($durasiLabels) !!},
                datasets: [{
                    data: {!! json_encode($durasiTotals) !!},
                    backgroundColor: '#1e4d66',
                    barPercentage: 0.6
                }]
            },
            options: chartOptions
        });
    </script>
</body>
</html>