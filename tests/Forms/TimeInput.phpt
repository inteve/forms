<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$input = new Inteve\Forms\TimeInput;
	Assert::null($input->getValue());
	Assert::same('', getHtmlValue($input));
	Assert::false($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\TimeInput;
	$input->setValue(NULL);
	Assert::null($input->getValue());
	Assert::same('', getHtmlValue($input));
	Assert::false($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\TimeInput;
	$input->setValue(new \DateTime('2019-01-01 18:00:00', new \DateTimeZone('UTC')));
	Assert::equal(new \DateInterval('PT18H0M'), $input->getValue());
	Assert::same('18:00', getHtmlValue($input));
	Assert::true($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\TimeInput;
	$input->setValue(new \DateTimeImmutable('2019-01-01 18:00:00', new \DateTimeZone('UTC')));
	Assert::equal(new \DateInterval('PT18H0M'), $input->getValue());
	Assert::same('18:00', getHtmlValue($input));
	Assert::true($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\TimeInput;
	$time = new \DateInterval('PT18H0M');
	$input->setValue($time);
	Assert::equal($time, $input->getValue());
	Assert::same('18:00', getHtmlValue($input));
	Assert::true($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\TimeInput;
	$time = new \DateInterval('PT1H0M');
	$input->setValue($time);
	Assert::equal($time, $input->getValue());
	Assert::same('1:00', getHtmlValue($input));
	Assert::true($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\TimeInput;

	Assert::exception(function () use ($input) {
		$input->setValue(new \DateInterval('PT36H'));
	}, Inteve\Forms\InvalidValueException::class, 'Invalid time in DateInterval.');
	Assert::same('', getHtmlValue($input));
	Assert::false($input->isFilled());

	Assert::exception(function () use ($input) {
		$input->setValue(TRUE);
	}, Inteve\Forms\InvalidArgumentException::class, 'Value of type boolean is not supported.');
	Assert::same('', getHtmlValue($input));
	Assert::false($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\TimeInput;

	Assert::null(getPostValue($input, ''));
	Assert::null(getPostValue($input, '0:60'));
	Assert::null(getPostValue($input, '24:00'));

	Assert::equal(new DateInterval('PT0H0M'), getPostValue($input, '00:00'));
	Assert::equal(new DateInterval('PT18H'), getPostValue($input, '18:00'));
});
