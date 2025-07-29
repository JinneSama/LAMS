<?php
$title = "Users";
ob_start();
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Users</h3>
            </div>
            <div class="card-body">
                <div id="GridUser"></div>
            </div>
        </div>
    </div>
</div>

<!-- Dialog Template -->
<script type="text/x-template" id="userDialogTemplate">
    <div>
        <div class="form-group">
            <label>Username</label>
            <input name="username" class="e-input" type="text" />
        </div>
        <div class="form-group">
            <label>Role</label>
            <input id="role_dropdown" name="RoleId" class="e-input"/>
        </div>
        <div id="password-row" class="form-group">
            <label>Password</label>
            <input name="password" class="e-input" type="password" />
        </div>
        <div id="confirm-password-row" class="form-group">
            <label>Confirm Password</label>
            <input name="confirm_password" class="e-input" type="password" />
        </div>
    </div>
</script>


<script>
    ej.grids.Grid.Inject(ej.grids.Filter);
    let roles = new ej.data.DataManager({
    url: '../data/FetchRole.php',
    adaptor: new ej.data.UrlAdaptor()
});

var grid1 = new ej.grids.Grid({
    dataSource: new ej.data.DataManager({
        url: '../data/FetchUser.php',
        insertUrl: '../data/ManageUser.php',
        updateUrl: '../data/ManageUser.php',
        removeUrl: '../data/ManageUser.php',
        adaptor: new ej.data.UrlAdaptor()
    }),
    height: 400,
    allowPaging: true,
    allowFiltering: true, // ✅ Enable filtering
    filterSettings: { type: 'Excel' },
    toolbar: ['Add', 'Edit', 'Delete', 'Update', 'Cancel'],
    editSettings: {
        allowAdding: true,
        allowEditing: true,
        allowDeleting: true,
        mode: 'Dialog',
        showDeleteConfirmDialog: true,
        template: '#userDialogTemplate'
    },
    columns: [
        { field: 'Id', headerText: 'ID', isPrimaryKey: true, visible: false },
        { field: 'username', headerText: 'Username', validationRules: { required: true } },
        {
            field: 'RoleId',
            headerText: 'Role',
            foreignKeyField: 'Id',
            foreignKeyValue: 'RoleName',
            dataSource: roles,
            validationRules: { required: true }
        }
    ],
    actionComplete: function (args) {
        if (args.requestType === 'beginEdit' || args.requestType === 'add') {
            const isAdd = args.requestType === 'add';

            const roleDropdown = new ej.dropdowns.DropDownList({
                dataSource: roles,
                fields: { text: 'RoleName', value: 'Id' },
                placeholder: 'Select Role',
                value: args.rowData ? args.rowData.RoleId : null
            });
            roleDropdown.appendTo('#role_dropdown');

            document.getElementById('password-row').style.display = isAdd ? 'block' : 'none';
            document.getElementById('confirm-password-row').style.display = isAdd ? 'block' : 'none';

            if (args.rowData && !isAdd) {
                document.querySelector('input[name="username"]').value = args.rowData.username;
            } else {
                document.querySelector('input[name="username"]').value = '';
                document.querySelector('input[name="password"]').value = '';
                document.querySelector('input[name="confirm_password"]').value = '';
            }
        }
    }
});
grid1.appendTo('#GridUser');

</script>

<?php
$content = ob_get_clean();
include '../Layout/MainLayout.php';
?>
