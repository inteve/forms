<?php

	declare(strict_types=1);

	namespace Inteve\Forms;

	use Inteve\Types\HexColor;
	use Nette;
	use Nette\Forms\Form;


	class ColorInput extends Nette\Forms\Controls\BaseControl
	{
		/** @var HexColor|NULL */
		private $color;

		/** @var string */
		private $rawValue = '';


		public function __construct(?string $caption = NULL, string $errorMessage = 'Invalid value.')
		{
			parent::__construct($caption);
			$this->setRequired(FALSE);
			$this->addRule([__CLASS__, 'validateColor'], $errorMessage);
		}


		/**
		 * @param  HexColor|NULL $value
		 * @return static
		 */
		public function setValue($value)
		{
			if ($value === NULL) {
				$this->color = NULL;
				$this->rawValue = '';

			} elseif ($value instanceof HexColor) {
				$this->color = $value;
				$this->rawValue = $value->getCssValue();

			} else {
				throw new InvalidArgumentException('Value of type ' . gettype($value) . ' is not supported.');
			}

			return $this;
		}


		public function getValue(): ?HexColor
		{
			return $this->color;
		}


		public function isFilled(): bool
		{
			return $this->rawValue !== '';
		}


		public function loadHttpData(): void
		{
			$value = $this->getHttpData(Form::DATA_LINE);
			$value = is_string($value) ? $value : '';

			$this->rawValue = $value;
			$this->color = NULL;

			try {
				$this->color = $value !== '' ? HexColor::fromCssColor($value) : NULL;

			} catch (\CzProject\Assert\AssertException $e) {
				// nothing
			}
		}


		public function getControl(): Nette\Utils\Html
		{
			$control = parent::getControl();
			assert($control instanceof Nette\Utils\Html);
			$control->type = 'color';
			$control->maxlength = 7;
			$control->value = $this->rawValue;
			return $control;
		}


		public static function validateColor(self $control): bool
		{
			return $control->color !== NULL;
		}
	}
