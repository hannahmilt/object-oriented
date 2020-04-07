<?php
namespace Hannahmilt/ObjectOrientedPhp;

require_once("autoload.php");
require_once(dirname(path:__DIR__) . ("/vendor/autoload.php");

use http\Exception\InvalidArgumentException;use Ramsey\Uuid\Uuid;

/**
 * This is the Author class
 * @author Hannahmilt <hmiltenberger@cnm.edu>
 */

class Author implements \JasonSerializable{
	use ValidateUuid;

	//this need to have primary keys first then alphabetical order for anything else
	//labels @var is the type of variable it is.
	/**
	 * id for this Author; this is the primary key
	 * @var Uuid $authId
	 */

	private $authorId;

	/**
	 *activation token for this Author
	 * @var string $authorActivationToken
	 */
	private $authorActivationToken;

	/**
	 * avatar url for Author
	 * @var string $authorAvatarUrl //variable type
	 */
	private $authorAvatarUrl;

	/**
	 * email for this Author
	 * @var string $authorEmail
	 *
	 */
	private $authorEmail;
	/**
	 * hash for Author
	 * @var string $authorHash
	 */
	private $authorHash;

	/**
	 * username for Author
	 * @var string $authorUsername
	 */
	private $authorUsername;

	/**
	 * constructor for this Tweet
	 * @param string Uuid $authorId  id fo this Author or null if new Author
	 * @param string $authorActivationToken activation token to safe gard against malicious accounts
	 * @param string $authorAvatarUrl string containing an avatar url or null
	 * @param string$authorEmail string containing an email
	 * @param string $authorHash string containing a password hash
	 * @param string $authorUsername string containing a username
	 * @throws \InvalidArgumentException if data types are not valid.
	 * @throws \RangeException if data values are out of bounds (e.g. string to long...)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manuel/en/langueage.oop5.decon.php
	 */
	public function __construct($authorId, string $authorActivationToken, string $authorAvatarUrl, string $authorEmail, string $authorHash, string $authorUsername){
		try{
			$this->setauthorId($newAuthorId); //$this means this method right here to make sure you are calling the right method
			$this->setauthorActivationToken($newAuthorActivationToken);
			$this->setauthorAvatarUrl($newAvatarUrl);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);


		}catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
}