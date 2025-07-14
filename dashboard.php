<?php
session_start();
require 'config.php';

if (!isset($_SESSION['access_token'])) {
    header('Location: spotify_login.php');
    exit();
}

$access_token = $_SESSION['access_token'];

function spotify_api_get($url, $access_token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SPOTIFY_API_BASE_URL . $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $access_token]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$user = spotify_api_get('/me', $access_token);
$playlists = spotify_api_get('/me/playlists', $access_token);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Spotify Dashboard</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container">
    <h2>Halo, <?= htmlspecialchars($user['display_name']) ?></h2>
    <h3>Playlist Anda:</h3>
    <ul>
    <?php foreach ($playlists['items'] as $playlist): ?>
      <li>
        <?= htmlspecialchars($playlist['name']) ?> 
        <a href="<?= $playlist['external_urls']['spotify'] ?>" target="_blank">Play</a>
      </li>
    <?php endforeach; ?>
    </ul>
  </div>
</body>
</html>
