<?php

use RedisBroker\RedisFactory;

require dirname(__DIR__) . '/vendor/autoload.php';

try {
	$factory = RedisFactory::GetInstance();

	for ($i = 0 ; $i<100 ; $i++) {
		$factory->CreatePublisher()
			->Publish('channel', $factory->CreateMessage(['text' => 'Salut', 'time' => time()]));

		sleep(45);
	}
} catch (RedisException $e) {
	echo "<div style='color: red; font-size: 22px;'>{$e->getMessage()}</div>";
}
