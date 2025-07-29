<?php
$title = "Attendee";
ob_start();
?>
<style>
    .form-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .form-col {
        flex: 1;
        min-width: 250px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Attendees</h3>
            </div>
            <div class="card-body">
                <div id="GridAttendee"></div>
            </div>
        </div>
    </div>
</div>


<script type="text/x-template" id="dialogtemplate">
    <div class="e-form-layout">
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label>First Name</label>
                    <input name="first_name" class="e-input" type="text" />
                </div>
                <div class="form-group">
                    <label>Middle Name</label>
                    <input name="middle_name" class="e-input" type="text" />
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input name="last_name" class="e-input" type="text" />
                </div>
                <div class="form-group">
                    <label>Ext.</label>
                    <input name="name_ext" class="e-input" type="text" />
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>Course</label>
                    <input id="course_dropdown" name="course_id" class="e-input"/>
                </div>
                <div class="form-group">
                    <label>Year</label>
                    <input name="year" class="e-input" type="number" />
                </div>
                <div class="form-group">
                    <label>Date Enrolled</label>
                    <input name="date_enrolled" class="e-input" type="date" />
                </div>
                <div class="form-group">
                    <label>Image Path</label>
                    <input name="image_path" class="e-input" type="file" />
                    <div id="image-preview" style="margin-top: 10px;"></div>
                </div>
            </div>
        </div>
    </div>
</script>


<script>
    let courseDropDown = new ej.data.DataManager({
        url: '../data/FetchCourseAll.php',
        adaptor: new ej.data.UrlAdaptor()
    });
    var attendeeGrid = new ej.grids.Grid({
        dataSource: new ej.data.DataManager({
            url: '../data/FetchAttendee.php',
            insertUrl: '../data/ManageAttendee.php',
            updateUrl: '../data/ManageAttendee.php',
            removeUrl: '../data/ManageAttendee.php',
            adaptor: new ej.data.UrlAdaptor()
        }),
        toolbar: ['Add', 'Edit', 'Delete', 'Update', 'Cancel'],
        height: 400,
        allowPaging: true,
        editSettings: {
            allowAdding: true,
            allowEditing: true,
            allowDeleting: true,
            mode: 'Dialog',
            template: '#dialogtemplate'
        },
        columns: [{
                field: 'id',
                headerText: 'ID',
                isPrimaryKey: true,
                visible: false
            },
            {
                field: 'first_name',
                headerText: 'First Name',
                validationRules: {
                    required: true
                },
                width: 120
            },
            {
                field: 'middle_name',
                headerText: 'Middle Name',
                width: 120
            },
            {
                field: 'last_name',
                headerText: 'Last Name',
                validationRules: {
                    required: true
                },
                width: 120
            },
            {
                field: 'name_ext',
                headerText: 'Ext.',
                width: 60
            },
            {
                field: 'course_id',
                headerText: 'Course',
                dataSource: courseDropDown,
                validationRules: {
                    required: true
                },
                width: 150
            },
            {
                field: 'year',
                headerText: 'Year',
                type: 'number',
                width: 80
            },
            {
                field: 'date_enrolled',
                headerText: 'Date Enrolled',
                type: 'date',
                editType: 'datepickeredit',
                format: {
                    type: 'date',
                    format: 'yyyy-MM-dd'
                },
                width: 120
            },
            {
                field: 'school_id',
                headerText: 'School ID',
                width: 100
            },
            {
                field: 'image_path',
                headerText: 'Image',
                width: 150,
                template: function(data) {
                    if (data.image_path)
                        return '<a href="../' + data.image_path + '" target="_blank">' + data.image_path + '</a>';
                    return '';
                }
            },
            {
                headerText: 'Generate QR',
                width: 100,
                template: function(data) {
                    return `
                            <button class="e-btn e-flat e-success e-small generate-qr-btn" data-id="${data.id}" title="Generate QR">
                                <i class="fas fa-qrcode"></i>
                            </button>
                        `;
                },
                textAlign: 'Center'
            }

        ],
        actionComplete: function(args) {
            if (args.requestType === 'beginEdit' || args.requestType === 'add') {
                const isAdd = args.requestType === 'add';
                const data = args.rowData || {};

                const courseDropdown = new ej.dropdowns.DropDownList({
                    dataSource: new ej.data.DataManager({
                        url: '../data/FetchCourseAll.php',
                        adaptor: new ej.data.UrlAdaptor()
                    }),
                    fields: {
                        text: 'name',
                        value: 'id'
                    },
                    placeholder: 'Select Course',
                    value: data.course_id || null
                });
                courseDropdown.appendTo('#course_dropdown');

                // Populate text fields
                document.querySelector('input[name="first_name"]').value = args.rowData.first_name || '';
                document.querySelector('input[name="middle_name"]').value = args.rowData.middle_name || '';
                document.querySelector('input[name="last_name"]').value = args.rowData.last_name || '';
                document.querySelector('input[name="name_ext"]').value = args.rowData.name_ext || '';
                document.querySelector('input[name="year"]').value = args.rowData.year || '';

                const dateField = document.querySelector('input[name="date_enrolled"]');
                if (args.rowData.date_enrolled) {
                    const date = new Date(args.rowData.date_enrolled);
                    const formattedDate = date.toISOString().split('T')[0]; // yyyy-MM-dd
                    dateField.value = formattedDate;
                } else {
                    dateField.value = '';
                }

                // Show image preview if editing and image exists
                const previewContainer = document.getElementById('image-preview');
                previewContainer.innerHTML = '';

                if (!isAdd && data.image_path) {
                    const fileName = data.image_path.split('/').pop();
                    previewContainer.innerHTML = `
                <p>Current Image: <a href="../${data.image_path}" target="_blank">${fileName}</a></p>
                <img src="../${data.image_path}" alt="Image" style="max-width: 100px; display: block; margin-top: 5px;" />
            `;
                }
            }
        },
        actionBegin: function(args) {
            if (args.requestType === 'save') {
                console.log("Date Enrolled Value:", args.data.date_enrolled); // ✅ Log to console
            }
        }

    });

    attendeeGrid.appendTo('#GridAttendee');
</script>

<script>
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('generate-qr-btn')) {
            const id = event.target.getAttribute('data-id');
            const url = `../data/generateQR.php?code=${id}`;
            window.open(url, '_blank');
        }
    });
</script>

<?php
$content = ob_get_clean();
include '../Layout/MainLayout.php';
?>