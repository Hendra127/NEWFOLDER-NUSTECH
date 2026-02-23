<div id="navModal" class="nav-modal">
    <div class="nav-modal-content">
        <div class="nav-modal-close-wrapper">
            <span class="nav-close" onclick="closeNavModal()">&times;</span>
        </div>
        
        <div class="nav-modal-header">
            <h2>Daftar Halaman Operasional</h2>
            <p>Akses cepat menu manajemen proyek operasional</p>
        </div>

        <div class="nav-modal-body">
            <div class="nav-column">
                <div class="column-header">
                    <div class="icon-box blue">DS</div>
                    <h3>Data Site</h3>
                </div>
                <ul>
                    <li><a href="{{ route('datasite') }}"><i class="fas fa-chevron-right"></i> Data Site</a></li>
                    <li><a href="{{ route('datapas') }}"><i class="fas fa-chevron-right"></i> Manajemen Password</a></li>
                    <li><a href="{{ route('laporanpm') }}"><i class="fas fa-chevron-right"></i> Laporan PM</a></li>
                    <li><a href="{{ route('pmliberta') }}"><i class="fas fa-chevron-right"></i> PM Liberta</a></li>
                    <li><a href="{{ route('summaryperangkat') }}"><i class="fas fa-chevron-right"></i> Summary PM</a></li>
                </ul>
            </div>

            <div class="nav-column">
                <div class="column-header">
                    <div class="icon-box red">TK</div>
                    <h3>Tiket</h3>
                </div>
                <ul>
                    <li><a href="{{ route('open.ticket') }}"><i class="fas fa-chevron-right"></i> Open Tiket</a></li>
                    <li><a href="{{ route('close.ticket') }}"><i class="fas fa-chevron-right"></i> Close Tiket</a></li>
                    <li><a href="{{ route('detailticket') }}"><i class="fas fa-chevron-right"></i> Detail Tiket</a></li>
                    <li><a href="{{ route('summaryticket') }}"><i class="fas fa-chevron-right"></i> Summary Tiket</a></li>
                </ul>
            </div>

            <div class="nav-column">
                <div class="column-header">
                    <div class="icon-box purple">LP</div>
                    <h3>Log Perangkat</h3>
                </div>
                <ul>
                    <li><a href="{{ route('pergantianperangkat') }}"><i class="fas fa-chevron-right"></i> Pergantian Perangkat</a></li>
                    <li><a href="{{ route('logpergantian') }}"><i class="fas fa-chevron-right"></i> Log Pergantian</a></li>
                    <li><a href="{{ route('sparetracker') }}"><i class="fas fa-chevron-right"></i> Spare Tracker</a></li>
                    <li><a href="{{ route('summaryperangkat') }}"><i class="fas fa-chevron-right"></i> Summary Perangkat</a></li>
                </ul>
            </div>

            <div class="nav-column">
                <div class="column-header" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">
                    <div class="icon-box blue" style="background: linear-gradient(135deg, #2ecc71, #27ae60);">TD</div>
                    <h3>To Do List</h3>
                </div>
                <ul>
                    <li><a href="{{ route('todolist') }}"><i class="fas fa-chevron-right"></i> My Todo List</a></li>
                </ul>

                <div class="column-header" style="margin-top: 25px; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">
                    <div class="icon-box blue" style="background: linear-gradient(135deg, #f1c40f, #f39c12);">RK</div>
                    <h3>Rekap SLA</h3>
                </div>
                <ul>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> BMN</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> SL</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>