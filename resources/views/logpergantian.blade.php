<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operasional</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
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
        <a href="{{ route('pergantianperangkat') }}" class="tab {{ request()->is('pergantianperangkat*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Pergantian Perangkat</a>
        <a href="{{ url('/logpergantian') }}" class="tab {{ request()->is('logpergantian*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Log Perangkat</a>
        <a href="{{ url('/sparetracker') }}" class="tab {{ request()->is('sparetracker*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Spare Tracker</a>
        <a href="{{ url('/summary') }}" class="tab {{ request()->is('summary*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Summary</a>
    </div>

    <!-- CARD -->
    <div class="card">
        <div class="card-header">
            <div class="actions">
                <button class="btn-action bi bi-plus" title="Add" id="addDataModall"></button>
                <button class="btn-action bi bi-upload" title="Upload"></button>
                <button class="btn-action bi bi-download" title="Download"></button>
            </div>

            <form method="GET" action="{{ route('datapas') }}" class="search-form">
                <div class="search-box">
                    <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                    <button type="submit" class="search-btn">🔍</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>SITE ID</th>
                        <th>SITE NAME</th>
                        <th>TIPE</th>
                        <th>BATCH</th>
                        <th>LATITUDE</th>
                        <th>LONGITUDE</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="9" class="empty text-center">
                            <!-- Empty State Content -->
                            Showing 0 of 0 results
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>