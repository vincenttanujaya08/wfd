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
  </style>
  @yield('head')
</head>

{{-- Jika pilihan #1: hapus `sidebar-open` --}}
{{-- Jika pilihan #2: pasang class="sidebar-open" --}}
<body>
  {{-- Sidebar include --}}
  @include('admin.layouts.sidebar') 

  {{-- Konten --}}
  <div class="main-content">
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
