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
        background: #111; 
        box-sizing: border-box;
    }

    .main-feed {
        flex: 1; 
        display: flex;
        flex-direction: column;
        padding: 1rem;
        background: #111;
        box-sizing: border-box;
    }

    .feed-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .feed-header h2 {
        margin: 0;
        font-size: 1.2rem;
        color: #ccc;
    }

    .feed-header select {
        background: #333;
        color: #ccc;
        border: none;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        cursor: pointer;
    }

    .divider {
        width: 100%;
        height: 1px;
        background: #333;
        margin: 0.75rem 0 1rem 0;
    }

    /* Grid layout posts: 1 col <768px, 2 col ≥768px, 3 col ≥1024px */
    #postContainer {
        display: grid;
        gap: 2rem;
        grid-template-columns: 1fr; 
    }

    @media (min-width: 768px) {
        #postContainer {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1024px) {
        #postContainer {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .post-card {
        background: #222;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #333;
        position: relative;
    }

    .post-header {
        display: flex;
        align-items: center;
        padding: 0.5rem;
    }

    /* Avatar dihilangkan, hanya username dan waktu */
    .post-header .username {
        font-weight: bold;
        color: #ccc;
    }

    .post-header .time {
        color: #888;
        font-size: 0.9rem;
        margin-left: 0.5rem;
    }

    .post-header .menu-btn {
        margin-left: auto; 
        color: #ccc; 
        cursor: pointer;
    }

    /* Slider Container */
    .image-slider {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .image-slider img {
        width: 100%;
        display: none;
        object-fit: cover;
    }

    .image-slider img.active {
        display: block;
    }

    /* Prev/Next button */
    .slider-btn {
        position: absolute;
        top:50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.3);
        color: #fff;
        padding:0.5rem;
        border-radius:50%;
        cursor:pointer;
        font-size:1.2rem;
        user-select:none;
    }

    .slider-btn:hover {
        background: rgba(0,0,0,0.5);
    }

    .slider-prev {
        left: 0.5rem;
    }

    .slider-next {
        right:0.5rem;
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
    }

    .post-footer .actions {
        display: flex;
        align-items: center;
        color: #ccc;
        font-size: 0.9rem;
    }

    .post-footer .actions i {
        margin-right: 0.25rem;
    }

    .post-footer .actions span {
        margin-right: 1rem;
        cursor: pointer;
    }

    .post-footer .actions span.liked i {
        color: red; 
    }

    .sidebar-right {
        background: #111;
        border-left: 1px solid #333;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        padding: 1rem;
        width: 300px; 
        flex-shrink: 0;
    }

    .search-box-container {
        margin-bottom:1.5rem;
    }

    .search-box-container h4 {
        margin:0 0 0.5rem 0;
        font-size:1rem;
        color:#ccc;
    }

    .search-box {
        background: #000;
        display: flex;
        align-items: center;
        padding: 0.5rem;
        border-radius: 4px;
    }

    .search-box input {
        flex: 1;
        background: none;
        border: none;
        color: #ccc;
        margin-right: 0.5rem;
    }

    .search-box input:focus {
        outline: none;
    }

    .search-box i {
        color: #ccc;
        cursor: pointer;
    }

    .sidebar-section {
        background: #000;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid #333;
    }

    .sidebar-section h3 {
        margin-top: 0;
        margin-bottom: 1rem;
        font-size: 1rem;
        color: #ccc;
    }

    .sidebar-section a {
        color: #ccc;
        text-decoration: none;
        display: block;
        margin-bottom: 0.5rem;
    }

    .sidebar-section a.hide {
        display:none;
    }

    .sidebar-section a:hover {
        text-decoration: underline;
    }

    .sidebar-section .see-more {
        display: flex;
        align-items:center;
        justify-content:space-between;
        margin-top:0.5rem;
    }

    .see-more-btn {
        background:#222;
        color:#ccc;
        padding:0.25rem 0.5rem;
        border-radius:4px;
        cursor:pointer;
        border:1px solid #333;
        font-size:0.9rem;
    }

    .see-more-btn.disabled {
        opacity:0.5;
        cursor:default;
    }

    .reset-btn {
        background:#333;
        color:#ccc;
        padding:0.25rem 0.5rem;
        border-radius:4px;
        border:1px solid #444;
        font-size:0.9rem;
        cursor:pointer;
        margin-left:0.5rem;
    }

    .no-more {
        color:#888;
    }

    .see-more-posts-container {
        text-align:center;
        margin-top: 20px;
    }

    .see-more-posts-container .see-more-btn {
        margin-top:1rem;
    }

    @media (max-width: 992px) and (min-width: 768px) {
        .sidebar-right {
            width: 250px; 
        }
    }

    @media (max-width: 768px) {
        .content-wrapper {
            flex-direction: column;
        }

        .sidebar-right {
            width: 100%;
            border-left: none;
            border-top: 1px solid #333;
            order: 1; 
        }

        .main-feed {
            order: 2; 
        }

        .post-card {
            max-width: 100%;
        }
    }

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
        width: 90%;
        max-width: 400px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        max-height: 80vh;
        overflow-y: auto;
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

    .comment-list {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .comment-item {
        background: #333;
        padding: 0.5rem;
        border-radius: 4px;
    }

    .comment-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
    }

    .comment-user {
        font-weight: bold;
        color: #ddd;
    }

    .comment-time {
        color: #aaa;
        font-size: 0.75rem;
    }

    .comment-text {
        font-size: 0.9rem;
        color: #ccc;
        line-height: 1.2;
    }

    .comment-form {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .comment-form input {
        flex: 1;
        background: #000;
        border: 1px solid #444;
        color: #ccc;
        border-radius: 4px;
        padding: 0.5rem;
    }

    .comment-form button {
        background: #444;
        border: none;
        color: #ccc;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
    }

    .comment-form button:hover {
        background: #555;
    }

   
</style>

<div class="content-wrapper">
    <div class="main-feed">
        <div class="feed-header">
            <h2>Newest</h2>
            <select>
                <option>Newest</option>
                <option>Popular</option>
                <option>Trending</option>
            </select>
        </div>
        <div class="divider"></div>

        <div id="postContainer"></div>
        <div class="see-more-posts-container">
            <span class="see-more-btn" id="seeMorePostsBtn">See More Posts</span>
            <span class="reset-btn" id="resetPostsBtn" style="display:none;">Reset</span>
        </div>

    </div>

    <div class="sidebar-right">
        <div class="search-box-container">
            <h4>Search Topics</h4>
            <div class="search-box">
                <input type="text" placeholder="Search topics..." id="searchTopicsInput"/>
                <i class="lni lni-search-alt"></i>
            </div>
        </div>

        <div class="sidebar-section">
            <h3>TOPICS</h3>
            <div id="topicContainer"></div>
            <div class="see-more">
                <span class="see-more-btn" id="seeMoreTopicsBtn">See More</span>
                <span class="reset-btn" id="resetTopicsBtn" style="display:none;">Reset</span>
            </div>
        </div>

        <div class="search-box-container">
            <h4>Search Profiles</h4>
            <div class="search-box">
                <input type="text" placeholder="Search profiles..." id="searchProfilesInput"/>
                <i class="lni lni-search-alt"></i>
            </div>
        </div>

        <div class="sidebar-section profile-list">
            <h3>PROFILE</h3>
            <div id="profileContainer"></div>
            <div class="see-more">
                <span class="see-more-btn" id="seeMoreProfileBtn">See More</span>
                <span class="reset-btn" id="resetProfileBtn" style="display:none;">Reset</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Overlay -->
<div class="modal-overlay" id="commentModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Comments</h3>
            <div class="close-btn" id="closeModal">&times;</div>
        </div>
        <div class="comment-list" id="commentList"></div>
        <form class="comment-form" id="commentForm">
            <input type="text" placeholder="Add a comment..." />
            <button type="submit">Post</button>
        </form>
    </div>
</div>

<script>
// Data, fungsi-fungsi, logika sama seperti sebelumnya, tapi hilangkan kode avatar di JS juga, 
// (avatar bukan mandatory, hanya di CSS sudah dihilangkan?), di HTML pun sudah tidak ada avatar HTML-nya.
// Pastikan randomLikes() didefinisikan:
// Fungsi untuk menghasilkan jumlah like secara acak
function randomLikes(max = 1000) {
    return Math.floor(Math.random() * max);
}

// Array contoh nama pengguna
const users = ["L0v3lyy", "User2", "JohnDoe", "Jane", "UserX", "Someone", "User3", "User4", "User5"];

// Array contoh deskripsi
const descriptions = [
    "Dumbass looking cat...",
    "Some random post...",
    "Beautiful scenery!",
    "Had a great day at the beach.",
    "Check out my new artwork.",
    "Loving this weather!",
    "Can't believe this happened.",
    "Throwback to last summer.",
    "Enjoying my coffee ☕️"
];

// Array contoh URL gambar (gunakan berbagai URL gambar yang berbeda)
const imageUrls = [
    "https://via.placeholder.com/600x400/FF5733/ffffff?text=Image1",
    "https://via.placeholder.com/600x400/33FF57/ffffff?text=Image2",
    "https://via.placeholder.com/600x400/3357FF/ffffff?text=Image3",
    "https://via.placeholder.com/600x400/FF33A1/ffffff?text=Image4",
    "https://via.placeholder.com/600x400/A133FF/ffffff?text=Image5",
    "https://via.placeholder.com/600x400/33FFA1/ffffff?text=Image6",
    "https://via.placeholder.com/600x400/FFA133/ffffff?text=Image7",
    "https://via.placeholder.com/600x400/33A1FF/ffffff?text=Image8",
    "https://via.placeholder.com/600x400/A1FF33/ffffff?text=Image9"
];

// Array contoh nama pengguna untuk komentar
const commentUsers = ["JohnDoe", "Jane", "UserX", "Someone", "User3", "User4"];

// Array contoh teks komentar
const commentTexts = [
    "Wow, cute!",
    "LOL 😂",
    "Nice post!",
    "Where is this?",
    "Amazing!",
    "So cool!",
    "Love this!",
    "Great shot!",
    "Beautiful!"
];

// Fungsi untuk menghasilkan komentar secara acak
function generateComments() {
    const comments = [];
    const numComments = Math.floor(Math.random() * 5); // Maksimal 5 komentar
    for (let i = 0; i < numComments; i++) {
        comments.push({
            user: commentUsers[Math.floor(Math.random() * commentUsers.length)],
            text: commentTexts[Math.floor(Math.random() * commentTexts.length)],
            time: `${Math.floor(Math.random() * 60)}m` // waktu komentar dalam menit
        });
    }
    return comments;
}

// Fungsi untuk memilih gambar secara acak
function generateImages() {
    const images = [];
    const numImages = Math.floor(Math.random() * 5) + 1; // 1 hingga 3 gambar per post
    for (let i = 0; i < numImages; i++) {
        const randomIndex = Math.floor(Math.random() * imageUrls.length);
        images.push(imageUrls[randomIndex]);
    }
    return images;
}

// Fungsi untuk menghasilkan postingan
function generatePosts(totalPosts = 50) {
    const posts = [];
    for (let i = 1; i <= totalPosts; i++) {
        const post = {
            id: i,
            user: users[Math.floor(Math.random() * users.length)],
            time: `${Math.floor(Math.random() * 24)}h`, // waktu posting dalam jam
            desc: descriptions[Math.floor(Math.random() * descriptions.length)],
            liked: Math.random() < 0.5, // true atau false secara acak
            comments: generateComments(),
            likes: randomLikes(),
            images: generateImages()
        };
        posts.push(post);
    }
    return posts;
}

// Menghasilkan data postingan
let allPosts = generatePosts(100); // Ganti angka 100 dengan jumlah postingan yang diinginkan



// Topics & Profiles
let allTopics = ["#TOPICsearch1","#TOPICSATU","#HELLO","#WORLD"];
let allProfiles = ["L0v3lyy","User2","CoolGuy","AnotherUser"];

const chunkSize = 3; 

// Pagination vars
let postIndex = 0; 
const postContainer = document.getElementById('postContainer');
const seeMorePostsBtn = document.getElementById('seeMorePostsBtn');
const resetPostsBtn = document.getElementById('resetPostsBtn');

let topicIndex = 0; 
const topicContainer = document.getElementById('topicContainer');
const seeMoreTopicsBtn = document.getElementById('seeMoreTopicsBtn');
const resetTopicsBtn = document.getElementById('resetTopicsBtn');

let profileIndex = 0; 
const profileContainer = document.getElementById('profileContainer');
const seeMoreProfileBtn = document.getElementById('seeMoreProfileBtn');
const resetProfileBtn = document.getElementById('resetProfileBtn');

const searchTopicsInput = document.getElementById('searchTopicsInput');
const searchProfilesInput = document.getElementById('searchProfilesInput');

const commentModal = document.getElementById('commentModal');
const closeModal = document.getElementById('closeModal');
const commentList = document.getElementById('commentList');
const commentForm = document.getElementById('commentForm');
let currentPostId = null;

loadMorePosts();
loadMoreTopics();
loadMoreProfiles();

seeMorePostsBtn.addEventListener('click', loadMorePosts);
resetPostsBtn.addEventListener('click', resetPosts);

seeMoreTopicsBtn.addEventListener('click', loadMoreTopics);
resetTopicsBtn.addEventListener('click', resetTopics);

seeMoreProfileBtn.addEventListener('click', loadMoreProfiles);
resetProfileBtn.addEventListener('click', resetProfiles);

searchTopicsInput.addEventListener('input', filterTopics);
searchProfilesInput.addEventListener('input', filterProfiles);

closeModal.addEventListener('click', () => {
    commentModal.classList.remove('show');
});
commentModal.addEventListener('click', (e) => {
    if(e.target===commentModal){
        commentModal.classList.remove('show');
    }
});
commentForm.addEventListener('submit', addComment);

function loadMorePosts(){
    const slice = allPosts.slice(postIndex, postIndex+chunkSize);
    slice.forEach(p => {
        const el = createPostElement(p);
        postContainer.appendChild(el);
    });
    postIndex += chunkSize;
    checkPostPagination();
}
function resetPosts(){
    postIndex = 0;
    postContainer.innerHTML = '';
    seeMorePostsBtn.textContent = "See More Posts";
    seeMorePostsBtn.classList.remove('disabled');
    seeMorePostsBtn.style.cursor='pointer';
    resetPostsBtn.style.display='none';
    seeMorePostsBtn.addEventListener('click', loadMorePosts);
    loadMorePosts();
}
function checkPostPagination(){
    if(postIndex >= allPosts.length) {
        seeMorePostsBtn.textContent = "No more";
        seeMorePostsBtn.classList.add('disabled');
        seeMorePostsBtn.style.cursor='default';
        resetPostsBtn.style.display='inline-block';
        seeMorePostsBtn.removeEventListener('click', loadMorePosts);
    } else {
        seeMorePostsBtn.textContent = "See More Posts";
        seeMorePostsBtn.classList.remove('disabled');
    }
}

function loadMoreTopics(){
    const slice = allTopics.slice(topicIndex, topicIndex+chunkSize);
    slice.forEach(t => {
        const a = document.createElement('a');
        a.href="#";
        a.textContent = t;
        topicContainer.appendChild(a);
    });
    topicIndex += chunkSize;
    checkTopicsPagination();
}
function resetTopics(){
    topicIndex = 0;
    topicContainer.innerHTML='';
    seeMoreTopicsBtn.textContent='See More';
    seeMoreTopicsBtn.classList.remove('disabled');
    seeMoreTopicsBtn.style.cursor='pointer';
    resetTopicsBtn.style.display='none';
    seeMoreTopicsBtn.addEventListener('click', loadMoreTopics);
    loadMoreTopics();
}
function checkTopicsPagination(){
    if(topicIndex>=allTopics.length){
        seeMoreTopicsBtn.textContent='No more';
        seeMoreTopicsBtn.classList.add('disabled');
        seeMoreTopicsBtn.style.cursor='default';
        resetTopicsBtn.style.display='inline-block';
        seeMoreTopicsBtn.removeEventListener('click', loadMoreTopics);
    } else {
        seeMoreTopicsBtn.textContent='See More';
        seeMoreTopicsBtn.classList.remove('disabled');
    }
}

function loadMoreProfiles(){
    const slice = allProfiles.slice(profileIndex, profileIndex+chunkSize);
    slice.forEach(pf => {
        const a = document.createElement('a');
        a.href="#";
        a.textContent = pf;
        profileContainer.appendChild(a);
    });
    profileIndex += chunkSize;
    checkProfilesPagination();
}
function resetProfiles(){
    profileIndex=0;
    profileContainer.innerHTML='';
    seeMoreProfileBtn.textContent='See More';
    seeMoreProfileBtn.classList.remove('disabled');
    seeMoreProfileBtn.style.cursor='pointer';
    resetProfileBtn.style.display='none';
    seeMoreProfileBtn.addEventListener('click', loadMoreProfiles);
    loadMoreProfiles();
}
function checkProfilesPagination(){
    if(profileIndex>=allProfiles.length){
        seeMoreProfileBtn.textContent='No more';
        seeMoreProfileBtn.classList.add('disabled');
        seeMoreProfileBtn.style.cursor='default';
        resetProfileBtn.style.display='inline-block';
        seeMoreProfileBtn.removeEventListener('click', loadMoreProfiles);
    } else {
        seeMoreProfileBtn.textContent='See More';
        seeMoreProfileBtn.classList.remove('disabled');
    }
}

function createPostElement(post){
    const card = document.createElement('div');
    card.classList.add('post-card');
    card.dataset.postId = post.id;

    const header = document.createElement('div');
    header.classList.add('post-header');
    /* Hilangkan avatar, hanya username dan waktu */
    header.innerHTML = `
        <div class="username">${post.user}</div>
        <div class="time">${post.time}</div>
        <div class="menu-btn">⋮</div>
    `;
    card.appendChild(header);

    const slider = document.createElement('div');
    slider.classList.add('image-slider');

    post.images.forEach((imgUrl, index) => {
        const img = document.createElement('img');
        img.src = imgUrl;
        if(index===0) img.classList.add('active');
        slider.appendChild(img);
    });

    if(post.images.length > 1){
        const prevBtn = document.createElement('div');
        prevBtn.classList.add('slider-btn','slider-prev');
        prevBtn.innerHTML='&#10094;';
        const nextBtn = document.createElement('div');
        nextBtn.classList.add('slider-btn','slider-next');
        nextBtn.innerHTML='&#10095;';

        prevBtn.addEventListener('click', ()=>slideImages(slider, -1));
        nextBtn.addEventListener('click', ()=>slideImages(slider, 1));

        slider.appendChild(prevBtn);
        slider.appendChild(nextBtn);
    }
    slider.addEventListener('dblclick', ()=>{
        toggleLike(post, card);
    });
    card.appendChild(slider);

    const footer = document.createElement('div');
    footer.classList.add('post-footer');

    const desc = document.createElement('div');
    desc.classList.add('description');
    desc.textContent = post.desc;
    footer.appendChild(desc);

    const actions = document.createElement('div');
    actions.classList.add('actions');
    updateActionsHTML(actions, post);
    footer.appendChild(actions);

    card.appendChild(footer);

    const commentBtn = actions.querySelector('.comment-btn');
    commentBtn.addEventListener('click', ()=>{
        currentPostId = post.id;
        showComments(post.id);
        commentModal.classList.add('show');
    });

    const likeBtn = actions.querySelector('.like-btn');
    likeBtn.addEventListener('click', ()=>{
        toggleLike(post, card);
    });

    return card;
}

function slideImages(slider, direction){
    const imgs = slider.querySelectorAll('img');
    let activeIndex = Array.from(imgs).findIndex(img=>img.classList.contains('active'));
    imgs[activeIndex].classList.remove('active');
    activeIndex += direction;
    if(activeIndex < 0) activeIndex = imgs.length-1;
    if(activeIndex >= imgs.length) activeIndex=0;
    imgs[activeIndex].classList.add('active');
}

function toggleLike(post, card) {
    if(!post.liked) {
        post.likes += 1;
        post.liked = true;
    } else {
        post.likes -= 1;
        post.liked = false;
    }
    updatePostActions(card, post);
}

function updatePostActions(card, post) {
    const actions = card.querySelector('.actions');
    updateActionsHTML(actions, post);

    const commentBtn = actions.querySelector('.comment-btn');
    commentBtn.addEventListener('click', ()=>{
        currentPostId = post.id;
        showComments(post.id);
        commentModal.classList.add('show');
    });

    const likeBtn = actions.querySelector('.like-btn');
    likeBtn.addEventListener('click', ()=>{
        toggleLike(post, card);
    });
}

function updateActionsHTML(actions, post){
    actions.innerHTML = `
        <span class="comment-btn"><i class="lni lni-comments"></i> ${post.comments.length}</span>
        <span class="like-btn ${post.liked?'liked':''}"><i class="lni lni-heart"></i> ${post.likes}</span>
    `;
}

function showComments(postId) {
    commentList.innerHTML = '';
    const post = allPosts.find(p=>p.id===postId);
    const comments = post.comments;
    comments.forEach(comment=>{
        const div = document.createElement('div');
        div.classList.add('comment-item');

        const header = document.createElement('div');
        header.classList.add('comment-item-header');

        const userSpan = document.createElement('span');
        userSpan.classList.add('comment-user');
        userSpan.textContent = comment.user;

        const timeSpan = document.createElement('span');
        timeSpan.classList.add('comment-time');
        timeSpan.textContent = comment.time;

        header.appendChild(userSpan);
        header.appendChild(timeSpan);

        const textDiv = document.createElement('div');
        textDiv.classList.add('comment-text');
        textDiv.textContent = comment.text;

        div.appendChild(header);
        div.appendChild(textDiv);

        commentList.appendChild(div);
    });
}

function addComment(e){
    e.preventDefault();
    const input = commentForm.querySelector('input');
    const newCommentText = input.value.trim();
    if(!newCommentText) return;
    const post = allPosts.find(p=>p.id===currentPostId);
    post.comments.push({
        user:"Me",
        text:newCommentText,
        time:"Just now"
    });
    input.value='';
    showComments(currentPostId);

    const card = document.querySelector(`.post-card[data-post-id='${currentPostId}']`);
    updatePostActions(card, post);
}

function filterTopics(){
    const q = searchTopicsInput.value.toLowerCase();
    Array.from(topicContainer.querySelectorAll('a')).forEach(a=>{
        if(a.textContent.toLowerCase().includes(q)) {
            a.classList.remove('hide');
        } else {
            a.classList.add('hide');
        }
    });
}

function filterProfiles(){
    const q = searchProfilesInput.value.toLowerCase();
    Array.from(profileContainer.querySelectorAll('a')).forEach(a=>{
        if(a.textContent.toLowerCase().includes(q)) {
            a.classList.remove('hide');
        } else {
            a.classList.add('hide');
        }
    });
}

function loadMoreTopics(){
    const slice = allTopics.slice(topicIndex, topicIndex+chunkSize);
    slice.forEach(t => {
        const a = document.createElement('a');
        a.href="#";
        a.textContent = t;
        topicContainer.appendChild(a);
    });
    topicIndex += chunkSize;
    checkTopicsPagination();
}
function resetTopics(){
    topicIndex = 0;
    topicContainer.innerHTML='';
    seeMoreTopicsBtn.textContent='See More';
    seeMoreTopicsBtn.classList.remove('disabled');
    seeMoreTopicsBtn.style.cursor='pointer';
    resetTopicsBtn.style.display='none';
    seeMoreTopicsBtn.addEventListener('click', loadMoreTopics);
    loadMoreTopics();
}
function checkTopicsPagination(){
    if(topicIndex>=allTopics.length){
        seeMoreTopicsBtn.textContent='No more';
        seeMoreTopicsBtn.classList.add('disabled');
        seeMoreTopicsBtn.style.cursor='default';
        resetTopicsBtn.style.display='inline-block';
        seeMoreTopicsBtn.removeEventListener('click', loadMoreTopics);
    } else {
        seeMoreTopicsBtn.textContent='See More';
        seeMoreTopicsBtn.classList.remove('disabled');
    }
}

function loadMoreProfiles(){
    const slice = allProfiles.slice(profileIndex, profileIndex+chunkSize);
    slice.forEach(pf => {
        const a = document.createElement('a');
        a.href="#";
        a.textContent = pf;
        profileContainer.appendChild(a);
    });
    profileIndex += chunkSize;
    checkProfilesPagination();
}
function resetProfiles(){
    profileIndex=0;
    profileContainer.innerHTML='';
    seeMoreProfileBtn.textContent='See More';
    seeMoreProfileBtn.classList.remove('disabled');
    seeMoreProfileBtn.style.cursor='pointer';
    resetProfileBtn.style.display='none';
    seeMoreProfileBtn.addEventListener('click', loadMoreProfiles);
    loadMoreProfiles();
}
function checkProfilesPagination(){
    if(profileIndex>=allProfiles.length){
        seeMoreProfileBtn.textContent='No more';
        seeMoreProfileBtn.classList.add('disabled');
        seeMoreProfileBtn.style.cursor='default';
        resetProfileBtn.style.display='inline-block';
        seeMoreProfileBtn.removeEventListener('click', loadMoreProfiles);
    } else {
        seeMoreProfileBtn.textContent='See More';
        seeMoreProfileBtn.classList.remove('disabled');
    }
}
</script>
@endsection
