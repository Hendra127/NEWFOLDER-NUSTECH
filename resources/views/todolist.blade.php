<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management - To Do List</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f0f2f5; color: #333; }
        .main-header { background-color: #1a202c; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        
        /* Card Styling */
        .note-item { 
            background: #fff; padding: 20px; border-radius: 18px; border: 1px solid #e2e8f0; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            display: flex; flex-direction: column; min-height: 250px;
        }
        .note-item:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); border-color: #8b5cf6; }
        
        /* Progress Styling */
        .progress { background-color: #edf2f7; height: 8px; border-radius: 10px; }
        .progress-bar { transition: width 0.6s ease; border-radius: 10px; }

        /* Checklist */
        /* Update class ini di bagian <style> */
        .checklist-item { 
            display: flex; 
            align-items: flex-start; /* Ubah ke flex-start agar checkbox tetap di atas saat teks panjang */
            gap: 10px; 
            margin-bottom: 8px; 
            padding: 4px 8px; 
            transition: 0.2s;
            width: 100%; /* Pastikan mengambil lebar penuh */
        }

        /* Tambahkan ini untuk memaksa teks membungkus (wrap) */
        .checklist-item span {
            word-break: break-word; /* Memecah kata yang terlalu panjang */
            white-space: normal;    /* Memastikan teks pindah baris */
            flex: 1;                /* Mengambil sisa ruang yang tersedia */
            line-height: 1.4;
        }

        /* Opsional: Jika judul project (h5) juga sering panjang, tambahkan ini */
        .note-item h5 {
            word-break: break-word;
            white-space: normal;
            overflow-wrap: anywhere;
        }
        .checklist-item:hover { background: #f8fafc; border-radius: 8px; }
        .strikethrough { text-decoration: line-through; color: #a0aec0; }
        
        .subtask-input { border-radius: 10px !important; border: 1px dashed #cbd5e0 !important; background: #f8fafc !important; font-size: 13px !important; }
        
        /* Done Column Styling */
        .done-column { background: #e2e8f0; border-radius: 20px; padding: 20px; min-height: 80vh; }
        .done-card { opacity: 0.85; filter: grayscale(0.5); border-left: 5px solid #2ecc71 !important; }
        
        .cursor-pointer { cursor: pointer; }
    </style>
</head>
<body>
    @include('components.nav-modal-structure')

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
        <a href="{{ url('/todolist') }}" class="tab {{ request()->is('todolist*') ? 'active' : '' }}" style="text-decoration: none; color: White;">To Do List</a>
    </div>

    <div class="container-fluid mt-4 px-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 style="font-weight: 700;">Ongoing Projects</h3>
                    <div class="d-flex flex-column w-100" style="gap: 10px;">
                        <textarea id="todoInput" class="form-control" rows="2" 
                                placeholder="Nama Project Baru... (Tekan Enter untuk simpan, Shift+Enter untuk baris baru)" 
                                onkeydown="handleTextareaEnter(event)"
                                style="border-radius: 12px; resize: none;"></textarea>
                        <button class="btn btn-primary w-100" onclick="saveTodo()" style="border-radius: 10px;">
                            <i class="bi bi-plus-lg me-2"></i>
                        </button>
                    </div>
                </div>

                <div class="notes-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                    @forelse($todos as $todo)
                        @php
                            $total = count($todo->checklists ?? []);
                            $completed = collect($todo->checklists ?? [])->where('completed', true)->count();
                            $percent = $total > 0 ? round(($completed / $total) * 100) : 0;
                        @endphp
                        
                        <div class="note-item" id="todo-card-{{ $todo->id }}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 style="font-weight: 700; margin: 0; color: #1e293b;" 
                                    contenteditable="true" 
                                    onblur="updateProjectTitle({{ $todo->id }}, this.innerText)">
                                    {{ $todo->title }}
                                </h5>
                                
                                <div class="d-flex gap-2">
                                    <i class="bi bi-check-circle-fill text-success fs-5 cursor-pointer" onclick="toggleStatus({{ $todo->id }})"></i>
                                    <i class="bi bi-trash text-danger cursor-pointer" onclick="deleteTodo({{ $todo->id }})"></i>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1" style="font-size: 11px; font-weight: 600;">
                                    <span>Progress</span>
                                    <span>{{ $percent }}%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $percent }}%; background-color: #8b5cf6;"></div>
                                </div>
                            </div>

                            <div class="checklist-area mb-3" style="max-height: 250px; overflow-y: auto; overflow-x: hidden; flex-grow: 1;">
                                @foreach($todo->checklists ?? [] as $item)
                                    <div class="checklist-item">
                                        <input type="checkbox" {{ $item['completed'] ? 'checked' : '' }} 
                                            onchange="toggleSubTask('{{ $todo->id }}', '{{ $item['id'] }}')" 
                                            class="form-check-input cursor-pointer" style="min-width: 18px;"> 
                                        
                                        <span class="{{ $item['completed'] ? 'strikethrough' : '' }}" 
                                            style="font-size: 13px;" 
                                            contenteditable="true"
                                            onblur="updateSubTaskText('{{ $todo->id }}', '{{ $item['id'] }}', this.innerText)">
                                            {{ $item['text'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <input type="text" class="form-control form-control-sm subtask-input" 
                                   placeholder="+ Tambah sub-task..." 
                                   onkeypress="if(event.key === 'Enter') addSubTask('{{ $todo->id }}', this)">
                        </div>
                    @empty
                        <p class="text-muted">Tidak ada project berjalan.</p>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-4">
                <div class="done-column">
                    <h4 class="mb-4" style="font-weight: 700;"><i class="bi bi-check-all text-success"></i> Completed</h4>
                    
                    @forelse($dones as $done)
                        <div class="note-item done-card mb-3" style="min-height: auto; padding: 15px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="m-0" style="font-weight: 700; text-decoration: line-through;">{{ $done->title }}</h6>
                                    <small class="text-muted" style="font-size: 10px;">Selesai pada: {{ $done->updated_at->format('d M H:i') }}</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <i class="bi bi-arrow-counterclockwise text-primary fs-5 cursor-pointer" 
                                       onclick="toggleStatus({{ $done->id }})" title="Kembalikan ke Aktif"></i>
                                    <i class="bi bi-trash text-danger cursor-pointer" onclick="deleteTodo({{ $done->id }})"></i>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted py-5">Belum ada project selesai.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Script untuk dropdown profile dan CRUD To Do List --}}
    <script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    // Konfigurasi Toast (Notifikasi kecil di pojok untuk auto-save)
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });

    // --- UI Logic ---
    $('#profileDropdownTrigger').on('click', function(e) {
        e.stopPropagation();
        $('#profileDropdownMenu').fadeToggle(200);
    });
    $(document).on('click', () => $('#profileDropdownMenu').fadeOut(200));

    function handleTextareaEnter(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            saveTodo();
        }
    }

    // --- CRUD Utama ---
    function saveTodo() {
        let title = $('#todoInput').val();
        if (!title.trim()) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Nama project tidak boleh kosong!' });
            return;
        }

        $.post("{{ route('todolist.store') }}", { title: title }, function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Project baru telah ditambahkan',
                showConfirmButton: false,
                timer: 1500
            }).then(() => location.reload());
        });
    }

    function toggleStatus(id) {
        $.post("/todolist/toggle/" + id, () => {
            Toast.fire({ icon: 'success', title: 'Status berhasil diperbarui' })
            .then(() => location.reload());
        });
    }

    function deleteTodo(id) {
        Swal.fire({
            title: 'Hapus Project?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/todolist/delete/" + id,
                    type: 'DELETE',
                    success: () => {
                        Swal.fire('Terhapus!', 'Project telah dihapus.', 'success')
                        .then(() => location.reload());
                    }
                });
            }
        });
    }

    // --- Edit In-Place (Auto-Save) ---
    function updateProjectTitle(id, newTitle) {
        if (!newTitle.trim()) return;
        $.post("/todolist/update-title/" + id, { title: newTitle }, function() {
            Toast.fire({ icon: 'success', title: 'Judul disimpan' });
        });
    }

    function updateSubTaskText(todoId, subtaskId, newText) {
        if (!newText.trim()) return;
        $.post(`/todolist/subtask/update/${todoId}`, {
            subtask_id: subtaskId,
            text: newText
        }, function() {
            Toast.fire({ icon: 'success', title: 'Perubahan disimpan' });
        });
    }

    // --- Sub-task Logic ---
    function addSubTask(todoId, inputElement) {
        let text = $(inputElement).val();
        if (!text.trim()) return;
        $.post(`/todolist/subtask/add/${todoId}`, { text: text }, () => {
            Toast.fire({ icon: 'success', title: 'Sub-task ditambahkan' })
            .then(() => location.reload());
        });
    }

    function toggleSubTask(todoId, subtaskId) {
        $.post(`/todolist/subtask/toggle/${todoId}`, { subtask_id: subtaskId }, () => {
            // Reload tanpa alert untuk UX yang lebih cepat pada checkbox
            location.reload();
        });
    }
</script>
</body>
</html>