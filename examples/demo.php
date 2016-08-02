<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-8-2 下午9:59
 */

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new \Runner\DotEnv\DotEnv();


$dotenv->loadFromFile(__DIR__ . '/.env');