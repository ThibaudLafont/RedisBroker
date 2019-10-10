<?php

namespace RedisBroker;

use Exception;

/**
 * Class RedisPublisher
 * @package RedisBroker
 */
class RedisPublisher {

	/**
	 * @var Redis
	 */
	private $redis_conn;

	/* ------------------------ MAGIC ------------------------*/

	/**
	 * RedisPublisher constructor.
	 * @param RedisConnection $redis_handler
	 */
	public function __construct(RedisConnection $redis_handler) {
		$this->SetRedisConn($redis_handler->CreateConnection());
	}

	/* ------------------------ METHODS ------------------------*/

	/**
	 * @param string $channel
	 * @param RedisMessage $message
	 * @throws Exception
	 */
	public function Publish($channel, RedisMessage $message) {
		$this->GetRedisConn()->rPush($channel, $message->Serialize());
		$this->GetRedisConn()->publish($channel, '');
	}

	/* ------------------------ GETTERS / SETTERS ------------------------*/

	/**
	 * @return Redis
	 */
	public function GetRedisConn() {
		return $this->redis_conn;
	}

	/**
	 * @param Redis $redis_conn
	 */
	public function SetRedisConn($redis_conn) {
		$this->redis_conn = $redis_conn;
	}

}
