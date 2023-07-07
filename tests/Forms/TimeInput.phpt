<?php

declare(strict_types=1);

use Tester\Assert;
use Tests\FormAssert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$input = new Inteve\Forms\TimeInput;
	FormAssert::blank($input);
	FormAssert::render($input, '<input type="time" name="test" id="frm-test" value="">');
});


test(function () {
	$input = new Inteve\Forms\TimeInput;
	$input->showAsTextInput();
	FormAssert::render($input, '<input type="text" name="test" id="frm-test" value="">');
});


test(function () {
	$input = new Inteve\Forms\TimeInput;
	FormAssert::errors($input, []);

	$input = new Inteve\Forms\TimeInput(NULL, 'Custom error message');
	FormAssert::errors($input, []);

	$input = new Inteve\Forms\TimeInput;
	$input->setRequired();
	FormAssert::errors($input, ['This field is required.']);

	$input = new Inteve\Forms\TimeInput(NULL, 'Custom error message');
	$input->setRequired();
	FormAssert::errors($input, ['This field is required.']);
});


test(function () {
	$input = new Inteve\Forms\TimeInput;
	FormAssert::setEmptyValue($input, NULL);
});


test(function () {
	$input = new Inteve\Forms\TimeInput;

	FormAssert::setValidValue(
		$input,
		new \DateTime('2019-01-01 18:00:00', new \DateTimeZone('UTC')),
		new \DateInterval('PT18H0M'),
		'18:00:00'
	);

	FormAssert::setValidValue(
		$input,
		new \DateTime('2019-01-01 18:30:45', new \DateTimeZone('UTC')),
		new \DateInterval('PT18H30M'),
		'18:30:00'
	);

	FormAssert::setValidValue(
		$input,
		new \DateTime('2019-01-01 8:00:00', new \DateTimeZone('UTC')),
		new \DateInterval('PT8H0M'),
		'08:00:00'
	);

	$input = new Inteve\Forms\TimeInput;
	$input->showAsTextInput();

	FormAssert::setValidValue(
		$input,
		new \DateTime('2019-01-01 8:00:00', new \DateTimeZone('UTC')),
		new \DateInterval('PT8H0M'),
		'8:00'
	);
});


test(function () {
	$input = new Inteve\Forms\TimeInput;

	FormAssert::setValidValue(
		$input,
		new \DateTimeImmutable('2019-01-01 18:00:00', new \DateTimeZone('UTC')),
		new \DateInterval('PT18H0M'),
		'18:00:00'
	);

	FormAssert::setValidValue(
		$input,
		new \DateTimeImmutable('2019-01-01 18:30:45', new \DateTimeZone('UTC')),
		new \DateInterval('PT18H30M'),
		'18:30:00'
	);
});


test(function () {
	$input = new Inteve\Forms\TimeInput;

	FormAssert::setValidValue(
		$input,
		$time = new \DateInterval('PT18H0M'),
		$time,
		'18:00:00'
	);

	FormAssert::setValidValue(
		$input,
		new \DateInterval('PT18H30M45S'),
		new \DateInterval('PT18H30M'),
		'18:30:00'
	);
});


test(function () {
	$input = new Inteve\Forms\TimeInput;

	FormAssert::setValidValue(
		$input,
		$time = new \DateInterval('PT1H0M'),
		$time,
		'01:00:00'
	);
});


test(function () {
	$input = new Inteve\Forms\TimeInput;

	FormAssert::setInvalidValue(
		$input,
		new \DateInterval('PT36H'),
		Inteve\Forms\InvalidValueException::class,
		'Invalid time in DateInterval.'
	);

	FormAssert::setInvalidValue(
		$input,
		TRUE,
		Inteve\Forms\InvalidArgumentException::class,
		'Value of type boolean is not supported.'
	);
});


test(function () {
	$input = new Inteve\Forms\TimeInput;

	FormAssert::setValidHttpValue($input, '', NULL);
	FormAssert::setValidHttpValue($input, '00:00', new DateInterval('PT0H0M'));
	FormAssert::setValidHttpValue($input, '00:00:00', new DateInterval('PT0H0M'));
	FormAssert::setValidHttpValue($input, '18:00', new DateInterval('PT18H'));
	FormAssert::setValidHttpValue($input, '18:00:30', new DateInterval('PT18H'));
});


test(function () {
	$input = new Inteve\Forms\TimeInput;

	FormAssert::setInvalidHttpValue($input, '0:60', ['Invalid time.']);
	FormAssert::setInvalidHttpValue($input, '24:00', ['Invalid time.']);
	FormAssert::setInvalidHttpValue($input, 'invalid', ['Invalid time.']);

	$input = new Inteve\Forms\TimeInput(NULL, 'Custom invalid time.');

	FormAssert::setInvalidHttpValue($input, '0:60', ['Custom invalid time.']);
	FormAssert::setInvalidHttpValue($input, '24:00', ['Custom invalid time.']);
	FormAssert::setInvalidHttpValue($input, 'invalid', ['Custom invalid time.']);
});
