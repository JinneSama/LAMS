<?php
$title = "Courses";
ob_start(); // Start capturing content
?>

<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">College</h3>
            </div>
            <div class="card-body">
                <div id="GridCollege"></div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Course</h3>
            </div>
            <div class="card-body">
                <div id="GridCourse"></div>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedCollegeId = null; // Global variable to hold selected college ID

    var grid1 = new ej.grids.Grid({
        dataSource: new ej.data.DataManager({
            url: '../data/FetchCollege.php',
            insertUrl: '../data/ManageCollege.php',
            updateUrl: '../data/ManageCollege.php',
            removeUrl: '../data/ManageCollege.php',
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
            { field: 'name', headerText: 'College Name', width: 150, validationRules: { required: true } }
        ],
        rowSelected: function(args) {
            selectedCollegeId = args.data.id;

            grid2.setProperties({
                dataSource: new ej.data.DataManager({
                    url: '../data/FetchCourse.php?college_id=' + selectedCollegeId,
                    insertUrl: '../data/ManageCourse.php?college_id=' + selectedCollegeId,
                    updateUrl: '../data/ManageCourse.php?college_id=' + selectedCollegeId,
                    removeUrl: '../data/ManageCourse.php?college_id=' + selectedCollegeId,
                    adaptor: new ej.data.UrlAdaptor()
                })
            });
            grid2.refresh();
        }
    });
    grid1.appendTo('#GridCollege');

    var grid2 = new ej.grids.Grid({
    height: 250,
    toolbar: ['Add', 'Edit', 'Delete', 'Update', 'Cancel'],
    allowPaging: true,
    editSettings: {
        allowAdding: true,
        allowEditing: true,
        allowDeleting: true,
        mode: 'Dialog',
        showDeleteConfirmDialog: true
    },
    columns: [
        { field: 'id', headerText: 'ID', isPrimaryKey: true, visible: false },
        { field: 'name', headerText: 'Course Name', width: 150, validationRules: { required: true } }
    ],
    dataSource: [],
    
    actionBegin: function (args) {
        if (args.requestType === 'save' && args.action === 'add') {
            // Inject selected college ID into new course
            args.data.college_id = selectedCollegeId;
        }
    }
});

    grid2.appendTo('#GridCourse');
</script>

<?php
$content = ob_get_clean();
include '../Layout/MainLayout.php';
?>
