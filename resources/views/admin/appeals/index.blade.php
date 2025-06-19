@extends('admin.layouts.template')
@section('title','')

@section('head')
<style>
  .admin-table {
    width:100%;
    border-collapse:collapse;
  }
  .admin-table th, .admin-table td {
    padding:.75rem 1rem;
    border-bottom:1px solid #eee;
    text-align:left;
  }
  .admin-table thead {
    background:#f7f7f7;
  }
  .btn-approve { background:#10b981; color:#fff; padding:.5rem 1rem; border:none; border-radius:.375rem; }
  .btn-reject  { background:#ef4444; color:#fff; padding:.5rem 1rem; border:none; border-radius:.375rem; }
</style>
@endsection

@section('content')
  <h1 class="text-xl font-semibold mb-4">Appeals</h1>
  <div class="overflow-x-auto">
    <table class="admin-table">
      <thead>
        <tr>
          <th>User</th>
          <th>Ban ID</th>
          <th>Message</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($appeals as $ap)
        <tr>
          <td>{{ $ap->user->name }}</td>
          <td>{{ $ap->ban_id }}</td>
          <td>{{ Str::limit($ap->message,40) }}</td>
          <td>{{ ucfirst($ap->status) }}</td>
          <td class="flex gap-2">
            <form action="{{ route('admin.appeals.update',$ap) }}" method="POST">
              @csrf @method('PUT')
              <button name="status" value="approved" class="btn-approve">Approve</button>
            </form>
            <form action="{{ route('admin.appeals.update',$ap) }}" method="POST">
              @csrf @method('PUT')
              <button name="status" value="rejected" class="btn-reject">Reject</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="py-6 text-center text-gray-500">
            No appeals submitted.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $appeals->links() }}</div>
@endsection
