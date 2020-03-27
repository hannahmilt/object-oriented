<?php
//require_once dirname(__dir__,1) . "/vendor/autoload.php";
require_once(dirname(__DIR__) . "/classes/autoload.php");
//require_once("/etc/apache2/capstone-mysql/Secrets.php");

//$secrets = new \Secrets('etc/apache2/Author-mysql/ddcauthor.ini');
//$pdo = $secrets->getPdoObject();

use Hannahmilt\ObjectOriented\Author;

$authorId = "06hc079-34hf-5uda-95t7-737c64r1h8r6";
$authorActivationToken = "New_Activation_Token";
$authorAvatarUrl = "https://avatar.com";
$authorEmail = "fakemail@website.com";
$authorHash = "hash-hash-hash";
$authorUsername = "I-am-a-real-person";

//creating the author object here
//runs the __construct
//runs the individual functions
$author = new Author($authorId, $authorActivationToken, $authorAvatarUrl, $authorEmail, $authorHash, $authorUsername);

var_dump($author);


