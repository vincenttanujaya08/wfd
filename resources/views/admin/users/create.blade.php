@extends('admin.layouts.template')

@section('title', 'Add New User')

@section('head')
<style>
  .form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 2rem;
    background: #f9f9f9;
    border-radius: .5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .form-container h1 {
    text-align: center;
    margin-bottom: 1.5rem;
    font-size: 1.8rem;
    color: #333;
  }

  .form-container label {
    display: block;
    margin-bottom: .5rem;
    font-weight: 600;
  }

  .form-container input,
  .form-container select,
  .form-container button {
    width: 100%;
    padding: .75rem;
    margin-bottom: 1rem;
    border: 1px solid #ddd;
    border-radius: .375rem;
    font-size: 1rem;
  }

  .form-container button {
    background-color: #1dc071;
    color: white;
    font-weight: bold;
    cursor: pointer;
  }

  .form-container button:hover {
    background-color: #17a556;
  }
</style>
@endsection

@section('content')
<div class="form-container">
  <h1>Create New User</h1>
  <form action="{{ route('admin.users.store') }}" method="POST" class="form-container">
    @csrf
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name') }}" required>
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" required>
    <label>Role</label>
    <select name="role_id" required>
      <option value="1" @selected(old('role_id')==1)>Admin</option>
      <option value="2" @selected(old('role_id')==2)>User</option>
      <option value="3" @selected(old('role_id')==3)>Banned</option>
    </select>
    <button type="submit">Create User</button>
  </form>
</div>
@endsection
