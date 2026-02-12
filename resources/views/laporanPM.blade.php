<!DOCTYPE html>
<html>
<head>
    <title>Laporan PM</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>

<div class="page">

    <!-- TOP BAR -->
    <div class="topbar">
        <div class="top-left">
            <span>Project</span>
            <span class="active">Operational</span>
        </div>
        <div class="profile"></div>
    </div>

    <!-- TABS -->
    <div class="tabs">
        <a href="{{ route('datasite') }}" class="tab {{ request()->is('datasite*') ? 'active' : '' }}" style="text-decoration: none; color: black;">All Sites</a>
        <a href="{{ url('/datapass') }}" class="tab {{ request()->is('datapass*') ? 'active' : '' }}" style="text-decoration: none; color: black;">Management Password</a>
        <a href="{{ url('/laporanpm') }}" class="tab {{ request()->is('laporanpm*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Laporan PM</a>
        <a href="{{ url('/PMLiberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}" style="text-decoration: none; color: black;">PM Liberta</a>
        <a href="{{ url('/pm-summary') }}" class="tab {{ request()->is('pm-summary*') ? 'active' : '' }}" style="text-decoration: none; color: black;">PM Summary</a>
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

        <table>
            <thead">
                <tr class="thead-dark">
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="9" class="empty text-center">
                        Showing 0 of 0 results
                    </td>
                </tr>
            </tbody>
        </table>

                </tr>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
