@extends('admin.layouts.template')

@section('title','User Management')

@section('content')
<table class="admin-table">
  <thead>
    <tr>
      <th>ID</th><th>Name</th><th>Role</th><th>Status</th>
      <th>Reports</th><th>Warnings</th><th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $u)
    <tr>
      <td>{{ $u->id }}</td>
      <td>{{ $u->name }}</td>
      <td>{{ $u->role->name }}</td>
      <td>{{ $u->bans->where('is_active',1)->isNotEmpty() ? 'Banned' : 'Active' }}</td>
      <td>{{ $u->reportsReceived->count() }}</td>
      <td>{{ $u->warnings->count() }}</td>
      <td>
        <a href="{{ route('admin.users.edit', $u) }}">Edit</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $users->links() }}
@endsection
