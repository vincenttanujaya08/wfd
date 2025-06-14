<h1>halo, admin!</h1>

<div class="sidebar-footer">
    <form class="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="nav-item" aria-label="Logout">
            <i class="lni lni-exit" aria-hidden="true"></i>
            <span class="nav-text">LOGOUT</span>
        </button>
    </form>
</div>