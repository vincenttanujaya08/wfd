<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <!-- Lineicons CDN -->
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #111;
            color: #ccc;
        }

        /* Main Content */
        .main-content {
           left: 100px;
            transition: margin-left 0.3s ease;
            padding: 1rem;
            position: absolute;
            z-index: 1;
            width: 150vh;
        }

        /* Jika menginginkan efek overlay saat sidebar expanded, 
           sudah diatur dalam sidebar.css atau inline di sidebar file 
           (asumsi sudah ditangani di sana dengan .sidebar-open pada body) */
        body.sidebar-open .main-content::before {
            /* Contoh overlay (jika diinginkan)
               Jika sudah ada di sidebar file, ini bisa dihapus atau disesuaikan. */
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 5000;
        }
    </style>
</head>
<body>
    @include('layouts.sidebar')

    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>
