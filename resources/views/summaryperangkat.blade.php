<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Perangkat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/summaryperangkat.css') }}">

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
        <a href="{{ url('/logpergantian') }}" class="tab {{ request()->is('logpergantian*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Log Perangkat</a>
        <a href="{{ url('/spaetaracker') }}" class="tab {{ request()->is('sparetracker*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Spare Tracker</a>
        <a href="{{ url('/summary') }}" class="tab {{ request()->is('summary*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Summary</a>
    </div>

    <div class="summary-card">
        <div class="card-title-custom text-center">Stock Perangkat</div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">JENIS</th>
                        <th class="text-center">BAIK</th>
                        <th class="text-center">RUSAK</th>
                        <th class="text-center">BARU</th>
                        <th class="text-center">GRAND TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>ROUTER</td><td>7</td><td>3</td><td>0</td><td>10</td></tr>
                    <tr><td>ADAPTOR</td><td>0</td><td>0</td><td>5</td><td>5</td></tr>
                    <tr><td>POE AP</td><td>0</td><td>0</td><td>5</td><td>5</td></tr>
                    <tr><td>TRANCIEVER</td><td>0</td><td>3</td><td>4</td><td>7</td></tr>
                    <tr><td>STAVOLT</td><td>1</td><td>0</td><td>4</td><td>5</td></tr>
                    <tr><td>ACCESS POINT</td><td>0</td><td>0</td><td>1</td><td>1</td></tr>
                    <tr><td>MODEM</td><td>2</td><td>0</td><td>0</td><td>2</td></tr>
                    <tr class="row-grand-total">
                        <td>GRAND TOTAL</td><td>10</td><td>6</td><td>19</td><td>35</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="summary-card">
        <div class="card-title-custom text-center">Kondisi Perangkat - Rusak</div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">JENIS</th>
                        <th class="text-center">BAIK</th>
                        <th class="text-center">RUSAK</th>
                        <th class="text-center">BARU</th>
                        <th class="text-center">GRAND TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>ROUTER</td><td>7</td><td>3</td><td>0</td><td>10</td></tr>
                    <tr><td>ADAPTOR</td><td>0</td><td>0</td><td>5</td><td>5</td></tr>
                    <tr><td>POE AP</td><td>0</td><td>0</td><td>5</td><td>5</td></tr>
                    <tr><td>TRANCIEVER</td><td>0</td><td>3</td><td>4</td><td>7</td></tr>
                    <tr><td>STAVOLT</td><td>1</td><td>0</td><td>4</td><td>5</td></tr>
                    <tr><td>ACCESS POINT</td><td>0</td><td>0</td><td>1</td><td>1</td></tr>
                    <tr><td>MODEM</td><td>2</td><td>0</td><td>0</td><td>2</td></tr>
                    <tr class="row-grand-total">
                        <td>GRAND TOTAL</td><td>10</td><td>6</td><td>19</td><td>35</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>