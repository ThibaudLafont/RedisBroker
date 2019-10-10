<?php

namespace RedisBroker;

use Redis;

/**
 * Class RedisConnection
 * @package RedisBroker
 */
class RedisConnection {

	/**
	 * @var string
	 */
	private $host;

	/**
	 * @var int
	 */
	private $port;

	/* ------------------------ MAGIC ------------------------*/

	/**
	 * RedisConnection constructor.
	 * @param $host
	 * @param $port
	 */
	public function __construct($host, $port) {
		$this->SetHost($host);
		$this->SetPort($port);
	}

	/* ------------------------ METHODS ------------------------*/

	/**
	 * @return Redis
	 */
	public function CreateConnection() {
		$redis = new Redis();
		$redis->connect($this->GetHost(), $this->GetPort());
		return $redis;
	}

	/* ------------------------ GETTERS / SETTERS ------------------------*/

	/**
	 * @return string
	 */
	public function GetHost() {
		return $this->host;
	}

	/**
	 * @param string $host
	 */
	public function SetHost($host) {
		$this->host = $host;
	}

	/**
	 * @return int
	 */
	public function GetPort() {
		return $this->port;
	}

	/**
	 * @param int $port
	 */
	public function SetPort($port) {
		$this->port = $port;
	}

}
