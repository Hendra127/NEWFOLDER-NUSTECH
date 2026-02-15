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
                <!-- Card 1: Ticket Today (Blue) -->
                <div class="card stat-card blue-card">
                    <h3>Ticket<br>Today</h3>
                    <div class="divider"></div>
                    <span class="value">2</span>
                </div>

                <!-- Card 2: All Open Ticket (Blue) -->
                <div class="card stat-card blue-card">
                    <h3>All Open<br>Ticket</h3>
                    <div class="divider"></div>
                    <span class="value">20</span>
                </div>

                <!-- Card 3: PM BMN (White) -->
                <div class="card stat-card white-card">
                    <h3>PM BMN</h3>
                    <div class="divider"></div>
                    <div class="value-group">
                        <span class="value">237</span>
                        <span class="sub-value">/ 237</span>
                    </div>
                </div>

                <!-- Card 4: PM SL (White) -->
                <div class="card stat-card white-card">
                    <h3>PM SL</h3>
                    <div class="divider"></div>
                    <div class="value-group">
                        <span class="value">121</span>
                        <span class="sub-value">/ 121</span>
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
                            <div class="ticket-row">
                                <span>ACCESS POINT</span>
                                <a href="#">Lihat Site (3)</a>
                            </div>
                            <div class="ticket-row">
                                <span>ALOHA</span>
                                <a href="#">Lihat Site (1)</a>
                            </div>
                            <div class="ticket-row">
                                <span>KOORDINASI</span>
                                <a href="#">Lihat Site (2)</a>
                            </div>
                            <div class="ticket-row">
                                <span>ACCESS POINT</span>
                                <a href="#">Lihat Site (3)</a>
                            </div>
                            <div class="ticket-row">
                                <span>ACCESS POINT</span>
                                <a href="#">Lihat Site (3)</a>
                            </div>
                            <div class="ticket-row">
                                <span>ACCESS POINT</span>
                                <a href="#">Lihat Site (3)</a>
                            </div>
                            <div class="ticket-row">
                                <span>ACCESS POINT</span>
                                <a href="#">Lihat Site (3)</a>
                            </div>
                            <div class="ticket-row">
                                <span>ACCESS POINT</span>
                                <a href="#">Lihat Site (3)</a>
                            </div>

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
                                <th style="width: 35%">Site Name</th>
                                <th style="width: 30%">Site ID</th>
                                <th style="width: 15%">Status</th>
                                <th style="width: 20%">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>KANTOR DESA SEPALA DALUNG</td>
                                <td class="text-center">AO16224706516504N</td>
                                <td class="text-center">OPEN</td>
                                <td class="text-center">74 Hari</td>
                            </tr>
                            <tr>
                                <td>KANTOR DESA TENGKU DACING</td>
                                <td class="text-center">AO16224706516504N</td>
                                <td class="text-center">OPEN</td>
                                <td class="text-center">74 Hari</td>
                            </tr>
                            <tr>
                                <td>SD NEGERI 005 LUMBIS</td>
                                <td class="text-center">AO16224706516504N</td>
                                <td class="text-center">OPEN</td>
                                <td class="text-center">30 Hari</td>
                            </tr>
                            <tr>
                                <td>KANTOR DESA BEBATU</td>
                                <td class="text-center">AO16224706516504N</td>
                                <td class="text-center">OPEN</td>
                                <td class="text-center">11 Hari</td>
                            </tr>
                            <tr>
                                <td>KANTOR KEPALA DESA LUNUG</td>
                                <td class="text-center">AO16224706516504N</td>
                                <td class="text-center">OPEN</td>
                                <td class="text-center">11 Hari</td>
                            </tr>
                            <tr>
                                <td>SMA NEGERI 14 MALINAU</td>
                                <td class="text-center">AO16224706516504N</td>
                                <td class="text-center">OPEN</td>
                                <td class="text-center">5 Hari</td>
                            </tr>
                            <tr>
                                <td>SEKTOR LONG PUJUNGAN</td>
                                <td class="text-center">AO16224706516504N</td>
                                <td class="text-center">OPEN</td>
                                <td class="text-center">5 Hari</td>
                            </tr>
                            <tr>
                                <td>BANDAR UDARA PERINTIS</td>
                                <td class="text-center">AO16224706516504N</td>
                                <td class="text-center">OPEN</td>
                                <td class="text-center">5 Hari</td>
                            </tr>
                            <tr>
                                <td>POS TNI AU KRAYAN</td>
                                <td class="text-center">AO16224706516504N</td>
                                <td class="text-center">OPEN</td>
                                <td class="text-center">4 Hari</td>
                            </tr>
                            <tr>
                                <td>SD AL-MUJTAHIDIN KOTA SORONG</td>
                                <td class="text-center">AO16224706516504N</td>
                                <td class="text-center">OPEN</td>
                                <td class="text-center">4 Hari</td>
                            </tr>
                        </tbody>
                    </table>
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

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="line"></div>
            <p>@2026 NUSTECH. All right reserved.</p>
            <div class="line"></div>
        </div>
    </footer>


    <script src="script.js"></script>
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
</body>

</html>