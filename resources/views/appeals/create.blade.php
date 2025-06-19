<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Banding Pemblokiran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    {{-- Navbar sederhana --}}
    <nav class="bg-white shadow p-4 mb-8">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                @auth
                <span class="mr-4">Halo, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="mr-4">Login</a>
                <a href="{{ route('signup') }}">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4">

        {{-- Tombol Kembali --}}
        <button
            type="button"
            onclick="window.history.back()"
            class="mb-6 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
            &larr; Kembali
        </button>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif
        @if(session('info'))
        <div class="bg-blue-100 text-blue-800 p-4 rounded mb-6">
            {{ session('info') }}
        </div>
        @endif

        {{-- Detail Ban --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <p><strong>Diblokir sejak:</strong> {{ $ban->banned_at->format('d F Y H:i') }}</p>
            <p><strong>Sampai:</strong> {{ $ban->banned_until->format('d F Y H:i') }}</p>
            <p><strong>Alasan:</strong> {{ $ban->reason }}</p>
        </div>

        {{-- Form Banding --}}
        <form action="{{ route('appeal.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="message" class="block font-medium mb-2">Alasan Banding</label>
                <textarea
                    id="message"
                    name="message"
                    rows="5"
                    class="w-full border-gray-300 rounded @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                @error('message')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded">
                Kirim Banding
            </button>
        </form>
    </div>

</body>

</html>