<?php
namespace Hannahmilt/ObjectOrientedPhp;

require_once("autoload.php");
require_once(dirname(path:__DIR__) . ("/vendor/autoload.php");

use http\Exception\InvalidArgumentException;use Ramsey\Uuid\Uuid;

/**
 * This is the Author class
 * @author Hannahmilt <hmiltenberger@cnm.edu>
 */

class HannahTest implements \JasonSerializable{
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
	/**
	 * accessor method for author id
	 *
	 * @return Uuid value of author id
	 */
	public function getAuthorId() :Uuid {
		return ($this->authorId);
	}
	/**
	 * mutator method for author id
	 *
	 * @param Uuid|string $newAuthorId new value of tweet id
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws \RangeException if $newAuthorId is out of range
	 * @throws \TypeError if $newAuthor Id if $newAuthorId is not a uuid or string
	 **/

		public function setAuthorId($newAuthorId): void{
			try{
				$uuid = self::validateUuid($newAuthor);
			}catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
			//convert and store the author id
			$this->authorId = $uuid;
		}
		/**
		 * accessor method for author activation token
		 * @return string value of the activation token
		 */
		public function getAuthorActivationToken(): ?string {
			return $this->authorActivationToken;
		}

		/**
		 * mutator method for account activation token
		 * @param string $newAuthorActivationToken
		 * @throws \InvalidArgumentException if the token is not a string or is insecure
		 * @throws \RangeException if the token is not exactly 32 characters
		 * @throws \TypeError if the activation Token is not a string
		 */
		public function setAuthorActivationToken(?string $authorActivationToken): void{

			if($newAuthorActivationToken === null) {
				$this->authorActivationToken = null)
				return;
			}
			$newAuthorActivationToken =strtolower(trim($newAuthorActivationToken));
			if(ctype_xdigit($newAuthorActivationToken)  === false){
				throw(new\RangeException ("author activation is not valid"));
			}
			//make sure user activation token is only 32 characters
			if(strlen($newAuthorActivationToken) ! == 32) {
				throw(new\RangeException("author activation token has to be 32 characters"));
			}
			$this->authorActivationToken = $newAuthorActivationToken;
		}
		/**
		 * accessor method for author avatar url
		 * @return string this author avatar url
		 * @throws \InvalidArgumentException if the avatar url is not a string or is is insecure
		 * @throws  \RangeException if the avatar url is not more than 255 characters
		 * @throws \TypeError if the avatar url is not a string
		 */
		public function getAuthorAvatarUrl(?string $newAuthorAvatarUrl): void{
			$newAuthorAvatarUrl = trim($newAuthorAvatarUrl); //take off any spaces before or after
			$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES

			//verify the avatar URL will fit in the database
			if(strlen($newAuthorAvatarUrl)>255) {
				throw(new \RangeException("avatar url too long, must be less than 256 characters"));
			}
			$this->authorAvatarUrl = $newAuthorAvatarUrl;
		}
	/**
	 * accessor method for author email
	 * @return string author email
	 */
		public function getAuthorEmail(): string {
			return $this->authorEmail;
		}

	/**
	 * mutator method for author email
	 *
	 * @param string $authorEmail
	 * @param
	 *
	 */
		public function getAuthorEmail():
	/**
	 * @return string $authorHash
	 */
		// missing a few
		public function getAuthorHash(): string{
			return $this->authorHash;
		}

		/**
		 * mutator method for author Hash
		 * @param string $authorHash
		 */
		public function setAuthorHash

}