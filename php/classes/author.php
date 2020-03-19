<?php
namespace hannahmilt\objectOriented;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 *
 */
class Author implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

/*Write and document all state variables in the class*/
	private $authorId;
	private $authorActivationToken;
	private $authorAvatarUrl;
	private $authorEmail;
	private $authorHash;
	private $authorUsername;

/*Write and document constructor method*/
	public function __construct($newAuthorId, $newAuthorActivationToken, string $newAuthorAvatarUrl, $newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		}

/*     catches errors or invalid inputs??  */
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/*Write and document an accessor/getter method for each state variable*/
	public function getAuthorId() : Uuid {
		return($this->authorId);
	}

	/*Write and document a mutator/setter for each state variable*/

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
	public function get authorActivationToken() : ?string {
		return($this->authorActivationToken);
}

/**
 * mutator method for authorActivationToken
 * @param string $newAuthorActivationToken
 * @throws \InvalidArgumentException in the token is not a string or insecure
 * @throws \RangeException if the token is not exactly 32 characters
 * @throws \TypeError is the activation token is not a string
 */

public function setAuthorActivationToken(?string $newAuthorActivationToken) : void {
	if($newAuthorActivationToken === null) {
		$this->authorActivationToken = null;
		return;
	}
	$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
	if(ctype_xdigit($newAuthorActivationToken) === false) {
		throw(new\RangeException("user activation is not valid"));
	}
	//make sure user actviation token is only 32 characters
	if(strlen($newAuthorActivationToken) !== 32) {
		throw(new\RangeException("user activation token has to be 32"));
	}
	$this->authorActivationToken = $newAuthorActivationToken;
}
/* accessor method for authorAvatarUrl*/

public function get authorAvatarUrl() : Default {
	return($this->authorAvatarUrl);
}

/*mutator method for authorAvatarUrl*/

public function setAuthorAvatarUrl( $newAuthorAvatarUrl) : void {
	try {
		$defalt = self::validateDefault($newAuthorAvatarUrl);
	}catch(\InvalidArgumentException |\RangeException | \Exception | \TypeError $exception){
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}

	$this->authorAvatarUrl = $defalt;
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
 * @param string $newAuthorEail new value of email
 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
 * @throws \RangeException if $newEmail is > 128 characters
 * @throws \TypeError if $newEmail is not a string
 */

public function setAuthorEmail(?string $newAuthorEmail): void {
	//varify the email is secure
	$newAuthorEmail = trim($newAuthorEmail);
	$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
	if(empty($newAuthorEmail) === true) {
		throw(new \InvalidArgumentException("profile email is empty or insecure"));
	}
	//verify the email will fit in the database
	if(strlen($newAuthorEmail) > 128) {
		throw(new \RangeException("profile email is too large"));
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
public function getauthorUsername(): ?string {
	return ($this->authorUsername);
}

/** mutator methor for authorUsername
 * @param string $newAuthorUsername
 * @throws \RangeException if the toke is not 10 characters
 * @throws \TypeError if the activation token is not a string
 */

public function setAuthorUsername (?string $newAuthorUsername): void {
	if($newAuthorUsername === null) {
		$this->authorUsername = null;
		return;
	}
	$newAuthorUsername = strtolower(trim($newAuthorUsername));
	if(ctype_xdigit($newAuthorUsername) === false) {
		throw(new\RangeException("username is not valid"));
	}
	if(strlen($newAuthorUsername) !==10) {
		throw(new/RangeException("author username has to be 10 characters"));
	}
	$this->authorUsername = $newAuthorUsername;

}
}