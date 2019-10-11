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

	public static function GetInstance() {
		if (self::$_instance === null) {
			self::$_instance = new RedisFactory();
		}
		return self::$_instance;
	}

	public function CreatePublisher() {
		return new RedisPublisher($this->CreateConnector());
	}

	public function CreateSubscriber($channel, $subscriber_class) {
		return new $subscriber_class($this->CreateConnector(), $channel);
	}

	public function CreateMessage(array $message_content) {
		return new RedisMessage($message_content);
	}

	private function CreateConnector() {
		return new RedisConnection(self::$redis_host, self::$redis_port);
	}

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
