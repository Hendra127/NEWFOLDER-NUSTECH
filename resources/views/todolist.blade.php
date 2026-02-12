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
    <link rel="stylesheet" href="{{ asset('css/todolist.css') }}">

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
        <a href="{{ route('todolist') }}" class="tab {{ request()->is('todolist*') ? 'active' : '' }}" style="text-decoration: none; color: White;">To Do List</a>
    </div>

    <div class="title-wrapper">
        <div class="todo-title">My To Do List</div>
    </div>

    <div class="todo-container">
        
        <div class="main-todo-card">
            <div class="input-note-area">
                <input type="text" placeholder="Buat catatan...">
                <i class="bi bi-journal-plus ms-2" style="color: #555;"></i>
                <i class="bi bi-plus-lg ms-2" style="color: #555;"></i>
            </div>

            <div class="notes-grid">
                
                <div class="note-item">
                    <div class="note-header">
                        Title Over Here - 1
                        <i class="bi bi-three-dots-vertical"></i>
                    </div>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox"> 
                            <span>Lorem ipsum dolor sit amet, consectetur.</span>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox"> 
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis.</span>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox"> 
                            <span>Lorem ipsum dolor sit amet, consectetur.</span>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox"> 
                            <span>Lorem ipsum dolor sit amet, consectetur.</span>
                        </div>
                    </div>
                </div>

                <div class="note-item note-item-full">
                    <div class="note-header">
                        Title Over Here - 3
                        <i class="bi bi-three-dots-vertical"></i>
                    </div>
                    <div class="note-content">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus elit sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent auctor purus luctus enim egestas, ac scelerisque ante pulvinar. Donec ut rhoncus ex. Suspendisse ac rhoncus nisl, eu tempor urna. Curabitur vel bibendum lorem. Morbi convallis convallis diam sit amet lacinia. Aliquam in elementum tellus.
                        <br><br>
                        Donec ut rhoncus ex. Suspendisse ac rhoncus nisl, eu tempor urna. Curabitur vel bibendum lorem. Morbi convallis convallis diam sit amet lacinia.
                    </div>
                </div>

                <div class="note-item">
                    <div class="note-header">
                        Title Over Here - 2
                        <i class="bi bi-three-dots-vertical"></i>
                    </div>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox"> 
                            <span>Lorem ipsum dolor sit amet, consectetur.</span>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox"> 
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis.</span>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox"> 
                            <span>Lorem ipsum dolor sit amet, consectetur.</span>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox"> 
                            <span>Lorem ipsum dolor sit amet, consectetur.</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="done-column">
            <div class="done-header">Done</div>
            
            <div class="done-item">
                Title Over Here - 1
                <i class="bi bi-three-dots-vertical"></i>
            </div>
            
            <div class="done-item">
                Title Over Here - 2
                <i class="bi bi-three-dots-vertical"></i>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>