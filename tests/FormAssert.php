<?php

	namespace Tests;

	use Nette;
	use Tester\Assert;


	class FormAssert
	{
		public function __construct()
		{
			throw new \RuntimeException('This is static class.');
		}


		public static function empty($input)
		{
			Assert::null($input->getValue());
			Assert::same('', self::getHtmlValue($input));
			Assert::false($input->isFilled());
		}


		public static function setEmptyValue($input, $value)
		{
			$input->setValue($value);
			self::empty($input);
		}


		public static function setValidValue($input, $value, $expectedValue, $expectedHtmlValue)
		{
			$input->setValue($value);
			Assert::equal($expectedValue, $input->getValue());
			Assert::same($expectedHtmlValue, self::getHtmlValue($input));
			Assert::true($input->isFilled());
		}


		public static function setInvalidValue($input, $value, $class, $message)
		{
			Assert::exception(function () use ($input, $value) {
				$input->setValue($value);
			}, $class, $message);
			Assert::same('', self::getHtmlValue($input));
			Assert::false($input->isFilled());
		}


		public static function setValidHttpValue($input, $httpValue, $expectedValue)
		{
			$result = self::loadHttpValue($input, $httpValue);
			Assert::equal($expectedValue, $result['value']);
			Assert::same([], $result['errors']);
		}


		public static function setInvalidHttpValue($input, $httpValue, array $expectedErrors)
		{
			$result = self::loadHttpValue($input, $httpValue);
			Assert::null($result['value']);
			Assert::same($expectedErrors, $result['errors']);
		}


		public static function errors($input, array $expectedErrors)
		{
			$form = new Nette\Forms\Form;
			$form['test'] = $input;
			$rules = $input->getRules();
			$rules->validate();
			$errors = $input->getErrors();
			unset($form['test']);
			return $errors;
		}


		public static function render($input, $expectedHtml)
		{
			$form = new Nette\Forms\Form;
			$form['test'] = $input;
			$html = $input->getControl();
			unset($form['test']);
			$html->{'data-nette-rules'} = NULL;
			Assert::same($expectedHtml, (string) $html);
		}


		private static function getHtmlValue($input)
		{
			$form = new Nette\Forms\Form;
			$form['test'] = $input;
			$value = $input->getControl()->value;
			unset($form['test']);
			return $value;
		}


		private static function loadHttpValue($input, $httpValue)
		{
			$_SERVER['REQUEST_METHOD'] = 'POST';
			$_POST = [
				'test' => $httpValue,
			];
			$_FILES = [];

			$form = new Nette\Forms\Form;
			$form['test'] = $input;
			$value = $input->getValue();
			$rules = $input->getRules();
			$rules->validate();
			$errors = $input->getErrors();
			unset($form['test']);
			$_POST = [];
			return [
				'value' => $value,
				'errors' => $errors,
			];
		}
	}
