{{-- resources/views/admin/bans/index.blade.php --}}
@extends('admin.layouts.template')
@section('title','Banned Users')

@section('head')
<style>
  .admin-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto;
  }
  .admin-table th,
  .admin-table td {
    padding: .75rem 1rem;
    border-bottom: 1px solid #eee;
    text-align: left;
    white-space: normal;
  }
  .admin-table thead {
    background: #f3f4f6;
  }
  .admin-table th {
    font-weight: 600;
    color: #374151;
  }
  .btn-view {
    display: inline-block;
    padding: .5rem 1rem;
    background: #3b82f6;
    color: #fff;
    border-radius: .375rem;
    text-decoration: none;
  }
</style>
@endsection

@section('content')
  <div class="overflow-x-auto">
    <table class="admin-table">
      <thead>
        <tr>
          <th>User</th>
          <th>Banned At</th>
          <th>Until</th>
          <th>Reason</th>
          <th>Appeals</th>
        </tr>
      </thead>
      <tbody>
        @forelse($bans as $ban)
          <tr>
            <td>{{ $ban->user->name }}</td>
            
            {{-- parse the timestamp so format() works even if DB returns string --}}
            <td>{{ \Carbon\Carbon::parse($ban->banned_at)->format('Y-m-d H:i') }}</td>
            
            <td>
              @if($ban->banned_until)
                {{ \Carbon\Carbon::parse($ban->banned_until)->format('Y-m-d') }}
              @else
                &mdash;
              @endif
            </td>
            
            <td>{{ Str::limit($ban->reason, 50) }}</td>
            
            <td>
              <a href="{{ route('admin.appeals.index', ['ban_id'=>$ban->id]) }}" class="btn-view">
                View Appeals
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="py-6 text-center text-gray-500">
              No banned users found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $bans->links() }}
  </div>
@endsection
