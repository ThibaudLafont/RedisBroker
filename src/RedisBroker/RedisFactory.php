<?php

namespace RedisBroker;

/**
 * Class RedisFactory
 * @package RedisBroker
 */
final class RedisFactory {

	/**
	 * @var string
	 */
	private static $redis_host = 'host.docker.internal';

	/**
	 * @var int
	 */
	private static $redis_port = 63;

	/**
	 * @var this
	 */
	private static $_instance;

	/* ------------------------ MAGIC ------------------------*/

	/**
	 * RedisFactory constructor.
	 * @param string $redis_host
	 * @param int $redis_port
	 */
	public function __construct($redis_host = '', $redis_port = 0) {
		if($redis_host !== '')
			self::SetRedisHost($redis_host);
		if($redis_port !== 0)
			self::SetRedisPort($redis_port);
	}

	/* ------------------------ METHODS ------------------------*/

	/**
	 * @return RedisFactory
	 */
	public static function GetInstance() {
		if (self::$_instance === null) {
			self::$_instance = new RedisFactory();
		}
		return self::$_instance;
	}

	/**
	 * @return RedisPublisher
	 */
	public function CreatePublisher() {
		return new RedisPublisher($this->CreateConnector());
	}

	/**
	 * @param string $channel
	 * @param string $subs_classname
	 * @return RedisSubscriber
	 */
	public function CreateSubscriber($channel, $subs_classname) {
		return new $subs_classname($this->CreateConnector(), $channel);
	}

	/**
	 * @param array $message_content
	 * @return RedisMessage
	 */
	public function CreateMessage(array $message_content) {
		return new RedisMessage($message_content);
	}

	/**
	 * @return RedisConnection
	 */
	private function CreateConnector() {
		return new RedisConnection(self::GetRedisHost(), self::GetRedisPort());
	}

	/* ------------------------ GETTERS / SETTERS ------------------------*/

	/**
	 * @return string
	 */
	public static function GetRedisHost() {
		return self::$redis_host;
	}

	/**
	 * @param string $redis_host
	 */
	public static function SetRedisHost($redis_host) {
		self::$redis_host = $redis_host;
	}

	/**
	 * @return int
	 */
	public static function GetRedisPort() {
		return self::$redis_port;
	}

	/**
	 * @param int $redis_port
	 */
	public static function SetRedisPort($redis_port) {
		self::$redis_port = $redis_port;
	}
}
