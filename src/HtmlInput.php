<?php

	declare(strict_types=1);

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


		public function __construct(?string $caption = NULL, ?int $rows = NULL)
		{
			parent::__construct($caption);
			$this->setRequired(FALSE);
			$this->setNullable();
			$this->setHtmlAttribute('rows', $rows);
		}


		/**
		 * @return self
		 */
		public function setHtmlClass(string $htmlClass)
		{
			$this->htmlClass = $htmlClass;
			return $this;
		}


		/**
		 * @return self
		 */
		public function setFileBrowserUrl(?string $fileBrowserUrl)
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


		public function getValue(): ?Html
		{
			$value = parent::getValue();
			return is_string($value) ? new Html($value) : NULL;
		}


		public function loadHttpData(): void
		{
			$value = $this->getHttpData(Form::DATA_TEXT);
			$value = is_string($value) ? $value : '';
			parent::setValue($value);
		}


		public function getControl(): Nette\Utils\Html
		{
			return parent::getControl()
				->appendAttribute('class', $this->htmlClass)
				->data('file-browser', $this->fileBrowserUrl);
		}
	}
