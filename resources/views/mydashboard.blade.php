<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUSTECH Monitoring Dashboard</title>
    <meta name="description" content="Real-Time Network & Site Operation Center Dashboard">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/mydashboard.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-bg-layer"></div>
        <div class="header-content-layer">
            <div class="logo-section">
                <div class="logo-text">
                    <h1>
                        <i> 📡 </i>
                        <span class="bold-title">NUSTECH</span>
                        <span class="regular-title">Monitoring Dashboard</span>

                    </h1>

                    <p>Real-Time Network & Site Operation Center</p>
                </div>
            </div>
        </div>
        <div class="header-clock">
            <span id="clock">00:00:00</span>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">

        <!-- Left Column -->
        <div class="left-column">

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="card stat-card blue-card">
                    <h3>Ticket<br>Today</h3>
                    <div class="divider"></div>
                    <span class="value">{{ $todayCount }}</span>
                </div>

                <div class="card stat-card blue-card">
                    <h3>All Open<br>Ticket</h3>
                    <div class="divider"></div>
                    <span class="value">{{ $totalOpen }}</span>
                </div>

                <!-- Card 3: PM BMN (White) -->
                <div class="card stat-card white-card">
                    <h3>PM BMN</h3>
                    <div class="divider"></div>
                    <div class="value-group">
                        <span class="value">{{ $pmBmnDone }}</span>
                        <span class="sub-value">/ {{ $pmBmnTotal }}</span>
                    </div>
                </div>

                <!-- Card 4: PM SL (White) -->
                <div class="card stat-card white-card">
                    <h3>PM SL</h3>
                    <div class="divider"></div>
                    <div class="value-group">
                        <span class="value">{{ $pmSlDone }}</span>
                        <span class="sub-value">/ {{ $pmSlTotal }}</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <div class="sidebar-menu">

                <!-- Menu Item 1: Piket Schedule (Expanded) -->
                <div class="card menu-item expanded">
                    <div class="menu-header">
                        <span class="menu-title">Piket Schedule</span>
                        <i class="ph-fill ph-caret-right arrow-icon"></i>

                    </div>
                    <div class="menu-content">
                        <div class="shift-info-bar">
                            <div class="shift-status">
                                <span>Shift On</span>
                            </div>
                            <div class="shift-time">
                                26 Jan 08:00 - 16:00 WITA
                            </div>
                        </div>
                        <div class="personnel-list">
                            <div class="personnel-badge">Hendra Hadi Pratama</div>
                            <div class="personnel-badge">Andri Pratama</div>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 2: Open Ticket Problem (Collapsed) -->
                <div class="card menu-item collapsed">
                    <div class="menu-header">
                        <span class="menu-title">Open Ticket Problem</span>
                        <i class="ph-fill ph-caret-right arrow-icon"></i>
                    </div>

                    <div class="menu-content ticket-content">
                        <div class="ticket-list">
                            @forelse($sidebarTickets as $problem => $items)
                                <div class="ticket-group" style="margin-bottom: 10px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 5px;">
                                    <div class="ticket-row" style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-weight: 600; color: #333; font-size: 0.9rem;">{{ strtoupper($problem ?? 'N/A') }}</span>
                                        <a href="javascript:void(0)" class="toggle-site" style="font-size: 0.8rem; text-decoration: none; color: #007bff;">Lihat Site ({{ $items->count() }})</a>
                                    </div>
                                    
                                    {{-- Container Detail Site --}}
                                    <div class="site-detail-container" style="display: none; padding: 8px 10px; background: rgba(0,0,0,0.03); border-radius: 6px; margin-top: 5px;">
                                        <ul style="list-style: none; padding: 0; margin: 0;">
                                            @foreach($items as $ticket)
                                                <li style="padding: 4px 0; color: #2c3e50; font-size: 0.8rem; display: flex; align-items: center; border-bottom: 1px solid rgba(0,0,0,0.03);">
                                                    <i class="ph ph-caret-right" style="margin-right: 5px; color: #4facfe;"></i>
                                                    {{ $ticket->nama_site }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <p style="padding: 10px; color: #999; text-align: center; font-size: 0.85rem;">No open problems</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Menu Item 3: Sparepart Needed (Collapsed) -->
                <div class="card menu-item collapsed">
                    <div class="menu-header">
                        <span class="menu-title">Sparepart Needed</span>
                        <i class="ph-fill ph-caret-right arrow-icon"></i>
                    </div>

                    <div class="menu-content">
                        <p style="">Belum ada sparepart</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">

            <!-- Ticket Table -->
            <div class="card table-card">
                <h2 class="card-title">Open Ticket List</h2>
                <div class="table-wrapper no-scrollbar">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 35%">Site Name</th>
                                <th style="width: 23%">Site ID</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 15%">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                            <tr>
                                <td class="text-center">{{ ($tickets->currentPage() - 1) * $tickets->perPage() + $loop->iteration }}</td>
                                <td>{{ $ticket->nama_site }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="site-detail-link" data-id="{{ $ticket->site_code }}" style="color: #007bff; text-decoration: none; font-weight: bold;">
                                        {{ $ticket->site_code }}
                                    </a>
                                </td>
                                <td class="text-center">{{ strtoupper($ticket->status) }}</td>
                                <td class="text-center">
                                    {{ floor(\Carbon\Carbon::parse($ticket->tanggal_rekap)->diffInDays(now())) }} Hari
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada tiket terbuka saat ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination-wrapper">
                    {{ $tickets->links() }}
                </div>
            </div>

            <!-- Chat Widget -->
            <div class="card chat-card">
                <div class="chat-header">
                    <h2 class="card-title">Live Chat</h2>
                </div>

                <div class="chat-area no-scrollbar">
                    <!-- Date Divider -->
                    <div class="date-divider">
                        <div class="line"></div>
                        <span>Yesterday</span>
                        <div class="line"></div>
                    </div>

                    <!-- Admin Message -->
                    <div class="message-group admin">
                        <span class="sender-name">Administrator</span>
                        <div class="message-bubble">
                            <p>Halo!<br>Rorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero
                                et
                                velit
                                interdum, ac aliquet odio mattis. Class aptent taciti sociosqu .</p>
                        </div>
                    </div>

                    <!-- Date Divider -->
                    <div class="date-divider">
                        <div class="line"></div>
                        <span>Today</span>
                        <div class="line"></div>
                    </div>

                    <!-- Client Message -->
                    <div class="message-group client">
                        <span class="sender-name">Client One</span>
                        <div class="message-bubble">
                            <p>Hola, selamat siang, Pak.</p>
                        </div>
                        <div class="message-bubble">
                            <p>Corem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et
                                velit
                                interdum, ac aliquet odio mattis. Class .</p>
                        </div>
                    </div>
                </div>

                <div class="chat-input-area">
                    <input type="text" placeholder="Type Something . . .">
                    <button class="send-btn">
                        <i class="ph-fill ph-paper-plane-right"></i>
                    </button>
                </div>
            </div>

        </div>
        <div id="siteModal" class="custom-modal" style="display:none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="modalTitle">Detail Tiket</h2>
                    <span class="close-modal">&times;</span>
                </div>
                <div class="modal-body">
            <div class="modal-detail-wrapper">
                <div class="detail-info-list">
                    <div class="detail-row"><span>Site ID</span> : <span id="m-site-id"></span></div>
                    <div class="detail-row"><span>Kategori</span> : <span id="m-kategori"></span></div>
                    <div class="detail-row"><span>Provinsi</span> : <span id="m-provinsi"></span></div>
                    <div class="detail-row"><span>Kabupaten</span> : <span id="m-kabupaten"></span></div>
                    <div class="detail-row"><span>Sumber Listrik</span> : <span id="m-listrik"></span></div>
                    <div class="detail-row"><span>Durasi</span> : <span id="m-durasi"></span></div>
                    <div class="detail-row"><span>Detail Problem</span> : <span id="m-problem"></span></div>
                    <div class="detail-row"><span>CE</span> : <span id="m-ce"></span></div>
                </div>

                <div class="map-container-small">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
/* 1. Kontainer Luar Modal (Overlay) */
.custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); /* Background gelap transparan */
    z-index: 9999;
    display: none; /* Diatur jadi 'flex' via JavaScript */
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px); /* Efek blur kekinian */
}

/* 2. Kotak Putih Modal */
.modal-content {
    background: #fff;
    width: 90%;
    max-width: 800px;
    padding: 25px;
    border-radius: 15px;
    position: relative;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    animation: modalFadeIn 0.3s ease-out;
}

@keyframes modalFadeIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* 3. Tombol Close */
.close-modal {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 28px;
    font-weight: bold;
    color: #999;
    cursor: pointer;
    transition: 0.2s;
}

.close-modal:hover {
    color: #ff4d4d;
}

/* 4. Header & Detail (Kode Anda yang sudah difix) */
.modal-header {
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
    margin-bottom: 20px;
}

.modal-header h2 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #333;
    text-transform: uppercase;
    margin: 0;
}

.modal-detail-wrapper {
    display: flex;
    gap: 20px;
    min-height: 250px;
}

.detail-info-list {
    flex: 1;
}

.detail-row {
    display: flex;
    margin-bottom: 10px;
    font-size: 0.9rem;
    color: #444;
}

.detail-row span:first-child {
    width: 130px; 
    font-weight: 600;
    color: #2c3e50;
    flex-shrink: 0;
}

/* 5. Map */
.map-container-small {
    width: 250px; /* Sedikit lebih lebar agar jelas */
    height: 180px;
    align-self: flex-end;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #ddd;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

#map {
    width: 100%;
    height: 100%;
}

/* Responsif HP */
@media (max-width: 600px) {
    .modal-detail-wrapper {
        flex-direction: column;
    }
    .map-container-small {
        width: 100%;
        height: 200px;
        margin-top: 10px;
    }
}
</style>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="line"></div>
            <p>@2026 NUSTECH. All right reserved.</p>
            <div class="line"></div>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="script.js"></script>
<script>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUSTECH Monitoring Dashboard</title>
    <meta name="description" content="Real-Time Network & Site Operation Center Dashboard">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/mydashboard.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-bg-layer"></div>
        <div class="header-content-layer">
            <div class="logo-section">
                <div class="logo-text">
                    <h1>
                        <i> 📡 </i>
                        <span class="bold-title">NUSTECH</span>
                        <span class="regular-title">Monitoring Dashboard</span>

                    </h1>

                    <p>Real-Time Network & Site Operation Center</p>
                </div>
            </div>
        </div>
        <div class="header-clock">
            <span id="clock">00:00:00</span>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">

        <!-- Left Column -->
        <div class="left-column">

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="card stat-card blue-card">
                    <h3>Ticket<br>Today</h3>
                    <div class="divider"></div>
                    <span class="value">{{ $todayCount }}</span>
                </div>

                <div class="card stat-card blue-card">
                    <h3>All Open<br>Ticket</h3>
                    <div class="divider"></div>
                    <span class="value">{{ $totalOpen }}</span>
                </div>

                <!-- Card 3: PM BMN (White) -->
                <div class="card stat-card white-card">
                    <h3>PM BMN</h3>
                    <div class="divider"></div>
                    <div class="value-group">
                        <span class="value">{{ $pmBmnDone }}</span>
                        <span class="sub-value">/ {{ $pmBmnTotal }}</span>
                    </div>
                </div>

                <!-- Card 4: PM SL (White) -->
                <div class="card stat-card white-card">
                    <h3>PM SL</h3>
                    <div class="divider"></div>
                    <div class="value-group">
                        <span class="value">{{ $pmSlDone }}</span>
                        <span class="sub-value">/ {{ $pmSlTotal }}</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <div class="sidebar-menu">

                <!-- Menu Item 1: Piket Schedule (Expanded) -->
                <div class="card menu-item expanded">
                    <div class="menu-header">
                        <span class="menu-title">Piket Schedule</span>
                        <i class="ph-fill ph-caret-right arrow-icon"></i>

                    </div>
                    <div class="menu-content">
                        <div class="shift-info-bar">
                            <div class="shift-status">
                                <span>Shift On</span>
                            </div>
                            <div class="shift-time">
                                26 Jan 08:00 - 16:00 WITA
                            </div>
                        </div>
                        <div class="personnel-list">
                            <div class="personnel-badge">Hendra Hadi Pratama</div>
                            <div class="personnel-badge">Andri Pratama</div>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 2: Open Ticket Problem (Collapsed) -->
                <div class="card menu-item collapsed">
                    <div class="menu-header">
                        <span class="menu-title">Open Ticket Problem</span>
                        <i class="ph-fill ph-caret-right arrow-icon"></i>
                    </div>

                    <div class="menu-content ticket-content">
                        <div class="ticket-list">
                            @forelse($sidebarTickets as $problem => $items)
                                <div class="ticket-group" style="margin-bottom: 10px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 5px;">
                                    <div class="ticket-row" style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-weight: 600; color: #333; font-size: 0.9rem;">{{ strtoupper($problem ?? 'N/A') }}</span>
                                        <a href="javascript:void(0)" class="toggle-site" style="font-size: 0.8rem; text-decoration: none; color: #007bff;">Lihat Site ({{ $items->count() }})</a>
                                    </div>
                                    
                                    {{-- Container Detail Site --}}
                                    <div class="site-detail-container" style="display: none; padding: 8px 10px; background: rgba(0,0,0,0.03); border-radius: 6px; margin-top: 5px;">
                                        <ul style="list-style: none; padding: 0; margin: 0;">
                                            @foreach($items as $ticket)
                                                <li style="padding: 4px 0; color: #2c3e50; font-size: 0.8rem; display: flex; align-items: center; border-bottom: 1px solid rgba(0,0,0,0.03);">
                                                    <i class="ph ph-caret-right" style="margin-right: 5px; color: #4facfe;"></i>
                                                    {{ $ticket->nama_site }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <p style="padding: 10px; color: #999; text-align: center; font-size: 0.85rem;">No open problems</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Menu Item 3: Sparepart Needed (Collapsed) -->
                <div class="card menu-item collapsed">
                    <div class="menu-header">
                        <span class="menu-title">Sparepart Needed</span>
                        <i class="ph-fill ph-caret-right arrow-icon"></i>
                    </div>

                    <div class="menu-content">
                        <p style="">Belum ada sparepart</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">

            <!-- Ticket Table -->
            <div class="card table-card">
                <h2 class="card-title">Open Ticket List</h2>
                <div class="table-wrapper no-scrollbar">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 35%">Site Name</th>
                                <th style="width: 23%">Site ID</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 15%">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                            <tr>
                                <td class="text-center">{{ ($tickets->currentPage() - 1) * $tickets->perPage() + $loop->iteration }}</td>
                                <td>{{ $ticket->nama_site }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="site-detail-link" data-id="{{ $ticket->site_code }}" style="color: Black; text-decoration: none;">
                                        {{ $ticket->site_code }}
                                    </a>
                                </td>
                                <td class="text-center">{{ strtoupper($ticket->status) }}</td>
                                <td class="text-center">
                                    {{ floor(\Carbon\Carbon::parse($ticket->tanggal_rekap)->diffInDays(now())) }} Hari
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada tiket terbuka saat ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination-wrapper">
                    {{ $tickets->links() }}
                </div>
            </div>

            <!-- Chat Widget -->
            <div class="card chat-card">
                <div class="chat-header">
                    <h2 class="card-title">Live Chat</h2>
                </div>

                <div class="chat-area no-scrollbar">
                    <!-- Date Divider -->
                    <div class="date-divider">
                        <div class="line"></div>
                        <span>Yesterday</span>
                        <div class="line"></div>
                    </div>

                    <!-- Admin Message -->
                    <div class="message-group admin">
                        <span class="sender-name">Administrator</span>
                        <div class="message-bubble">
                            <p>Halo!<br>Rorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero
                                et
                                velit
                                interdum, ac aliquet odio mattis. Class aptent taciti sociosqu .</p>
                        </div>
                    </div>

                    <!-- Date Divider -->
                    <div class="date-divider">
                        <div class="line"></div>
                        <span>Today</span>
                        <div class="line"></div>
                    </div>

                    <!-- Client Message -->
                    <div class="message-group client">
                        <span class="sender-name">Client One</span>
                        <div class="message-bubble">
                            <p>Hola, selamat siang, Pak.</p>
                        </div>
                        <div class="message-bubble">
                            <p>Corem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et
                                velit
                                interdum, ac aliquet odio mattis. Class .</p>
                        </div>
                    </div>
                </div>

                <div class="chat-input-area">
                    <input type="text" placeholder="Type Something . . .">
                    <button class="send-btn">
                        <i class="ph-fill ph-paper-plane-right"></i>
                    </button>
                </div>
            </div>

        </div>
        <div id="siteModal" class="custom-modal" style="display:none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="modalTitle">Detail Tiket</h2>
                    <span class="close-modal">&times;</span>
                </div>
                <div class="modal-body">
            <div class="modal-detail-wrapper">
                <div class="detail-info-list">
                    <div class="detail-row"><span>Site ID</span> : <span id="m-site-id"></span></div>
                    <div class="detail-row"><span>Kategori</span> : <span id="m-kategori"></span></div>
                    <div class="detail-row"><span>Provinsi</span> : <span id="m-provinsi"></span></div>
                    <div class="detail-row"><span>Kabupaten</span> : <span id="m-kabupaten"></span></div>
                    <div class="detail-row"><span>Sumber Listrik</span> : <span id="m-listrik"></span></div>
                    <div class="detail-row"><span>Durasi</span> : <span id="m-durasi"></span></div>
                    <div class="detail-row"><span>Detail Problem</span> : <span id="m-problem"></span></div>
                    <div class="detail-row"><span>CE</span> : <span id="m-ce"></span></div>
                </div>

                <div class="map-container-small">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
/* 1. Kontainer Luar Modal (Overlay) */
.custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); /* Background gelap transparan */
    z-index: 9999;
    display: none; /* Diatur jadi 'flex' via JavaScript */
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px); /* Efek blur kekinian */
}

/* 2. Kotak Putih Modal */
.modal-content {
    background: #fff;
    width: 90%;
    max-width: 800px;
    padding: 25px;
    border-radius: 15px;
    position: relative;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    animation: modalFadeIn 0.3s ease-out;
}

@keyframes modalFadeIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* 3. Tombol Close */
.modal-header {
    display: flex;
    justify-content: center; /* Mengetengahkan konten secara horizontal */
    align-items: center;
    position: relative;      /* Menjadi acuan untuk posisi tombol close */
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
    margin-bottom: 20px;
}

/* Update Judul H2 */
.modal-header h2 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #333;
    text-transform: uppercase;
    margin: 0;
    text-align: center; /* Memastikan teks di dalam h2 berada di tengah */
}

/* Update Tombol Close agar tetap di pojok kanan */
.close-modal {
    position: absolute; /* Tombol melayang, tidak memakan space baris judul */
    top: 50%;
    right: 20px;
    transform: translateY(-50%); /* Menyelaraskan posisi vertikal tombol close */
    font-size: 28px;
    font-weight: bold;
    color: #999;
    cursor: pointer;
    transition: 0.2s;
    line-height: 1; /* Mencegah tombol close menggeser tinggi header */
}

.modal-detail-wrapper {
    display: flex;
    gap: 20px;
    min-height: 250px;
}

.detail-info-list {
    flex: 1;
}

.detail-row {
    display: flex;
    margin-bottom: 10px;
    font-size: 0.9rem;
    color: #444;
}

.detail-row span:first-child {
    width: 130px; 
    font-weight: 600;
    color: #2c3e50;
    flex-shrink: 0;
}

/* 5. Map */
.map-container-small {
    width: 250px; /* Sedikit lebih lebar agar jelas */
    height: 180px;
    align-self: flex-end;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #ddd;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

#map {
    width: 100%;
    height: 100%;
}

/* Responsif HP */
@media (max-width: 600px) {
    .modal-detail-wrapper {
        flex-direction: column;
    }
    .map-container-small {
        width: 100%;
        height: 200px;
        margin-top: 10px;
    }
}
</style>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="line"></div>
            <p>@2026 NUSTECH. All right reserved.</p>
            <div class="line"></div>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="script.js"></script>
<script>
let map; 

document.querySelectorAll('.site-detail-link').forEach(link => {
    link.addEventListener('click', function() {
        const siteId = this.getAttribute('data-id');
        
        fetch(`/ticket/detail/${siteId}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                // --- STEP 1: MUNCULKAN MODAL DULU (PENTING) ---
                const modal = document.getElementById('siteModal');
                modal.style.display = 'flex';

                // --- STEP 2: ISI DATA ---
                document.getElementById('modalTitle').innerText = `Detail Tiket - ${data.nama_site}`;
                document.getElementById('m-site-id').innerText = data.site_id || '-';
                document.getElementById('m-kategori').innerText = data.kategori || '-';
                document.getElementById('m-provinsi').innerText = data.provinsi || '-';
                document.getElementById('m-kabupaten').innerText = data.kabupaten || '-';
                document.getElementById('m-listrik').innerText = data.sumber_listrik || '-';
                
                // Pastikan durasi diparse dengan aman
                const durasiRaw = parseFloat(data.durasi) || 0;
                document.getElementById('m-durasi').innerText = `${Math.floor(durasiRaw)} Hari`;
                
                document.getElementById('m-problem').innerText = data.detail_problem || '-';
                document.getElementById('m-ce').innerText = data.ce || '-';

                // --- STEP 3: LOGIKA PETA ---
                setTimeout(() => {
                    // Hapus map lama jika ada
                    if (map) {
                        map.remove();
                        map = null;
                    }

                    // Parse koordinat
                    const lat = parseFloat(data.latitude);
                    const lng = parseFloat(data.longitude);

                    // Cek apakah koordinat valid (bukan 0 atau NaN)
                    if (!isNaN(lat) && !isNaN(lng) && lat !== 0) {
                        map = L.map('map').setView([lat, lng], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap'
                        }).addTo(map);
                        L.marker([lat, lng]).addTo(map);
                        
                        // Maksa peta menyesuaikan ukuran kotak modal yang sudah terbuka
                        map.invalidateSize();
                    } else {
                        document.getElementById('map').innerHTML = 
                            '<div style="display:flex;justify-content:center;align-items:center;height:100%;color:#888;font-size:0.8rem;">Koordinat tidak ditemukan</div>';
                    }
                }, 500); 
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengambil data detail site.');
            });
    });
});

// Logic Close tetap sama
document.querySelector('.close-modal').onclick = () => {
    document.getElementById('siteModal').style.display = 'none';
};

window.onclick = (event) => {
    const modal = document.getElementById('siteModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
};
</script>

{{-- Script untuk Real-time Clock dan Toggle Menu --}}
<script>
    
// Real-time Clock
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-GB', { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit' 
    });
    document.getElementById('clock').innerText = timeString;
}

setInterval(updateClock, 1000);
updateClock(); // Initial call

const menuItems = document.querySelectorAll(".menu-item");

menuItems.forEach(item => {
    const header = item.querySelector(".menu-header");

    header.addEventListener("click", () => {

        if (item.classList.contains("expanded")) {
            item.classList.remove("expanded");
            item.classList.add("collapsed");
        } else {

            // Tutup semua
            menuItems.forEach(i => {
                i.classList.remove("expanded");
                i.classList.add("collapsed");
            });

            // Buka yang diklik
            item.classList.remove("collapsed");
            item.classList.add("expanded");
        }
    });
});

</script>
{{-- Script untuk Toggle Detail Site di Sidebar --}}
<script>
document.querySelectorAll('.toggle-site').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Mencegah card utama ikut collapse/expand

        const group = this.closest('.ticket-group');
        const detail = group.querySelector('.site-detail-container');
        const count = group.querySelectorAll('li').length;

        if (detail.style.display === "none" || detail.style.display === "") {
            detail.style.display = "block";
            this.innerText = `Tutup Site (${count})`;
            this.style.color = "#d9534f"; // Warna merah saat terbuka
        } else {
            detail.style.display = "none";
            this.innerText = `Lihat Site (${count})`;
            this.style.color = "#007bff"; // Kembali ke warna biru asal
        }
    });
});
</script>
</body>

</html>

{{-- Script untuk Real-time Clock dan Toggle Menu --}}
<script>
    
// Real-time Clock
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-GB', { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit' 
    });
    document.getElementById('clock').innerText = timeString;
}

setInterval(updateClock, 1000);
updateClock(); // Initial call

const menuItems = document.querySelectorAll(".menu-item");

menuItems.forEach(item => {
    const header = item.querySelector(".menu-header");

    header.addEventListener("click", () => {

        if (item.classList.contains("expanded")) {
            item.classList.remove("expanded");
            item.classList.add("collapsed");
        } else {

            // Tutup semua
            menuItems.forEach(i => {
                i.classList.remove("expanded");
                i.classList.add("collapsed");
            });

            // Buka yang diklik
            item.classList.remove("collapsed");
            item.classList.add("expanded");
        }
    });
});

</script>
{{-- Script untuk Toggle Detail Site di Sidebar --}}
<script>
document.querySelectorAll('.toggle-site').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Mencegah card utama ikut collapse/expand

        const group = this.closest('.ticket-group');
        const detail = group.querySelector('.site-detail-container');
        const count = group.querySelectorAll('li').length;

        if (detail.style.display === "none" || detail.style.display === "") {
            detail.style.display = "block";
            this.innerText = `Tutup Site (${count})`;
            this.style.color = "#d9534f"; // Warna merah saat terbuka
        } else {
            detail.style.display = "none";
            this.innerText = `Lihat Site (${count})`;
            this.style.color = "#007bff"; // Kembali ke warna biru asal
        }
    });
});
</script>
</body>

</html>