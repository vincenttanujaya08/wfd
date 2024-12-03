<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>You're in</h1>

    <!-- Logout Form -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        @method('POST') <!-- Ensure the form is sent as a POST request -->
        <button type="submit">Logout</button>
    </form>
</body>
</html>
