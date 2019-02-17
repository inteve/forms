<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$input = new Inteve\Forms\DateInput;
	Assert::null($input->getValue());
	Assert::same('', getHtmlValue($input));
	Assert::false($input->isFilled());
	Assert::same('<input name="test" id="frm-test" value="">', toHtml($input, TRUE));
});


test(function () {
	$input = new Inteve\Forms\DateInput;
	$input->setValue(NULL);
	Assert::null($input->getValue());
	Assert::same('', getHtmlValue($input));
	Assert::false($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\DateInput;
	$input->setValue(new \DateTime('2019-01-01 18:00:00', new \DateTimeZone('UTC')));
	Assert::equal(new \DateTimeImmutable('2019-01-01 00:00:00', new \DateTimeZone('UTC')), $input->getValue());
	Assert::same('1.1.2019', getHtmlValue($input));
	Assert::true($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\DateInput;
	$input->setValue(new \DateTimeImmutable('2019-01-01 18:00:00', new \DateTimeZone('UTC')));
	Assert::equal(new \DateTimeImmutable('2019-01-01 00:00:00', new \DateTimeZone('UTC')), $input->getValue());
	Assert::same('1.1.2019', getHtmlValue($input));
	Assert::true($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\DateInput;
	$date = new \DateTimeImmutable('2019-01-01 18:00:00', new \DateTimeZone('UTC'));
	$input->setValue($date);
	Assert::equal(new \DateTimeImmutable('2019-01-01 00:00:00', new \DateTimeZone('UTC')), $input->getValue());
	Assert::same('1.1.2019', getHtmlValue($input));
	Assert::true($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\DateInput;

	Assert::exception(function () use ($input) {
		$input->setValue(TRUE);
	}, Inteve\Forms\InvalidArgumentException::class, 'Value of type boolean is not supported.');
	Assert::same('', getHtmlValue($input));
	Assert::false($input->isFilled());
});


test(function () {
	$input = new Inteve\Forms\DateInput;

	Assert::null(getPostValue($input, ''));
	Assert::null(getPostValue($input, 'hello'));
	Assert::null(getPostValue($input, ':24'));
	Assert::null(getPostValue($input, '0:'));
	Assert::null(getPostValue($input, '31.2.2018'));
	Assert::null(getPostValue($input, '0.0.2018'));
	Assert::null(getPostValue($input, '0.0.00'));

	Assert::equal(new DateTimeImmutable('2019-01-01 00:00:00', new \DateTimeZone('UTC')), getPostValue($input, '1.01. 2019'));
	Assert::equal(new DateTimeImmutable('2019-12-12', new \DateTimeZone('UTC')), getPostValue($input, '12. 12. 2019'));
});
