<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-8-2 下午9:59
 */

require __DIR__ . '/../vendor/autoload.php';

$parser = new \Runner\DotEnv\Parser();

$data = $parser->load(__DIR__ . '/.env');

print_r($data);