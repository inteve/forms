<?php

	namespace Inteve\Forms;

	use Inteve\Types\Html;
	use Nette;
	use Nette\Forms\Form;


	class HtmlInput extends Nette\Forms\Controls\TextArea
	{
		/** @var string */
		private $htmlClass = 'form__control--html';

		/** @var string|NULL */
		private $fileBrowserUrl;


		/**
		 * @param string|NULL $caption
		 * @param int|NULL $rows
		 */
		public function __construct($caption = NULL, $rows = NULL)
		{
			parent::__construct($caption);
			$this->setRequired(FALSE);
			$this->setNullable();
			$this->setHtmlAttribute('rows', $rows);
		}


		/**
		 * @param  string $htmlClass
		 * @return self
		 */
		public function setHtmlClass($htmlClass)
		{
			$this->htmlClass = $htmlClass;
			return $this;
		}


		/**
		 * @param  string|NULL $fileBrowserUrl
		 * @return self
		 */
		public function setFileBrowserUrl($fileBrowserUrl)
		{
			$this->fileBrowserUrl = $fileBrowserUrl;
			return $this;
		}


		/**
		 * @param  Html|NULL $value
		 * @return static
		 */
		public function setValue($value)
		{
			if ($value === NULL) {
				parent::setValue(NULL);

			} elseif ($value instanceof Html) {
				parent::setValue($value->getHtml());

			} else {
				throw new InvalidArgumentException('Value of type ' . gettype($value) . ' is not supported.');
			}

			return $this;
		}


		/**
		 * @return Html|NULL
		 */
		public function getValue()
		{
			$value = parent::getValue();
			return is_string($value) ? new Html($value) : NULL;
		}


		/**
		 * Loads HTTP data.
		 * @return void
		 */
		public function loadHttpData()
		{
			$value = $this->getHttpData(Form::DATA_TEXT);
			$value = is_string($value) ? $value : '';
			parent::setValue($value);
		}


		/**
		 * Generates control's HTML element.
		 * @return Nette\Utils\Html
		 */
		public function getControl()
		{
			return parent::getControl()
				->appendAttribute('class', $this->htmlClass)
				->data('file-browser', $this->fileBrowserUrl);
		}
	}
