<?php
ob_start(); // Start capturing content


$title = "Reset Requests";

?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Password Reset Requests</h3>
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
            url: '../data/FetchResetRequests.php',
            adaptor: new ej.data.UrlAdaptor()
        }),
        height: 250,
        allowPaging: true,
        columns: [
            { field: 'id', headerText: 'ID', isPrimaryKey: true, width: 120, visible: false },
            { field: 'name', headerText: 'Username', width: 150, validationRules: { required: true } },
            {
                headerText: 'Reset Password',
                width: 100,
                template: function(data) {
                    return `
                            <button class="e-btn e-flat e-success e-small reset-btn" data-id="${data.id}" title="Reset Password">
                                <i class="fas fa-unlock"></i>
                            </button>
                        `;
                },
                textAlign: 'Center'
            }
        ]
    });
    grid1.appendTo('#GridUser');
</script>

<script>
    document.addEventListener('click', function(event) {
    let btn = event.target.closest('.reset-btn');
    if (btn) {
        const id = btn.getAttribute('data-id');
        const url = `../security/changepassword.php?id=${id}`;
        window.open(url, '_blank');
    }
});
</script>

<?php
$content = ob_get_clean(); // Store captured content in $content

include '../Layout/MainLayout.php';
?>