<?php
session_start();
require 'config.php';

$authorize_url = SPOTIFY_AUTHORIZE_URL . '?' . http_build_query([
    'response_type' => 'code',
    'client_id' => SPOTIFY_CLIENT_ID,
    'scope' => 'user-read-private user-read-email playlist-read-private streaming',
    'redirect_uri' => SPOTIFY_REDIRECT_URI,
]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Spotify</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container">
    <h2>Login dengan Akun Spotify</h2>
    <a href="<?= $authorize_url ?>" class="btn-login">Login with Spotify</a>
  </div>
</body>
</html>
