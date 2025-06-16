@extends('admin.layouts.template')
@section('title','Appeals')
@section('content')
  <table class="admin-table">
    <thead><tr><th>User</th><th>Ban ID</th><th>Message</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      @foreach($appeals as $ap)
      <tr>
        <td>{{ $ap->user->name }}</td>
        <td>{{ $ap->ban_id }}</td>
        <td>{{ Str::limit($ap->message,40) }}</td>
        <td>{{ ucfirst($ap->status) }}</td>
        <td>
          <form action="{{ route('admin.appeals.update',$ap) }}" method="POST" class="flex gap-2">
            @csrf @method('PUT')
            <button name="status" value="approved" class="btn btn-add">Approve</button>
            <button name="status" value="rejected"  class="btn btn-cancel">Reject</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $appeals->links() }}
@endsection
