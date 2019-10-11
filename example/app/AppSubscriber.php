<?php

namespace App;

use RedisBroker\RedisSubscriber;

class AppSubscriber extends RedisSubscriber {

	/**
	 * @param string $message
	 * @return void
	 */
	protected function Consume($message) {
		sleep(rand(1, 3));
		echo $message['id'] . ': ' . $message['message']['text'] . "\n";
	}

}