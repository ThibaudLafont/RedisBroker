<?php

namespace App;

use RedisBroker\RedisSubscriber;

class AppSubscriber extends RedisSubscriber {

	/**
	 * @param string $id
	 * @param array $content
	 * @return void
	 */
	protected function Consume($id, array $content) {
		sleep(rand(1, 3));
		echo $id . ': ' .
			$content['text'] .
			' (' . (time() - $content['time']) . 's since publish)' .
			"\n"
		;
	}

}