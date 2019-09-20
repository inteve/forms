<?php

	namespace Inteve\Forms;

	use Nette;
	use Nette\Forms\Form;


	class TimeInput extends Nette\Forms\Controls\BaseControl
	{
		/** @var int|NULL */
		private $hour;

		/** @var int|NULL */
		private $minute;

		/** @var string */
		private $rawValue = '';


		public function __construct($caption = NULL, $errorMessage = 'Invalid time.')
		{
			parent::__construct($caption);
			$this->setRequired(FALSE);
			$this->addRule([__CLASS__, 'validateTime'], $errorMessage);
		}


		/**
		 * @param  \DateTime|NULL
		 * @return void
		 */
		public function setValue($value)
		{
			if ($value === NULL) {
				$this->hour = NULL;
				$this->minute = NULL;
				$this->rawValue = '';

			} elseif ($value instanceof \DateTimeInterface) {
				$this->hour = (int) $value->format('G');
				$this->minute = (int) $value->format('i');
				$this->rawValue = $value->format('G:i');

			} elseif ($value instanceof \DateInterval) {
				$this->hour = (int) $value->format('%h');
				$this->minute = (int) $value->format('%I');
				$this->rawValue = $value->format('%h:%I');

				if (!self::validateTime($this)) {
					$this->setValue(NULL);
					throw new InvalidValueException('Invalid time in DateInterval.');
				}

			} else {
				throw new InvalidArgumentException('Value of type ' . gettype($value) . ' is not supported.');
			}
		}


		/**
		 * @return \DateInterval|NULL
		 */
		public function getValue()
		{
			if (self::validateTime($this)) {
				return new \DateInterval('PT' . $this->hour . 'H' . $this->minute . 'M');
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
			$parts = explode(':', $value, 3);
			$this->hour = isset($parts[0]) ? Helpers::toInt($parts[0]) : NULL;
			$this->minute = isset($parts[1]) ? Helpers::toInt($parts[1]) : NULL;
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
		public static function validateTime(Nette\Forms\IControl $control)
		{
			if ($control->hour !== NULL && $control->minute !== NULL) {
				if ($control->hour < 0 || $control->hour > 23) {
					return FALSE;
				}

				if ($control->minute < 0 || $control->minute > 59) {
					return FALSE;
				}

				return TRUE;
			}

			return FALSE;
		}
	}
