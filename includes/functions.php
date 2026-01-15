<?php
require_once __DIR__ . '/../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BREVO_API_KEY', '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');

function sendEmail($toEmail, $toName, $subject, $htmlContent) {
    $url = 'https://api.brevo.com/v3/smtp/email';
    $data = [
        'sender' => ['name' => 'Ecommerce System', 'email' => 'no-reply@example.com'],
        'to' => [['email' => $toEmail, 'name' => $toName]],
        'subject' => $subject,
        'htmlContent' => $htmlContent
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'api-key: ' . BREVO_API_KEY,
        'content-type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isEmployee() {
    return isset($_SESSION['role']) && ($_SESSION['role'] === 'employee' || $_SESSION['role'] === 'admin');
}

function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function inr($amount, $decimals = 0) {
    $num = (float)$amount;
    return '₹' . number_format($num, (int)$decimals);
}
?>
