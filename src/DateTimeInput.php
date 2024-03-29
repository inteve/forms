<?php

	declare(strict_types=1);

	namespace Inteve\Forms;

	use Nette;
	use Nette\Forms\Form;
	use Nette\Utils\Strings;
	use Nette\Utils\Validators;


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


		/**
		 * @param \DateTimezone|string|NULL $timezone
		 */
		public function __construct(?string $caption = NULL, string $errorMessage = 'Invalid datetime.', $timezone = NULL)
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
		 * @param  \DateTimeImmutable|\DateTime|NULL $value
		 * @return static
		 */
		public function setValue($value)
		{
			if ($value === NULL) {
				$this->datetimeValue = NULL;
				$this->rawValue = '';
				$this->isValid = TRUE;

			} elseif (($value instanceof \DateTime) || ($value instanceof \DateTimeImmutable)) {
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

			return $this;
		}


		public function getValue(): ?\DateTimeImmutable
		{
			return $this->datetimeValue;
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
				$yyyy = Validators::isNumericInt($m['yyyy']) ? ((int) $m['yyyy']) : NULL;
				$mm = Validators::isNumericInt($m['mm']) ? ((int) $m['mm']) : NULL;
				$dd = Validators::isNumericInt($m['dd']) ? ((int) $m['dd']) : NULL;
				$hh = Validators::isNumericInt($m['hh']) ? ((int) $m['hh']) : NULL;
				$ii = Validators::isNumericInt($m['ii']) ? ((int) $m['ii']) : NULL;
				$ss = Validators::isNumericInt($m['ss']) ? ((int) $m['ss']) : NULL;

				if (!isset($yyyy, $mm, $dd, $hh, $ii, $ss)) {
					return;
				}

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


		public function getControl(): Nette\Utils\Html
		{
			$control = parent::getControl();
			assert($control instanceof Nette\Utils\Html);
			$control->value = $this->rawValue;
			$control->type = $this->htmlType;
			return $control;
		}


		public static function validateInput(self $control): bool
		{
			return $control->isValid;
		}
	}
