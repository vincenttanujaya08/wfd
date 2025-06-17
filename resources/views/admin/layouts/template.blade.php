<!DOCTYPE html>
<html lang="en">
<head>
  <!-- … meta, CSS lineicons … -->
  <style>
    /* Reset & base */
    *,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }
    html,body{ width:100%; height:100%; overflow-x:hidden; font-family:sans-serif; }

    /* Sidebar */
    #sidebar {
      position:fixed; top:0; left:0;
      height:100vh; width:70px;
      background:#1f1f1f; color:#ccc;
      display:flex; flex-direction:column;
      transition:width .3s; overflow:hidden; z-index:1000;
    }
    #sidebar.expanded { width:260px; }

    /* Main content bergeser otomatis */
    .main-content {
      margin-left: 70px;
      width: calc(100% - 70px);
      padding:1rem 2rem;
      transition:margin-left .3s,width .3s;
    }
    body.sidebar-open .main-content {
      margin-left: 260px;
      width: calc(100% - 260px);
    }

    /* overlay dekorasi (tdk memblok klik) */
    body.sidebar-open .main-content::before {
      content:""; position:fixed;
      top:0; left:0; right:0; bottom:0;
      background:rgba(0,0,0,0.2);
      pointer-events:none; z-index:500;
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
