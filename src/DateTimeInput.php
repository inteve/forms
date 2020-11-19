<?php

	namespace Inteve\Forms;

	use Nette;
	use Nette\Forms\Form;
	use Nette\Utils\Strings;


	class DateTimeInput extends Nette\Forms\Controls\BaseControl
	{
		const W3C_DATETIME_FORMAT = 'Y-m-d\TH:i:s';

		/** @var \DateTimeImmutable|NULL */
		private $datetimeValue;

		/** @var string */
		private $rawValue = '';

		/** @var bool */
		private $isValid = TRUE;

		/** @var \DateTimeZone|NULL */
		private $timezone;

		/** @var string */
		private $htmlType = 'datetime-local';


		public function __construct($caption = NULL, $errorMessage = 'Invalid datetime.', $timezone = NULL)
		{
			parent::__construct($caption);
			$this->setRequired(FALSE);
			$this->addRule([__CLASS__, 'validateInput'], $errorMessage);
			$this->timezone = ($timezone instanceof \DateTimeZone || $timezone === NULL) ? $timezone : new \DateTimeZone($timezone);
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
		 * @param  \DateTimeInterface|NULL
		 * @return void
		 */
		public function setValue($value)
		{
			if ($value === NULL) {
				$this->datetimeValue = NULL;
				$this->rawValue = '';
				$this->isValid = TRUE;

			} elseif ($value instanceof \DateTimeInterface) {
				if ($value instanceof \DateTime) {
					$value = \DateTimeImmutable::createFromMutable($value);
				}

				$this->datetimeValue = $value;

				if ($this->timezone !== NULL) {
					$value = $value->setTimezone($this->timezone);
				}

				$this->rawValue = $value->format(self::W3C_DATETIME_FORMAT);
				$this->isValid = TRUE;

			} else {
				throw new InvalidArgumentException('Value of type ' . gettype($value) . ' is not supported.');
			}
		}


		/**
		 * @return \DateTimeImmutable|NULL
		 */
		public function getValue()
		{
			return $this->datetimeValue;
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
			$this->datetimeValue = NULL;
			$this->isValid = FALSE;

			$m = Strings::match($value, '#^(?P<yyyy>\d{4})-(?P<mm>\d{2})-(?P<dd>\d{2})T(?P<hh>\d{2}):(?P<ii>\d{2}):(?P<ss>\d{2})#');

			if (!is_array($m)) {
				$m = Strings::match($value, '#^(?P<yyyy>\d{4})-(?P<mm>\d{2})-(?P<dd>\d{2})T(?P<hh>\d{2}):(?P<ii>\d{2})#');

				if (is_array($m)) {
					$m['ss'] = '00';
				}
			}

			if (is_array($m)) {
				$yyyy = $m['yyyy'];
				$mm = $m['mm'];
				$dd = $m['dd'];
				$hh = $m['hh'];
				$ii = $m['ii'];
				$ss = $m['ss'];

				if (!checkdate($mm, $dd, $yyyy)) {
					return;
				}

				if (!($hh >= 0 && $hh < 24 && $ii >= 0 && $ii <= 59 && $ss >= 0 && $ss <= 59)) {
					return;
				}

				if ($this->timezone !== NULL) {
					$datetime = new \DateTimeImmutable("{$yyyy}-{$mm}-{$dd}T{$hh}:{$ii}:{$ss}", $this->timezone);
					$this->datetimeValue = $datetime->setTimezone(new \DateTimeZone('UTC'));

				} else {
					$this->datetimeValue = new \DateTimeImmutable("{$yyyy}-{$mm}-{$dd}T{$hh}:{$ii}:{$ss}", new \DateTimeZone('UTC'));
				}

				$this->isValid = TRUE;
			}
		}


		/**
		 * @return Nette\Utils\Html
		 */
		public function getControl()
		{
			$control = parent::getControl();
			$control->value = $this->rawValue;
			$control->type = $this->htmlType;
			return $control;
		}


		/**
		 * @return bool
		 */
		public static function validateInput(Nette\Forms\IControl $control)
		{
			return $control->isValid;
		}
	}
