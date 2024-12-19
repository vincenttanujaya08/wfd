@extends('layouts.template')

@section('content')
<style>
    /* Existing CSS */
    html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        background: #111;
        font-family: sans-serif;
        color: #ccc;
    }

    .content-wrapper {
        display: flex;
        width: 100%;
        min-height: 100vh; 
        box-sizing: border-box;
        background: #111; 
    }

    .main-content {
        flex: 1;
        padding: 2rem;
        box-sizing: border-box;
        background: #111;
    }

    .upload-form-container {
        max-width: 500px;
        margin: 0 auto;
        background: #222;
        padding: 2rem;
        border-radius: 8px;
        border: 1px solid #333;
    }

    .upload-form-container h2 {
        margin-top: 0;
        margin-bottom: 1.5rem;
        color: #ccc;
        font-size: 1.3rem;
        text-align: center;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        color: #ccc;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-group input[type="text"],
    .form-group textarea {
        width: 100%;
        padding: 0.5rem;
        background: #333;
        color: #ccc;
        border: 1px solid #444;
        border-radius: 4px;
        font-size: 0.9rem;
    }

    .form-group input[type="text"]:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #555;
    }

    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }

    .submit-btn {
        display: block;
        width: 100%;
        background: #444;
        color: #ccc;
        border: none;
        padding: 0.75rem;
        font-size: 1rem;
        border-radius: 4px;
        cursor: pointer;
        text-align: center;
        margin-top: 1.5rem;
    }

    .submit-btn:hover {
        background: #555;
    }

    /* Suggestion box for topics */
    .topic-suggestions {
        background: #333;
        border: 1px solid #444;
        border-radius: 4px;
        margin-top: 0.5rem;
        padding: 0.5rem;
        position: absolute;
        width: calc(100% - 1rem);
        box-sizing: border-box;
        z-index: 999;
        max-height: 200px;
        overflow-y: auto;
        display: none; /* Hidden by default */
    }

    .topic-suggestions .suggestion {
        padding: 0.5rem;
        cursor: pointer;
        font-size: 0.9rem;
        color: #ccc;
    }

    .topic-suggestions .suggestion:hover {
        background: #444;
    }

    .no-results {
        font-size:0.9rem;
        color:#ccc;
        padding:0.5rem;
    }

    .no-results:hover {
        background:#444;
        cursor:pointer;
    }

    @media (max-width: 768px) {
        .main-content {
            padding: 1rem;
        }

        .upload-form-container {
            padding: 1rem;
        }
    }

    .image-url-group {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .image-url-group input[type="text"] {
        flex: 1;
        margin-right: 0.5rem;
    }

    .remove-link-btn {
        background: #ff4d4d;
        border: none;
        color: #fff;
        padding: 0.5rem 0.75rem;
        border-radius: 4px;
        cursor: pointer;
    }

    .remove-link-btn:hover {
        background: #ff1a1a;
    }

    .add-image-btn {
        background: #28a745;
        border: none;
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
    }

    .add-image-btn:hover {
        background: #218838;
    }

    /* Flash Messages */
    .alert {
        padding: 1rem;
        border-radius: 4px;
        margin-top: 1rem;
        width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .alert-success {
        background-color: #28a745;
        color: #fff;
    }

    .alert-danger {
        background-color: #dc3545;
        color: #fff;
    }
</style>

<div class="content-wrapper">
    <!-- Removed Sidebar -->

    <!-- Main Content -->
    <div class="main-content">
        <!-- Upload Form -->
        <div class="upload-form-container">
            <h2>Upload New Post</h2>
            <form action="{{ route('posts.store') }}" method="POST" id="postForm">
                @csrf

                <!-- Caption -->
                <div class="form-group">
                    <label for="description">Caption</label>
                    <textarea name="description" id="description" placeholder="Write something..." required>{{ old('description') }}</textarea>
                </div>

                <!-- Topic -->
                <div class="form-group" style="position:relative;">
                    <label for="topicInput">Topic</label>
                    <input type="text" name="topic" id="topicInput" placeholder="Type topic..." autocomplete="off" value="{{ old('topic') }}">

                    <!-- Suggestion box -->
                    <div id="topicSuggestions" class="topic-suggestions"></div>
                </div>

                <!-- Image Links -->
                <div class="form-group">
                    <label>Image Links (min 1, max 5)</label>
                    <div id="imageLinksContainer">
                        <div class="image-url-group">
                            <input type="text" name="image_links[]" placeholder="Enter image URL..." required>
                            <button type="button" class="remove-link-btn" onclick="removeImageLink(this)">Remove</button>
                        </div>
                    </div>
                    <button type="button" class="add-image-btn" id="addImageLinkBtn" style="margin-top: 0.5rem;">Add Image Link</button>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Post</button>
            </form>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Handling dynamic addition/removal of image link fields
    const imageLinksContainer = document.getElementById('imageLinksContainer');
    const addImageLinkBtn = document.getElementById('addImageLinkBtn');

    // Add new image link field
    addImageLinkBtn.addEventListener('click', () => {
        const currentFields = imageLinksContainer.querySelectorAll('.image-url-group').length;

        if (currentFields >= 5) {
            alert('You can add up to 5 image links only.');
            return;
        }

        const div = document.createElement('div');
        div.classList.add('image-url-group');
        div.innerHTML = `
            <input type="text" name="image_links[]" placeholder="Enter image URL..." required>
            <button type="button" class="remove-link-btn" onclick="removeImageLink(this)">Remove</button>
        `;
        imageLinksContainer.appendChild(div);
    });

    // Remove specific image link field
    function removeImageLink(button) {
        const currentFields = imageLinksContainer.querySelectorAll('.image-url-group').length;

        if (currentFields <= 1) {
            alert('You must have at least one image link.');
            return;
        }

        button.parentElement.remove();
    }

    // Topic Suggestions via AJAX
    let topicTimeout = null; // To debounce AJAX requests
    const topicInput = document.getElementById('topicInput');
    const topicSuggestions = document.getElementById('topicSuggestions');

    topicInput.addEventListener('input', () => {
        const query = topicInput.value.trim();

        // Clear any existing timeout to debounce
        if (topicTimeout) {
            clearTimeout(topicTimeout);
        }

        if (query.length === 0) {
            topicSuggestions.style.display = 'none';
            return;
        }

        // Debounce AJAX request by 300ms
        topicTimeout = setTimeout(() => {
            fetch(`/topics/search?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    // Clear previous suggestions
                    while(topicSuggestions.firstChild){
                        topicSuggestions.removeChild(topicSuggestions.firstChild);
                    }

                    if(data.length > 0){
                        data.forEach(topic => {
                            const div = document.createElement('div');
                            div.classList.add('suggestion');
                            div.textContent = topic.name;
                            div.addEventListener('click', () => {
                                topicInput.value = topic.name;
                                topicSuggestions.style.display = 'none';
                            });
                            topicSuggestions.appendChild(div);
                        });
                    } else {
                        // No results, show option to add new topic
                        const noRes = document.createElement('div');
                        noRes.classList.add('no-results');
                        noRes.textContent = `No results. Add "${query}" as a new topic?`;
                        noRes.addEventListener('click', () => {
                            topicInput.value = query;
                            topicSuggestions.style.display = 'none';
                        });
                        topicSuggestions.appendChild(noRes);
                    }

                    topicSuggestions.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching topics:', error);
                    topicSuggestions.style.display = 'none';
                });
        }, 300); // 300ms debounce
    });

    // Close suggestion box when clicking outside
    document.addEventListener('click', (event) => {
        if (!topicInput.contains(event.target) && !topicSuggestions.contains(event.target)) {
            topicSuggestions.style.display = 'none';
        }
    });
</script>
@endsection
