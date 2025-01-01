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
    background-color: #000;
  }

  .profile-container {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    padding: 20px;
    gap: 20px;
    box-sizing: border-box;
  }

  .profile-image {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
  }

  .profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .user-info {
    flex: 1;
    max-width: 500px;
    color: #fff;
    text-align: center;
  }

  @media (min-width: 768px) {
    .user-info {
      text-align: left;
    }
  }

  .username {
    font-size: 1.5rem;
    font-weight: bold;
    word-wrap: break-word;
    word-break: break-word;
  }

  .description {
    font-size: 1rem;
    color: #bbb;
    word-wrap: break-word;
    word-break: break-word;
    margin-top: 10px;
  }

  .stats-container {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
  }

  @media (min-width: 768px) {
    .stats-container {
      justify-content: flex-start;
    }
  }

  .stat-item {
    text-align: center;
  }

  .stat-item strong {
    font-size: 1.2rem;
  }
</style>

<div class="profile-container">
  <!-- Profile Image -->
  <div class="profile-image">
    <img 
      src="{{ $user->profile_image ?? 'https://via.placeholder.com/200' }}" 
      alt="Profile Image"
    />
  </div>

  <!-- User Info -->
  <div class="user-info">
    <div class="d-flex justify-content-between align-items-center">
      <!-- Username -->
      <div class="username">
        {{ $user->name ?? 'Username' }}
      </div>
      <!-- Edit Profile Button -->
      <button 
        class="btn btn-outline-light btn-sm" 
        data-bs-toggle="modal" 
        data-bs-target="#editProfileModal"
      >
        Edit Profile
      </button>
    </div>

    <!-- Description -->
    <div class="description">
      {{ $user->description ?? 'A little description...' }}
    </div>

    <!-- Stats -->
    <div class="stats-container">
      <div class="stat-item">
        <strong>20</strong><br>
        <span>Post</span>
      </div>
      <div class="stat-item">
        <strong>50</strong><br>
        <span>Follower</span>
      </div>
      <div class="stat-item">
        <strong>31</strong><br>
        <span>Following</span>
      </div>
    </div>
  </div>
</div>

<!-- Edit Profile Modal -->
<div 
  class="modal fade" 
  id="editProfileModal" 
  tabindex="-1" 
  aria-labelledby="editProfileModalLabel" 
  aria-hidden="true"
>
  <div class="modal-dialog">
    <form 
      action="{{ route('profile.update') }}" 
      method="POST"
    >
      @csrf
      <div class="modal-content" style="background-color: #222; color: #fff;">
        <div class="modal-header" style="border-bottom: 1px solid #444;">
          <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
          <button 
            type="button" 
            class="btn-close btn-close-white" 
            data-bs-dismiss="modal" 
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <!-- Username -->
          <div class="mb-3">
            <label for="name" class="form-label">Username</label>
            <input 
              type="text" 
              class="form-control bg-dark text-white" 
              id="name" 
              name="name" 
              value="{{ old('name', $user->name) }}" 
              required
            />
          </div>
          <!-- Description -->
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea 
              class="form-control bg-dark text-white" 
              id="description" 
              name="description" 
              rows="3"
            >{{ old('description', $user->description) }}</textarea>
          </div>
          <!-- Profile Image URL -->
          <div class="mb-3">
            <label for="profile_image" class="form-label">Profile Image URL</label>
            <input 
              type="url" 
              class="form-control bg-dark text-white" 
              id="profile_image" 
              name="profile_image" 
              value="{{ old('profile_image', $user->profile_image) }}"
              placeholder="https://example.com/image.jpg"
            />
            <small class="text-muted">Provide a valid image URL.</small>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #444;">
          <button 
            type="button" 
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Cancel
          </button>
          <button type="submit" class="btn btn-primary">
            Save Changes
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap JS -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
  crossorigin="anonymous">
</script>
@endsection
