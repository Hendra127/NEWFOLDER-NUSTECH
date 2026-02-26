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
        :root { --pagi: #5cb85c; --siang: #f0ad4e; --malam: #5bc0de; --off: #ff5c5c; }
        body { background-color: #f8f9fa; padding: 20px; font-family: sans-serif; }
        
        .toolbar { background: white; padding: 15px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .table-piket { border-spacing: 3px; border-collapse: separate; }
        
        .name-cell { 
            min-width: 250px; background: white !important; border: 1px solid #dee2e6 !important; 
            border-radius: 8px; font-weight: 600; padding: 12px !important;
            position: sticky; left: 0; z-index: 2;
        }
        
        .date-head { background: #343a40 !important; color: white; text-align: center; min-width: 50px; }
        
        /* Select Box Styling */
        .shift-select {
            width: 48px; height: 35px; border: none; border-radius: 6px;
            font-weight: bold; font-size: 12px; text-align: center; color: white; cursor: pointer;
            appearance: none; -webkit-appearance: none;
        }
        .bg-m { background-color: var(--pagi); }
        .bg-s { background-color: var(--siang); }
        .bg-p { background-color: var(--malam); }
        .bg-off { background-color: var(--off); }
        
        .loading-overlay { opacity: 0.5; pointer-events: none; }

        /* Area Capture: Pastikan lebar mengikuti tabel yang lebar */
        #capture-area { 
            padding: 15px; 
            background-color: #f8f9fa; 
            width: fit-content; 
            min-width: 100%;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="toolbar d-flex justify-content-between align-items-center">
        <form action="{{ route('jadwalpiket') }}" method="GET" class="d-flex gap-3 align-items-center">
            <div class="d-flex align-items-center gap-2">
                <label class="small fw-bold text-muted text-nowrap">Pilih Bulan:</label>
                <select name="month" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.submit()">
                    @for ($m=1; $m<=12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="d-flex align-items-center gap-2">
                <label class="small fw-bold text-muted text-nowrap">Tahun:</label>
                <select name="year" class="form-select form-select-sm" style="width: 100px;" onchange="this.form.submit()">
                    @for ($y = date('Y')-1; $y <= date('Y')+1; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </form>

        <div class="d-flex gap-2">
            <button class="btn btn-success btn-sm px-3" onclick="downloadCapture()">
                <i class="bi bi-camera"></i> Download Capture
            </button>
            <button class="btn btn-outline-danger btn-sm px-3" onclick="if(confirm('Kosongkan semua jadwal bulan ini?')) document.getElementById('form-delete').submit()">
                <i class="bi bi-trash"></i> Kosongkan
            </button>
            <form id="form-delete" action="{{ route('piket.deleteAll') }}" method="POST" class="d-none">
                @csrf @method('DELETE')
            </form>
        </div>
    </div>

    <div id="capture-area">
        <h3 class="text-center fw-bold mb-4">JADWAL SHIFT BULAN {{ strtoupper($bulanSekarang) }} {{ $tahunSekarang }}</h3>
        
        <div class="table-responsive bg-white p-3 rounded shadow-sm">
            <table class="table table-borderless table-piket">
                <thead>
                    <tr>
                        <th class="name-cell text-center">Nama</th>
                        @for ($i = 1; $i <= $jumlahHari; $i++)
                            <th class="date-head">{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarNama as $nama)
                    <tr>
                        <td class="name-cell">{{ $nama }}</td>
                        @for ($d = 1; $d <= $jumlahHari; $d++)
                            @php
                                $tgl = \Carbon\Carbon::createFromDate($year, $month, $d)->format('Y-m-d');
                                $userRow = \App\Models\User::where('name', $nama)->first();
                                $existing = $userRow ? $dataPiket->where('user_id', $userRow->id)->where('tanggal', $tgl)->first() : null;
                                $kodeAktif = $existing && $existing->shift ? $existing->shift->kode : 'OFF';

                                $class = match(strtoupper($kodeAktif)) {
                                    'M' => 'bg-m',
                                    'S' => 'bg-s',
                                    'P' => 'bg-p',
                                    default => 'bg-off',
                                };
                            @endphp

                            <td class="text-center">
                                <select class="shift-select {{ $class }}" 
                                        data-nama="{{ $nama }}" 
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                nama: $el.data('nama'),
                tanggal: $el.data('tanggal'),
                shift_kode: kode
            },
            success: function(res) {
                console.log("Tersimpan: " + res.message);
                $el.removeClass('loading-overlay');
            },
            error: function(xhr) {
                let pesan = "Terjadi kesalahan sistem";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    pesan = xhr.responseJSON.message;
                }
                alert("Gagal! Pesan Server: " + pesan);
                location.reload(); 
            }
        });
    }

    function downloadCapture() {
        const btn = event.currentTarget;
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
        btn.disabled = true;

        const captureElement = document.getElementById('capture-area');

        html2canvas(captureElement, {
            scale: 2, 
            useCORS: true,
            logging: false,
            backgroundColor: "#f8f9fa",
            // Memastikan lebar total tabel ikut terambil meski harus scroll horizontal
            width: captureElement.scrollWidth,
            windowWidth: captureElement.scrollWidth
        }).then(canvas => {
            const image = canvas.toDataURL("image/png");
            const link = document.createElement('a');
            link.download = `Jadwal_Piket_{{ $bulanSekarang }}_{{ $tahunSekarang }}.png`;
            link.href = image;
            link.click();
            
            btn.innerHTML = originalContent;
            btn.disabled = false;
        }).catch(err => {
            console.error(err);
            alert("Gagal melakukan capture gambar.");
            btn.innerHTML = originalContent;
            btn.disabled = false;
        });
    }
</script>
</body>
</html>