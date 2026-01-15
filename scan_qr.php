<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Service Man - Scan QR Code</div>
            <div class="card-body text-center">
                <div id="reader" style="width: 100%;"></div>
                <hr>
                <form id="scanForm" method="POST" action="api/update_status.php">
                    <label>Or Enter QR Token Manually:</label>
                    <input type="text" id="qr_token" name="qr_token" class="form-control mb-2" required>
                    <button type="submit" class="btn btn-primary w-100">Verify & Deliver</button>
                </form>
                <div id="result" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
function onScanSuccess(decodedText, decodedResult) {
    document.getElementById('qr_token').value = decodedText;
    verifyAndDeliver(decodedText);
}

function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning.
}

let html5QrcodeScanner = new Html5QrcodeScanner(
  "reader",
  { fps: 10, qrbox: {width: 250, height: 250} },
  /* verbose= */ false);
html5QrcodeScanner.render(onScanSuccess, onScanFailure);

function verifyAndDeliver(token) {
    const resDiv = document.getElementById('result');
    resDiv.innerHTML = '<div class="alert alert-info">Verifying...</div>';
    
    const formData = new FormData();
    formData.append('qr_token', token);
    
    fetch('api/update_status.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            resDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
            html5QrcodeScanner.clear();
        } else {
            resDiv.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        resDiv.innerHTML = '<div class="alert alert-danger">Error processing request.</div>';
    });
}

document.getElementById('scanForm').addEventListener('submit', function(e){
    e.preventDefault();
    verifyAndDeliver(document.getElementById('qr_token').value);
});
</script>

<?php include 'includes/footer.php'; ?>
