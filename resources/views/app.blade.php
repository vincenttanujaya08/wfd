<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDdit - Integrated Page</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Line Icons -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

    <!-- Tailwind CSS (if needed) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    



<style>
    /* Reset Styles */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
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
    font-size: 1.5rem; /* Adjusted */
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #fafbfe;
    margin: 0;
    padding: 0;
    height: 100%;
    overflow: hidden; /* Hide scrollbars */
}

/* Navbar Styles */
.navbar {
    z-index: 1100; /* Ensure navbar is above sidebar */
}

/* Sidebar Styles */
#sidebar {
    width: 4.375rem; /* 70px = 4.375rem */
    min-width: 4.375rem;
    z-index: 1000;
    transition: all 0.25s ease-in-out;
    background-color: #239fa8;
    display: flex;
    flex-direction: column;
    height: 100vh;
    position: fixed;
    top: 3.5rem; /* 56px = 3.5rem */
    left: 0;
    overflow-y: auto;
}

#sidebar.expand {
    width: 16.25rem; /* 260px = 16.25rem */
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
    min-width: 1.25rem; /* 20px = 1.25rem */
    text-align: center;
}

a.sidebar-link:hover {
    background-color: rgba(255, 255, 255, 0.075);
    border-left: 0.1875rem solid #3b7ddd; /* 3px = 0.1875rem */
}

.sidebar-item {
    position: relative;
}

#sidebar:not(.expand) .sidebar-item .sidebar-dropdown {
    position: absolute;
    top: 0;
    left: 4.375rem; /* 70px = 4.375rem */
    background-color: #0e1838;
    padding: 0;
    min-width: 15rem; /* Relative for dropdown size */
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
    border-width: 0 0.075rem 0.075rem 0; /* 1px = 0.075rem */
    content: "";
    display: inline-block;
    padding: 0.125rem; /* 2px = 0.125rem */
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
}

/* Main Content Styles */
.content {
    margin-left: 4.375rem; /* 70px = 4.375rem */
    padding: 1rem;
    transition: margin-left 0.3s ease;
    margin-top: 3.5rem; /* 56px = 3.5rem */
    height: calc(100vh - 3.5rem);
    overflow-y: auto;
}

#sidebar.expand ~ .content {
    margin-left: 16.25rem; /* 260px = 16.25rem */
}

/* Search Box Styles */
.search-box {
    width: 100%;
    max-width: 37.5rem; /* 600px = 37.5rem */
    margin: 0 auto 2rem auto;
    display: flex;
    border: 0.0625rem solid #ddd; /* 1px = 0.0625rem */
    border-radius: 0.3125rem; /* 5px = 0.3125rem */
    box-shadow: 0 0.25rem 0.375rem rgba(0, 0, 0, 0.1); /* Shadow adjusted */
}

.search-input {
    flex: 1;
    border: none;
    padding: 0.625rem; /* 10px = 0.625rem */
    font-size: 1rem;
    border-radius: 0.3125rem 0 0 0.3125rem; /* Rounded edges */
}

.search-input:focus {
    outline: none;
}

.search-button {
    background-color: #239fa8;
    color: white;
    border: none;
    padding: 0.625rem 1.25rem; /* 10px 20px */
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
    gap: 1.25rem; /* 20px = 1.25rem */
}

.post {
    background-color: white;
    padding: 1.875rem; /* 30px = 1.875rem */
    border-radius: 0.9375rem; /* 15px = 0.9375rem */
    box-shadow: 0 0.375rem 0.625rem rgba(0, 0, 0, 0.15);
}

.profile-picture {
    cursor: pointer;
    border-radius: 50%;
    width: 3.125rem; /* 50px = 3.125rem */
    height: 3.125rem;
    transition: all 0.3s ease;
}

.profile-picture:hover {
    opacity: 0.7;
}

#post-image-container {
    width: 100%;
    height: 18.75rem; /* 300px = 18.75rem */
    overflow: hidden;
    margin-top: 0.9375rem; /* 15px = 0.9375rem */
}

#post-image-container img {
    width: 150%;
    height: 100%;
    object-fit: cover;
}

.modal-content {
    text-align: center;
}

/* Responsive Adjustments */
@media (min-width: 992px) {
    #sidebar {
        height: calc(100vh - 3.5rem); /* Navbar height */
    }

    .row {
        height: 100%;
        margin: 0;
    }

    .col-lg-7,
    .col-lg-5 {
        height: 100%;
        padding: 0;
    }
}

@media (max-width: 991.98px) {
    #sidebar {
        top: 3.5rem; /* Adjust for navbar on smaller screens */
    }

    .content {
        height: calc(100vh - 3.5rem);
    }
}
</style>
</head>

<body>
    <!-- Navbar
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <button class="toggle-btn" type="button">
                <i class="lni lni-grid-alt"></i>
            </button>
            <a class="navbar-brand ms-2" href="#">ToDdit</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <form method="POST" action="{{ route('logout') }}" class="d-flex">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </div>
    </nav> -->

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
            <a href="#" class="sidebar-link">
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
            <div class="post bg-gray-100">
                <div class="d-flex align-items-center">
                    <!-- Profile Picture -->
                    <img id="profile-pic" class="profile-picture" src="https://newprofilepic.photo-cdn.net//assets/images/article/profile.jpg?90af0c8" alt="Profile Picture"
                        data-bs-toggle="modal" data-bs-target="#profilePicModal">
                    <div class="ms-3">
                        <h5 class="mb-1">L0v3lyy</h5>
                        <p class="mb-0 text-muted">Posted 1 hour ago</p>
                    </div>
                </div>
                <div id="post-image-container">
                    <img id="post-image" src="https://cdn.pixabay.com/photo/2024/02/28/07/42/european-shorthair-8601492_640.jpg" alt="Post Image">
                </div>
                <div class="p-4">
                    <p class="mt-2">Look at these two cats, they are so adorable OMG 😭</p>
                </div>
                <div class="p-4">
                    <div class="d-flex align-items-center space-x-4 mt-3">
                        <button class="btn btn-light text-gray-600 hover:text-blue-500 me-3">
                            <img src="chat-dots.svg" alt="Comment" class="w-6 h-6">
                        </button>
                        <button id="like-button" class="btn btn-light text-gray-600 hover:text-red-500 me-2">
                            <img id="heart-icon" src="heart.svg" alt="Like" class="w-6 h-6">
                        </button>
                        <span id="like-counter" class="text-gray-600">0</span>
                    </div>
                </div>

                <!-- Comment Section (Hidden by default) -->
                <div class="p-4 border-top d-none">
                    <h6 class="mb-3">Comments</h6>
                    <div class="d-flex mb-3">
                        <input id="comment-input" type="text" class="form-control me-2"
                            placeholder="Add a comment..." maxlength="200">
                        <button id="add-comment" class="btn btn-primary">Post</button>
                    </div>
                    <ul id="comment-list" class="list-unstyled">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
            const likeButton = document.getElementById('like-button');
            const heartIcon = document.getElementById('heart-icon');
            const likeCounter = document.getElementById('like-counter');
            let likeCount = 0;

            likeButton.addEventListener('click', () => {
                if (heartIcon.getAttribute('src').includes('heart-fill.svg')) {
                    heartIcon.setAttribute('src', 'heart.svg');
                    likeCount--;
                } else {
                    heartIcon.setAttribute('src', 'heart-fill.svg');
                    likeCount++;
                }
                likeCounter.textContent = likeCount;
            });

            // Comment section toggle functionality
            const commentInputContainer = document.querySelector('.border-top');
            const chatDotsButton = document.querySelector('button.btn-light img[alt="Comment"]');

            chatDotsButton.addEventListener('click', () => {
                commentInputContainer.classList.toggle('d-none');
            });

            // Comment section functionality
            const commentInput = document.getElementById('comment-input');
            const addCommentButton = document.getElementById('add-comment');
            const commentList = document.getElementById('comment-list');

            addCommentButton.addEventListener('click', () => {
                const commentText = commentInput.value.trim();
                if (commentText) {
                    const commentItem = document.createElement('li');
                    commentItem.className = 'd-flex align-items-start mb-3';
                    commentItem.innerHTML = `
                        <img src="girl2.jpg" alt="User" class="rounded-circle me-3 comment-profile-picture" data-username="SweetLimee" style="width: 40px; height: 40px; cursor: pointer;">
                        <div>
                            <p class="mb-1"><strong>SweetLimee:</strong> ${commentText}</p>
                            <small class="text-muted">Just now</small>
                        </div>
                    `;
                    commentList.appendChild(commentItem);
                    commentInput.value = '';
                } else {
                    alert('Please enter a comment.');
                }
            });

            // Dynamic modal for profile pictures
            const profilePicModal = document.getElementById('profilePicModal');
            const profilePicModalImg = profilePicModal.querySelector('.modal-body img');
            const profilePicModalUsername = profilePicModal.querySelector('.fw-bold');
            const profilePicModalDescription = profilePicModal.querySelector('.text-muted');

            // Poster Profile Picture
            const posterProfilePic = document.getElementById('profile-pic');
            posterProfilePic.addEventListener('click', () => {
                profilePicModalImg.setAttribute('src', 'girl.jpg');
                profilePicModalUsername.textContent = "Hi, I'm L0v3lyy";
                profilePicModalDescription.textContent = "Loving cute moments and sharing them with the world 🐾";
            });

            // Commenter Profile Pictures
            commentList.addEventListener('click', (event) => {
                if (event.target.classList.contains('comment-profile-picture')) {
                    const username = event.target.getAttribute('data-username');
                    const imageUrl = event.target.getAttribute('src');

                    profilePicModalImg.setAttribute('src', imageUrl);
                    profilePicModalUsername.textContent = `Hi, I'm ${username}`;
                    profilePicModalDescription.textContent = `This is ${username}'s profile!`;

                    const modal = new bootstrap.Modal(profilePicModal);
                    modal.show();
                }
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