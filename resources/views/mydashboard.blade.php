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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <div class="card stat-card blue-card clickable-card" data-type="today" style="cursor: pointer;">
                    <div class="card-inner">
                        <div class="label-side"><span class="label-text">Ticket<br>Today</span></div>
                        <div class="vertical-divider"></div>
                        <div class="value-side"><span class="value">{{ $todayCount }}</span></div>
                    </div>
                </div>

                <div class="card stat-card blue-card clickable-card" data-type="all_open" style="cursor: pointer;">
                    <div class="card-inner">
                        <div class="label-side"><span class="label-text">All Open<br>Ticket</span></div>
                        <div class="vertical-divider"></div>
                        <div class="value-side"><span class="value">{{ $totalOpen }}</span></div>
                    </div>
                </div>

                <div class="card stat-card white-card clickable-card" data-type="pm_bmn" style="cursor: pointer;">
                    <div class="card-inner">
                        <div class="label-side"><span class="label-text">PM<br>BMN<br>Done</span></div>
                        <div class="vertical-divider"></div>
                        <div class="value-side">
                            <div class="value-group">
                                <span class="value">{{ $pmBmnDone }}</span>
                                <span class="sub-value">/ {{ $pmBmnTotal }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card stat-card white-card clickable-card" data-type="pm_sl" style="cursor: pointer;">
                    <div class="card-inner">
                        <div class="label-side"><span class="label-text">PM<br>SL<br>Done</span></div>
                        <div class="vertical-divider"></div>
                        <div class="value-side">
                            <div class="value-group">
                                <span class="value">{{ $pmSlDone }}</span>
                                <span class="sub-value">/ {{ $pmSlTotal }}</span>
                            </div>
                        </div>
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
                                    <a href="javascript:void(0)" 
                                    class="site-detail-link" 
                                    data-id="{{ $ticket->site_code }}" 
                                    style="color: #000000; text-decoration: none; font-weight: normal;">
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

                <div class="chat-area no-scrollbar" id="chatbox" style="height: 400px; overflow-y: auto; padding: 15px; display: flex; flex-direction: column;"></div>

                <div class="chat-footer" style="padding: 10px; border-top: 1px solid #eee;">
                    <div id="replyPreview" class="hidden" style="background: #f0f0f0; padding: 8px; border-radius: 8px; margin-bottom: 8px; font-size: 12px; display: none; justify-content: space-between; align-items: center; border-left: 4px solid #007bff;">
                        <div>
                            <span style="font-weight: bold; color: #007bff;">Membalas:</span> 
                            <span id="replyText" style="color: #555;"></span>
                        </div>
                        <button onclick="cancelReply()" style="color: #ff4d4d; font-weight: bold; border: none; background: none; cursor: pointer;">✕</button>
                    </div>

                    <div class="chat-input-area" style="display: flex; gap: 8px;">
                        <input type="text" id="chatInput" placeholder="Type Something . . ." style="flex: 1; padding: 8px 15px; border-radius: 20px; border: 1px solid #ddd; outline: none;">
                        <button class="send-btn" onclick="sendMessage()" style="background: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 50%; cursor: pointer;">
                            <i class="ph-fill ph-paper-plane-right"></i>
                        </button>
                    </div>
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
    function getGuestName() {
        // Jika sudah login, tidak perlu nama guest
        if (@json(auth()->check())) return null;

        let name = localStorage.getItem('chat_guest_name');
        
        while (!name || name.trim() === "") {
            name = prompt("Silakan masukkan nama Anda untuk memulai chat:");
            if (name) {
                name = name.trim();
                localStorage.setItem('chat_guest_name', name);
            }
        }
        return name;
    }
let selectedReplyId = null;

// 1. Fungsi untuk mengatur balasan
function setReply(id, text, name, isAdmin = false) { // Tambah parameter isAdmin
    selectedReplyId = id;
    const preview = document.getElementById('replyPreview');
    const replyText = document.getElementById('replyText');
    
    // Tambahkan label ADMIN di preview jika perlu
    const adminLabel = isAdmin ? ' (ADMIN)' : '';
    replyText.innerText = `${name}${adminLabel}: ${text.substring(0, 35)}${text.length > 35 ? '...' : ''}`;
    
    preview.style.display = 'flex';
    document.getElementById('chatInput').focus();
}
// 2. Fungsi membatalkan balasan
function cancelReply() {
    selectedReplyId = null;
    document.getElementById('replyPreview').style.display = 'none';
}

/// 3. Fungsi Ambil Pesan (Load)
function loadMessages() {
    fetch("{{ route('chat.fetch') }}")
        .then(res => res.json())
        .then(data => {
            const chatbox = document.getElementById('chatbox');
            const currentUserId = @json(auth()->id()); 
            
            chatbox.innerHTML = "";
            let lastDate = null; // Penanda tanggal untuk membuat garis pemisah

            data.forEach(msg => {
                // --- 1. LOGIKA PEMISAH TANGGAL ---
                const dateObj = new Date(msg.created_at);
                const msgDate = dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });
                
                const today = new Date().toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });

                const yesterday = new Date();
                yesterday.setDate(yesterday.getDate() - 1);
                const yesterdayStr = yesterday.toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });

                // Jika tanggal pesan berbeda dengan pesan sebelumnya, munculkan garis
                if (msgDate !== lastDate) {
                    let label = msgDate;
                    if (msgDate === today) label = "Hari Ini";
                    else if (msgDate === yesterdayStr) label = "Kemarin";

                    chatbox.innerHTML += `
                        <div style="display: flex; align-items: center; margin: 20px 0; opacity: 0.8;">
                            <div style="flex: 1; height: 1px; background: linear-gradient(to right, transparent, #ddd);"></div>
                            <div style="padding: 0 15px; font-size: 11px; font-weight: bold; color: #888; text-transform: uppercase; letter-spacing: 1px;">${label}</div>
                            <div style="flex: 1; height: 1px; background: linear-gradient(to left, transparent, #ddd);"></div>
                        </div>
                    `;
                    lastDate = msgDate;
                }

                // --- 2. LOGIKA BUBBLE CHAT ---
                // --- 2. LOGIKA BUBBLE CHAT ---
const isMe = msg.is_me;

// Deteksi Admin: Cek properti is_sender_admin ATAU is_admin dari database
// Kita gunakan == 1 untuk mengantisipasi jika database mengirim string "1"
const isAdmin = (msg.user && (msg.user.is_admin == 1 || msg.user.is_admin === true)) || (msg.is_admin == 1);

// Template balasan (Parent)
const replyTemplate = msg.parent ? `
    <div style="background: rgba(0,0,0,0.05); padding: 5px 8px; border-radius: 5px; margin-bottom: 5px; border-left: 3px solid #007bff; font-size: 11px;">
        <strong style="display: block;">
            ${msg.parent.user ? msg.parent.user.name : (msg.parent.guest_name || 'Guest')}
            ${msg.parent.is_admin == 1 ? ' <span style="color: #d9534f;">(ADMIN)</span>' : ''}
        </strong>
        <span style="color: #666;">${msg.parent.message.substring(0, 30)}...</span>
    </div>
` : '';

const msgHtml = `
    <div style="display: flex; justify-content: ${isMe ? 'flex-end' : 'flex-start'}; margin-bottom: 15px;">
        <div style="max-width: 80%; position: relative;">
            <div style="background: ${isMe ? '#007bff' : '#ffffff'}; 
                        color: ${isMe ? '#ffffff' : '#333333'}; 
                        padding: 10px 15px; 
                        border-radius: ${isMe ? '15px 15px 0 15px' : '15px 15px 15px 0'};
                        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
                        border: ${isMe ? 'none' : '1px solid #eee'}">
                
                ${replyTemplate}

                <div style="font-size: 10px; font-weight: bold; margin-bottom: 3px; display: flex; justify-content: space-between; gap: 10px;">
                    <span>
                    
                        ${isMe ? 'Anda' : (msg.user ? msg.user.name : (msg.guest_name || 'Guest'))}
                        ${isAdmin ? ' <span style="color: blue; font-weight: bold; text-shadow: 1px 1px 1px rgba(0,0,0,0.2);">(ADMIN)</span>' : ''}
                    </span>
                    
                    <span onclick="setReply(${msg.id}, '${msg.message.replace(/'/g, "\\'")}', '${msg.user ? msg.user.name : (msg.guest_name || 'Guest')}', ${isAdmin})" 
                          style="cursor: pointer; color: ${isMe ? '#cce5ff' : '#007bff'}; text-decoration: underline;">Reply</span>
                </div>
                
                <div style="font-size: 13px; line-height: 1.4;">${msg.message}</div>
                
                <div style="font-size: 9px; text-align: right; margin-top: 5px; opacity: 0.7;">
                    ${dateObj.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                </div>
            </div>
        </div>
    </div>
`;
                chatbox.innerHTML += msgHtml;
            });
            
            // Auto scroll ke posisi paling bawah
            chatbox.scrollTop = chatbox.scrollHeight; 
        })
        .catch(err => console.error("Gagal memuat pesan:", err));
}
// 4. Fungsi Kirim Pesan
function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value;
    if (message.trim() == "") return;

    // AMBIL NAMA GUEST DISINI
    const guestName = getGuestName(); 

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{ route('chat.send') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({ 
            message: message,
            guest_name: guestName, // KIRIM NAMA KE SERVER
            parent_id: selectedReplyId 
        })
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) {
            // Ini akan memberitahu kita ALASAN spesifik gagalnya
            console.error("Error Server:", data);
            throw new Error(data.message || "Gagal mengirim");
        }
        return data;
    })
    .then(() => {
        input.value = "";
        cancelReply();
        loadMessages(); 
    })
    .catch(err => {
        console.error(err);
        alert("Pesan Gagal: " + err.message);
    });
}

// Jalankan load pesan setiap 3 detik
setInterval(loadMessages, 15000);
loadMessages();
</script>
{{-- Script untuk Detail Site Modal & Peta --}}
    <script>
        // 1. Inisialisasi Peta & Jam Global
        let map; 

        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-GB', { 
                hour: '2-digit', minute: '2-digit', second: '2-digit' 
            });
            const clockEl = document.getElementById('clock');
            if(clockEl) clockEl.innerText = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // 2. Logika Sidebar Menu (Expand/Collapse Card Utama)
        const menuItems = document.querySelectorAll(".menu-item");
        menuItems.forEach(item => {
            const header = item.querySelector(".menu-header");
            header.addEventListener("click", function(e) {
                // JANGAN jalankan collapse jika yang diklik adalah tombol "Lihat Site"
                if (e.target.classList.contains('toggle-site')) return;

                if (item.classList.contains("expanded")) {
                    item.classList.remove("expanded");
                    item.classList.add("collapsed");
                } else {
                    // Tutup menu lain yang terbuka
                    menuItems.forEach(i => {
                        i.classList.remove("expanded");
                        i.classList.add("collapsed");
                    });
                    // Buka yang sekarang
                    item.classList.remove("collapsed");
                    item.classList.add("expanded");
                }
            });
        });

        // 3. FIX: Logika Lihat Site (Dropdown di dalam Sidebar)
        // Menggunakan Event Delegation agar lebih kuat
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('toggle-site')) {
                e.preventDefault();
                e.stopPropagation(); // Kunci utama: hentikan event agar tidak naik ke menu-header

                const btn = e.target;
                const group = btn.closest('.ticket-group');
                const detail = group.querySelector('.site-detail-container');
                const count = group.querySelectorAll('li').length;

                // Cek status display (jika kosong atau none, maka buka)
                const isHidden = detail.style.display === "none" || detail.style.display === "";

                if (isHidden) {
                    detail.style.display = "block";
                    btn.innerText = `Tutup Site (${count})`;
                    btn.style.color = "#d9534f"; // Warna merah
                } else {
                    detail.style.display = "none";
                    btn.innerText = `Lihat Site (${count})`;
                    btn.style.color = "#007bff"; // Warna biru asal
                }
            }
        });

        // 4. Logika Modal Detail (Klik Site ID di Tabel)
        function openSiteDetail(siteCode) {
            fetch(`/ticket/detail/${siteCode}`)
                .then(response => response.json())
                .then(data => {
                    const modal = document.getElementById('siteModal');
                    modal.style.display = 'flex';

                    // Update Isi Modal
                    document.getElementById('modalTitle').innerText = `Detail Tiket - ${data.nama_site}`;
                    document.getElementById('m-site-id').innerText = data.site_id || '-';
                    document.getElementById('m-kategori').innerText = data.kategori || '-';
                    document.getElementById('m-provinsi').innerText = data.provinsi || '-';
                    document.getElementById('m-kabupaten').innerText = data.kabupaten || '-';
                    document.getElementById('m-listrik').innerText = data.sumber_listrik || '-';
                    document.getElementById('m-durasi').innerText = `${Math.floor(data.durasi || 0)} Hari`;
                    document.getElementById('m-problem').innerText = data.detail_problem || '-';
                    document.getElementById('m-ce').innerText = data.ce || '-';

                    // Render Map
                    setTimeout(() => {
                        if (map) { map.remove(); map = null; }
                        const lat = parseFloat(data.latitude);
                        const lng = parseFloat(data.longitude);

                        if (!isNaN(lat) && !isNaN(lng) && lat !== 0) {
                            map = L.map('map').setView([lat, lng], 13);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                            L.marker([lat, lng]).addTo(map);
                            map.invalidateSize();
                        }
                    }, 400);
                })
                .catch(err => console.error("Gagal memuat detail:", err));
        }

        // Listener untuk link di tabel
        document.querySelectorAll('.site-detail-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                openSiteDetail(this.getAttribute('data-id'));
            });
        });

        // 5. Logika Penutup Modal
        const closeModal = () => { document.getElementById('siteModal').style.display = 'none'; };
        const closeBtn = document.querySelector('.close-modal');
        if(closeBtn) closeBtn.onclick = closeModal;
        
        window.onclick = (event) => {
            const modal = document.getElementById('siteModal');
            if (event.target == modal) closeModal();
        };
    </script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.clickable-card');
    
    cards.forEach(card => {
        card.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const tableBody = document.querySelector('table tbody');
            const tableTitle = document.querySelector('.table-card .card-title');
            const tableHeaderLast = document.querySelector('table thead th:last-child'); // Target kolom Duration/Date

            // Feedback visual
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Sedang mengambil data...</td></tr>';

            fetch(`/tickets/filter?type=${type}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (tableTitle) tableTitle.innerText = data.type_label;
                        
                        // FIX: Merubah Header secara dinamis
                        if (type === 'pm_bmn' || type === 'pm_sl') {
                            if (tableHeaderLast) tableHeaderLast.innerText = 'Date';
                        } else {
                            if (tableHeaderLast) tableHeaderLast.innerText = 'Duration';
                        }

                        tableBody.innerHTML = '';

                        if (data.tickets.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>';
                            return;
                        }

                        data.tickets.forEach((t, index) => {
                            tableBody.innerHTML += `
                                <tr>
                                    <td class="text-center">${index + 1}</td>
                                    <td>${t.nama_site}</td>
                                    <td class="text-center">${t.site_code}</td>
                                    <td class="text-center">
                                        <span class="badge ${t.status === 'DONE' ? 'bg-success' : 'bg-warning'}">
                                            ${t.status}
                                        </span>
                                    </td>
                                    <td class="text-center">${t.display_date}</td>
                                </tr>
                            `;
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Gagal memuat data.</td></tr>';
                });
        });
    });
});
</script>
</body>
</html>
</body>

</html>