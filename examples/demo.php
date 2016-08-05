<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-8-2 下午9:59
 */

require __DIR__ . '/../vendor/autoload.php';

(new \Runner\Envar\DotEnv())->loadFromFile(__DIR__ . '/envar.config');

envar('DB_USERNAME');