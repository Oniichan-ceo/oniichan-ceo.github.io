<?php
session_start();

$license_id = $_POST['license_id'] ?? '';
$password = $_POST['password'] ?? '';

$users_file = __DIR__ . '/../data/license_users.json';
$users = file_exists($users_file) ? json_decode(file_get_contents($users_file), true) : [];

$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if (isset($users[$license_id]) && $users[$license_id]['password'] === $password) {
  $_SESSION['license_id'] = $license_id;

  if ($is_ajax) {
    echo "success";
  } else {
    header("Location: ../dashboard.html");
  }
  exit;
} else {
  if ($is_ajax) {
    echo "error";
  } else {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head><meta charset='UTF-8'><title>Login Gagal</title></head>
    <body style='font-family: sans-serif; padding: 2rem;'>
      <h2>❌ Login Gagal</h2>
      <p>ID lisensi atau password salah.</p>
      <a href='../login.html'>⬅ Kembali ke Login</a>
    </body>
    </html>";
  }
}
?>
