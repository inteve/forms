<?php

declare(strict_types=1);

use Tester\Assert;
use Tests\FormAssert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$input = new Inteve\Forms\DateTimeInput;
	FormAssert::blank($input);
	FormAssert::render($input, '<input type="datetime-local" name="test" id="frm-test" value="">');
});


test(function () {
	$input = new Inteve\Forms\DateTimeInput;
	$input->showAsTextInput();
	FormAssert::render($input, '<input type="text" name="test" id="frm-test" value="">');
});


test(function () {
	$input = new Inteve\Forms\DateTimeInput;
	FormAssert::errors($input, []);

	$input = new Inteve\Forms\DateTimeInput(NULL, 'Custom error message');
	FormAssert::errors($input, []);

	$input = new Inteve\Forms\DateTimeInput;
	$input->setRequired();
	FormAssert::errors($input, ['This field is required.']);

	$input = new Inteve\Forms\DateTimeInput(NULL, 'Custom error message');
	$input->setRequired();
	FormAssert::errors($input, ['This field is required.']);
});


test(function () {
	$input = new Inteve\Forms\DateTimeInput;
	FormAssert::setEmptyValue($input, NULL);
});


test(function () {
	$input = new Inteve\Forms\DateTimeInput;

	FormAssert::setValidValue(
		$input,
		new \DateTime('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		new \DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		'2019-01-01T18:30:59'
	);

	$input = new Inteve\Forms\DateTimeInput(NULL, 'Invalid datetime.', 'UTC');

	FormAssert::setValidValue(
		$input,
		new \DateTime('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		new \DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		'2019-01-01T18:30:59'
	);

	$input = new Inteve\Forms\DateTimeInput(NULL, 'Invalid datetime.', new \DateTimeZone('Europe/Prague'));

	FormAssert::setValidValue(
		$input,
		new \DateTime('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		new \DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		'2019-01-01T19:30:59'
	);
});


test(function () {
	$input = new Inteve\Forms\DateTimeInput;

	FormAssert::setValidValue(
		$input,
		new \DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		new \DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		'2019-01-01T18:30:59'
	);

	$input = new Inteve\Forms\DateTimeInput(NULL, 'Invalid datetime.', 'UTC');

	FormAssert::setValidValue(
		$input,
		new \DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		new \DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		'2019-01-01T18:30:59'
	);

	$input = new Inteve\Forms\DateTimeInput(NULL, 'Invalid datetime.', new \DateTimeZone('Europe/Prague'));

	FormAssert::setValidValue(
		$input,
		new \DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		new \DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')),
		'2019-01-01T19:30:59'
	);
});


test(function () {
	$input = new Inteve\Forms\DateTimeInput;

	FormAssert::setInvalidValue(
		$input,
		TRUE,
		Inteve\Forms\InvalidArgumentException::class,
		'Value of type boolean is not supported.'
	);
});


test(function () {
	$input = new Inteve\Forms\DateTimeInput;

	FormAssert::setValidHttpValue($input, '', NULL);
	FormAssert::setValidHttpValue($input, '2019-01-01T18:30:59', new DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')));

	$input = new Inteve\Forms\DateTimeInput(NULL, 'Invalid datetime.', 'UTC');

	FormAssert::setValidHttpValue($input, '', NULL);
	FormAssert::setValidHttpValue($input, '2019-01-01T18:30:59', new DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')));

	$input = new Inteve\Forms\DateTimeInput(NULL, 'Invalid datetime.', 'Europe/Prague');

	FormAssert::setValidHttpValue($input, '', NULL);
	FormAssert::setValidHttpValue($input, '2019-01-01T19:30:59', new DateTimeImmutable('2019-01-01 18:30:59', new \DateTimeZone('UTC')));
});


test(function () {
	$input = new Inteve\Forms\DateTimeInput;

	FormAssert::setInvalidHttpValue($input, 'hello', ['Invalid datetime.']);
	FormAssert::setInvalidHttpValue($input, ':24', ['Invalid datetime.']);
	FormAssert::setInvalidHttpValue($input, '0:', ['Invalid datetime.']);
	FormAssert::setInvalidHttpValue($input, '31.2.2018', ['Invalid datetime.']);
	FormAssert::setInvalidHttpValue($input, '0.0.2018', ['Invalid datetime.']);
	FormAssert::setInvalidHttpValue($input, '0.0.00', ['Invalid datetime.']);
	FormAssert::setInvalidHttpValue($input, '2019-02-30T18:30:59', ['Invalid datetime.']);
	FormAssert::setInvalidHttpValue($input, '2019-01-30T25:30:59', ['Invalid datetime.']);
	FormAssert::setInvalidHttpValue($input, '2019-01-30T18:60:59', ['Invalid datetime.']);
	FormAssert::setInvalidHttpValue($input, '2019-01-30T18:30:60', ['Invalid datetime.']);

	$input = new Inteve\Forms\DateTimeInput(NULL, 'Custom invalid datetime.');
	FormAssert::setInvalidHttpValue($input, 'hello', ['Custom invalid datetime.']);
});
