<?php

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


		/**
		 * @param string|NULL $caption
		 * @param int|NULL $places
		 * @param string $errorMessage
		 */
		public function __construct($caption = NULL, $places = NULL, $errorMessage = 'Invalid value.2')
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


		/**
		 * @return Decimal|NULL
		 */
		public function getValue()
		{
			return $this->decimal;
		}


		/**
		 * @return bool
		 */
		public function isFilled()
		{
			return $this->rawValue !== '';
		}


		/**
		 * @return void
		 */
		public function loadHttpData()
		{
			$value = $this->getHttpData(Form::DATA_LINE);
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


		/**
		 * @return Nette\Utils\Html
		 */
		public function getControl()
		{
			$control = parent::getControl();
			assert($control instanceof Nette\Utils\Html);
			$control->value = $this->rawValue;
			$control->type = 'text';
			$control->style('width', 'auto'); // TODO
			return $control;
		}


		/**
		 * @return bool
		 */
		public static function validateValue(self $control)
		{
			return $control->isValid;
		}
	}
