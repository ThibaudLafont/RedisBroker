<?php

namespace RedisBroker;

use Exception;

/**
 * Class RedisMessage
 * @package RedisBroker
 */
final class RedisMessage {

	/**
	 * @var int
	 */
	private $id = '';

	/**
	 * @var array
	 */
	private $content = [];

	/* ------------------------ MAGIC ------------------------*/

	/**
	 * RedisMessage constructor.
	 * @param array $message
	 */
	public function __construct(array $message = []) {
		$this->SetId();
		if($message !== '') {
			$this->SetContent($message);
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
			'content' => $this->GetContent()
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
	 * @return array
	 */
	public function GetContent() {
		return $this->content;
	}

	/**
	 * @param array $content
	 */
	public function SetContent(array $content) {
		$this->content = $content;
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function AddToContent($key, $value) {
		$this->GetContent()[$key] = $value;
	}

}
