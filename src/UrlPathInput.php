<?php

	namespace Inteve\Forms;

	use Inteve\Types\UrlPath;
	use Nette;
	use Nette\Forms\Form;


	class UrlPathInput extends Nette\Forms\Controls\BaseControl
	{
		/** @var UrlPath|NULL */
		private $path;

		/** @var string */
		private $rawValue = '';

		/** @var int|NULL */
		private $maxLength;


		/**
		 * @param string|NULL $caption
		 * @param int|NULL $maxLength
		 */
		public function __construct($caption = NULL, $maxLength = NULL)
		{
			parent::__construct($caption);
			$this->setRequired(FALSE);
			$this->maxLength = $maxLength;
		}


		/**
		 * @param  UrlPath|NULL $value
		 * @return static
		 */
		public function setValue($value)
		{
			if ($value === NULL) {
				$this->path = NULL;
				$this->rawValue = '';

			} elseif ($value instanceof UrlPath) {
				$this->path = $value;
				$this->rawValue = $value->toString();

			} else {
				throw new InvalidArgumentException('Value of type ' . gettype($value) . ' is not supported.');
			}

			return $this;
		}


		/**
		 * @return UrlPath|NULL
		 */
		public function getValue()
		{
			return $this->path;
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
			$value = is_string($value) ? $value : '';
			$this->path = $value !== '' ? UrlPath::fromString($value) : NULL;
			$this->rawValue = $this->path !== NULL ? $this->path->toString() : $value;
		}


		/**
		 * @return Nette\Utils\Html
		 */
		public function getControl()
		{
			$control = parent::getControl();
			assert($control instanceof Nette\Utils\Html);
			$control->type = 'text';
			$control->maxlength = $this->maxLength;
			$control->value = $this->rawValue;
			return $control;
		}
	}
