<?php
namespace Hannahmilt\ObjectOriented\Test;

use Hannahmilt\ObjectOriented\{Author};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


	class AuthorTest extends DataDesignTest {

	//this is fake data so we can TEST
	private $VALID_AUTHOR_ACTIVATION_TOKEN;//this will be done in the setup
	private $VALID_AUTHOR_AVATAR_URL = "https://avatar.com";
	private $VALID_AUTHOR_EMAIL = "hannahmilt@gmail.com";
	private $VALID_AUTHOR_HASH; //THIS WILL BE DONE IN THE SETUP
	private $VALID_AUTHOR_USERNAME = "hmiltenberger";

	public function setUp() : void {
		parent::setUp();

		$password ="my_super_secret_password";
		$this->VALID_AUTHOR_HASH = password_hash( "password",PASSWORD_ARGON2I, ["time_cost" => 45]);
		$this->VALID_AUTHOR_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}

	public function testInsertValidAuthor() : void {

	}
	public function testUpdateValidAuthor() : void {

	}
	public function testDeleteValidAuthor() : void {

	}
	public function testGetValidAuthorByAuthorId() : void {

	}
	public function testGetValidAuthors() : void {

	}


}