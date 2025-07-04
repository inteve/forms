<?php

	declare(strict_types=1);

	namespace Inteve\Forms;

	use Nette;


	class SelectBox extends Nette\Forms\Controls\SelectBox
	{
		/** @var callable(string $value): array<mixed>|NULL */
		private $itemsProvider;


		/**
		 * @param array<mixed>|null $items
		 */
		public function __construct(?string $label = NULL, ?array $items = NULL)
		{
			parent::__construct($label, $items);
			$this->control->appendAttribute('class', 'input--selectbox');
		}


		/**
		 * @param  callable(string $value): array<mixed> $itemsProvider
		 * @return static
		 */
		public function setRemoteSource(string $url, callable $itemsProvider)
		{
			$this->setHtmlAttribute('data-source-url', $url);
			$this->itemsProvider = $itemsProvider;
			return $this;
		}


		/**
		 * @return static
		 */
		public function enableCreate(string $url)
		{
			$this->setHtmlAttribute('data-create-url', $url);
			return $this;
		}


		public function loadHttpData(): void
		{
			parent::loadHttpData();
			$value = is_string($this->value) ? $this->value : '';

			if ($this->itemsProvider !== NULL && $value !== '') {
				$items = call_user_func($this->itemsProvider, $value);
				$this->setItems($items);
			}
		}
	}
