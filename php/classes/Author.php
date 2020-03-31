<?php
namespace Hannahmilt\ObjectOriented;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Small Cross Section of a Twitter like Message
 *
 * This Tweet can be considered a small example of what services like Twitter store when messages are sent and
 * received using Twitter. This can easily be extended to emulate more features of Twitter.
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 3.0.0
 */

class Author implements \JsonSerializable {
	use ValidateUuid;

/*Write and document all state variables in the class*/
/** id for this Author is the primary key
*@var Uuid $authorId
*/
private $authorId;

/** token handed out to varify that the profile is valid and not malicious.
* @var string $authorActivationToken
 */
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
public function getauthorActivationToken() : string {
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
	if(empty($newAuthorEmail) === true) {
		throw(new \InvalidArgumentException("author email is empty or insecure"));
	}
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
	//enforce the the hash is exactly 97 characters.
	if(strlen($newAuthorHash) !== 97) {
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
		if(strlen($newAuthorUsername) >32) {
			throw(new \RangeException("author username has to be 32 characters"));
	}
	$this->authorUsername = $newAuthorUsername;

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
/*
//Insert statement method

public function insert(\PDO $pdo) : void {
	//query template
	$query = "INSERT INTO author(authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername)
				VALUES(:authorId, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :authorUsername)";

	//send the statement to PDO so it knows what to do.
	$statement = $pdo->prepare($query);

	//bind the member variable to the place holders in the template
	//left out date because no date in data
	$parameters = ["authorId" => $this->authorId->getBytes(),
						"authorActivationToken" => $this->authorActivationToken-> ,
						"authorAvatarUrl" => $this->authorAvatarUrl-> ,
						"authorEmail" => $this->authorEmail-> ,
						"authorHash" => $this->authorHash-> ,
						"authorUsername" => $this->authorUsername->getBytes()];

	//Execute the statement on the database
	$statement->execute($parameters);
}

//Update statement method
public functionudate(\PDO $pdo) : void {

	//create query template
	$query = "UPDATE author
				SET authorId = :authorId, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :authorUsername
				WHERE authorId = :authorId";

	//prepare a statement using the SQL so PDO knows what to do.
	$statement = $pdo->prepare($query);

	//put the dat into the right format for MySQL. this project didn't have date so didn't put it

	// bind the member variables to the place holders in in the template
	$parameters = ["authorId" => $this->authorId->getBytes(),
						"authorActivationToken" => $this->authorActivationToken-> ,
						"authorAvatarUrl" => $this->authorAvatarUrl-> ,
						"authorEmail" => $this->authorEmail-> ,
						"authorHash" => $this->authorHash-> ,
						"authorUsername" => $this->authorUsername-> ];

	//now execute he statement on the database
	$statement->execute($parameters);
}

//delete statement method
public function delete(\PDO $pdo) : void {

	//create query template
	$query = "DELETE FROM author
					WHERE authorId = :authorId";

	//prepare a statement object using the SQL so pdo knows what to do.
	$statement = $pdo->prepare($query);

	//bind the member variables to the place holder in the template
	$parameter = ["authorId" => $this->authorId->getBytes()];

	//now execute the statement on the database.
	$statement->execute($parametrs);
}

//GetFooBy Bar method that returns single object

//getFooByBar method that returns a full array

*/