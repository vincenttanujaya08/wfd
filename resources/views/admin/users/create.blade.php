{{-- resources/views/admin/users/create.blade.php --}}
@extends('admin.layouts.template')

@section('title', 'Add New User')

@section('head')
    <style>
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: #f9f9f9;
            border-radius: .5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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

         /* Error toast */
        .alert-error {
            position: fixed;
            top: 1rem;
            left: 52%;
            transform: translateX(-50%);
            max-width: 320px;
            width: 100%;
            background: #dc2626; /* red-600 */
            color: white;
            border-radius: .5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            display: flex;
            align-items: flex-start;
            padding: 1rem;
            gap: .75rem;
            z-index: 10000;
        }
        .alert-error i {
            font-size: 1.75rem;
            line-height: 1;
        }
        .alert-error .message {
            flex: 1;
        }
        .alert-error .message .title {
            font-weight: bold;
            margin-bottom: .25rem;
        }
        .alert-error .message .text {
            font-size: .9rem;
        }
        .alert-error button.close {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.25rem;
            line-height: 1;
            cursor: pointer;
        }
    </style>
    {{-- Alpine.js --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('content')
    {{-- Error toast --}}
    @if($errors->any())
      <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 5000)"
        class="alert-error"
      >
        <i class="lni lni-cross-circle"></i>
        <div class="message">
          <div class="title">Error!</div>
          <div class="text">{{ $errors->first() }}</div>
        </div>
        <button class="close" @click="show = false">&times;</button>
      </div>
    @endif

    <div class="form-container">
      <h1>Create New User</h1>
      <form action="{{ route('admin.users.store') }}" method="POST">
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
