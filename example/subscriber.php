<?php

use App\AppConsumer;
use RedisBroker\RedisConnection;

ini_set("default_socket_timeout", -1);
set_time_limit(0);

require dirname(__DIR__) . '/vendor/autoload.php';

try {
	$redis_handler = new RedisConnection('host.docker.internal', 63);

	$consumer = new AppConsumer($redis_handler, 'channel');
	$consumer->Subscribe();
} catch (RedisException $e) {
	echo 'Exception : ' . $e->getMessage() . "\n";
}
