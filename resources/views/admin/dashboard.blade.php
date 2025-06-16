@extends('admin.layouts.template')
@section('title','Dashboard')
@section('content')

  <div class="card-grid">
    <div class="card">
      <h4>Total Users</h4>
      <p>{{ $totalUsers }}</p>
    </div>
    <div class="card">
      <h4>Active Reports</h4>
      <p>{{ $activeReports }}</p>
    </div>
    <div class="card">
      <h4>Pending Suspensions</h4>
      <p>{{ $pendingSuspensions }}</p>
    </div>
  </div>

  <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold">User Management</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-add">Add Admin/User</a>
  </div>

  <form action="{{ route('admin.users.index') }}" method="GET">
    <input type="text" name="search" value="{{ $q }}" placeholder="Search users…" class="search-input">
  </form>

  <table class="admin-table mb-8">
    <thead>
      <tr><th>ID</th><th>Name</th><th>Role</th><th>Status</th><th>Reports</th><th>Warnings</th><th>Action</th></tr>
    </thead>
    <tbody>
      @foreach($users as $u)
      <tr>
        <td>{{ $u->id }}</td>
        <td>{{ $u->name }}</td>
        {{-- <td>{{ ucfirst($u->role->name) }}</td>
        <td>{{ $u->role->name==='banned'?'Banned':'Active' }}</td>
        <td>{{ $u->reportsReceived->count() }}</td>
        <td>{{ $u->warnings->count() }}</td>
        <td><a href="{{ route('admin.users.edit',$u) }}" class="btn btn-edit">Edit</a></td> --}}
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $users->appends(request()->query())->links() }}

  <h2 class="text-xl font-semibold mb-2">Reports Queue</h2>
  <table class="admin-table">
    <thead><tr><th>ID</th><th>Reporter</th><th>Target</th><th>Status</th><th>Handled By</th><th>Action</th></tr></thead>
    <tbody>
      @foreach($reports as $r)
      <tr>
        <td>{{ $r->id }}</td>
        <td>{{ $r->reporter->name }}</td>
        <td>{{ $r->reportedUser->name }}</td>
        <td>{{ ucfirst($r->status) }}</td>
        <td>{{ optional($r->handledByAdmin)->name ?? '-' }}</td>
        <td><a href="{{ route('admin.reports.show',$r) }}" class="btn btn-view">View</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $reports->links() }}

@endsection
