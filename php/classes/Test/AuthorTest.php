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
		//get count of author records in db before we run the test.
		$numRows = $this->getConnection()->getRowCount("author");

		//insert an author record in the db
		$authorId = generateUuidV4()->toString();
		$author = new Author($authorId, $this->VALID_AUTHOR_ACTIVATION_TOKEN, $this->VALID_AUTHOR_AVATAR_URL, $this->VALID_AUTHOR_EMAIL, $this->VALID_AUTHOR_HASH, $this->VALID_AUTHOR_USERNAME);
		$author->insert($this->getPDO());

		//check count of author records in the db after the insert
		$numRowsAfterInsert = $this->getConnection()->getRowCount("author");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		//get a copy of the record just inserted and validate the values
		// make sure the values that went into the record are the same ones that come out
	}
	/*
	public function testUpdateValidAuthor() : void {

	}
	public function testDeleteValidAuthor() : void {

	}
	public function testGetValidAuthorByAuthorId() : void {

	}
	public function testGetValidAuthors() : void {

	}
*/
}