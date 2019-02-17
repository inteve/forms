<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


Assert::exception(function () {
	$helpers = new Inteve\Forms\Helpers;
}, Inteve\Forms\StaticClassException::class, 'This is static class.');
