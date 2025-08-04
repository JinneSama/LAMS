<li class="nav-item">
    <a href="<?= BASE_URL ?>/manage/users" class="nav-link <?= strpos($current_page, '/manage/users') !== false ? 'active' : '' ?>">
        <i class="fas fa-users nav-icon"></i>
        <p>Users</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= BASE_URL ?>/manage/roles" class="nav-link <?= strpos($current_page, '/manage/roles') !== false ? 'active' : '' ?>">
        <i class="fas fa-user-tag nav-icon"></i>
        <p>Roles</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= BASE_URL ?>/manage/passwordresetrequest" class="nav-link <?= strpos($current_page, '/manage/passwordresetrequest') !== false ? 'active' : '' ?>">
        <i class="fas fa-unlock nav-icon"></i>
        <p>Password Requests</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= BASE_URL ?>/manage/LockOutUsers" class="nav-link <?= strpos($current_page, '/manage/LockOutUsers') !== false ? 'active' : '' ?>">
        <i class="fas fa-unlock nav-icon"></i>
        <p>Locked Accounts</p>
    </a>
</li>