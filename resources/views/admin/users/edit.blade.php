@extends('admin.layouts.template')
@section('title','Edit User')
@section('content')
  <form action="{{ route('admin.users.update',$user) }}" method="POST">
    @csrf @method('PUT')
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name',$user->name) }}">
    <label>Role</label>
    <select name="role_id">
      @foreach($roles as $r)
        <option value="{{ $r->id }}" @selected($r->id == $user->role_id)>{{ $r->name }}</option>
      @endforeach
    </select>
    <button type="submit" class="btn-submit">Save Changes</button>
  </form>
@endsection