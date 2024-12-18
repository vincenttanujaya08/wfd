<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Lineicons CDN -->
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />

    <title>Sidebar Example</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #111;
            color: #ccc;
            height: 2000px; /* contoh konten panjang agar bisa di scroll */
        }

        .main-content {
            margin-left: 0; 
            padding: 1rem;
        }

        /* SIDEBAR */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 70px; /* Lebar saat collapse */
            background: #1f1f1f; /* Hitam */
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: width 0.3s ease;
            overflow: hidden;
        }

        #sidebar.expanded {
            width: 260px; /* Lebar saat expand */
        }

        .sidebar-top {
            width: 100%;
            display: flex;
            align-items: center;
            padding: 1rem;
        }

        #sidebar:not(.expanded) .sidebar-top {
            justify-content: center;
        }

        #sidebar.expanded .sidebar-top {
            justify-content: flex-start;
        }

        .sidebar-top .menu-btn {
            color: #fff;
            cursor: pointer;
            font-size: 1.5rem;
        }

        .brand {
            color: #ccc;
            font-size: 1.3rem;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            margin-left: 0.5rem;
        }

        #sidebar:not(.expanded) .brand {
            display: none;
        }

        #sidebar.expanded .brand {
            display: inline-block;
        }

        .sidebar-nav {
            margin-top: 2rem;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .nav-item {
            width: 100%;
            display: flex;
            align-items: center;
            padding: 1rem;
            cursor: pointer;
            color: #ccc;
            text-decoration: none;
            background: none;
            border: none;
            font: inherit;
            text-align: left;
        }

        .nav-item:hover {
            background: #333;
        }

        .nav-item i {
            font-size: 1.4rem;
            margin-right: 1rem;
            min-width: 24px;
            text-align: center;
        }

        .nav-text {
            opacity: 0;
            transition: opacity 0.2s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        #sidebar.expanded .nav-text {
            opacity: 1;
        }

        .sidebar-footer {
            margin-top: auto;
            width: 100%;
            border-top: 1px solid #333;
        }

        body.sidebar-open .main-content::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 5000;
        }

        .logout-form {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .logout-form button.nav-item {
            background: none; 
            border: none; 
            padding: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            width: 100%;
            color: #ccc;
        }

        .logout-form button.nav-item:hover {
            background: #333;
        }

    </style>
</head>
<body>

    <div id="sidebar">
        <div class="sidebar-top">
            <i class="lni lni-menu menu-btn" onclick="toggleSidebar()"></i>
            <span class="brand">TODDIT</span>
        </div>

        <div class="sidebar-nav">
            <!-- Ganti ikon HOME untuk EXPLORE menjadi kompas -->
            <a href="{{ route('explore') }}" class="nav-item {{ Request::is('explore') ? 'active' : '' }}">
                <i class="lni lni-compass"></i>
                <span class="nav-text">EXPLORE</span>
            </a>

            <a href="{{ route('upload') }}" class="nav-item {{ Request::is('upload') ? 'active' : '' }}">
                <i class="lni lni-upload"></i>
                <span class="nav-text">UPLOAD</span>
            </a>

            <!-- Ganti route('homee') menjadi route('home') dan ikon lni-cog menjadi lni-home -->
            <a href="{{ route('homee') }}" class="nav-item {{ Request::is('home') ? 'active' : '' }}">
                <i class="lni lni-home"></i>
                <span class="nav-text">HOME</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <form class="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item">
                    <i class="lni lni-exit"></i>
                    <span class="nav-text">LOGOUT</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('expanded');
            document.body.classList.toggle('sidebar-open');
        }
    </script>

</body>
</html>
