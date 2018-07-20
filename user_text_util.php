<?php

require_once __DIR__ . '/CSVParser.php';
require_once __DIR__ . '/DateReplacer.php';
require_once __DIR__ . '/LineCounter.php';

$delimiters = [
    'comma'     => ',',
    'semicolon' => ';',
];

$methods = [
    'countAverageLineCount' => LineCounter::class,
    'replaceDates'          => DateReplacer::class,
];

if (3 !== $argc || ! array_key_exists($argv[1], $delimiters) || ! array_key_exists($argv[2], $methods)) {
    echo "Пример вызова: php user_text_util.php comma countAverageLineCount\n";
    exit(1);
}
$delimiter       = $delimiters[$argv[1]];
$method          = $argv[2];
$className       = $methods[$method];
$parser          = new CSVParser($delimiter);
$dataManipulator = new $className($parser);
$dataManipulator->{$method}();
exit(0);
