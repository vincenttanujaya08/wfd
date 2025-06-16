<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title') — Toddit Admin</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    /* Base */
    *{box-sizing:border-box;margin:0;padding:0;}
    body{display:flex;font-family:Arial,sans-serif;background:#f9fafb;min-height:100vh;}
    a{text-decoration:none;color:inherit;}
    /* Sidebar */
    #sidebar{width:80px;background:#5b6bf3;color:#fff;transition:width .3s;display:flex;flex-direction:column;}
    #sidebar.expanded{width:220px;}
    .sidebar-top{padding:1rem;display:flex;align-items:center;}
    .brand{font-size:1.2rem;font-weight:bold;margin-left:.5rem;}
    #sidebar:not(.expanded) .brand{display:none;}
    .nav-item{display:flex;align-items:center;padding:.8rem 1rem;transition:background .2s;color:#e0e7ff;}
    .nav-item i{font-size:1.2rem;margin-right:1rem;}
    #sidebar:not(.expanded) .nav-text{display:none;}
    .nav-item:hover,.nav-item.active{background:#4c55c2;}
    .sidebar-footer{margin-top:auto;padding:1rem;}
    /* Main */
    .main-content{flex:1;padding:2rem;}
    /* Cards */
    .card-grid{display:flex;gap:1rem;margin-bottom:2rem;}
    .card{flex:1;background:#fff;padding:1.5rem;border-radius:.5rem;box-shadow:0 2px 6px rgba(0,0,0,.05);text-align:center;}
    .card h4{margin-bottom:.5rem;color:#6b7280;}
    .card p{font-size:1.75rem;font-weight:600;color:#111827;}
    /* Tables */
    .admin-table{width:100%;border-collapse:collapse;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.05);}
    .admin-table th,.admin-table td{padding:.75rem 1rem;border-bottom:1px solid #e5e7eb;text-align:left;}
    .admin-table thead{background:#f3f4f6;}
    /* Forms & Buttons */
    .search-input{width:100%;padding:.5rem 1rem;margin-bottom:1rem;border:1px solid #d1d5db;border-radius:.375rem;}
    .btn{padding:.5rem 1rem;border:none;border-radius:.375rem;font-size:.875rem;cursor:pointer;}
    .btn-add{background:#10b981;color:#fff;}
    .btn-edit{background:#6366f1;color:#fff;}
    .btn-view{background:#3b82f6;color:#fff;}
    .btn-cancel{background:#ef4444;color:#fff;}
    .btn-warning{background:#f59e0b;color:#fff;}
    .btn-ban{background:#dc2626;color:#fff;}
    /* Slider & Info */
    .image-slider{display:flex;overflow-x:auto;gap:.5rem;margin-bottom:1rem;}
    .image-slider img{height:120px;border-radius:.375rem;}
    .info-card{background:#fff;padding:1rem;border-radius:.5rem;box-shadow:0 2px 6px rgba(0,0,0,.05);}
    .info-card h3{margin-bottom:.5rem;color:#374151;}
    .info-card p{margin-bottom:.5rem;color:#4b5563;}
  </style>
  @yield('head')
</head>
<body>
  @include('admin.layouts.sidebar')
  <div class="main-content">
    <h1 style="margin-bottom:1.5rem;color:#1f2937;">@yield('title')</h1>
    @yield('content')
  </div>
  <script>function toggleSidebar(){document.getElementById('sidebar').classList.toggle('expanded')}</script>
  @yield('scripts')
</body>
</html>
