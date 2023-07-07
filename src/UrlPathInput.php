<?php

	declare(strict_types=1);

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


		public function __construct(?string $caption = NULL, ?int $maxLength = NULL)
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


		public function getValue(): ?UrlPath
		{
			return $this->path;
		}


		public function isFilled(): bool
		{
			return $this->rawValue !== '';
		}


		public function loadHttpData(): void
		{
			$value = $this->getHttpData(Form::DATA_LINE);
			$value = is_string($value) ? $value : '';
			$this->path = $value !== '' ? UrlPath::fromString($value) : NULL;
			$this->rawValue = $this->path !== NULL ? $this->path->toString() : $value;
		}


		public function getControl(): Nette\Utils\Html
		{
			$control = parent::getControl();
			assert($control instanceof Nette\Utils\Html);
			$control->type = 'text';
			$control->maxlength = $this->maxLength;
			$control->value = $this->rawValue;
			return $control;
		}
	}
