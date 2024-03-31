@hasRole('super_admin')
<li class="nav-item">
    <a href="{{ route('admin.user.index') }}" class="nav-link @yield("user")">
        <i class="nav-icon fa fa-users iCheck"></i>
        <p>Users</p>
    </a>
</li>
@endhasRole
<li class="nav-item">
    <a href="{{ route('admin.artist.index') }}" class="nav-link @yield("artist")">
        <i class="nav-icon fa fa-users iCheck"></i>
        <p>Artists</p>
    </a>
</li>