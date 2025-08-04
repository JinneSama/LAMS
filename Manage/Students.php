<?php
$title = "Students";
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
                <!-- Custom Add Modal -->
                <div class="modal fade" id="attendeeModal" tabindex="-1">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <form id="attendeeForm" class="modal-content" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitle">Attendee Form</h5>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id">
                                <input type="hidden" name="action" value="insert">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input name="first_name" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input name="middle_name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input name="last_name" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Ext.</label>
                                            <input name="name_ext" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Course ID</label>
                                            <select name="course_id" id="courseSelect" class="form-control" required>
                                                <option value="">Select Course</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Year</label>
                                            <input name="year" type="number" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Date Enrolled</label>
                                            <input name="date_enrolled" type="date" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>School ID</label>
                                            <input name="school_id" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <label>Photo</label>
                                        <div class="border rounded mb-2" style="width:200px;height:200px;margin:auto;">
                                            <img id="previewImage" src="" alt="Preview" style="width:100%;height:100%;object-fit:cover;display:none;">
                                        </div>
                                        <input type="file" name="photo" class="form-control" accept="image/*" onchange="previewPhoto(this)">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    const modal = new bootstrap.Modal(document.getElementById('attendeeModal'));
    let courseDropDown = new ej.data.DataManager({
        url: '../data/FetchCourseAll.php',
        adaptor: new ej.data.UrlAdaptor()
    });
    const attendeeGrid = new ej.grids.Grid({
        dataSource: new ej.data.DataManager({
            url: '../data/FetchAttendee.php',
            removeUrl: '../data/ManageAttendee.php',
            insertUrl: '../data/ManageAttendee.php',
            updateUrl: '../data/ManageAttendee.php',
            adaptor: new ej.data.UrlAdaptor()
        }),
        toolbar: [{
            text: 'Add',
            tooltipText: 'Add',
            prefixIcon: 'e-add',
            id: 'add'
        }],
        editSettings: {
            allowDeleting: true,
            showDeleteConfirmDialog: true,
            mode: 'Dialog' // But overridden by custom modal
        },
        columns: [
            { field: 'id', isPrimaryKey: true, visible: false },
            { field: 'first_name', headerText: 'First Name', width: 120 },
            { field: 'last_name', headerText: 'Last Name', width: 120 },
            { field: 'course_id', headerText: 'Course', width: 120, foreignKeyField: 'id', foreignKeyValue: 'name', dataSource: courseDropDown },
            { field: 'year', headerText: 'Year', width: 80 },
            { field: 'date_enrolled', headerText: 'Enrolled', width: 120 },
            {
                headerText: 'Actions',
                width: 100,
                template: function(data) {
                    return `<button class="btn btn-sm btn-info edit-btn" data-id="${data.id}"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-info view-btn" data-id="${data.id}"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-sm btn-info generate-qr-btn" data-id="${data.id}"><i class="fas fa-qrcode"></i></button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="${data.id}"><i class="fas fa-trash"></i></button>`;
                }
            }
        ]
    });

    attendeeGrid.appendTo('#GridAttendee');

    attendeeGrid.toolbarClick = function(args) {
        if (args.item.id === 'add') {
            openAddModal();
            args.cancel = true;
        }
    };

    async function loadCourseOptions() {
        const response = await fetch('../data/FetchCourseAll.php'); // adjust path as needed
        const courses = await response.json();
        const select = document.getElementById('courseSelect');

        // Clear existing options except the default
        select.innerHTML = '<option value="">Select Course</option>';

        courses.forEach(course => {
            const opt = document.createElement('option');
            opt.value = course.id;
            opt.textContent = course.name;
            select.appendChild(opt);
        });
    }

    // Load course options on page load
    document.addEventListener('DOMContentLoaded', loadCourseOptions);
        // Handle custom edit button
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-btn')) {
            const id = parseInt(e.target.getAttribute('data-id'));
            const records = attendeeGrid.getCurrentViewRecords(); // only current page
            const data = records.find(row => Number(row.id) === id);
            if (data) {
                openEditModal(data); // your function to populate and show the modal
            } else {
                console.warn('Row data not found for id:', id);
            }
        }
    });

    document.addEventListener('click', function (e) {
    const id = parseInt(e.target.closest('button')?.getAttribute('data-id'));
    if (!id) return;

    // View button
    if (e.target.closest('.view-btn')) {
        const records = attendeeGrid.getCurrentViewRecords();
        const data = records.find(row => Number(row.id) === id);
        if (data) {
            openViewModal(data); // implement this
        }
    }

    // Delete button
    if (e.target.closest('.delete-btn')) {
        if (confirm('Are you sure you want to delete this attendee?')) {
            fetch('../data/ManageAttendee.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: 'remove', key: id })
            })
            .then(res => res.json())
            .then(() => {
                attendeeGrid.refresh();
            })
            .catch(console.error);
        }
    }
    });

    document.getElementById('attendeeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        fetch('../data/ManageAttendee.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            modal.hide();
            form.reset();
            document.getElementById('previewImage').style.display = 'none';
            attendeeGrid.refresh(); // ✅ refresh after submit
        })
        .catch(console.error);
    });

    function previewPhoto(input) {
        const file = input.files[0];
        const img = document.getElementById('previewImage');
        if (file) {
            img.src = URL.createObjectURL(file);
            img.style.display = 'block';
        }
    }

    function openAddModal() {
        const form = document.getElementById('attendeeForm');
        document.getElementById('modalTitle').textContent = 'Add Student';
        form.reset();
        form.action.value = 'insert';
        form.id.value = '';
        document.getElementById('previewImage').style.display = 'none';
        modal.show();
    }

    function openEditModal(data) {
        const form = document.getElementById('attendeeForm');
        document.getElementById('modalTitle').textContent = 'Edit Student';
        form.reset();
        form.action.value = 'update';
        form.id.value = data.id;
        form.first_name.value = data.first_name || '';
        form.middle_name.value = data.middle_name || '';
        form.last_name.value = data.last_name || '';
        form.name_ext.value = data.name_ext || '';
        form.course_id.value = data.course_id || '';
        form.year.value = data.year || '';
        form.date_enrolled.value = data.date_enrolled?.split(' ')[0] || '';
        form.school_id.value = data.school_id || '';
        if (data.image_path) {
            document.getElementById('previewImage').src = `../${data.image_path}`;
            document.getElementById('previewImage').style.display = 'block';
        } else {
            document.getElementById('previewImage').style.display = 'none';
        }
        modal.show();
    }
    function openViewModal(data) {
    const form = document.getElementById('attendeeForm');
    document.getElementById('modalTitle').textContent = 'View Student';
    form.reset();

    form.action.value = ''; // disable saving
    form.id.value = data.id;
    form.first_name.value = data.first_name;
    form.middle_name.value = data.middle_name;
    form.last_name.value = data.last_name;
    form.name_ext.value = data.name_ext;
    form.course_id.value = data.course_id;
    form.year.value = data.year;
    form.date_enrolled.value = data.date_enrolled.split(' ')[0];
    form.school_id.value = data.school_id;

    if (data.image_path) {
        document.getElementById('previewImage').src = `../${data.image_path}`;
        document.getElementById('previewImage').style.display = 'block';
    }

    // Disable all inputs
    form.querySelectorAll('input, select, textarea').forEach(el => el.disabled = true);
    form.querySelector('button[type="submit"]').style.display = 'none';

    modal.show();

    // Re-enable after modal closes
    document.getElementById('attendeeModal').addEventListener('hidden.bs.modal', () => {
        form.querySelectorAll('input, select, textarea').forEach(el => el.disabled = false);
        form.querySelector('button[type="submit"]').style.display = '';
    }, { once: true });
}

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