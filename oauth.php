<?php
error_reporting(E_ALL);
require 'vendor/autoload.php';

$sandbox = true;

$oauth_handler = new \Evernote\Auth\OauthHandler($sandbox);

$key      = 'moritzg199';
$secret   = 'c1c34531acc73c2f';
$callback = 'http://umkkd9317f21.moritzgoeckel.koding.io/RandomNote/vendor/evernote/evernote-cloud-sdk-php/sample/oauth/index.php';

try {
    $oauth_data  = $oauth_handler->authorize($key, $secret, $callback);

    echo "\nOauth Token : " . $oauth_data['oauth_token'];

    // Now you can use this token to call the api
    $client = new \Evernote\Client($oauth_data['oauth_token']);

} catch (Evernote\Exception\AuthorizationDeniedException $e) {
    //If the user decline the authorization, an exception is thrown.
    echo "Declined";
}










