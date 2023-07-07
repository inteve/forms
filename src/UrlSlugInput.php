<?php

	declare(strict_types=1);

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


		public function __construct(?string $caption = NULL, ?int $maxLength = NULL)
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


		public function getValue(): ?UrlSlug
		{
			return $this->slug;
		}


		public function isFilled(): bool
		{
			return $this->rawValue !== '';
		}


		public function loadHttpData(): void
		{
			$value = $this->getHttpData(Form::DATA_LINE);
			$value = is_string($value) ? $value : '';
			$this->slug = $value !== '' ? UrlSlug::fromString($value) : NULL;
			$this->rawValue = $this->slug !== NULL ? $this->slug->toString() : $value;
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
