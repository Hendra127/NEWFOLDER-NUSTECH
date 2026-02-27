<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Landing Page Nustech</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}">

  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Roboto+Slab:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      margin: 0;
      padding: 0;
      overflow: hidden;
      height: 100vh;
      width: 100vw;
      background-color: #4c1d95; /* fallback color */
    }
    
    #bgVideo {
      position: fixed;
      top: 0;
      left: 0;
      min-width: 100%;
      min-height: 100%;
      object-fit: cover;
      z-index: -1;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInLeft {
      from { opacity: 0; transform: translateX(-60px);}
      to   { opacity: 1; transform: translateX(0);}
    }

    .fade-in { animation: fadeIn 2s ease-out both; }
    .animate-slide-in-left { animation: slideInLeft 1.5s cubic-bezier(.4,0,.2,1) both; }

    .gradient-text {
      background: linear-gradient(to right, #d1d7e7, #86ade5);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* Navbar Glassmorphism */
    #mainNav > div {
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.25), 0 8px 30px rgba(0,0,0,0.25);
    }

    /* Dropdown Desktop */
    .group > .dropdown-menu {
      opacity: 0;
      visibility: hidden;
      transform: translateY(10px) scale(0.95);
      transition: all 0.3s ease;
    }
    .group:hover > .dropdown-menu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0) scale(1);
    }

    .dropdown-item {
      display: block;
      padding: 10px 16px;
      font-size: 14px;
      color: #374151;
      transition: all 0.25s ease;
      position: relative;
    }
    .dropdown-item:hover {
      background: linear-gradient(90deg, #f0f9ff, #e0f2fe);
      color: #0284c7;
      padding-left: 24px;
    }
    .dropdown-item::before {
      content: ""; position: absolute; left: 0; top: 50%; width: 0; height: 60%;
      background: #0ea5e9; transform: translateY(-50%); transition: width 0.25s ease;
    }
    .dropdown-item:hover::before { width: 4px; }

    /* Nav Link Hover Underline */
    .nav-link { position: relative; }
    .nav-link::after {
      content: ''; position: absolute; bottom: -2px; left: 0; width: 0;
      height: 2px; background: #0ea5e9; transition: width 0.3s ease;
    }
    .nav-link:hover::after { width: 100%; }
  </style>
</head>

<body class="relative flex flex-col justify-center items-center text-gray-100">

  <video autoplay muted loop playsinline id="bgVideo">
    <source src="{{ asset('assets/video/coba.mp4') }}" type="video/mp4" />
  </video>

  <div class="absolute z-10 animate-slide-in-left text-white" style="top: 40%; left: 10%;">
    <h1 class="text-5xl md:text-7xl font-bold gradient-text">WELCOME</h1>
    <p class="mt-2 text-lg text-blue-100 opacity-80">Nustech Indonesia Management System</p>
  </div>

  <nav id="mainNav" class="w-full fixed top-0 left-0 z-50 py-6 transition-all duration-300">
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-center space-x-4 rounded-full py-3 bg-white/10 backdrop-blur-xl border border-white/20">
      
      <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
        <i class="fa-solid fa-bars text-xl"></i>
      </button>

      <ul class="hidden md:flex items-center space-x-2 font-medium text-white">
        
        <li class="relative group">
          <a href="#" class="nav-link px-4 py-2">Data Site</a>
          <div class="dropdown-menu absolute top-full left-0 mt-3 w-52 bg-white rounded-xl shadow-xl z-50 overflow-hidden">
            <a href="{{ route('datasite') }}" class="dropdown-item">Data Site</a>
            <a href="{{ route('datapas') }}" class="dropdown-item">Manajemen Password</a>
            <a href="{{ route('laporanpm') }}" class="dropdown-item">PM</a>
            <a href="{{ route('pmliberta') }}" class="dropdown-item">PM Liberta 2026</a>
            <a href="{{ route('summarypm') }}" class="dropdown-item">Summary PM</a>
          </div>
        </li>

        <li class="relative group">
          <a href="#" class="nav-link px-4 py-2">Tiket</a>
          <div class="dropdown-menu absolute top-full left-0 mt-3 w-52 bg-white rounded-xl shadow-xl z-50 overflow-hidden">
            <a href="{{ route('open.ticket') }}" class="dropdown-item">Open Tiket</a>
            <a href="{{ route('close.ticket') }}" class="dropdown-item">Close Tiket</a>
            <a href="{{ route('mydashboard') }}" class="dropdown-item">Details (Dashboard)</a>
          </div>
        </li>

        <li class="relative group">
          <a href="#" class="nav-link px-4 py-2">Log Perangkat</a>
          <div class="dropdown-menu absolute top-full left-0 mt-3 w-56 bg-white rounded-xl shadow-xl z-50 overflow-hidden">
            <a href="{{ route('pergantianperangkat') }}" class="dropdown-item">Pergantian Perangkat</a>
            <a href="{{ route('logpergantian') }}" class="dropdown-item">Log Pergantian</a>
            <a href="{{ route('sparetracker') }}" class="dropdown-item">Spare Tracker</a>
            <a href="{{ route('summaryperangkat') }}" class="dropdown-item">PM Summary</a>
          </div>
        </li>

        @auth
          @php $role = Auth::user()->role; @endphp
          @if (in_array($role, ['admin', 'superadmin']))
            <li class="relative group">
              <a href="#" class="nav-link px-4 py-2">SLA</a>
              <div class="dropdown-menu absolute top-full left-0 mt-3 w-48 bg-white rounded-xl shadow-xl z-50 overflow-hidden">
                <a href="{{ url('rekap-bmn') }}b" class="dropdown-item">BMN</a>
                <a href="{{ url('rekap-sl') }}" class="dropdown-item">SL</a>
              </div>
            </li>
            <li><a href="{{ route('jadwalpiket') }}" class="nav-link px-4 py-2">Jadwal Piket</a></li>
          @endif
        @endauth

        <li><a href="{{ route('todolist') }}" class="nav-link px-4 py-2">To Do List</a></li>
        
        @auth
          @if (Auth::user()->role === 'superadmin')
            <li><a href="{{ url('users') }}" class="nav-link px-4 py-2">Users</a></li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="bg-red-500/80 hover:bg-red-600 px-4 py-1.5 rounded-full text-sm transition ml-2">
                Logout
              </button>
            </form>
          </li>
        @endauth
      </ul>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white text-gray-800 w-full absolute top-full left-0 shadow-2xl border-t border-gray-100">
      <ul class="flex flex-col p-4 space-y-1">
        <li><a href="{{ route('datasite') }}" class="block p-3 border-b border-gray-50">Data Site</a></li>
        <li><a href="{{ route('open.ticket') }}" class="block p-3 border-b border-gray-50">Tiket</a></li>
        <li><a href="{{ route('todolist') }}" class="block p-3 border-b border-gray-50">To Do List</a></li>
        @auth
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full text-left p-3 text-red-600">Logout</button>
                </form>
            </li>
        @endauth
      </ul>
    </div>
  </nav>

  <footer class="w-full absolute bottom-0 left-0 py-6 text-sm text-center fade-in text-white/60">
    &copy; <script>document.write(new Date().getFullYear())</script> Nustech Indonesia. All rights reserved.
  </footer>

  <script>
    // Navbar Scroll Effect
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 40) {
        nav.classList.add('py-3');
      } else {
        nav.classList.remove('py-3');
      }
    });

    // Mobile Menu Toggle
    const mobileBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    mobileBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>
</body>
</html>