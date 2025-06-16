@extends('admin.layouts.template')
@section('title','Banned Users')
@section('content')
  <table class="admin-table">
    <thead><tr><th>User</th><th>Banned At</th><th>Until</th><th>Reason</th></tr></thead>
    <tbody>
      @foreach($bans as $ban)
      <tr>
        <td>{{ $ban->user->name }}</td>
        <td>{{ $ban->banned_at }}</td>
        <td>{{ $ban->banned_until ?? '—' }}</td>
        <td>{{ $ban->reason }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $bans->links() }}
@endsection