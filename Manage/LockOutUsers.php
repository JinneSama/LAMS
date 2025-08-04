<?php
ob_start();
$title = "Locked Accounts";
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Locked Users</h3>
            </div>
            <div class="card-body">
                <div id="GridLockedUsers"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var lockedUsersGrid = new ej.grids.Grid({
        dataSource: new ej.data.DataManager({
            url: '../data/FetchLockoutUsers.php',
            adaptor: new ej.data.UrlAdaptor()
        }),
        height: 250,
        allowPaging: true,
        columns: [
            { field: 'Id', headerText: 'ID', isPrimaryKey: true, width: 100, visible: false },
            { field: 'Username', headerText: 'Username', width: 200 },
            {
                headerText: 'Unlock Account',
                width: 130,
                template: function(data) {
                    return `
                        <button class="e-btn e-flat e-warning e-small unlock-btn" data-id="${data.Id}" title="Unlock Account">
                            <i class="fas fa-lock-open"></i>
                        </button>
                    `;
                },
                textAlign: 'Center'
            }
        ]
    });
    lockedUsersGrid.appendTo('#GridLockedUsers');
</script>

<script>
    document.addEventListener('click', function(event) {
        const btn = event.target.closest('.unlock-btn');
        if (btn) {
            const id = btn.getAttribute('data-id');
            if (confirm('Are you sure you want to unlock this user?')) {
                fetch('../data/UnlockUser.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('User unlocked successfully');
                        lockedUsersGrid.refresh(); // reload grid
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }
    });
</script>

<?php
$content = ob_get_clean();
include '../Layout/MainLayout.php';
?>
