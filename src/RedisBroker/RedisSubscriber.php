<?php

namespace RedisBroker;

use Redis;

/**
 * Class RedisSubscriber
 * @package RedisBroker
 */
abstract class RedisSubscriber {

	/**
	 * @var Redis
	 */
	protected $redis_conn = null;

	/**
	 * @var Redis
	 */
	protected $subs_conn = null;

	/**
	 * @var string
	 */
	protected $channel = '';

	/* ------------------------ MAGIC ------------------------*/

	/**
	 * RedisSubscriber constructor.
	 * @param RedisConnection $redis_handler
	 * @param string $channel
	 */
	public function __construct(RedisConnection $redis_handler, $channel) {
		$this->SetRedisConn($redis_handler->CreateConnection());
		$this->SetSubsConn($redis_handler->CreateConnection());
		$this->SetChannel($channel);
	}

	/**
	 * Unsubscribe and close connections
	 */
	public function __destruct() {
		$this->Unsubscribe();
		$this->CloseConnections();
	}

	/* ------------------------ ABSTRACT METHODS ------------------------*/

	/**
	 * Custom consume method for ProcessMessage callback
	 * @param string $message
	 * @return mixed
	 */
	protected abstract function Consume($message);

	/* ------------------------ METHODS ------------------------*/

	/**
	 * Subscribe to channel and trigger callback on event
	 */
	public function Subscribe() {
		// Process pending messages if any
		$this->ProcessPendingMessages();
		// Subscribe
		$this->GetSubsConn()->subscribe(
			[$this->GetChannel()],
			[$this, 'SubscribeCallback']
		);
	}

	/**
	 * Unsubscribe from channel
	 */
	public function Unsubscribe() {
		$this->GetSubsConn()->unsubscribe([$this->GetChannel()]);
	}

	/**
	 * Close Redis connections
	 */
	public function CloseConnections() {
		$this->GetRedisConn()->close();
		$this->GetSubsConn()->close();
	}

	/**
	 * Subscribe callback
	 */
	public function SubscribeCallback() {
		$this->ProcessMessage(
			$this->GetRedisConn()->rPop($this->GetChannel())
		);
	}

	/**
	 * Used in case of pending messages when subscription
	 */
	private function ProcessPendingMessages() {
		while($message = $this->GetRedisConn()->rPop($this->GetChannel())) {
			$this->ProcessMessage($message);
		}
	}

	/**
	 * Used for Pending messages and subscription callback
	 * @param string $message
	 */
	private function ProcessMessage($message) {
		if($message !== false) {
			$message = json_decode($message, true);
			if($message !== false) {
				$this->Consume($message);
			} else throw new Exception('Error while decoding json message');
		}
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
	public function SetRedisConn(Redis $redis_conn) {
		$this->redis_conn = $redis_conn;
	}

	/**
	 * @return Redis
	 */
	public function GetSubsConn() {
		return $this->subs_conn;
	}

	/**
	 * @param Redis $subs_conn
	 */
	public function SetSubsConn($subs_conn) {
		$this->subs_conn = $subs_conn;
	}

	/**
	 * @return string
	 */
	public function GetChannel() {
		return $this->channel;
	}

	/**
	 * @param string $channel
	 */
	public function SetChannel($channel) {
		$this->channel = $channel;
	}

}
