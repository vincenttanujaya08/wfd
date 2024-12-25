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
        
        box-sizing: border-box;
        background: #111;
    }

    /* Responsive Layout for Posts */
    #userPostsContainer {
        display: grid;
        gap: 2rem;
        grid-template-columns: 1fr; /* Default 1 column */
    }

    @media (min-width: 768px) {
        #userPostsContainer {
            grid-template-columns: repeat(2, 1fr); /* ≥768px: 2 columns */
        }
    }

    @media (min-width: 1024px) {
        #userPostsContainer {
            grid-template-columns: repeat(3, 1fr); /* ≥1024px: 3 columns */
        }
    }

    .post-card {
        background: #222;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #333;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .post-header {
        display: flex;
        align-items: center;
        padding: 0.5rem;
    }

    .post-header .username {
        font-weight: bold;
        color: #ccc;
    }

    .post-header .time {
        color: #888;
        font-size: 0.9rem;
        margin-left: 0.5rem;
    }

    .menu-btn {
        color: #ccc;
        cursor: pointer;
    }

    /* Updated CSS for maintaining aspect ratio */
    .post-image {
        position: relative;
        width: 100%;
        padding-top: 100%; /* 1:1 Aspect Ratio (persegi) */
        overflow: hidden;
        background: #999; /* Warna latar belakang untuk placeholder */
    }

    .post-image img, .post-image .no-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .post-image .no-image {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #000;
        font-weight: bold;
        font-size: 1rem;
    }

    .post-footer {
        padding: 0.5rem;
        background: #222;
        display: flex;
        flex-direction: column;
    }

    .post-footer .description {
        color: #ccc;
        margin-bottom: 0.5rem;
        word-wrap: break-word;
        font-size:0.9rem;
    }

    .post-footer .description .edited {
        color:#888;
        font-size:0.8rem;
        margin-left:0.3rem;
    }

    .post-footer .actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        color: #ccc;
        font-size: 0.9rem;
        gap:0.5rem;
    }

    .actions button {
        background:#444;
        color:#ccc;
        border:none;
        padding:0.3rem 0.5rem;
        border-radius:4px;
        cursor:pointer;
        font-size:0.8rem;
    }

    .actions button:hover {
        background:#555;
    }

    /* Modal without internal scroll */
    .modal-overlay {
        display: none;
        position: fixed;
        top:0; left:0; right:0; bottom:0;
        background: rgba(0,0,0,0.7);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal {
        background: #222;
        border: 1px solid #333;
        border-radius: 8px;
        width: 100%;
        max-width: 400px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.1rem;
        color: #ccc;
    }

    .modal-header .close-btn {
        cursor: pointer;
        color: #ccc;
        font-size: 1.5rem;
    }

    .modal-body {
        margin-bottom:1rem;
    }

    .modal-body textarea {
        width:100%;
        background:#333;
        border:1px solid #444;
        border-radius:4px;
        color:#ccc;
        padding:0.5rem;
        resize:vertical;
        min-height:100px;
    }

    .modal-actions {
        display:flex;
        justify-content:flex-end;
        gap:0.5rem;
    }

    .modal-actions button {
        background:#444;
        color:#ccc;
        border:none;
        padding:0.5rem 1rem;
        border-radius:4px;
        cursor:pointer;
        font-size:0.9rem;
    }

    .modal-actions button:hover {
        background:#555;
    }
</style>

<div class="content-wrapper">
    <div class="main-content">
        <h2>Your Posts</h2>
        <div id="userPostsContainer">
            @forelse($posts as $post)
                <div class="post-card" data-post-id="{{ $post->id }}">
                    <div class="post-header">
                        <div class="username">{{ $post->user->name }}</div>
                        <div class="time">{{ $post->created_at->diffForHumans() }}</div>
                        <div class="menu-btn">⋮</div>
                    </div>
                    <div class="post-image">
                        @if($post->images->count() > 0)
                            <img src="{{ $post->images->first()->path }}" alt="Post Image">
                        @else
                            <div class="no-image">
                                No Image
                            </div>
                        @endif
                    </div>
                    <div class="post-footer">
                        <div class="description">
                            {{ $post->description }}
                            @if($post->edited)
                                <span class="edited">(Edited)</span>
                            @endif
                        </div>
                        <div class="actions">
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn" style="background:#800;">Delete</button>
                        </div>
                    </div>
                </div>
            @empty
                <p>You have not created any posts yet.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Edit Post</h3>
            <div class="close-btn" id="closeModalBtn">&times;</div>
        </div>
        <div class="modal-body">
            <textarea id="editCaption" placeholder="Edit your caption..."></textarea>
        </div>
        <div class="modal-actions">
            <button id="cancelEditBtn">Cancel</button>
            <button id="saveEditBtn">Save</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editModal = document.getElementById('editModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const saveEditBtn = document.getElementById('saveEditBtn');
        const editCaption = document.getElementById('editCaption');
        let currentEditPostId = null;
        let currentEditCard = null;

        // Open Edit Modal
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const card = e.target.closest('.post-card');
                const postId = card.getAttribute('data-post-id');
                const description = card.querySelector('.description').innerText.replace('(Edited)', '').trim();

                currentEditPostId = postId;
                currentEditCard = card;
                editCaption.value = description;
                editModal.classList.add('show');
            });
        });

        // Close Modal Functions
        const closeModal = () => {
            editModal.classList.remove('show');
            currentEditPostId = null;
            currentEditCard = null;
            editCaption.value = '';
        };

        closeModalBtn.addEventListener('click', closeModal);
        cancelEditBtn.addEventListener('click', closeModal);

        // Save Edited Caption
        saveEditBtn.addEventListener('click', () => {
            const newDescription = editCaption.value.trim();

            if(newDescription === '') {
                alert('Caption cannot be empty.');
                return;
            }

            // Send AJAX request to update the caption
            fetch(`/posts/${currentEditPostId}/edit`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ description: newDescription })
            })
            .then(response => {
                if(response.ok){
                    return response.json();
                } else {
                    throw new Error('Failed to update the post.');
                }
            })
            .then(data => {
                // Update the caption in the UI
                const descDiv = currentEditCard.querySelector('.description');
                descDiv.textContent = data.description;
                // Append "(Edited)" if not already present
                if(!descDiv.innerHTML.includes('(Edited)')){
                    const editedSpan = document.createElement('span');
                    editedSpan.classList.add('edited');
                    editedSpan.textContent = ' (Edited)';
                    descDiv.appendChild(editedSpan);
                }
                // Close the modal
                closeModal();
            })
            .catch(error => {
                console.error(error);
                alert('An error occurred while updating the post.');
            });
        });

        // Delete Post
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const card = e.target.closest('.post-card');
                const postId = card.getAttribute('data-post-id');

                if(confirm('Are you sure you want to delete this post?')){
                    // Send AJAX request to delete the post
                    fetch(`/posts/${postId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if(response.ok){
                            return response.json();
                        } else {
                            throw new Error('Failed to delete the post.');
                        }
                    })
                    .then(data => {
                        // Remove the post card from the UI
                        card.remove();
                        alert(data.message);
                    })
                    .catch(error => {
                        console.error(error);
                        alert('An error occurred while deleting the post.');
                    });
                }
            });
        });
    });
</script>
@endsection
