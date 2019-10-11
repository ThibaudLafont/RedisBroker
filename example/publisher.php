<?php

use RedisBroker\RedisConnection;
use RedisBroker\RedisMessage;
use RedisBroker\RedisPublisher;

require dirname(__DIR__) . '/vendor/autoload.php';

try {
	$redis_handler = new RedisConnection('host.docker.internal', 63);

	for ($i = 0 ; $i<10 ; $i++) {
		$message = new RedisMessage(['text' => 'Salut', 'time' => time()]);

		$publisher = new RedisPublisher($redis_handler);
		$publisher->Publish('channel', $message);
	}
} catch (RedisException $e) {
	echo "<div style='color: red; font-size: 22px;'>{$e->getMessage()}</div>";
}
