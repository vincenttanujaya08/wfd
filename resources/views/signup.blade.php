<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign-Up Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 w-100 max-w-md bg-white rounded-lg">
            <div class="text-center mb-4">
                <h2 class="text-3xl font-bold text-gray-700">Create an Account</h2>
                <p class="text-gray-500">Join our community today</p>
            </div>
            <form id="signUpForm">
                <div class="mb-3">
                    <label for="name" class="form-label text-gray-700">Full Name</label>
                    <input type="text" id="name" class="form-control p-2 border border-gray-300 rounded-md" placeholder="Enter your full name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-gray-700">Email Address</label>
                    <input type="email" id="email" class="form-control p-2 border border-gray-300 rounded-md" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-gray-700">Password</label>
                    <input type="password" id="password" class="form-control p-2 border border-gray-300 rounded-md" placeholder="Create a password" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label text-gray-700">Confirm Password</label>
                    <input type="password" id="confirmPassword" class="form-control p-2 border border-gray-300 rounded-md" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Sign Up
                </button>
            </form>
            <div class="mt-4 text-center">
                <p class="text-gray-500">Already have an account? 
                    <a href="login.html" class="text-blue-500 hover:underline">Log In</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#signUpForm').on('submit', function (e) {
                e.preventDefault();
                const password = $('#password').val();
                const confirmPassword = $('#confirmPassword').val();
                if (password !== confirmPassword) {
                    alert('Passwords do not match!');
                } else {
                    alert('Sign-Up successful!');
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
