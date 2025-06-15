@extends('layouts.template')

@section('title', 'Report User')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .report-container {
        max-width: 600px;
        margin: 2rem auto;
        padding: 1.5rem;
        background: #1e1e1e;
        border: 1px solid #333;
        border-radius: 1rem;
        color: #ddd;
    }

    .report-title {
        display: flex;
        align-items: center;
        font-size: 1.5rem;
        color: #e74c3c;
        margin-bottom: 1rem;
    }

    .report-title i {
        margin-right: .5rem;
    }

    .search-input {
        width: 100%;
        padding: .75rem;
        border: 1px solid #333;
        border-radius: .5rem;
        background: #222;
        color: #fff;
        margin-bottom: 1rem;
    }

    .user-list .user-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: .5rem 0;
        padding: .6rem .75rem;
        background: #2a2a2a;
        border: 1px solid #333;
        border-radius: .5rem;
    }

    .user-item:hover {
        background: #333;
    }

    .user-name {
        color: #fff;
        font-weight: 500;
    }

    .btn-report {
        background: #e67e22;
        color: #fff;
        padding: .4rem .8rem;
        border: none;
        border-radius: .5rem;
        cursor: pointer;
    }

    .btn-report:hover {
        opacity: .9;
    }

    .pagination-controls {
        display: flex;
        justify-content: center;
        gap: .5rem;
        margin-top: 1rem;
    }

    .pagination-controls button {
        background: #333;
        color: #ddd;
        border: none;
        padding: .4rem .8rem;
        border-radius: .5rem;
        cursor: pointer;
    }

    .pagination-controls button:disabled {
        opacity: .4;
        cursor: default;
    }

    .report-form {
        background: #2a2a2a;
        border: 1px solid #333;
        border-radius: .5rem;
        padding: 1rem;
        margin-top: 1.5rem;
    }

    .form-field {
        margin-bottom: 1rem;
    }

    .form-field label {
        display: block;
        margin-bottom: .3rem;
        color: #ccc;
    }

    .form-field input[type=file],
    .form-field textarea {
        width: 100%;
        padding: .6rem;
        background: #1b1b1b;
        border: 1px solid #444;
        border-radius: .5rem;
        color: #fff;
    }

    .btn-submit {
        background: #27ae60;
        color: #000;
        padding: .5rem 1rem;
        border: none;
        border-radius: .5rem;
        cursor: pointer;
    }

    .btn-submit:hover {
        opacity: .9;
    }

    .btn-cancel {
        background: #7f8c8d;
        color: #fff;
        padding: .5rem 1rem;
        border: none;
        border-radius: .5rem;
        margin-left: .5rem;
        cursor: pointer;
    }

    .btn-cancel:hover {
        opacity: .9;
    }

    .alert-success {
        background: #2ecc71;
        color: #000;
        padding: .7rem;
        border-radius: .5rem;
        margin-top: 1rem;
        text-align: center;
    }

    /* put this in your existing <style> */
    .image-preview-wrapper {
        display: inline-block;
        position: relative;
        margin: 4px;
        width: 80px;
        height: 80px;
    }

    .preview-thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #444;
    }

    .remove-btn {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 20px;
        height: 20px;
        background: #e74c3c;
        color: #fff;
        border: none;
        border-radius: 50%;
        font-size: 14px;
        line-height: 18px;
        text-align: center;
        cursor: pointer;
    }
</style>

<div class="report-container">
    <div class="report-title">
        <i class="lni lni-warning"></i>
        Report User
    </div>

    {{-- SEARCH SECTION --}}
    <div id="searchSection">
        <input
            type="text"
            id="searchUser"
            class="search-input"
            placeholder="Type a user’s name to search…"
            autocomplete="off">

        <div id="searchResult" class="user-list"></div>
        <div class="pagination-controls" id="paginationControls"></div>
    </div>

    {{-- REPORT FORM SECTION (hidden until a user is chosen) --}}
    <div id="formSection" style="display:none;"></div>

    <div id="reportSuccessMsg"></div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const searchInput = document.getElementById('searchUser');
    const searchResult = document.getElementById('searchResult');
    const paginationCtrl = document.getElementById('paginationControls');
    const searchSection = document.getElementById('searchSection');
    const formSection = document.getElementById('formSection');
    const reportSuccess = document.getElementById('reportSuccessMsg');
    let currentUrl = `/report/search-users?page=1`;

    // 1) Fetch & render a page of users
    function fetchUsers(url, query = '') {
        currentUrl = url + (query ? `&q=${encodeURIComponent(query)}` : '');
        fetch(currentUrl, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(r => r.json())
            .then(resp => {
                // Render users
                if (!resp.data.length) {
                    searchResult.innerHTML = '<div class="text-neutral-400 italic">No users found.</div>';
                    paginationCtrl.innerHTML = '';
                    return;
                }
                searchResult.innerHTML = resp.data.map(u => `
          <div class="user-item">
            <div class="flex items-center">
              <img
                src="${u.profile_image || '/images/default_profile.jpeg'}"
                onerror="this.onerror=null;this.src='/images/default_profile.jpeg';"
                width="40" height="40"
                class="rounded-full border border-neutral-700 mr-3"
              >
              <span class="user-name">${u.name}</span>
            </div>
            <button class="btn-report" data-userid="${u.id}" data-username="${u.name}">
              Report
            </button>
          </div>
        `).join('');

                // Render pagination controls
                paginationCtrl.innerHTML = `
          <button id="prevPage" ${!resp.prev_page_url?'disabled':''}>Previous</button>
          <span class="px-2 text-sm">${resp.current_page} / ${resp.last_page}</span>
          <button id="nextPage" ${!resp.next_page_url?'disabled':''}>Next</button>
        `;
                // Hook buttons
                document.getElementById('prevPage')?.addEventListener('click', () => fetchUsers(resp.prev_page_url, searchInput.value));
                document.getElementById('nextPage')?.addEventListener('click', () => fetchUsers(resp.next_page_url, searchInput.value));
            });
    }

    // 2) Initial placeholder
    searchResult.innerHTML = '<div class="text-neutral-400 italic">Start typing above to search users…</div>';

    // 3) Live search on keyup
    searchInput.addEventListener('keyup', () => {
        clearTimeout(window._debounce);
        window._debounce = setTimeout(() => {
            const q = searchInput.value.trim();
            if (!q) {
                searchResult.innerHTML = '<div class="text-neutral-400 italic">Start typing above to search users…</div>';
                paginationCtrl.innerHTML = '';
                return;
            }
            fetchUsers(`/report/search-users?page=1`, q);
        }, 300);
    });

    // 4) Delegate "Report" clicks
    searchResult.addEventListener('click', e => {
        if (!e.target.matches('.btn-report')) return;
        const userId = e.target.dataset.userid;
        const userName = e.target.dataset.username;

        // Hide search + pagination
        searchSection.style.display = 'none';

        // Inject report form HTML
        formSection.innerHTML = `
      <form id="reportForm" class="report-form" enctype="multipart/form-data">
        <div class="text-lg font-semibold mb-4">
          Reporting <span style="color:#e74c3c">${userName}</span>
        </div>
        <input type="hidden" name="reported_user_id" value="${userId}">

        <!-- IMAGE UPLOAD UI -->
        <div class="form-field">
          <label>Evidence images (max 5):</label>
          <div id="imageUploadArea" class="mt-1 border border-neutral-700 p-2 rounded bg-neutral-800">
            <button type="button" id="addImageBtn"
              class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
              + Add Image
            </button>
            <input type="file" id="fileInput" accept="image/*" style="display:none">
            <div id="imagePreviewList" class="flex flex-wrap gap-2 mt-2"></div>
          </div>
        </div>

        <!-- DESCRIPTION -->
        <div class="form-field">
          <label>Description:</label>
          <textarea name="description" rows="3" required placeholder="Describe what happened…"></textarea>
        </div>

        <!-- SUBMIT / CANCEL -->
        <div>
          <button type="submit" class="btn-submit">Send Report</button>
          <button type="button" class="btn-cancel" id="cancelReport">Cancel</button>
        </div>
      </form>
    `;
        formSection.style.display = 'block';
        reportSuccess.innerHTML = '';

        // Initialize image-upload logic
        initImageUpload();

        // Cancel handler
        document.getElementById('cancelReport').onclick = () => {
            formSection.style.display = 'none';
            formSection.innerHTML = '';
            searchSection.style.display = 'block';
        };

        // Submit handler
        // Submit via AJAX
        document.getElementById('reportForm').onsubmit = ev => {
            ev.preventDefault();
            const form = ev.target;

            // Build a fresh FormData
            const fd = new FormData();
            fd.append('reported_user_id', form.reported_user_id.value);
            fd.append('description', form.description.value);

            // Log how many files we think we have
            console.log('Selected files count:', selectedFiles.length, selectedFiles);

            selectedFiles.forEach((file, idx) => {
                fd.append('images[]', file);
                console.log(`Appended images[${idx}] =`, file.name, file.size, file.type);
            });

            // OPTIONAL: dump out the entire payload
            for (let pair of fd.entries()) {
                console.log('FormData entry:', pair[0], pair[1]);
            }

            fetch('/report/send', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: fd
                })
                .then(async r => {
                    if (!r.ok) {
                        // try to parse JSON error if any
                        let e = await r.json().catch(() => null);
                        console.error('Server returned HTTP', r.status, e);
                        alert(e?.message || `Upload failed: ${r.status}`);
                        return;
                    }
                    return r.json();
                })
                .then(json => {
                    if (json?.success) {
                        reportSuccess.innerHTML = `<div class="alert-success">${json.message}</div>`;
                        formSection.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    alert('Unexpected server error - see console.');
                });
        };

    });

    // 5) Image-upload initializer
    let selectedFiles = [];

    function initImageUpload() {
        selectedFiles = [];
        const addImageBtn = document.getElementById('addImageBtn');
        const fileInput = document.getElementById('fileInput');
        const imagePreviewList = document.getElementById('imagePreviewList');

        addImageBtn.onclick = () => {
            if (selectedFiles.length >= 5) return;
            fileInput.click();
        };

        fileInput.onchange = () => {
            const file = fileInput.files[0];
            if (!file) return;
            if (selectedFiles.length >= 5) {
                alert('Maximum 5 images allowed.');
                fileInput.value = '';
                return;
            }

            selectedFiles.push(file);
            const url = URL.createObjectURL(file);

            // create wrapper with fixed 80×80
            const wrapper = document.createElement('div');
            wrapper.className = 'image-preview-wrapper';

            wrapper.innerHTML = `
      <img src="${url}" class="preview-thumb-img" />
      <button type="button" class="remove-btn">&times;</button>
    `;
            imagePreviewList.appendChild(wrapper);

            // remove handler
            wrapper.querySelector('.remove-btn').onclick = () => {
                const idx = selectedFiles.indexOf(file);
                if (idx > -1) selectedFiles.splice(idx, 1);
                wrapper.remove();
                addImageBtn.disabled = false;
            };

            if (selectedFiles.length >= 5) {
                addImageBtn.disabled = true;
            }

            fileInput.value = '';
        };
    }
</script>

@endsection