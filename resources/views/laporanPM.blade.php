<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan PM</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .form-control-lg,
        .form-select-lg {
            height: 54px;
            font-size: 16px;
        }

        .btn-success {
            background: #0c2484 !important;
            border: none !important;
            color: #fff !important;
            font-weight: 700;
        }

        .btn-success:hover {
            background: #0c2484 !important;
        }

        .btn-secondary {
            background: #0c2484 !important;
            border: none !important;
            font-weight: 700;
        }
    </style>
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

<div class="tabs-section">
    <a href="{{ route('datasite') }}" class="tab {{ request()->is('datasite*') ? 'active' : '' }}"
       style="text-decoration: none; color: Black;">All Sites</a>

    <a href="{{ url('/datapass') }}" class="tab {{ request()->is('datapass*') ? 'active' : '' }}"
       style="text-decoration: none; color: Black;">Management Password</a>

    <a href="{{ url('/laporanpm') }}" class="tab {{ request()->is('laporanpm*') ? 'active' : '' }}"
       style="text-decoration: none; color: White;">Laporan PM</a>

    <a href="{{ url('/PMLiberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}"
       style="text-decoration: none; color: Black;">PM Liberta</a>

    <a href="{{ url('/pm-summary') }}" class="tab {{ request()->is('pm-summary*') ? 'active' : '' }}"
       style="text-decoration: none; color: Black;">PM Summary</a>
</div>

<!-- CARD -->
<div class="card">
    <div class="card-header">
        <div class="actions">

            <!-- tombol plus -->
            <button type="button"
                    class="btn btn-light shadow-sm me-2"
                    data-bs-toggle="modal"
                    data-bs-target="#modalLaporanPM"
                    style="width:55px;height:55px;border-radius:12px;">
                <span style="font-size:22px;">+</span>
            </button>

            <button class="btn-action bi bi-upload" title="Upload"></button>
            <button class="btn-action bi bi-download" title="Download"></button>
        </div>

        <!-- search -->
        <form method="GET" action="{{ route('laporanpm') }}" class="search-form">
            <div class="search-box">
                <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                <button type="submit" class="search-btn">🔍</button>
            </div>
        </form>
    </div>

    <div style="overflow-x: auto; max-height: 600px; overflow-y: auto;">
        <table>
            <thead>
                <tr class="thead-dark">
                <th>NO</th>
                <th>TANGGAL SUBMIT</th>
                <th>SITE ID</th>
                <th>LOKASI SITE</th>
                <th>KABUPATEN / KOTA</th>
                <th>PROVINSI</th>
                <th>PM BULAN</th>
                <th>LAPORAN BA PM</th>
                <th>TEKNISI</th>
                <th>KENDALA</th>
                <th>ACTION</th>
                <th>KET. TAMBAHAN</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
            </thead>

            <tbody>
            @forelse($data as $item)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal_submit }}</td>
                    <td>{{ $item->site_id }}</td>
                    <td>{{ $item->lokasi_site ?? '-' }}</td>
                    <td>{{ $item->kabupaten_kota ?? '-' }}</td>
                    <td>{{ $item->provinsi ?? '-' }}</td>
                    <td>{{ $item->pm_bulan ?? '-' }}</td>
                    <td>{{ $item->laporan_ba_pm ?? '-' }}</td>
                    <td>{{ $item->teknisi ?? '-' }}</td>
                    <td>{{ $item->kendala ?? '-' }}</td>
                    <td>{{ $item->action ?? '-' }}</td>
                    <td>{{ $item->ket_tambahan ?? '-' }}</td>
                    <td>{{ $item->status ?? '-' }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="14" class="text-start p-3">
                        Showing 0 of 0 results
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ===================== MODAL TAMBAH LAPORAN PM ===================== -->
<div class="modal fade" id="modalLaporanPM" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4 border-0">

            <!-- Header -->
            <div class="modal-header border-0 px-4 pt-4">
                <h4 class="modal-title fw-bold">Tambah Data Laporan PM</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 pb-4">
                <form action="{{ route('laporanpm.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">

                        <!-- Tanggal -->
                        <div class="col-12">
                            <input type="date" name="tanggal_submit"
                                   class="form-control form-control-lg rounded-3" required>
                        </div>

                        <!-- Nama Site -->
                        <div class="col-12">
                            <select name="site_id" id="siteSelect"
                                    class="form-select form-select-lg rounded-3" required>
                                <option value="">Pilih atau cari Nama Site</option>

                                @foreach($sites as $s)
                                    <option value="{{ $s->site_id }}" data-siteid="{{ $s->site_id }}">
                                        {{ $s->site_name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Site ID auto -->
                        <div class="col-12">
                            <input type="text" id="siteIdView"
                                   class="form-control form-control-lg rounded-3 bg-light"
                                   placeholder="Site ID" readonly>
                        </div>

                        <!-- Bulan -->
                        <div class="col-12">
                            <select name="pm_bulan" class="form-select form-select-lg rounded-3" required>
                                <option value="">Select Month</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>

                        <!-- Teknisi -->
                        <div class="col-12">
                            <input type="text" name="teknisi"
                                   class="form-control form-control-lg rounded-3"
                                   placeholder="Teknisi" required>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <select name="status" class="form-select form-select-lg rounded-3" required>
                                <option value="">Select Status</option>
                                <option value="Done">Done</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-3 shadow-sm">
                            SIMPAN
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg px-5 rounded-3"
                                data-bs-dismiss="modal">
                            BATAL
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS (WAJIB biar modal jalan) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const siteSelect = document.getElementById("siteSelect");
        const siteIdView = document.getElementById("siteIdView");

        if (siteSelect && siteIdView) {
            siteSelect.addEventListener("change", function () {
                const selectedOption = siteSelect.options[siteSelect.selectedIndex];
                const siteId = selectedOption.getAttribute("data-siteid");
                siteIdView.value = siteId ? siteId : "";
            });
        }
    });
</script>

</body>
</html>