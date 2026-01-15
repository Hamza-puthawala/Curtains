<?php include 'includes/header.php'; 

if(isset($_POST['reply'])) {
    $to = $_POST['email'];
    $name = $_POST['name'];
    $subject = "Re: " . $_POST['subject'];
    $message = $_POST['message'];
    
    // Send email
    $content = "<p>Dear $name,</p><p>$message</p>";
    $res = sendEmail($to, $name, $subject, $content);
    setFlash('success', 'Reply sent.');
}

?>
<h2>Inquiries</h2>
<table class="table table-bordered">
    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Action</th></tr></thead>
    <tbody>
        <?php
        $stmt = $pdo->query("SELECT * FROM inquiries ORDER BY created_at DESC");
        while ($row = $stmt->fetch()):
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['subject']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#replyModal<?= $row['id'] ?>">Reply</button>
                
                <!-- Reply Modal -->
                <div class="modal fade" id="replyModal<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST">
                                <div class="modal-header"><h5 class="modal-title">Reply</h5></div>
                                <div class="modal-body">
                                    <input type="hidden" name="email" value="<?= $row['email'] ?>">
                                    <input type="hidden" name="name" value="<?= $row['name'] ?>">
                                    <input type="hidden" name="subject" value="<?= $row['subject'] ?>">
                                    <textarea name="message" class="form-control" rows="5" placeholder="Type your reply..."></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="reply" class="btn btn-primary">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include '../admin/includes/footer.php'; ?>
