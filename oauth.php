<?php
error_reporting(E_ALL);
require 'vendor/autoload.php';

$sandbox = true;

$oauth_handler = new \Evernote\Auth\OauthHandler($sandbox);

$key      = 'moritzg199';
$secret   = 'c1c34531acc73c2f';
$callback = 'http://umkkd9317f21.moritzgoeckel.koding.io/RandomNote/oauth.php';

if(isset($_COOKIE["token"]) == false)
{
    try {
        $oauth_data = $oauth_handler->authorize($key, $secret, $callback);
        $token = $oauth_data['oauth_token'];
        setcookie("token", $token, time() + (3600 * 24 * 100));
        
        //header("http://umkkd9317f21.moritzgoeckel.koding.io/RandomNote/oauth.php");
    } 
    catch (Evernote\Exception\AuthorizationDeniedException $e) 
    {
        //If the user decline the authorization, an exception is thrown.
        print_r($e);
        echo "Declined";
    }
}
else {
    $token = $_COOKIE["token"];
}

//echo "Token: " . $token . "<p />";

$client = new \Evernote\Client($token);
//$advancedClient = $client->getAdvancedClient();

if(isset($_GET['notebook']) == false)
{
    $notebooks = array();
    $notebooks = $client->listNotebooks();
    foreach ($notebooks as $notebook) {
        echo "<a href='?notebook=" . $notebook->guid . "'>" . $notebook->name . " (Guid: " . $notebook->guid . ")</a><br />";
    }
}
else {
    $book = $client->getNotebook($_GET['notebook']);
    
    $filter = new \EDAM\NoteStore\NoteFilter();
    $noteStore = $client->getUserNotestore();
    
    $filter->notebookGuid = $_GET['notebook'];
    $notes = $noteStore->findNotes($token, $filter, 0, 100);
    
    foreach ($notes->notes as $note) { 
        echo $note->title . "<br />"; 
    }
}

//$note = $client->getNote('the-note-guid');


/*$search = new \Evernote\Model\Search('test');
$notebook = null;
$scope = \Evernote\Client::SEARCH_SCOPE_BUSINESS;
$order = \Evernote\Client::SORT_ORDER_REVERSE | \Evernote\Client::SORT_ORDER_RECENTLY_CREATED;
$maxResult = 5;

$results = $client->findNotesWithSearch($search, $notebook, $scope, $order, $maxResult);
foreach ($results as $result) {
    $noteGuid    = $result->guid;
    $noteType    = $result->type;
    $noteTitle   = $result->title;
    $noteCreated = $result->created;
    $noteUpdated = $result->updated;
    
    echo $noteTitle;
}*/









