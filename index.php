<?php
$title = "Scanner";

ob_start(); // Start capturing content
?>

<script src="./libs/html5-qrcode.min.js"></script>
<style>
  #reader {
    width: 100%;
    max-width: 800px;
    margin: auto;
    padding: 20px;
    background-color: rgb(255, 255, 255);
  }

  body {
    background-color: rgb(240, 240, 240);
  }

  .image-container img {
    width: 20rem;
  }
</style>

<div class="row">
  <div class="col-md-8 col-sm-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">QR Code Scanner</h3>
        <div class="card-tools">
          <!-- Buttons, labels, and many other things can be placed here! -->
          <!-- Here is a label for example -->
          <span class="badge badge-primary">Please scan the QR Code</span>
        </div>
        <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div id="reader"></div>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
  <div class="col-md-4 col-sm-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Student Profile</h3>
        <!-- /.card-tools -->
      </div>
      <div class="card-body box-profile">
        <div class="text-center">
          <img id="student-img" class="profile-user-img img-fluid img-circle"
            src="./images/ama2.png"
            alt="User profile picture"
            style="width: 150px; height: 150px;">
        </div>

        <h3 id="student-name" class="profile-username text-center">Scan QR</h3>
        <p class="text-muted text-center">Student</p>

        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Course</b> <a id="student-course" class="float-right">...</a>
          </li>
          <li class="list-group-item">
            <b>Year</b> <a id="student-year" class="float-right">...</a>
          </li>
          <li class="list-group-item">
            <b>Date Enrolled</b> <a id="student-date" class="float-right">...</a>
          </li>
          <li class="list-group-item">
            <b>School Id</b> <a id="student-schoolid" class="float-right">...</a>
          </li>
        </ul>
        <div class="row" id="button-container">
        </div>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>

<script>
  let studentId = null;

  function onScanSuccess(decodedText, decodedResult) {
    studentId = decodedText;

    // Load student profile
    fetch(`./data/getstudent.php?id=${studentId}`)
      .then(res => res.json())
      .then(data => {
        if (!data || Object.keys(data).length === 0) {
          alert("Student not found.");
          return;
        }

        // Populate profile
        document.getElementById('student-name').textContent = data.full_name || 'N/A';
        document.getElementById('student-course').textContent = data.course || 'N/A';
        document.getElementById('student-year').textContent = data.year || 'N/A';
        document.getElementById('student-date').textContent = data.date_enrolled || 'N/A';
        document.getElementById('student-schoolid').textContent = data.school_id || 'N/A';
        if (data.image_path) {
          document.getElementById('student-img').src = data.image_path;
        }

        // After profile loaded, check today's attendance
        updateAttendanceButtons();
      })
      .catch(error => {
        console.error("Student fetch error:", error);
      });
  }

  function updateAttendanceButtons() {
    fetch(`./data/getattendancestatus.php?studentId=${studentId}`)
      .then(res => res.json())
      .then(status => {
        const lastType = status.lastType;
        const container = document.getElementById('button-container');
        if (lastType === 1) {
          container.innerHTML = `
            <div class="col-12 text-center">
              <a href="#" onclick="Attend(2)" class="btn btn-danger btn-sm w-100"><b>Time Out</b></a>
            </div>`;
        } else {
          container.innerHTML = `
            <div class="col-12 text-center">
              <a href="#" onclick="Attend(1)" class="btn btn-success btn-sm w-100"><b>Time In</b></a>
            </div>`;
        }
      })
      .catch(error => {
        console.error("Error fetching attendance status:", error);
      });
  }

  function onScanFailure(error) {
    // Optional scan failure handler
  }

  const html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", {
      fps: 10,
      qrbox: 250
    }, false
  );
  html5QrcodeScanner.render(onScanSuccess, onScanFailure);

  function Attend(attendanceType) {
    if (!studentId) {
      alert("Please scan a student QR code first.");
      return;
    }

    fetch('./data/saveattendance.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
          studentId: studentId,
          attendanceType: attendanceType
        })
      })
      .then(res => res.text())
      .then(response => {
        // Show message and refresh buttons
        const container = document.getElementById('button-container');
        container.innerHTML = `
          <div class="alert alert-success w-100 text-center" role="alert">
            ${attendanceType === 1 ? 'Timed In' : 'Timed Out'} Successfully.
          </div>
        `;

        /*
        // If you want to restore the buttons after 2 seconds, uncomment this block
        setTimeout(() => {
          container.innerHTML = `
            <div class="col-md-6 col-sm-12 text-center">
              <a href="#" id="btn-timein" onclick="Attend(1)" class="btn btn-success btn-sm w-100"><b>Time In</b></a>
            </div>
            <div class="col-md-6 col-sm-12 text-center">
              <a href="#" id="btn-timeout" onclick="Attend(2)" class="btn btn-danger btn-sm w-100"><b>Time Out</b></a>
            </div>
          `;
          updateAttendanceButtons();
        }, 2000);
      */
      })
      .catch(error => {
        console.error("Attendance error:", error);
        alert("Failed to save attendance.");
      });
  }
</script>


<?php
$content = ob_get_clean(); // Store captured content in $content

include 'Layout/MainLayout.php';
?>