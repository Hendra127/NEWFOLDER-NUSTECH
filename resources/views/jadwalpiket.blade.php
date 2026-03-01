<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Shift - {{ $bulanSekarang }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root { 
            --navy-primary: #1e293b;
            --emerald-pagi: #FFD150;  /* M */
            --amber-siang: #3A9AFF;   /* S */
            --indigo-malam: #44A194;  /* P */
            --rose-off: #A03A13;      /* OFF */
        }
        
        body { 
            background-color: #f1f5f9; 
            padding: 20px; 
            font-family: 'Inter', system-ui, -apple-system, sans-serif; 
        }

        /* Container Utama */
        #capture-area { 
            background: #ffffff; 
            padding: 40px; 
            border-radius: 4px; /* Sudut tajam lebih profesional untuk dokumen */
            overflow-x: auto;
            max-width: 100%;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid var(--navy-primary);
            padding-bottom: 20px;
        }

        .main-title {
            font-weight: 800;
            font-size: 24px;
            color: var(--navy-primary);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Styling Tabel */
        .table-piket { 
            border-collapse: separate; 
            border-spacing: 4px; 
            width: 100%;
        }

        .table-piket thead th {
            background-color: var(--navy-primary) !important;
            color: white !important;
            font-size: 11px;
            font-weight: 600;
            padding: 12px 2px;
            text-align: center;
            border: none !important;
        }

        .name-cell { 
            min-width: 200px; 
            background: #ffffff !important; 
            font-weight: 700; 
            font-size: 13px;
            color: #334155;
            border: 1px solid #e2e8f0 !important;
            padding: 10px 15px !important;
            position: sticky; 
            left: 0; 
            z-index: 10;
        }

        /* Update CSS untuk Kartu Shift */
.shift-select {
    width: 65px; 
    height: 38px; 
    border: none; 
    border-radius: 6px; 
    font-weight: 800; 
    font-size: 13px; 
    text-align: center; 
    color: white !important; 
    cursor: pointer;
    
    /* Hilangkan panah dropdown agar tidak mendorong teks */
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;

    /* KUNCI TENGAH PRESISI */
    display: inline-flex;    /* Gunakan flex agar align-items bekerja */
    align-items: center;     /* Tengah Vertikal */
    justify-content: center;   /* Tengah Horizontal */
    padding: 0 !important;   /* Hapus padding agar teks tidak naik/terdorong */
    line-height: normal;     /* Reset line-height */
    margin: 0 auto;
}

        .shift-select:hover {
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
            transform: translateY(-2px);
        }

        .shift-select:focus {
            outline: none;
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }

        /* Tambahan agar kolom tabel menyesuaikan ukuran select yang baru */
        .table-piket td {
    padding: 8px 4px !important;
    vertical-align: middle; /* Pastikan sel tabel di tengah secara vertikal */
    text-align: center;
}

        .shift-select::-ms-expand {
            display: none;
        }

        /* Card style dengan shadow */
        .bg-m, .bg-s, .bg-p, .bg-off {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
        }

        .bg-m { background-color: var(--emerald-pagi) !important; }
        .bg-s { background-color: var(--amber-siang) !important; }
        .bg-p { background-color: var(--indigo-malam) !important; }
        .bg-off { background-color: var(--rose-off) !important; }

        /* Keterangan di bawah */
        .legend-area {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
        }

        .legend-item { display: flex; align-items: center; gap: 8px; }
        .dot { width: 12px; height: 12px; border-radius: 2px; }

        /* Toolbar (Sembunyi saat download) */
        .toolbar-card {
            background: white;
            padding: 15px 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="toolbar-card no-capture">
        <div class="d-flex gap-3 align-items-center">
            <h5 class="m-0 fw-bold text-navy">Manajemen Shift</h5>
            <form action="{{ route('jadwalpiket') }}" method="GET" class="d-flex gap-2">
                <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                    @for ($m=1; $m<=12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
                <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                    @for ($y = date('Y')-1; $y <= date('Y')+1; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>
        <button class="btn btn-primary btn-sm px-4 fw-bold" onclick="downloadCapture()">
            <i class="bi bi-camera me-2"></i> Capture
        </button>
    </div>

    <div id="capture-area">
        <div class="report-header">
            <div class="main-title">Jadwal Piket</div>
            <div class="text-muted small mt-1">Bulan: {{ $bulanSekarang }} {{ $tahunSekarang }} |  NUSTECH Indonesia</div>
        </div>

        <div class="table-responsive" style="overflow: visible !important;">
            <table class="table table-borderless table-piket">
                <thead>
                    <tr>
                        <th class="name-cell text-center align-middle" style="background:#1e293b !important; color:white !important;">Nama</th>
                        @for ($i = 1; $i <= $jumlahHari; $i++)
                            <th class="align-middle">{{ $i }}</th>
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

        <div class="legend-area">
            <div class="legend-item"><div class="dot bg-m"></div> Pagi (M)</div>
            <div class="legend-item"><div class="dot bg-s"></div> Siang (S)</div>
            <div class="legend-item"><div class="dot bg-p"></div> Malam (P)</div>
            <div class="legend-item"><div class="dot bg-off"></div> Libur (OFF)</div>
        </div>
    </div>
</div>

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

        $.ajax({
            url: "{{ route('piket.updateShift') }}",
            method: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                nama: $el.data('nama'),
                tanggal: $el.data('tanggal'),
                shift_kode: kode
            }
        });
    }

    function downloadCapture() {
    const element = document.getElementById('capture-area');
    const toolbar = document.querySelector('.no-capture');
    
    if(toolbar) toolbar.style.visibility = 'hidden';
    
    window.scrollTo(0,0);

    html2canvas(element, {
        scale: 4, 
        useCORS: true,
        backgroundColor: "#ffffff",
        logging: false,
        width: element.scrollWidth,
        height: element.scrollHeight,
        windowWidth: element.scrollWidth, 
        onclone: (clonedDoc) => {
            const clonedArea = clonedDoc.getElementById('capture-area');
            
            // 1. PAKSA LEBAR agar tidak terpotong
            if(clonedArea) {
                clonedArea.style.width = element.scrollWidth + 'px';
                clonedArea.style.maxWidth = 'none';
                clonedArea.style.overflow = 'visible';
            }

            // 2. TRIK FIX POSISI TEKS: Ubah Select menjadi Div di hasil clone
            const selects = clonedDoc.querySelectorAll('.shift-select');
            selects.forEach(s => {
                const val = s.value; // Ambil nilai M, S, P, atau OFF
                const parent = s.parentNode;
                
                // Buat elemen pengganti berupa DIV
                const replacement = clonedDoc.createElement('div');
                replacement.innerText = val;
                
                // Salin semua class (untuk warna background) dan style dasar
                replacement.className = s.className; 
                
                // Styling paksa agar div benar-benar presisi di tengah
                Object.assign(replacement.style, {
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    width: '65px',   // Sesuaikan dengan CSS select Anda
                    height: '38px',  // Sesuaikan dengan CSS select Anda
                    borderRadius: '6px',
                    fontWeight: '800',
                    fontSize: '13px',
                    color: 'white',
                    margin: '0 auto',
                    padding: '0',
                    lineHeight: '1', // Line height 1 sangat membantu presisi vertikal
                    textAlign: 'center'
                });

                // Ganti select dengan div baru ini (hanya di dokumen clone/download)
                parent.replaceChild(replacement, s);
            });

            // 3. FIX STICKY: Kolom nama diubah ke static agar tidak berantakan
            const stickyCells = clonedDoc.querySelectorAll('.name-cell');
            stickyCells.forEach(cell => {
                cell.style.position = 'static';
            });
        }
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = `Jadwal_Piket_{{ $bulanSekarang }}_{{ $tahunSekarang }}.png`;
        link.href = canvas.toDataURL("image/png", 1.0);
        link.click();
        
        if(toolbar) toolbar.style.visibility = 'visible';
    }).catch(err => {
        console.error('Error:', err);
        if(toolbar) toolbar.style.visibility = 'visible';
    });
}
</script>
</body>
</html>