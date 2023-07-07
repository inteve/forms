<?php

	declare(strict_types=1);

	namespace Inteve\Forms;

	use Inteve\Types\Decimal;
	use Nette;
	use Nette\Forms\Form;


	class DecimalInput extends Nette\Forms\Controls\BaseControl
	{
		/** @var Decimal|NULL */
		private $decimal;

		/** @var int|NULL */
		private $places;

		/** @var string */
		private $rawValue = '';

		/** @var bool */
		private $isValid = TRUE;


		public function __construct(?string $caption = NULL, ?int $places = NULL, string $errorMessage = 'Invalid value.')
		{
			parent::__construct($caption);
			$this->setRequired(FALSE);
			$this->addRule([__CLASS__, 'validateValue'], $errorMessage);

			$this->places = $places;
		}


		/**
		 * @param  Decimal|NULL $value
		 * @return static
		 */
		public function setValue($value)
		{
			if ($value === NULL) {
				$this->decimal = NULL;
				$this->rawValue = '';
				$this->isValid = TRUE;

			} elseif ($value instanceof Decimal) {
				$this->decimal = $value;
				$this->rawValue = str_replace('.', ',', $value->toString());
				$this->isValid = TRUE;

			} else {
				throw new InvalidArgumentException('Value of type ' . gettype($value) . ' is not supported.');
			}

			return $this;
		}


		public function getValue(): ?Decimal
		{
			return $this->decimal;
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
			$this->decimal = NULL;
			$this->isValid = FALSE;

			$value = str_replace([' ', ','], ['', '.'], $value);

			if ($value === '') {
				$this->decimal = NULL;
				$this->isValid = TRUE;

			} elseif (\Nette\Utils\Validators::isNumeric($value)) {
				$this->decimal = Decimal::from((float) $value, $this->places);
				$this->isValid = TRUE;
			}
		}


		public function getControl(): Nette\Utils\Html
		{
			$control = parent::getControl();
			assert($control instanceof Nette\Utils\Html);
			$control->value = $this->rawValue;
			$control->type = 'text';
			$control->style('width', 'auto'); // TODO
			return $control;
		}


		public static function validateValue(self $control): bool
		{
			return $control->isValid;
		}
	}
