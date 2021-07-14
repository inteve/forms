<?php

	namespace Inteve\Forms;

	use Inteve\Types\UrlSlug;
	use Nette;
	use Nette\Forms\Form;


	class UrlSlugInput extends Nette\Forms\Controls\BaseControl
	{
		/** @var UrlSlug|NULL */
		private $slug;

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
		 * @param  UrlSlug|NULL $value
		 * @return static
		 */
		public function setValue($value)
		{
			if ($value === NULL) {
				$this->slug = NULL;
				$this->rawValue = '';

			} elseif ($value instanceof UrlSlug) {
				$this->slug = $value;
				$this->rawValue = $value->toString();

			} else {
				throw new InvalidArgumentException('Value of type ' . gettype($value) . ' is not supported.');
			}

			return $this;
		}


		/**
		 * @return UrlSlug|NULL
		 */
		public function getValue()
		{
			return $this->slug;
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
			$this->slug = $value !== '' ? UrlSlug::fromString($value) : NULL;
			$this->rawValue = $this->slug !== NULL ? $this->slug->toString() : $value;
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
