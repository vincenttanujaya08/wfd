@extends('admin.layouts.template')
@section('title', 'Reports Queue')

@section('head')
    <style>
        .reports-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            /* let columns size to content */
        }

        .reports-table thead {
            background: #f3f4f6;
        }

        .reports-table th,
        .reports-table td {
            padding: .75rem 1rem;
            border-bottom: 1px solid #eee;
            white-space: normal;
            /* override the global nowrap */
            text-align: left;
        }

        .reports-table th {
            font-weight: 600;
            color: #374151;
            /* gray-700 */
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
        <table class="reports-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reporter</th>
                    <th>Target</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->reporter->name }}</td>
                        <td>{{ $r->reportedUser->name }}</td>
                        <td>
                            @if ($r->handledByAdmin)
                              Handle by  {{ $r->handledByAdmin->name }}
                            @else
                                {{ ucfirst($r->status) }}
                            @endif
                        </td>


                        <td>
                            <a href="{{ route('admin.reports.show', $r) }}" class="btn-view">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500">No reports found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $reports->links() }}</div>
@endsection
