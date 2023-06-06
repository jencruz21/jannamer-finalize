<?php require('session.php');?>
<?php if(logged_in()){ ?>
          <script type="text/javascript">
            window.location = "index.php";
          </script>
    <?php
    } ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Login</title>

  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" 
  rel="stylesheet">

  <link href="../css/sb-admin-2.css" rel="stylesheet">
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  
</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row shadow">
              <div class="col-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome to QR Based Toolkeeper Management System | QR Login</h1>
                  </div>
                  <!-- <video id="preview" width="100%" height="300"></video> -->
                  <div id="reader"  width="600px" height="600px"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <script src="../js/sb-admin-2.min.js"></script>
  <script src="../js/script.js"></script>

  <script>

    function onScanSuccess(decodedText) {
      // handle the scanned code as you like, for example:
      sendData(decodedText);
    }

    const config = { 
      qrbox: {width: 350, height: 350}, 
      rememberLastUsedCamera: true,
      supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA, Html5QrcodeScanType.SCAN_TYPE_FILE]
    };

    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader",
      config,
      /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess);

    function sendData(content) {
      const qrCodeLogin = new URLSearchParams();
      qrCodeLogin.append('qr_text', content);

      fetch('process_qrcode_login.php', {
              method: 'POST',
              headers: {
                  "Content-Type": "application/x-www-form-urlencoded"
              },
              body: qrCodeLogin
      })
        .then(response => {
          if (response.status === 200) {
            return response.text();
          } else {
            window.location = "login_qrcode.php";
          }
        }).
        then(result => {
          if (result) {
            alert(result);
            window.location = "index.php";
          }
        })
        .catch(err => console.error(err));
    }
  </script>

</body>

</html>









