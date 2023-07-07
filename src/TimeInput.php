<?php

	declare(strict_types=1);

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

		/** @var string */
		private $htmlType = 'time';


		/**
		 * @param string|NULL $caption
		 * @param string $errorMessage
		 */
		public function __construct(?string $caption = NULL, string $errorMessage = 'Invalid time.')
		{
			parent::__construct($caption);
			$this->setRequired(FALSE);
			$this->addRule([__CLASS__, 'validateTime'], $errorMessage);
		}


		/**
		 * @return static
		 */
		public function showAsTextInput()
		{
			$this->htmlType = 'text';
			return $this;
		}


		/**
		 * @param  \DateTimeInterface|\DateInterval|NULL $value
		 * @return static
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
				$this->rawValue = $value->format($this->htmlType === 'text' ? 'G:i' : 'H:i:00');

			} elseif ($value instanceof \DateInterval) {
				$this->hour = (int) $value->format('%h');
				$this->minute = (int) $value->format('%I');
				$this->rawValue = $value->format($this->htmlType === 'text' ? '%h:%I' : '%H:%I:00');

				if (!self::validateTime($this)) {
					$this->setValue(NULL);
					throw new InvalidValueException('Invalid time in DateInterval.');
				}

			} else {
				throw new InvalidArgumentException('Value of type ' . gettype($value) . ' is not supported.');
			}

			return $this;
		}


		public function getValue(): ?\DateInterval
		{
			if (self::validateTime($this)) {
				return new \DateInterval('PT' . $this->hour . 'H' . $this->minute . 'M');
			}

			return NULL;
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
			$parts = explode(':', $value, 3);
			$this->hour = isset($parts[0]) ? Helpers::toInt($parts[0]) : NULL;
			$this->minute = isset($parts[1]) ? Helpers::toInt($parts[1]) : NULL;
		}


		public function getControl(): Nette\Utils\Html
		{
			$control = parent::getControl();
			assert($control instanceof Nette\Utils\Html);
			$control->type = $this->htmlType;
			$control->value = $this->rawValue;
			return $control;
		}


		public static function validateTime(self $control): bool
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
