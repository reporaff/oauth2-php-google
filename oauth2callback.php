<?php
session_start();
session_unset();
session_destroy();
session_start();

require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('client_secrets.json');
$client->setRedirectUri('http://localhost/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE);
$client->setAccessType('offline'); // Permite refresh tokens
$client->setPrompt('consent'); // Fuerza la pantalla de consentimiento

// Si hay un código de autorización
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
    header('Location: index.php');
    exit();
}

// Si el token de acceso está, actualiza sesión
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
    header('Location: index.php');
    exit();
}
?>
