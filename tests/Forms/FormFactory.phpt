<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$factory = new Inteve\Forms\FormFactory;

	Assert::type(Inteve\Forms\IFormFactory::class, $factory);
	Assert::type(Nette\Application\UI\Form::class, $factory->create());
});
