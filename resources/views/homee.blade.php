@extends('layouts.template')

@section('content')
<style>
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

    #userPostsContainer {
        display: grid;
        gap: 2rem;
        grid-template-columns: 1fr;
    }

    @media (min-width: 768px) {
        #userPostsContainer {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1024px) {
        #userPostsContainer {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .post-card {
        background: #222;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #333;
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

    .post-image {
        position: relative;
        width: 100%;
        padding-top: 100%;
        overflow: hidden;
        background: #999;
        cursor: pointer; /* Menambahkan pointer untuk gambar */
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
        font-size: 0.9rem;
    }

    .post-footer .description .edited {
        color: #888;
        font-size: 0.8rem;
        margin-left: 0.3rem;
    }

    .post-footer .actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        color: #ccc;
        font-size: 0.9rem;
        gap: 0.5rem;
    }

    .actions button {
        background: #444;
        color: #ccc;
        border: none;
        padding: 0.3rem 0.5rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.8rem;
    }

    .actions button:hover {
        background: #555;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
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
        width: 90%;
        max-width: 900px;
        padding: 1rem;
        display: flex;
        flex-direction: row;
        color: #ccc;
        gap: 1rem;
    }

    .modal-image {
        flex: 2;
        background: #333;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .modal-details {
        flex: 3;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .comments-container,
    .likes-container {
        max-height: 120px;
        overflow-y: auto;
        padding: 0.5rem;
        border: 1px solid #333;
        border-radius: 4px;
        background: #111;
        margin-top: 1rem;
    }

    .comments-container table {
        width: 100%;
        border-collapse: collapse;
        color: #ccc;
    }

    .comments-container th, .comments-container td {
        border: 1px solid #444;
        padding: 0.5rem;
        text-align: left;
        vertical-align: top;
    }

    .likes-container ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .likes-container li {
        margin-bottom: 0.5rem;
    }

    .hide-comment-btn {
        background: #444;
        color: #ccc;
        border: none;
        padding: 0.3rem 0.5rem;
        border-radius: 4px;
        cursor: pointer;
    }

    .hide-comment-btn:hover {
        background: #555;
    }

    @media (max-width: 768px) {
        .modal {
            flex-direction: column;
        }
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
                            <img src="{{ $post->images->first()->path }}" alt="Post Image" class="image-modal-trigger">
                        @else
                            <div class="no-image image-modal-trigger">No Image</div>
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

<div class="modal-overlay" id="postModalOverlay">
    <div class="modal">
        <div class="modal-image" id="postModalImage"></div>
        <div class="modal-details">
            <div>
                <button id="closePostModal" style="background:#800; color:#fff; border:none; padding:0.5rem; border-radius:4px; cursor:pointer;">Close</button>
            </div>
            <div class="comments-container">
                <h4>Comments</h4>
                <table>
                    <tbody id="commentsList"></tbody>
                </table>
            </div>
            <div class="likes-container">
                <h4>Likes</h4>
                <ul id="likesList"></ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalOverlay = document.getElementById('postModalOverlay');
    const modalImage = document.getElementById('postModalImage');
    const commentsList = document.getElementById('commentsList');
    const likesList = document.getElementById('likesList');
    const closePostModal = document.getElementById('closePostModal');

    document.querySelectorAll('.image-modal-trigger').forEach(image => {
        image.addEventListener('click', (e) => {
            e.stopPropagation(); // Mencegah event bubbling
            const card = image.closest('.post-card');
            const postId = card.getAttribute('data-post-id');
            const imageSrc = image.tagName === 'IMG' ? image.src : null;

            modalImage.innerHTML = imageSrc ? `<img src="${imageSrc}" alt="Post Image">` : '<div>No Image</div>';

            fetch(`/posts/${postId}/details`)
                .then(res => res.json())
                .then(data => {
                    commentsList.innerHTML = '';
                    if (data.comments.length > 0) {
                        data.comments.forEach(comment => {
                            commentsList.innerHTML += `
                                <tr>
                                    <td>${comment.user}</td>
                                    <td>${comment.text}</td>
                                    <td><button class="hide-comment-btn" data-id="${comment.id}">Hide</button></td>
                                </tr>
                            `;
                        });
                    } else {
                        commentsList.innerHTML = '<tr><td colspan="3" style="text-align:center; color:#888;">No comments available.</td></tr>';
                    }

                    likesList.innerHTML = '';
                    if (data.likes.length > 0) {
                        data.likes.forEach(like => {
                            likesList.innerHTML += `<li>${like.user}</li>`;
                        });
                    } else {
                        likesList.innerHTML = '<li style="text-align:center; color:#888;">No likes available.</li>';
                    }

                    modalOverlay.classList.add('show');
                });
        });
    });

    closePostModal.addEventListener('click', () => {
        modalOverlay.classList.remove('show');
    });
});
</script>
@endsection
