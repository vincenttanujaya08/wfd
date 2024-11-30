<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 w-100 max-w-md bg-white rounded-lg">
            <div class="text-center mb-4">
                <h2 class="text-3xl font-bold text-gray-700">Welcome Back to Todit!</h2>
                <p class="text-gray-500">Login to your account</p>
            </div>
            <form id="loginForm">
                <div class="mb-3">
                    <label for="email" class="form-label text-gray-700">Email address</label>
                    <input type="email" id="email" class="form-control p-2 border border-gray-300 rounded-md" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-gray-700">Password</label>
                    <input type="password" id="password" class="form-control p-2 border border-gray-300 rounded-md" placeholder="Enter your password" required>
                </div>
                <div class="mb-3 text-end">
                    <a href="#" class="text-sm text-blue-500 hover:underline">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Login
                </button>
            </form>
            <div class="mt-4 text-center">
                <p class="text-gray-500">Don't have an account? 
                    <a href="signup.blade.php" class="text-blue-500 hover:underline">Sign up</a>
                </p>
            </div>
        </div>
    </div>
<<<<<<< Updated upstream
=======

    <div class="bottom-text">
        <p>Share your thoughts, join discussions, and connect with a global community</p> 
        <p>Upload content, engage in conversations, and discover new perspectives!</p>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <img src="{{ asset('images/failedlogin.png') }}" alt="Error" class="modal-img">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Login Failed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    The password you entered is incorrect. Please try again.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

>>>>>>> Stashed changes
    <script>
        $(document).ready(function () {
            $('#loginForm').on('submit', function (e) {
                e.preventDefault();
<<<<<<< Updated upstream
                alert('Login successful!');
=======
                
                const email = $('#email').val();
                const password = $('#password').val();
                if (email === "test@example.com" && password === "password123") {
                    alert('Login successful!');
                } else {
                    $('#errorModal').modal('show');
                }
>>>>>>> Stashed changes
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
