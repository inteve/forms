<?php

use Tester\Assert;
use Tests\FormAssert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$input = new Inteve\Forms\DateInput;
	FormAssert::blank($input);
	FormAssert::render($input, '<input name="test" id="frm-test" value="">');
});


test(function () {
	$input = new Inteve\Forms\DateInput;
	FormAssert::errors($input, []);

	$input = new Inteve\Forms\DateInput(NULL, 'Custom error message');
	FormAssert::errors($input, []);

	$input = new Inteve\Forms\DateInput;
	$input->setRequired();
	FormAssert::errors($input, ['This field is required.']);

	$input = new Inteve\Forms\DateInput(NULL, 'Custom error message');
	$input->setRequired();
	FormAssert::errors($input, ['This field is required.']);
});


test(function () {
	$input = new Inteve\Forms\DateInput;
	FormAssert::setEmptyValue($input, NULL);
});


test(function () {
	$input = new Inteve\Forms\DateInput;

	FormAssert::setValidValue(
		$input,
		new \DateTime('2019-01-01 18:00:00', new \DateTimeZone('UTC')),
		new \DateTimeImmutable('2019-01-01 00:00:00', new \DateTimeZone('UTC')),
		'1.1.2019'
	);
});


test(function () {
	$input = new Inteve\Forms\DateInput;

	FormAssert::setValidValue(
		$input,
		new \DateTimeImmutable('2019-01-01 18:00:00', new \DateTimeZone('UTC')),
		new \DateTimeImmutable('2019-01-01 00:00:00', new \DateTimeZone('UTC')),
		'1.1.2019'
	);
});


test(function () {
	$input = new Inteve\Forms\DateInput;

	FormAssert::setInvalidValue(
		$input,
		TRUE,
		Inteve\Forms\InvalidArgumentException::class,
		'Value of type boolean is not supported.'
	);
});


test(function () {
	$input = new Inteve\Forms\DateInput;

	FormAssert::setValidHttpValue($input, '', NULL);
	FormAssert::setValidHttpValue($input, '1.01. 2019', new DateTimeImmutable('2019-01-01 00:00:00', new \DateTimeZone('UTC')));
	FormAssert::setValidHttpValue($input, '12. 12. 2019', new DateTimeImmutable('2019-12-12 00:00:00', new \DateTimeZone('UTC')));
});


test(function () {
	$input = new Inteve\Forms\DateInput;

	FormAssert::setInvalidHttpValue($input, 'hello', ['Invalid date.']);
	FormAssert::setInvalidHttpValue($input, ':24', ['Invalid date.']);
	FormAssert::setInvalidHttpValue($input, '0:', ['Invalid date.']);
	FormAssert::setInvalidHttpValue($input, '31.2.2018', ['Invalid date.']);
	FormAssert::setInvalidHttpValue($input, '0.0.2018', ['Invalid date.']);
	FormAssert::setInvalidHttpValue($input, '0.0.00', ['Invalid date.']);

	$input = new Inteve\Forms\DateInput(NULL, 'Custom invalid date.');
	FormAssert::setInvalidHttpValue($input, 'hello', ['Custom invalid date.']);
});
