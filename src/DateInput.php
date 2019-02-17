<?php

	namespace Inteve\Forms;

	use Nette;
	use Nette\Forms\Form;


	class DateInput extends Nette\Forms\Controls\BaseControl
	{
		/** @var int|NULL */
		private $day;

		/** @var int|NULL */
		private $month;

		/** @var int|NULL */
		private $year;

		/** @var string */
		private $rawValue = '';


		public function __construct($caption = NULL, $errorMessage = 'Invalid date.')
		{
			parent::__construct($caption);
			$this->addRule([__CLASS__, 'validateDate'], $errorMessage);
		}


		/**
		 * @param  \DateTime|NULL
		 * @return void
		 */
		public function setValue($value)
		{
			if ($value === NULL) {
				$this->day = NULL;
				$this->month = NULL;
				$this->year = NULL;
				$this->rawValue = '';

			} elseif ($value instanceof \DateTimeInterface) {
				$this->day = (int) $value->format('j');
				$this->month = (int) $value->format('n');
				$this->year = (int) $value->format('Y');
				$this->rawValue = $value->format('j.n.Y');

			} else {
				throw new InvalidArgumentException('Value of type ' . gettype($value) . ' is not supported.');
			}
		}


		/**
		 * @return \DateTimeImmutable|NULL
		 */
		public function getValue()
		{
			if (self::validateDate($this)) {
				return new \DateTimeImmutable(
					sprintf('%4u-%02u-%02u 00:00:00', $this->year, $this->month, $this->day),
					new \DateTimeZone('UTC')
				);
			}

			return NULL;
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
			$parts = explode('.', $value, 3);
			$this->day = isset($parts[0]) ? Helpers::toInt($parts[0]) : NULL;
			$this->month = isset($parts[1]) ? Helpers::toInt($parts[1]) : NULL;
			$this->year = isset($parts[2]) ? Helpers::toInt($parts[2]) : NULL;
		}


		/**
		 * @return Nette\Utils\Html
		 */
		public function getControl()
		{
			$control = parent::getControl();
			$control->value = $this->rawValue;
			return $control;
		}


		/**
		 * @return bool
		 */
		public static function validateDate(Nette\Forms\IControl $control)
		{
			if ($control->year !== NULL && $control->month !== NULL && $control->day !== NULL) {
				return checkdate($control->month, $control->day, $control->year);
			}

			return FALSE;
		}
	}
