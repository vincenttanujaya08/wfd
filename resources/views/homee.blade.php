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
        padding: 2rem;
        box-sizing: border-box;
        background: #111;
    }

    /* Responsif Layout Postingan */
    #userPostsContainer {
        display: grid;
        gap: 2rem;
        grid-template-columns: 1fr; /* Default 1 kolom */
    }

    @media (min-width: 768px) {
        #userPostsContainer {
            grid-template-columns: repeat(2, 1fr); /* ≥768px: 2 kolom */
        }
    }

    @media (min-width: 1024px) {
        #userPostsContainer {
            grid-template-columns: repeat(3, 1fr); /* ≥1024px: 3 kolom */
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

    .post-image {
        background: #999;
        width: 100%;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #000;
        font-weight: bold;
        font-size:1rem;
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

    /* Modal tanpa scroll internal */
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
    #editCaption{
        margin-right: 30px;
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
        <div id="userPostsContainer"></div>
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
            <textarea id="editCaption"></textarea>
        </div>
        <div class="modal-actions">
            <button id="cancelEditBtn">Cancel</button>
            <button id="saveEditBtn">Save</button>
        </div>
    </div>
</div>

<script>
function randomLikes(){
    return Math.floor(Math.random()*500);
}

let userPosts = [
    {
        id:1,
        user:"LoggedUser",
        time:"30h",
        desc:"My first post, just checking things out!",
        edited:false,
        comments: [{user:"Friend", text:"Nice!", time:"2m"}],
        likes:randomLikes(),
        image:"https://img.pikbest.com/origin/09/42/37/23apIkbEsTiRD.jpg!w700wp"
    },
    {
        id:2,
        user:"LoggedUser",
        time:"12h",
        desc:"Another day, another post",
        edited:true,
        comments:[],
        likes:randomLikes(),
        image:"https://img.pikbest.com/origin/09/42/37/23apIkbEsTiRD.jpg!w700wp"
    }
];

const container = document.getElementById('userPostsContainer');
userPosts.forEach(p=>{
    container.appendChild(createPostElement(p));
});

let currentEditPost = null;

function createPostElement(post){
    const card = document.createElement('div');
    card.classList.add('post-card');
    card.dataset.postId = post.id;

    const header = document.createElement('div');
    header.classList.add('post-header');
    header.innerHTML = `
        <div class="username">${post.user}</div>
        <div class="time">${post.time}</div>
        <div class="menu-btn">⋮</div>
    `;
    card.appendChild(header);

    const imgDiv = document.createElement('div');
    imgDiv.classList.add('post-image');
    imgDiv.textContent = "Image here";
    card.appendChild(imgDiv);

    const footer = document.createElement('div');
    footer.classList.add('post-footer');

    const desc = document.createElement('div');
    desc.classList.add('description');
    desc.textContent = post.desc;
    if(post.edited){
        const editedSpan = document.createElement('span');
        editedSpan.classList.add('edited');
        editedSpan.textContent = "(Edited)";
        desc.appendChild(editedSpan);
    }
    footer.appendChild(desc);

    const actions = document.createElement('div');
    actions.classList.add('actions');

    const editBtn = document.createElement('button');
    editBtn.textContent="Edit";
    editBtn.addEventListener('click', ()=>openEditModal(post, card));

    const deleteBtn = document.createElement('button');
    deleteBtn.textContent="Delete";
    deleteBtn.style.background='#800';
    deleteBtn.addEventListener('click', ()=>deletePost(post, card));

    actions.appendChild(editBtn);
    actions.appendChild(deleteBtn);
    footer.appendChild(actions);

    card.appendChild(footer);

    return card;
}

function openEditModal(post, card){
    currentEditPost = {post:post, card:card};
    const editModal = document.getElementById('editModal');
    const editCaption = document.getElementById('editCaption');
    editCaption.value = post.desc;
    editModal.classList.add('show');
}

function deletePost(post, card){
    if(confirm("Are you sure want to delete this post?")){
        userPosts = userPosts.filter(p=>p.id!==post.id);
        card.remove();
    }
}

function saveEdit(){
    const editModal = document.getElementById('editModal');
    const editCaption = document.getElementById('editCaption');
    const newCaption = editCaption.value.trim();
    const {post, card} = currentEditPost;

    // Cek apakah berubah
    if(newCaption!=='' && newCaption!==post.desc){
        post.desc = newCaption;
        post.edited = true;
        updatePostUI(card, post);
    }
    editModal.classList.remove('show');
    currentEditPost = null;
}

function cancelEdit(){
    const editModal = document.getElementById('editModal');
    editModal.classList.remove('show');
    currentEditPost = null;
}

function updatePostUI(card, post){
    const desc = card.querySelector('.description');
    desc.textContent = post.desc;
    if(post.edited){
        const editedSpan = document.createElement('span');
        editedSpan.classList.add('edited');
        editedSpan.textContent = "(Edited)";
        desc.appendChild(editedSpan);
    }
}

// Modal events
document.getElementById('saveEditBtn').addEventListener('click', saveEdit);
document.getElementById('cancelEditBtn').addEventListener('click', cancelEdit);
document.getElementById('closeModalBtn').addEventListener('click', cancelEdit);
</script>
@endsection
