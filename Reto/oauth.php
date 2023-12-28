<?php
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\Google;

$clientId = 'YOUR_CLIENT_ID';
$clientSecret = 'YOUR_CLIENT_SECRET';
$redirectUri = 'https://www.google.com//oauth.php';


$provider = new Google([
    'clientId'     => $clientId,
    'clientSecret' => $clientSecret,
    'redirectUri'  => $redirectUri,
]);

// Si no hem rebut un codi d'autorització, redirigir a Google per autenticar-se
if (!isset($_GET['code'])) {
    $authUrl = $provider->getAuthorizationUrl();
    header('Location: ' . $authUrl);
    exit;
} else {
    // Hem rebut el codi d'autorització, obtenir les dades d'accés
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
    ]);

    // Utilitzar el token per obtenir les dades de l'usuari
    $user = $provider->getResourceOwner($token);

    // Mostrar el nom d'usuari
    echo 'Hola, ' . $user->getName() . '!';
}
