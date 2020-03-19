<?php
namespace hannahmilt\objectOriented;

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
 **/

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
		}

/*     catches errors or invalid inputs??  */
		catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception){
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

public function get authorAvatarUrl() : string {
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
	if(strlen($newAuthorAvatarUrl) > 100){
		throw(new\RangeException("authorAvatarUrl is too large"));
	}
//store the authorAvatarUrl
	$this->authorAvatarUrl = $newAuthorAvatarUrl;
}
/**
 * accessor method for email
 *
 * @return string value of email
 **/
public function getAuthorEmail(): string {
	return $this->authorEmail;
}

/**
 * mutator method for emial
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
	if(empty($newAuthorHash === true) {
		throw(new\InvalidArgumentException("author password has empty or insecure"));
	}
	//enforce the the hash is exactly 97 characters.
	if(strlen($newAuthorHash) !== 97) {
		throw(new \RangeException("author hash must be 97 characters"));
	}
	//store the hash
	$this->authorHash = $newAuthorHash;

}
/* accessor method for authorUsername*/
public function getAuthorUsername(): string {
	return ($this->authorUsername);
}

/** mutator method for authorUsername
 * @param string $newAuthorUsername
 * @throws \RangeException if the toke is not 32 characters
 * @throws \TypeError if the activation token is not a string
 */

public function setAuthorUsername (string $newAuthorUsername): void {
	if($newAuthorUsername === null) {
		$this->authorUsername = null;
		return;
	}
	$newAuthorUsername = strtolower(trim($newAuthorUsername));
	if(ctype_xdigit($newAuthorUsername) === false) {
		throw(new\RangeException("username is not valid"));
	}
	if(strlen($newAuthorUsername) !==32) {
		throw(new \RangeException("author username has to be 32 characters"));
	}
	$this->authorUsername = $newAuthorUsername;

}
}