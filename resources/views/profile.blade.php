@extends('layouts.template')

@section('title', 'User Profile')

@section('content')
<link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
  crossorigin="anonymous" />

<!-- CSRF meta for AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
  html,
  body {
    margin: 0;
    padding: 0;
    background: linear-gradient(to bottom right, #000, #111);
    height: 100vh;
    color: #fff;
    display: flex;
  }

  .profile-container {
    display: flex;
    flex-wrap: wrap;
    padding: 20px;
    gap: 20px;
    box-sizing: border-box;
    border-radius: 20px;
    margin: auto;
    max-width: 900px;
    position: relative;
    background: rgba(0, 0, 0, 0.9);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
    border: 4px solid transparent;
    animation: whiteGlow 2s infinite alternate;
    overflow: hidden;
    justify-content: center;
    align-items: center;
    margin-top: 5rem;
    margin-bottom: 5rem;
  }

  .mainn {
    opacity: 0;
    /* For fade-in effect */
    transition: opacity 1s ease-in;
  }

  .mainn.loaded {
    opacity: 1;
  }

  @keyframes whiteGlow {
    from {
      border-color: rgba(255, 255, 255, 0.5);
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    to {
      border-color: rgba(255, 255, 255, 1);
      box-shadow: 0 0 20px rgba(255, 255, 255, 1);
    }
  }

  .profile-image {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    border: 3px solid #fff;
    box-shadow: 0 8px 15px rgba(255, 255, 255, 0.5);
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .user-info {
    flex: 1;
    max-width: 500px;
    text-align: center;
  }

  @media (min-width: 768px) {
    .user-info {
      text-align: left;
    }
  }

  .username {
    font-size: 1.8rem;
    font-weight: bold;
    color: #fff;
  }

  .description {
    font-size: 1rem;
    color: #ddd;
    margin-top: 10px;
  }

  .stats-container {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
  }

  .stat-item {
    text-align: center;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    padding: 10px;
    flex: 1 1 100px;
    max-width: 120px;
    height: 100px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    /* So it looks clickable */
  }

  .stat-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.3);
  }

  .stat-item strong {
    font-size: 1.5rem;
    color: #fff;
  }

  .stat-item span {
    font-size: 0.9rem;
    color: #ccc;
  }

  .btn-outline-light:hover {
    background-color: #f5f5f5;
    color: #000;
  }

  .modal-content {
    background-color: #222;
    color: #fff;
    border-radius: 10px;
  }

  .form-control {
    background-color: #333;
    color: #fff;
    border-radius: 5px;
  }

  .form-control:focus {
    background-color: #444;
    border-color: #888;
    color: white;
  }

  .modal-header {
    background-color: #333;
    border-bottom: 1px solid #444;
    color: #fff;
  }

  .modal-footer {
    background-color: #333;
    border-top: 1px solid #444;
  }

  .btn-secondary {
    background-color: #555;
    border: none;
    color: #fff;
    transition: background-color 0.3s ease;
  }

  .btn-secondary:hover {
    background-color: #777;
    color: #fff;
  }

  .btn-primary {
    background-color: #fff;
    color: #000;
    border: none;
    transition: background-color 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #ccc;
    color: #000;
  }

  /* Follow Container */
  .follow-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 20px;
    background: rgba(0, 0, 0, 0.75);
    border-radius: 10px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.7);
    color: #fff;
  }

  .follow-container h2 {
    margin-bottom: 1rem;
  }

  .search-bar {
    margin-bottom: 1rem;
  }

  .search-bar input {
    background-color: #333;
    border: 1px solid #444;
    color: #fff;
  }

  .search-bar input:focus {
    background-color: #444;
    border-color: #888;
  }

  .user-list {
    margin-top: 1rem;
    max-height: 360px;
    overflow-y: auto;
  }

  .user-item {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.3s ease;
  }

  .user-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 2px 8px rgba(255, 255, 255, 0.2);
  }

  .user-profile {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .user-profile img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
  }

  .user-profile .username {
    font-size: 1rem;
    color: #fff;
    margin: 0;
  }

  .follow-btn {
    min-width: 80px;
  }

  .btn-follow {
    background-color: #0d6efd;
    /* Blue */
    border: none;
    color: white;
  }

  .btn-followed {
    background-color: #dc3545;
    /* Red */
    border: none;
    color: white;
  }

  /* Fade/Slide for Follower/Following Modals */
  .modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .modal-overlay.show {
    display: flex;
    opacity: 1;
  }

  .follower-list-modal,
  .following-list-modal {
    background: #222;
    width: 80%;
    max-width: 600px;
    padding: 1rem;
    border-radius: 10px;
    border: 1px solid #333;
    transform: translateY(-20px);
    animation: slideDown 0.4s forwards;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  @keyframes slideDown {
    from {
      transform: translateY(-50px);
    }

    to {
      transform: translateY(0);
    }
  }

  .close-modal-btn {
    align-self: flex-end;
    background: #666;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 0.5rem 1rem;
    cursor: pointer;
    margin-bottom: 1rem;
  }

  .close-modal-btn:hover {
    background: #888;
  }

  .modal-title {
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
    text-align: center;
  }

  .modal-list {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #444;
    border-radius: 4px;
    padding: 0.5rem;
  }

  .modal-list .user-line {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.3rem;
    margin-bottom: 0.3rem;
    background: #333;
    border-radius: 4px;
  }

  .modal-list .user-line:hover {
    background: #444;
  }

  .modal-list .user-line img {
    width: 30px;
    height: 30px;
    object-fit: cover;
    border-radius: 50%;
  }

  .user-profile-image {
    cursor: pointer;
    transition: transform 0.3s ease;
  }

  .user-profile-image:hover {
    transform: scale(1.1);
  }
</style>

<!-- Main Wrapper -->
<div class="mainn">
  <!-- Profile Container -->
  <div class="profile-container">
    <!-- Profile Image -->
    <div class="profile-image">
      <img
        src="{{ $user->profile_image ?? 'https://via.placeholder.com/200' }}"
        alt="Profile Image Not Found"
        onerror="this.onerror=null; this.src='https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png'; this.alt='Profile Image Not Found'; this.style.border='2px solid red'; this.title='Profile Image Not Found';" />
    </div>

    <!-- User Info -->
    <div class="user-info">
      <div class="d-flex justify-content-between align-items-center">
        <div class="username">
          {{ $user->name ?? 'Username' }}
        </div>
        <button
          class="btn btn-outline-light btn-sm"
          data-bs-toggle="modal"
          data-bs-target="#editProfileModal">
          Edit Profile
        </button>
      </div>

      <div class="description">
        {{ $user->description ?? 'A little description...' }}
      </div>

      <div class="stats-container">
        <div class="stat-item" data-target="posts">
          <strong>{{ $totalPosts }}</strong>
          <span>Post{{ $totalPosts === 1 ? '' : 's' }}</span>
        </div>
        <div class="stat-item" id="openFollowersModal">
          <!-- We'll attach a click event in JS to open the "Followers" modal -->
          <strong>{{ $totalFollowers }}</strong>
          <span>Follower{{ $totalFollowers === 1 ? '' : 's' }}</span>
        </div>
        <div class="stat-item" id="openFollowingModal">
          <!-- We'll attach a click event in JS to open the "Following" modal -->
          <strong id="folNum">{{ $totalFollowing }}</strong>
          <span>Following</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Container Follow: "Find People to Follow" on same page -->
  <div class="follow-container">
    <h2>Find People to Follow</h2>

    <!-- Search Bar (Optional AJAX Later) -->
    <div class="search-bar">
      <label for="searchUser" class="form-label">Search Users</label>
      <input
        type="text"
        class="form-control"
        id="searchUser"
        placeholder="Type to search..."
        autocomplete="off">
    </div>

    <!-- Filter: All, Followed, Unfollowed -->
    <div class="d-flex mb-2" style="gap: 1rem;">
      <label for="searchFilter" class="form-label my-auto">Filter:</label>
      <select id="searchFilter" class="form-select form-select-sm" style="max-width:150px;">
        <option value="all">All</option>
        <option value="followed">Followed</option>
        <option value="unfollowed">Unfollowed</option>
      </select>
    </div>

    <!-- The user-list container (same as before, but we'll re-render it) -->
    <div class="user-list" id="userList">
      @foreach($otherUsers as $other)
      @php
      $isFollowed = DB::table('user_followers')
      ->where('user_id', $other->id)
      ->where('follower_id', auth()->id())
      ->exists();
      @endphp

      <div class="user-item">
        <div class="user-profile">
          <img
            src="{{ $other->profile_image ?? 'https://via.placeholder.com/40' }}"
            alt="User Pic"
            onerror="this.onerror=null; this.src='https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png'; this.alt='Profile Image Not Found'; this.style.border='2px solid red'; this.title='Profile Image Not Found';"
            class="user-profile-image"
            data-bs-toggle="modal"
            data-bs-target="#userDetailModal"
            data-user-id="{{ $other->id }}">
          <p class="username mb-0">{{ $other->name }}</p>
        </div>

        <button
          class="btn btn-sm follow-btn 
              {{ $isFollowed ? 'btn-followed' : 'btn-follow'}}"
          data-user-id="{{ $other->id }}"
          data-followed="{{ $isFollowed ? 'true' : 'false' }}">
          {{ $isFollowed ? 'Followed' : 'Follow' }}
        </button>
      </div>
      @endforeach
    </div>
  </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userDetailModalLabel">User Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img id="modalProfileImage" src="" alt="Profile Pic" class="rounded-circle mb-3" width="100" height="100">
        </div>
        <h4 id="modalUsername" class="text-center"></h4>
        <p id="modalDescription" class="text-center"></p>
      </div>
    </div>
  </div>
</div>

<!-- Follower Modal -->
<div class="modal-overlay" id="followersModalOverlay">
  <div class="follower-list-modal">
    <button class="close-modal-btn" id="closeFollowersModal">Close</button>
    <h2 class="modal-title">Your Followers</h2>
    <div class="modal-list" id="followersList"></div>
  </div>
</div>

<!-- Following Modal -->
<div class="modal-overlay" id="followingModalOverlay">
  <div class="following-list-modal">
    <button class="close-modal-btn" id="closeFollowingModal">Close</button>
    <h2 class="modal-title">Who You're Following</h2>
    <div class="modal-list" id="followingList"></div>
  </div>
</div>

<!-- Modal Edit Profile -->
<div
  class="modal fade"
  id="editProfileModal"
  tabindex="-1"
  aria-labelledby="editProfileModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('profile.update') }}" method="POST">
      @csrf
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Username</label>
            <input
              type="text"
              class="form-control"
              id="name"
              name="name"
              value="{{ old('name', $user->name) }}"
              required />
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea
              class="form-control"
              id="description"
              name="description"
              rows="3">{{ old('description', $user->description) }}</textarea>
          </div>

          <div class="mb-3">
            <label for="profile_image" class="form-label">Profile Image URL</label>
            <input
              type="url"
              class="form-control"
              id="profile_image"
              name="profile_image"
              value="{{ old('profile_image', $user->profile_image) }}"
              placeholder="https://example.com/image.jpg" />
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap + JS -->
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
  crossorigin="anonymous">
</script>

<script>
  //opening details
  document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('userDetailModal');

    modal.addEventListener('show.bs.modal', function(event) {
      const triggerElement = event.relatedTarget; // The element that triggered the modal
      const userId = triggerElement.getAttribute('data-user-id');

      // Check if userId is being sent
      console.log("User ID:", userId);

      // Make an AJAX request to fetch user details
      fetch(`/user-details/${userId}`)
        .then(response => {
          console.log("Response Status:", response.status);
          return response.json();
        })
        .then(data => {
          console.log("Data Received:", data);

          if (data.error) {
            alert(data.error);
            return;
          }

          // Populate modal fields with user data
          document.getElementById('modalProfileImage').src = data.profile_image || 'https://via.placeholder.com/100';
          document.getElementById('modalUsername').textContent = data.name || 'Unknown';
          document.getElementById('modalDescription').textContent = data.description || 'No description available.';
        })
        .catch(error => {
          console.error('Error fetching user details:', error);
        });
    });
  });


  // Fade in the profile container
  window.addEventListener('load', function() {
    document.querySelector('.mainn').classList.add('loaded');
  });

  // If someone clicks on the Posts stat
  document.querySelectorAll('.stat-item[data-target="posts"]').forEach(item => {
    item.addEventListener('click', () => {
      window.location.href = "{{ route('homee') }}";
    });
  });

  // Attach click events for opening modals
  const openFollowersModalEl = document.getElementById('openFollowersModal');
  const openFollowingModalEl = document.getElementById('openFollowingModal');
  const followersModalOverlay = document.getElementById('followersModalOverlay');
  const followingModalOverlay = document.getElementById('followingModalOverlay');
  const followersListEl = document.getElementById('followersList');
  const followingListEl = document.getElementById('followingList');

  const closeFollowersBtn = document.getElementById('closeFollowersModal');
  const closeFollowingBtn = document.getElementById('closeFollowingModal');

  openFollowersModalEl.addEventListener('click', () => {
    fetchFollowers(); // We'll define fetchFollowers() below
    followersModalOverlay.classList.add('show');
  });
  openFollowingModalEl.addEventListener('click', () => {
    fetchFollowing(); // We'll define fetchFollowing() below
    followingModalOverlay.classList.add('show');
  });

  closeFollowersBtn.addEventListener('click', () => {
    followersModalOverlay.classList.remove('show');
  });
  closeFollowingBtn.addEventListener('click', () => {
    followingModalOverlay.classList.remove('show');
  });

  // AJAX to get followers
  function fetchFollowers() {
    fetch('/get-followers', {
        method: 'GET',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        }
      })
      .then(res => {
        if (!res.ok) throw new Error('Failed to load followers');
        return res.json();
      })
      .then(data => {
        // data => array of user objects
        followersListEl.innerHTML = '';
        if (data.length > 0) {
          data.forEach(u => {
            const line = document.createElement('div');
            line.classList.add('user-line');
            line.innerHTML = `
            <img src="${u.profile_image ?? 'https://via.placeholder.com/40'}" alt="User Pic"
            onerror="this.onerror=null; this.src='https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png'; this.alt='Profile Image Not Found'; this.style.border='2px solid red'; this.title='Profile Image Not Found';">
            <span>${u.name}</span>
          `;
            followersListEl.appendChild(line);
          });
        } else {
          followersListEl.innerHTML = '<p style="text-align:center; color:#aaa;">No followers yet.</p>';
        }
      })
      .catch(err => console.error(err));
  }

  // AJAX to get following
  function fetchFollowing() {
    fetch('/get-following', {
        method: 'GET',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        }
      })
      .then(res => {
        if (!res.ok) throw new Error('Failed to load following');
        return res.json();
      })
      .then(data => {
        followingListEl.innerHTML = '';
        if (data.length > 0) {
          data.forEach(u => {
            const line = document.createElement('div');
            line.classList.add('user-line');
            line.innerHTML = `
            <img src="${u.profile_image ?? 'https://via.placeholder.com/40'}" alt="User Pic"
            onerror="this.onerror=null; this.src='https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png'; this.alt='Profile Image Not Found'; this.style.border='2px solid red'; this.title='Profile Image Not Found';">
            <span>${u.name}</span>
          `;
            followingListEl.appendChild(line);
          });
        } else {
          followingListEl.innerHTML = '<p style="text-align:center; color:#aaa;">You are not following anyone yet.</p>';
        }
      })
      .catch(err => console.error(err));
  }



  // AJAX Follow/Unfollow
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const followButtons = document.querySelectorAll('.follow-btn');

  followButtons.forEach(btn => {
    btn.addEventListener('click', async function(e) {
      e.preventDefault();
      const userId = this.dataset.userId;
      const followed = this.dataset.followed === 'true';
      // If followed == true -> UNFOLLOW
      // If false -> FOLLOW

      let url, method;
      if (followed) {
        // Unfollow
        url = `/unfollow/${userId}`;
        method = 'DELETE';
      } else {
        // Follow
        url = `/follow/${userId}`;
        method = 'POST';
      }

      try {
        const response = await fetch(url, {
          method: method,
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        });

        if (!response.ok) {
          console.error('Error in follow/unfollow:', response.status);
          // Optionally show an error alert
          return;
        }

        const data = await response.json();
        // data.followed should be boolean from controller

        var followedNum = document.getElementById('folNum');
        // Toggle button
        if (data.followed) {
          // Means now followed
          this.textContent = 'Followed';
          this.classList.remove('btn-follow');
          this.classList.add('btn-followed');
          this.dataset.followed = 'true';


        } else {
          // Means now unfollowed
          this.textContent = 'Follow';
          this.classList.remove('btn-followed');
          this.classList.add('btn-follow');
          this.dataset.followed = 'false';

        }

      } catch (error) {
        console.error('AJAX error:', error);
      }
    });
  });
  const searchInput = document.getElementById('searchUser');
  const filterSelect = document.getElementById('searchFilter');
  const userListEl = document.getElementById('userList');

  // Debounce timer to avoid hitting server on every single keystroke too fast
  let searchTimer = null;

  function doSearch() {
    const query = searchInput.value.trim(); // the typed text
    const filter = filterSelect.value; // all | followed | unfollowed

    // Construct URL: /search-users?q=...&filter=...
    let url = `/search-users?q=${encodeURIComponent(query)}&filter=${encodeURIComponent(filter)}`;

    fetch(url, {
        method: 'GET',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        }
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`Search error: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        // data => array of user objects, each with { id, name, profile_image, is_followed }
        renderUserList(data);
      })
      .catch(err => {
        console.error('Search fetch error:', err);
      });
  }

  // 2) On keyup in the searchInput, we do a small debounce
  searchInput.addEventListener('keyup', () => {
    if (searchTimer) clearTimeout(searchTimer);
    searchTimer = setTimeout(doSearch, 300); // 300ms delay
  });

  // 3) On change in filterSelect
  filterSelect.addEventListener('change', () => {
    doSearch();
  });

  // 4) Re-render function for .user-list
  function renderUserList(users) {
    // 'users' is the JSON array from your endpoint
    // We'll rebuild the .user-list content
    userListEl.innerHTML = '';

    users.forEach(user => {
      // user.is_followed => boolean from your server
      // user.name, user.profile_image, user.id, etc.

      const isFollowed = user.is_followed ? 'true' : 'false';
      const btnClass = user.is_followed ? 'btn-followed' : 'btn-follow';
      const btnText = user.is_followed ? 'Followed' : 'Follow';

      // Build the HTML
      const userItem = document.createElement('div');
      userItem.classList.add('user-item');

      const userProfile = document.createElement('div');
      userProfile.classList.add('user-profile');

      // Image + Username
      const img = document.createElement('img');
      img.src = user.profile_image ?? 'https://via.placeholder.com/40';
      img.alt = 'User Pic';
      img.style.width = '40px';
      img.style.height = '40px';
      img.style.objectFit = 'cover';
      img.style.borderRadius = '50%';

      const usernameP = document.createElement('p');
      usernameP.classList.add('username', 'mb-0');
      usernameP.textContent = user.name;

      userProfile.appendChild(img);
      userProfile.appendChild(usernameP);

      // Follow/unfollow button
      const followBtn = document.createElement('button');
      followBtn.classList.add('btn', 'btn-sm', 'follow-btn', btnClass);
      followBtn.setAttribute('data-user-id', user.id);
      followBtn.setAttribute('data-followed', isFollowed);
      followBtn.textContent = btnText;

      // We want the same follow/unfollow logic on this new button
      followBtn.addEventListener('click', followUnfollowHandler);

      userItem.appendChild(userProfile);
      userItem.appendChild(followBtn);

      userListEl.appendChild(userItem);
    });
  }

  // 5) Move your existing follow/unfollow logic into a function
  async function followUnfollowHandler(e) {
    e.preventDefault();
    const userId = this.dataset.userId;
    const followed = (this.dataset.followed === 'true');

    let url, method;
    if (followed) {
      // Unfollow
      url = `/unfollow/${userId}`;
      method = 'DELETE';
    } else {
      // Follow
      url = `/follow/${userId}`;
      method = 'POST';
    }

    try {
      const response = await fetch(url, {
        method: method,
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        }
      });

      if (!response.ok) {
        console.error('Error in follow/unfollow:', response.status);
        return;
      }

      const data = await response.json();
      // data.followed => true if now followed, false if now unfollowed

      // Toggle button text & style
      if (data.followed) {
        this.textContent = 'Followed';
        this.classList.remove('btn-follow');
        this.classList.add('btn-followed');
        this.dataset.followed = 'true';

        // Increment your 'Following' count
        const followedNum = document.getElementById('folNum');
        let currentVal = parseInt(followedNum.innerHTML, 10) || 0;
        followedNum.innerHTML = currentVal + 1;

      } else {
        this.textContent = 'Follow';
        this.classList.remove('btn-followed');
        this.classList.add('btn-follow');
        this.dataset.followed = 'false';

        // Decrement your 'Following' count
        const followedNum = document.getElementById('folNum');
        let currentVal = parseInt(followedNum.innerHTML, 10) || 0;
        if (currentVal > 0) {
          followedNum.innerHTML = currentVal - 1;
        }
      }

      // If you're on "followed" or "unfollowed" filter, re-run the search 
      // so the user disappears or appears accordingly.
      // If you want that behavior, just do:
      doSearch();

    } catch (error) {
      console.error('AJAX error:', error);
    }
  }


  // 6) Attach the existing followUnfollowHandler to the initial buttons
  followButtons.forEach(btn => {
    btn.addEventListener('click', followUnfollowHandler);
  });

  // 7) (Optional) On page load, we might do an initial search to show "all" if needed
  // doSearch(); // or only do it if user starts typing or changes the filter
</script>
@endsection