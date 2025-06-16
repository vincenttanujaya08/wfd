@extends('admin.layouts.template')
@section('title','Reports Queue')
@section('content')
  <table class="admin-table">
    <thead>
      <tr><th>ID</th><th>Reporter</th><th>Target</th><th>Status</th><th>Action</th></tr>
    </thead>
    <tbody>
      @foreach($reports as $r)
      <tr>
        <td>{{ $r->id }}</td>
        <td>{{ $r->reporter->name }}</td>
        <td>{{ $r->reportedUser->name }}</td>
        <td>{{ ucfirst($r->status) }}</td>
        <td><a class="btn" href="{{ route('admin.reports.show',$r) }}">View</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $reports->links() }}
@endsection