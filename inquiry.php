<?php include 'includes/header.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'] ?? null;
    
    $pdo->prepare("INSERT INTO inquiries (user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)")
        ->execute([$user_id, $name, $email, $subject, $message]);
        
    setFlash('success', 'Inquiry sent successfully.');
}
?>
<h2>Contact Us / Inquiry</h2>
<div class="row">
    <div class="col-md-6">
        <form method="POST">
            <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required value="<?= $_SESSION['user_name'] ?? '' ?>"></div>
            <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="mb-3"><label>Subject</label><input type="text" name="subject" class="form-control" required></div>
            <div class="mb-3"><label>Message</label><textarea name="message" class="form-control" rows="5" required></textarea></div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
