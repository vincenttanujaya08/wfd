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

    .sidebar-left {
        width: 300px;
        background: #111;
        border-right: 1px solid #333;
        padding: 1rem;
        box-sizing: border-box;
    }

    .sidebar-left h3 {
        color: #ccc;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .sidebar-left a {
        color: #ccc;
        text-decoration: none;
        display: block;
        margin-bottom: 0.5rem;
    }

    .sidebar-left a:hover {
        text-decoration: underline;
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

    .form-group .file-input {
        background: #000;
        border: 1px dashed #444;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
    }

    .form-group .file-input:hover {
        background: #111;
    }

    .form-group .file-input input[type=file] {
        opacity: 0;
        position: absolute;
        left: -9999px;
    }

    .form-group .file-text {
        color: #888;
        font-size: 0.9rem;
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

    /* Suggestion box untuk topik */
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
        .sidebar-left {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #333;
            order: 1;
        }

        .main-content {
            order: 2;
            padding: 1rem;
        }

        .upload-form-container {
            padding: 1rem;
        }
    }

    /* Styling untuk File Input */
.form-group .file-input {
    background: #000;
    border: 1px dashed #444;
    padding: 1rem;
    text-align: center;
    cursor: pointer;
    position: relative;
    border-radius: 4px;
    transition: background 0.3s;
}

.form-group .file-input:hover {
    background: #111;
}

.form-group .file-input input[type=file] {
    opacity: 0;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

/* Styling untuk Daftar File */
#fileList {
    margin-top: 10px;
    list-style-type: none;
    padding: 0;
}

#fileList li {
    background: #333;
    padding: 0.5rem;
    margin-bottom: 0.5rem;
    border-radius: 4px;
    font-size: 0.9rem;
    color: #ccc;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

#fileList li .file-name {
    word-break: break-all;
}

#fileList li .remove-btn {
    background: transparent;
    border: none;
    color: #ff4d4d;
    cursor: pointer;
    font-size: 1.2rem;
    line-height: 1;
    padding: 0;
}

#fileList li .remove-btn:hover {
    color: #ff1a1a;
}

</style>

<div class="content-wrapper">
   

    <div class="main-content">
        <div class="upload-form-container">
            <h2>Upload New Post</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="caption">Caption</label>
                    <textarea name="caption" id="caption" placeholder="Write something..." required></textarea>
                </div>

                <div class="form-group" style="position:relative;">
                    <label for="topicInput">Topic</label>
                    <input type="text" name="topic" id="topicInput" placeholder="Type topic..." autocomplete="off">

                    <!-- Suggestion box -->
                    <div id="topicSuggestions" class="topic-suggestions" style="display:none;"></div>
                </div>

                <div class="form-group">
                    <label>Upload Images (min 1 image)</label>
                    <label for="imagesInput" class="file-input" 
                           role="button" 
                           tabindex="0" 
                           aria-describedby="fileInputDescription">
                        <span class="file-text">Click to select images</span>
                    </label>
                    <input type="file" name="images[]" id="imagesInput" multiple required accept="image/*" onchange="updateFileList();" aria-describedby="fileInputDescription" style="display:none;">
                    <ul id="fileList" style="margin-top: 10px; list-style-type: none; padding: 0;"></ul>
                </div>
                
                

                <button type="submit" class="submit-btn">Post</button>
            </form>
        </div>
    </div>
</div>

<script>
// Mock topics
let allTopics = ["#TOPICsearch1","#TOPICSATU","#HELLO","#WORLD","#JAVASCRIPT","#CSS","#HTML","#REACT","#ANOTHER"];
const topicInput = document.getElementById('topicInput');
const topicSuggestions = document.getElementById('topicSuggestions');

topicInput.addEventListener('input', ()=>{
    const query = topicInput.value.toLowerCase().trim();
    while(topicSuggestions.firstChild){
        topicSuggestions.removeChild(topicSuggestions.firstChild);
    }
    if(query.length===0){
        topicSuggestions.style.display='none';
        return;
    }

    // Filter topics
    const results = allTopics.filter(t=>t.toLowerCase().includes(query));

    if(results.length>0){
        results.forEach(r=>{
            const div = document.createElement('div');
            div.classList.add('suggestion');
            div.textContent = r;
            div.addEventListener('click', ()=>{
                topicInput.value = r;
                topicSuggestions.style.display='none';
            });
            topicSuggestions.appendChild(div);
        });
    } else {
        // No results, show add new
        const noRes = document.createElement('div');
        noRes.classList.add('no-results');
        noRes.textContent = `No results. Add "${query}" as new topic?`;
        noRes.addEventListener('click', ()=>{
            // Jika user klik ini, kita anggap user set topic baru
            topicInput.value = query;
            topicSuggestions.style.display='none';
        });
        topicSuggestions.appendChild(noRes);
    }

    topicSuggestions.style.display='block';
});


function updateFileList() {
    const fileInput = document.getElementById('imagesInput');
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = ''; // Bersihkan daftar sebelumnya

    if (fileInput.files.length === 0) {
        const li = document.createElement('li');
        li.textContent = 'No files selected';
        li.style.color = 'red';
        fileList.appendChild(li);
        return;
    }

    Array.from(fileInput.files).forEach((file, index) => {
        const li = document.createElement('li');

        const fileNameSpan = document.createElement('span');
        fileNameSpan.classList.add('file-name');
        fileNameSpan.textContent = file.name;

        const removeBtn = document.createElement('button');
        removeBtn.classList.add('remove-btn');
        removeBtn.innerHTML = '&times;';
        removeBtn.title = 'Remove this image';
        removeBtn.onclick = (e) => {
            e.preventDefault();
            e.stopPropagation();
            removeFile(index);
        };

        li.appendChild(fileNameSpan);
        li.appendChild(removeBtn);
        fileList.appendChild(li);
    });
}

function removeFile(index) {
    const fileInput = document.getElementById('imagesInput');
    const dt = new DataTransfer();

    Array.from(fileInput.files).forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });

    fileInput.files = dt.files;
    updateFileList();
}

// Validasi Form sebelum Pengiriman
document.getElementById('postForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('imagesInput');
    if (fileInput.files.length === 0) {
        e.preventDefault();
        alert('Please select at least one image.');
    }
    // Validasi tambahan bisa ditambahkan di sini
});

// Optional: preview images, handle 'new topic' logic on submit, dsb.
</script>
@endsection
