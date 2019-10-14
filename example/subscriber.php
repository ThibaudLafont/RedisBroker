<?php

use App\AppSubscriber;
use RedisBroker\RedisConnection;
use RedisBroker\RedisFactory;

ini_set("default_socket_timeout", -1);
set_time_limit(-1);

require dirname(__DIR__) . '/vendor/autoload.php';

try {
	RedisFactory::GetInstance()->CreateSubscriber(
		'channel',
		AppSubscriber::class
	)->Subscribe();
} catch (RedisException $e) {
	echo 'Exception : ' . $e->getMessage() . "\n";
}
