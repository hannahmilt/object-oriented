<?php

namespace Hannahmilt\ObjectOriented;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use http\Env\Request;
use Ramsey\Uuid\Uuid;

/**
 * Small Cross Section of a Twitter like Message
 *
 * This Tweet can be considered a small example of what services like Twitter store when messages are sent and
 * received using Twitter. This can easily be extended to emulate more features of Twitter.
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 3.0.0
**/

class Author implements \JsonSerializable {
	use ValidateUuid;

	/*Write and document all state variables in the class*/
	/** id for this Author is the primary key
	*@var Uuid $authorId
	**/
	private $authorId;


	/** token handed out to varify that the profile is valid and not malicious.
	* @var string $authorActivationToken
	 **/
	private $authorActivationToken;
	/**
	* @var
	*/
	private $authorAvatarUrl;
	/**
	 * email for the Author; this is a unique index
	 * @var string $authorEmail
	 */
	private $authorEmail;
	/**
	* hash for author password
	* @var $authorHash
	*/
	private $authorHash;
	/**
	 * username for author
	 * @var $authorUsername
	 */
	private $authorUsername;

	/*Write and document constructor method*/
	/**
 	* Author constructor.
	 * @param string|Uuid $newAuthorId if of this Author or null if a new Author
 	* @param string $newAuthorActivationToken activation token to safe guard against malicious accounts
 	* @param string $newAuthorAvatarUrl string containing newAuthorUrl can be null
 	* @param $newAuthorEmail string containing email
 	* @param $newAuthorHash string containing password hash
 	* @param $newAuthorUsername string containing username
 	*/
	public function __construct($newAuthorId, string  $newAuthorActivationToken, $newAuthorAvatarUrl, $newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
		try {
		$this->setAuthorId($newAuthorId);
		$this->setAuthorActivationToken($newAuthorActivationToken);
		$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
		$this->setAuthorEmail($newAuthorEmail);
		$this->setAuthorHash($newAuthorHash);
		$this->setAuthorUsername($newAuthorUsername);

		/*     catches errors or invalid inputs??  */
		} catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception){
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

		/*Write and document an accessor/getter method for each state variable*/
	/** accessor method for authorId
	*@return Uuid of authorId
	*/

	public function getAuthorId() : Uuid {
		return($this->authorId);
	}

	/*Write and document a mutator/setter for each state variable*/
	/**
	 * mutator method for profile id
	 * @param Uuid| string $newAuthorId value of new profile id
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if the profile Id is not
	 */

	public function setAuthorId( $newAuthorId) : void {
		try {
				$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(),0, $exception));
		}
		$this->authorId = $uuid;
	}
	/* accessor for authorActivationToken */
	public function getAuthorActivationToken() : string {
		return($this-> authorActivationToken);
	}

	/**
	 * mutator method for authorActivationToken
	 * @param string $newAuthorActivationToken
	 * @throws \InvalidArgumentException in the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError is the activation token is not a string
	 */

	public function setAuthorActivationToken(string $newAuthorActivationToken) : void {
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure authorActivationToken is only 32 characters
		if(strlen($newAuthorActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}
	/**
	 * accessor method for authorAvatarUrl
	 * @return string value of authorAvatarUrl
	 */

	public function getAuthorAvatarUrl() : string {
		return($this->authorAvatarUrl);
	}

	/**
	 * mutator method for authorAvatarUrl
	 * @param string $newAuthorAvatarUrl new value of author content
	 * @throws \InvalidArgumentException if $newTweetContent i not a string or insecure
	 * @throws \RangeException if $newTweetContent is >100 characters
	 * @throws \TypeError if $newTweetContent is not a string
	 */

	public function setAuthorAvatarUrl( string  $newAuthorAvatarUrl) : void {
		//verify the tweet content is secure
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl= filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorAvatarUrl) === true) {
			throw(new \InvalidArgumentException("author url is empty or insecure"));
		}
		//verify the authorAvatarUrl will fit in tbe database
		if(strlen($newAuthorAvatarUrl) > 255){
			throw(new\RangeException("authorAvatarUrl is too large"));
		}
	//store the authorAvatarUrl
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}
	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 */
	public function getAuthorEmail(): string {
		return $this->authorEmail;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newAuthorEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 */

	public function setAuthorEmail(string $newAuthorEmail): void {
		//verify the email is secure


		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);

/*
		if(empty($newAuthorEmail) === true) {
			echo $newAuthorEmail. 'after empty';
			throw(new \InvalidArgumentException("author email is empty or insecure"));
		}
*/
		//verify the email will fit in the database
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("author email is too large"));
		}

		//store the email
		$this->authorEmail = $newAuthorEmail;
	}

	/** accessor method for authorHash
	 *@return string value of hash
	 */
	public function getAuthorHash(): string {
		return $this->authorHash;
	}

	/**
	 * mutator method for author hash password
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if the has is not secure
	 * @throws \RangeException if the hash is not 97 characters
	 * @throws \TypeError if the profile hash is not a string
	 */

	public function setAuthorHash(string $newAuthorHash): void {
		//enforce that the has is properly formatted
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new\InvalidArgumentException("author password has empty or insecure"));
		}
		//enforce the the hash doesn't exceed 97 characters.
		if(strlen($newAuthorHash) > 97) {
			throw(new \RangeException("author hash must be 97 characters"));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;

	}
	/**
	 * accessor method for authorUsername
	 */
	public function getAuthorUsername(): string {
		return ($this->authorUsername);
	}

	/** mutator method for authorUsername
	 * @param string $newAuthorUsername
	 * @throws \RangeException if the toke is not 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */


	public function setAuthorUsername (string $newAuthorUsername): void {
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newAuthorUsername) === true) {
				throw(new\InvalidArgumentException("username is not valid"));
		}
			echo $newAuthorUsername. "before if";
			if(strlen($newAuthorUsername) >32) {
				throw(new \RangeException("author username has to be 32 characters"));
		}
		$this->authorUsername = $newAuthorUsername;

	}

	//Insert statement method

	/**
	 * inserts this Author into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function insert(\PDO $pdo) : void {
		//query template
		$query = "INSERT INTO author(authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername) 
						VALUES(:authorId, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :authorUsername)";

		//send the statement to PDO so it knows what to do.
		$statement = $pdo->prepare($query);

		//bind the member variable to the place holders in the template
		//left out date because no date in data
		$parameters = ["authorId" => $this->authorId->getBytes(),
							"authorActivationToken" => $this->authorActivationToken ,
							"authorAvatarUrl" => $this->authorAvatarUrl ,
							"authorEmail" => $this->authorEmail,
							"authorHash" => $this->authorHash,
							"authorUsername" => $this->authorUsername];

		//Execute the statement on the database
		$statement->execute($parameters);
	}

	//Update statement method

	/**
	 * updates this Author in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException whn mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		//create query template
		$query = "UPDATE author
					SET authorId = :authorId, authorActivationToken = :authorActivationToken, authorAvatarUrl = :authorAvatarUrl, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername =:authorUsername
					WHERE authorId = :authorId";

		//prepare a statement using the SQL so PDO knows what to do.
		$statement = $pdo->prepare($query);

		//put the dat into the right format for MySQL. this project didn't have date so didn't put it

		// bind the member variables to the place holders in in the template
		$parameters = ["authorId" => $this->authorId->getBytes(),
							"authorActivationToken" => $this->authorActivationToken,
							"authorAvatarUrl" => $this->authorAvatarUrl,
							"authorEmail" => $this->authorEmail,
							"authorHash" => $this->authorHash,
							"authorUsername" => $this->authorUsername];

		//now execute he statement on the database
		$statement->execute($parameters);
	}

	//delete statement method

	/**
	 * deletes this author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError is $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		//create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";

		//prepare a statement object using the SQL so pdo knows what to do.
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];

		//now execute the statement on the database.
		$statement->execute($parameters);
	}

	//GetFooBy Bar method that returns single object
	/**
	 * get the Author by AuthorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return Author|null Author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?Author {
		//sanitize the authorId before searching
		try{
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			throw(new \PDOException($exception->getMessage(),0, $exception));
		}
		//create query template
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		//bing the author id to the place holder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);


		//grab the author from mySQL
		try {
				$author = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
				}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($author);
	}
	//getFooByBar method that returns a full array
	/**
	 * gets all Authors
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Tweets found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAuthors(\PDO $pdo) : \SPLFixedArray {
		//create query template
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of tweets
		$tweets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try{
				$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
				$author[$author->key()] = $author;
				$author->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($author);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();
		unset($fields["authorActivationToken"]);
		unset($fields["authorAvatarUrl"]);
		unset($fields["authorHash"]);
		unset($fields["authorUsername"]);
		return($fields);
		}
}


