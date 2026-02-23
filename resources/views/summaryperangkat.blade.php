<!DOCTYPE html>
<html lang="id">
<head>
    @include('components.nav-modal-structure')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Perangkat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/summaryperangkat.css') }}">

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
        <a href="{{ route('pergantianperangkat') }}" class="tab {{ request()->is('pergantianperangkat*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Pergantian Perangkat</a>
        <a href="{{ url('/logpergantian') }}" class="tab {{ request()->is('logpergantian*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Log Perangkat</a>
        <a href="{{ url('/sparetracker') }}" class="tab {{ request()->is('sparetracker*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Spare Tracker</a>
        <a href="{{ url('/pm-summary') }}" class="tab {{ request()->is('pm-summary*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Summary</a>
        
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