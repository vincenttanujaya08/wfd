<!DOCTYPE html>
<html lang="en">
<head>
  <!-- … meta, CSS lineicons … -->
  <style>
          html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background: #111;
            color: #ccc;
            font-family: sans-serif;
            overflow-x: hidden; /* Mencegah scroll horizontal */
        }

        /* Misalnya sidebar collapse width = 70px, expanded width = 260px.
           Kita akan atur main-content agar menyesuaikan.
        */

        /* Body dengan sidebar collapse */
        body:not(.sidebar-open) .main-content {
            margin-left: 70px; /* Ruang untuk sidebar collapse */
            width: calc(100% - 70px);
        }

        /* Body dengan sidebar open */
        body.sidebar-open .main-content {
            margin-left: 260px; /* Jika sidebar expand menjadi 260px */
            width: calc(100% - 260px);
        }

        .main-content {
            transition: margin-left 0.3s ease, width 0.3s ease;
            padding: 1rem;
            box-sizing: border-box;
            position: relative;
            /* Tidak perlu absolute jika layout normal */
        }

        /* Overlay efek jika sidebar expanded, jika diinginkan */
        body.sidebar-open .main-content::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 5000;
        }
         /* notification‐modal */
    .notif-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.4);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }
    .notif-box {
      background: white;
      border-radius: 8px;
      padding: 2rem;
      max-width: 320px;
      text-align: center;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      animation: pop-in 0.3s ease;
    }
    .notif-box .icon {
      font-size: 3rem;
      color: #38a169;  /* green */
      margin-bottom: 1rem;
    }
    .notif-box h2 {
      margin: 0;
      font-size: 1.25rem;
      color: #2d3748;
    }
    .notif-box p {
      margin: .5rem 0 1.5rem;
      color: #4a5568;
    }
    .notif-box button {
      background: #4299e1;
      color: white;
      border: none;
      padding: .5rem 1.25rem;
      border-radius: .25rem;
      cursor: pointer;
    }
    @keyframes pop-in {
      from { transform: scale(0.8); opacity: 0 }
      to   { transform: scale(1);   opacity: 1 }
    }
  </style>

  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  @yield('head')
</head>

{{-- Jika pilihan #1: hapus `sidebar-open` --}}
{{-- Jika pilihan #2: pasang class="sidebar-open" --}}
<body>
  {{-- Sidebar include --}}
  @include('admin.layouts.sidebar') 
  

  {{-- Konten --}}
  <div class="main-content">

     {{-- ⚠️ Flash notification modal --}}
    @if(session('success') || session('error'))
      <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 4000)"
        class="notif-backdrop"
      >
        <div class="notif-box" @click.away="show = false">
          <div class="icon">
            {{-- success vs error icon --}}
            @if(session('success'))
              <i class="fas fa-check-circle"></i>
            @else
              <i class="fas fa-exclamation-circle" style="color:#e53e3e;"></i>
            @endif
          </div>
          <h2>
            {{ session('success') ? 'Berhasil!' : 'Error' }}
          </h2>
          <p>
            {{ session('success') ?? session('error') }}
          </p>
          <button @click="show = false">OK</button>
        </div>
      </div>
    @endif
    <h1>@yield('title')</h1>
    @yield('content')
  </div>

  <script>
    function toggleSidebar(){
      document.getElementById('sidebar').classList.toggle('expanded');
      document.body.classList.toggle('sidebar-open');
    }
  </script>
  @yield('scripts')
</body>
</html>
