<?php
//require_once dirname(__dir__,1) . "/vendor/autoload.php";
require_once(dirname(__DIR__) . "/classes/autoload.php");
//require_once("/etc/apache2/capstone-mysql/Secrets.php");

//$secrets = new \Secrets('etc/apache2/Author-mysql/ddcauthor.ini');
//$pdo = $secrets->getPdoObject();

use Hannahmilt\ObjectOriented\Author;

$authorId = "c94b85b6-d2d4-4550-900c-52e53e482f55";
$authorActivationToken = bin2hex(random_bytes(16));
$authorAvatarUrl = "https://avatar.com";
$authorEmail = "fakemail@website.com";
$authorHash = password_hash( "password",PASSWORD_ARGON2I, ["time_cost" => 45]);;
$authorUsername = "I-am-a-real-person";

//creating the author object here
//runs the __construct
//runs the individual functions
$author = new Author($authorId, $authorActivationToken, $authorAvatarUrl, $authorEmail, $authorHash, $authorUsername);

var_dump($author);


