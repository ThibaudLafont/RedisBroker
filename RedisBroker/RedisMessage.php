<?php

namespace RedisBroker;

use Exception;

/**
 * Class RedisMessage
 * @package RedisBroker
 */
class RedisMessage {

	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $message;

	/* ------------------------ MAGIC ------------------------*/

	/**
	 * RedisMessage constructor.
	 * @param string $message
	 */
	public function __construct($message = '') {
		$this->SetId();
		if($message !== '') {
			$this->SetMessage($message);
		}
	}

	/* ------------------------ METHODS ------------------------*/

	/**
	 * @return string
	 * @throws Exception
	 */
	public function Serialize () {
		$ret = json_encode([
			'id' => $this->GetId(),
			'message' => $this->GetMessage()
		], true);
		if($ret !== false) {
			return $ret;
		}
		throw new Exception('Error during json encoding of the message');
	}

	/* ------------------------ GETTERS / SETTERS ------------------------*/

	/**
	 * @return mixed
	 */
	public function GetId() {
		return $this->id;
	}

	public function SetId() {
		$this->id = uniqid();
	}

	/**
	 * @return string
	 */
	public function GetMessage() {
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function SetMessage($message) {
		$this->message = $message;
	}

}
