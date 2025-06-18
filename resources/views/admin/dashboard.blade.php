{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.template')
@section('title', 'Dashboard')

@section('head')
    <style>
        /* Cards */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .card {
            background: #fff;
            border-radius: .5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
            text-align: center;
        }

        .card h4 {
            margin-bottom: .5rem;
            color: #374151;
            font-weight: 500;
        }

        .card p {
            font-size: 1.75rem;
            font-weight: 600;
            color: #111827;
        }

        /* Filter bar */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            margin-bottom: 1rem;
            align-items: center;
        }

        .filter-bar input,
        .filter-bar select {
            padding: .4rem .6rem;
            border: 1px solid #ccc;
            border-radius: .25rem;
            font-size: .9rem;
        }

        .filter-bar button {
            padding: .5rem 1rem;
            background: #6574cd;
            color: #fff;
            border: none;
            border-radius: .25rem;
            cursor: pointer;
        }

        .filter-bar button:hover {
            background: #4b5bb5;
        }

        /* Table */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th,
        td {
            padding: .75rem 1rem;
            border-bottom: 1px solid #eee;
            text-align: left;
            white-space: nowrap;
        }

        thead {
            background: #f7f7f7;
        }

        .btn {
            padding: .5rem 1rem;
            border: none;
            border-radius: .375rem;
            font-size: .875rem;
            cursor: pointer;
        }

        .btn-add {
            background: #1dc071;
            color: #fff;
        }

        .btn-edit {
            background: #6574cd;
            color: #fff;
        }

        .btn-view {
            background: #3490dc;
            color: #fff;
        }

        .btn-prev,
        .btn-next {
            background: #e2e8f0;
            color: #555;
        }

        .filter-controls {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            align-items: center;
        }

        .filter-controls input,
        .filter-controls select {
            padding: .4rem .6rem;
            border: 1px solid #ccc;
            border-radius: .25rem;
            font-size: .9rem;
        }

        .filter-controls button {
            padding: .5rem 1rem;
            background: #6574cd;
            color: #fff;
            border: none;
            border-radius: .25rem;
            cursor: pointer;
        }

        .filter-controls button:hover {
            background: #4b5bb5;
        }

        /* Create button */
        .btn-add {
            padding: .5rem 1rem;
            background: #1dc071;
            color: #fff;
            border: none;
            border-radius: .375rem;
            font-size: .875rem;
            white-space: nowrap;
            align-self: flex-start;
            /* keep at top if wrapped */
        }

        .btn-add:hover {
            background: #17a556;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .card {
            background: #fff;
            border-radius: .5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
            text-align: center;
        }

        .card h4 {
            margin-bottom: .5rem;
            color: #374151;
            font-weight: 500;
        }

        .card p {
            font-size: 1.75rem;
            font-weight: 600;
            color: #111827;
        }

        /* Filter bar */
        .filter-bar {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .5rem;
            margin-bottom: 1rem;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    {{-- Cards --}}
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

    </div>

    {{-- Filter & Search --}}
    <div class="filter-bar">
        <form method="GET" class="filter-controls">
            <input id="user-search" type="text" name="search" placeholder="Search…" value="{{ $q }}" />

            <select id="user_role" name="filter_role">
                <option value="">All Roles</option>
                <option value="1" {{ $roleFilter == '1' ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ $roleFilter == '2' ? 'selected' : '' }}>User</option>
                <option value="3" {{ $roleFilter == '3' ? 'selected' : '' }}>Banned</option>
            </select>

            <select id="user_status" name="filter_status">
                <option value="">All Status</option>
                <option value="active" {{ $statusFilter == 'active' ? 'selected' : '' }}>Active</option>
                <option value="banned" {{ $statusFilter == 'banned' ? 'selected' : '' }}>Banned</option>
            </select>
            <input id="user-min-rep" type="number" name="filter_min_reports" placeholder="Min Reports" min="0"
                value="{{ $minReports }}" />
            <input id="user-max-rep" type="number" name="filter_max_reports" placeholder="Max Reports" min="0"
                value="{{ $maxReports }}" />
            <input id="user-min-warn" type="number" name="filter_min_warnings" placeholder="Min Warnings" min="0"
                value="{{ $minWarnings }}" />
            <input id="user-max-warn" type="number" name="filter_max_warnings" placeholder="Max Warnings" min="0"
                value="{{ $maxWarnings }}" />

            <button type="submit">Filter</button>
        </form>

        {{-- moved Create button here --}}
        <a href="{{ route('admin.users.create') }}" class="btn-add">Add Admin/User</a>
    </div>

    {{-- User Table --}}
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Reports</th>
                    <th>Warnings</th>
                    <th>Action</th>
                </tr>
            </thead>
             <tbody id="user-table-body">
                @foreach ($users as $u)
                    <tr>
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>
                            @if ($u->role_id == 1)
                                Admin
                            @elseif($u->role_id == 2)
                                User
                            @elseif($u->role_id == 3)
                                Banned
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            {{-- First check role: if they’re in the “Banned” role, always show Banned --}}
                            @if ($u->role_id == 3)
                                Banned
                            @else
                                Active
                            @endif
                        </td>
                        <td>{{ $u->reports_received_count }}</td>
                        <td>{{ $u->warnings_count }}</td>
                        <td><a href="{{ route('admin.users.edit', $u) }}" class="btn btn-edit">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center gap-2 mb-8">
        <button id="prev-page" class="btn btn-prev" disabled>Prev</button>
        <span id="page-info">Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</span>
        <button id="next-page" class="btn btn-next" disabled>Next</button>
    </div>



@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let currentPage = {{ $users->currentPage() }};
            let lastPage = {{ $users->lastPage() }};
            const searchInput = document.getElementById('user-search');
            const tbody = document.getElementById('user-table-body');
            const prevBtn = document.getElementById('prev-page');
            const nextBtn = document.getElementById('next-page');
            const pageInfo = document.getElementById('page-info');
            let typingTimer;

            // Simpan HTML awal & status paging
            const initialHTML = tbody.innerHTML;
            const initialInfo = pageInfo.textContent;
            const initialPrevDisabled = prevBtn.disabled;
            const initialNextDisabled = nextBtn.disabled;

            function renderRows(items) {
                tbody.innerHTML = ''; // Clear the previous rows
                items.forEach(u => {
                    // Determine the role name based on role_id
                    let roleName = '—'; // Default value
                    if (u.role_id === 1) {
                        roleName = 'Admin';
                    } else if (u.role_id === 2) {
                        roleName = 'User';
                    } else if (u.role_id === 3) {
                        roleName = 'Banned';
                    }

                    // Determine status: if role_id is 3 then always Banned, else Active
                    let status = u.role_id === 3 ? 'Banned' : 'Active';

                    // Add the row to the table
                    tbody.insertAdjacentHTML('beforeend', `
                    <tr>
                      <td>${u.id}</td>
                      <td>${u.name}</td>
                      <td>${roleName}</td>
                      <td>${status}</td>
                      <td>${u.reports_received_count}</td>
                      <td>${u.warnings_count}</td>
                      <td><a href="/admin/users/${u.id}/edit" class="btn btn-edit">Edit</a></td>
                    </tr>
                  `);
                });
            }

            function updateButtons() {
                prevBtn.disabled = currentPage <= 1;
                nextBtn.disabled = currentPage >= lastPage;
                pageInfo.textContent = `Page ${currentPage} of ${lastPage}`;
            }

            function fetchUsers(page = 1, query = '') {
                fetch(`{{ route('admin.dashboard.searchUsers') }}?q=${encodeURIComponent(query)}&page=${page}`)
                    .then(res => res.json())
                    .then(json => {
                        renderRows(json.data);
                        currentPage = json.current_page;
                        pageInfo.textContent = `Page ${json.current_page} of ${json.last_page}`;
                        prevBtn.disabled = currentPage <= 1;
                        nextBtn.disabled = currentPage >= json.last_page;
                    });
            }

            searchInput.addEventListener('input', () => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    const q = searchInput.value.trim();
                    if (q === '') {
                        // restore tampilan awal
                        tbody.innerHTML = initialHTML;
                        pageInfo.textContent = initialInfo;
                        prevBtn.disabled = initialPrevDisabled;
                        nextBtn.disabled = initialNextDisabled;
                    } else {
                        fetchUsers(1, q);
                    }
                }, 300);
            });

            prevBtn.addEventListener('click', () => {
                if (currentPage > 1) fetchUsers(currentPage - 1);
            });
            nextBtn.addEventListener('click', () => {
                if (currentPage < lastPage) fetchUsers(currentPage + 1);
            });

            // Initial enable/disable
            updateButtons();
        });
    </script>
@endsection
