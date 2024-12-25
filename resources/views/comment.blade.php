<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        .container {
            display: flex;
            flex-direction: row;
            width: 100%;
        }

        .post-container {
            flex: 1;
            max-width: 40%;
            padding: 1rem;
        }

        .comments-container {
            flex: 2;
            padding: 1rem;
            overflow-y: auto;
            border-left: 1px solid #ccc;
        }

        .post-image-container img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .comment-input-container {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Post Container -->
        <div class="post-container">
            <div class="post bg-gray-100">
                <div class="d-flex align-items-center">
                    <img class="profile-picture user-profile-pic" src="https://newprofilepic.photo-cdn.net//assets/images/article/profile.jpg?90af0c8" alt="Profile Picture"
                        data-bs-toggle="modal" data-bs-target="#profilePicModal" data-username="L0v3lyy" data-description="Loving cute moments and sharing them with the world 🐾" style="width: 50px; height: 50px; border-radius: 50%;">
                    <div class="ms-3">
                        <h5 class="mb-1">L0v3lyy</h5>
                        <p class="mb-0 text-muted">Posted 1 hour ago</p>
                    </div>
                </div>
                <div class="post-image-container mt-3">
                    <img src="https://cdn.pixabay.com/photo/2024/02/28/07/42/european-shorthair-8601492_640.jpg" alt="Post Image">
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
            </div>
        </div>

        <!-- Comments Container -->
        <div class="comments-container">
            <h5>Comments</h5>
            <div class="comment-input-container">
                <input type="text" class="comment-input form-control" placeholder="Add a comment..." maxlength="200">
                <button class="add-comment btn btn-primary">Post</button>
            </div>
            <ul class="comment-list list-unstyled">
                <!-- Example Comments -->
                <li class="mb-3"><strong>User1:</strong> Wow, such cute cats!</li>
                <li class="mb-3"><strong>User2:</strong> I can’t handle the cuteness 😍</li>
                <li class="mb-3"><strong>User3:</strong> These cats made my day!</li>
                <li class="mb-3"><strong>User4:</strong> Aww, they are so lovely!</li>
                <li class="mb-3"><strong>User5:</strong> Where did you find these cats?</li>
                <li class="mb-3"><strong>User6:</strong> Absolutely adorable!</li>
                <li class="mb-3"><strong>User7:</strong> I want to adopt one 😭</li>
                <li class="mb-3"><strong>User8:</strong> Best post ever!</li>
                <li class="mb-3"><strong>User9:</strong> Cats are life ❤️</li>
                <li class="mb-3"><strong>User10:</strong> Amazing photo!</li>
                <li class="mb-3"><strong>User11:</strong> I can’t stop looking at them 😍</li>
                <li class="mb-3"><strong>User12:</strong> This made my day better!</li>
                <li class="mb-3"><strong>User13:</strong> What a lovely moment!</li>
                <li class="mb-3"><strong>User14:</strong> Cats are the best companions!</li>
                <li class="mb-3"><strong>User15:</strong> OMG, so cute!</li>
                <li class="mb-3"><strong>User16:</strong> They look so happy together!</li>
                <li class="mb-3"><strong>User17:</strong> Can’t stop smiling 😊</li>
                <li class="mb-3"><strong>User18:</strong> Adorable and perfect!</li>
                <li class="mb-3"><strong>User19:</strong> Love this post ❤️</li>
                <li class="mb-3"><strong>User20:</strong> My heart melted 😭</li>
            </ul>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
