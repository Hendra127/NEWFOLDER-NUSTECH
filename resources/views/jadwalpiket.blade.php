<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Shift</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root { 
            --pagi: #0d6efd;   /* Biru Primer */
            --siang: #ffc107;  /* Kuning */
            --malam: #6610f2;  /* Ungu */
            --off: #dc3545;    /* Merah Solid */
        }
        body { background-color: #f8f9fa; padding: 20px; font-family: sans-serif; }
        
        /* 1. Judul di Paling Atas */
        .main-title {
            text-align: center;
            font-weight: 800;
            font-size: 24px;
            margin-bottom: 20px;
            color: #2c3e50;
            text-transform: uppercase;
        }

        /* 2. Toolbar di bawah Judul (Filter & Buttons) */
        .toolbar-card {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* 3. Area Tabel */
        #capture-area { background: #f8f9fa; padding: 10px; }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .table-piket { border-spacing: 5px; border-collapse: separate; }
        
        .name-cell { 
            min-width: 250px; 
            background: white !important; 
            border: 1px solid #ebedef !important; 
            border-radius: 10px; 
            font-weight: 700; 
            padding: 12px 15px !important;
            position: sticky; left: 0; z-index: 5;
        }
        
        .date-head { 
            background: #5a5a5a !important; color: white; 
            text-align: center; width: 45px; min-width: 45px;
            border-radius: 5px;
        }
        
        .shift-select {
            width: 48px; height: 38px; border: none; border-radius: 8px;
            font-weight: 800; font-size: 11px; text-align: center; color: white; cursor: pointer;
            appearance: none; -webkit-appearance: none;
        }

        .bg-m { background-color: var(--pagi) !important; }
        .bg-s { background-color: var(--siang) !important; }
        .bg-p { background-color: var(--malam) !important; }
        .bg-off { background-color: var(--off) !important; }
        
        .loading-overlay { opacity: 0.5; pointer-events: none; }
    </style>
</head>
<body>

<div class="container-fluid">
    
    <div id="capture-area">
        <div class="main-title">
            JADWAL SHIFT BULAN {{ strtoupper($bulanSekarang) }} {{ $tahunSekarang }}
        </div>

        <div class="toolbar-card no-capture">
            <div class="d-flex align-items-center gap-3">
                <form action="{{ route('jadwalpiket') }}" method="GET" class="d-flex align-items-center gap-2">
                    <label class="fw-bold small">Bulan:</label>
                    <select name="month" class="form-select form-select-sm" style="width: 130px;" onchange="this.form.submit()">
                        @for ($m=1; $m<=12; $m++)
                            <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>

                    <label class="fw-bold small ms-2">Tahun:</label>
                    <select name="year" class="form-select form-select-sm" style="width: 90px;" onchange="this.form.submit()">
                        @for ($y = date('Y')-1; $y <= date('Y')+1; $y++)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-success btn-sm px-3 shadow-sm" onclick="downloadCapture()">
                    <i class="bi bi-camera-fill"></i> Download Capture
                </button>
                <button class="btn btn-outline-danger btn-sm px-3 shadow-sm" onclick="if(confirm('Kosongkan jadwal?')) document.getElementById('form-delete').submit()">
                    <i class="bi bi-trash"></i> Kosongkan
                </button>
            </div>
        </div>

        <div class="table-container">
            <div class="table-responsive" style="overflow: visible !important;">
                <table class="table table-borderless table-piket">
                    <thead>
                        <tr>
                            <th class="name-cell text-center align-middle">Nama Petugas</th>
                            @for ($i = 1; $i <= $jumlahHari; $i++)
                                <th class="date-head align-middle">{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daftarNama as $nama)
                        <tr>
                            <td class="name-cell align-middle">{{ $nama }}</td>
                            @for ($d = 1; $d <= $jumlahHari; $d++)
                                @php
                                    $tgl = \Carbon\Carbon::createFromDate($year, $month, $d)->format('Y-m-d');
                                    $userRow = \App\Models\User::where('name', 'like', '%' . trim($nama) . '%')->first();
                                    $existing = $userRow ? $dataPiket->where('user_id', $userRow->id)->where('tanggal', $tgl)->first() : null;
                                    $kodeAktif = $existing && $existing->shift ? $existing->shift->kode : 'OFF';

                                    $class = match(strtoupper($kodeAktif)) {
                                        'M' => 'bg-m', 'S' => 'bg-s', 'P' => 'bg-p', default => 'bg-off',
                                    };
                                @endphp
                                <td class="text-center align-middle">
                                    <select class="shift-select {{ $class }}" 
                                            data-nama="{{ trim($nama) }}" 
                                            data-tanggal="{{ $tgl }}"
                                            onchange="updateData(this)">
                                        <option value="OFF" {{ $kodeAktif == 'OFF' ? 'selected' : '' }}>OFF</option>
                                        <option value="M" {{ $kodeAktif == 'M' ? 'selected' : '' }}>M</option>
                                        <option value="S" {{ $kodeAktif == 'S' ? 'selected' : '' }}>S</option>
                                        <option value="P" {{ $kodeAktif == 'P' ? 'selected' : '' }}>P</option>
                                    </select>
                                </td>
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<form id="form-delete" action="{{ route('piket.deleteAll') }}" method="POST" class="d-none">
    @csrf @method('DELETE')
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    function updateData(el) {
        const $el = $(el);
        const kode = $el.val();
        
        $el.removeClass('bg-m bg-s bg-p bg-off');
        if(kode == 'M') $el.addClass('bg-m');
        else if(kode == 'S') $el.addClass('bg-s');
        else if(kode == 'P') $el.addClass('bg-p');
        else $el.addClass('bg-off');

        $el.addClass('loading-overlay');

        $.ajax({
            url: "{{ route('piket.updateShift') }}",
            method: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                nama: $el.data('nama'),
                tanggal: $el.data('tanggal'),
                shift_kode: kode
            },
            success: function(res) {
                $el.removeClass('loading-overlay');
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || "Nama petugas tidak ditemukan!");
                location.reload(); 
            }
        });
    }

    function downloadCapture() {
    const captureArea = document.getElementById('capture-area');
    const toolbar = document.querySelector('.no-capture');
    
    toolbar.style.display = 'none';

    html2canvas(captureArea, {
        scale: 2,
        useCORS: true,
        backgroundColor: "#f8f9fa",
        // Gunakan scrollWidth agar menangkap seluruh lebar tabel yang tersembunyi
        width: captureArea.scrollWidth,
        windowWidth: captureArea.scrollWidth 
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = `Jadwal_Piket_{{ $bulanSekarang }}.png`;
        link.href = canvas.toDataURL("image/png");
        link.click();
        toolbar.style.display = 'flex';
    });
}
</script>
</body>
</html>