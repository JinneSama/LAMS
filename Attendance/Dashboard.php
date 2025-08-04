<?php
$title = "Dashboard";
ob_start(); // Start output buffering
?>

<!-- Users -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3 id="user-count">0</h3>
                <p>Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="manage/users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Courses -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3 id="course-count">0</h3>
                <p>Courses</p>
            </div>
            <div class="icon">
                <i class="fas fa-book"></i>
            </div>
            <a href="manage/courses" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Attendance -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 id="attendance-count">0</h3>
                <p>Attendance Logs</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <a href="Attendance/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Resets -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3 id="student-count">0</h3>
                <p>Students</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <a href="manage/reset-requests.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Attendees</h3>
                    <a href="javascript:void(0);">View Report</a>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span id="attendee-count" class="text-bold text-lg">820</span>
                        <span>Attendees Over Time</span>
                    </p>

                    <p class="ml-auto d-flex flex-column text-right" id="attendance-change">
                        <span id="change-percent" class="text-success">
                            <i class="fas fa-arrow-up"></i> <span id="percent-value">12.5%</span>
                        </span>
                        <span class="text-muted">Since last week</span>
                    </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                    <canvas id="visitors-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> This Week
                    </span>

                    <span>
                        <i class="fas fa-square text-gray"></i> Last Week
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Attendees Today</h3>
                    <a href="../Attendance/AttendanceList">View All</a>
                </div>
            </div>
            <div class="card-body">
                <div id="Grid"></div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-md-6 -->
    </div>

    <!-- Add more rows/widgets here -->
    <script>
        ej.grids.Grid.Inject(ej.grids.PdfExport, ej.grids.Toolbar, ej.grids.Search);
        var grid = new ej.grids.Grid({
            dataSource: new ej.data.DataManager({
                url: '../data/fetchattendance.php?filter=1',
                adaptor: new ej.data.UrlAdaptor(),
                offline: true
            }),
            allowPaging: true,
            allowSorting: true,
            allowFiltering: true,
            allowPdfExport: true,
            filterSettings: {
                type: 'Excel',
            },
            pageSettings: {
                pageSize: 10
            },
            columns: [{
                    field: 'Id',
                    headerText: 'ID',
                    width: 80
                },
                {
                    field: 'fullName',
                    headerText: 'Student Name',
                    width: 200
                },
                {
                    field: 'TypeName',
                    headerText: 'Attendance Type',
                    width: 150
                },
                {
                    field: 'DateAttended',
                    headerText: 'Date/Time Attended',
                    width: 180,
                    type: 'dateTime', // ✅ better type for datetime
                    format: {
                        type: 'dateTime',
                        format: 'yyyy/MM/dd h:mm a'
                    },
                    filter: {
                        type: 'Menu'
                    }
                }
            ]
        });

        grid.appendTo('#Grid');

        document.getElementById('printToPdfBtn').addEventListener('click', function() {
            grid.pdfExport({
                exportType: 'AllPages',
                isFiltered: true,
                fileName: 'Attendance.pdf',
                header: {
                    fromTop: 0,
                    height: 100,
                    contents: [{
                        type: 'Text',
                        value: 'LAMS Attendance Report',
                        position: {
                            x: 150,
                            y: 20
                        },
                        style: {
                            textBrushColor: '#000000',
                            fontSize: 18,
                            bold: true
                        }
                    }]
                }
            })
        });
    </script>

    <script>
        function updateAttendeeCount(total) {
            document.getElementById('attendee-count').textContent = total;
        }

        function updateAttendanceChange(thisWeekTotal, lastWeekTotal) {
            const percentSpan = document.getElementById('change-percent');
            const valueSpan = document.getElementById('percent-value');

            if (!lastWeekTotal || lastWeekTotal === 0) {
                valueSpan.textContent = "N/A";
                return;
            }

            const diff = thisWeekTotal - lastWeekTotal;
            const percentChange = ((diff / lastWeekTotal) * 100).toFixed(1);

            // Set the arrow and color
            if (percentChange > 0) {
                percentSpan.className = 'text-success';
                percentSpan.innerHTML = `<i class="fas fa-arrow-up"></i> <span id="percent-value">${percentChange}%</span>`;
            } else if (percentChange < 0) {
                percentSpan.className = 'text-danger';
                percentSpan.innerHTML = `<i class="fas fa-arrow-down"></i> <span id="percent-value">${Math.abs(percentChange)}%</span>`;
            } else {
                percentSpan.className = 'text-muted';
                percentSpan.innerHTML = `<i class="fas fa-minus"></i> <span id="percent-value">0%</span>`;
            }
        }

        fetch('../data/weeklyAttendance.php')
            .then(res => res.json())
            .then(data => {
                const thisWeekTotal = data.thisWeek.reduce((a, b) => a + b, 0);
                const lastWeekTotal = data.lastWeek.reduce((a, b) => a + b, 0);
                const grandTotal = thisWeekTotal + lastWeekTotal;

                updateAttendeeCount(grandTotal);
                updateAttendanceChange(thisWeekTotal, lastWeekTotal); // From previous step
            });
    </script>


    <script>
        fetch('../data/dashboardmetrics.php')
            .then(res => res.json())
            .then(data => {
                document.getElementById('user-count').textContent = data.users;
                document.getElementById('course-count').textContent = data.courses;
                document.getElementById('attendance-count').textContent = data.attendance;
                document.getElementById('student-count').textContent = data.students;
            })
            .catch(err => {
                console.error('Failed to load dashboard metrics:', err);
            });
    </script>
    <?php
    $content = ob_get_clean();
    include '../Layout/MainLayout.php'; // Your AdminLTE-based layout file
    ?>