<?php
session_start();

require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('client_secrets.json'); // Cargar credenciales desde el archivo JSON
$client->setRedirectUri('http://localhost/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE);

// Si ya está autenticado
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
    
    // Listar archivos de Google Drive
    $driveService = new Google_Service_Drive($client);
    $files = $driveService->files->listFiles();
    
    echo '<h2>Lista de Archivos de Google Drive:</h2>';
    foreach ($files as $file) {
        echo $file->name . "<br>";
    }
} else {
    // Redirigir al usuario a Google para autenticarse
    $authUrl = $client->createAuthUrl();
    echo '<a href="' . $authUrl . '">Iniciar sesión con Google</a>';
}
?>
