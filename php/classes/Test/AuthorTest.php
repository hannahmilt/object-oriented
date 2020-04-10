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
		$this->VALID_AUTHOR_HASH = password_hash( "password",PASSWORD_ARGON2I, ["time_cost" => 9]);
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
		//pdoAuthor is the author from the database

		$pdoAuthor= Author::getAuthorByAuthorId($this->getPDO(), $author->getAuthorId()->toString());
		self::assertEquals($authorId, $pdoAuthor->getAuthorId());
		self::assertEquals($this->VALID_AUTHOR_ACTIVATION_TOKEN, $pdoAuthor->getAuthorActivationToken());
		self::assertEquals($this->VALID_AUTHOR_AVATAR_URL, $pdoAuthor->getAuthorAvatarUrl());


		self::assertEquals($this->VALID_AUTHOR_EMAIL, $pdoAuthor->getAuthorEmail());


		self::assertEquals($this->VALID_AUTHOR_HASH, $pdoAuthor->getAuthorHash());
		self::assertEquals($this->VALID_AUTHOR_USERNAME, $pdoAuthor->getAuthorUsername());

	}

	public function testUpdateValidAuthor() : void {
		//get count of author records in db before we run the test.
		$numRows = $this->getConnection()->getRowCount("author");

		//insert an author record in the db
		$authorId = generateUuidV4()->toString();
		$author = new Author($authorId, $this->VALID_AUTHOR_ACTIVATION_TOKEN, $this->VALID_AUTHOR_AVATAR_URL, $this->VALID_AUTHOR_EMAIL, $this->VALID_AUTHOR_HASH, $this->VALID_AUTHOR_USERNAME);
		$author->insert($this->getPDO());

		//update a balue on the record I just inserted.
		$author->setAuthorUsername($this->VALID_AUTHOR_USERNAME . "changed");
		$author->setAuthorUsername($changedAuthorUsername);
		$author ->update($this->getPDO());

		//check count of author records in the db after the insert
		$numRowsAfterInsert = $this->getConnection()->getRowCount("author");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);


		//get a copy of the record just inserted and validate the values

		// make sure the values that went into the record are the same ones that come out
		//pdoAuthor is the author from the database

		$pdoAuthor= Author::getAuthorByAuthorId($this->getPDO(), $author->getAuthorId()->toString());
		self::assertEquals($authorId, $pdoAuthor->getAuthorId());
		self::assertEquals($this->VALID_AUTHOR_ACTIVATION_TOKEN, $pdoAuthor->getAuthorActivationToken());
		self::assertEquals($this->VALID_AUTHOR_AVATAR_URL, $pdoAuthor->getAuthorAvatarUrl());


		self::assertEquals($this->VALID_AUTHOR_EMAIL, $pdoAuthor->getAuthorEmail());


		self::assertEquals($this->VALID_AUTHOR_HASH, $pdoAuthor->getAuthorHash());
		self::assertEquals($this->VALID_AUTHOR_USERNAME, $pdoAuthor->getAuthorUsername());
		//verify that the saved username is same as the update username
		self::assertEquals($changedAuthorUsername, $pdoAuthor->getAuthorUsername());
	}

		public function testDeleteValidAuthor() : void {
			//get count of author records in db before we run the test.
			$numRows = $this->getConnection()->getRowCount("author");

			//insert an author record in the db
			$authorId = generateUuidV4()->toString();
			$author = new Author($authorId, $this->VALID_AUTHOR_ACTIVATION_TOKEN, $this->VALID_AUTHOR_AVATAR_URL, $this->VALID_AUTHOR_EMAIL, $this->VALID_AUTHOR_HASH, $this->VALID_AUTHOR_USERNAME);
			$author->insert($this->getPDO());

			//check count of author records in the db after the insert
			$numRowsAfterInsert = $this->getConnection()->getRowCount("author");
			self::assertEquals($numRows + 1, $numRowsAfterInsert);

			//now delete the record we just inserted
			$author->delete($this->getPDO());

			//try to get the record. it should not exist.
			$pdoAuthor= Author::getAuthorByAuthorId($this->getPDO(), $author->getAuthorId()->toString());

		}
		/*
		public function testGetValidAuthorByAuthorId() : void {

		}
		public function testGetValidAuthors() : void {

		}
	*/
}