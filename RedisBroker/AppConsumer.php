<?php

namespace RedisBroker;

class AppConsumer extends RedisConsumer {

	protected function Consume($message) {
		sleep(rand(1, 3));
		echo $message['message'] . "\n";
	}

}