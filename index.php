<?php

$content = "";

error_reporting(E_ALL);
require 'vendor/autoload.php';

$sandbox = true;

$oauth_handler = new \Evernote\Auth\OauthHandler($sandbox);

$key      = 'moritzg199';
$secret   = 'c1c34531acc73c2f';
$callback = 'http://umkkd9317f21.moritzgoeckel.koding.io/RandomNote/';

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
        $content .=  "Permission denied!";
        print_r($e);
    }
}
else {
    $token = $_COOKIE["token"];
}

//$content .= "Token: " . $token . "<p />";

$client = new \Evernote\Client($token);
//$advancedClient = $client->getAdvancedClient();

if(isset($_GET['notebook']) == false)
{
    $content .= "<h2>Choose a notebook</h1>";
    $notebooks = array();
    $notebooks = $client->listNotebooks();
    foreach ($notebooks as $notebook) {
        $content .= "<a href='?notebook=" . $notebook->guid . "'>" . $notebook->name . "</a><br />";
        //. " (Guid: " . $notebook->guid . ")
    }
}
else {
    $book = $client->getNotebook($_GET['notebook']);
    
    $filter = new \EDAM\NoteStore\NoteFilter();
    $noteStore = $client->getUserNotestore();
    
    $filter->notebookGuid = $_GET['notebook'];
    $notes = $noteStore->findNotes($token, $filter, 0, 100);
    
    $note_output = array();
    foreach ($notes->notes as $note) {
        $note = $client->getNote($note->guid);
        
        $theNoteArray = array(
            "title" => $note->title,
            "content" => $note->content->toEnml()
        );
        //htmlentities(str_replace('"', "\"", $note->content->toEnml()))
        array_push($note_output, $theNoteArray);
    }
}

/*$note = $client->getNote('the-note-guid');
$noteGuid    = $note->guid;
$noteType    = $note->type;
$noteTitle   = $note->title;
$noteCreated = $note->created;
$noteUpdated = $note->updated;*/

//Auth, Select Notebook / All, Show Random -> Next, Set Interval
    
include("design.php");