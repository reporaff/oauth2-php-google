<?php
session_start();

require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('TU_CLIENT_ID');
$client->setClientSecret('TU_CLIENT_SECRET');
$client->setRedirectUri('http://localhost/oauth2callback.php');

// Si hay un código de autorización
if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    header('Location: index.php');
}

// Si el token de acceso está presente, actualizar sesión
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
    header('Location: index.php');
}
?>
