<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Lineicons CDN -->
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet">

    <title>Sidebar Example</title>
    <style>
        /* Reset and Base Styles */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: sans-serif;
            background: #111;
            color: #ccc;
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
            width: 70px;
            /* Width when collapsed */
            background: #1f1f1f;
            /* Dark background */
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: width 0.3s ease;
            overflow: hidden;
        }

        #sidebar.expanded {
            width: 260px;
            /* Width when expanded */
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
            position: relative;
            /* For badge positioning */
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
            position: relative;
            /* For badge positioning */
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

        /* Notification Badge */
        .notification-badge {
            position: absolute;
            /* Absolute positioning relative to .nav-item */
            background-color: red;
            color: white;
            border-radius: 50%;
            font-size: 0.6rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            z-index: 10;
            /* Ensure it appears above other elements */
            top: -4px;
            right: -4px;
        }

        /* Position and style for expanded sidebar */
        #sidebar.expanded .nav-item .notification-badge {
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
        }

        /* Position and style for collapsed sidebar */
        #sidebar:not(.expanded) .nav-item .notification-badge {
            top: 25px;
            right: 22px;
        }

        .sidebar-footer {
            margin-top: auto;
            width: 100%;
            border-top: 1px solid #333;
        }

        body.sidebar-open .main-content::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
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

        .notification-badge {
            position: absolute;
            /* Absolute positioning relative to .nav-item */
            background-color: red !important;
            /* Ensure it's visible */
            color: white;
            border-radius: 50%;
            font-size: 0.8rem;
            font-weight: bold;
            display: flex !important;
            /* Force display */
            align-items: center;
            justify-content: center;
            width: 20px;
            /* Increase size for debugging */
            height: 20px;
            /* Increase size for debugging */
            top: -4px;
            right: -4px;
            z-index: 10;
            /* Ensure it appears above other elements */
        }


        /* Responsive Adjustments (Optional) */
        @media (max-width: 768px) {
            #sidebar:not(.expanded) .notification-badge {
                top: -4px;
                right: -4px;
                width: 14px;
                height: 14px;
                font-size: 0.5rem;
            }

            #sidebar.expanded .notification-badge {
                top: 50%;
                right: 10px;
                transform: translateY(-50%);
                width: 16px;
                height: 16px;
            }
        }
    </style>
</head>

<body>

 <div id="sidebar" >
  <div class="sidebar-top">
    <i class="lni lni-home-2 menu-btn" onclick="toggleSidebar()" aria-label="Toggle Sidebar"></i>
    <span class="brand">Toddit Admin</span>
  </div>

  <nav class="sidebar-nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" aria-label="Dashboard">
      <i class="lni lni-dashboard-square-1"></i>
      <span class="nav-text">Dashboard</span>
    </a>

    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ Request::routeIs('admin.users.*') ? 'active' : '' }}" aria-label="User Management">
      <i class="lni lni-user-4"></i>
      <span class="nav-text">User Management</span>
    </a>

    <a href="{{ route('admin.reports.index') }}" class="nav-item {{ Request::routeIs('admin.reports.*') ? 'active' : '' }}" aria-label="Reports">
      <i class="lni lni-book-1"></i>
      <span class="nav-text">Reports</span>
    </a>

    <a href="{{ route('admin.bans.index') }}" class="nav-item {{ Request::routeIs('admin.bans.*') ? 'active' : '' }}" aria-label="bans">
      <i class="lni lni-ban-2"></i>
      <span class="nav-text">bans</span>
    </a>
  </nav>

  <div class="sidebar-footer">
    <form action="{{ route('logout') }}" method="POST" class="logout-form">
      @csrf
      <button type="submit" class="nav-item" aria-label="Logout">
        <i class="lni lni-exit"></i>
        <span class="nav-text">Logout</span>
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


        document.addEventListener('DOMContentLoaded', () => {
            const badge = document.querySelector('.notification-badge');

            // Fetch jumlah notifikasi yang belum dibaca
            fetch('/notifications/unread-count', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const unreadCount = data.unread_notifications_count;

                    if (unreadCount > 0) {
                        badge.textContent = unreadCount;
                        badge.style.display = 'flex'; // Tampilkan badge jika ada notifikasi
                    } else {
                        badge.style.display = 'none'; // Sembunyikan badge jika tidak ada notifikasi
                    }
                })
                .catch(error => {
                    console.error('Error fetching unread notifications count:', error);
                });
        });
    </script>

</body>

</html>