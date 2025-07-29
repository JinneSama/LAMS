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

 <div class="card">
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
 <script>
   function onScanSuccess(decodedText, decodedResult) {
     console.log(`Code matched = ${decodedText}`, decodedResult);
     alert(`QR Code detected: ${decodedText}`);

     // Send the scanned data to process.php
     fetch('process.php', {
         method: 'POST',
         headers: {
           'Content-Type': 'application/x-www-form-urlencoded',
         },
         body: new URLSearchParams({
           code: decodedText
         })
       })
       .then(response => {
         if (response.redirected) {
           window.location.href = response.url;
         } else {
           return response.text().then(data => {
             console.log(data);
             alert(data); // Display server response
           });
         }
       })
       .catch(error => {
         console.error('Error:', error);
         alert('Error: ' + error);
       });

     html5QrcodeScanner.clear();
   }

   function onScanFailure(error) {
     // Handle scan failure, currently we do nothing
   }

   const html5QrcodeScanner = new Html5QrcodeScanner(
     "reader", {
       fps: 10,
       qrbox: 250
     }, /* verbose= */ false);
   html5QrcodeScanner.render(onScanSuccess, onScanFailure);
 </script>
 <?php
  $content = ob_get_clean(); // Store captured content in $content

  include 'Layout/MainLayout.php';
  ?>