<?php
session_start();
require 'config.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SPOTIFY_TOKEN_URL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $headers = [
        'Authorization: Basic ' . base64_encode(SPOTIFY_CLIENT_ID . ':' . SPOTIFY_CLIENT_SECRET),
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $data = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => SPOTIFY_REDIRECT_URI,
    ];
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);
    curl_close($ch);
    $token = json_decode($response, true);

    if (isset($token['access_token'])) {
        $_SESSION['access_token'] = $token['access_token'];
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Gagal mendapatkan token akses.";
    }
} else {
    echo "Tidak ada kode otorisasi.";
}
?>
