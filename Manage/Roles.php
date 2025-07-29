<?php
$title = "Roles";

ob_start(); // Start capturing content
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Roles</h3>
            </div>
            <div class="card-body">
                <div id="GridUser"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var grid1 = new ej.grids.Grid({
        dataSource: new ej.data.DataManager({
            url: '../data/FetchAllRoles.php',
            insertUrl: '../data/ManageRole.php',
            updateUrl: '../data/ManageRole.php',
            removeUrl: '../data/ManageRole.php',
            adaptor: new ej.data.UrlAdaptor()
        }),
        height: 250,
        allowPaging: true,
        toolbar: ['Add', 'Edit', 'Delete', 'Update', 'Cancel'],
        editSettings: {
            allowAdding: true,
            allowEditing: true,
            allowDeleting: true,
            mode: 'Dialog',
            showDeleteConfirmDialog: true
        },
        columns: [
            { field: 'id', headerText: 'ID', isPrimaryKey: true, width: 120, visible: false },
            { field: 'name', headerText: 'Role Name', width: 150, validationRules: { required: true } }
        ]
    });
    grid1.appendTo('#GridUser');
</script>

<?php
$content = ob_get_clean(); // Store captured content in $content

include '../Layout/MainLayout.php';
?>