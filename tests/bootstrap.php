<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/FormAssert.php';

Tester\Environment::setup();


function test($cb)
{
	$cb();
}
