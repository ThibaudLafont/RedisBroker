<?php

namespace App;

use RedisBroker\RedisConsumer;

class AppConsumer extends RedisConsumer {

	/**
	 * @param string $message
	 * @return void
	 */
	protected function Consume($message) {
		sleep(rand(1, 3));
		echo $message['id'] . ': ' . $message['message']['text'] . "\n";
	}

}