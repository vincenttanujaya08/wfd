@extends('layouts.template')

@section('title', 'User Profile')

@section('content')
<link 
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
  rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
  crossorigin="anonymous"
/>

<style>
  html, body {
    margin: 0;
    padding: 0;
    background: linear-gradient(to bottom right, #000, #111);
    height: 100vh;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
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
    transition: transform 0.3s ease;
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

  .profile-container {
    opacity: 0;
    transition: opacity 1s ease-in;
  }

  .profile-container.loaded{
    opacity: 1;
  }
  
</style>

<div class="profile-container">
  <div class="profile-image">
    <img 
      src="{{ $user->profile_image ?? 'https://via.placeholder.com/200' }}" 
      alt="Profile Image"
    />
  </div>

  <div class="user-info">
    <div class="d-flex justify-content-between align-items-center">
      <div class="username">
        {{ $user->name ?? 'Username' }}
      </div>
      <button 
        class="btn btn-outline-light btn-sm" 
        data-bs-toggle="modal" 
        data-bs-target="#editProfileModal"
      >
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
      <div class="stat-item">
        <strong>{{ $totalFollowers }}</strong>
        <span>Follower{{ $totalFollowers === 1 ? '' : 's' }}</span>
      </div>
      <div class="stat-item">
        <strong>{{ $totalFollowing }}</strong>
        <span>Following</span>
      </div>
    </div>
  </div>
</div>

<div 
  class="modal fade" 
  id="editProfileModal" 
  tabindex="-1" 
  aria-labelledby="editProfileModalLabel" 
  aria-hidden="true"
>
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
              required
            />
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea 
              class="form-control" 
              id="description" 
              name="description" 
              rows="3"
            >{{ old('description', $user->description) }}</textarea>
          </div>

          <div class="mb-3">
            <label for="profile_image" class="form-label">Profile Image URL</label>
            <input 
              type="url" 
              class="form-control" 
              id="profile_image" 
              name="profile_image" 
              value="{{ old('profile_image', $user->profile_image) }}"
              placeholder="https://example.com/image.jpg"
            />
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
<script>
     window.addEventListener('load', function() {
      document.querySelector('.profile-container').classList.add('loaded');
    });
</script>

<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
  crossorigin="anonymous">
</script>
<script>
  document.querySelectorAll('.stat-item[data-target="posts"]').forEach(item => {
    item.addEventListener('click', () => {
      window.location.href = "{{ route('homee') }}";
    });
  });
</script>
@endsection

