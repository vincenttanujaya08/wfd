<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDdit - Integrated Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Line Icons -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

    <!-- Tailwind CSS (optional) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    <style>
        /* Import Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        /* Reset Styles */
        ::after,
        ::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
        }

        li {
            list-style: none;
        }

        h1 {
            font-weight: 600;
            font-size: 1.5rem;
            /* 24px */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fafbfe;
            margin: 0;
            padding: 0;
            height: 100vh;
            /* Removed overflow: hidden to fix white bar issue */
        }

        /* Navbar Styles */
        .navbar {
            z-index: 1100;
            /* Ensure navbar is above sidebar */
        }

        /* Sidebar Styles */
        #sidebar {
            width: 4.375rem;
            /* 70px = 4.375rem */
            min-width: 4.375rem;
            z-index: 1000;
            transition: all 0.25s ease-in-out;
            background-color: #239fa8;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow: hidden;
        }

        #sidebar.expand {
            width: 16.25rem;
            /* 260px = 16.25rem */
            min-width: 16.25rem;
        }

        .toggle-btn {
            background-color: transparent;
            cursor: pointer;
            border: 0;
            padding: 1rem 1.5rem;
            color: #FFF;
        }

        .toggle-btn i {
            font-size: 1.5rem;
        }

        .sidebar-logo {
            margin: auto 0;
            padding: 1rem;
            text-align: center;
        }

        .sidebar-logo a {
            color: #FFF;
            font-size: 1.25rem;
            font-weight: 600;
        }

        /* Hide text in sidebar links when not expanded */
        #sidebar:not(.expand) .sidebar-logo,
        #sidebar:not(.expand) a.sidebar-link span {
            display: none;
        }

        .sidebar-nav {
            padding: 2rem 0;
            flex: 1 1 auto;
        }

        a.sidebar-link {
            padding: 0.625rem 1.625rem;
            /* 10px 26px */
            color: #FFF;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            white-space: nowrap;
            position: relative;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            margin-right: 0.75rem;
            min-width: 1.25rem;
            /* 20px = 1.25rem */
            text-align: center;
        }

        a.sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.075);
            border-left: 0.1875rem solid #3b7ddd;
            /* 3px = 0.1875rem */
        }

        .sidebar-item {
            position: relative;
        }

        #sidebar:not(.expand) .sidebar-item .sidebar-dropdown {
            position: absolute;
            top: 0;
            left: 4.375rem;
            /* 70px = 4.375rem */
            background-color: #0e1838;
            padding: 0;
            min-width: 15rem;
            /* 240px = 15rem */
            display: none;
        }

        #sidebar:not(.expand) .sidebar-item:hover .has-dropdown+.sidebar-dropdown {
            display: block;
            max-height: 15em;
            width: 100%;
            opacity: 1;
        }

        #sidebar.expand .sidebar-link[data-bs-toggle="collapse"]::after {
            border: solid;
            border-width: 0 0.075rem 0.075rem 0;
            /* 1px = 0.075rem */
            content: "";
            display: inline-block;
            padding: 0.125rem;
            /* 2px = 0.125rem */
            position: absolute;
            right: 1.5rem;
            top: 1.4rem;
            transform: rotate(-135deg);
            transition: all 0.2s ease-out;
        }

        #sidebar.expand .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
            transform: rotate(45deg);
            transition: all 0.2s ease-out;
        }

        .sidebar-footer {
            padding: 1rem;
            position: relative;
        }

        /* Ensure Logout remains visible */
        #sidebar:not(.expand) .sidebar-footer .sidebar-link span {
            display: none;
        }

        /* Tooltip for Logout when sidebar is collapsed */
        #sidebar .sidebar-footer .sidebar-link {
            position: relative;
        }

        #sidebar:not(.expand) .sidebar-footer .sidebar-link::after {
            content: 'Logout';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background-color: #0e1838;
            color: #FFF;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
            pointer-events: none;
            margin-left: 0.5rem;
            font-size: 0.875rem;
        }

        #sidebar:not(.expand) .sidebar-footer .sidebar-link:hover::after {
            opacity: 1;
        }

        /* Main Content Styles */
        .content {
            margin-left: 4.375rem;
            /* 70px = 4.375rem */
            padding: 1rem;
            transition: margin-left 0.3s ease;
            margin-top: 3.5rem;
            /* 56px = 3.5rem */
            height: calc(100vh - 3.5rem);
            overflow-y: auto;
        }

        #sidebar.expand~.content {
            margin-left: 16.25rem;
            /* 260px = 16.25rem */
        }

        /* Search Box Styles */
        .search-box {
            width: 100%;
            max-width: 37.5rem;
            /* 600px = 37.5rem */
            margin: 0 auto 2rem auto;
            display: flex;
            border: 0.0625rem solid #ddd;
            /* 1px = 0.0625rem */
            border-radius: 0.3125rem;
            /* 5px = 0.3125rem */
            box-shadow: 0 0.25rem 0.375rem rgba(0, 0, 0, 0.1);
            /* Shadow adjusted */
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 0.625rem;
            /* 10px = 0.625rem */
            font-size: 1rem;
            border-radius: 0.3125rem 0 0 0.3125rem;
            /* Rounded edges */
        }

        .search-input:focus {
            outline: none;
        }

        .search-button {
            background-color: #239fa8;
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            /* 10px 20px */
            border-radius: 0 0.3125rem 0.3125rem 0;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #1d8c94;
        }

        /* Post Styles */
        .post-container {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            /* 20px = 1.25rem */
        }

        .post {
            background-color: white;
            padding: 1.875rem;
            /* 30px = 1.875rem */
            border-radius: 0.9375rem;
            /* 15px = 0.9375rem */
            box-shadow: 0 0.375rem 0.625rem rgba(0, 0, 0, 0.15);
            max-width: 25rem;
            /* 400px */
            margin: 0 auto;
            /* Center the card */
        }

        .profile-picture {
            cursor: pointer;
            border-radius: 50%;
            width: 3.125rem;
            /* 50px = 3.125rem */
            height: 3.125rem;
            transition: all 0.3s ease;
        }

        .profile-picture:hover {
            opacity: 0.7;
        }

        .post-image-container {
            width: 100%;
            height: 18.75rem;
            /* 300px = 18.75rem */
            overflow: hidden;
            margin-top: 0.9375rem;
            /* 15px = 0.9375rem */
        }

        .post-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-content {
            text-align: center;
        }

        /* Comment Section Styles */
        .comment-section {
            padding: 1rem;
            border-top: 1px solid #ddd;
            display: none;
        }

        .comment-section.active {
            display: block;
        }

        .comment-section h6 {
            margin-bottom: 1rem;
        }

        .comment-section .comment-input-container {
            display: flex;
            margin-bottom: 1rem;
        }

        .comment-section .comment-input-container input {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.3125rem;
            margin-right: 0.5rem;
        }

        .comment-section .comment-input-container button {
            padding: 0.5rem 1rem;
            background-color: #239fa8;
            color: white;
            border: none;
            border-radius: 0.3125rem;
            cursor: pointer;
        }

        .comment-section .comment-input-container button:hover {
            background-color: #1d8c94;
        }

        .comment-section .comment-list {
            list-style: none;
            padding: 0;
            max-height: 15rem;
            overflow-y: auto;
        }

        .comment-section .comment-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .comment-section .comment-item img {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            margin-right: 0.75rem;
            cursor: pointer;
        }

        .comment-section .comment-item .comment-content {
            background-color: #f3f4f6;
            padding: 0.75rem 1rem;
            border-radius: 0.3125rem;
            width: 100%;
        }

        .comment-section .comment-item .comment-content p {
            margin-bottom: 0.25rem;
        }

        .comment-section .comment-item .comment-content small {
            color: #6c757d;
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .post {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>


    <!-- Sidebar -->
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button">
                <i class="lni lni-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="#">ToDdit</a>
            </div>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-user"></i>
                    <span class="ms-2">Profile</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#uploadMenu" aria-expanded="false" aria-controls="uploadMenu">
                    <i class="lni lni-upload"></i>
                    <span class="ms-2">Upload</span>
                </a>
                <ul id="uploadMenu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Text</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Video</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-popup"></i>
                    <span class="ms-2">About</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-cog"></i>
                    <span class="ms-2">Settings</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="#" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="right" title="Logout">
                <i class="lni lni-exit"></i>
                <span class="ms-2">Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="content">
        <!-- Search Section -->
        <div class="container">
            <div class="text-center mb-4">
                <h1>Welcome to ToDdit</h1>
                <p>Search your content!</p>
            </div>

            <div class="search-box">
                <input type="text" id="searchInput" class="search-input" placeholder="Search here..." />
                <button id="searchButton" class="search-button">Search</button>
            </div>
        </div>

        <!-- Posts Section -->
        <div class="container post-container">
            <!-- Single Post -->
            <div class="post bg-gray-100">
                <div class="d-flex align-items-center">
                    <!-- Profile Picture -->
                    <img class="profile-picture user-profile-pic" src="https://newprofilepic.photo-cdn.net//assets/images/article/profile.jpg?90af0c8" alt="Profile Picture"
                        data-bs-toggle="modal" data-bs-target="#profilePicModal" data-username="L0v3lyy" data-description="Loving cute moments and sharing them with the world 🐾">
                    <div class="ms-3">
                        <h5 class="mb-1">L0v3lyy</h5>
                        <p class="mb-0 text-muted">Posted 1 hour ago</p>
                    </div>
                </div>
                <div class="post-image-container">
                    <img class="post-image" src="https://cdn.pixabay.com/photo/2024/02/28/07/42/european-shorthair-8601492_640.jpg" alt="Post Image">
                </div>
                <div class="p-4">
                    <p class="mt-2">Look at these two cats, they are so adorable OMG 😭</p>
                </div>
                <div class="p-4">
                    <div class="d-flex align-items-center space-x-4 mt-3">
                        <button class="btn btn-light text-gray-600 hover:text-blue-500 me-3 comment-btn" data-post-id="1">
                            <img src="chat-dots.svg" alt="Comment" class="w-6 h-6">
                        </button>
                        <button class="btn btn-light text-gray-600 hover:text-red-500 me-2 like-btn" data-post-id="1">
                            <img src="heart.svg" alt="Like" class="heart-icon w-6 h-6">
                        </button>
                        <span class="like-counter text-gray-600">0</span>
                    </div>
                </div>

                <!-- Comment Section (Hidden by default) -->
                <div class="comment-section">
                    <h6 class="mb-3">Comments</h6>
                    <div class="comment-input-container">
                        <input type="text" class="comment-input form-control me-2"
                            placeholder="Add a comment..." maxlength="200">
                        <button class="add-comment btn btn-primary">Post</button>
                    </div>
                    <ul class="comment-list list-unstyled">
                        <!-- Comments will appear here dynamically -->
                    </ul>
                </div>
            </div>

            <!-- Repeat Posts as Needed -->
            <!-- Ensure each post has unique data attributes if necessary -->
            <div class="post bg-gray-100">
                <div class="d-flex align-items-center">
                    <!-- Profile Picture -->
                    <img class="profile-picture user-profile-pic" src="https://newprofilepic.photo-cdn.net//assets/images/article/profile.jpg?90af0c8" alt="Profile Picture"
                        data-bs-toggle="modal" data-bs-target="#profilePicModal" data-username="L0v3lyy" data-description="Loving cute moments and sharing them with the world 🐾">
                    <div class="ms-3">
                        <h5 class="mb-1">L0v3lyy</h5>
                        <p class="mb-0 text-muted">Posted 1 hour ago</p>
                    </div>
                </div>
                <div class="post-image-container">
                    <img class="post-image" src="https://cdn.pixabay.com/photo/2024/02/28/07/42/european-shorthair-8601492_640.jpg" alt="Post Image">
                </div>
                <div class="p-4">
                    <p class="mt-2">Look at these two cats, they are so adorable OMG 😭</p>
                </div>
                <div class="p-4">
                    <div class="d-flex align-items-center space-x-4 mt-3">
                        <button class="btn btn-light text-gray-600 hover:text-blue-500 me-3 comment-btn" data-post-id="2">
                            <img src="chat-dots.svg" alt="Comment" class="w-6 h-6">
                        </button>
                        <button class="btn btn-light text-gray-600 hover:text-red-500 me-2 like-btn" data-post-id="2">
                            <img src="heart.svg" alt="Like" class="heart-icon w-6 h-6">
                        </button>
                        <span class="like-counter text-gray-600">0</span>
                    </div>
                </div>

                <!-- Comment Section (Hidden by default) -->
                <div class="comment-section">
                    <h6 class="mb-3">Comments</h6>
                    <div class="comment-input-container">
                        <input type="text" class="comment-input form-control me-2"
                            placeholder="Add a comment..." maxlength="200">
                        <button class="add-comment btn btn-primary">Post</button>
                    </div>
                    <ul class="comment-list list-unstyled">
                        <!-- Comments will appear here dynamically -->
                    </ul>
                </div>
            </div>

            <div class="post bg-gray-100">
                <div class="d-flex align-items-center">
                    <!-- Profile Picture -->
                    <img class="profile-picture user-profile-pic" src="https://newprofilepic.photo-cdn.net//assets/images/article/profile.jpg?90af0c8" alt="Profile Picture"
                        data-bs-toggle="modal" data-bs-target="#profilePicModal" data-username="L0v3lyy" data-description="Loving cute moments and sharing them with the world 🐾">
                    <div class="ms-3">
                        <h5 class="mb-1">L0v3lyy</h5>
                        <p class="mb-0 text-muted">Posted 1 hour ago</p>
                    </div>
                </div>
                <div class="post-image-container">
                    <img class="post-image" src="https://cdn.pixabay.com/photo/2024/02/28/07/42/european-shorthair-8601492_640.jpg" alt="Post Image">
                </div>
                <div class="p-4">
                    <p class="mt-2">Look at these two cats, they are so adorable OMG 😭</p>
                </div>
                <div class="p-4">
                    <div class="d-flex align-items-center space-x-4 mt-3">
                        <button class="btn btn-light text-gray-600 hover:text-blue-500 me-3 comment-btn" data-post-id="3">
                            <img src="chat-dots.svg" alt="Comment" class="w-6 h-6">
                        </button>
                        <button class="btn btn-light text-gray-600 hover:text-red-500 me-2 like-btn" data-post-id="3">
                            <img src="heart.svg" alt="Like" class="heart-icon w-6 h-6">
                        </button>
                        <span class="like-counter text-gray-600">0</span>
                    </div>
                </div>

                <!-- Comment Section (Hidden by default) -->
                <div class="comment-section">
                    <h6 class="mb-3">Comments</h6>
                    <div class="comment-input-container">
                        <input type="text" class="comment-input form-control me-2"
                            placeholder="Add a comment..." maxlength="200">
                        <button class="add-comment btn btn-primary">Post</button>
                    </div>
                    <ul class="comment-list list-unstyled">
                        <!-- Comments will appear here dynamically -->
                    </ul>
                </div>
            </div>
            <!-- Add more posts as needed -->
        </div>
    </div>

    <!-- Profile Picture Modal -->
    <div class="modal fade" id="profilePicModal" tabindex="-1" aria-labelledby="profilePicModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column align-items-center justify-content-center">
                    <img src="girl.jpg" alt="Profile Picture" class="rounded-circle img-fluid mb-3"
                        style="width: 150px; height: 150px; object-fit: cover; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <h5 class="fw-bold mb-1">Hi, I'm L0v3lyy</h5>
                    <p class="text-muted">Loving cute moments and sharing them with the world 🐾</p>
                    <button class="btn btn-primary btn-sm px-4 mt-2">Follow</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <!-- Removed duplicate Bootstrap JS inclusion -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            // Sidebar Toggle
            const toggleButtons = document.querySelectorAll('.toggle-btn');
            const sidebar = document.getElementById('sidebar');
            const content = document.querySelector('.content');

            toggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    sidebar.classList.toggle('expand');
                });
            });

            // Like button functionality
            const likeButtons = document.querySelectorAll('.like-btn');

            likeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const heartIcon = button.querySelector('.heart-icon');
                    const likeCounter = button.nextElementSibling;
                    let likeCount = parseInt(likeCounter.textContent);

                    if (heartIcon.getAttribute('src').includes('heart-fill.svg')) {
                        heartIcon.setAttribute('src', 'heart.svg');
                        likeCount--;
                    } else {
                        heartIcon.setAttribute('src', 'heart-fill.svg');
                        likeCount++;
                    }
                    likeCounter.textContent = likeCount;
                });
            });

            // Comment section toggle functionality
            const commentButtons = document.querySelectorAll('.comment-btn');

            commentButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Find the closest post container
                    const post = button.closest('.post');
                    if (post) {
                        const commentSection = post.querySelector('.comment-section');
                        commentSection.classList.toggle('active');
                    }
                });
            });

            // Comment section functionality
            const commentSections = document.querySelectorAll('.comment-section');

            commentSections.forEach(section => {
                const addCommentButton = section.querySelector('.add-comment');
                const commentInput = section.querySelector('.comment-input');
                const commentList = section.querySelector('.comment-list');

                addCommentButton.addEventListener('click', () => {
                    const commentText = commentInput.value.trim();
                    if (commentText) {
                        const commentItem = document.createElement('li');
                        commentItem.className = 'comment-item';
                        commentItem.innerHTML = `
                            <img src="girl2.jpg" alt="User" class="rounded-circle me-3 comment-profile-picture" data-username="SweetLimee" style="width: 2.5rem; height: 2.5rem; cursor: pointer;">
                            <div class="comment-content">
                                <p><strong>SweetLimee:</strong> ${commentText}</p>
                                <small class="text-muted">Just now</small>
                            </div>
                        `;
                        commentList.appendChild(commentItem);
                        commentInput.value = '';
                        // Optionally, scroll to the newest comment
                        commentList.scrollTop = commentList.scrollHeight;
                    } else {
                        alert('Please enter a comment.');
                    }
                });
            });

            // Dynamic modal for profile pictures
            const profilePicModal = document.getElementById('profilePicModal');
            const profilePicModalImg = profilePicModal.querySelector('.modal-body img');
            const profilePicModalUsername = profilePicModal.querySelector('.fw-bold');
            const profilePicModalDescription = profilePicModal.querySelector('.text-muted');

            // Handle profile picture click in posts
            const userProfilePics = document.querySelectorAll('.user-profile-pic');
            userProfilePics.forEach(pic => {
                pic.addEventListener('click', () => {
                    const username = pic.getAttribute('data-username');
                    const description = pic.getAttribute('data-description');
                    const src = pic.getAttribute('src');

                    profilePicModalImg.setAttribute('src', src);
                    profilePicModalUsername.textContent = `Hi, I'm ${username}`;
                    profilePicModalDescription.textContent = description;
                });
            });

            // Handle commenter profile picture click within comments
            document.querySelectorAll('.comment-profile-picture').forEach(pic => {
                pic.addEventListener('click', () => {
                    const username = pic.getAttribute('data-username');
                    const src = pic.getAttribute('src');

                    profilePicModalImg.setAttribute('src', src);
                    profilePicModalUsername.textContent = `Hi, I'm ${username}`;
                    profilePicModalDescription.textContent = `This is ${username}'s profile!`;
                });
            });

            // Search functionality (placeholder)
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');

            searchButton.addEventListener('click', () => {
                const query = searchInput.value.trim();
                if (query) {
                    // Implement your search logic here
                    alert(`You searched for: ${query}`);
                } else {
                    alert('Please fill the text box.');
                }
            });
        });
    </script>
</body>

</html>