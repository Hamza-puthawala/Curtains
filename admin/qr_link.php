<?php include 'includes/header.php'; ?>
<h2>Public QR Scanning Link</h2>
<div class="card">
    <div class="card-body">
        <p>Share this link with Service Men (Delivery Boys) to scan QR codes on delivery.</p>
        <div class="alert alert-info">
            <?php 
            $link = "http://" . $_SERVER['HTTP_HOST'] . "/unit1/scan_qr.php";
            echo "<a href='$link' target='_blank'>$link</a>";
            ?>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
