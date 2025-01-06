@extends('layouts.template')

@section('content')
<style>
    /* General Styles */
    html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        background: #111;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #ccc;
    }

    .content-wrapper {
        display: flex;
        flex-direction: column;
        padding: 2rem;
        width: 100%;
        min-height: 100vh;
        background: #111;
        box-sizing: border-box;
    }

    .notifications-header {
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notifications-header h2 {
        color: #fff;
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .notifications-header p {
        color: #888;
        margin: 0;
        font-size: 1rem;
    }

    .notifications-table-container {
        background: #222;
        border-radius: 8px;
        padding: 1.5rem;
        border: 1px solid #333;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        color: #ccc;
    }

    table thead {
        background: #333;
    }

    table thead th {
        padding: 0.8rem;
        text-align: left;
        font-size: 1rem;
        color: #fff;
        border-bottom: 2px solid #444;
    }

    table tbody tr {
        transition: background 0.3s ease;
        cursor: pointer;
    }

    table tbody tr:hover {
        background: #444;
    }

    table tbody td {
        padding: 0.8rem;
        font-size: 0.95rem;
        border-bottom: 1px solid #333;
        vertical-align: middle;
    }

    table tbody td:first-child {
        width: 40px;
        text-align: center;
    }

    table tbody td:last-child {
        text-align: center;
        width: 120px;
    }

    .empty-message {
        text-align: center;
        color: #888;
        padding: 2rem 0;
        font-size: 1.2rem;
    }

    .btn-clear {
        background: #f44336; /* Red background */
        color: #fff;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.95rem;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-clear:hover {
        background: #d32f2f; /* Darker red on hover */
        transform: scale(1.05);
    }

    /* Confirm Modal Styles */
    #clearConfirmModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    #clearConfirmModal.show {
        display: flex;
    }

    #clearConfirmModal .modal {
        background: #222;
        border: 1px solid #333;
        border-radius: 8px;
        padding: 1.5rem;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    #clearConfirmModal .modal h3 {
        color: #fff;
        margin-bottom: 1rem;
    }

    #clearConfirmModal .modal p {
        color: #ccc;
        margin-bottom: 1.5rem;
    }

    #clearConfirmModal .modal-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    #clearConfirmModal .modal-actions button {
        padding: 0.6rem 1rem;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    #clearConfirmModal .btn-cancel {
        background: #800;
        color: #fff;
    }

    #clearConfirmModal .btn-cancel:hover {
        background: #900;
    }

    #clearConfirmModal .btn-proceed {
        background: #4CAF50;
        color: #fff;
    }

    #clearConfirmModal .btn-proceed:hover {
        background: #45a049;
    }

    /* Notification Types Styles */
    .notification-like {
        color: #4CAF50; /* Green */
        font-weight: bold;
    }

    .notification-comment {
        color: #2196F3; /* Blue */
        font-weight: bold;
    }

    .notification-comment-like {
        color: #FF9800; /* Orange */
        font-weight: bold;
    }

    .notification-reply {
        color: #9C27B0; /* Purple */
        font-weight: bold;
    }
    .notification-follow {
        color: yellow; 
        font-weight: bold;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .notifications-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-clear {
            margin-top: 1rem;
            width: 100%;
        }
    }
    .content-wrapper{
        opacity: 0;
        transition: opacity 1s ease-in;
    }
    .content-wrapper.loaded {
        opacity: 1;
    }
</style>

<div class="content-wrapper">
    <div class="notifications-header">
        <div>
            <h2>Notifications</h2>
            <p>Stay updated with the latest interactions on your posts.</p>
        </div>
        <button id="clearNotificationsBtn" class="btn-clear">Clear Notifications</button>
    </div>

    <div class="notifications-table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Message</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $index = 1;
                @endphp

                @forelse ($notifications as $notification)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>
                            @switch($notification->type)
                                @case('like')
                                    <strong>{{ $notification->user_name }}</strong> <span class="notification-like">liked</span> your post.
                                    @break

                                @case('comment')
                                    <strong>{{ $notification->user_name }}</strong> <span class="notification-comment">commented:</span> "{{ $notification->comment_text }}"
                                    @break

                                @case('comment_like')
                                    <strong>{{ $notification->user_name }}</strong> <span class="notification-comment-like">liked</span> your comment.
                                    @break

                                @case('reply')
                                    <strong>{{ $notification->user_name }}</strong> <span class="notification-reply">replied</span> to your comment.
                                    @break  
                                
                                @case('new_follower')
                                    <strong>{{ $notification->user_name }}</strong> has <span class="notification-follow">followed</span> you.
                                    @break     

                                @default
                                    <strong>{{ $notification->user_name }}</strong> performed an action.
                            @endswitch
                        </td>
                        <td>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-message">No new notifications</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Clear Notifications Modal -->
<div id="clearConfirmModal">
    <div class="modal">
        <h3>Confirm Action</h3>
        <p>Are you sure you want to clear all notifications?</p>
        <div class="modal-actions">
            <button id="cancelClearBtn" class="btn-cancel">Cancel</button>
            <button id="proceedClearBtn" class="btn-proceed">Clear</button>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        document.querySelector('.content-wrapper').classList.add('loaded');
    });

    document.addEventListener('DOMContentLoaded', () => {
        const clearNotificationsBtn = document.getElementById('clearNotificationsBtn');
        const clearConfirmModal = document.getElementById('clearConfirmModal');
        const cancelClearBtn = document.getElementById('cancelClearBtn');
        const proceedClearBtn = document.getElementById('proceedClearBtn');

        // Show the confirmation modal
        clearNotificationsBtn.addEventListener('click', () => {
            clearConfirmModal.classList.add('show');
        });

        // Hide the confirmation modal
        cancelClearBtn.addEventListener('click', () => {
            clearConfirmModal.classList.remove('show');
        });

        // Proceed with clearing notifications
        proceedClearBtn.addEventListener('click', () => {
            clearConfirmModal.classList.remove('show'); // Close the modal
            fetch("{{ route('clear.notifications') }}", { // Ensure the route matches your routes
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
        
                    location.reload(); // Reload the page to update the UI
                } else {
                   
                }
            })
            .catch(error => {
                console.error('Error clearing notifications:', error);
               
            });
        });
    });
</script>
@endsection
