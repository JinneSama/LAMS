<?php
$title = "Attendance List";

ob_start(); // Start capturing content
?>
<!-- Grid Container -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Attendance List</h3>
        <div class="card-tools">
            <button type="button" id="printToPdfBtn" class="btn btn-secondary btn-block btn-sm">
                <i class="fa fa-print"></i> Print Attendance
            </button>
        </div>
        <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div id="Grid"></div>
    </div>
</div>
<script>
    ej.grids.Grid.Inject(ej.grids.PdfExport, ej.grids.Toolbar, ej.grids.Search);
    var grid = new ej.grids.Grid({
        dataSource: new ej.data.DataManager({
            url: '../data/fetchattendance.php',
            adaptor: new ej.data.UrlAdaptor(),
            offline: true
        }),
        allowPaging: true,
        allowSorting: true,
        allowFiltering: true,
        allowPdfExport: true,
        toolbar: ['Search'],
        filterSettings: {
            type: 'Excel',
        },
        pageSettings: {
            pageSize: 15
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


<?php
$content = ob_get_clean(); // Store captured content in $content

include '../Layout/MainLayout.php';
?>